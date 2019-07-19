<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\User;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use App\Models\warehouse;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    $user = User::all()->random();
    return [
        'comment' => $faker->paragraph,
        'user_id' => $user->id,
        'user_address_id' => $user->main_location,
        'warehouse_id' => function() {
            return warehouse::all()->random();
        },
        'shipping_date' => $faker->dateTime(Carbon::now()->addWeeks($faker->numberBetween(1, 3))),
    ];
});

$factory->afterCreating(Order::class, function ($order, $faker) {
    $order->products()->attach(Product::active()->get()->random(), ['quantity' => $faker->numberBetween(5, 10)]);
    $order->products()->attach(Product::active()->get()->random(), ['quantity' => $faker->numberBetween(5, 10)]);
    $order->products()->attach(Product::active()->get()->random(), ['quantity' => $faker->numberBetween(5, 10)]);
    $order->products()->attach(Product::active()->get()->random(), ['quantity' => $faker->numberBetween(5, 10)]);
    $order->total_price = $order->products->sum(function($product) {
        return $product->final_price * $product->pivot->quantity;
    });
    $order->points = $order->products->sum(function($product) {
        return $product->points * $product->pivot->quantity;
    });
    $order->shipping_price = $order->warehouse->shipping_price;
    $order->save();
    $order->statuses()->create([
        'name' => 'Waiting for confirmation',
    ]);
});
