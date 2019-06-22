<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country',
        'city',
        'street',
        'building',
        'floor',
        'apartment',
        'nearest_landmark',
        'location_type',
    ];
}
