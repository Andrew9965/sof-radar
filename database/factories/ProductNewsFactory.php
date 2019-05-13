<?php

use Faker\Generator as Faker;

$factory->define(App\Models\ProductNews::class, function (Faker $faker) {
    return [
        'product_id' => rand(18, 322),
        'title' => $faker->text(rand(50, 191)),
        'text' => $faker->text(rand(100, 500)),
        'description' => $faker->text(rand(1000, 5000))
    ];
});
