<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $table = 'attendance';
    
    protected $fillable = [
         'employee_id',  // ← Make sure this exists
    'date',
    'month',
    'year',
    'status',
    'check_in',
    'check_out',
    'late_minutes',
    'deduction_amount'
    ];

    protected $casts = [
        'date' => 'date',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'salary_deduction' => 'decimal:2'
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    // Calculate daily salary
    public static function calculateDailySalary($employeeId, $date)
    {
        $employee = Employee::find($employeeId);
        if (!$employee || $employee->salary <= 0) {
            return 0;
        }
        
        // Get working days in month (approx 22 days)
        $workingDays = 22;
        $dailySalary = $employee->salary / $workingDays;
        
        return $dailySalary;
    }

    // Calculate deduction based on status
    public static function calculateDeduction($status, $dailySalary)
    {
        switch ($status) {
            case 'absent':
                return $dailySalary; // Full day deduction
            case 'half-day':
                return $dailySalary / 2; // Half day deduction
            case 'late':
                return $dailySalary * 0.1; // 10% deduction
            default:
                return 0;
        }
    }
}