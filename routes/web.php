<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HolidayController;

require __DIR__.'/auth.php';

// ============================================
// PUBLIC ROUTES
// ============================================
Route::get('/', function () {
    return redirect()->route('login');
});

// ============================================
// AUTHENTICATED ROUTES (All logged in users)
// ============================================
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Attendance
    Route::resource('attendance', AttendanceController::class);
    Route::get('attendance-report', [AttendanceController::class, 'report'])->name('attendance.report');

    // Leave Management
    Route::get('leave/balance/{employeeId?}', [LeaveController::class, 'balance'])->name('leave.balance');
    Route::resource('leave', LeaveController::class);
    Route::post('leave/{leaveRequest}/approve', [LeaveController::class, 'approve'])->name('leave.approve');
    Route::post('leave/{leaveRequest}/reject', [LeaveController::class, 'reject'])->name('leave.reject');
    Route::delete('leave/{leaveRequest}/cancel', [LeaveController::class, 'cancel'])->name('leave.cancel');

    // Profile Management
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/update', [ProfileController::class, 'update'])->name('update');
        Route::put('/change-password', [ProfileController::class, 'changePassword'])->name('password');
        Route::delete('/destroy', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // Holidays (View Only)
    Route::get('/holidays', [HolidayController::class, 'index'])->name('holidays.index');
    Route::get('/holidays/calendar', [HolidayController::class, 'calendar'])->name('holidays.calendar');
    Route::get('/holidays/upcoming', [HolidayController::class, 'upcoming'])->name('holidays.upcoming');
});

// ============================================
// ADMIN ONLY ROUTES
// ============================================
Route::middleware(['auth', 'admin'])->group(function () {

    // Employee Management
    Route::resource('employees', EmployeeController::class);

    // Department Management
    Route::resource('departments', DepartmentController::class);

    // Salary Management
    Route::resource('salary', SalaryController::class);
    Route::get('salary/{salary}/download', [SalaryController::class, 'downloadPdf'])->name('salary.download');
    Route::get('salary/export-csv', [SalaryController::class, 'exportCsv'])->name('salary.export.csv');

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/employees', [ReportController::class, 'employees'])->name('employees');
        Route::get('/attendance', [ReportController::class, 'attendance'])->name('attendance');
        Route::get('/salary', [ReportController::class, 'salary'])->name('salary');
    });

    // Employee Password Reset
    Route::post('/employees/{employee}/reset-password', [EmployeeController::class, 'resetPassword'])
        ->name('employees.reset-password');

    // Holiday Management (CRUD)
    Route::get('/holidays/create', [HolidayController::class, 'create'])->name('holidays.create');
    Route::post('/holidays', [HolidayController::class, 'store'])->name('holidays.store');
    Route::get('/holidays/{holiday}/edit', [HolidayController::class, 'edit'])->name('holidays.edit');
    Route::put('/holidays/{holiday}', [HolidayController::class, 'update'])->name('holidays.update');
    Route::delete('/holidays/{holiday}', [HolidayController::class, 'destroy'])->name('holidays.destroy');
});