<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class CartController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('user.cart.show');
    }
    
    /**
     * add item to cart.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        $this->validate($request, [
            'quantity' => 'nullable|integer|min:1',
        ]);
        $quantity = ($request->quantity) ? $request->quantity : 1;
        if(!(auth()->user()->cart()->updateExistingPivot($product->id, ['quantity' => $quantity]))) {
            auth()->user()->cart()->attach([$product->id => ['quantity' => $quantity]]);
        }
        return back()->with(['status' => trans('Added Successfully')]);
    }
    
    /**
     * delete item from cart.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Product $product)
    {
        auth()->user()->cart()->detach($product->id);
        return back()->with(['status' => trans('Added Successfully')]);
    }
    
    /**
     * update item from cart.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'quantity' => 'required|integer|min:1',
        ]);
        auth()->user()->cart()->updateExistingPivot($product->id, ['quantity' => $request->quantity]);
        return back()->with(['status' => trans('Updated Successfully')]);
    }
}
