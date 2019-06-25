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
