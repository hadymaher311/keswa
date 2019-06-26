<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminPersonalInfo extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'gender', 'phone', 'birth_date', 'admin_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date_of_birth' => 'datetime',
    ];
}
