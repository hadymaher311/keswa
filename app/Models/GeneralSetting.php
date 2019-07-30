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
     * Get Price Tax scope
     */
    public function ScopePriceTax()
    {
        return $this->where('name', 'price_tax');
    }
    
    /**
     * Get Working hours from scope
     */
    public function ScopeWorkingHoursFrom()
    {
        return $this->where('name', 'working_hours_from');
    }
    
    /**
     * Get Working hours to scope
     */
    public function ScopeWorkingHoursTo()
    {
        return $this->where('name', 'working_hours_to');
    }
    
    /**
     * Get Points value to scope
     */
    public function ScopePointsValue()
    {
        return $this->where('name', 'points_value');
    }
    
    /**
     * Get Update pos orders to scope
     */
    public function ScopeUpdatePOSOrders()
    {
        return $this->where('name', 'update_pos_orders');
    }
}
