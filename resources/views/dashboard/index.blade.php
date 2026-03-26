@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    /* ========================================
       ULTRA PREMIUM DASHBOARD DESIGN
    ======================================== */
    
    :root {
        --primary: #4f46e5;
        --primary-dark: #4338ca;
        --primary-light: #818cf8;
        --secondary: #06b6d4;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --info: #3b82f6;
        --dark: #0f172a;
        --gray: #64748b;
        --light: #f8fafc;
    }

    /* Animations */
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    @keyframes float-slow {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-5px); }
    }

    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    @keyframes border-flow {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    @keyframes glow-pulse {
        0% { box-shadow: 0 0 5px rgba(79, 70, 229, 0.3); }
        50% { box-shadow: 0 0 25px rgba(79, 70, 229, 0.5); }
        100% { box-shadow: 0 0 5px rgba(79, 70, 229, 0.3); }
    }

    @keyframes scale-pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    /* Premium Card */
    .card-premium {
        background: white;
        border-radius: 28px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.08);
        position: relative;
        overflow: hidden;
    }

    .card-premium::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), var(--secondary), #ec4899, var(--primary));
        background-size: 300% 100%;
        animation: border-flow 3s linear infinite;
    }

    .card-premium:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px -15px rgba(79, 70, 229, 0.2);
    }

    /* Stats Card 3D */
    .stats-card-3d {
        background: white;
        border-radius: 24px;
        padding: 1.5rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stats-card-3d::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 4px;
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .stats-card-3d:hover::after {
        transform: scaleX(1);
    }

    .stats-card-3d.employees::after { background: var(--primary); }
    .stats-card-3d.departments::after { background: var(--success); }
    .stats-card-3d.present::after { background: var(--info); }
    .stats-card-3d.salary::after { background: var(--warning); }

    .stats-card-3d:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.1);
    }

    .stats-icon-3d {
        width: 55px;
        height: 55px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .stats-card-3d:hover .stats-icon-3d {
        transform: scale(1.05) rotate(5deg);
    }

    .stats-value {
        font-size: 2.2rem;
        font-weight: 800;
        line-height: 1.2;
    }

    /* Welcome Banner */
    .welcome-banner {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: 28px;
        position: relative;
        overflow: hidden;
    }

    .welcome-banner::before {
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

    /* Avatar */
    .avatar-premium {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(79, 70, 229, 0.3);
    }

    .avatar-premium:hover {
        transform: rotateY(360deg) scale(1.1);
    }

    /* Quick Action Card */
    .action-card {
        background: white;
        border-radius: 24px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .action-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(79, 70, 229, 0.05), transparent);
        transition: left 0.5s ease;
    }

    .action-card:hover::before {
        left: 100%;
    }

    .action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px -10px rgba(0, 0, 0, 0.1);
    }

    .action-icon {
        width: 70px;
        height: 70px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        transition: all 0.3s ease;
    }

    .action-card:hover .action-icon {
        transform: scale(1.05);
    }

    /* Table Row */
    .table-row-premium {
        transition: all 0.2s ease;
    }

    .table-row-premium:hover {
        background: linear-gradient(90deg, rgba(79, 70, 229, 0.03), transparent);
        transform: translateX(5px);
    }

    /* Department Item */
    .dept-item {
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.03), rgba(6, 182, 212, 0.03));
        border: 1px solid rgba(79, 70, 229, 0.08);
        border-radius: 20px;
        padding: 1rem;
        transition: all 0.3s ease;
    }

    .dept-item:hover {
        transform: translateX(5px);
        border-color: var(--primary);
        background: rgba(79, 70, 229, 0.05);
    }

    /* Progress Bar */
    .progress-premium {
        height: 6px;
        border-radius: 10px;
        background: #e2e8f0;
        overflow: hidden;
    }

    .progress-premium .progress-bar {
        background: linear-gradient(90deg, var(--primary), var(--secondary));
        border-radius: 10px;
        position: relative;
        overflow: hidden;
    }

    .progress-premium .progress-bar::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        animation: shimmer 2s infinite;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .stats-value {
            font-size: 1.5rem;
        }
        .stats-icon-3d {
            width: 45px;
            height: 45px;
        }
        .action-icon {
            width: 55px;
            height: 55px;
        }
    }
</style>

<div class="container-fluid px-4 py-4">
    
    <!-- Welcome Banner -->
    <div class="welcome-banner mb-4">
        <div class="p-4 p-md-5 position-relative">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="text-white">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <i class="fas fa-calendar-alt"></i>
                            <span class="opacity-75">{{ now()->format('l, F j, Y') }}</span>
                        </div>
                        <h1 class="display-4 fw-bold mb-3">
                            Welcome back, <span style="background: linear-gradient(135deg, #fff, #e0e7ff); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">{{ Auth::user()->name }}</span>! 👋
                        </h1>
                        <p class="mb-0 fs-5 opacity-90">Here's what's happening in your organization today</p>
                    </div>
                </div>
                <div class="col-md-4 text-center text-md-end mt-4 mt-md-0">
                    <div class="bg-white bg-opacity-20 rounded-4 p-3 d-inline-block">
                        <i class="fas fa-chart-line fa-3x text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="stats-card-3d employees">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stats-icon-3d bg-primary bg-opacity-10">
                        <i class="fas fa-users fa-2x text-primary"></i>
                    </div>
                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill">
                        <i class="fas fa-chart-line me-1"></i>+{{ isset($newEmployees) ? $newEmployees : 0 }} this month
                    </span>
                </div>
                <div class="stats-value text-primary">{{ isset($totalEmployees) ? number_format($totalEmployees) : 0 }}</div>
                <div class="text-muted mb-2">Total Employees</div>
                <div class="progress-premium">
                    <div class="progress-bar" style="width: {{ isset($totalEmployees) && isset($departmentCounts) && $departmentCounts->count() > 0 ? min(($totalEmployees / ($departmentCounts->count() * 20)) * 100, 100) : 0 }}%"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stats-card-3d departments">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stats-icon-3d bg-success bg-opacity-10">
                        <i class="fas fa-building fa-2x text-success"></i>
                    </div>
                </div>
                <div class="stats-value text-success">{{ isset($totalDepartments) ? number_format($totalDepartments) : 0 }}</div>
                <div class="text-muted mb-2">Active Departments</div>
                <div class="progress-premium">
                    <div class="progress-bar" style="width: {{ isset($totalDepartments) ? min(($totalDepartments / 10) * 100, 100) : 0 }}%"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stats-card-3d present">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stats-icon-3d bg-info bg-opacity-10">
                        <i class="fas fa-calendar-check fa-2x text-info"></i>
                    </div>
                </div>
                <div class="stats-value text-info">{{ isset($presentToday) ? number_format($presentToday) : 0 }}</div>
                <div class="text-muted mb-2">Present Today</div>
                <div class="progress-premium">
                    <div class="progress-bar" style="width: {{ isset($presentToday) && isset($totalEmployees) && $totalEmployees > 0 ? ($presentToday / $totalEmployees) * 100 : 0 }}%"></div>
                </div>
                <div class="mt-2">
                    <small class="text-muted">Attendance Rate: {{ isset($presentToday) && isset($totalEmployees) && $totalEmployees > 0 ? round(($presentToday / $totalEmployees) * 100) : 0 }}%</small>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stats-card-3d salary">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stats-icon-3d bg-warning bg-opacity-10">
                        <i class="fas fa-dollar-sign fa-2x text-warning"></i>
                    </div>
                </div>
                <div class="stats-value text-warning">${{ number_format(isset($avgSalary) ? $avgSalary : 0, 0) }}</div>
                <div class="text-muted mb-2">Average Salary</div>
                <div class="progress-premium">
                    <div class="progress-bar" style="width: 75%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Two Column Layout -->
    <div class="row g-4 mb-4">
        <!-- Recent Employees -->
        <div class="col-lg-7">
            <div class="card-premium">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-users text-primary me-2"></i>
                            <h5 class="fw-bold mb-0 d-inline">Recent Team Members</h5>
                        </div>
                        <a href="{{ route('employees.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                            View All <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="px-4 py-3">Employee</th>
                                    <th class="py-3">Department</th>
                                    <th class="py-3">Position</th>
                                    <th class="py-3">Joined</th>
                                 </thead>
                                <tbody>
                                    @if(isset($recentEmployees) && count($recentEmployees) > 0)
                                        @foreach($recentEmployees as $emp)
                                        <tr class="table-row-premium">
                                            <td class="px-4 py-3">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="avatar-premium">
                                                        {{ strtoupper(substr($emp->name ?? 'U', 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold">{{ $emp->name ?? 'N/A' }}</div>
                                                        <small class="text-muted">{{ $emp->email ?? '' }}</small>
                                                    </div>
                                                </div>
                                             </td>
                                            <td class="py-3">
                                                <span class="badge bg-light text-dark rounded-pill px-3 py-2">
                                                    <i class="fas fa-building me-1"></i>{{ isset($emp->department) && $emp->department ? $emp->department->department_name : 'N/A' }}
                                                </span>
                                             </td>
                                            <td class="py-3">{{ $emp->position ?? 'N/A' }}</td>
                                            <td class="py-3">
                                                @if(isset($emp->joining_date))
                                                    {{ \Carbon\Carbon::parse($emp->joining_date)->format('d M Y') }}
                                                @else
                                                    N/A
                                                @endif
                                             </td>
                                         </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center py-5 text-muted">No employees found</td>
                                        </tr>
                                    @endif
                                </tbody>
                             </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Leave Requests -->
            <div class="card-premium mt-4">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-clock text-warning me-2"></i>
                            <h5 class="fw-bold mb-0 d-inline">Pending Leave Requests</h5>
                        </div>
                        <a href="{{ route('leave.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                            View All <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                 <tr>
                                    <th class="px-4 py-3">Employee</th>
                                    <th class="py-3">Leave Type</th>
                                    <th class="py-3">Duration</th>
                                    <th class="py-3">Days</th>
                                    <th class="py-3 text-end px-4">Actions</th>
                                 </tr>
                            </thead>
                            <tbody>
                                @if(isset($pendingLeaves) && count($pendingLeaves) > 0)
                                    @foreach($pendingLeaves as $leave)
                                    <tr class="table-row-premium">
                                        <td class="px-4 py-3">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="avatar-premium" style="background: linear-gradient(135deg, #f59e0b, #ef4444);">
                                                    {{ strtoupper(substr($leave->employee->name ?? 'U', 0, 1)) }}
                                                </div>
                                                <span class="fw-semibold">{{ $leave->employee->name ?? 'N/A' }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            @php $type = $leave->leave_type ?? ''; @endphp
                                            @if($type == 'sick')
                                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2">
                                                    <i class="fas fa-thermometer"></i> Sick
                                                </span>
                                            @elseif($type == 'casual')
                                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">
                                                    <i class="fas fa-umbrella-beach"></i> Casual
                                                </span>
                                            @else
                                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">
                                                    <i class="fas fa-calendar-alt"></i> Annual
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
                                                <i class="fas fa-clock me-1"></i>{{ $leave->total_days ?? 0 }} days
                                            </span>
                                        </td>
                                        <td class="py-3 text-end px-4">
                                            <div class="d-flex gap-2 justify-content-end">
                                                <form action="{{ route('leave.approve', $leave->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-success rounded-circle" 
                                                            style="width: 34px; height: 34px;" title="Approve">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-sm btn-outline-danger rounded-circle" 
                                                        style="width: 34px; height: 34px;" title="Reject"
                                                        data-bs-toggle="modal" data-bs-target="#rejectModal{{ $leave->id }}">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <i class="fas fa-check-circle fa-3x text-success mb-3 d-block"></i>
                                            <p class="text-muted mb-0">No pending leave requests</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Department Overview & Quick Actions -->
        <div class="col-lg-5">
            <!-- Department Overview -->
            <div class="card-premium">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-building text-success me-2"></i>
                            <h5 class="fw-bold mb-0 d-inline">Departments</h5>
                        </div>
                        <a href="{{ route('departments.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                            Manage <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        @if(isset($departmentCounts) && count($departmentCounts) > 0)
                            @foreach($departmentCounts as $dept)
                            <div class="col-12">
                                <div class="dept-item">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="rounded-2 p-2" style="background: linear-gradient(135deg, #4f46e5, #06b6d4);">
                                                <i class="fas fa-building text-white"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold mb-0">{{ $dept->department_name ?? 'N/A' }}</h6>
                                                <small class="text-muted"><i class="fas fa-user-tie me-1"></i>{{ $dept->department_head ?? 'No Head' }}</small>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                                <span class="fw-bold text-primary">{{ $dept->employees_count ?? 0 }}</span>
                                            </div>
                                            <small class="text-muted">Employees</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="col-12 text-center py-5 text-muted">No departments found</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row g-3 mt-4">
                <div class="col-12">
                    <a href="{{ route('employees.create') }}" class="text-decoration-none">
                        <div class="action-card">
                            <div class="action-icon bg-primary bg-opacity-10 mx-auto">
                                <i class="fas fa-user-plus fa-2x text-primary"></i>
                            </div>
                            <h6 class="fw-bold mb-1">Add Employee</h6>
                            <p class="text-muted small mb-0">Add new team member to your organization</p>
                        </div>
                    </a>
                </div>
                <div class="col-12">
                    <a href="{{ route('attendance.create') }}" class="text-decoration-none">
                        <div class="action-card">
                            <div class="action-icon bg-success bg-opacity-10 mx-auto">
                                <i class="fas fa-calendar-check fa-2x text-success"></i>
                            </div>
                            <h6 class="fw-bold mb-1">Mark Attendance</h6>
                            <p class="text-muted small mb-0">Record daily attendance for employees</p>
                        </div>
                    </a>
                </div>
                <div class="col-12">
                    <a href="{{ route('reports.index') }}" class="text-decoration-none">
                        <div class="action-card">
                            <div class="action-icon bg-warning bg-opacity-10 mx-auto">
                                <i class="fas fa-chart-line fa-2x text-warning"></i>
                            </div>
                            <h6 class="fw-bold mb-1">View Reports</h6>
                            <p class="text-muted small mb-0">Generate insights and analytics</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modals -->
@if(isset($pendingLeaves) && count($pendingLeaves) > 0)
    @foreach($pendingLeaves as $leave)
    <div class="modal fade" id="rejectModal{{ $leave->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white border-0">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-ban me-2"></i>Reject Leave Request
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('leave.reject', $leave->id) }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <p>You are about to reject leave request from <strong class="text-danger">{{ $leave->employee->name ?? 'N/A' }}</strong></p>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Reason for rejection <span class="text-danger">*</span></label>
                            <textarea name="admin_remarks" class="form-control" rows="3" placeholder="Please provide a reason..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pb-4 pe-4">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger rounded-pill px-4">Reject Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
@endif
@endsection