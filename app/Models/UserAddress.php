<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\WarehouseRelatedLocation;

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

    /**
     * Get Related location of warehouse
     */
    public function warehouse_related_location()
    {
        return $this->belongsTo(WarehouseRelatedLocation::class, 'city');
    }

    /**
     * Get related warehouse
     */
    public function warehouse()
    {
        return $this->warehouse_related_location->warehouse;
    }
}
