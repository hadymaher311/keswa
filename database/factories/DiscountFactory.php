<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Product;
use App\Models\Discount;
use Faker\Generator as Faker;

$factory->define(Discount::class, function (Faker $faker) {
    return [
        'type' => $faker->randomElement(['percentage', 'value']),
        'amount' => $faker->numberBetween(1, 50),
        'product_amount' => $faker->numberBetween(1, 100),
        'active' => $faker->numberBetween(0, 1),
        'product_id' => function() {
            return Product::all()->random();
        },
    ];
});
