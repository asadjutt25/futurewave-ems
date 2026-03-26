<?php
// app/Models/EmailTemplate.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $fillable = [
        'name',
        'subject',
        'body',
        'type', // leave_approved, leave_rejected, salary_generated, etc.
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];
}