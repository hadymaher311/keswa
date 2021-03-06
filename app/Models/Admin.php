<?php

namespace App\Models;

use App\Models\warehouse;
use App\Models\AdminAddress;
use App\Models\AdminSetting;
use App\Models\AdminPersonalInfo;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use App\Notifications\AdminResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable implements HasMedia
{
    use Notifiable;
    use HasRoles;
    use HasMediaTrait;

    /**
     * The attribute that auth guard.
     *
     * @var string
     */
    protected $guard_name = 'admin';

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
        return $this->getMedia('admin.avatar')->last();
    }
    
    /**
     * The function to return admin settings.
     *
     */
    public function settings()
    {
        return $this->hasOne(AdminSetting::class);
    }

    //Send password reset notification
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPasswordNotification($token));
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
     * Get admin personal info
     * 
     */
    public function personalInfo()
    {
        return $this->hasOne(AdminPersonalInfo::class);
    }
    
    /**
     * Get admin addresses
     * 
     */
    public function address()
    {
        return $this->hasone(AdminAddress::class);
    }

    /**
     * Get admin warehouses
     */
    public function warehouses()
    {
        return $this->belongsToMany(warehouse::class, 'admin_warehouses');
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
