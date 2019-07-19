<?php

namespace App\Policies\Admin;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\warehouse;
use App\Models\Admin;

class WarehousesPolicy
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
     * View warehouse for only some admins
     */
    public function view(Admin $admin, warehouse $warehouse)
    {
        foreach ($admin->warehouses as $ware) {
            if ($ware->id == $warehouse->id) {
                return true;
            }
        }
        return false;
    }
}
