<?php

use Faker\Generator as Faker;

$factory->define(App\Models\ProductMedia::class, function (Faker $faker) {
    $faker->addProvider(new \Faker\Provider\Youtube($faker));

    return [
        'product_id' => 322,
        'type' => $type = rand(0,1) ? 'feature' : 'video',
        'img' => $faker->image($dir = 'storage/app/public/uploads', $width = 640, $height = 480),
        'yt' => $faker->youtubeUri(),
        'title' => $faker->text(rand(50, 191)),
        'description' => $faker->text(rand(100, 200)),
        'slider' => rand(0,1)
    ];
});
