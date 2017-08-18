<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Article;

class PostArticlesController extends AjaxController
{
    public function __invoke($id)
    {
        $type = request('type', 'latest');
        $articles = $this->getArticles($id, $type);
        if (($type === 'top-10' && request('page') > 1) OR $articles->total() === 0) {
            return $this->respondNotFound('No records found');
        }

        $formattedArticles = [];
        foreach ($articles as $key => $article) {
            $formattedArticles[$key] = $article->toArray();
        }
        return $this->respondWithPagination($articles, $formattedArticles);
    }

    public function getArticles($postId, $type)
    {
        $post = Post::find($postId);
        $perPage = ( int )request('perPage', 5);
        return $post->articles()
            ->orderBy('sequence', 'desc')
            ->where('type', $type)
            ->paginate($perPage, Article::defaultAttributes());
    }
}
