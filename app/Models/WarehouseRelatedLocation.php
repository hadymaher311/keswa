<?php

namespace App\Models;

use App\Models\warehouse;
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

    /**
     * Get related warehouse
     */
    public function warehouse()
    {
        return $this->belongsTo(warehouse::class);
    }
}
