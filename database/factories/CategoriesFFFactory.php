<?php

use Faker\Generator as Faker;

$factory->define(App\Models\CategoriesFF::class, function (Faker $faker) {
    return [
        'category_id' => rand(3, 137),
        'title' => $faker->sentence(rand(2, 10))
    ];
});
