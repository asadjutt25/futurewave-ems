<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\AttendanceController;

class LoginController extends Controller
{
    //

    protected function authenticated(Request $request, $user)
    {
        // Auto mark attendance for employees
        if ($user->role === 'employee') {
            $attendanceController = new AttendanceController();
            $attendanceController->autoMarkAttendance();
        }
        
        return redirect()->intended('dashboard');
    }
}