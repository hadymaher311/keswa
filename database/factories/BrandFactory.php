<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use App\Models\Brand;

$factory->define(Brand::class, function (Faker $faker) {
    return [
        'name_en' => $faker->company,
        'description_en' => $faker->text(300),
        'active' => $faker->numberBetween(0, 1),
        'navbar_visibility' => $faker->numberBetween(0, 1),
    ];
});

$factory->afterCreating(Brand::class, function ($brand, $faker) {
    $brand->addMediaFromUrl("https://loremflickr.com/300/300/logo")->toMediaCollection('brand.image');
    $brand->addMediaFromUrl("https://loremflickr.com/300/300/logo")->toMediaCollection('brand.image');
    $brand->addMediaFromUrl("https://loremflickr.com/300/300/logo")->toMediaCollection('brand.image');
    $brand->addMediaFromUrl("https://loremflickr.com/300/300/logo")->toMediaCollection('brand.image');
    $brand->addMediaFromUrl("https://loremflickr.com/300/300/logo")->toMediaCollection('brand.image');
});