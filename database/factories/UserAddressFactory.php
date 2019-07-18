<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\User;
use App\Models\UserAddress;
use Faker\Generator as Faker;
use App\Models\WarehouseRelatedLocation;

$factory->define(UserAddress::class, function (Faker $faker) {
    return [
        'country' => 'Egypt',
        'city' => function() {
            return WarehouseRelatedLocation::all()->random();
        },
        'street' => $faker->streetName,
        'building' => $faker->buildingNumber,
        'floor' => $faker->buildingNumber,
        'apartment' => $faker->buildingNumber,
        'nearest_landmark' => $faker->state,
        'location_type' => $faker->randomElement(['home', 'business']),
        'user_id' => function() {
            return User::all()->random();
        },
    ];
});
