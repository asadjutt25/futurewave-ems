<?php

namespace App\Exports;

use App\Models\Salary;
use Illuminate\Support\Facades\DB;

class SalaryExport
{
    protected $month;
    protected $year;

    public function __construct($month = null, $year = null)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function export()
    {
        $query = Salary::with('employee');
        
        if ($this->month) {
            $query->where('month', $this->month);
        }
        
        if ($this->year) {
            $query->where('year', $this->year);
        }
        
        $salaries = $query->get();
        
        $filename = 'salary-report-' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];
        
        $callback = function() use ($salaries) {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Headers
            fputcsv($file, [
                'Employee Name',
                'Email',
                'Department',
                'Month',
                'Year',
                'Basic Salary',
                'Allowances',
                'Deductions',
                'Tax',
                'Net Salary',
                'Payment Method',
                'Payment Date',
                'Status'
            ]);
            
            // Data
            foreach ($salaries as $salary) {
                fputcsv($file, [
                    $salary->employee->name ?? 'N/A',
                    $salary->employee->email ?? 'N/A',
                    $salary->employee->department->name ?? 'N/A',
                    $salary->month,
                    $salary->year,
                    number_format($salary->basic_salary, 2),
                    number_format($salary->allowances, 2),
                    number_format($salary->deductions, 2),
                    number_format($salary->tax, 2),
                    number_format($salary->net_salary, 2),
                    ucfirst($salary->payment_method),
                    $salary->payment_date->format('d M Y'),
                    ucfirst($salary->status)
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}