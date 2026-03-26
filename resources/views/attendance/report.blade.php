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

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .gradient-header {
        background: linear-gradient(135deg, #4f46e5, #06b6d4);
        border-radius: 28px;
        position: relative;
        overflow: hidden;
        animation: fadeInUp 0.5s ease;
    }

    .gradient-header::before {
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

    .filter-card-glass {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 24px;
        transition: all 0.3s ease;
    }

    .filter-card-glass:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    }

    .stat-card-premium {
        border-radius: 24px;
        padding: 1.5rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .stat-card-premium::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 4px;
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .stat-card-premium:hover {
        transform: translateY(-5px);
    }

    .stat-card-premium:hover::after {
        transform: scaleX(1);
    }

    .stat-card-premium.present::after { background: #10b981; }
    .stat-card-premium.ontime::after { background: #3b82f6; }
    .stat-card-premium.late::after { background: #f59e0b; }
    .stat-card-premium.absent::after { background: #ef4444; }

    .stat-value {
        font-size: 2.2rem;
        font-weight: 800;
        line-height: 1.2;
    }

    .avatar-premium {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4f46e5, #06b6d4);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
    }

    .avatar-premium:hover {
        transform: scale(1.1);
        box-shadow: 0 8px 20px rgba(79, 70, 229, 0.3);
    }

    .badge-status-premium {
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

    .btn-action-premium {
        width: 36px;
        height: 36px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .btn-action-premium:hover {
        transform: translateY(-2px);
    }

    .btn-edit-premium {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }

    .btn-edit-premium:hover {
        background: #f59e0b;
        color: white;
    }

    .btn-delete-premium {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    .btn-delete-premium:hover {
        background: #ef4444;
        color: white;
    }

    .table-row-premium {
        transition: all 0.2s ease;
        border-bottom: 1px solid #f0f0f0;
    }

    .table-row-premium:hover {
        background: linear-gradient(90deg, #f8f9ff, transparent);
        transform: translateX(3px);
    }

    .working-hours {
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .stat-value {
            font-size: 1.5rem;
        }
        .avatar-premium {
            width: 38px;
            height: 38px;
            font-size: 0.9rem;
        }
    }
</style>

<div class="container-fluid px-4 py-4">

    <!-- Premium Header -->
    <div class="gradient-header mb-4">
        <div class="p-4 position-relative">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="text-white">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <i class="fas fa-calendar-check fa-3x opacity-75"></i>
                        <div>
                            <h1 class="display-5 fw-bold mb-1">Attendance Management</h1>
                            <p class="mb-0 opacity-90 fs-5">Track and manage employee attendance records</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('attendance.create') }}" class="btn btn-light rounded-pill px-4 py-2 shadow-sm mt-3 mt-sm-0">
                    <i class="fas fa-plus-circle me-2"></i>Mark Attendance
                </a>
            </div>
        </div>
    </div>

    <!-- Glass Filter Card -->
    <div class="filter-card-glass bg-white shadow-sm mb-4">
        <div class="p-4">
            <div class="d-flex align-items-center gap-2 mb-3">
                <i class="fas fa-sliders-h text-primary"></i>
                <h5 class="fw-bold mb-0">Filter Attendance</h5>
            </div>
            <form action="{{ route('attendance.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold small text-muted">Employee</label>
                    <select name="employee_id" class="form-select rounded-pill border-0 shadow-sm bg-light">
                        <option value="">All Employees</option>
                        @if(isset($employees) && $employees->isNotEmpty())
                            @foreach($employees as $emp)
                                @if($emp && is_object($emp))
                                <option value="{{ $emp->id }}" {{ request('employee_id') == $emp->id ? 'selected' : '' }}>
                                    {{ $emp->name ?? 'Unknown' }}
                                </option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small text-muted">Date</label>
                    <input type="date" name="date" class="form-control rounded-pill border-0 shadow-sm bg-light" 
                           value="{{ request('date') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small text-muted">Status</label>
                    <select name="status" class="form-select rounded-pill border-0 shadow-sm bg-light">
                        <option value="">All Status</option>
                        <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>✅ Present</option>
                        <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>❌ Absent</option>
                        <option value="late" {{ request('status') == 'late' ? 'selected' : '' }}>⏰ Late</option>
                        <option value="half-day" {{ request('status') == 'half-day' ? 'selected' : '' }}>🌓 Half Day</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 shadow-sm">
                        <i class="fas fa-search me-2"></i>Apply Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    @if(isset($attendances) && $attendances->isNotEmpty())
    <div class="row g-4 mb-4">
        @php
            $presentCount = $attendances->where('status', 'present')->count();
            $absentCount = $attendances->where('status', 'absent')->count();
            $lateCount = $attendances->where('status', 'late')->count();
            $halfDayCount = $attendances->where('status', 'half-day')->count();
            
            $onTimeCount = $attendances->filter(function($item) {
                return $item->check_in && $item->check_in <= '09:00:00';
            })->count();
        @endphp
        
        <div class="col-sm-6 col-lg-3">
            <div class="stat-card-premium present bg-white shadow-sm">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small mb-1">Present</div>
                        <div class="stat-value text-success">{{ $presentCount }}</div>
                        <div class="mt-2">
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill">
                                <i class="fas fa-check-circle me-1"></i>Today's attendance
                            </span>
                        </div>
                    </div>
                    <div class="bg-success bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-user-check fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="stat-card-premium ontime bg-white shadow-sm">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small mb-1">On Time</div>
                        <div class="stat-value text-primary">{{ $onTimeCount }}</div>
                        <div class="mt-2">
                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill">
                                <i class="fas fa-clock me-1"></i>Before 9:00 AM
                            </span>
                        </div>
                    </div>
                    <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-hourglass-start fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="stat-card-premium late bg-white shadow-sm">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small mb-1">Late Arrivals</div>
                        <div class="stat-value text-warning">{{ $lateCount }}</div>
                        <div class="mt-2">
                            <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill">
                                <i class="fas fa-exclamation-triangle me-1"></i>After 9:00 AM
                            </span>
                        </div>
                    </div>
                    <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-hourglass-half fa-2x text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="stat-card-premium absent bg-white shadow-sm">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small mb-1">Absent</div>
                        <div class="stat-value text-danger">{{ $absentCount }}</div>
                        <div class="mt-2">
                            <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill">
                                <i class="fas fa-user-slash me-1"></i>Need attention
                            </span>
                        </div>
                    </div>
                    <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-user-times fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Attendance Table -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0">
                <i class="fas fa-list me-2 text-primary"></i>Attendance Records
            </h5>
            <span class="badge bg-primary rounded-pill px-3 py-2">{{ $attendances->total() ?? 0 }} Total Records</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3">Employee</th>
                            <th class="py-3">Date</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Check In</th>
                            <th class="py-3">Check Out</th>
                            <th class="py-3">Working Hours</th>
                            <th class="py-3 text-end px-4">Actions</th>
                         </thead>
                    <tbody>
                        @forelse($attendances as $attendance)
                        @if($attendance && is_object($attendance))
                        <tr class="table-row-premium">
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-premium">
                                        {{ $attendance->employee && is_object($attendance->employee) ? strtoupper(substr($attendance->employee->name ?? 'U', 0, 1)) : 'U' }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $attendance->employee->name ?? 'N/A' }}</div>
                                        <small class="text-muted">{{ $attendance->employee->email ?? '' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 fw-semibold">{{ $attendance->date ? \Carbon\Carbon::parse($attendance->date)->format('d M Y') : 'N/A' }}</td>
                            <td class="py-3">
                                @if($attendance->status == 'present')
                                    <span class="badge-status-premium badge-present">
                                        <i class="fas fa-check-circle"></i> Present
                                    </span>
                                @elseif($attendance->status == 'absent')
                                    <span class="badge-status-premium badge-absent">
                                        <i class="fas fa-times-circle"></i> Absent
                                    </span>
                                @elseif($attendance->status == 'late')
                                    <span class="badge-status-premium badge-late">
                                        <i class="fas fa-clock"></i> Late
                                    </span>
                                @elseif($attendance->status == 'half-day')
                                    <span class="badge-status-premium badge-half-day">
                                        <i class="fas fa-adjust"></i> Half Day
                                    </span>
                                @else
                                    <span class="badge-status-premium">
                                        {{ $attendance->status ?? 'N/A' }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-3">{{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') : '—' }}</td>
                            <td class="py-3">{{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('h:i A') : '—' }}</td>
                            <td class="py-3">
                                @if($attendance->check_in && $attendance->check_out)
                                    @php
                                        $start = \Carbon\Carbon::parse($attendance->check_in);
                                        $end = \Carbon\Carbon::parse($attendance->check_out);
                                        $hours = $end->diffInHours($start);
                                        $minutes = $end->diffInMinutes($start) % 60;
                                    @endphp
                                    <span class="working-hours">
                                        <i class="fas fa-clock me-1"></i>{{ $hours }}h {{ $minutes }}m
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td class="py-3 text-end px-4">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('attendance.edit', $attendance) }}" class="btn-action-premium btn-edit-premium" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('attendance.destroy', $attendance) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action-premium btn-delete-premium" 
                                                title="Delete" onclick="return confirm('Delete this attendance record?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endif
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
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

            <!-- Pagination -->
            @if(method_exists($attendances, 'hasPages') && $attendances->hasPages())
            <div class="d-flex justify-content-center py-4 border-top">
                {{ $attendances->links() }}
            </div>
            @endif
        </div>
    </div>

    <!-- Quick Tip Card -->
    <div class="mt-4 p-4 bg-light rounded-4">
        <div class="d-flex align-items-center gap-3">
            <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                <i class="fas fa-lightbulb text-primary fa-2x"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-1">Attendance Tips</h6>
                <p class="text-muted mb-0 small">Regular attendance tracking helps in accurate salary calculation and performance evaluation. Mark attendance daily before 10:00 AM for best results.</p>
            </div>
        </div>
    </div>
</div>
@endsection