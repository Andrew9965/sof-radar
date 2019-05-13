<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Reviews::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'product_id' => rand(18, 322),
        'headline' => $faker->text(rand(50, 191)),
        'used' => $faker->numerify('# years'),
        'easy_of_use' => rand(1, 5),
        'functionality' => rand(1, 5),
        'product_quality' => rand(1, 5),
        'customer_support' => rand(1, 5),
        'value_for_money' => rand(1, 5),
        'like_best' => $faker->text(rand(100, 200)),
        'like_least' => $faker->text(rand(100, 200)),
        'comment' => $faker->text(rand(500, 1000)),
        'like' => rand(1, 200),
        'dislike' => rand(1, 200),
        "created_at" => now(),
        "updated_at" => now()
    ];
});
