<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\User;
use App\Models\Review;
use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Review::class, function (Faker $faker) {
    return [
        'rate' => $faker->numberBetween(1, 5),
        'content' => $faker->paragraph,
        'approved' => $faker->numberBetween(0, 1),
        'product_id' => function() {
            return Product::all()->random();
        },
        'user_id' => function() {
            return User::all()->random();
        },
    ];
});
