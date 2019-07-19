<?php

namespace App\Models;

use App\User;
use App\Models\Product;
use App\Models\warehouse;
use App\Models\OrderStatus;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comment', 'user_address_id', 'total_price',
        'points', 'warehouse_id', 'shipping_price'
    ];

    /**
     * Get order products
     * 
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products', 'order_id', 'product_id')->active()->withPivot('quantity')->withTimestamps();
    }
    
    /**
     * Get order statuses
     * 
     */
    public function statuses()
    {
        return $this->hasMany(OrderStatus::class);
    }
    
    /**
     * Get order latest statuses
     * 
     */
    public function latestStatus()
    {
        return $this->hasOne(OrderStatus::class)->orderBy('id', 'desc');
    }

    /**
     * if order has approved status
     */
    public function isApproved()
    {
        return $this->statuses->where('name', 'Approved')->isNotEmpty();
    }
    
    /**
     * if order has decline status
     */
    public function isDeclined()
    {
        return $this->statuses->where('name', 'Declined')->isNotEmpty();
    }
    
    /**
     * if order has Shipped status
     */
    public function isShipped()
    {
        return $this->statuses->where('name', 'Shipped')->isNotEmpty();
    }
    
    /**
     * if order has Completed status
     */
    public function isCompleted()
    {
        return $this->statuses->where('name', 'Completed')->isNotEmpty();
    }
    
    /**
     * if order has Canceled status
     */
    public function isCanceled()
    {
        return $this->statuses->where('name', 'Canceled')->isNotEmpty();
    }
    
    /**
     * Get order address
     * 
     */
    public function address()
    {
        return $this->belongsTo(UserAddress::class, 'user_address_id');
    }
    
    /**
     * Get order User
     * 
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get order warehouse
     */
    public function warehouse()
    {
        return $this->belongsTo(warehouse::class);
    }
}
