<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Carbon\Carbon;
use App\Models\Brand;
use App\Models\Feature;
use App\Models\Product;
use App\Models\warehouse;
use Faker\Generator as Faker;
use App\Models\SubSubCategory;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name_en' => $faker->word,
        'description_en' => $faker->text(1000),
        'short_description_en' => $faker->text(300),
        'low_quantity' => $faker->numberBetween(0, 50), 
        'quantity_per_packet' => $faker->numberBetween(1, 100), 
        'min_sale_quantity' => $faker->numberBetween(1, 10),
        'length' => $faker->numberBetween(1, 100), 
        'width' => $faker->numberBetween(1, 100), 
        'depth' => $faker->numberBetween(1, 100), 
        'weight' => $faker->numberBetween(1, 100),
        'cost'  => $faker->numberBetween(1, 100), 
        'price' => $faker->numberBetween(100, 1000),
        // 'expiry_date' => $faker->dateTime(Carbon::now()->addWeeks($faker->numberBetween(2, 52))), 
        'expiry_alarm_before' => $faker->numberBetween(1, 30),
        'brand_id' => function() {
        	return Brand::all()->random();
        },
        'sku' => $faker->numberBetween(1000000000, 9999999999),
        'upc' => $faker->numberBetween(1000000000, 9999999999),
        'upc' => $faker->numberBetween(1000000000, 9999999999),
        'sale_by' => $faker->randomElement(['unit', 'gram']),
        'active' => $faker->numberBetween(0, 1),
        'free_shipping' => $faker->numberBetween(0, 1),
        'allow_review' => $faker->numberBetween(0, 1),
    ];
});

$factory->afterCreating(Product::class, function ($product, $faker) {
    $product->categories()->attach(SubSubCategory::all()->random());
    $product->categories()->attach(SubSubCategory::all()->random());
    $product->addMediaFromUrl("https://loremflickr.com/600/600/product")->toMediaCollection('product.images');
    $product->addMediaFromUrl("https://loremflickr.com/600/600/product")->toMediaCollection('product.images');
    $product->addMediaFromUrl("https://loremflickr.com/600/600/product")->toMediaCollection('product.images');
    $product->addMediaFromUrl("https://loremflickr.com/600/600/product")->toMediaCollection('product.images');
    $product->addMediaFromUrl("https://loremflickr.com/600/600/product")->toMediaCollection('product.images');
    $product->features()->attach(Feature::all()->random());
    $product->features()->attach(Feature::all()->random());
    $product->accessories()->attach(Product::all()->random());
    $product->accessories()->attach(Product::all()->random());
    $product->accessories()->attach(Product::all()->random());
    $product->accessories()->attach(Product::all()->random());
    $product->accessories()->attach(Product::all()->random());
    $product->related_products()->attach(Product::all()->random());
    $product->related_products()->attach(Product::all()->random());
    $product->related_products()->attach(Product::all()->random());
    $product->related_products()->attach(Product::all()->random());
});
