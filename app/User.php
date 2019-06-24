<?php

namespace App;

use Spatie\MediaLibrary\Models\Media;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\UserPersonalInfo;
use App\Models\UserAddress;
use App\Models\Product;

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
        'first_name', 'last_name', 'email', 'password',
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
        return $this->belongsToMany(Product::class, 'users_carts', 'user_id', 'product_id')->withPivot('quantity')->withTimestamps();
    }

    /**
     * The function to return cart total price.
     *
     */
    public function getCartTotalPriceAttribute()
    {
        return ($this->cart->count()) ? $this->cart->sum(function($cart) {
            return $cart->final_price;
          }) : 0;
    }
}
