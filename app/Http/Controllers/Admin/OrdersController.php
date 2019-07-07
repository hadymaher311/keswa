<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        return Order::orderBy('created_at', 'desc')->whereHas('statuses', function ($query) {
            $query->pending();
        })->get();
    }
    
    /**
     * Get approved orders
     * 
     * @return \App\Models\Order
     */
    protected function approvedOrders()
    {
        return Order::orderBy('created_at', 'desc')->whereHas('statuses', function ($query) {
            $query->approved();
        })->get();
    }
    
    /**
     * Get completed orders
     * 
     * @return \App\Models\Order
     */
    protected function completedOrders()
    {
        return Order::orderBy('created_at', 'desc')->whereHas('statuses', function ($query) {
            $query->completed();
        })->get();
    }
    
    /**
     * Get shipped orders
     * 
     * @return \App\Models\Order
     */
    protected function shippedOrders()
    {
        return Order::orderBy('created_at', 'desc')->whereHas('statuses', function ($query) {
            $query->shipped();
        })->get();
    }
    
    /**
     * Get canceled orders
     * 
     * @return \App\Models\Order
     */
    protected function canceledOrders()
    {
        return Order::orderBy('created_at', 'desc')->whereHas('statuses', function ($query) {
            $query->canceled();
        })->get();
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
        // return $request->all();
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.orders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|min:2'
        ]);
        return back()->with(['status' => trans('Added Successfully')]);
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
