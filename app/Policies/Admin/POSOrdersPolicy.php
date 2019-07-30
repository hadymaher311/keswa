<?php

namespace App\Policies\Admin;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\POSOrder;

class POSOrdersPolicy
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
    public function view(Admin $admin, POSOrder $order)
    {
        foreach ($admin->warehouses as $warehouse) {
            if ($warehouse->id == $order->warehouse_id) {
                return true;
            }
        }
        return false;
    }
}
