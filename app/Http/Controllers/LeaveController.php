<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\Employee;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeaveApprovedMail;
use App\Mail\LeaveRejectedMail;
use App\Mail\LeaveAppliedMail;

class LeaveController extends Controller
{
    /**
     * Display a listing of leave requests.
     */
    public function index(Request $request)
    {
        $query = LeaveRequest::with('employee', 'approver');
        
        // Get current user's employee record
        $currentEmployee = Employee::where('email', Auth::user()->email)->first();
        
        // If not admin, show only own leave requests
        if (Auth::user()->role !== 'admin') {
            $query->where('employee_id', $currentEmployee->id ?? 0);
        }
        
        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }
        
        $leaveRequests = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('leave.index', compact('leaveRequests'));
    }

    /**
     * Show the form for creating a new leave request.
     */
    public function create()
    {
        // Ensure default department exists
        $defaultDept = Department::find(1);
        if (!$defaultDept) {
            Department::create([
                'department_name' => 'General Department',
                'department_head' => 'Admin',
                'description' => 'Default department'
            ]);
        }
        
        // Get current employee or all employees for admin
        $currentEmployee = Employee::where('email', Auth::user()->email)->first();
        
        if (Auth::user()->role === 'admin') {
            $employees = Employee::all();
        } else {
            $employees = collect([$currentEmployee]);
        }
        
        // If no employees exist, create default ones from users
        if ($employees->isEmpty() || ($employees->count() === 1 && $employees->first() === null)) {
            $users = User::all();
            foreach ($users as $user) {
                // Check if employee already exists
                $employee = Employee::where('email', $user->email)->first();
                if (!$employee) {
                    // Check if department exists
                    $deptId = Department::first() ? Department::first()->id : 1;
                    
                    try {
                        Employee::create([
                            'name' => $user->name,
                            'email' => $user->email,
                            'phone' => '',
                            'department_id' => $deptId,
                            'position' => 'Employee',
                            'salary' => 0,
                            'address' => '',
                            'joining_date' => now(),
                        ]);
                    } catch (\Exception $e) {
                        Log::error('Failed to create employee: ' . $e->getMessage());
                    }
                }
            }
            $employees = Employee::all();
            
            if (Auth::user()->role !== 'admin') {
                $employees = collect([Employee::where('email', Auth::user()->email)->first()]);
            }
            
            Log::info('Auto-created employee records for all users');
        }
        
        // Filter out null values
        $employees = $employees->filter();
        
        return view('leave.create', compact('employees'));
    }

    /**
     * Store a newly created leave request.
     */
    public function store(Request $request)
    {
        try {
            // Log request data for debugging
            Log::info('Leave request data:', $request->all());

            // Validate request
            $request->validate([
                'employee_id' => 'required|exists:employees,id',
                'leave_type' => 'required|in:sick,casual,annual,unpaid',
                'start_date' => 'required|date|after_or_equal:today',
                'end_date' => 'required|date|after_or_equal:start_date',
                'reason' => 'required|string|min:10'
            ]);

            // Calculate total days
            $start = \Carbon\Carbon::parse($request->start_date);
            $end = \Carbon\Carbon::parse($request->end_date);
            $totalDays = $start->diffInDays($end) + 1;

            // Create leave request
            $leaveRequest = LeaveRequest::create([
                'employee_id' => $request->employee_id,
                'leave_type' => $request->leave_type,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'total_days' => $totalDays,
                'reason' => $request->reason,
                'status' => 'pending'
            ]);

            Log::info('Leave request created with ID: ' . $leaveRequest->id);

            // Send email to all admins
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                try {
                    Mail::to($admin->email)->send(new LeaveAppliedMail($leaveRequest));
                    Log::info('Leave application email sent to admin: ' . $admin->email);
                } catch (\Exception $e) {
                    Log::error('Failed to send email to admin ' . $admin->email . ': ' . $e->getMessage());
                }
            }

            return redirect()->route('leave.index')
                ->with('success', 'Leave request submitted successfully');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation error - redirect back with errors
            return back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            // Other errors
            Log::error('Leave store error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return back()->withInput()
                ->with('error', 'Failed to submit leave request: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified leave request.
     */
    public function show(LeaveRequest $leaveRequest)
    {
        // Check authorization
        $employee = Employee::where('email', Auth::user()->email)->first();
        
        if (Auth::user()->role !== 'admin' && $leaveRequest->employee_id !== ($employee->id ?? 0)) {
            return redirect()->route('leave.index')
                ->with('error', 'You are not authorized to view this request.');
        }

        return view('leave.show', compact('leaveRequest'));
    }

    /**
     * Approve a leave request (AJAX compatible).
     */
    public function approve(Request $request, LeaveRequest $leaveRequest)
    {
        try {
            // Check if user is admin
            if (Auth::user()->role !== 'admin') {
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => 'Unauthorized action.']);
                }
                return back()->with('error', 'Unauthorized action.');
            }

            // Check if request is pending
            if ($leaveRequest->status !== 'pending') {
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => 'This request has already been processed.']);
                }
                return back()->with('error', 'This request has already been processed.');
            }

            $leaveRequest->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => Auth::id(),
                'admin_remarks' => $request->admin_remarks ?? null
            ]);

            Log::info('Leave request approved: ' . $leaveRequest->id);

            // Send email to employee
            try {
                if ($leaveRequest->employee && $leaveRequest->employee->email) {
                    Mail::to($leaveRequest->employee->email)->send(new LeaveApprovedMail($leaveRequest));
                    Log::info('Leave approval email sent to: ' . $leaveRequest->employee->email);
                } else {
                    Log::warning('No email found for employee: ' . $leaveRequest->employee_id);
                }
            } catch (\Exception $e) {
                Log::error('Failed to send approval email: ' . $e->getMessage());
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Leave request approved successfully! Email notification sent to employee.'
                ]);
            }

            return redirect()->route('leave.index')
                ->with('success', 'Leave request approved successfully! Email notification sent to employee.');
                
        } catch (\Exception $e) {
            Log::error('Leave approve error: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to approve leave: ' . $e->getMessage()
                ]);
            }
            
            return back()->with('error', 'Failed to approve leave request: ' . $e->getMessage());
        }
    }

    /**
     * Reject a leave request (AJAX compatible).
     */
    public function reject(Request $request, LeaveRequest $leaveRequest)
    {
        try {
            // Check if user is admin
            if (Auth::user()->role !== 'admin') {
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => 'Unauthorized action.']);
                }
                return back()->with('error', 'Unauthorized action.');
            }

            // Check if request is pending
            if ($leaveRequest->status !== 'pending') {
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => 'This request has already been processed.']);
                }
                return back()->with('error', 'This request has already been processed.');
            }

            // Validate remarks
            if (!$request->admin_remarks || strlen($request->admin_remarks) < 5) {
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => 'Please provide a reason for rejection (min 5 characters).']);
                }
                return back()->with('error', 'Please provide a reason for rejection (min 5 characters).');
            }

            $leaveRequest->update([
                'status' => 'rejected',
                'admin_remarks' => $request->admin_remarks,
                'approved_by' => Auth::id(),
                'approved_at' => now()
            ]);

            Log::info('Leave request rejected: ' . $leaveRequest->id);

            // Send email to employee with remarks
            try {
                if ($leaveRequest->employee && $leaveRequest->employee->email) {
                    Mail::to($leaveRequest->employee->email)->send(new LeaveRejectedMail($leaveRequest, $request->admin_remarks));
                    Log::info('Leave rejection email sent to: ' . $leaveRequest->employee->email);
                } else {
                    Log::warning('No email found for employee: ' . $leaveRequest->employee_id);
                }
            } catch (\Exception $e) {
                Log::error('Failed to send rejection email: ' . $e->getMessage());
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Leave request rejected successfully! Email notification sent to employee.'
                ]);
            }

            return redirect()->route('leave.index')
                ->with('success', 'Leave request rejected successfully! Email notification sent to employee.');
                
        } catch (\Exception $e) {
            Log::error('Leave reject error: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to reject leave: ' . $e->getMessage()
                ]);
            }
            
            return back()->with('error', 'Failed to reject leave request: ' . $e->getMessage());
        }
    }

    /**
     * Cancel a pending leave request (AJAX compatible).
     */
    public function cancel(Request $request, LeaveRequest $leaveRequest)
    {
        try {
            // Get current user's employee record
            $employee = Employee::where('email', Auth::user()->email)->first();
            
            // Check if user owns this request
            if ($leaveRequest->employee_id !== ($employee->id ?? 0)) {
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => 'Unauthorized action.']);
                }
                return back()->with('error', 'Unauthorized action.');
            }

            // Check if request is pending
            if ($leaveRequest->status !== 'pending') {
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => 'Only pending requests can be cancelled.']);
                }
                return back()->with('error', 'Only pending requests can be cancelled.');
            }

            $leaveRequest->delete();

            Log::info('Leave request cancelled: ' . $leaveRequest->id);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Leave request cancelled successfully!'
                ]);
            }

            return redirect()->route('leave.index')
                ->with('success', 'Leave request cancelled successfully');
                
        } catch (\Exception $e) {
            Log::error('Leave cancel error: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to cancel leave: ' . $e->getMessage()
                ]);
            }
            
            return back()->with('error', 'Failed to cancel leave request');
        }
    }

    /**
     * Get leave balance for an employee.
     */
    public function balance($employeeId = null)
    {
        try {
            if (!Auth::check()) {
                return redirect()->route('login');
            }
            
            $user = Auth::user();
            $employee = null;
            
            if ($user->role === 'admin' && $employeeId) {
                $employee = Employee::find($employeeId);
            } else {
                $employee = Employee::where('email', $user->email)->first();
            }
            
            // Create employee if not exists
            if (!$employee) {
                $deptId = Department::first() ? Department::first()->id : 1;
                
                $employee = Employee::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => '',
                    'department_id' => $deptId,
                    'position' => 'Employee',
                    'salary' => 0,
                    'address' => '',
                    'joining_date' => now(),
                ]);
                
                Log::info('Auto-created employee for leave balance: ' . $user->email);
            }
            
            // Get current year
            $currentYear = date('Y');
            
            // Calculate used leaves
            $sickUsed = LeaveRequest::where('employee_id', $employee->id)
                ->where('leave_type', 'sick')
                ->where('status', 'approved')
                ->whereYear('created_at', $currentYear)
                ->sum('total_days');
                
            $casualUsed = LeaveRequest::where('employee_id', $employee->id)
                ->where('leave_type', 'casual')
                ->where('status', 'approved')
                ->whereYear('created_at', $currentYear)
                ->sum('total_days');
                
            $annualUsed = LeaveRequest::where('employee_id', $employee->id)
                ->where('leave_type', 'annual')
                ->where('status', 'approved')
                ->whereYear('created_at', $currentYear)
                ->sum('total_days');
                
            $unpaidUsed = LeaveRequest::where('employee_id', $employee->id)
                ->where('leave_type', 'unpaid')
                ->where('status', 'approved')
                ->whereYear('created_at', $currentYear)
                ->sum('total_days');
            
            $balances = [
                'sick' => [
                    'total' => 12,
                    'used' => (int)$sickUsed,
                    'remaining' => max(0, 12 - (int)$sickUsed)
                ],
                'casual' => [
                    'total' => 12,
                    'used' => (int)$casualUsed,
                    'remaining' => max(0, 12 - (int)$casualUsed)
                ],
                'annual' => [
                    'total' => 15,
                    'used' => (int)$annualUsed,
                    'remaining' => max(0, 15 - (int)$annualUsed)
                ],
                'unpaid' => [
                    'total' => 'Unlimited',
                    'used' => (int)$unpaidUsed,
                    'remaining' => 'Unlimited'
                ]
            ];
            
            // Get recent leaves
            $recentLeaves = LeaveRequest::where('employee_id', $employee->id)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
            
            return view('leave.balance', compact('employee', 'balances', 'recentLeaves'));

        } catch (\Exception $e) {
            Log::error('Leave balance error: ' . $e->getMessage());
            
            return view('leave.balance', [
                'employee' => null,
                'balances' => [
                    'sick' => ['total' => 12, 'used' => 0, 'remaining' => 12],
                    'casual' => ['total' => 12, 'used' => 0, 'remaining' => 12],
                    'annual' => ['total' => 15, 'used' => 0, 'remaining' => 15],
                    'unpaid' => ['total' => 'Unlimited', 'used' => 0, 'remaining' => 'Unlimited']
                ],
                'recentLeaves' => []
            ]);
        }
    }

    /**
     * Get leave balance API endpoint.
     */
    public function getBalanceApi(Request $request)
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 401);
            }
            
            if ($user->role === 'admin' && $request->has('employee_id')) {
                $employee = Employee::find($request->employee_id);
            } else {
                $employee = Employee::where('email', $user->email)->first();
            }
            
            if (!$employee) {
                return response()->json([
                    'success' => false,
                    'message' => 'No employee record found'
                ], 404);
            }

            $currentYear = date('Y');
            
            $balances = [
                'sick' => [
                    'total' => 12,
                    'used' => (int)LeaveRequest::where('employee_id', $employee->id)
                        ->where('leave_type', 'sick')
                        ->where('status', 'approved')
                        ->whereYear('created_at', $currentYear)
                        ->sum('total_days'),
                    'remaining' => 0
                ],
                'casual' => [
                    'total' => 12,
                    'used' => (int)LeaveRequest::where('employee_id', $employee->id)
                        ->where('leave_type', 'casual')
                        ->where('status', 'approved')
                        ->whereYear('created_at', $currentYear)
                        ->sum('total_days'),
                    'remaining' => 0
                ],
                'annual' => [
                    'total' => 15,
                    'used' => (int)LeaveRequest::where('employee_id', $employee->id)
                        ->where('leave_type', 'annual')
                        ->where('status', 'approved')
                        ->whereYear('created_at', $currentYear)
                        ->sum('total_days'),
                    'remaining' => 0
                ]
            ];
            
            $balances['sick']['remaining'] = max(0, $balances['sick']['total'] - $balances['sick']['used']);
            $balances['casual']['remaining'] = max(0, $balances['casual']['total'] - $balances['casual']['used']);
            $balances['annual']['remaining'] = max(0, $balances['annual']['total'] - $balances['annual']['used']);

            return response()->json([
                'success' => true,
                'data' => $balances,
                'employee' => $employee->name
            ]);

        } catch (\Exception $e) {
            Log::error('Leave balance API error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch leave balance'
            ], 500);
        }
    }
}