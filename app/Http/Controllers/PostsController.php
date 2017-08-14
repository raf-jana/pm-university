<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostsController extends Controller
{
    public function __invoke(Post $post)
    {
        $previousPost = Post::previousRecord($post);
        $nextPost = Post::nextRecord($post);
        return view('posts.show', compact('post', 'previousPost', 'nextPost'));
    }
}