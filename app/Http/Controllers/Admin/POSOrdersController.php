<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\POSOrder;
use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use App\Http\Controllers\Controller;

class POSOrdersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
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
                return $this->allOrders();
        }
    }

    /**
     * Get pending orders
     * 
     * @return \App\Models\Order
     */
    protected function pendingOrders()
    {
        return POSOrder::whereHas('warehouse.admins', function($admin) {
            return $admin->where('admins.id', auth()->id());
        })->orderBy('id', 'desc')->with('latestStatus')->get()->filter(function ($order) {
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
        return POSOrder::whereHas('warehouse.admins', function($admin) {
            return $admin->where('admins.id', auth()->id());
        })->orderBy('id', 'desc')->with('latestStatus')->get()->filter(function ($order) {
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
        return POSOrder::whereHas('warehouse.admins', function($admin) {
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
                return POSOrder::whereHas('warehouse.admins', function($admin) {
            return $admin->where('admins.id', auth()->id());
        })->orderBy('id', 'desc')->whereBetween('created_at', [$request->from, $request->to])->get();
            }
        } else {
            return POSOrder::whereHas('warehouse.admins', function($admin) {
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
        $completed_orders_count = $this->completedOrders()->count();

        return view('admin.pos.orders.index', compact('orders', 'pending_orders_count', 'all_orders_count', 'completed_orders_count'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\POSOrder  $order
     * @return \Illuminate\Http\Response
     */
    public function show(POSOrder $order)
    {
        if (auth()->user()->can('admin.pos_order.view', $order)) {
            $price_tax = GeneralSetting::priceTax()->first();
            return view('admin.pos.orders.show', compact('order', 'price_tax'));
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
        if (auth()->user()->can('admin.pos_order.view', $order)) {
            $price_tax = GeneralSetting::priceTax()->first();
            return view('admin.pos.orders.invoice', compact('order', 'price_tax'));
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
        if (auth()->user()->can('admin.pos_order.view', $order)) {
            $price_tax = GeneralSetting::priceTax()->first();
            return view('admin.pos.orders.invoicePrint', compact('order', 'price_tax'));
        }
        abort(403);
    }

}
