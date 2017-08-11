<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Placement::class, function (Faker $faker) {
    $picture = random_pic(public_path('images/placements'));
    return [
        'title' => $faker->sentence,
        'summary' => $faker->paragraph,
        'picture' => $picture ? basename($picture) : null,
        'link' => $faker->url,
        'published_at' => now()
    ];
});
