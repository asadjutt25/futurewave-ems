<?php
// app/Models/Employee.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Employee extends Model
{
    protected $table = 'employees';
    
    protected $fillable = [
        'user_id',
        'name', 
        'email', 
        'phone', 
        'department_id', 
        'position',
        'salary', 
        'address', 
        'image', 
        'joining_date'
    ];

    protected $casts = [
        'joining_date' => 'date',
        'salary' => 'decimal:2'
    ];

    /**
     * Get the user associated with this employee
     * This is the relationship method that was missing
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the department of this employee
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    /**
     * Get all attendances for this employee
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'employee_id');
    }

    /**
     * Get all leave requests for this employee
     */
    public function leaveRequests(): HasMany
    {
        return $this->hasMany(LeaveRequest::class, 'employee_id');
    }

    /**
     * Boot the model
     */
    protected static function booted()
    {
        static::creating(function ($employee) {
            if (!$employee->user_id) {
                $user = User::where('email', $employee->email)->first();
                
                if (!$user) {
                    $defaultPassword = Str::slug($employee->name) . '123';
                    
                    $user = User::create([
                        'name' => $employee->name,
                        'email' => $employee->email,
                        'password' => bcrypt($defaultPassword),
                        'role' => 'employee'
                    ]);
                    
                    \Illuminate\Support\Facades\Log::info('User account created for employee: ' . $employee->name);
                }
                
                $employee->user_id = $user->id;
            }
        });
        
        static::created(function ($employee) {
            \Illuminate\Support\Facades\Log::info('Employee created: ' . $employee->name);
        });
        
        static::updated(function ($employee) {
            $user = User::where('email', $employee->email)->first();
            if ($user) {
                $user->name = $employee->name;
                $user->email = $employee->email;
                $user->save();
            }
        });
        
        static::deleted(function ($employee) {
            $user = User::where('email', $employee->email)->first();
            if ($user) {
                $user->delete();
            }
        });
    }
}