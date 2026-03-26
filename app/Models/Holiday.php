<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $fillable = [
        'name',
        'date',
        'type',
        'description',
        'is_annual'
    ];

    protected $casts = [
        'date' => 'date',
        'is_annual' => 'boolean'
    ];
}