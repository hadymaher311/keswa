<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /**
         * admin Order policies
         */
        Gate::define('order.view', 'App\Policies\Admin\OrdersPolicy@view');
        Gate::define('order.update', 'App\Policies\Admin\OrdersPolicy@update');
        Gate::define('order.delete', 'App\Policies\Admin\OrdersPolicy@delete');
        Gate::define('order.approve', 'App\Policies\Admin\OrdersPolicy@approve');
        Gate::define('order.shipping', 'App\Policies\Admin\OrdersPolicy@shipping');
        Gate::define('order.shipping_return', 'App\Policies\Admin\OrdersPolicy@shipping_return');
        Gate::define('order.complete', 'App\Policies\Admin\OrdersPolicy@complete');
        /**
         * admin POS Order policies
         */
        Gate::define('admin.pos_order.view', 'App\Policies\Admin\POSOrdersPolicy@view');
        /**
         * admin return policies
         */
        Gate::define('return.view', 'App\Policies\Admin\ReturnsPolicy@view');
        Gate::define('return.update', 'App\Policies\Admin\ReturnsPolicy@update');
        Gate::define('return.delete', 'App\Policies\Admin\ReturnsPolicy@delete');
        Gate::define('return.approve', 'App\Policies\Admin\ReturnsPolicy@approve');
        Gate::define('return.in_the_way', 'App\Policies\Admin\ReturnsPolicy@in_the_way');
        Gate::define('return.return_denied', 'App\Policies\Admin\ReturnsPolicy@return_denied');
        Gate::define('return.complete', 'App\Policies\Admin\ReturnsPolicy@complete');
        
        /**
         * Worker order policies
         */
        Gate::define('pos_order.approve', 'App\Policies\POS\OrdersPolicy@approve');
        Gate::define('pos_order.view', 'App\Policies\POS\OrdersPolicy@view');
        Gate::define('pos_order.delete', 'App\Policies\POS\OrdersPolicy@delete');
        Gate::define('pos_order.update', 'App\Policies\POS\OrdersPolicy@update');
        /**
         * Worker product policies
         */
        Gate::define('pos.product.view', 'App\Policies\POS\ProductsPolicy@view');
        
        Gate::define('warehouse.view', 'App\Policies\Admin\WarehousesPolicy@view');        
    }
}
