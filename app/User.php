<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

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
        return $this->getFirstMedia('user.avatar');
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
}
