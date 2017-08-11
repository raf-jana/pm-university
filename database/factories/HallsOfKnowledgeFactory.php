<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\HallsOfKnowledge::class, function (Faker $faker) {
    $picture = random_pic(public_path('images/hok'));
    return [
        'title' => $faker->sentence,
        'picture' => $picture ? basename($picture) : null,
        'link' => $faker->url,
        'published_at' => now()
    ];
});
