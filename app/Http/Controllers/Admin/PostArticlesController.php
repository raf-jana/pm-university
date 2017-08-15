<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Filters\ArticleFilters;
use App\Http\Controllers\Controller;

class PostArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param int $id
     * @param ArticleFilters $filters
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id, ArticleFilters $filters)
    {
        $articles = $this->getArticles($id, $filters);
        $totalArticles = $articles->total();
        $articles->withPath(request()->getUri());
        return view('admin.post_articles.index', compact('id', 'articles', 'totalArticles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        return view('admin.post_articles.create', compact('id'));
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
        Article::create($data);
        $notification = $this->notification('Saved successfully', 'success');
        return redirect(route('posts.articles', ['id' => $data['post_id']]))->with($notification);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $postId
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($postId, $id)
    {
        $article = Article::find($id);
        return view('admin.post_articles.edit', compact('postId', 'id', 'article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param int $postId
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $postId, $id)
    {
        $article = Article::find($id);
        $data = $this->_validateInput();
        $article->update($data);
        $notification = $this->notification('Saved successfully', 'success');
        return redirect(route('posts.articles', ['id' => $data['post_id']]))->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::find($id);
        $article->unpublish();
        $notification = $this->notification('Deleted successfully', 'success');
        return redirect(route('posts.articles', ['id' => $article->post_id]))->with($notification);
    }

    public function bulkAction(Request $request)
    {
        $action = $request->get('action_type');
        $ids = $request->get('article_ids');
        $notification = $this->notification(ucfirst($action) . 'ed successfully', 'success');
        foreach ($ids as $id) {
            $post = Article::find($id);
            $method = $action === 'publish' ? 'publish' : 'unpublish';
            $post->{$method}();
        }
        return redirect(route('posts.articles', ['id' => $request->get('post_id')]))->with($notification);
    }

    /**
     * Fetch all relevant threads.
     *
     * @param int $postId
     * @param ArticleFilters $filters
     * @return mixed
     */
    protected function getArticles($postId, ArticleFilters $filters)
    {
        return Article::where('post_id', $postId)
            ->recent()
            ->filter($filters)
            ->paginate(15, Article::defaultAttributes(['post_id', 'type', 'created_at']));
    }

    private function _validateInput()
    {
        $data = $this->validate(request(), [
            'post_id' => 'required|exists:posts,id',
            'type' => 'required',
            'title' => 'required|max:150',
            'picture' => 'sometimes|image|mimes:jpeg,png,jpg,gif',
            'video_url' => 'required_if:type,videos',
            'source_url' => 'required|url',
            'description' => 'sometimes'
        ]);
        if (request()->hasFile('picture'))
            $data['picture'] = request()->file('picture')->store('images', 'public');

        $filters = [
            'title' => 'strip_tags|trim|capitalize_first_letter',
            'note_description' => 'trim|capitalize_first_letter',
            'source_url' => 'strip_tags|trim|lowercase',
            'video_url' => 'strip_tags|trim|lowercase'

        ];
        return \Sanitizer::make($data, $filters)->sanitize();
    }
}
