<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    /**
     * Display attendance based on user role
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Attendance::with('employee');
        
        // Role-based filtering
        if ($user->role === 'employee') {
            $employee = Employee::where('email', $user->email)->first();
            if ($employee) {
                $query->where('employee_id', $employee->id);
            }
        }
        
        // Apply filters
        if ($request->has('date') && $request->date) {
            $query->where('date', $request->date);
        }
        
        if ($request->has('employee_id') && $request->employee_id && $user->role === 'admin') {
            $query->where('employee_id', $request->employee_id);
        }
        
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        $attendances = $query->orderBy('date', 'desc')->paginate(15);
        $employees = ($user->role === 'admin') ? Employee::all() : collect();
        
        // Summary statistics
        $summary = [
            'present' => $query->clone()->where('status', 'present')->count(),
            'absent' => $query->clone()->where('status', 'absent')->count(),
            'late' => $query->clone()->where('status', 'late')->count(),
            'half_day' => $query->clone()->where('status', 'half-day')->count(),
            'total_deduction' => $query->clone()->sum('salary_deduction') ?? 0
        ];
        
        return view('attendance.index', compact('attendances', 'employees', 'summary'));
    }

    /**
     * Show form to mark attendance
     */
    public function create()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            $employees = Employee::all();
        } else {
            $employee = Employee::where('email', $user->email)->first();
            $employees = $employee ? collect([$employee]) : collect();
        }
        
        return view('attendance.create', compact('employees'));
    }

    /**
     * Store attendance record
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'employee_id' => 'required|exists:employees,id',
                'date' => 'required|date',
                'status' => 'required|in:present,absent,late,half-day',
                'check_in' => 'nullable|date_format:H:i',
                'check_out' => 'nullable|date_format:H:i',
                'notes' => 'nullable|string'
            ]);

            // Get employee and calculate daily salary
            $employee = Employee::find($request->employee_id);
            $dailySalary = $this->calculateDailySalary($request->employee_id, $request->date);
            $deduction = $this->calculateDeduction($request->status, $dailySalary);
            
            $data = $request->all();
            $data['daily_salary'] = $dailySalary;
            $data['salary_deduction'] = $deduction;

            Attendance::updateOrCreate(
                [
                    'employee_id' => $request->employee_id,
                    'date' => $request->date
                ],
                $data
            );

            return redirect()->route('attendance.index')
                ->with('success', 'Attendance marked successfully');
                
        } catch (\Exception $e) {
            Log::error('Attendance store error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to mark attendance');
        }
    }

    /**
     * Auto mark attendance on login
     */
    public function autoMarkAttendance()
    {
        $user = Auth::user();
        $employee = Employee::where('email', $user->email)->first();
        
        if (!$employee) {
            return;
        }
        
        $today = Attendance::where('employee_id', $employee->id)
            ->where('date', today())
            ->first();
        
        if (!$today) {
            $checkInTime = now();
            $status = $checkInTime->format('H:i') > '09:00' ? 'late' : 'present';
            
            $dailySalary = $this->calculateDailySalary($employee->id, today());
            $deduction = $this->calculateDeduction($status, $dailySalary);
            
            Attendance::create([
                'employee_id' => $employee->id,
                'date' => today(),
                'check_in' => $checkInTime,
                'status' => $status,
                'daily_salary' => $dailySalary,
                'salary_deduction' => $deduction
            ]);
        }
    }

    /**
     * Edit attendance record
     */
    public function edit(Attendance $attendance)
    {
        $user = Auth::user();
        
        // Check if user can edit this record
        if ($user->role === 'employee') {
            $employee = Employee::where('email', $user->email)->first();
            if (!$employee || $attendance->employee_id !== $employee->id) {
                return redirect()->route('attendance.index')->with('error', 'Unauthorized');
            }
        }
        
        $employees = ($user->role === 'admin') ? Employee::all() : collect();
        
        return view('attendance.edit', compact('attendance', 'employees'));
    }

    /**
     * Update attendance record
     */
    public function update(Request $request, Attendance $attendance)
    {
        try {
            $request->validate([
                'employee_id' => 'required|exists:employees,id',
                'date' => 'required|date',
                'status' => 'required|in:present,absent,late,half-day',
                'check_in' => 'nullable|date_format:H:i',
                'check_out' => 'nullable|date_format:H:i',
                'notes' => 'nullable|string'
            ]);

            // Recalculate deduction
            $employee = Employee::find($request->employee_id);
            $dailySalary = $this->calculateDailySalary($request->employee_id, $request->date);
            $deduction = $this->calculateDeduction($request->status, $dailySalary);
            
            $data = $request->all();
            $data['daily_salary'] = $dailySalary;
            $data['salary_deduction'] = $deduction;
            
            $attendance->update($data);

            return redirect()->route('attendance.index')
                ->with('success', 'Attendance updated successfully');
                
        } catch (\Exception $e) {
            Log::error('Attendance update error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update attendance');
        }
    }

    /**
     * Delete attendance record
     */
    public function destroy(Attendance $attendance)
    {
        try {
            $attendance->delete();
            return redirect()->route('attendance.index')
                ->with('success', 'Attendance record deleted');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete attendance');
        }
    }

    /**
     * Monthly attendance report with salary deduction
     */
    public function report(Request $request)
    {
        $request->validate([
            'month' => 'nullable|integer|between:1,12',
            'year' => 'nullable|integer',
            'employee_id' => 'nullable|exists:employees,id'
        ]);
        
        $user = Auth::user();
        $month = $request->month ?? now()->month;
        $year = $request->year ?? now()->year;
        
        $query = Attendance::with('employee')
            ->whereMonth('date', $month)
            ->whereYear('date', $year);
        
        // Role-based filtering
        if ($user->role === 'employee') {
            $employee = Employee::where('email', $user->email)->first();
            if ($employee) {
                $query->where('employee_id', $employee->id);
            }
        } elseif ($request->employee_id) {
            $query->where('employee_id', $request->employee_id);
        }
        
        $attendances = $query->get();
        
        // Calculate summary per employee
        $summary = [];
        foreach ($attendances as $att) {
            $empId = $att->employee_id;
            if (!isset($summary[$empId])) {
                $summary[$empId] = [
                    'employee' => $att->employee,
                    'present' => 0,
                    'absent' => 0,
                    'late' => 0,
                    'half_day' => 0,
                    'total_deduction' => 0,
                    'monthly_salary' => $att->employee->salary ?? 0,
                    'net_salary' => 0
                ];
            }
            $summary[$empId][$att->status]++;
            $summary[$empId]['total_deduction'] += $att->salary_deduction ?? 0;
        }
        
        // Calculate net salary
        foreach ($summary as $key => $data) {
            $summary[$key]['net_salary'] = $data['monthly_salary'] - $data['total_deduction'];
        }
        
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $years = range(date('Y') - 2, date('Y'));
        $employees = ($user->role === 'admin') ? Employee::all() : collect();
        
        return view('attendance.report', compact('summary', 'month', 'year', 'months', 'years', 'employees'));
    }

    /**
     * Calculate daily salary
     */
    private function calculateDailySalary($employeeId, $date)
    {
        $employee = Employee::find($employeeId);
        if (!$employee || $employee->salary <= 0) {
            return 0;
        }
        
        // Get working days in month (approx 22 days)
        $workingDays = 22;
        $dailySalary = $employee->salary / $workingDays;
        
        return round($dailySalary, 2);
    }

    /**
     * Calculate deduction based on status
     */
    private function calculateDeduction($status, $dailySalary)
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