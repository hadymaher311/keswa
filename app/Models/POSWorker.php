<?php

namespace App\Models;

use App\Models\warehouse;
use App\Models\POSWorkerAddress;
use App\Models\POSWorkerSetting;
use App\Models\POSWorkerPersonalInfo;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\POS\WorkerResetPasswordNotification;

class POSWorker extends Authenticatable implements HasMedia
{
    use Notifiable;
    use HasMediaTrait;

    /**
     * The attribute that auth guard.
     *
     * @var string
     */
    protected $guard_name = 'pos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'warehouse_id'
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
        return $this->getMedia('pos_worker.avatar')->last();
    }
    
    /**
     * The function to return worker settings.
     *
     */
    public function settings()
    {
        return $this->hasOne(POSWorkerSetting::class);
    }

    //Send password reset notification
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new WorkerResetPasswordNotification($token));
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
     * Get worker personal info
     * 
     */
    public function personalInfo()
    {
        return $this->hasOne(POSWorkerPersonalInfo::class, 'worker_id');
    }
    
    /**
     * Get worker addresses
     * 
     */
    public function address()
    {
        return $this->hasone(POSWorkerAddress::class, 'worker_id');
    }
    
    /**
     * Get worker warehouse
     * 
     */
    public function pos()
    {
        return $this->belongsTo(warehouse::class, 'warehouse_id');
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
