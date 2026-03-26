<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{
    /**
     * Display a listing of employees.
     */
    public function index(Request $request)
    {
        $query = Employee::with('department', 'user');
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        // Filter by department
        if ($request->has('department_id') && !empty($request->department_id)) {
            $query->where('department_id', $request->department_id);
        }
        
        $employees = $query->latest()->paginate(15);
        $departments = Department::all();
        
        return view('employees.index', compact('employees', 'departments'));
    }

    /**
     * Show the form for creating a new employee.
     */
    public function create()
    {
        $departments = Department::all();
        return view('employees.create', compact('departments'));
    }

    /**
     * Store a newly created employee.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:employees,email|unique:users,email',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string',
                'department_id' => 'required|exists:departments,id',
                'position' => 'required|string|max:255',
                'salary' => 'required|numeric|min:0',
                'joining_date' => 'required|date',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:20480',
                'password' => 'required|string|min:8|confirmed'
            ]);

            // Create User Account
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'employee',
                'phone' => $request->phone,
                'address' => $request->address,
                'department_id' => $request->department_id
            ]);

            // Create Employee Record
            $employee = new Employee();
            $employee->user_id = $user->id;
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->phone = $request->phone ?? '';
            $employee->address = $request->address ?? '';
            $employee->department_id = $request->department_id;
            $employee->position = $request->position;
            $employee->salary = $request->salary;
            $employee->joining_date = $request->joining_date;
            
            // Handle Image Upload
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/employees'), $imageName);
                $employee->image = 'uploads/employees/' . $imageName;
            }
            
            $employee->save();

            Log::info('New employee created: ' . $employee->email);

            return redirect()->route('employees.index')
                ->with('login_info', [
                    'email' => $request->email,
                    'password' => $request->password
                ]);

        } catch (\Exception $e) {
            Log::error('Employee store error: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Failed to create employee: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified employee.
     */
    public function show(Employee $employee)
    {
        $employee->load('department', 'user');
        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified employee.
     */
    public function edit(Employee $employee)
    {
        $departments = Department::all();
        return view('employees.edit', compact('employee', 'departments'));
    }

    /**
     * Update the specified employee.
     */
    public function update(Request $request, Employee $employee)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:employees,email,' . $employee->id . '|unique:users,email,' . ($employee->user_id ?? 0),
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string',
                'department_id' => 'required|exists:departments,id',
                'position' => 'required|string|max:255',
                'salary' => 'required|numeric|min:0',
                'joining_date' => 'required|date',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:20480',
                'password' => 'nullable|string|min:8|confirmed'
            ]);

            // Update Employee Record
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->phone = $request->phone ?? '';
            $employee->address = $request->address ?? '';
            $employee->department_id = $request->department_id;
            $employee->position = $request->position;
            $employee->salary = $request->salary;
            $employee->joining_date = $request->joining_date;
            
            // Handle Image Upload
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                if ($employee->image && file_exists(public_path($employee->image))) {
                    unlink(public_path($employee->image));
                }
                
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/employees'), $imageName);
                $employee->image = 'uploads/employees/' . $imageName;
            }
            
            $employee->save();

            // Update User Account
            if ($employee->user_id) {
                $user = User::find($employee->user_id);
                if ($user) {
                    $user->name = $request->name;
                    $user->email = $request->email;
                    $user->phone = $request->phone;
                    $user->address = $request->address;
                    $user->department_id = $request->department_id;
                    
                    if ($request->filled('password')) {
                        $user->password = Hash::make($request->password);
                    }
                    
                    $user->save();
                }
            }

            Log::info('Employee updated: ' . $employee->email);

            return redirect()->route('employees.index')
                ->with('success', 'Employee updated successfully!');

        } catch (\Exception $e) {
            Log::error('Employee update error: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Failed to update employee: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified employee.
     */
    public function destroy(Employee $employee)
    {
        try {
            if ($employee->image && file_exists(public_path($employee->image))) {
                unlink(public_path($employee->image));
            }
            
            if ($employee->user_id) {
                User::where('id', $employee->user_id)->delete();
            }
            
            $employee->delete();

            Log::info('Employee deleted: ' . $employee->email);

            return redirect()->route('employees.index')
                ->with('success', 'Employee deleted successfully!');

        } catch (\Exception $e) {
            Log::error('Employee delete error: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete employee: ' . $e->getMessage());
        }
    }

    /**
     * Reset employee password - WITH MODAL
     */
    public function resetPassword(Request $request, Employee $employee)
    {
        try {
            // Validate password
            $request->validate([
                'password' => 'required|string|min:8|confirmed'
            ]);

            // Check if employee has user_id
            if (!$employee->user_id) {
                return back()->with('error', 'No user account found for this employee.');
            }

            // Find user by user_id
            $user = User::find($employee->user_id);
            
            if (!$user) {
                return back()->with('error', 'User account not found.');
            }

            // Update password
            $newPassword = $request->password;
            $user->password = Hash::make($newPassword);
            $user->save();
            
            Log::info('Password reset for employee: ' . $employee->email);
            
            // Return with reset_info session to show modal
            return redirect()->route('employees.index')
                ->with('reset_info', [
                    'email' => $employee->email,
                    'password' => $newPassword
                ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Password reset error: ' . $e->getMessage());
            return back()->with('error', 'Failed to reset password: ' . $e->getMessage());
        }
    }
}