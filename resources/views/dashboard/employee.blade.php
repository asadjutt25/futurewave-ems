@extends('layouts.app')

@section('title', 'Employee Dashboard')

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

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.02); }
    }

    .dashboard-header {
        background: linear-gradient(135deg, #4f46e5, #06b6d4);
        border-radius: 28px;
        position: relative;
        overflow: hidden;
        animation: fadeInUp 0.5s ease;
    }

    .dashboard-header::before {
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

    .leave-card {
        border-radius: 24px;
        padding: 1.5rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        animation: fadeInUp 0.6s ease;
    }

    .leave-card::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 4px;
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .leave-card:hover {
        transform: translateY(-5px);
    }

    .leave-card:hover::after {
        transform: scaleX(1);
    }

    .leave-card.sick::after { background: #ef4444; }
    .leave-card.casual::after { background: #10b981; }
    .leave-card.annual::after { background: #3b82f6; }

    .leave-value {
        font-size: 2.2rem;
        font-weight: 800;
        line-height: 1.2;
    }

    .attendance-card {
        border-radius: 24px;
        transition: all 0.3s ease;
        animation: fadeInUp 0.7s ease;
    }

    .attendance-card:hover {
        transform: translateY(-3px);
    }

    .time-badge {
        background: linear-gradient(135deg, #4f46e5, #06b6d4);
        padding: 8px 16px;
        border-radius: 50px;
        font-weight: 600;
    }

    .status-badge {
        padding: 6px 14px;
        border-radius: 100px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .status-present {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }

    .status-late {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }

    .status-absent {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    .table-card {
        border-radius: 24px;
        overflow: hidden;
        transition: all 0.3s ease;
        animation: fadeInUp 0.8s ease;
    }

    .table-card:hover {
        transform: translateY(-3px);
    }

    .table-row-premium {
        transition: all 0.2s ease;
        border-bottom: 1px solid #f0f0f0;
    }

    .table-row-premium:hover {
        background: linear-gradient(90deg, #f8f9ff, transparent);
        transform: translateX(3px);
    }

    .badge-leave {
        padding: 6px 14px;
        border-radius: 100px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .badge-approved {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }

    .badge-rejected {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    .badge-pending {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }

    .quick-action-btn {
        transition: all 0.3s ease;
        border-radius: 50px;
        padding: 12px;
    }

    .quick-action-btn:hover {
        transform: translateY(-3px);
    }

    .welcome-icon {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 12px;
        transition: all 0.3s ease;
    }

    .welcome-icon:hover {
        transform: scale(1.05);
    }

    @media (max-width: 768px) {
        .leave-value {
            font-size: 1.5rem;
        }
        .quick-action-btn {
            padding: 10px;
            font-size: 0.85rem;
        }
    }
</style>

<div class="container-fluid px-4 py-4">
    
    <!-- Premium Header -->
    <div class="dashboard-header mb-4">
        <div class="p-4 position-relative">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="text-white">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <i class="fas fa-user-circle fa-3x opacity-75"></i>
                        <div>
                            <h1 class="display-5 fw-bold mb-1">Employee Dashboard</h1>
                            <p class="mb-0 opacity-90 fs-5">Welcome back, {{ isset($employee) && $employee ? $employee->name : Auth::user()->name }}! 👋</p>
                        </div>
                    </div>
                </div>
                <div class="welcome-icon mt-3 mt-sm-0">
                    <i class="fas fa-user fa-2x text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Leave Balance Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="leave-card sick bg-white shadow-sm">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small mb-1">Sick Leave</div>
                        <div class="leave-value text-danger">{{ isset($leaveBalance['sick']) ? $leaveBalance['sick'] : 12 }}</div>
                        <div class="mt-2">
                            <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill">
                                <i class="fas fa-thermometer me-1"></i>Available balance
                            </span>
                        </div>
                    </div>
                    <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-thermometer-half fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="leave-card casual bg-white shadow-sm">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small mb-1">Casual Leave</div>
                        <div class="leave-value text-success">{{ isset($leaveBalance['casual']) ? $leaveBalance['casual'] : 12 }}</div>
                        <div class="mt-2">
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill">
                                <i class="fas fa-umbrella-beach me-1"></i>Available balance
                            </span>
                        </div>
                    </div>
                    <div class="bg-success bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-umbrella-beach fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="leave-card annual bg-white shadow-sm">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small mb-1">Annual Leave</div>
                        <div class="leave-value text-primary">{{ isset($leaveBalance['annual']) ? $leaveBalance['annual'] : 15 }}</div>
                        <div class="mt-2">
                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill">
                                <i class="fas fa-calendar-alt me-1"></i>Available balance
                            </span>
                        </div>
                    </div>
                    <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-calendar-alt fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Attendance Card -->
    <div class="attendance-card bg-white shadow-sm mb-4">
        <div class="card-header bg-white py-3 border-0">
            <div class="d-flex align-items-center gap-2">
                <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                    <i class="fas fa-calendar-check text-primary"></i>
                </div>
                <h5 class="fw-bold mb-0">Today's Attendance</h5>
                <span class="time-badge ms-auto text-white small">
                    <i class="fas fa-clock me-1"></i>{{ now()->format('h:i A') }}
                </span>
            </div>
        </div>
        <div class="card-body p-4">
            @if(isset($todayAttendance) && $todayAttendance)
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-3 mb-3 mb-md-0">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-sign-in-alt fa-2x text-primary"></i>
                            </div>
                            <div>
                                <div class="text-muted small">Check In</div>
                                <h4 class="fw-bold mb-0">
                                    @if(isset($todayAttendance->check_in))
                                        {{ \Carbon\Carbon::parse($todayAttendance->check_in)->format('h:i A') }}
                                    @else
                                        Not marked
                                    @endif
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-sign-out-alt fa-2x text-success"></i>
                            </div>
                            <div>
                                <div class="text-muted small">Check Out</div>
                                <h4 class="fw-bold mb-0">
                                    @if(isset($todayAttendance->check_out) && $todayAttendance->check_out)
                                        {{ \Carbon\Carbon::parse($todayAttendance->check_out)->format('h:i A') }}
                                    @else
                                        <span class="badge bg-success rounded-pill">Currently Working</span>
                                    @endif
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4 pt-3 border-top">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Date:</strong> 
                            @if(isset($todayAttendance->date))
                                {{ \Carbon\Carbon::parse($todayAttendance->date)->format('d F Y') }}
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Status:</strong> 
                            @php 
                                $status = isset($todayAttendance->status) ? $todayAttendance->status : 'present'; 
                            @endphp
                            <span class="status-badge status-{{ $status == 'present' ? 'present' : ($status == 'late' ? 'late' : 'absent') }}">
                                <i class="fas {{ $status == 'present' ? 'fa-check-circle' : ($status == 'late' ? 'fa-clock' : 'fa-times-circle') }}"></i>
                                {{ ucfirst($status) }}
                            </span>
                        </p>
                    </div>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-clock fa-4x text-muted mb-3 d-block"></i>
                    <h5 class="text-muted mb-2">No Attendance Marked for Today</h5>
                    <p class="text-muted mb-3">Please mark your attendance to start the day</p>
                    <a href="{{ route('attendance.create') }}" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-plus me-2"></i>Mark Attendance
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Leave Requests Table -->
    <div class="table-card bg-white shadow-sm">
        <div class="card-header bg-white py-3 border-0">
            <div class="d-flex align-items-center gap-2">
                <div class="bg-warning bg-opacity-10 rounded-circle p-2">
                    <i class="fas fa-clock text-warning"></i>
                </div>
                <h5 class="fw-bold mb-0">Recent Leave Requests</h5>
                <span class="badge bg-warning rounded-pill ms-2">{{ isset($myLeaves) ? count($myLeaves) : 0 }} Records</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3">Leave Type</th>
                            <th class="py-3">Duration</th>
                            <th class="py-3">Days</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Applied On</th>
                         </thead>
                        <tbody>
                            @if(isset($myLeaves) && count($myLeaves) > 0)
                                @foreach($myLeaves as $leave)
                                <tr class="table-row-premium">
                                    <td class="px-4 py-3">
                                        @php $type = $leave->leave_type ?? ''; @endphp
                                        @if($type == 'sick')
                                            <span class="badge-leave status-present">
                                                <i class="fas fa-thermometer"></i> Sick
                                            </span>
                                        @elseif($type == 'casual')
                                            <span class="badge-leave status-present">
                                                <i class="fas fa-umbrella-beach"></i> Casual
                                            </span>
                                        @elseif($type == 'annual')
                                            <span class="badge-leave status-present">
                                                <i class="fas fa-calendar-alt"></i> Annual
                                            </span>
                                        @else
                                            <span class="badge-leave status-present">
                                                <i class="fas fa-money-bill-wave"></i> Unpaid
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        @if(isset($leave->start_date) && isset($leave->end_date))
                                            {{ \Carbon\Carbon::parse($leave->start_date)->format('d M') }} - 
                                            {{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}
                                        @else
                                            N/A
                                        @endif
                                     </td>
                                    <td class="py-3">
                                        <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3 py-2">
                                            <i class="fas fa-calendar-day me-1"></i>{{ isset($leave->total_days) ? $leave->total_days : 0 }} days
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        @php 
                                            $status = isset($leave->status) ? $leave->status : 'pending'; 
                                        @endphp
                                        @if($status == 'approved')
                                            <span class="badge-leave badge-approved">
                                                <i class="fas fa-check-circle"></i> Approved
                                            </span>
                                        @elseif($status == 'rejected')
                                            <span class="badge-leave badge-rejected">
                                                <i class="fas fa-times-circle"></i> Rejected
                                            </span>
                                        @else
                                            <span class="badge-leave badge-pending">
                                                <i class="fas fa-hourglass-half"></i> Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3">{{ isset($leave->created_at) ? $leave->created_at->format('d M Y') : 'N/A' }}</td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <i class="fas fa-calendar-alt fa-3x text-muted mb-3 d-block"></i>
                                        <p class="text-muted mb-0">No leave requests found</p>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4 g-3">
        <div class="col-md-4">
            <a href="{{ route('leave.create') }}" class="quick-action-btn btn btn-primary w-100 rounded-pill py-3 shadow-sm">
                <i class="fas fa-plus-circle me-2"></i>Apply for Leave
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('attendance.create') }}" class="quick-action-btn btn btn-outline-primary w-100 rounded-pill py-3">
                <i class="fas fa-calendar-check me-2"></i>Mark Attendance
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('leave.balance') }}" class="quick-action-btn btn btn-outline-secondary w-100 rounded-pill py-3">
                <i class="fas fa-chart-pie me-2"></i>View Leave Balance
            </a>
        </div>
    </div>
</div>
@endsection