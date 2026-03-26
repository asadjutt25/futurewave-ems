<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Department;
use App\Models\Salary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    /**
     * Reports Dashboard
     */
    public function index()
    {
        $totalEmployees = Employee::count();
        $totalDepartments = Department::count();
        
        // FIXED: whereDate with single argument
        $presentToday = Attendance::where('date', today())->where('status', 'present')->count();
        
        $totalSalaries = Salary::where('status', 'paid')->sum('net_salary');
        
        // Monthly attendance trend (last 6 months)
        $attendanceTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthName = $month->format('M');
            $present = Attendance::whereMonth('date', $month->month)
                ->whereYear('date', $month->year)
                ->where('status', 'present')
                ->count();
            $absent = Attendance::whereMonth('date', $month->month)
                ->whereYear('date', $month->year)
                ->where('status', 'absent')
                ->count();
            $late = Attendance::whereMonth('date', $month->month)
                ->whereYear('date', $month->year)
                ->where('status', 'late')
                ->count();
                
            $attendanceTrend[] = [
                'month' => $monthName,
                'present' => $present,
                'absent' => $absent,
                'late' => $late
            ];
        }
        
        return view('reports.index', compact(
            'totalEmployees', 
            'totalDepartments', 
            'presentToday', 
            'totalSalaries', 
            'attendanceTrend'
        ));
    }

    /**
     * Employees Report
     */
    public function employees(Request $request)
    {
        $query = Employee::with('department');
        
        if ($request->has('department_id') && $request->department_id != '') {
            $query->where('department_id', $request->department_id);
        }
        
        if ($request->has('position') && $request->position != '') {
            $query->where('position', 'like', '%' . $request->position . '%');
        }
        
        $employees = $query->get();
        $departments = Department::all();
        
        if ($request->has('export') && $request->export == 'csv') {
            return $this->exportEmployeesCSV($employees);
        }
        
        return view('reports.employees', compact('employees', 'departments'));
    }

    /**
     * Attendance Report
     */
    public function attendance(Request $request)
    {
        $request->validate([
            'month' => 'nullable|integer|between:1,12',
            'year' => 'nullable|integer|min:2020|max:' . date('Y')
        ]);
        
        $month = $request->month ?? now()->month;
        $year = $request->year ?? now()->year;
        
        $attendances = Attendance::with('employee')
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get();
        
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
                    'total' => 0
                ];
            }
            $summary[$empId][$att->status]++;
            $summary[$empId]['total']++;
        }
        
        $departmentSummary = Department::withCount([
            'employees as present_count' => function($q) use ($month, $year) {
                $q->whereHas('attendances', function($q2) use ($month, $year) {
                    $q2->whereMonth('date', $month)->whereYear('date', $year)->where('status', 'present');
                });
            },
            'employees as absent_count' => function($q) use ($month, $year) {
                $q->whereHas('attendances', function($q2) use ($month, $year) {
                    $q2->whereMonth('date', $month)->whereYear('date', $year)->where('status', 'absent');
                });
            }
        ])->get();
        
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $years = range(2020, date('Y'));
        
        if ($request->has('export') && $request->export == 'csv') {
            return $this->exportAttendanceCSV($summary, $month, $year);
        }
        
        return view('reports.attendance', compact('summary', 'departmentSummary', 'month', 'year', 'months', 'years'));
    }

    /**
     * Salary Report
     */
    public function salary(Request $request)
    {
        $request->validate([
            'month' => 'nullable|string',
            'year' => 'nullable|integer'
        ]);
        
        $month = $request->month ?? now()->format('F');
        $year = $request->year ?? now()->year;
        
        $salaries = Salary::with('employee')
            ->where('month', $month)
            ->where('year', $year)
            ->get();
        
        $summary = [
            'total_basic' => $salaries->sum('basic_salary'),
            'total_allowances' => $salaries->sum('allowances'),
            'total_deductions' => $salaries->sum('deductions'),
            'total_tax' => $salaries->sum('tax'),
            'total_net' => $salaries->sum('net_salary'),
            'paid_count' => $salaries->where('status', 'paid')->count(),
            'pending_count' => $salaries->where('status', 'pending')->count()
        ];
        
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $years = range(2020, date('Y'));
        
        if ($request->has('export') && $request->export == 'csv') {
            return $this->exportSalaryCSV($salaries);
        }
        
        return view('reports.salary', compact('salaries', 'summary', 'month', 'year', 'months', 'years'));
    }

    private function exportEmployeesCSV($employees)
    {
        $filename = "employees_report_" . date('Y-m-d') . ".csv";
        $handle = fopen('php://output', 'w');
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        fputcsv($handle, ['ID', 'Name', 'Email', 'Phone', 'Department', 'Position', 'Salary', 'Joining Date']);
        
        foreach ($employees as $emp) {
            fputcsv($handle, [
                $emp->id,
                $emp->name,
                $emp->email,
                $emp->phone,
                $emp->department->department_name ?? 'N/A',
                $emp->position,
                $emp->salary,
                $emp->joining_date ? \Carbon\Carbon::parse($emp->joining_date)->format('d-m-Y') : 'N/A'
            ]);
        }
        
        fclose($handle);
        exit;
    }

    private function exportAttendanceCSV($summary, $month, $year)
    {
        $filename = "attendance_report_{$month}_{$year}.csv";
        $handle = fopen('php://output', 'w');
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        fputcsv($handle, ['Employee Name', 'Department', 'Present', 'Absent', 'Late', 'Half Day', 'Total Days', 'Attendance %']);
        
        foreach ($summary as $data) {
            $attendancePercent = $data['total'] > 0 ? round(($data['present'] / $data['total']) * 100, 1) : 0;
            fputcsv($handle, [
                $data['employee']->name ?? 'N/A',
                $data['employee']->department->department_name ?? 'N/A',
                $data['present'],
                $data['absent'],
                $data['late'],
                $data['half_day'],
                $data['total'],
                $attendancePercent . '%'
            ]);
        }
        
        fclose($handle);
        exit;
    }

    private function exportSalaryCSV($salaries)
    {
        $filename = "salary_report_" . date('Y-m-d') . ".csv";
        $handle = fopen('php://output', 'w');
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        fputcsv($handle, ['Employee', 'Month', 'Year', 'Basic Salary', 'Allowances', 'Deductions', 'Tax', 'Net Salary', 'Status', 'Payment Date']);
        
        foreach ($salaries as $sal) {
            fputcsv($handle, [
                $sal->employee->name ?? 'N/A',
                $sal->month,
                $sal->year,
                $sal->basic_salary,
                $sal->allowances,
                $sal->deductions,
                $sal->tax,
                $sal->net_salary,
                $sal->status,
                $sal->payment_date ? \Carbon\Carbon::parse($sal->payment_date)->format('d-m-Y') : 'N/A'
            ]);
        }
        
        fclose($handle);
        exit;
    }
}