<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'type' => \App\Models\Post::BACHELORE,
        'slug' => $faker->slug,
        'note_title' => $faker->sentence,
        'note_description' => $faker->paragraph,
        'user_id' => function () {
            return factory(\App\Models\User::class)->create()->id;
        },
        'last_user_id' => function (array $post) {
            return \App\Models\User::find($post['user_id'])->id;
        },
        'published_at' => now()
    ];
});
