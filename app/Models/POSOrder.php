<?php

namespace App\Models;

use App\Models\Product;
use App\Models\POSWorker;
use App\Models\warehouse;
use App\Models\POSOrderStatus;
use Illuminate\Database\Eloquent\Model;

class POSOrder extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comment', 'total_price', 'warehouse_id', 'worker_id'
    ];

    /**
     * Get order products
     * 
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'p_o_s_order_products', 'order_id', 'product_id')->withPivot('quantity')->withTimestamps();
    }
    
    /**
     * Get order statuses
     * 
     */
    public function statuses()
    {
        return $this->hasMany(POSOrderStatus::class, 'order_id');
    }
    
    /**
     * Get order latest statuses
     * 
     */
    public function latestStatus()
    {
        return $this->hasOne(POSOrderStatus::class, 'order_id')->orderBy('id', 'desc');
    }
    
    /**
     * if order has Completed status
     */
    public function isCompleted()
    {
        return $this->statuses->where('name', 'Completed')->isNotEmpty();
    }
    
    /**
     * Get order warehouse
     */
    public function warehouse()
    {
        return $this->belongsTo(warehouse::class);
    }
    
    /**
     * Get order worker
     */
    public function worker()
    {
        return $this->belongsTo(POSWorker::class, 'worker_id');
    }
}
