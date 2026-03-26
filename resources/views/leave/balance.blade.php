@extends('layouts.app')

@section('title', 'Leave Balance')

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

    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
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

    .page-header {
        background: linear-gradient(135deg, #4f46e5, #06b6d4);
        border-radius: 28px;
        position: relative;
        overflow: hidden;
        animation: fadeInUp 0.5s ease;
    }

    .page-header::before {
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

    .profile-card {
        background: white;
        border-radius: 24px;
        transition: all 0.3s ease;
        animation: fadeInUp 0.6s ease;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }

    .profile-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .profile-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4f46e5, #06b6d4);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
    }

    .profile-avatar:hover {
        transform: scale(1.05) rotate(5deg);
        box-shadow: 0 15px 35px rgba(79, 70, 229, 0.4);
    }

    .balance-card {
        border-radius: 24px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        animation: fadeInUp 0.7s ease;
        cursor: pointer;
    }

    .balance-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 35px -15px rgba(0, 0, 0, 0.2);
    }

    .balance-card::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 4px;
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .balance-card.sick::after { background: #ef4444; }
    .balance-card.casual::after { background: #10b981; }
    .balance-card.annual::after { background: #8b5cf6; }
    .balance-card.unpaid::after { background: #f59e0b; }

    .balance-card:hover::after {
        transform: scaleX(1);
    }

    .balance-icon {
        width: 55px;
        height: 55px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .balance-card:hover .balance-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 800;
        line-height: 1;
    }

    .stat-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.7;
    }

    .btn-action {
        transition: all 0.3s ease;
        border-radius: 50px;
        padding: 0.6rem 1.5rem;
        font-weight: 600;
    }

    .btn-action:hover {
        transform: translateY(-2px);
    }

    .btn-apply {
        background: linear-gradient(135deg, #4f46e5, #06b6d4);
        color: white;
        border: none;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
    }

    .btn-apply:hover {
        box-shadow: 0 8px 20px rgba(79, 70, 229, 0.3);
    }

    .btn-requests {
        background: white;
        color: #4f46e5;
        border: 1px solid #4f46e5;
    }

    .btn-requests:hover {
        background: #4f46e5;
        color: white;
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

    .table-row-premium {
        transition: all 0.2s ease;
        border-bottom: 1px solid #f0f0f0;
    }

    .table-row-premium:hover {
        background: linear-gradient(90deg, #f8f9ff, transparent);
        transform: translateX(3px);
    }

    .progress-premium {
        height: 6px;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.2);
        overflow: hidden;
    }

    .progress-premium .progress-bar {
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

    @media (max-width: 768px) {
        .stat-value {
            font-size: 1.5rem;
        }
        .profile-avatar {
            width: 80px;
            height: 80px;
        }
        .balance-icon {
            width: 45px;
            height: 45px;
        }
    }
</style>

<div class="container-fluid px-4 py-4">
    
    <!-- Premium Header -->
    <div class="page-header mb-4">
        <div class="p-4 position-relative">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="text-white">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <i class="fas fa-chart-pie fa-3x opacity-75"></i>
                        <div>
                            <h1 class="display-5 fw-bold mb-1">Leave Balance</h1>
                            <p class="mb-0 opacity-90 fs-5">View your leave balance and usage history</p>
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-2 mt-3 mt-sm-0">
                    <a href="{{ route('leave.create') }}" class="btn-action btn-apply">
                        <i class="fas fa-plus-circle me-2"></i>Apply for Leave
                    </a>
                    <a href="{{ route('leave.index') }}" class="btn-action btn-requests">
                        <i class="fas fa-list me-2"></i>My Requests
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Employee Profile Card -->
    @if(isset($employee) && $employee)
    <div class="profile-card mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-2 text-center">
                    <div class="profile-avatar mx-auto">
                        <span>{{ strtoupper(substr($employee->name ?? 'U', 0, 1)) }}</span>
                    </div>
                </div>
                <div class="col-md-10 text-center text-md-start mt-3 mt-md-0">
                    <h3 class="fw-bold mb-2">{{ $employee->name ?? 'N/A' }}</h3>
                    <div class="d-flex flex-wrap gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-envelope text-primary"></i>
                            <span class="text-muted">{{ $employee->email ?? 'N/A' }}</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-briefcase text-primary"></i>
                            <span class="text-muted">{{ $employee->position ?? 'Employee' }}</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-calendar-alt text-primary"></i>
                            <span class="text-muted">Joined: {{ $employee->joining_date ? \Carbon\Carbon::parse($employee->joining_date)->format('d M Y') : 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Balance Cards -->
    <div class="row g-4 mb-5">
        <!-- Sick Leave Card -->
        <div class="col-sm-6 col-lg-3">
            <div class="balance-card sick" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                <div class="card-body p-4 text-white">
                    <div class="balance-icon bg-white bg-opacity-20">
                        <i class="fas fa-thermometer-half fa-2x"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Sick Leave</h5>
                    <div class="mb-2 d-flex justify-content-between">
                        <span>Total</span>
                        <strong>{{ $balances['sick']['total'] ?? 12 }}</strong>
                    </div>
                    <div class="mb-2 d-flex justify-content-between">
                        <span>Used</span>
                        <strong>{{ $balances['sick']['used'] ?? 0 }}</strong>
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <span>Remaining</span>
                        <strong class="fs-3">{{ $balances['sick']['remaining'] ?? 12 }}</strong>
                    </div>
                    <div class="progress-premium">
                        @php
                            $total = $balances['sick']['total'] ?? 12;
                            $used = $balances['sick']['used'] ?? 0;
                            $percent = $total > 0 ? ($used / $total) * 100 : 0;
                        @endphp
                        <div class="progress-bar bg-white" style="width: {{ $percent }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Casual Leave Card -->
        <div class="col-sm-6 col-lg-3">
            <div class="balance-card casual" style="background: linear-gradient(135deg, #10b981, #059669);">
                <div class="card-body p-4 text-white">
                    <div class="balance-icon bg-white bg-opacity-20">
                        <i class="fas fa-umbrella-beach fa-2x"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Casual Leave</h5>
                    <div class="mb-2 d-flex justify-content-between">
                        <span>Total</span>
                        <strong>{{ $balances['casual']['total'] ?? 12 }}</strong>
                    </div>
                    <div class="mb-2 d-flex justify-content-between">
                        <span>Used</span>
                        <strong>{{ $balances['casual']['used'] ?? 0 }}</strong>
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <span>Remaining</span>
                        <strong class="fs-3">{{ $balances['casual']['remaining'] ?? 12 }}</strong>
                    </div>
                    <div class="progress-premium">
                        @php
                            $total = $balances['casual']['total'] ?? 12;
                            $used = $balances['casual']['used'] ?? 0;
                            $percent = $total > 0 ? ($used / $total) * 100 : 0;
                        @endphp
                        <div class="progress-bar bg-white" style="width: {{ $percent }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Annual Leave Card -->
        <div class="col-sm-6 col-lg-3">
            <div class="balance-card annual" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                <div class="card-body p-4 text-white">
                    <div class="balance-icon bg-white bg-opacity-20">
                        <i class="fas fa-calendar-alt fa-2x"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Annual Leave</h5>
                    <div class="mb-2 d-flex justify-content-between">
                        <span>Total</span>
                        <strong>{{ $balances['annual']['total'] ?? 15 }}</strong>
                    </div>
                    <div class="mb-2 d-flex justify-content-between">
                        <span>Used</span>
                        <strong>{{ $balances['annual']['used'] ?? 0 }}</strong>
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <span>Remaining</span>
                        <strong class="fs-3">{{ $balances['annual']['remaining'] ?? 15 }}</strong>
                    </div>
                    <div class="progress-premium">
                        @php
                            $total = $balances['annual']['total'] ?? 15;
                            $used = $balances['annual']['used'] ?? 0;
                            $percent = $total > 0 ? ($used / $total) * 100 : 0;
                        @endphp
                        <div class="progress-bar bg-white" style="width: {{ $percent }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Unpaid Leave Card -->
        <div class="col-sm-6 col-lg-3">
            <div class="balance-card unpaid" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                <div class="card-body p-4 text-white">
                    <div class="balance-icon bg-white bg-opacity-20">
                        <i class="fas fa-coins fa-2x"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Unpaid Leave</h5>
                    <div class="mb-2 d-flex justify-content-between">
                        <span>Total</span>
                        <strong>{{ $balances['unpaid']['total'] ?? '∞' }}</strong>
                    </div>
                    <div class="mb-2 d-flex justify-content-between">
                        <span>Used</span>
                        <strong>{{ $balances['unpaid']['used'] ?? 0 }}</strong>
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <span>Remaining</span>
                        <strong class="fs-3">{{ $balances['unpaid']['remaining'] ?? '∞' }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Leave Requests -->
    @if(isset($recentLeaves) && count($recentLeaves) > 0)
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3 border-0">
            <div class="d-flex align-items-center gap-2">
                <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                    <i class="fas fa-history text-primary"></i>
                </div>
                <h5 class="fw-bold mb-0">Recent Leave Requests</h5>
                <span class="badge bg-primary rounded-pill ms-2">{{ count($recentLeaves) }} Records</span>
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
                        @foreach($recentLeaves as $leave)
                        <tr class="table-row-premium">
                            <td class="px-4 py-3">
                                @if($leave->leave_type == 'sick')
                                    <span class="badge-status badge-approved">
                                        <i class="fas fa-thermometer-half"></i> Sick Leave
                                    </span>
                                @elseif($leave->leave_type == 'casual')
                                    <span class="badge-status badge-approved">
                                        <i class="fas fa-umbrella-beach"></i> Casual Leave
                                    </span>
                                @elseif($leave->leave_type == 'annual')
                                    <span class="badge-status badge-approved">
                                        <i class="fas fa-calendar-alt"></i> Annual Leave
                                    </span>
                                @else
                                    <span class="badge-status badge-pending">
                                        <i class="fas fa-coins"></i> Unpaid Leave
                                    </span>
                                @endif
                              </td>
                            <td class="py-3">
                                <div class="fw-semibold">{{ \Carbon\Carbon::parse($leave->start_date)->format('d M') }} - 
                                {{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}</div>
                              </td>
                            <td class="py-3">
                                <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3 py-2">
                                    <i class="fas fa-calendar-day me-1"></i>{{ $leave->total_days }} days
                                </span>
                              </td>
                            <td class="py-3">
                                @if($leave->status == 'approved')
                                    <span class="badge-status badge-approved">
                                        <i class="fas fa-check-circle"></i> Approved
                                    </span>
                                @elseif($leave->status == 'rejected')
                                    <span class="badge-status badge-rejected">
                                        <i class="fas fa-times-circle"></i> Rejected
                                    </span>
                                @else
                                    <span class="badge-status badge-pending">
                                        <i class="fas fa-hourglass-half"></i> Pending
                                    </span>
                                @endif
                              </td>
                            <td class="py-3">
                                <div class="fw-semibold">{{ \Carbon\Carbon::parse($leave->created_at)->format('d M Y') }}</div>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($leave->created_at)->diffForHumans() }}</small>
                              </td>
                         </tr>
                        @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Quick Stats Summary -->
    <div class="row mt-4 g-3">
        <div class="col-md-4">
            <div class="bg-light rounded-4 p-3 text-center">
                <i class="fas fa-chart-line fa-2x text-primary mb-2"></i>
                <h6 class="fw-bold mb-1">Total Leave Used</h6>
                <h3 class="fw-bold text-primary">
                    {{ ($balances['sick']['used'] ?? 0) + ($balances['casual']['used'] ?? 0) + ($balances['annual']['used'] ?? 0) + ($balances['unpaid']['used'] ?? 0) }}
                </h3>
                <small class="text-muted">days taken this year</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bg-light rounded-4 p-3 text-center">
                <i class="fas fa-calendar-check fa-2x text-success mb-2"></i>
                <h6 class="fw-bold mb-1">Total Leave Remaining</h6>
                <h3 class="fw-bold text-success">
                    {{ ($balances['sick']['remaining'] ?? 0) + ($balances['casual']['remaining'] ?? 0) + ($balances['annual']['remaining'] ?? 0) }}
                </h3>
                <small class="text-muted">available for use</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bg-light rounded-4 p-3 text-center">
                <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                <h6 class="fw-bold mb-1">Pending Requests</h6>
                <h3 class="fw-bold text-warning">
                    {{ isset($recentLeaves) ? $recentLeaves->where('status', 'pending')->count() : 0 }}
                </h3>
                <small class="text-muted">awaiting approval</small>
            </div>
        </div>
    </div>
</div>
@endsection