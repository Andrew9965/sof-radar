<?php

use Faker\Generator as Faker;

$factory->define(App\Models\RelatedLinks::class, function (Faker $faker) {
    return [
        'title' => $title = $faker->text(rand(50, 191)),
        'category_id' => rand(1, 138),
        'slug' => str_slug($title),
        'filter' => [
            'user_review' => rand(0,1),
            'business_size' => rand(0,1),
            'features' => rand(0,1),
            'deployment' => rand(0,1),
            'desktop_client' => rand(0,1),
            'mobile_version' => rand(0,1),
            'price' => rand(0,1)
        ]
    ];
});
