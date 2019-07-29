<?php

namespace App\Models;

use App\Models\Admin;
use App\Models\Order;
use App\Models\Product;
use App\Models\POSWorker;
use App\Models\WarehouseProduct;
use App\Helpers\LocalizableModel;
use App\Models\WarehouseRelatedLocation;

class warehouse extends LocalizableModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_en', 'name_ar',
        'location_en', 'location_ar',
        'shipping_price'
    ];
 
    /**
     * Localized attributes.
     *
     * @var array
     */
    protected $localizable = [
        'name',
        'location'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    /**
     * Get warehouse related locations
     */
    public function related_locations()
    {
        return $this->hasMany(WarehouseRelatedLocation::class, 'warehouse_id');
    }

    /**
     * Get warehouse products
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'warehouse_products');
    }

    /**
     * get warehouse admins
     */
    public function admins()
    {
        return $this->belongsToMany(Admin::class, 'admin_warehouses');
    }
    
    /**
     * Get warehouse products quantities
     */
    public function product_quantities()
    {
        return $this->hasMany(WarehouseProduct::class, 'warehouse_id');
    }

    /**
     * Get warehouse orders
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get warehouse worker
     */
    public function worker()
    {
        return $this->hasMany(POSWorker::class);
    }
}
