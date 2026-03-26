@extends('layouts.app')

@section('title', 'Attendance Management')

@section('content')
<style>
    /* Premium Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.02); }
    }

    .header-premium {
        background: linear-gradient(135deg, #4f46e5, #06b6d4);
        border-radius: 28px;
        position: relative;
        overflow: hidden;
        animation: fadeInUp 0.5s ease;
    }

    .header-premium::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255,255,255,0.1) 25%, transparent 25%),
                    linear-gradient(-45deg, rgba(255,255,255,0.1) 25%, transparent 25%);
        background-size: 40px 40px;
        animation: shimmer 15s linear infinite;
    }

    .stat-card {
        border-radius: 24px;
        padding: 1.5rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        animation: fadeInUp 0.6s ease;
    }

    .stat-card::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 4px;
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-card.present::after { background: #10b981; }
    .stat-card.absent::after { background: #ef4444; }
    .stat-card.late::after { background: #f59e0b; }
    .stat-card.deduction::after { background: #3b82f6; }

    .stat-card:hover::after {
        transform: scaleX(1);
    }

    .stat-value {
        font-size: 2.2rem;
        font-weight: 800;
        line-height: 1.2;
    }

    .filter-card {
        border-radius: 24px;
        transition: all 0.3s ease;
        animation: fadeInUp 0.7s ease;
    }

    .filter-card:hover {
        transform: translateY(-2px);
    }

    .table-container {
        border-radius: 24px;
        overflow: hidden;
        animation: fadeInUp 0.8s ease;
    }

    .table-row {
        transition: all 0.2s ease;
        border-bottom: 1px solid #f0f0f0;
    }

    .table-row:hover {
        background: linear-gradient(90deg, #f8f9ff, transparent);
        transform: translateX(3px);
    }

    .avatar-sm {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4f46e5, #06b6d4);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .avatar-sm:hover {
        transform: scale(1.1);
    }

    .badge-status {
        padding: 6px 14px;
        border-radius: 100px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .badge-present {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }

    .badge-absent {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    .badge-late {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }

    .badge-half-day {
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
    }

    .btn-action {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .btn-action:hover {
        transform: translateY(-2px);
    }

    .btn-edit {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }

    .btn-edit:hover {
        background: #f59e0b;
        color: white;
    }

    .btn-delete {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    .btn-delete:hover {
        background: #ef4444;
        color: white;
    }

    @media (max-width: 768px) {
        .stat-value {
            font-size: 1.5rem;
        }
        .badge-status {
            padding: 4px 10px;
            font-size: 0.7rem;
        }
    }
</style>

<div class="container-fluid px-4 py-4">
    
    <!-- Header Section -->
    <div class="header-premium mb-4">
        <div class="p-4 position-relative">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="text-white">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <i class="fas fa-calendar-check fa-3x opacity-75"></i>
                        <div>
                            <h1 class="display-5 fw-bold mb-1">Attendance Management</h1>
                            <p class="mb-0 opacity-90 fs-5">Track and manage employee attendance</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('attendance.create') }}" class="btn btn-light rounded-pill px-4 py-2 shadow-sm mt-3 mt-sm-0">
                    <i class="fas fa-plus-circle me-2"></i>Mark Attendance
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="stat-card present bg-white shadow-sm">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small mb-1">Present Today</div>
                        <div class="stat-value text-success">{{ $summary['present'] ?? 0 }}</div>
                        <div class="mt-2">
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill">
                                <i class="fas fa-chart-line me-1"></i>+{{ $summary['present'] ?? 0 }} today
                            </span>
                        </div>
                    </div>
                    <div class="bg-success bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-check-circle fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="stat-card absent bg-white shadow-sm">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small mb-1">Absent Today</div>
                        <div class="stat-value text-danger">{{ $summary['absent'] ?? 0 }}</div>
                        <div class="mt-2">
                            <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill">
                                <i class="fas fa-exclamation-circle me-1"></i>Need attention
                            </span>
                        </div>
                    </div>
                    <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-times-circle fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="stat-card late bg-white shadow-sm">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small mb-1">Late Arrivals</div>
                        <div class="stat-value text-warning">{{ $summary['late'] ?? 0 }}</div>
                        <div class="mt-2">
                            <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill">
                                <i class="fas fa-clock me-1"></i>{{ $summary['late'] ?? 0 }} late today
                            </span>
                        </div>
                    </div>
                    <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-clock fa-2x text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="stat-card deduction bg-white shadow-sm">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small mb-1">Total Deductions</div>
                        <div class="stat-value text-primary">${{ number_format($summary['total_deduction'] ?? 0, 2) }}</div>
                        <div class="mt-2">
                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill">
                                <i class="fas fa-calculator me-1"></i>This month
                            </span>
                        </div>
                    </div>
                    <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-dollar-sign fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-card bg-white shadow-sm mb-4">
        <div class="p-4">
            <div class="d-flex align-items-center gap-2 mb-3">
                <i class="fas fa-sliders-h text-primary"></i>
                <h5 class="fw-bold mb-0">Filter Attendance Records</h5>
            </div>
            <form method="GET" action="{{ route('attendance.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">Date</label>
                    <input type="date" name="date" class="form-control rounded-pill" value="{{ request('date') }}">
                </div>
                @if(Auth::user()->role === 'admin')
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">Employee</label>
                    <select name="employee_id" class="form-select rounded-pill">
                        <option value="">All Employees</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}" {{ request('employee_id') == $emp->id ? 'selected' : '' }}>
                                {{ $emp->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="col-md-2">
                    <label class="form-label fw-semibold small">Status</label>
                    <select name="status" class="form-select rounded-pill">
                        <option value="">All</option>
                        <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>✅ Present</option>
                        <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>❌ Absent</option>
                        <option value="late" {{ request('status') == 'late' ? 'selected' : '' }}>⏰ Late</option>
                        <option value="half-day" {{ request('status') == 'half-day' ? 'selected' : '' }}>🌓 Half Day</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-2">
                        <i class="fas fa-search me-2"></i>Apply Filter
                    </button>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <a href="{{ route('attendance.report') }}" class="btn btn-outline-primary w-100 rounded-pill py-2">
                        <i class="fas fa-chart-line me-2"></i>View Report
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Attendance Table -->
    <div class="table-container bg-white shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3">Employee</th>
                        <th class="py-3">Date</th>
                        <th class="py-3">Status</th>
                        <th class="py-3">Check In</th>
                        <th class="py-3">Check Out</th>
                        <th class="py-3">Daily Salary</th>
                        <th class="py-3">Deduction</th>
                        <th class="py-3 text-end px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $att)
                    <tr class="table-row">
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-sm">
                                    {{ strtoupper(substr($att->employee->name ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $att->employee->name ?? 'N/A' }}</div>
                                    <small class="text-muted">{{ $att->employee->email ?? '' }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 fw-semibold">{{ \Carbon\Carbon::parse($att->date)->format('d M Y') }}</td>
                        <td class="py-3">
                            @if($att->status == 'present')
                                <span class="badge-status badge-present">
                                    <i class="fas fa-check-circle"></i> Present
                                </span>
                            @elseif($att->status == 'absent')
                                <span class="badge-status badge-absent">
                                    <i class="fas fa-times-circle"></i> Absent
                                </span>
                            @elseif($att->status == 'late')
                                <span class="badge-status badge-late">
                                    <i class="fas fa-clock"></i> Late
                                </span>
                            @else
                                <span class="badge-status badge-half-day">
                                    <i class="fas fa-adjust"></i> Half Day
                                </span>
                            @endif
                        </td>
                        <td class="py-3">{{ $att->check_in ? \Carbon\Carbon::parse($att->check_in)->format('h:i A') : '—' }}</td>
                        <td class="py-3">{{ $att->check_out ? \Carbon\Carbon::parse($att->check_out)->format('h:i A') : '—' }}</td>
                        <td class="py-3 text-success fw-semibold">${{ number_format($att->daily_salary ?? 0, 2) }}</td>
                        <td class="py-3 text-danger fw-semibold">-${{ number_format($att->salary_deduction ?? 0, 2) }}</td>
                        <td class="py-3 text-end px-4">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('attendance.edit', $att) }}" class="btn-action btn-edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('attendance.destroy', $att) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn-action btn-delete" title="Delete" onclick="return confirm('Delete this attendance record?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <div class="py-5">
                                <i class="fas fa-calendar-times fa-5x text-muted mb-4 d-block"></i>
                                <h5 class="text-muted mb-2">No Attendance Records Found</h5>
                                <p class="text-muted mb-3">Start marking attendance for your employees</p>
                                <a href="{{ route('attendance.create') }}" class="btn btn-primary rounded-pill px-4">
                                    <i class="fas fa-plus me-2"></i>Mark Attendance
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center py-3 border-top">
            {{ $attendances->links() }}
        </div>
    </div>
</div>
@endsection