@extends('layouts.app')

@section('title', 'Leave Management')

@section('content')
<style>
    /* ========================================
       ULTRA PREMIUM LEAVE MANAGEMENT DESIGN
    ======================================== */
    
    :root {
        --primary: #4361ee;
        --primary-light: #4895ef;
        --primary-dark: #3f37c9;
        --success: #10b981;
        --success-dark: #059669;
        --danger: #ef4444;
        --danger-dark: #dc2626;
        --warning: #f59e0b;
        --warning-dark: #d97706;
        --info: #3b82f6;
        --dark: #1e293b;
        --gray: #64748b;
        --light: #f8fafc;
        --white: #ffffff;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        --radius-sm: 0.5rem;
        --radius-md: 1rem;
        --radius-lg: 1.5rem;
        --radius-xl: 2rem;
    }

    /* Animations */
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

    /* Header */
    .header-premium {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-radius: var(--radius-xl);
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-xl);
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

    /* Stat Cards */
    .stat-card-premium {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(0, 0, 0, 0.05);
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
        background: linear-gradient(90deg, var(--primary), var(--primary-light));
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .stat-card-premium:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .stat-card-premium:hover::after {
        transform: scaleX(1);
    }

    .stat-icon-premium {
        width: 50px;
        height: 50px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .stat-card-premium:hover .stat-icon-premium {
        transform: scale(1.05) rotate(5deg);
    }

    .stat-number-premium {
        font-size: 2rem;
        font-weight: 800;
        color: var(--dark);
        line-height: 1.2;
    }

    .stat-label-premium {
        color: var(--gray);
        font-size: 0.85rem;
        margin-top: 0.25rem;
    }

    /* Filter Card */
    .filter-card-premium {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
        animation: fadeInUp 0.7s ease;
    }

    .filter-card-premium:hover {
        box-shadow: var(--shadow-lg);
    }

    /* Table */
    .table-container-premium {
        background: var(--white);
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        animation: fadeInUp 0.8s ease;
    }

    .table-premium {
        margin-bottom: 0;
    }

    .table-premium thead {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    }

    .table-premium th {
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--gray);
        padding: 1rem 1.25rem;
        border-bottom: 2px solid #e2e8f0;
    }

    .table-premium td {
        padding: 1rem 1.25rem;
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
    }

    .table-row-premium {
        transition: all 0.2s ease;
    }

    .table-row-premium:hover {
        background: linear-gradient(90deg, #f8f9ff, transparent);
        transform: translateX(4px);
    }

    /* Avatar */
    .avatar-premium {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-weight: 700;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
    }

    .avatar-premium:hover {
        transform: scale(1.05);
        box-shadow: var(--shadow-md);
    }

    /* Badges */
    .badge-status-premium {
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

    .badge-sick {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    .badge-casual {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }

    .badge-annual {
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
    }

    .badge-unpaid {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }

    /* Buttons */
    .btn-action-premium {
        padding: 8px 18px;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .btn-action-premium::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s ease;
    }

    .btn-action-premium:hover::before {
        left: 100%;
    }

    .btn-action-premium:hover {
        transform: translateY(-2px);
    }

    .btn-approve-premium {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        box-shadow: 0 2px 6px rgba(16, 185, 129, 0.2);
    }

    .btn-reject-premium {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        box-shadow: 0 2px 6px rgba(239, 68, 68, 0.2);
    }

    .btn-cancel-premium {
        background: linear-gradient(135deg, #6c757d, #5a6268);
        color: white;
        box-shadow: 0 2px 6px rgba(108, 117, 125, 0.2);
    }

    /* Modal */
    .modal-premium {
        border-radius: var(--radius-xl);
        overflow: hidden;
        border: none;
    }

    .modal-header-premium {
        padding: 1.25rem;
        border: none;
    }

    .modal-header-danger {
        background: linear-gradient(135deg, var(--danger), var(--danger-dark));
    }

    /* Form Controls */
    .form-control-premium {
        border: 2px solid #e2e8f0;
        border-radius: var(--radius-md);
        padding: 0.75rem 1rem;
        transition: all 0.2s ease;
    }

    .form-control-premium:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        outline: none;
    }

    /* Select */
    .select-premium {
        border: 2px solid #e2e8f0;
        border-radius: var(--radius-md);
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
        background-color: var(--white);
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .select-premium:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        outline: none;
    }

    /* Reason Text */
    .reason-text {
        max-width: 220px;
        cursor: pointer;
        color: var(--gray);
        font-size: 0.85rem;
        transition: color 0.2s;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .reason-text:hover {
        color: var(--dark);
        text-decoration: underline;
    }

    /* Alert */
    .alert-premium {
        border-radius: var(--radius-lg);
        border: none;
        padding: 1rem 1.25rem;
        box-shadow: var(--shadow-sm);
        animation: fadeInUp 0.3s ease;
    }

    /* Pagination */
    .pagination-premium {
        gap: 6px;
    }

    .pagination-premium .page-link {
        border-radius: 12px;
        border: none;
        padding: 8px 14px;
        color: var(--primary);
        font-weight: 500;
        transition: all 0.2s;
        background: transparent;
    }

    .pagination-premium .page-link:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-1px);
    }

    .pagination-premium .active .page-link {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
        box-shadow: var(--shadow-sm);
    }

    /* Empty State */
    .empty-state {
        padding: 4rem 2rem;
        text-align: center;
        background: linear-gradient(135deg, #fafcff, #f5f7fb);
        border-radius: 24px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .stat-number-premium {
            font-size: 1.5rem;
        }
        .btn-action-premium {
            padding: 6px 12px;
            font-size: 0.7rem;
        }
        .table-premium th, .table-premium td {
            padding: 0.75rem;
        }
        .avatar-premium {
            width: 40px;
            height: 40px;
            font-size: 0.9rem;
        }
    }
</style>

<div class="container-fluid px-4 py-4">
    
    <!-- Premium Header -->
    <div class="header-premium mb-4">
        <div class="p-4 position-relative">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="text-white">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <i class="fas fa-calendar-alt fa-3x opacity-75"></i>
                        <div>
                            <h1 class="display-5 fw-bold mb-1">Leave Management</h1>
                            <p class="mb-0 opacity-90 fs-5">Track and manage employee leave requests efficiently</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('leave.create') }}" class="btn btn-light rounded-pill px-4 py-2 shadow-sm mt-3 mt-sm-0">
                    <i class="fas fa-plus-circle me-2"></i>Apply for Leave
                </a>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show alert-premium mb-4">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-check-circle fa-lg"></i>
                <span class="fw-semibold">{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show alert-premium mb-4">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-exclamation-circle fa-lg"></i>
                <span class="fw-semibold">{{ session('error') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card-premium">
                <div class="stat-icon-premium" style="background: linear-gradient(135deg, rgba(67,97,238,0.1), rgba(76,201,240,0.1));">
                    <i class="fas fa-hourglass-half fa-2x text-primary"></i>
                </div>
                <div class="stat-number-premium text-primary">{{ $leaveRequests->where('status', 'pending')->count() }}</div>
                <div class="stat-label-premium">Pending Requests</div>
                <div class="mt-2">
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill">Awaiting Approval</span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card-premium">
                <div class="stat-icon-premium" style="background: linear-gradient(135deg, rgba(16,185,129,0.1), rgba(5,150,105,0.1));">
                    <i class="fas fa-check-circle fa-2x text-success"></i>
                </div>
                <div class="stat-number-premium text-success">{{ $leaveRequests->where('status', 'approved')->count() }}</div>
                <div class="stat-label-premium">Approved Requests</div>
                <div class="mt-2">
                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill">Leaves Granted</span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card-premium">
                <div class="stat-icon-premium" style="background: linear-gradient(135deg, rgba(239,68,68,0.1), rgba(220,38,38,0.1));">
                    <i class="fas fa-times-circle fa-2x text-danger"></i>
                </div>
                <div class="stat-number-premium text-danger">{{ $leaveRequests->where('status', 'rejected')->count() }}</div>
                <div class="stat-label-premium">Rejected Requests</div>
                <div class="mt-2">
                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill">Not Approved</span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card-premium">
                <div class="stat-icon-premium" style="background: linear-gradient(135deg, rgba(245,158,11,0.1), rgba(234,88,12,0.1));">
                    <i class="fas fa-calendar-day fa-2x text-warning"></i>
                </div>
                <div class="stat-number-premium text-warning">{{ $leaveRequests->sum('total_days') }}</div>
                <div class="stat-label-premium">Total Days Taken</div>
                <div class="mt-2">
                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill">Year to Date</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-card-premium mb-4">
        <div class="d-flex align-items-center gap-2 mb-3">
            <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                <i class="fas fa-sliders-h text-primary"></i>
            </div>
            <h5 class="fw-bold mb-0">Filter Requests</h5>
        </div>
        <form action="{{ route('leave.index') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-9">
                    <select name="status" class="select-premium w-100">
                        <option value="">📋 All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>✅ Approved</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>❌ Rejected</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold">
                        <i class="fas fa-search me-2"></i>Apply Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Leave Requests Table -->
    <div class="table-container-premium">
        <div class="table-responsive">
            <table class="table table-premium">
                <thead>
                    <tr>
                        <th style="width: 25%">Employee</th>
                        <th style="width: 12%">Leave Type</th>
                        <th style="width: 20%">Duration</th>
                        <th style="width: 8%">Days</th>
                        <th style="width: 20%">Reason</th>
                        <th style="width: 10%">Status</th>
                        <th style="width: 5%" class="text-end">Actions</th>
                     </thead>
                <tbody>
                    @forelse($leaveRequests as $request)
                    <tr class="table-row-premium">
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-premium">
                                    {{ strtoupper(substr($request->employee->name ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $request->employee->name ?? 'N/A' }}</div>
                                    <div class="small text-muted">{{ $request->employee->email ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge-status-premium badge-{{ $request->leave_type ?? 'unpaid' }}">
                                <i class="fas {{ $request->leave_type == 'sick' ? 'fa-thermometer-half' : ($request->leave_type == 'casual' ? 'fa-umbrella-beach' : ($request->leave_type == 'annual' ? 'fa-calendar-alt' : 'fa-coins')) }}"></i>
                                {{ ucfirst($request->leave_type ?? 'Unpaid') }}
                            </span>
                        </td>
                        <td>
                            <div class="fw-semibold">{{ \Carbon\Carbon::parse($request->start_date)->format('d M Y') }}</div>
                            <div class="small text-muted">→ {{ \Carbon\Carbon::parse($request->end_date)->format('d M Y') }}</div>
                        </td>
                        <td>
                            <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3 py-2">
                                <i class="fas fa-clock me-1"></i>{{ $request->total_days }} days
                            </span>
                        </td>
                        <td>
                            <div class="reason-text" title="Click to view full reason" onclick="alert('{{ addslashes($request->reason) }}')">
                                <i class="fas fa-quote-left text-muted"></i>
                                {{ Str::limit($request->reason ?? 'No reason provided', 40) }}
                            </div>
                        </td>
                        <td>
                            @if($request->status == 'approved')
                                <span class="badge-status-premium badge-approved">
                                    <i class="fas fa-check-circle"></i> Approved
                                </span>
                            @elseif($request->status == 'rejected')
                                <span class="badge-status-premium badge-rejected">
                                    <i class="fas fa-times-circle"></i> Rejected
                                </span>
                            @else
                                <span class="badge-status-premium badge-pending">
                                    <i class="fas fa-hourglass-half"></i> Pending
                                </span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-flex gap-2 justify-content-end">
                                @if(Auth::user()->role == 'admin' && $request->status == 'pending')
                                    <form action="{{ route('leave.approve', $request->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn-action-premium btn-approve-premium" onclick="return confirm('✅ Approve this leave request from {{ $request->employee->name }}?')">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                    </form>
                                    <button type="button" class="btn-action-premium btn-reject-premium" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $request->id }}">
                                        <i class="fas fa-times"></i> Reject
                                    </button>
                                @endif
                                @if(Auth::user()->role != 'admin' && $request->status == 'pending')
                                    <form action="{{ route('leave.cancel', $request->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action-premium btn-cancel-premium" onclick="return confirm('❌ Cancel your leave request?')">
                                            <i class="fas fa-trash-alt"></i> Cancel
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>

                    <!-- Reject Modal -->
                    @if(Auth::user()->role == 'admin')
                    <div class="modal fade" id="rejectModal{{ $request->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content modal-premium">
                                <div class="modal-header-premium modal-header-danger text-white">
                                    <h5 class="modal-title fw-bold">
                                        <i class="fas fa-ban me-2"></i>Reject Leave Request
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('leave.reject', $request->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-body p-4">
                                        <div class="alert alert-warning mb-4">
                                            <i class="fas fa-info-circle me-2"></i>
                                            You are about to reject leave request from <strong>{{ $request->employee->name }}</strong>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">
                                                <i class="fas fa-comment text-danger me-2"></i>Reason for Rejection
                                                <span class="text-danger">*</span>
                                            </label>
                                            <textarea name="admin_remarks" class="form-control-premium w-100" rows="4" 
                                                      placeholder="Please provide a clear reason for rejection..." required></textarea>
                                            <small class="text-muted mt-2 d-block">
                                                <i class="fas fa-info-circle me-1"></i>This reason will be shared with the employee
                                            </small>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0 p-4 pt-0">
                                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                                            <i class="fas fa-times me-2"></i>Cancel
                                        </button>
                                        <button type="submit" class="btn btn-danger rounded-pill px-4">
                                            <i class="fas fa-ban me-2"></i>Confirm Rejection
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-calendar-times fa-5x text-muted mb-4 d-block"></i>
                                <h4 class="fw-bold text-muted mb-2">No Leave Requests Found</h4>
                                <p class="text-muted mb-4">Apply for leave or wait for requests from employees</p>
                                <a href="{{ route('leave.create') }}" class="btn btn-primary rounded-pill px-5 py-2">
                                    <i class="fas fa-plus me-2"></i>Apply for Leave
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
             </table>
        </div>
        @if($leaveRequests->hasPages())
        <div class="px-4 py-3 border-top">
            <div class="d-flex justify-content-center">
                {{ $leaveRequests->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection