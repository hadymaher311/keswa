<?php

namespace App\Http\Controllers\User;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WishListController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('user.profile.wishlist');
    }
    
    /**
     * add item to wishlist.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        auth()->user()->wishlist()->syncWithoutDetaching($product);
        return back()->with(['status' => trans('Added Successfully')]);
    }
    
    /**
     * delete item from wishlist.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Product $product)
    {
        auth()->user()->wishlist()->detach($product->id);
        return back()->with(['status' => trans('Added Successfully')]);
    }
}
