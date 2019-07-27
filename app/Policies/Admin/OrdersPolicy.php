<?php

namespace App\Policies\Admin;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Admin;
use App\Models\Order;

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
     * View order for only some admins
     */
    public function view(Admin $admin, Order $order)
    {
        foreach ($admin->warehouses as $warehouse) {
            if ($warehouse->id == $order->warehouse_id) {
                return true;
            }
        }
        return false;
    }

    /**
     * update order for only some admins
     */
    public function update(Admin $admin, Order $order)
    {
        foreach ($admin->warehouses as $warehouse) {
            if ($warehouse->id == $order->warehouse_id) {
                if (!$order->isCanceled() && !$order->isShipped() && !$order->isDisapproved()) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * delete order for only some admins
     */
    public function delete(Admin $admin, Order $order)
    {
        foreach ($admin->warehouses as $warehouse) {
            if ($warehouse->id == $order->warehouse_id) {
                if (!$order->isCanceled() && !$order->isShipped() && !$order->isDisapproved()) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Approve order
     */
    public function approve(Admin $admin, Order $order)
    {
        if (!$order->isShipped() && !$order->isCanceled()) {
            return true;
        }
        return false;
    }

    /**
     * shipping order
     */
    public function shipping(Admin $admin, Order $order)
    {
        if ($order->isApproved() && !$order->isCanceled() && !$order->isCompleted() && !$order->isShippingReturned()) {
            return true;
        }
        return false;
    }

    /**
     * shipping return order
     */
    public function shipping_return(Admin $admin, Order $order)
    {
        if ($order->isApproved() && !$order->isCanceled() && !$order->isCompleted() && !$order->isShippingReturned() && $order->isShipped()) {
            return true;
        }
        return false;
    }

    /**
     * complete order
     */
    public function complete(Admin $admin, Order $order)
    {
        if ($order->isApproved() && !$order->isCanceled() && $order->isShipped() && !$order->isShippingReturned()) {
            return true;
        }
        return false;
    }
}
