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

        if ($articles->total() === 0) {
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
        $postArticles = $post->articles();
        if ($type === 'latest') {
            $postArticles->latest();
        } else {
            $postArticles->where('type', $type);
        }
        return $postArticles->paginate($perPage, Article::defaultAttributes());
    }

    public function getType()
    {
        $type = request('type', 'latest');
        if ($type === 'top-10') {
            $type = 1;
        } elseif ($type === 'videos') {
            $type = 2;
        } elseif ($type === 'books') {
            $type = 3;
        } elseif ($type === 'interviews') {
            $type = 4;
        } elseif ($type === 'videos') {
            $type = 2;
        }
        return $type;
    }
}
