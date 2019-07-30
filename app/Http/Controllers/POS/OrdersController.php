<?php

namespace App\Http\Controllers\POS;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\POSOrder;
use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use App\Models\WarehouseProduct;
use App\Http\Controllers\Controller;
use App\Http\Requests\POS\Orders\CreateRequest;

class OrdersController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:pos');
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

            case 'completed':
                return $this->completedOrders();
            
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
        return POSOrder::where('warehouse_id', auth()->user()->warehouse_id)->orderBy('id', 'desc')->with('latestStatus')->get()->filter(function ($order) {
            return $order->latestStatus->name == 'Waiting for confirmation';
        });
    }
    
    /**
     * Get completed orders
     * 
     * @return \App\Models\Order
     */
    protected function completedOrders()
    {
        return POSOrder::where('warehouse_id', auth()->user()->warehouse_id)->orderBy('id', 'desc')->with('latestStatus')->get()->filter(function ($order) {
            return $order->latestStatus->name == 'Completed';
        });
    }
    
    /**
     * Get all orders
     * 
     * @return \App\Models\Order
     */
    protected function allOrders()
    {
        return POSOrder::where('warehouse_id', auth()->user()->warehouse_id)->orderBy('id', 'desc')->get();
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
                return POSOrder::where('warehouse_id', auth()->user()->warehouse_id)->orderBy('id', 'desc')->whereBetween('created_at', [$request->from, $request->to])->get();
            }
        } else {
            return POSOrder::where('warehouse_id', auth()->user()->warehouse_id)->orderBy('id', 'desc')->whereBetween('created_at', [Carbon::today(), Carbon::tomorrow()])->get();
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
        $completed_orders_count = $this->completedOrders()->count();

        return view('pos.orders.index', compact('orders', 'pending_orders_count', 'all_orders_count', 'completed_orders_count'));
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
     * @param  \App\Models\POSOrder  $order
     */
    protected function reduceQuantities(POSOrder $order) {
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
     * return Order product quantities.
     *
     * @param  \App\Models\POSOrder  $order
     */
    protected function returnQuantities(POSOrder $order) {
        foreach ($order->products as $product) {
            $quantity = WarehouseProduct::where('warehouse_id', $order->warehouse_id)->where('product_id', $product->id)->where('expiry_date', '>=', now())->first();
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
     * complete pos_Order.
     *
     * @param  \App\Models\POSOrder  $order
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function complete(Request $request, POSOrder $order)
    {
        $this->reduceQuantities($order);
        $request['comment'] = str_replace('<', '&lt;', $request->comment);
        $request['comment'] = str_replace('>', '&gt;', $request->comment);
        $request['comment'] = nl2br($request->comment);
        $order->statuses()->create(
            [
                'name' => 'Completed',
                'description' => $request->comment
            ]
        );
        return redirect()->route('pos_orders.invoice', $order->id)->with(['status' => __('Completed Successfully')]);
    }
    
    /**
     * Check if products is available
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param \App\Models\Order $order
     */
    protected function isNotAvailable(Request $request, Order $order)
    {
        foreach ($order->products as $product) {
            if (!$product->isAvailableIn(warehouse::find($request->warehouse))) {
                return $product;
            }
        }
        return null;
    }

    /**
     * Approve pos_Order.
     *
     * @param  \App\Models\POSOrder  $order
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function approve(Request $request, Order $order)
    { 
        $this->validate($request, [
            'warehouse' => 'required|exists:warehouses,id',
            'comment' => 'nullable|string',
        ]);
        $product = $this->isNotAvailable($request, $order);
        if (!$product) {
            $request['comment'] = str_replace('<', '&lt;', $request->comment);
            $request['comment'] = str_replace('>', '&gt;', $request->comment);
            $request['comment'] = nl2br($request->comment);
            $order->warehouse_id = $request->warehouse;
            $order->save();
            if ($order->isDisapproved()) {
                $order->statuses()->disapproved()->delete();
            }
            $order->statuses()->create(
                [
                    'name' => 'Approved',
                    'description' => $request->comment,
                ]
            );
            $this->markUserNotificationAsRead($order); 
            return redirect()->route('orders.index')->with(['status' => __('Approved Successfully')]);
        }
        return back()->with(['error' => __('The product') . ' ' . $product->name . ' ' . __('is not available in this warehouse')]);
    }
    

    /**
     * Display page for order approving.
     *
     * @param  \App\Models\POSOrder  $order
     * @return \Illuminate\Http\Response
     */
    public function approveView(POSOrder $order)
    {
        if (auth()->user()->can('pos_order.approve', $order)) {
            $price_tax = GeneralSetting::priceTax()->first();
            return view('pos.orders.approve', compact('order', 'price_tax', 'warehouses'));
        }
        abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\POSOrder  $order
     * @return \Illuminate\Http\Response
     */
    public function show(POSOrder $order)
    {
        if (auth()->user()->can('pos_order.view', $order)) {
            $price_tax = GeneralSetting::priceTax()->first();
            return view('pos.orders.show', compact('order', 'price_tax'));
        }
        abort(403);
    }
    
    /**
     * Display order invoice.
     *
     * @param  \App\Models\POSOrder  $order
     * @return \Illuminate\Http\Response
     */
    public function invoice(POSOrder $order)
    {
        if (auth()->user()->can('pos_order.view', $order)) {
            $price_tax = GeneralSetting::priceTax()->first();
            return view('pos.orders.invoice', compact('order', 'price_tax'));
        }
        abort(403);
    }
    
    /**
     * Print order invoice.
     *
     * @param  \App\Models\POSOrder  $order
     * @return \Illuminate\Http\Response
     */
    public function invoicePrint(POSOrder $order)
    {
        if (auth()->user()->can('pos_order.view', $order)) {
            $price_tax = GeneralSetting::priceTax()->first();
            return view('pos.orders.invoicePrint', compact('order', 'price_tax'));
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
        $products = auth()->user()->pos->activeProducts;
        return view('pos.orders.create', compact('products'));
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
     * @param \App\Models\POSOrder $order
     */
    protected function addOrderStatus(POSOrder $order)
    {
        $order->statuses()->create(
            ['name' => 'Waiting for confirmation',]
        );
    }    
    
    /**
     * add order products
     * 
     * @param \App\Models\POSOrder $order
     */
    protected function addOrderProducts(Request $request, POSOrder $order)
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
     * @return \App\Models\POSOrder
     */
    protected function storeOrderDetails(Request $request)
    {
        return auth()->user()->orders()->create([
            'comment' => $request->comment,
            'total_price' => $this->getTotalPrice($request),
            'warehouse_id' => auth()->user()->pos->id,
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
     * @param  \App\Http\Requests\POS\Orders\CreateRequest  $request
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
            return redirect()->route('pos_orders.approve', $order->id)->with(['status' => trans('Added Successfully')]);
        }
        return back()->with(['error' => __('You must order at least') . ' ' . $product->min_sale_quantity . ' ' . __('from') . ' ' . $product->name]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\POSOrder  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        // return view('pos.orders.edit', compact('Order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\POSOrder  $order
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
        $orders = POSOrder::find($request->orders);
        if ($this->canDeleteAllOrders($orders)) {
            POSOrder::destroy($request->orders);
            return back()->with('status', trans('Deleted Successfully'));
        }
        return back()->with(['error' => 'You Can\'t delete these orders']);
    }
}
