<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show()
    {
        $user = Auth::user();
        
        // Find employee by email
        $employee = Employee::where('email', $user->email)->first();
        
        // If employee doesn't exist, create a fallback object
        if (!$employee) {
            $employee = new Employee();
            $employee->name = $user->name;
            $employee->email = $user->email;
            $employee->created_at = $user->created_at;
            $employee->id = 0;
        }
        
        // Get additional stats for the profile
        $leavesCount = LeaveRequest::where('employee_id', $employee->id ?? 0)
            ->where('status', 'approved')
            ->count();
        
        // FIXED: Use employee_id instead of user_id for attendance
        $presentCount = Attendance::where('employee_id', $employee->id ?? 0)
            ->where('status', 'present')
            ->count();
        
        $lateCount = Attendance::where('employee_id', $employee->id ?? 0)
            ->where('status', 'late')
            ->count();
        
        $absentCount = Attendance::where('employee_id', $employee->id ?? 0)
            ->where('status', 'absent')
            ->count();
        
        // Calculate attendance percentage
        $totalDays = $presentCount + $absentCount + $lateCount;
        $attendancePercentage = $totalDays > 0 
            ? round(($presentCount / $totalDays) * 100, 2) 
            : 0;
        
        // Get recent attendance - FIXED: use employee_id
        $recentAttendance = Attendance::where('employee_id', $employee->id ?? 0)
            ->latest()
            ->take(5)
            ->get();
        
        return view('profile.show', compact(
            'user', 
            'employee', 
            'leavesCount', 
            'presentCount', 
            'lateCount', 
            'absentCount',
            'attendancePercentage',
            'recentAttendance'
        ));
    }

    /**
     * Show the form for editing the profile.
     */
    public function edit()
    {
        $user = Auth::user();
        
        // Find employee by email
        $employee = Employee::where('email', $user->email)->first();
        
        // If employee doesn't exist, create a fallback object
        if (!$employee) {
            $employee = new Employee();
            $employee->name = $user->name;
            $employee->email = $user->email;
        }
        
        return view('profile.edit', compact('user', 'employee'));
    }

    /**
     * Update the user's profile.
     */
    public function update(Request $request)
    {
        try {
            $user = Auth::user();
            
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:20480'
            ]);

            // Update User (ONLY name and email)
            $userModel = User::find($user->id);
            $userModel->name = $request->name;
            $userModel->email = $request->email;
            $userModel->save();

            // Update or Create Employee
            $employee = Employee::where('email', $user->email)->first();
            
            if (!$employee) {
                $employee = new Employee();
                $employee->user_id = $user->id;
                $employee->email = $request->email;
            }
            
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->phone = $request->phone ?? '';
            $employee->address = $request->address ?? '';
            
            // Handle image upload
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                // Delete old image
                if ($employee->image && file_exists(public_path($employee->image))) {
                    unlink(public_path($employee->image));
                }
                
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/employees'), $imageName);
                $employee->image = 'uploads/employees/' . $imageName;
            }
            
            $employee->save();

            return redirect()->route('profile.show')
                ->with('success', 'Profile updated successfully');
                
        } catch (\Exception $e) {
            Log::error('Profile update error: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Failed to update profile: ' . $e->getMessage());
        }
    }

    /**
     * Change the user's password.
     */
    public function changePassword(Request $request)
    {
        try {
            $user = Auth::user();
            
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:8|confirmed'
            ]);

            // Check current password
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->with('error', 'Current password is incorrect');
            }

            // Update password
            $userModel = User::find($user->id);
            $userModel->password = Hash::make($request->new_password);
            $userModel->save();

            return redirect()->route('profile.show')
                ->with('success', 'Password changed successfully');
                
        } catch (\Exception $e) {
            Log::error('Password change error: ' . $e->getMessage());
            return back()->with('error', 'Failed to change password');
        }
    }

    /**
     * Delete the user's account - ONLY ADMIN CAN DELETE
     */
    public function destroy(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Check if user is admin
            if ($user->role !== 'admin') {
                return back()->with('error', 'Only admin can delete accounts!');
            }
            
            $request->validate([
                'password' => 'required'
            ]);

            if (!Hash::check($request->password, $user->password)) {
                return back()->with('error', 'Password is incorrect');
            }

            // Get the user to delete (from request or current user)
            $userToDeleteId = $request->user_id ?? $user->id;
            $userToDelete = User::find($userToDeleteId);
            
            if (!$userToDelete) {
                return back()->with('error', 'User not found');
            }
            
            // Prevent admin from deleting themselves
            if ($userToDelete->id === $user->id && $user->role === 'admin') {
                $adminCount = User::where('role', 'admin')->count();
                if ($adminCount <= 1) {
                    return back()->with('error', 'Cannot delete the last admin account!');
                }
            }

            // Delete employee record if exists
            $employee = Employee::where('email', $userToDelete->email)->first();
            if ($employee) {
                if ($employee->image && file_exists(public_path($employee->image))) {
                    unlink(public_path($employee->image));
                }
                $employee->delete();
                Log::info('Employee deleted by admin: ' . $employee->email);
            }

            // Delete user
            $userToDelete->delete();
            Log::info('User deleted by admin: ' . $userToDelete->email);

            if ($userToDelete->id === $user->id) {
                Auth::logout();
                return redirect()->route('login')->with('success', 'Account deleted successfully');
            }

            return redirect()->route('employees.index')
                ->with('success', 'User account deleted successfully');
                
        } catch (\Exception $e) {
            Log::error('Account delete error: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete account: ' . $e->getMessage());
        }
    }
}