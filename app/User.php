<?php

namespace App;

use App\Models\Order;
use App\Models\Review;
use App\Models\Product;
use App\Models\UserAddress;
use App\Models\UserPersonalInfo;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use App\Notifications\User\OrderReviewNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\User\OrderWillBeServedLaterNotification;

class User extends Authenticatable implements MustVerifyEmail, HasMedia
{
    use Notifiable;
    use HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'added_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'active' => 'boolean'
    ];
    
    /**
     * The function to return Full name.
     *
     */
    public function getNameAttribute()
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }

    /**
     * The function to return Image url.
     *
     */
    public function getImageAttribute()
    {
        return $this->getMedia('user.avatar')->last();
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('card')
              ->width(368)
              ->height(232);
        $this->addMediaConversion('thumb')
              ->width(100)
              ->height(100);
    }

    /**
     * make order will be served later notification
     */
    public function sendOrderWillBeServedLaterNotification(Order $order)
    {
        $this->notify(new OrderWillBeServedLaterNotification($order));
    }
    
    /**
     * send email for order review
     */
    public function sendOrderReviewNotification(Order $order)
    {
        $this->notify(new OrderReviewNotification($order));
    }

    /**
     * Get user personal info
     * 
     */
    public function personalInfo()
    {
        return $this->hasOne(UserPersonalInfo::class);
    }
    
    /**
     * Get user addresses
     * 
     */
    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }
    
    /**
     * Get user cart
     * 
     */
    public function cart()
    {
        return $this->belongsToMany(Product::class, 'users_carts', 'user_id', 'product_id')->active()->withPivot('quantity')->withTimestamps();
    }
    
    /**
     * Get user wishlist
     * 
     */
    public function wishlist()
    {
        return $this->belongsToMany(Product::class, 'users_wishlists', 'user_id', 'product_id')->active()->withTimestamps();
    }

    /**
     * The function to return cart total price.
     *
     */
    public function getCartTotalPriceAttribute()
    {
        return ($this->cart->count()) ? $this->cart->sum(function($cart) {
            return $cart->final_price * $cart->pivot->quantity;
          }) : 0;
    }
    
    /**
     * The function to return cart total points.
     *
     */
    public function getCartTotalPointsAttribute()
    {
        return ($this->cart->count()) ? $this->cart->sum(function($cart) {
            return $cart->points * $cart->pivot->quantity;
          }) : 0;
    }

    /**
     * Get user reviews
     * 
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    
    /**
     * Get user approved reviews
     * 
     */
    public function approvedReviews()
    {
        return $this->hasMany(Review::class)->approved();
    }
    
    /**
     * Get user not approved reviews
     * 
     */
    public function notApprovedReviews()
    {
        return $this->hasMany(Review::class)->where('approved', 0);
    }

    /**
     * Get user main location
     */
    public function mainLocation()
    {
        return $this->belongsTo(UserAddress::class, 'main_location');
    }

    /**
     * Get user orders
     * 
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

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
}
