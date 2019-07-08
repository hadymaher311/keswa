<?php

namespace App\Models;

use App\User;
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
    
    /**
     * Get order latest statuses
     * 
     */
    public function latestStatus()
    {
        return $this->hasOne(OrderStatus::class)->orderBy('id', 'desc');
    }

    public function scopePending($query)
    {
        return $query->whereHas('latestStatus', function($status) {
            $status->where('name','Waiting for confirmation');
        });
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
}
