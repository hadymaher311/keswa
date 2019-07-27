<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderReturn;
use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use App\Http\Controllers\Controller;

class ReturnsController extends Controller
{
    /**
     * Display user returns.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.returns.index');
    }
    
    /**
     * Display user return details.
     *
     * @param \App\Models\OrderReturn $return
     * @return \Illuminate\Http\Response
     */
    public function details(OrderReturn $return)
    {
        if ($return->user_id == auth()->id()) {
            return view('user.returns.details', compact('return'));
        }
        abort(403);
    }

    /**
     * add waiting status for return
     * 
     * @param \App\Models\OrderReturn $return
     */
    protected function addPendingStatus(OrderReturn $return)
    {
        $return->statuses()->create([
            'name' => 'Waiting for confirmation',
        ]);
    }

    /**
     * check if return has been placed earlier
     * @param \App\Models\Order $order
     * @param \App\Models\Product $product
     * @return bool
     */
    protected function isHasBeenPlaced(Order $order, Product $product)
    {
        return (OrderReturn::where('user_id', auth()->id())->where('order_id', $order->id)->where('product_id', $product->id)->first()) ? true : false;
    }

    /**
     * is in working hours
     * 
     * @return bool
     */
    protected function inWorkingHours()
    {
        return Carbon::now()->greaterThanOrEqualTo(new Carbon(GeneralSetting::workingHoursFrom()->first()->value)) && Carbon::now()->lessThanOrEqualTo(new Carbon(GeneralSetting::workingHoursTo()->first()->value));
    }
    
    /**
     * Confirm order product return
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order $order
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function confirm(Request $request, Order $order, Product $product)
    {
        if ($order->products->contains($product) && $order->user_id == auth()->id()) {
            if (!$this->isHasBeenPlaced($order, $product)) {
                $this->validate($request, [
                    'quantity' => 'required|integer|min:1|max:' . $order->products->find($product)->pivot->quantity,
                ]);
                $return = auth()->user()->returns()->create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'user_address_id' => $order->user_address_id,
                    'warehouse_id' => $order->warehouse_id,
                    'quantity' => $request->quantity,
                ]);
                $this->addPendingStatus($return);
                if (!$this->inWorkingHours()) {
                    auth()->user()->sendReturnWillBeServedLaterNotification($return);
                }
                return redirect()->route('user.returns')->with(['status' => 'Added Successfully']);
            }
            return back()->with(['error' => 'This return has been placed earlier']);
        }
        abort(403);
    }
}
