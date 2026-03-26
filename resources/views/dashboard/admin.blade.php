@extends('layouts.app')

@section('title', 'Admin Dashboard')

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

    .stat-card-premium {
        border-radius: 24px;
        padding: 1.5rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        animation: fadeInUp 0.6s ease;
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

    .stat-card-premium.employees::after { background: #4f46e5; }
    .stat-card-premium.departments::after { background: #10b981; }
    .stat-card-premium.present::after { background: #06b6d4; }
    .stat-card-premium.leaves::after { background: #f59e0b; }

    .stat-value {
        font-size: 2.2rem;
        font-weight: 800;
        line-height: 1.2;
    }

    .stat-icon {
        width: 55px;
        height: 55px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .stat-card-premium:hover .stat-icon {
        transform: scale(1.05) rotate(5deg);
    }

    .table-card {
        border-radius: 24px;
        overflow: hidden;
        transition: all 0.3s ease;
        animation: fadeInUp 0.7s ease;
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

    .badge-sick {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    .badge-casual {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }

    .badge-annual {
        background: rgba(79, 70, 229, 0.1);
        color: #4f46e5;
    }

    .badge-unpaid {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
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

    .btn-approve {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }

    .btn-approve:hover {
        background: #10b981;
        color: white;
    }

    .btn-reject {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    .btn-reject:hover {
        background: #ef4444;
        color: white;
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
        .stat-value {
            font-size: 1.5rem;
        }
        .stat-icon {
            width: 45px;
            height: 45px;
        }
        .avatar-sm {
            width: 35px;
            height: 35px;
            font-size: 0.8rem;
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
                        <i class="fas fa-chart-line fa-3x opacity-75"></i>
                        <div>
                            <h1 class="display-5 fw-bold mb-1">Admin Dashboard</h1>
                            <p class="mb-0 opacity-90 fs-5">Welcome back, {{ Auth::user()->name }}! 👋</p>
                        </div>
                    </div>
                </div>
                <div class="welcome-icon mt-3 mt-sm-0">
                    <i class="fas fa-crown fa-2x text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Premium Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card-premium employees bg-white shadow-sm">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small mb-1">Total Employees</div>
                        <div class="stat-value text-primary">{{ isset($totalEmployees) ? $totalEmployees : 0 }}</div>
                        <div class="mt-2">
                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill">
                                <i class="fas fa-chart-line me-1"></i>Active workforce
                            </span>
                        </div>
                    </div>
                    <div class="stat-icon bg-primary bg-opacity-10">
                        <i class="fas fa-users fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card-premium departments bg-white shadow-sm">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small mb-1">Departments</div>
                        <div class="stat-value text-success">{{ isset($totalDepartments) ? $totalDepartments : 0 }}</div>
                        <div class="mt-2">
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill">
                                <i class="fas fa-building me-1"></i>Total divisions
                            </span>
                        </div>
                    </div>
                    <div class="stat-icon bg-success bg-opacity-10">
                        <i class="fas fa-building fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card-premium present bg-white shadow-sm">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small mb-1">Present Today</div>
                        <div class="stat-value text-info">{{ isset($presentToday) ? $presentToday : 0 }}</div>
                        <div class="mt-2">
                            <span class="badge bg-info bg-opacity-10 text-info rounded-pill">
                                <i class="fas fa-calendar-check me-1"></i>Current attendance
                            </span>
                        </div>
                    </div>
                    <div class="stat-icon bg-info bg-opacity-10">
                        <i class="fas fa-user-check fa-2x text-info"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card-premium leaves bg-white shadow-sm">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small mb-1">Pending Leaves</div>
                        <div class="stat-value text-warning">{{ isset($pendingLeaves) ? $pendingLeaves : 0 }}</div>
                        <div class="mt-2">
                            <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill">
                                <i class="fas fa-clock me-1"></i>Awaiting approval
                            </span>
                        </div>
                    </div>
                    <div class="stat-icon bg-warning bg-opacity-10">
                        <i class="fas fa-clock fa-2x text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Two Column Layout -->
    <div class="row g-4">
        <!-- Recent Employees Table -->
        <div class="col-lg-6">
            <div class="table-card bg-white shadow-sm">
                <div class="card-header bg-white py-3 border-0">
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                            <i class="fas fa-users text-primary"></i>
                        </div>
                        <h5 class="fw-bold mb-0">Recent Employees</h5>
                        <span class="badge bg-primary rounded-pill ms-2">{{ isset($recentEmployees) ? count($recentEmployees) : 0 }} New</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="px-4 py-3">Employee</th>
                                    <th class="py-3">Email</th>
                                    <th class="py-3">Department</th>
                                    <th class="py-3">Joined</th>
                                 </thead>
                                <tbody>
                                    @if(isset($recentEmployees) && count($recentEmployees) > 0)
                                        @foreach($recentEmployees as $emp)
                                        <tr class="table-row-premium">
                                            <td class="px-4 py-3">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="avatar-sm">
                                                        {{ strtoupper(substr($emp->name ?? 'U', 0, 1)) }}
                                                    </div>
                                                    <span class="fw-semibold">{{ $emp->name ?? 'N/A' }}</span>
                                                </div>
                                             </td>
                                            <td class="py-3">{{ $emp->email ?? 'N/A' }}</td>
                                            <td class="py-3">
                                                @if(isset($emp->department) && $emp->department)
                                                    <span class="badge bg-light text-dark rounded-pill px-3 py-2">
                                                        <i class="fas fa-building me-1"></i>{{ $emp->department->department_name }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                             </td>
                                            <td class="py-3">{{ isset($emp->created_at) ? $emp->created_at->format('d M Y') : 'N/A' }}</td>
                                         </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center py-5">
                                                <i class="fas fa-users fa-3x text-muted mb-3 d-block"></i>
                                                <p class="text-muted mb-0">No employees found</p>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                             </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Leave Requests -->
            <div class="col-lg-6">
                <div class="table-card bg-white shadow-sm">
                    <div class="card-header bg-white py-3 border-0">
                        <div class="d-flex align-items-center gap-2">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-2">
                                <i class="fas fa-clock text-warning"></i>
                            </div>
                            <h5 class="fw-bold mb-0">Pending Leave Requests</h5>
                            <span class="badge bg-warning rounded-pill ms-2">{{ isset($recentLeaves) ? count($recentLeaves) : 0 }} Pending</span>
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
                                    @if(isset($recentLeaves) && count($recentLeaves) > 0)
                                        @foreach($recentLeaves as $leave)
                                        <tr class="table-row-premium">
                                            <td class="px-4 py-3">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="avatar-sm" style="background: linear-gradient(135deg, #f59e0b, #ef4444);">
                                                        {{ strtoupper(substr($leave->employee->name ?? 'U', 0, 1)) }}
                                                    </div>
                                                    <span class="fw-semibold">{{ $leave->employee->name ?? 'N/A' }}</span>
                                                </div>
                                            </td>
                                            <td class="py-3">
                                                @php $type = $leave->leave_type ?? ''; @endphp
                                                @if($type == 'sick')
                                                    <span class="badge-status badge-sick">
                                                        <i class="fas fa-thermometer"></i> Sick
                                                    </span>
                                                @elseif($type == 'casual')
                                                    <span class="badge-status badge-casual">
                                                        <i class="fas fa-umbrella-beach"></i> Casual
                                                    </span>
                                                @elseif($type == 'annual')
                                                    <span class="badge-status badge-annual">
                                                        <i class="fas fa-calendar-alt"></i> Annual
                                                    </span>
                                                @else
                                                    <span class="badge-status badge-unpaid">
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
                                                    <i class="fas fa-clock me-1"></i>{{ $leave->total_days ?? 0 }} days
                                                </span>
                                            </td>
                                            <td class="py-3 text-end px-4">
                                                <div class="d-flex gap-2 justify-content-end">
                                                    <form action="{{ route('leave.approve', $leave->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn-action btn-approve" 
                                                                title="Approve" onclick="return confirm('Approve this leave request?')">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                    <button type="button" class="btn-action btn-reject" 
                                                            title="Reject" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $leave->id }}">
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
        </div>
    </div>
</div>

<!-- Reject Modals -->
@if(isset($recentLeaves) && count($recentLeaves) > 0)
    @foreach($recentLeaves as $leave)
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