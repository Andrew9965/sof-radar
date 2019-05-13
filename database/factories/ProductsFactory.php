<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Products::class, function (Faker $faker) {

    $test = \App\Models\Categories::with('categories_ff')->get();
    $id1 = $test[rand(0, count($test)-1)];
    $f1 = $id1->categories_ff->pluck('title')->toArray();
    $id2 = $test[rand(0, count($test)-1)];
    $f2 = $id2->categories_ff->pluck('title')->toArray();
    $id3 = $test[rand(0, count($test)-1)];
    $f3 = $id3->categories_ff->pluck('title')->toArray();

    return [
        'title' => $title = $faker->text(rand(50, 191)),
        'logo' => 'images/faker/img_0'.rand(1,3).'.png',
        'short_description' => $short = '<p>'.$faker->text(rand(100, 500)).'</p>',
        'fool_description' => '<p>'.$faker->text(rand(1000, 5000)).'</p>',
        'categories' => ['1' => $id1->id, '2' => $id2->id, '3' => $id3->id],
        'features' => [
            '1' => $faker->randomElements($f1, rand(1, count($f1)-1)),
            '2' => $faker->randomElements($f2, rand(1, count($f2)-1)),
            '3' => $faker->randomElements($f3, rand(1, count($f3)-1)),
        ],
        'details' => [
            "deployment" => $faker->randomElements(["SaaS","InHouse"], rand(1, 2)),
            "desc_client" => $faker->randomElements(["Windows","Linux","Mac","Web-browser"], rand(1, 4)),
            "mobile_version" => $faker->randomElements(["Android","IOS","Windows phone","Web-browser"], rand(1, 4)),
            "business_size" => $faker->randomElements(["Small","Medium","Enterprise"], rand(1, 3)),
            "vendor_detalis" => "<p>".$faker->sentence(rand(2, 10))."</p>"
        ],
        'pricing' => [
            'starting_price' => [
                "onsubmit" => $act = rand(0,1) ? "on" : "off",
                "price" => $act=='off' ? $faker->randomNumber(2) : null,
                "link" => $act=='on' ? $faker->url : null,
            ],
            'pricing_model' => $faker->randomElements(["Subscription","Pay as you go","No Seat Price"], rand(1, 3)),
            'training' => $faker->randomElements(["Documenation","Webinars","In person","Live courses"], rand(1, 4)),
            'license_price' => [
                "onsubmit" => $act = rand(0,1) ? "on" : "off",
                "price" => $act=='off' ? $faker->randomNumber(2) : null,
                "link" => $act=='on' ? $faker->url : null,
            ],
            'free_trial' => [
                "active" => $act = rand(0,1) ? "on" : "off",
                "link" => $act ? $faker->url : null,
            ]
        ],
        'web_site' => rand(0,1) ? $faker->url : null,
        'integrations_programs' => [],
        'meta_title' => $title,
        'meta_description' => strip_tags($short)
    ];
});
