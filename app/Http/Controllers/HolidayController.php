<?php
// app/Http/Controllers/HolidayController.php

namespace App\Http\Controllers;

use App\Models\Holiday;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HolidayController extends Controller
{
    // No constructor needed - use middleware in routes instead

    public function index()
    {
        $holidays = Holiday::orderBy('date', 'asc')->paginate(10);
        return view('holidays.index', compact('holidays'));
    }

    public function calendar()
    {
        $holidays = Holiday::whereYear('date', date('Y'))->get();
        return view('holidays.calendar', compact('holidays'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }
        return view('holidays.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'type' => 'required|in:public,company,religious',
            'description' => 'nullable|string'
        ]);

        Holiday::create($request->all());

        return redirect()->route('holidays.index')
            ->with('success', 'Holiday added successfully!');
    }

    public function edit(Holiday $holiday)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }
        return view('holidays.edit', compact('holiday'));
    }

    public function update(Request $request, Holiday $holiday)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'type' => 'required|in:public,company,religious',
            'description' => 'nullable|string'
        ]);

        $holiday->update($request->all());

        return redirect()->route('holidays.index')
            ->with('success', 'Holiday updated successfully!');
    }

    public function destroy(Holiday $holiday)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }
        
        $holiday->delete();
        return redirect()->route('holidays.index')
            ->with('success', 'Holiday deleted successfully!');
    }

    public function upcoming()
    {
        $upcomingHolidays = Holiday::where('date', '>=', Carbon::today())
            ->orderBy('date', 'asc')
            ->limit(5)
            ->get();
        
        return response()->json($upcomingHolidays);
    }
}