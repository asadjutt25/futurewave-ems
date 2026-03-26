<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeaveRequest extends Model
{
    protected $fillable = [
        'employee_id',
        'leave_type',
        'start_date',
        'end_date',
        'total_days',
        'reason',
        'status',
        'admin_remarks',
        'approved_at',
        'approved_by'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'approved_at' => 'datetime'
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Add this method to get remaining leave balance
    public static function getRemainingBalance($employeeId, $leaveType)
    {
        $total = match($leaveType) {
            'sick' => 12,
            'casual' => 12,
            'annual' => 15,
            'unpaid' => 999,
            default => 0
        };
        
        $used = self::where('employee_id', $employeeId)
            ->where('leave_type', $leaveType)
            ->where('status', 'approved')
            ->whereYear('created_at', date('Y'))
            ->sum('total_days');
            
        return $total - $used;
    }
}