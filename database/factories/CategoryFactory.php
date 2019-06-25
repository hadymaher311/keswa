<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use App\Models\Category;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name_en' => $faker->word,
        'description_en' => $faker->text(300),
        'active' => $faker->numberBetween(0, 1),
        'navbar_visibility' => $faker->numberBetween(0, 1),
    ];
});
