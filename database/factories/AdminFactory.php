<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Admin;
use Faker\Generator as Faker;

$factory->define(Admin::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'active' => $faker->numberBetween(0, 1),
        'password' => Hash::make('123456789'),
        'remember_token' => Str::random(10),
    ];
});

$factory->afterCreating(Admin::class, function ($admin, $faker) {
    $admin->personalInfo()->create([
        'phone' => $faker->numberBetween(10000000000, 99999999999),
        'gender' => $faker->randomElement(['male', 'female']),
        'birth_date' => $faker->dateTime('2000-01-01 00:00:00'),
    ]);
    $admin->addMediaFromUrl("https://loremflickr.com/300/300/man")->toMediaCollection('admin.avatar');
    $admin->address()->create([
        'country' => 'Egypt',
        'city' => $faker->city,
        'street' => $faker->streetName,
        'building' => $faker->buildingNumber,
        'floor' => $faker->buildingNumber,
        'apartment' => $faker->buildingNumber,
        'nearest_landmark' => $faker->state,
        'location_type' => $faker->randomElement(['home', 'business']),
    ]);
});
