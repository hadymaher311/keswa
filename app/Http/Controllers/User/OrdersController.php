<?php

namespace App\Http\Controllers\User;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    /**
     * Display user orders.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.orders.index');
    }

    /**
     * user order checkout page
     * 
     * @return \Illuminate\Http\Response
     */
    public function checkout()
    {
        return view('user.orders.checkout');
    }

    /**
     * add order status
     * 
     * @param \App\Models\Order $order
     */
    protected function addOrderStatus(Order $order)
    {
        $order->statuses()->create([
            'name' => 'Waiting for confirmation',
        ]);
    }    
    
    /**
     * add order products
     * 
     * @param \App\Models\Order $order
     */
    protected function addOrderProducts(Order $order)
    {
        $cart_products = auth()->user()->cart->map(function ($this_cart) { 
            return $this_cart->pivot;
        });
        foreach ($cart_products as $product) {
            $order->products()->attach(
                $product->product_id,
                ['quantity' => $product->quantity,]
            );
        }

        // remove the cart
        auth()->user()->cart()->detach();
    }    

    /**
     * Store order details
     * 
     * @param \Illuminate\Http\Request $request
     * @return \App\Models\Order
     */
    protected function storeOrderDetails(Request $request)
    {
        return auth()->user()->orders()->create([
            'comment' => $request->comments,
            'user_address_id' => $request->address,
            'total_price' => auth()->user()->cart_total_price
        ]);
    }

    /**
     * Confirm Order
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function confirm(Request $request)
    {
        $this->validate($request, [
            'comments' => 'nullable|string',
            'address' => [
                    'required',
                    Rule::exists('user_addresses', 'id')->where(function ($query) {
                        $query->where('user_id', auth()->id());
                    }),
                ]
        ]);
        if (!(auth()->user()->cart()->count())) {
            return back()->with(['error' => trans('Something worng happened')]);            
        }
        $request['comments'] = str_replace('<', '&lt;', $request->comments);
        $request['comments'] = str_replace('>', '&gt;', $request->comments);
        $request['comments'] = nl2br($request->comments);
        $order = $this->storeOrderDetails($request);
        $this->addOrderStatus($order);
        $this->addOrderProducts($order);
        return redirect()->route('user.orders')->with(['status' => trans('Added Successfully')]);
    }
}
