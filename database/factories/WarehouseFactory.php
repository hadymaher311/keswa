<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use App\Models\warehouse;

$factory->define(warehouse::class, function (Faker $faker) {
    return [
        'name_en' => $faker->word,
        'location_en' => $faker->address,
        'active' => $faker->numberBetween(0, 1),
    ];
});
