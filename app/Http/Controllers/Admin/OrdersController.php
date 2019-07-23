<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Product;
use App\Models\warehouse;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use App\Models\WarehouseProduct;
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
            
            case 'disapproved':
                return $this->disapprovedOrders();
            
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
        return Order::whereHas('warehouse.admins', function($admin) {
            return $admin->where('admins.id', auth()->id());
        })->orderBy('id', 'desc')->with('latestStatus')->get()->filter(function ($order) {
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
        return Order::whereHas('warehouse.admins', function($admin) {
            return $admin->where('admins.id', auth()->id());
        })->orderBy('id', 'desc')->with('latestStatus')->get()->filter(function ($order) {
            return $order->latestStatus->name == 'Approved';
        });
    }
    
    /**
     * Get disapproved orders
     * 
     * @return \App\Models\Order
     */
    protected function disapprovedOrders()
    {
        return Order::whereHas('warehouse.admins', function($admin) {
            return $admin->where('admins.id', auth()->id());
        })->orderBy('id', 'desc')->with('latestStatus')->get()->filter(function ($order) {
            return $order->latestStatus->name == 'Disapproved';
        });
    }
    
    /**
     * Get completed orders
     * 
     * @return \App\Models\Order
     */
    protected function completedOrders()
    {
        return Order::whereHas('warehouse.admins', function($admin) {
            return $admin->where('admins.id', auth()->id());
        })->orderBy('id', 'desc')->with('latestStatus')->get()->filter(function ($order) {
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
        return Order::whereHas('warehouse.admins', function($admin) {
            return $admin->where('admins.id', auth()->id());
        })->orderBy('id', 'desc')->with('latestStatus')->get()->filter(function ($order) {
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
        return Order::whereHas('warehouse.admins', function($admin) {
            return $admin->where('admins.id', auth()->id());
        })->orderBy('id', 'desc')->with('latestStatus')->get()->filter(function ($order) {
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
        return Order::whereHas('warehouse.admins', function($admin) {
            return $admin->where('admins.id', auth()->id());
        })->orderBy('id', 'desc')->get();
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
                return Order::whereHas('warehouse.admins', function($admin) {
                    return $admin->where('admins.id', auth()->id());
                })->orderBy('id', 'desc')->whereBetween('created_at', [$request->from, $request->to])->get();
            }
        } else {
            return Order::whereHas('warehouse.admins', function($admin) {
                return $admin->where('admins.id', auth()->id());
            })->orderBy('id', 'desc')->whereBetween('created_at', [Carbon::today(), Carbon::tomorrow()])->get();
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
        $disapproved_orders_count = $this->disapprovedOrders()->count();
        $shipped_orders_count = $this->shippedOrders()->count();
        $completed_orders_count = $this->completedOrders()->count();
        $canceled_orders_count = $this->canceledOrders()->count();

        $warehouses = warehouse::active()->get();
        return view('admin.orders.index', compact('orders', 'pending_orders_count', 'all_orders_count', 'approved_orders_count', 'disapproved_orders_count', 'shipped_orders_count', 'completed_orders_count', 'canceled_orders_count', 'warehouses'));
    }

    /**
     * get real quantity
     * 
     * @param \App\Models\Product $product
     * @return int
     */
    protected function getRealQuantity(Product $product)
    {
        return (mb_strtolower($product->sale_by) == 'gram') ? $product->pivot->quantity * $product->min_sale_quantity : $product->pivot->quantity;
    }

    /**
     * reduce Order product quantities.
     *
     * @param  \App\Models\Order  $order
     */
    protected function reduceQuantities(Order $order) {
        foreach ($order->products as $product) {
            $quantity = WarehouseProduct::where('warehouse_id', $order->warehouse_id)->where('product_id', $product->id)->where('reduced_quantity', '>=', $product->min_sale_quantity)->where('reduced_quantity', '>=', $this->getRealQuantity($product))->first();
            $quantity->reduced_quantity -= $this->getRealQuantity($product);
            $quantity->save();
            $product->total_quantity = $product->quantities->sum(function($quantity) {
                return $quantity->reduced_quantity;
            });
            $product->save();
        }
    }

    /**
     * shipping Order form.
     *
     * @param  \App\Models\Order  $order
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function shippingForm(Order $order)
    {
        if (auth()->user()->can('order.view', $order)) {
            $admins = Admin::active()->role('delivery')->get();
            return view('admin.orders.shippingForm', compact('order', 'admins'));
        }
        abort(403);
    }


    /**
     * shipping Order.
     *
     * @param  \App\Models\Order  $order
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function shipping(Request $request, Order $order)
    {
        $this->validate($request, [
            'delivery' => 'required|exists:admins,id'
        ]);
        if (!$order->isShipped()) {
            $this->reduceQuantities($order);
        }
        $order->delivery_id = $request->delivery;
        $order->save();
        $order->statuses()->create(
            ['name' => 'Shipped',]
        );
        $order->shipping_date = Carbon::now();
        $order->save();
        return redirect()->route('orders.index', ['state'=>'shipped'])->with(['status' => __('Shipped Successfully')]);
    }
    
    /**
     * complete Order.
     *
     * @param  \App\Models\Order  $order
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function complete(Request $request, Order $order)
    {
        $order->user->sendOrderReviewNotification($order);
        $order->statuses()->create(
            ['name' => 'Completed',]
        );
        return back()->with(['status' => __('Completed Successfully')]);
    }
    
    /**
     * disapprove Order.
     *
     * @param  \App\Models\Order  $order
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function disapprove(Request $request, Order $order)
    {
        $order->statuses()->create(
            ['name' => 'Disapproved',]
        );
        $this->markUserNotificationAsRead($order); 
        return redirect()->route('orders.index')->with(['status' => __('Disapproved Successfully')]);
    }

    /**
     * Approve Order.
     *
     * @param  \App\Models\Order  $order
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function approve(Request $request, Order $order)
    {
        $this->validate($request, [
            'warehouse' => 'required|exists:warehouses,id',
            'comment' => 'nullable|string',
        ]);
        $request['comment'] = str_replace('<', '&lt;', $request->comment);
        $request['comment'] = str_replace('>', '&gt;', $request->comment);
        $request['comment'] = nl2br($request->comment);
        $order->warehouse_id = $request->warehouse;
        $order->comment = $request->comment;
        $order->save();
        $order->statuses()->create(
            ['name' => 'Approved',]
        );
        $this->markUserNotificationAsRead($order); 
        return redirect()->route('orders.index')->with(['status' => __('Approved Successfully')]);
    }

    /**
     * Mark user notification as read
     * 
     * @param  \App\Models\Order  $order
     */
    protected function markUserNotificationAsRead(Order $order)
    {
        $notification = $order->user->unreadnotifications()->where('type', 'App\Notifications\User\OrderWillBeServedLaterNotification')->where('data->order_id', $order->id)->first();
        if ($notification) {
            $notification->markAsRead();
        }
    }
    

    /**
     * Display page for order approving.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function approveView(Order $order)
    {
        if (auth()->user()->can('order.view', $order)) {
            if (!($order->isApproved()) && !($order->isDisapproved())) {
                $price_tax = GeneralSetting::priceTax()->first();
                $warehouses = auth()->user()->warehouses;
                return view('admin.orders.approve', compact('order', 'price_tax', 'warehouses'));
            }
            abort(404);
        }
        abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        if (auth()->user()->can('order.view', $order)) {
            $price_tax = GeneralSetting::priceTax()->first();
            return view('admin.orders.show', compact('order', 'price_tax'));
        }
        abort(403);
    }
    
    /**
     * Display order invoice.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function invoice(Order $order)
    {
        if (auth()->user()->can('order.view', $order)) {
            $price_tax = GeneralSetting::priceTax()->first();
            return view('admin.orders.invoice', compact('order', 'price_tax'));
        }
        abort(403);
    }
    
    /**
     * Print order invoice.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function invoicePrint(Order $order)
    {
        if (auth()->user()->can('order.view', $order)) {
            $price_tax = GeneralSetting::priceTax()->first();
            return view('admin.orders.invoicePrint', compact('order', 'price_tax'));
        }
        abort(403);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::active()->get();
        $products = Product::whereHas('warehouses.admins', function($admin) {
            return $admin->where('admins.id', auth()->id());
        })->active()->get();
        return view('admin.orders.create', compact('users', 'products'));
    }

    /**
     * get real quantity
     */
    protected function getRealQuantityForMinSale(Product $product)
    {
        return (mb_strtolower($product->sale_by) == 'gram') ? 1 : $product->min_sale_quantity;
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
            if ($quantity < $this->getRealQuantityForMinSale($product)) {
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
     * if all products is free
     */
    protected function isAllFree(Request $request)
    {
        foreach ($request->products as $pro) {
            $product = Product::find($pro);
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
        $user = User::find($request->user);
        return $user->orders()->create([
            'comment' => $request->comment,
            'user_address_id' => $user->main_location,
            'total_price' => $this->getTotalPrice($request),
            'points' => $this->getTotalPoints($request),
            'warehouse_id' => UserAddress::find(User::find($request->user)->main_location)->warehouse()->id,
            'shipping_price' => ($this->isAllFree($request)) ? UserAddress::find(User::find($request->user)->main_location)->warehouse()->shipping_price : 0,
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
     * get order total Points
     * 
     * @param \Illuminate\Http\Request $request
     * @return \App\Models\Order
     */
    protected function getTotalPoints(Request $request)
    {
        $products = Product::find($request->products);
        $i = 0;
        $sum = 0;
        foreach ($products as $product) {
            $sum += $product->points * $request->quantity[$i];
            $i++;
        }
        return $sum;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\Orders\CreateRequest  $request
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
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        // return view('admin.orders.edit', compact('Order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        // $this->validate($request, [
        //     'name' => 'required|string|min:2'
        // ]);
        // $order->name = $request->name;
        // $order->save();
        // return redirect()->route('orders.index')->with('status', trans('Updated Successfully'));
    }

    /**
     * Can delete all orders
     */
    protected function canDeleteAllOrders($orders)
    {
        foreach ($orders as $order) {
            if (!(!$order->isCanceled() && !$order->isShipped() && !$order->isDisapproved())) {
                return false;
            }
        }
        return true;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\Order  $order
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
        $orders = Order::find($request->orders);
        if ($this->canDeleteAllOrders($orders)) {
            Order::destroy($request->orders);
            return back()->with('status', trans('Deleted Successfully'));
        }
        return back()->with(['error' => 'You Can\'t delete these orders']);
    }
}
