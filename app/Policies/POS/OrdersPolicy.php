<?php

namespace App\Policies\POS;

use App\Models\POSOrder;
use App\Models\POSWorker;
use App\Models\GeneralSetting;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrdersPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * View order for only some workers
     */
    public function view(POSWorker $worker, POSOrder $order)
    {
        return $order->warehouse_id == $worker->warehouse_id;
    }

    /**
     * Approve order for only some workers
     */
    public function approve(POSWorker $worker, POSOrder $order)
    {
        return $order->worker_id == $worker->id;
    }

    /**
     * delete order for only some workers
     */
    public function delete(POSWorker $worker, POSOrder $order)
    {
        return ($order->worker_id == $worker->id && !$order->isCompleted());
    }

    /**
     * update order for only some workers
     */
    public function update(POSWorker $worker, POSOrder $order)
    {
        $update_pos_orders = GeneralSetting::updatePOSOrders()->first();
        return ($order->worker_id == $worker->id && $update_pos_orders->value == 1);
    }
}
