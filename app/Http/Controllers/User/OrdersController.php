<?php

namespace App\Http\Controllers\User;

use App\Models\Order;
use App\Models\Product;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\WarehouseRelatedLocation;

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
        $locations = WarehouseRelatedLocation::whereHas('warehouse', function($warehouse){
            return $warehouse->active();
        })->get();
        return view('user.orders.checkout', compact('locations'));
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
     * if all cart products is free
     */
    protected function isAllFree()
    {
        foreach (auth()->user()->cart as $product) {
            if (!$product->free_shipping) {
                return false;
            }
        }
        return true;
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
            'total_price' => auth()->user()->cart_total_price,
            'points' => auth()->user()->cart_total_points,
            'warehouse_id' => UserAddress::find($request->address)->warehouse()->id,
            'shipping_price' => ($this->isAllFree()) ? UserAddress::find($request->address)->warehouse()->shipping_price : 0,
        ]);
    }

    /**
     * Get real quantity
     * 
     * @param \App\Models\Product $product
     * @return int
     */
    protected function getRealQuantity(Product $product)
    {
        return (mb_strtolower($product->sale_by) == 'gram') ? $product->min_sale_quantity * $product->pivot->quantity : $product->pivot->quantity;
    }

    /**
     * Check min sale of produts
     */
    protected function checkMinSaleOfProducts()
    {
        foreach (auth()->user()->cart as $product) {
            if ($this->getRealQuantity($product) < $product->min_sale_quantity) {
                return $product;
            }
        }
        return null;
    }
    
    /**
     * Check if products is available
     * 
     * @param \Illuminate\Http\Request $request
     */
    protected function isNotAvailable(Request $request)
    {
        foreach (auth()->user()->cart as $product) {
            if (!$product->isAvailableIn(UserAddress::find($request->address)->warehouse())) {
                return $product;
            }
        }
        return null;
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
        if (UserAddress::find($request->address)->warehouse()->active) {
            $product = $this->isNotAvailable($request);
            if (!$product) {
                $product = $this->checkMinSaleOfProducts();
                if (!$product) {
                    $order = $this->storeOrderDetails($request);
                    $this->addOrderStatus($order);
                    $this->addOrderProducts($order);
                    return redirect()->route('user.orders')->with(['status' => trans('Added Successfully')]);
                }
                return back()->with(['error' => __('You must order at least') . ' ' . $product->min_sale_quantity . ' ' . __('from') . ' ' . $product->name]);
            }
            return back()->with(['error' => __('The product') . ' ' . $product->name . ' ' . 'is not available in your area']);
        }
        return back()->with(['error' => __('You must change your address because warehouse in this address is no active')]);
    }

    /**
     * Get order details
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function details(Request $request, Order $order)
    {
        return view('user.orders.details', compact('order'));
    }
}
