<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Filters\PostFilters;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param PostFilters $filters
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, PostFilters $filters)
    {
        $posts = $this->getPosts($filters);
        $totalPosts = $posts->total();
        $posts->withPath(request()->getUri());
        $latestPost = Post::latest()->first();
        $oldestPost = Post::oldest()->first();
        return view('admin.posts.index', compact('posts', 'totalPosts', 'latestPost', 'oldestPost'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->_validateInput();
        $data['slug'] = $data['title'];
        Post::create($data);
        $notification = $this->notification('Saved successfully', 'success');
        return redirect(route('posts'))->with($notification);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $data = $this->_validateInput();
        $data['slug'] = $data['title'];
        $post->update($data);
        $notification = $this->notification('Saved successfully', 'success');
        return redirect(route('posts'))->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        $post->articles->each->delete();
        $notification = $this->notification('Deleted successfully', 'success');
        return redirect(route('posts'))->with($notification);
    }

    public function bulkAction(Request $request)
    {
        $action = $request->get('action_type');
        $ids = $request->get('post_ids');
        $notification = $this->notification(ucfirst($action) . 'ed successfully', 'success');

        foreach ($ids as $id) {
            $post = Post::find($id);
            $post->{$action}();
            if ($action !== 'publish') {
                $post->articles->each->{$action}();
            }
        }
        return redirect(route('posts'))->with($notification);
    }

    /**
     * Fetch all relevant threads.
     *
     * @param PostFilters $filters
     * @return mixed
     */
    protected function getPosts(PostFilters $filters)
    {
        $posts = Post::recent()->filter($filters);
        return $posts->withCount(
            [
                'topTenArticles',
                'videosArticles',
                'interviewsArticles',
                'booksArticles',
                'toolsArticles'
            ])
            ->paginate(15, Post::defaultAttributes(['created_at', 'published_at']));
    }

    private function _validateInput()
    {
        $data = $this->validate(request(), [
            'type' => 'required',
            'title' => 'required|max:150',
            'summary' => 'sometimes',
            'picture' => 'sometimes|image|mimes:jpeg,png,jpg,gif',
            'note_title' => 'sometimes',
            'note_description' => 'sometimes'
        ]);
        if (request()->hasFile('picture'))
            $data['picture'] = request()->file('picture')->store('images', 'public');

        $filters = [
            'title' => 'strip_tags|trim|capitalize_first_letter',
            'summary' => 'strip_tags|trim|capitalize_first_letter',
            'note_title' => 'strip_tags|trim|capitalize_first_letter',
            'note_description' => 'trim|capitalize_first_letter'
        ];
        return \Sanitizer::make($data, $filters)->sanitize();
    }
}
