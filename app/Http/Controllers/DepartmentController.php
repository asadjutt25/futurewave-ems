<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the departments.
     */
    public function index()
    {
        try {
            $departments = Department::withCount('employees')
                ->orderBy('id', 'desc')
                ->paginate(10);
            
            return view('departments.index', compact('departments'));
            
        } catch (\Exception $e) {
            Log::error('Department index error: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Show the form for creating a new department.
     */
    public function create()
    {
        return view('departments.create');
    }

    /**
     * Store a newly created department in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'department_name' => 'required|string|max:255|unique:departments',
                'department_head' => 'required|string|max:255',
                'description' => 'required|string'
            ]);

            Department::create([
                'department_name' => $request->department_name,
                'department_head' => $request->department_head,
                'description' => $request->description
            ]);

            return redirect()->route('departments.index')
                ->with('success', 'Department created successfully!');

        } catch (\Exception $e) {
            Log::error('Department store error: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Failed to create department. Please try again.');
        }
    }

    /**
     * Show the form for editing the specified department.
     */
    public function edit(Department $department)
    {
        try {
            return view('departments.edit', compact('department'));
            
        } catch (\Exception $e) {
            Log::error('Department edit error: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Update the specified department in storage.
     */
    public function update(Request $request, Department $department)
    {
        try {
            $request->validate([
                'department_name' => 'required|string|max:255|unique:departments,department_name,' . $department->id,
                'department_head' => 'required|string|max:255',
                'description' => 'required|string'
            ]);

            $department->update([
                'department_name' => $request->department_name,
                'department_head' => $request->department_head,
                'description' => $request->description
            ]);

            return redirect()->route('departments.index')
                ->with('success', 'Department updated successfully!');

        } catch (\Exception $e) {
            Log::error('Department update error: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Failed to update department. Please try again.');
        }
    }

    /**
     * Remove the specified department from storage.
     */
    public function destroy(Department $department)
    {
        try {
            // Check if department has employees
            if ($department->employees()->count() > 0) {
                return redirect()->route('departments.index')
                    ->with('error', 'Cannot delete department with employees!');
            }
            
            $department->delete();
            
            return redirect()->route('departments.index')
                ->with('success', 'Department deleted successfully!');

        } catch (\Exception $e) {
            Log::error('Department destroy error: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete department. Please try again.');
        }
    }
}