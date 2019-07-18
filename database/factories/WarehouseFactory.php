<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Product;
use App\Models\warehouse;
use Faker\Generator as Faker;

$factory->define(warehouse::class, function (Faker $faker) {
    return [
        'name_en' => $faker->word,
        'location_en' => $faker->address,
        'active' => $faker->numberBetween(0, 1),
        'shipping_price' => $faker->numberBetween(5, 50),
    ];
});

$factory->afterCreating(warehouse::class, function ($warehouse, $faker) {
    $warehouse->admins()->attach(Admin::all()->random());
    $warehouse->admins()->attach(Admin::all()->random());
    $warehouse->admins()->attach(Admin::all()->random());
    $warehouse->admins()->attach(Admin::all()->random());
    for ($i=0; $i < 100; $i++) { 
        $warehouse->products()->attach(Product::all()->random(), [
            'base_quantity' => $faker->numberBetween(5000, 100000),
            'reduced_quantity' => $faker->numberBetween(1, 5000),
            'expiry_date' => $faker->dateTime(Carbon::now()->addWeeks($faker->numberBetween(2, 52))), 
        ]);
    }
    for ($i=0; $i < 10; $i++) { 
        $warehouse->related_locations()->create([
            'location_name' => $faker->city,
        ]);
    }
});