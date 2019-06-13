<?php

namespace App\Models;

use App\Helpers\LocalizableModel;

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
}
