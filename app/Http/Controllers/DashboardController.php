<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Department;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            // Admin Dashboard Data
            $totalEmployees = Employee::count();
            $totalDepartments = Department::count();
            
            // FIXED: whereDate with single argument
            $presentToday = Attendance::where('date', today())->where('status', 'present')->count();
            
            $pendingLeaves = LeaveRequest::where('status', 'pending')->count();
            $recentEmployees = Employee::with('department')->latest()->take(5)->get();
            $recentLeaves = LeaveRequest::with('employee')->where('status', 'pending')->latest()->take(5)->get();
            
            return view('dashboard.admin', compact(
                'totalEmployees', 'totalDepartments', 'presentToday', 'pendingLeaves',
                'recentEmployees', 'recentLeaves'
            ));
        } else {
            // Employee Dashboard Data
            $employee = Employee::where('email', $user->email)->first();
            
            if (!$employee) {
                return redirect()->route('profile.edit')->with('error', 'Please complete your profile first');
            }
            
            $myLeaves = LeaveRequest::where('employee_id', $employee->id)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
                
            $leaveBalance = [
                'sick' => 12 - LeaveRequest::where('employee_id', $employee->id)->where('leave_type', 'sick')->where('status', 'approved')->sum('total_days'),
                'casual' => 12 - LeaveRequest::where('employee_id', $employee->id)->where('leave_type', 'casual')->where('status', 'approved')->sum('total_days'),
                'annual' => 15 - LeaveRequest::where('employee_id', $employee->id)->where('leave_type', 'annual')->where('status', 'approved')->sum('total_days'),
            ];
            
            // FIXED: whereDate with single argument
            $todayAttendance = Attendance::where('employee_id', $employee->id)
                ->where('date', today())
                ->first();
            
            return view('dashboard.employee', compact('employee', 'myLeaves', 'leaveBalance', 'todayAttendance'));
        }
    }
}