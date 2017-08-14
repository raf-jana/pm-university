<?php

namespace App\Http\Controllers;

use App\Models\HallsOfKnowledge;
use App\Models\Placement;
use App\Models\Post;

class HomeController extends Controller
{
    public function __invoke()
    {
        $postsAttributes = Post::defaultAttributes();
        $bachelorePosts = Post::published()->filterByType(Post::BACHELORE)->get($postsAttributes);
        $masterPosts = Post::published()->filterByType(Post::MASTER)->get($postsAttributes);
        $specializationPosts = Post::published()->filterByType(Post::SPECIALIZATION)->get($postsAttributes);
        $placements = Placement::published()->get(Placement::defaultAttributes());
        $hoks = HallsOfKnowledge::published()->get(HallsOfKnowledge::defaultAttributes());
        return view('posts.index', compact(
            'bachelorePosts',
            'masterPosts',
            'specializationPosts',
            'placements',
            'hoks'
        ));
    }
}