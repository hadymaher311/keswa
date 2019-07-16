<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehouseRelatedLocation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'location_name'
    ];
}
