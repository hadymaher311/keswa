<?php

namespace App\Policies\Admin;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\OrderReturn;
use App\Models\Admin;

class ReturnsPolicy
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
     * View return for only some admins
     */
    public function view(Admin $admin, OrderReturn $return)
    {
        foreach ($admin->warehouses as $warehouse) {
            if ($warehouse->id == $return->warehouse_id) {
                return true;
            }
        }
        return false;
    }

    /**
     * update return for only some admins
     */
    public function update(Admin $admin, OrderReturn $return)
    {
        foreach ($admin->warehouses as $warehouse) {
            if ($warehouse->id == $return->warehouse_id) {
                if (!$return->isCanceled() && !$return->isInTheWay() && !$return->isDisapproved()) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * delete return for only some admins
     */
    public function delete(Admin $admin, OrderReturn $return)
    {
        foreach ($admin->warehouses as $warehouse) {
            if ($warehouse->id == $return->warehouse_id) {
                if (!$return->isCanceled() && !$return->isInTheWay() && !$return->isDisapproved()) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Approve return
     */
    public function approve(Admin $admin, OrderReturn $return)
    {
        if (!$return->isInTheWay() && !$return->isCanceled()) {
            return true;
        }
        return false;
    }

    /**
     * in_the_way return
     */
    public function in_the_way(Admin $admin, OrderReturn $return)
    {
        if ($return->isApproved() && !$return->isCanceled() && !$return->isCompleted() && !$return->isReturnDebied()) {
            return true;
        }
        return false;
    }

    /**
     * return_denied return
     */
    public function return_denied(Admin $admin, OrderReturn $return)
    {
        if ($return->isApproved() && !$return->isCanceled() && !$return->isCompleted() && !$return->isReturnDebied() && $return->isInTheWay()) {
            return true;
        }
        return false;
    }

    /**
     * complete return
     */
    public function complete(Admin $admin, OrderReturn $return)
    {
        if ($return->isApproved() && !$return->isCanceled() && $return->isInTheWay() && !$return->isReturnDebied()) {
            return true;
        }
        return false;
    }
}
