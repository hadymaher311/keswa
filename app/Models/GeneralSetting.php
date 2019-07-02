<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'value',
    ];

    /**
     * Get all Price Tax scope
     */
    public function ScopePriceTax()
    {
        return $this->where('name', 'price_tax')->first();
    }
}
