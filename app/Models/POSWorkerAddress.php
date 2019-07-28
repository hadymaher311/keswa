<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class POSWorkerAddress extends Model
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
        'admin_id'
    ];
}
