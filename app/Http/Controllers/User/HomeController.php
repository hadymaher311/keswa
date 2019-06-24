<?php

namespace App\Http\Controllers\User;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\SubSubCategory;
use App\Http\Controllers\Controller;
use App\Models\Brand;

class HomeController extends Controller
{
    
    /**
     * Show the application homepage.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function welcome()
    {
        $categories_with_latest_products = SubSubCategory::active()->take(5)->get();
        foreach ($categories_with_latest_products as $cat) {
            $cat->load('latestProducts');
        }
        $top_rated_products = Product::active()->get()->sortByDesc('rating')->take(5);
        $best_discount_products = Product::active()->get()->sortByDesc('discount_percentage')->take(5);
        $home_brands = Brand::active()->get()->take(10);
        return view('welcome', compact('top_rated_products', 'best_discount_products', 'categories_with_latest_products', 'home_brands'));
    }
}
