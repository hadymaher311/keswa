<?php

namespace App\Policies\POS;

use App\Models\POSWorker;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\POSOrder;

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
}
