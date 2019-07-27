<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnStatus extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description'
    ];

    /**
     * Scope a query to only include pending returns.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('name', 'Waiting for confirmation');
    }
    
    /**
     * Scope a query to only include approved returns.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApproved($query)
    {
        return $query->where('name', 'Approved');
    }
    
    /**
     * Scope a query to only include disapproved returns.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDisapproved($query)
    {
        return $query->where('name', 'Disapproved');
    }
    
    /**
     * Scope a query to only include in the way returns.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInTheWay($query)
    {
        return $query->where('name', 'In the way');
    }
    
    /**
     * Scope a query to only include Completed returns.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCompleted($query)
    {
        return $query->where('name', 'Completed');
    }
    
    /**
     * Scope a query to only include Completed scrapped returns.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCompletedScrapped($query)
    {
        return $query->where('name', 'Completed scrapped');
    }
    
    /**
     * Scope a query to only include Canceled returns.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCanceled($query)
    {
        return $query->where('name', 'Canceled');
    }
    
    /**
     * Scope a query to only include return denied returns.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeReturnDenied($query)
    {
        return $query->where('name', 'Return denied');
    }
}
