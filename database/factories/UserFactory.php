<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use App\Models\Product;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
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

$factory->afterCreating(App\User::class, function ($user, $faker) {
    $user->personalInfo()->create([
        'phone' => $faker->numberBetween(10000000000, 99999999999),
        'gender' => $faker->randomElement(['male', 'female']),
        'birth_date' => $faker->dateTime('2000-01-01 00:00:00'),
    ]);
    $product = Product::all()->random();
    if (!($user->cart()->updateExistingPivot($product->id, ['quantity' => $faker->randomDigit]))) {
        $user->cart()->attach([$product->id => ['quantity' => $faker->randomDigit]]);
    }
    $user->wishlist()->syncWithoutDetaching(Product::all()->random());
    $user->addMediaFromUrl("https://loremflickr.com/300/300/man")->toMediaCollection('user.avatar');
});
