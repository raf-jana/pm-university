<?php

use Faker\Generator as Faker;
use App\Models\Article;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'post_id' => function () {
            return factory(\App\Models\Post::class)->create()->id;
        },
        'type' => array_random(
            [
                Article::VIDEOS,
                Article::BOOKS,
                Article::INTERVIES,
                Article::TOOLS,
                Article::TOP_TEN
            ]
        ),
        'source_url' => $faker->url,
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'user_id' => function () {
            return factory(\App\Models\User::class)->create()->id;
        },
        'last_user_id' => function (array $post) {
            return \App\Models\User::find($post['user_id'])->id;
        },
        'published_at' => now()
    ];
});
