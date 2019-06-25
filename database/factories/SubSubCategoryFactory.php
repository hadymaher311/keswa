<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\SubCategory;
use Faker\Generator as Faker;
use App\Models\SubSubCategory;

$factory->define(SubSubCategory::class, function (Faker $faker) {
    return [
        'name_en' => $faker->word,
        'description_en' => $faker->text(300),
        'active' => $faker->numberBetween(0, 1),
        'navbar_visibility' => $faker->numberBetween(0, 1),
        'sub_category_id' => function() {
        	return SubCategory::all()->random();
        },
    ];
});
