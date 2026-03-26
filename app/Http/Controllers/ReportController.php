<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Salary;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function employees(Request $request)
    {
        $query = Employee::with('department');
        
        if ($request->has('department_id')) {
            $query->where('department_id', $request->department_id);
        }
        
        $employees = $query->get();
        
        if ($request->has('export')) {
            return $this->exportEmployees($employees);
        }
        
        return view('reports.employees', compact('employees'));
    }

    public function attendance(Request $request)
    {
        $request->validate([
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer'
        ]);

        $attendances = Attendance::with('employee')
            ->whereMonth('date', $request->month)
            ->whereYear('date', $request->year)
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
                    'half_day' => 0
                ];
            }
            $summary[$empId][$att->status]++;
        }

        if ($request->has('export')) {
            return $this->exportAttendance($summary, $request->month, $request->year);
        }

        return view('reports.attendance', compact('summary'));
    }

    public function salary(Request $request)
    {
        $request->validate([
            'month' => 'required|string',
            'year' => 'required|integer'
        ]);

        $salaries = Salary::with('employee')
            ->where('month', $request->month)
            ->where('year', $request->year)
            ->get();

        if ($request->has('export')) {
            return $this->exportSalaries($salaries);
        }

        return view('reports.salary', compact('salaries'));
    }

    private function exportEmployees($employees)
    {
        // CSV export
        $filename = "employees_" . now()->format('Y_m_d') . ".csv";
        $handle = fopen('php://output', 'w');
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        fputcsv($handle, ['ID', 'Name', 'Email', 'Phone', 'Department', 'Position', 'Salary']);
        
        foreach ($employees as $emp) {
            fputcsv($handle, [
                $emp->id,
                $emp->name,
                $emp->email,
                $emp->phone,
                $emp->department->department_name ?? 'N/A',
                $emp->position,
                $emp->salary
            ]);
        }
        
        fclose($handle);
        exit;
    }

    private function exportAttendance($summary, $month, $year)
    {
        $filename = "attendance_{$month}_{$year}.csv";
        $handle = fopen('php://output', 'w');
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        fputcsv($handle, ['Employee Name', 'Present', 'Absent', 'Late', 'Half Day']);
        
        foreach ($summary as $data) {
            fputcsv($handle, [
                $data['employee']->name,
                $data['present'],
                $data['absent'],
                $data['late'],
                $data['half_day']
            ]);
        }
        
        fclose($handle);
        exit;
    }

    private function exportSalaries($salaries)
    {
        $filename = "salaries_" . now()->format('Y_m_d') . ".csv";
        $handle = fopen('php://output', 'w');
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        fputcsv($handle, ['Employee', 'Month', 'Year', 'Basic', 'Allowances', 'Deductions', 'Tax', 'Net', 'Status']);
        
        foreach ($salaries as $sal) {
            fputcsv($handle, [
                $sal->employee->name,
                $sal->month,
                $sal->year,
                $sal->basic_salary,
                $sal->allowances,
                $sal->deductions,
                $sal->tax,
                $sal->net_salary,
                $sal->status
            ]);
        }
        
        fclose($handle);
        exit;
    }
}