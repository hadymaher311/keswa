<?php

namespace App\Models;

use App\Helpers\LocalizableModel;
use App\Models\WarehouseRelatedLocation;

class warehouse extends LocalizableModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_en', 'name_ar',
        'location_en', 'location_ar',
    ];
 
    /**
     * Localized attributes.
     *
     * @var array
     */
    protected $localizable = [
        'name',
        'location'
    ];

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

    /**
     * Get warehouse related locations
     */
    public function related_locations()
    {
        return $this->hasMany(WarehouseRelatedLocation::class, 'warehouse_id');
    }
}
