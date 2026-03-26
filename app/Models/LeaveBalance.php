<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeaveBalance extends Model
{
    protected $fillable = [
        'employee_id',
        'leave_type',
        'total_days',
        'used_days',
        'remaining_days',
        'year'
    ];

    protected $casts = [
        'year' => 'integer'
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
    
    public static function getDefaultQuota($leaveType)
    {
        return match($leaveType) {
            'sick' => 12,
            'casual' => 12,
            'annual' => 15,
            'unpaid' => 999,
            default => 0
        };
    }
    
    public static function updateBalance($employeeId, $leaveType, $year)
    {
        $used = LeaveRequest::where('employee_id', $employeeId)
            ->where('leave_type', $leaveType)
            ->where('status', 'approved')
            ->whereYear('created_at', $year)
            ->sum('total_days');
            
        $total = self::getDefaultQuota($leaveType);
        $remaining = max(0, $total - $used);
        
        $balance = self::updateOrCreate(
            [
                'employee_id' => $employeeId,
                'leave_type' => $leaveType,
                'year' => $year
            ],
            [
                'total_days' => $total,
                'used_days' => $used,
                'remaining_days' => $remaining
            ]
        );
        
        return $balance;
    }
    
    public static function getAllBalances($employeeId, $year)
    {
        $balances = [];
        $leaveTypes = ['sick', 'casual', 'annual', 'unpaid'];
        
        foreach ($leaveTypes as $type) {
            $balance = self::where('employee_id', $employeeId)
                ->where('leave_type', $type)
                ->where('year', $year)
                ->first();
                
            if (!$balance) {
                $balance = self::updateBalance($employeeId, $type, $year);
            }
            
            $balances[$type] = [
                'total' => $balance->total_days,
                'used' => $balance->used_days,
                'remaining' => $balance->remaining_days
            ];
        }
        
        return $balances;
    }
}