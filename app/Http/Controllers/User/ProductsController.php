<?php

namespace App\Http\Controllers\User;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  Product  $product
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product, $slug)
    {
        if ($product->isTrueSlug($slug) and $product->active) {
            $latest_products = Product::orderBy('created_at', 'desc')->active()->get()->take(5);
            return view('user.products.show', compact('product', 'latest_products'));
        }
        abort(404);
    }
}
