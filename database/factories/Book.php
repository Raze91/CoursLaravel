<?php

use Faker\Generator as Faker;

$factory->define(App\Book::class, function (Faker $faker) {
    return [
        "title" => $faker->sentence(3, true),
        "description" => $faker->paragraphs(3, true),
    ];
});
