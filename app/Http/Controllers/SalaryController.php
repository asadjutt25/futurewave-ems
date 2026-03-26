<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class SalaryController extends Controller
{
    /**
     * Display a listing of salaries.
     */
    public function index(Request $request)
    {
        $query = Salary::with('employee');
        
        // Filter by month
        if ($request->has('month') && !empty($request->month)) {
            $query->where('month', $request->month);
        }
        
        // Filter by year
        if ($request->has('year') && !empty($request->year)) {
            $query->where('year', $request->year);
        }
        
        // If not admin, show only own salary
        if (Auth::user()->role !== 'admin') {
            $employee = Employee::where('email', Auth::user()->email)->first();
            if ($employee) {
                $query->where('employee_id', $employee->id);
            }
        }
        
        $salaries = $query->orderBy('created_at', 'desc')->paginate(15);
        $months = ['January', 'February', 'March', 'April', 'May', 'June',
                   'July', 'August', 'September', 'October', 'November', 'December'];
        
        return view('salary.index', compact('salaries', 'months'));
    }

    /**
     * Show form to create new salary.
     */
    public function create()
    {
        $employees = Employee::all();
        $months = ['January', 'February', 'March', 'April', 'May', 'June',
                   'July', 'August', 'September', 'October', 'November', 'December'];
        
        return view('salary.create', compact('employees', 'months'));
    }

    /**
     * Store a newly created salary.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'employee_id' => 'required|exists:employees,id',
                'month' => 'required|string',
                'year' => 'required|integer',
                'basic_salary' => 'required|numeric|min:0',
                'allowances' => 'nullable|numeric|min:0',
                'deductions' => 'nullable|numeric|min:0',
                'tax' => 'nullable|numeric|min:0',
                'payment_method' => 'required|string|in:bank,cash,check',
                'transaction_id' => 'nullable|string',
                'payment_date' => 'required|date',
                'notes' => 'nullable|string'
            ]);

            $employee = Employee::find($request->employee_id);
            
            // Calculate net salary
            $basic = $request->basic_salary;
            $allowances = $request->allowances ?? 0;
            $deductions = $request->deductions ?? 0;
            $tax = $request->tax ?? 0;
            $netSalary = $basic + $allowances - $deductions - $tax;

            // Check if salary already exists
            $existing = Salary::where('employee_id', $request->employee_id)
                ->where('month', $request->month)
                ->where('year', $request->year)
                ->first();
                
            if ($existing) {
                return back()->with('error', 'Salary already processed for this employee for ' . $request->month . ' ' . $request->year);
            }

            $salary = Salary::create([
                'employee_id' => $request->employee_id,
                'user_id' => $employee->user_id,
                'month' => $request->month,
                'year' => $request->year,
                'basic_salary' => $basic,
                'allowances' => $allowances,
                'deductions' => $deductions,
                'tax' => $tax,
                'net_salary' => $netSalary,
                'payment_method' => $request->payment_method,
                'transaction_id' => $request->transaction_id,
                'payment_date' => $request->payment_date,
                'status' => 'paid',
                'notes' => $request->notes
            ]);

            Log::info('Salary processed for employee: ' . $employee->email . ' for ' . $request->month . ' ' . $request->year);

            return redirect()->route('salary.index')
                ->with('success', 'Salary processed successfully!');

        } catch (\Exception $e) {
            Log::error('Salary store error: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Failed to process salary: ' . $e->getMessage());
        }
    }

    /**
     * Display salary details.
     */
    public function show(Salary $salary)
    {
        // Check authorization
        if (Auth::user()->role !== 'admin' && Auth::id() !== $salary->user_id) {
            abort(403, 'Unauthorized access.');
        }
        
        return view('salary.show', compact('salary'));
    }

    /**
     * Show form to edit salary.
     */
    public function edit(Salary $salary)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }
        
        $employees = Employee::all();
        $months = ['January', 'February', 'March', 'April', 'May', 'June',
                   'July', 'August', 'September', 'October', 'November', 'December'];
        
        return view('salary.edit', compact('salary', 'employees', 'months'));
    }

    /**
     * Update salary record.
     */
    public function update(Request $request, Salary $salary)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }
        
        try {
            $request->validate([
                'basic_salary' => 'required|numeric|min:0',
                'allowances' => 'nullable|numeric|min:0',
                'deductions' => 'nullable|numeric|min:0',
                'tax' => 'nullable|numeric|min:0',
                'payment_method' => 'required|string|in:bank,cash,check',
                'transaction_id' => 'nullable|string',
                'payment_date' => 'required|date',
                'notes' => 'nullable|string'
            ]);

            $basic = $request->basic_salary;
            $allowances = $request->allowances ?? 0;
            $deductions = $request->deductions ?? 0;
            $tax = $request->tax ?? 0;
            $netSalary = $basic + $allowances - $deductions - $tax;

            $salary->update([
                'basic_salary' => $basic,
                'allowances' => $allowances,
                'deductions' => $deductions,
                'tax' => $tax,
                'net_salary' => $netSalary,
                'payment_method' => $request->payment_method,
                'transaction_id' => $request->transaction_id,
                'payment_date' => $request->payment_date,
                'notes' => $request->notes
            ]);

            Log::info('Salary updated for employee: ' . $salary->employee->email);

            return redirect()->route('salary.index')
                ->with('success', 'Salary updated successfully!');

        } catch (\Exception $e) {
            Log::error('Salary update error: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Failed to update salary: ' . $e->getMessage());
        }
    }

    /**
     * Delete salary record.
     */
    public function destroy(Salary $salary)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }
        
        try {
            $salary->delete();
            Log::info('Salary record deleted for employee: ' . $salary->employee->email);
            
            return redirect()->route('salary.index')
                ->with('success', 'Salary record deleted successfully!');
                
        } catch (\Exception $e) {
            Log::error('Salary delete error: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete salary record');
        }
    }

    /**
     * Download PDF Salary Slip.
     */
    public function downloadPdf(Salary $salary)
    {
        // Check authorization
        if (Auth::user()->role !== 'admin' && Auth::id() !== $salary->user_id) {
            abort(403, 'Unauthorized access.');
        }
        
        try {
            $data = [
                'salary' => $salary,
                'employee' => $salary->employee,
                'company' => [
                    'name' => 'FutureWave Technologies',
                    'address' => '123 Business Avenue, Lahore, Pakistan',
                    'phone' => '+92 42 1234567',
                    'email' => 'hr@futurewave.com'
                ]
            ];
            
            $pdf = Pdf::loadView('pdf.salary-slip', $data);
            $pdf->setPaper('A4', 'portrait');
            
            return $pdf->download('Salary-Slip-' . $salary->employee->name . '-' . $salary->month . '-' . $salary->year . '.pdf');
            
        } catch (\Exception $e) {
            Log::error('PDF Download error: ' . $e->getMessage());
            return back()->with('error', 'Failed to generate PDF: ' . $e->getMessage());
        }
    }

    /**
     * Export salaries to CSV.
     */
    public function exportCsv(Request $request)
    {
        $query = Salary::with('employee');
        
        if ($request->has('month') && !empty($request->month)) {
            $query->where('month', $request->month);
        }
        
        if ($request->has('year') && !empty($request->year)) {
            $query->where('year', $request->year);
        }
        
        $salaries = $query->get();
        
        if ($salaries->isEmpty()) {
            return back()->with('error', 'No salary records found to export.');
        }
        
        $filename = 'salary-report-' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];
        
        $callback = function() use ($salaries) {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for Excel
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
                'Transaction ID',
                'Payment Date',
                'Status'
            ]);
            
            // Data rows
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
                    $salary->transaction_id ?? 'N/A',
                    $salary->payment_date->format('d M Y'),
                    ucfirst($salary->status)
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    /**
     * Mark salary as paid.
     */
    public function markPaid(Salary $salary)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }
        
        try {
            $salary->update([
                'status' => 'paid',
                'payment_date' => now()
            ]);
            
            return back()->with('success', 'Salary marked as paid!');
            
        } catch (\Exception $e) {
            Log::error('Mark paid error: ' . $e->getMessage());
            return back()->with('error', 'Failed to mark salary as paid');
        }
    }
}