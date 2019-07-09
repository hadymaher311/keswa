<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Orders\CreateRequest;

class OrdersController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:view orders')->only(['index', 'show']);
        $this->middleware('permission:create orders')->only(['create', 'store']);
        $this->middleware('permission:update orders')->only(['edit', 'update']);
        $this->middleware('permission:delete orders')->only(['destroy']);
    }


    /**
     * Get orders by state query
     * 
     * @param \Illuminate\Http\Request
     * @return \App\Models\Order
     */
    protected function getOrdersByState(Request $request)
    {
        switch ($request->state) {
            case 'pending':
                return $this->pendingOrders();
            
            case 'by_date':
                return $this->byDateOrders($request);
            
            case 'all':
                return $this->allOrders();
            
            case 'approved':
                return $this->approvedOrders();
            
            case 'shipped':
                return $this->shippedOrders();
            
            case 'completed':
                return $this->completedOrders();
            
            case 'canceled':
                return $this->canceledOrders();

            default:
                return $this->pendingOrders();
        }
    }

    /**
     * Get pending orders
     * 
     * @return \App\Models\Order
     */
    protected function pendingOrders()
    {
        return Order::with('latestStatus')->get()->filter(function ($order) {
            return $order->latestStatus->name == 'Waiting for confirmation';
        });
    }
    
    /**
     * Get approved orders
     * 
     * @return \App\Models\Order
     */
    protected function approvedOrders()
    {
        return Order::with('latestStatus')->get()->filter(function ($order) {
            return $order->latestStatus->name == 'Approved';
        });
    }
    
    /**
     * Get completed orders
     * 
     * @return \App\Models\Order
     */
    protected function completedOrders()
    {
        return Order::with('latestStatus')->get()->filter(function ($order) {
            return $order->latestStatus->name == 'Completed';
        });
    }
    
    /**
     * Get shipped orders
     * 
     * @return \App\Models\Order
     */
    protected function shippedOrders()
    {
        return Order::with('latestStatus')->get()->filter(function ($order) {
            return $order->latestStatus->name == 'Shipped';
        });
    }
    
    /**
     * Get canceled orders
     * 
     * @return \App\Models\Order
     */
    protected function canceledOrders()
    {
        return Order::with('latestStatus')->get()->filter(function ($order) {
            return $order->latestStatus->name == 'Canceled';
        });
    }
    
    /**
     * Get all orders
     * 
     * @return \App\Models\Order
     */
    protected function allOrders()
    {
        return Order::orderBy('created_at', 'desc')->get();
    }
    
    /**
     * Get orders by date interval
     * 
     * @param \Illuminate\Http\Request
     * @return \App\Models\Order
     */
    protected function byDateOrders(Request $request)
    {
        if ($request->from_to) {
            $from_to_array = explode('/', $request->from_to);
            $request['from'] = Carbon::create($from_to_array[0]);
            $request['to'] = Carbon::create($from_to_array[1]) ? Carbon::create($from_to_array[1]) : Carbon::today();
            if ($request->from && $request->to) {
                $this->validate($request, [
                    'to' => 'date|after_or_equal:from',
                    'from' => 'date|before_or_equal:to',
                ]);
                return Order::orderBy('created_at', 'desc')->whereBetween('created_at', [$request->from, $request->to])->get();
            }
        } else {
            return Order::orderBy('created_at', 'desc')->whereBetween('created_at', [Carbon::today(), Carbon::tomorrow()])->get();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = $this->getOrdersByState($request);
        $pending_orders_count = $this->pendingOrders()->count();
        $all_orders_count = $this->allOrders()->count();
        $approved_orders_count = $this->approvedOrders()->count();
        $shipped_orders_count = $this->shippedOrders()->count();
        $completed_orders_count = $this->completedOrders()->count();
        $canceled_orders_count = $this->canceledOrders()->count();
        return view('admin.orders.index', compact('orders', 'pending_orders_count', 'all_orders_count', 'approved_orders_count', 'shipped_orders_count', 'completed_orders_count', 'canceled_orders_count'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $price_tax = GeneralSetting::priceTax()->first();
        return view('admin.orders.show', compact('order', 'price_tax'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::active()->get();
        $products = Product::active()->get();
        return view('admin.orders.create', compact('users', 'products'));
    }

    /**
     * Check min sale of produts
     * 
     * @param \Illuminate\Http\Request
     */
    protected function checkMinSaleOfProducts(Request $request)
    {
        $i = 0;
        foreach ($request->quantity as $quantity) {
            $product = Product::find($request->products[$i]);
            if ($quantity < $product->min_sale_quantity) {
                return $product;
            }
            $i++;
        }
        return null;
    }

    /**
     * add order status
     * 
     * @param \App\Models\Order $order
     */
    protected function addOrderStatus(Order $order)
    {
        $order->statuses()->createMany([
            ['name' => 'Waiting for confirmation',],
            ['name' => 'Approved',]
        ]);
    }    
    
    /**
     * add order products
     * 
     * @param \App\Models\Order $order
     */
    protected function addOrderProducts(Request $request, Order $order)
    {
        $i = 0;
        foreach ($request->products as $product) {
            $order->products()->attach(
                $product,
                ['quantity' => $request->quantity[$i],]
            );
            $i++;
        }
    }    

    /**
     * Store order details
     * 
     * @param \Illuminate\Http\Request $request
     * @return \App\Models\Order
     */
    protected function storeOrderDetails(Request $request)
    {
        $user = User::find($request->user);
        return $user->orders()->create([
            'comment' => $request->comment,
            'user_address_id' => $user->addresses->first()->id,
            'total_price' => $this->getTotalPrice($request),
        ]);
    }
    
    /**
     * get order total price
     * 
     * @param \Illuminate\Http\Request $request
     * @return \App\Models\Order
     */
    protected function getTotalPrice(Request $request)
    {
        $products = Product::find($request->products);
        $i = 0;
        $sum = 0;
        foreach ($products as $product) {
            $sum += $product->final_price * $request->quantity[$i];
            $i++;
        }
        return $sum;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Http\Requests\Admin\Orders\CreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $request['comment'] = str_replace('<', '&lt;', $request->comment);
        $request['comment'] = str_replace('>', '&gt;', $request->comment);
        $request['comment'] = nl2br($request->comment);
        $product = $this->checkMinSaleOfProducts($request);
        if (!$product) {
            $order = $this->storeOrderDetails($request);
            $this->addOrderStatus($order);
            $this->addOrderProducts($request, $order);
            return back()->with(['status' => trans('Added Successfully')]);
        }
        return back()->with(['error' => __('You must order at least') . ' ' . $product->min_sale_quantity . ' ' . __('from') . ' ' . $product->name]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        return view('admin.orders.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $this->validate($request, [
            'name' => 'required|string|min:2'
        ]);
        $permission->name = $request->name;
        $permission->save();
        return redirect()->route('orders.index')->with('status', trans('Updated Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!$request->orders) {
            return back();
        }
        $this->validate($request, [
            'orders.*' => 'required|exists:orders,id',
        ]);
        Order::destroy($request->orders);
        return back()->with('status', trans('Deleted Successfully'));
    }
}
