<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\OrderReturn;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReturnsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:view returns')->only(['index', 'show']);
        $this->middleware('permission:create returns')->only(['create', 'store']);
        $this->middleware('permission:update returns')->only(['edit', 'update']);
        $this->middleware('permission:delete returns')->only(['destroy']);
    }


    /**
     * Get returns by state query
     * 
     * @param \Illuminate\Http\Request
     * @return \App\Models\OrderReturn
     */
    protected function getReturnsByState(Request $request)
    {
        switch ($request->state) {
            case 'pending':
                return $this->pendingReturns();
            
            case 'by_date':
                return $this->byDateReturns($request);
            
            case 'all':
                return $this->allReturns();
            
            case 'approved':
                return $this->approvedReturns();
            
            case 'disapproved':
                return $this->disapprovedReturns();
            
            case 'in_the_way':
                return $this->inTheWayReturns();
            
            case 'return_denied':
                return $this->returnDeniedReturns();
            
            case 'completed_screpped':
                return $this->completedScrappedReturns();
            
            
            case 'completed':
                return $this->completedReturns();
            
            case 'canceled':
                return $this->canceledReturns();

            default:
                return $this->pendingReturns();
        }
    }

    /**
     * Get pending Returns
     * 
     * @return \App\Models\OrderReturn
     */
    protected function pendingReturns()
    {
        return OrderReturn::whereHas('warehouse.admins', function($admin) {
            return $admin->where('admins.id', auth()->id());
        })->orderBy('id', 'desc')->with('latestStatus')->get()->filter(function ($return) {
            return $return->latestStatus->name == 'Waiting for confirmation';
        });
    }
    
    /**
     * Get approved Returns
     * 
     * @return \App\Models\Return
     */
    protected function approvedReturns()
    {
        return OrderReturn::whereHas('warehouse.admins', function($admin) {
            return $admin->where('admins.id', auth()->id());
        })->orderBy('id', 'desc')->with('latestStatus')->get()->filter(function ($return) {
            return $return->latestStatus->name == 'Approved';
        });
    }
    
    /**
     * Get disapproved Returns
     * 
     * @return \App\Models\Return
     */
    protected function disapprovedReturns()
    {
        return OrderReturn::whereHas('warehouse.admins', function($admin) {
            return $admin->where('admins.id', auth()->id());
        })->orderBy('id', 'desc')->with('latestStatus')->get()->filter(function ($return) {
            return $return->latestStatus->name == 'Disapproved';
        });
    }
    
    /**
     * Get completed Scrapped Returns
     * 
     * @return \App\Models\Return
     */
    protected function completedScrappedReturns()
    {
        return OrderReturn::whereHas('warehouse.admins', function($admin) {
            return $admin->where('admins.id', auth()->id());
        })->orderBy('id', 'desc')->with('latestStatus')->get()->filter(function ($return) {
            return $return->latestStatus->name == 'Completed scrapped';
        });
    }
    
    /**
     * Get completed Returns
     * 
     * @return \App\Models\Return
     */
    protected function completedReturns()
    {
        return OrderReturn::whereHas('warehouse.admins', function($admin) {
            return $admin->where('admins.id', auth()->id());
        })->orderBy('id', 'desc')->with('latestStatus')->get()->filter(function ($return) {
            return $return->latestStatus->name == 'Completed';
        });
    }
    
    /**
     * Get in the way Returns
     * 
     * @return \App\Models\Return
     */
    protected function inTheWayReturns()
    {
        return OrderReturn::whereHas('warehouse.admins', function($admin) {
            return $admin->where('admins.id', auth()->id());
        })->orderBy('id', 'desc')->with('latestStatus')->get()->filter(function ($return) {
            return $return->latestStatus->name == 'In the way';
        });
    }
    
    /**
     * Get return denied Returns
     * 
     * @return \App\Models\Return
     */
    protected function returnDeniedReturns()
    {
        return OrderReturn::whereHas('warehouse.admins', function($admin) {
            return $admin->where('admins.id', auth()->id());
        })->orderBy('id', 'desc')->with('latestStatus')->get()->filter(function ($return) {
            return $return->latestStatus->name == 'Return Denied';
        });
    }
    
    /**
     * Get canceled Returns
     * 
     * @return \App\Models\Return
     */
    protected function canceledReturns()
    {
        return OrderReturn::whereHas('warehouse.admins', function($admin) {
            return $admin->where('admins.id', auth()->id());
        })->orderBy('id', 'desc')->with('latestStatus')->get()->filter(function ($return) {
            return $return->latestStatus->name == 'Canceled';
        });
    }
    
    /**
     * Get all Returns
     * 
     * @return \App\Models\Return
     */
    protected function allReturns()
    {
        return OrderReturn::whereHas('warehouse.admins', function($admin) {
            return $admin->where('admins.id', auth()->id());
        })->orderBy('id', 'desc')->get();
    }
    
    /**
     * Get Returns by date interval
     * 
     * @param \Illuminate\Http\Request
     * @return \App\Models\Return
     */
    protected function byDateReturns(Request $request)
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
                return OrderReturn::whereHas('warehouse.admins', function($admin) {
                    return $admin->where('admins.id', auth()->id());
                })->orderBy('id', 'desc')->whereBetween('created_at', [$request->from, $request->to])->get();
            }
        } else {
            return OrderReturn::whereHas('warehouse.admins', function($admin) {
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
        $returns = $this->getReturnsByState($request);
        $pending_returns_count = $this->pendingReturns()->count();
        $all_returns_count = $this->allReturns()->count();
        $approved_returns_count = $this->approvedReturns()->count();
        $disapproved_returns_count = $this->disapprovedReturns()->count();
        $in_the_way_returns_count = $this->inTheWayReturns()->count();
        $return_denied_returns_count = $this->returnDeniedReturns()->count();
        $completed_returns_count = $this->completedReturns()->count();
        $completed_scrapped_returns_count = $this->completedScrappedReturns()->count();
        $canceled_returns_count = $this->canceledReturns()->count();

        return view('admin.returns.index', compact('returns', 'pending_returns_count', 'all_returns_count', 'approved_returns_count', 'disapproved_returns_count', 'in_the_way_returns_count', 'return_denied_returns_count', 'completed_scrapped_returns_count', 'completed_returns_count', 'canceled_returns_count'));
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
     * @param  \App\Models\Return  $return
     */
    protected function reduceQuantities(Order $return) {
        foreach ($return->products as $product) {
            $quantity = WarehouseProduct::where('warehouse_id', $return->warehouse_id)->where('product_id', $product->id)->where('reduced_quantity', '>=', $product->min_sale_quantity)->where('reduced_quantity', '>=', $this->getRealQuantity($product))->first();
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
     * @param  \App\Models\Return  $return
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function shippingForm(Order $return)
    {
        if (auth()->user()->can('order.view', $return)) {
            $admins = Admin::active()->role('delivery')->get();
            return view('admin.orders.shippingForm', compact('order', 'admins'));
        }
        abort(403);
    }


    /**
     * shipping Order.
     *
     * @param  \App\Models\Return  $return
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function shipping(Request $request, Order $return)
    {
        $this->validate($request, [
            'delivery' => 'required|exists:admins,id',
            'comment' => 'nullable|string',
        ]);
        if (!$return->isShipped()) {
            $this->reduceQuantities($return);
        }
        $request['comment'] = str_replace('<', '&lt;', $request->comment);
        $request['comment'] = str_replace('>', '&gt;', $request->comment);
        $request['comment'] = nl2br($request->comment);
        $return->statuses()->create(
            [
                'name' => 'Shipped',
                'description' => $request->comment,
            ]
        );
        $return->delivery_id = $request->delivery;
        $return->shipping_date = Carbon::now();
        $return->save();
        return redirect()->route('orders.index', ['state'=>'shipped'])->with(['status' => __('Shipped Successfully')]);
    }

    /**
     * return Order product quantities.
     *
     * @param  \App\Models\Return  $return
     */
    protected function returnQuantities(Order $return) {
        foreach ($return->products as $product) {
            $quantity = WarehouseProduct::where('warehouse_id', $return->warehouse_id)->where('product_id', $product->id)->where('expiry_date', '>=', now())->first();
            if ($quantity) {
                $quantity->reduced_quantity += $this->getRealQuantity($product);
                $quantity->save();
            }
            $product->total_quantity = $product->quantities->sum(function($quantity) {
                return $quantity->reduced_quantity;
            });
            $product->save();
        }
    }
    
    /**
     * shipping returned Order.
     *
     * @param  \App\Models\Return  $return
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function shippingReturned(Request $request, Order $return)
    {
        if ($return->isShipped()) {
            $this->returnQuantities($return);
            $return->statuses()->create(
                [
                    'name' => 'Shipping returned',
                ]
            );
            return redirect()->route('orders.index', ['state'=>'shipped'])->with(['status' => __('Shipping returned Successfully')]);
        }
        abort(404);
    }
    
    /**
     * complete Order.
     *
     * @param  \App\Models\Return  $return
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function complete(Request $request, Order $return)
    {
        $return->user->sendOrderReviewNotification($return);
        $return->statuses()->create(
            [
                'name' => 'Completed',
            ]
        );
        return back()->with(['status' => __('Completed Successfully')]);
    }
    
    /**
     * disapprove Order.
     *
     * @param  \App\Models\Return  $return
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function disapprove(Request $request, Order $return)
    {
        $return->statuses()->create(
            ['name' => 'Disapproved',]
        );
        if ($return->isApproved()) {
            $return->statuses()->approved()->delete();
        }
        $this->markUserNotificationAsRead($return); 
        return redirect()->route('orders.index')->with(['status' => __('Disapproved Successfully')]);
    }

    /**
     * Check if products is available
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param \App\Models\Return $return
     */
    protected function isNotAvailable(Request $request, Order $return)
    {
        foreach ($return->products as $product) {
            if (!$product->isAvailableIn(warehouse::find($request->warehouse))) {
                return $product;
            }
        }
        return null;
    }

    /**
     * Approve Order.
     *
     * @param  \App\Models\Return  $return
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function approve(Request $request, Order $return)
    { 
        $this->validate($request, [
            'warehouse' => 'required|exists:warehouses,id',
            'comment' => 'nullable|string',
        ]);
        $product = $this->isNotAvailable($request, $return);
        if (!$product) {
            $request['comment'] = str_replace('<', '&lt;', $request->comment);
            $request['comment'] = str_replace('>', '&gt;', $request->comment);
            $request['comment'] = nl2br($request->comment);
            $return->warehouse_id = $request->warehouse;
            $return->save();
            if ($return->isDisapproved()) {
                $return->statuses()->disapproved()->delete();
            }
            $return->statuses()->create(
                [
                    'name' => 'Approved',
                    'description' => $request->comment,
                ]
            );
            $this->markUserNotificationAsRead($return); 
            return redirect()->route('orders.index')->with(['status' => __('Approved Successfully')]);
        }
        return back()->with(['error' => __('The product') . ' ' . $product->name . ' ' . __('is not available in this warehouse')]);
    }

    /**
     * Mark user notification as read
     * 
     * @param  \App\Models\Return  $return
     */
    protected function markUserNotificationAsRead(Order $return)
    {
        $notification = $return->user->unreadnotifications()->where('type', 'App\Notifications\User\OrderWillBeServedLaterNotification')->where('data->order_id', $return->id)->first();
        if ($notification) {
            $notification->markAsRead();
        }
    }
    

    /**
     * Display page for order approving.
     *
     * @param  \App\Models\Return  $return
     * @return \Illuminate\Http\Response
     */
    public function approveView(Order $return)
    {
        if (auth()->user()->can('order.view', $return)) {
            if (!$return->isShipped()) {
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
     * @param  \App\Models\Return  $return
     * @return \Illuminate\Http\Response
     */
    public function show(Order $return)
    {
        if (auth()->user()->can('order.view', $return)) {
            $price_tax = GeneralSetting::priceTax()->first();
            return view('admin.orders.show', compact('order', 'price_tax'));
        }
        abort(403);
    }
    
    /**
     * Display order invoice.
     *
     * @param  \App\Models\Return  $return
     * @return \Illuminate\Http\Response
     */
    public function invoice(Order $return)
    {
        if (auth()->user()->can('order.view', $return)) {
            $price_tax = GeneralSetting::priceTax()->first();
            return view('admin.orders.invoice', compact('order', 'price_tax'));
        }
        abort(403);
    }
    
    /**
     * Print order invoice.
     *
     * @param  \App\Models\Return  $return
     * @return \Illuminate\Http\Response
     */
    public function invoicePrint(Order $return)
    {
        if (auth()->user()->can('order.view', $return)) {
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
     * @param \App\Models\Return $return
     */
    protected function addOrderStatus(Order $return)
    {
        $return->statuses()->createMany([
            ['name' => 'Waiting for confirmation',],
            ['name' => 'Approved',]
        ]);
    }    
    
    /**
     * add order products
     * 
     * @param \App\Models\Return $return
     */
    protected function addOrderProducts(Request $request, Order $return)
    {
        $i = 0;
        foreach ($request->products as $product) {
            $return->products()->attach(
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
     * @return \App\Models\Return
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
     * @return \App\Models\Return
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
     * @return \App\Models\Return
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
            $return = $this->storeOrderDetails($request);
            $this->addOrderStatus($return);
            $this->addOrderProducts($request, $return);
            return back()->with(['status' => trans('Added Successfully')]);
        }
        return back()->with(['error' => __('You must order at least') . ' ' . $product->min_sale_quantity . ' ' . __('from') . ' ' . $product->name]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Return  $return
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $return)
    {
        // return view('admin.orders.edit', compact('Order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Return  $return
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $return)
    {
        // $this->validate($request, [
        //     'name' => 'required|string|min:2'
        // ]);
        // $return->name = $request->name;
        // $return->save();
        // return redirect()->route('orders.index')->with('status', trans('Updated Successfully'));
    }

    /**
     * Can delete all orders
     */
    protected function canDeleteAllOrders($returns)
    {
        foreach ($returns as $return) {
            if (!(!$return->isCanceled() && !$return->isShipped() && !$return->isDisapproved())) {
                return false;
            }
        }
        return true;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\Order  $return
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
        $returns = OrderReturn::find($request->orders);
        if ($this->canDeleteAllOrders($returns)) {
            OrderReturn::destroy($request->orders);
            return back()->with('status', trans('Deleted Successfully'));
        }
        return back()->with(['error' => 'You Can\'t delete these orders']);
    }
}
