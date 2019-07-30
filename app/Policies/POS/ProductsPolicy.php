<?php

namespace App\Policies\POS;

use App\Models\Product;
use App\Models\POSWorker;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductsPolicy
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
     * View product for only some workers
     */
    public function view(POSWorker $worker, Product $product)
    {
        return $product->isAvailableIn($worker->pos);
    }
}
