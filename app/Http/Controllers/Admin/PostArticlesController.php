<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\Post;
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
        $post = $totalArticles > 0
            ? $articles->first()->post
            : Post::find($id, Post::defaultAttributes());

        $articles->withPath(request()->getUri());
        return view('admin.post_articles.index', compact('post', 'articles', 'totalArticles'));
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
        $article = Article::find($id, $this->_formAttributes());
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
        $article = Article::find($id, $this->_formAttributes());
        $data = $this->_validateInput();
        $article->update($data);
        $notification = $this->notification('Saved successfully', 'success');
        return redirect(route('posts.articles', ['id' => $postId]) . '?type=' . $article->type)
            ->with($notification);
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
        $article->delete();
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
            $post->{$action}();
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
            ->paginate(15, Article::defaultAttributes(['post_id', 'type', 'sequence', 'created_at']));
    }

    private function _validateInput()
    {
        $data = $this->validate(request(), [
            'post_id' => 'required|exists:posts,id',
            'type' => 'required',
            'title' => 'required|max:150',
            'picture' => 'sometimes|image|mimes:jpeg,png,jpg,gif',
            'video_url' => 'sometimes',
            'source_url' => 'required|url',
            'description' => 'sometimes',
            'sequence' => 'required',
            'author_name' => 'sometimes',
            'author_organization' => 'sometimes',
            'author_designation' => 'sometimes',
            'author_location' => 'sometimes'
        ]);
        if (request()->hasFile('picture'))
            $data['picture'] = request()->file('picture')->store('images', 'public');

        $filters = $this->_sanitizeFilters();
        return \Sanitizer::make($data, $filters)->sanitize();
    }

    protected function _sanitizeFilters()
    {
        return [
            'title' => 'strip_tags|trim|capitalize_first_letter',
            'description' => 'trim|capitalize_first_letter',
            'source_url' => 'strip_tags|trim|lowercase',
            'video_url' => 'strip_tags|trim|lowercase',
            'author_name' => 'strip_tags|trim|titleize',
            'author_organization' => 'strip_tags|trim|titleize',
            'author_designation' => 'strip_tags|trim|titleize',
            'author_location' => 'strip_tags|trim|titleize'

        ];
    }

    protected function _formAttributes()
    {
        return Article::defaultAttributes(
            ['type', 'author_name', 'author_organization', 'author_designation',
                'author_location', 'sequence'
            ]);
    }
}
