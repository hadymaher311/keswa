<?php

namespace App\Models;

use App\Models\Product;
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
        'comment', 'user_address_id', 'total_price'
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
}
