<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\OrderReturn;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Admin;
use App\Models\WarehouseProduct;
use App\Models\GeneralSetting;

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
            
            case 'completed_scrapped':
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
            return $return->latestStatus->name == 'Return denied';
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
     * in the way Return form.
     *
     * @param  \App\Models\OrderReturn  $return
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function inTheWayForm(OrderReturn $return)
    {
        if (auth()->user()->can('return.view', $return)) {
            $admins = Admin::active()->role('delivery')->get();
            return view('admin.returns.inTheWayForm', compact('return', 'admins'));
        }
        abort(403);
    }


    /**
     * in the way return.
     *
     * @param  \App\Models\OrderReturn  $return
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function intheway(Request $request, OrderReturn $return)
    {
        $this->validate($request, [
            'delivery' => 'required|exists:admins,id',
            'comment' => 'nullable|string',
        ]);
        $request['comment'] = str_replace('<', '&lt;', $request->comment);
        $request['comment'] = str_replace('>', '&gt;', $request->comment);
        $request['comment'] = nl2br($request->comment);
        $return->statuses()->create(
            [
                'name' => 'In the way',
                'description' => $request->comment,
            ]
        );
        $return->delivery_id = $request->delivery;
        $return->save();
        return redirect()->route('returns.index', ['state'=>'in_the_way'])->with(['status' => __('Updated Successfully')]);
    }
    
    /**
     * returnDenied return.
     *
     * @param  \App\Models\OrderReturn  $return
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function returnDenied(Request $request, OrderReturn $return)
    {
        if (auth()->user()->can('return.return_denied', $return)) {
            $return->statuses()->create(
                [
                    'name' => 'Return denied',
                ]
            );
            return redirect()->route('returns.index', ['state'=>'return_denied'])->with(['status' => __('Updated Successfully')]);
        }
        abort(403);
    }
    
    /**
     * return Order product quantities.
     *
     * @param  \App\Models\OrderReturn  $return
     */
    protected function returnQuantities(OrderReturn $return) {
        $quantity = WarehouseProduct::where('warehouse_id', $return->warehouse_id)->where('product_id', $return->product->id)->where('expiry_date', '>=', now())->first();
        if ($quantity) {
            $quantity->reduced_quantity += $this->getRealQuantity($return->product);
            $quantity->save();
        }
        $return->product->total_quantity = $return->product->quantities->sum(function($quantity) {
            return $quantity->reduced_quantity;
        });
        $return->product->save();
    }
    
    /**
     * complete Order.
     *
     * @param  \App\Models\OrderReturn  $return
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function complete(Request $request, OrderReturn $return)
    {
        $this->returnQuantities($return);
        $return->statuses()->create(
            [
                'name' => 'Completed',
            ]
        );
        return redirect()->route('returns.index', ['state' => 'completed'])->with(['status' => __('Completed Successfully')]);
    }
    
    /**
     * return Order product scrapped quantities.
     *
     * @param  \App\Models\OrderReturn  $return
     */
    protected function returnScrappedQuantities(OrderReturn $return) {
        $quantity = WarehouseProduct::where('warehouse_id', $return->warehouse_id)->where('product_id', $return->product->id)->where('expiry_date', '>=', now())->first();
        if ($quantity) {
            $quantity->scrapped_quantity += $this->getRealQuantity($return->product);
            $quantity->save();
        }
    }
    
    /**
     * complete scrapped Order.
     *
     * @param  \App\Models\OrderReturn  $return
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function completeScrape(Request $request, OrderReturn $return)
    {
        $this->returnScrappedQuantities($return);
        $return->statuses()->create(
            [
                'name' => 'Completed scrapped',
            ]
        );
        return redirect()->route('returns.index', ['state' => 'completed_scrapped'])->with(['status' => __('Completed Successfully')]);
    }
    
    /**
     * disapprove Order.
     *
     * @param  \App\Models\OrderReturn  $return
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function disapprove(Request $request, OrderReturn $return)
    {
        $return->statuses()->create(
            ['name' => 'Disapproved',]
        );
        if ($return->isApproved()) {
            $return->statuses()->approved()->delete();
        }
        $this->markUserNotificationAsRead($return); 
        return redirect()->route('returns.index', ['state' => 'disapproved'])->with(['status' => __('Disapproved Successfully')]);
    }

    /**
     * Approve Order.
     *
     * @param  \App\Models\OrderReturn  $return
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function approve(Request $request, OrderReturn $return)
    {
        if ($return->isDisapproved()) {
            $return->statuses()->disapproved()->delete();
        }
        $return->statuses()->create(
            [
                'name' => 'Approved',
            ]
        );
        $this->markUserNotificationAsRead($return); 
        return redirect()->route('returns.index', ['state' => 'approved'])->with(['status' => __('Approved Successfully')]);
    }

    /**
     * Mark user notification as read
     * 
     * @param  \App\Models\OrderReturn  $return
     */
    protected function markUserNotificationAsRead(OrderReturn $return)
    {
        $notification = $return->user->unreadNotifications()->where('type', 'App\Notifications\User\ReturnWillBeServedLaterNotification')->where('data->return_id', $return->id)->first();
        if ($notification) {
            $notification->markAsRead();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderReturn  $return
     * @return \Illuminate\Http\Response
     */
    public function show(OrderReturn $return)
    {
        if (auth()->user()->can('return.view', $return)) {
            $price_tax = GeneralSetting::priceTax()->first();
            return view('admin.returns.show', compact('return', 'price_tax'));
        }
        abort(403);
    }
    
    /**
     * Display return invoice.
     *
     * @param  \App\Models\OrderReturn  $return
     * @return \Illuminate\Http\Response
     */
    public function invoice(OrderReturn $return)
    {
        if (auth()->user()->can('return.view', $return)) {
            $price_tax = GeneralSetting::priceTax()->first();
            return view('admin.returns.invoice', compact('return', 'price_tax'));
        }
        abort(403);
    }
    
    /**
     * Print return invoice.
     *
     * @param  \App\Models\OrderReturn  $return
     * @return \Illuminate\Http\Response
     */
    public function invoicePrint(OrderReturn $return)
    {
        if (auth()->user()->can('return.view', $return)) {
            $price_tax = GeneralSetting::priceTax()->first();
            return view('admin.returns.invoicePrint', compact('return', 'price_tax'));
        }
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrderReturn  $return
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderReturn $return)
    {
        // return view('admin.orders.edit', compact('Order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrderReturn  $return
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderReturn $return)
    {
        // $this->validate($request, [
        //     'name' => 'required|string|min:2'
        // ]);
        // $return->name = $request->name;
        // $return->save();
        // return redirect()->route('orders.index')->with('status', trans('Updated Successfully'));
    }

    /**
     * Can delete all returns
     */
    protected function canDeleteAllReturns($returns)
    {
        foreach ($returns as $return) {
            if (!auth()->user()->can('return.delete', $return)) {
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
        if (!$request->returns) {
            return back();
        }
        $this->validate($request, [
            'returns.*' => 'required|exists:returns,id',
        ]);
        $returns = OrderReturn::find($request->returns);
        if ($this->canDeleteAllReturns($returns)) {
            OrderReturn::destroy($request->returns);
            return back()->with('status', trans('Deleted Successfully'));
        }
        return back()->with(['error' => 'You Can\'t delete these returns']);
    }
}
