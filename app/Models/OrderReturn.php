<?php

namespace App\Models;

use App\User;
use App\Models\Product;
use App\Models\ReturnStatus;
use Illuminate\Database\Eloquent\Model;

class OrderReturn extends Model
{
    /**
     * Table name because return string is perserved word
     */
    protected $table = 'returns';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comment', 'quantity', 'user_address_id', 'warehouse_id', 'user_id', 'delivery_id', 'return_id', 'product_id', 'order_id'
    ];

    /**
     * Get return products
     * 
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get return order
     * 
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    
    /**
     * Get return statuses
     * 
     */
    public function statuses()
    {
        return $this->hasMany(ReturnStatus::class, 'return_id');
    }
    
    /**
     * Get return latest statuses
     * 
     */
    public function latestStatus()
    {
        return $this->hasOne(ReturnStatus::class, 'return_id')->orderBy('id', 'desc');
    }

    /**
     * if return has approved status
     */
    public function isApproved()
    {
        return $this->statuses->where('name', 'Approved')->isNotEmpty();
    }
    
    /**
     * if return has disapproved status
     */
    public function isDisapproved()
    {
        return $this->statuses->where('name', 'Disapproved')->isNotEmpty();
    }
    
    /**
     * if return has in the way status
     */
    public function isInTheWay()
    {
        return $this->statuses->where('name', 'In the way')->isNotEmpty();
    }
    
    /**
     * if return has Completed status
     */
    public function isCompleted()
    {
        return $this->statuses->where('name', 'Completed')->isNotEmpty();
    }
    
    /**
     * if return has Completed Scrapped status
     */
    public function isCompletedScrapped()
    {
        return $this->statuses->where('name', 'Completed scrapped')->isNotEmpty();
    }
    
    /**
     * if return has Canceled status
     */
    public function isCanceled()
    {
        return $this->statuses->where('name', 'Canceled')->isNotEmpty();
    }
    
    /**
     * if return has Return denied status
     */
    public function isreturnDenied()
    {
        return $this->statuses->where('name', 'Return denied')->isNotEmpty();
    }
    
    /**
     * Get return address
     * 
     */
    public function address()
    {
        return $this->belongsTo(UserAddress::class, 'user_address_id');
    }
    
    /**
     * Get return User
     * 
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get return warehouse
     */
    public function warehouse()
    {
        return $this->belongsTo(warehouse::class);
    }
    
    /**
     * Get return delivery man
     */
    public function delivery()
    {
        return $this->belongsTo(Admin::class);
    }
}
