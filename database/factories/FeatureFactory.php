<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Feature;
use Faker\Generator as Faker;

$factory->define(Feature::class, function (Faker $faker) {
    return [
        'name_en' => $faker->word,
        'value_en' => $faker->word,
    ];
});
