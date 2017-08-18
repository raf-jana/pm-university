<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Placement;
use App\Models\HallsOfKnowledge;

class HomeController extends Controller
{
    public function __invoke()
    {
        $postsAttributes = Post::defaultAttributes();
        $bachelorePosts = Post::published()->type(Post::BACHELORE)->get($postsAttributes);
        $masterPosts = Post::published()->type(Post::MASTER)->get($postsAttributes);
        $specializationPosts = Post::published()
            ->type(Post::SPECIALIZATION)
            ->get($postsAttributes);
        $placements = Post::published()
            ->type(Post::PLACEMENTS)
            ->get($postsAttributes);
        $hoks = Post::published()
            ->type(Post::HOK)
            ->get($postsAttributes)->take(3);
        return view('posts.index', compact(
            'bachelorePosts',
            'masterPosts',
            'specializationPosts',
            'placements',
            'hoks'
        ));
    }
}