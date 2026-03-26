@extends('layouts.app')

@section('title', 'Salary Management')

@section('content')
<style>
    /* ========================================
       ULTRA PREMIUM SALARY MANAGEMENT DESIGN
    ======================================== */
    
    :root {
        --primary: #4361ee;
        --primary-dark: #3a0ca3;
        --primary-light: #4895ef;
        --secondary: #4cc9f0;
        --success: #10b981;
        --danger: #ef4444;
        --warning: #f59e0b;
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

    /* Header */
    .page-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-radius: var(--radius-xl);
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-xl);
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
        background: linear-gradient(90deg, var(--primary), var(--secondary));
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
        width: 55px;
        height: 55px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .stat-card-premium:hover .stat-icon-premium {
        transform: scale(1.05) rotate(5deg);
    }

    .stat-value-premium {
        font-size: 1.8rem;
        font-weight: 800;
        line-height: 1.2;
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
        transform: translateY(-2px);
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
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-weight: 700;
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

    .badge-paid {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }

    .badge-pending {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }

    /* Buttons */
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

    .btn-view-premium {
        background: rgba(67, 97, 238, 0.1);
        color: var(--primary);
    }

    .btn-view-premium:hover {
        background: var(--primary);
        color: var(--white);
    }

    .btn-download-premium {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }

    .btn-download-premium:hover {
        background: #10b981;
        color: var(--white);
    }

    /* Form Controls */
    .form-control-premium, .form-select-premium {
        border: 2px solid #e2e8f0;
        border-radius: var(--radius-md);
        padding: 0.75rem 1rem;
        transition: all 0.2s ease;
    }

    .form-control-premium:focus, .form-select-premium:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        outline: none;
    }

    @media (max-width: 768px) {
        .stat-value-premium {
            font-size: 1.5rem;
        }
        .avatar-premium {
            width: 38px;
            height: 38px;
        }
        .btn-action-premium {
            width: 32px;
            height: 32px;
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
                        <i class="fas fa-wallet fa-3x opacity-75"></i>
                        <div>
                            <h1 class="display-5 fw-bold mb-1">Salary Management</h1>
                            <p class="mb-0 opacity-90 fs-5">Manage and track employee salary records</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('salary.create') }}" class="btn btn-light rounded-pill px-4 py-2 shadow-sm mt-3 mt-sm-0">
                    <i class="fas fa-plus-circle me-2"></i>Process Salary
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-5">
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card-premium">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stat-icon-premium bg-primary bg-opacity-10">
                        <i class="fas fa-file-invoice-dollar fa-2x text-primary"></i>
                    </div>
                </div>
                <div class="stat-value-premium text-primary">{{ $salaries->total() }}</div>
                <div class="text-muted mb-2">Total Records</div>
                <div class="mt-2">
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill">
                        <i class="fas fa-chart-line me-1"></i>All time
                    </span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card-premium">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stat-icon-premium bg-success bg-opacity-10">
                        <i class="fas fa-dollar-sign fa-2x text-success"></i>
                    </div>
                </div>
                <div class="stat-value-premium text-success">${{ number_format($salaries->sum('net_salary'), 0) }}</div>
                <div class="text-muted mb-2">Total Paid</div>
                <div class="mt-2">
                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill">
                        <i class="fas fa-chart-line me-1"></i>Year to date
                    </span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card-premium">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stat-icon-premium bg-info bg-opacity-10">
                        <i class="fas fa-check-circle fa-2x text-info"></i>
                    </div>
                </div>
                <div class="stat-value-premium text-info">{{ $salaries->where('status', 'paid')->count() }}</div>
                <div class="text-muted mb-2">Paid Salaries</div>
                <div class="mt-2">
                    <span class="badge bg-info bg-opacity-10 text-info rounded-pill">
                        <i class="fas fa-check-circle me-1"></i>Completed
                    </span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card-premium">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stat-icon-premium bg-warning bg-opacity-10">
                        <i class="fas fa-hourglass-half fa-2x text-warning"></i>
                    </div>
                </div>
                <div class="stat-value-premium text-warning">{{ $salaries->where('status', 'pending')->count() }}</div>
                <div class="text-muted mb-2">Pending Salaries</div>
                <div class="mt-2">
                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill">
                        <i class="fas fa-hourglass-half me-1"></i>Awaiting
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="filter-card-premium mb-4">
        <div class="d-flex align-items-center gap-2 mb-3">
            <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                <i class="fas fa-sliders-h text-primary"></i>
            </div>
            <h5 class="fw-bold mb-0">Filter Salaries</h5>
        </div>
        <form action="{{ route('salary.index') }}" method="GET" class="row g-3">
            <div class="col-md-5">
                <label class="form-label fw-semibold small text-muted">
                    <i class="fas fa-calendar-alt me-1"></i>Month
                </label>
                <select name="month" class="form-select-premium w-100">
                    <option value="">All Months</option>
                    @foreach($months as $month)
                        <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                            {{ $month }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <label class="form-label fw-semibold small text-muted">
                    <i class="fas fa-calendar-alt me-1"></i>Year
                </label>
                <select name="year" class="form-select-premium w-100">
                    <option value="">All Years</option>
                    @for($y = date('Y'); $y >= date('Y')-2; $y--)
                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold">
                    <i class="fas fa-search me-2"></i>Apply
                </button>
                <a href="{{ route('salary.index') }}" class="btn btn-outline-secondary w-100 rounded-pill py-2">
                    <i class="fas fa-undo me-2"></i>Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Salary Table -->
    <div class="table-container-premium">
        <div class="table-responsive">
            <table class="table table-premium">
                <thead>
                    <tr>
                        <th style="width: 22%">Employee</th>
                        <th style="width: 8%">Month</th>
                        <th style="width: 6%">Year</th>
                        <th style="width: 10%">Basic</th>
                        <th style="width: 10%">Allowances</th>
                        <th style="width: 10%">Deductions</th>
                        <th style="width: 8%">Tax</th>
                        <th style="width: 10%">Net Salary</th>
                        <th style="width: 8%">Status</th>
                        <th style="width: 8%" class="text-end">Actions</th>
                    </thead>
                <tbody>
                    @forelse($salaries as $salary)
                    <tr class="table-row-premium">
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-premium">
                                    {{ strtoupper(substr($salary->employee->name ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $salary->employee->name ?? 'N/A' }}</div>
                                    <div class="small text-muted">{{ $salary->employee->email ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 fw-semibold">{{ $salary->month }}</td>
                        <td class="py-3">{{ $salary->year }}</td>
                        <td class="py-3">
                            <span class="text-success fw-semibold">${{ number_format($salary->basic_salary, 2) }}</span>
                        </td>
                        <td class="py-3">
                            <span class="text-primary fw-semibold">${{ number_format($salary->allowances, 2) }}</span>
                        </td>
                        <td class="py-3">
                            <span class="text-danger fw-semibold">-${{ number_format($salary->deductions, 2) }}</span>
                        </td>
                        <td class="py-3">
                            <span class="text-warning fw-semibold">-${{ number_format($salary->tax, 2) }}</span>
                        </td>
                        <td class="py-3">
                            <span class="fw-bold text-info">${{ number_format($salary->net_salary, 2) }}</span>
                        </td>
                        <td class="py-3">
                            @if($salary->status == 'paid')
                                <span class="badge-status-premium badge-paid">
                                    <i class="fas fa-check-circle"></i> Paid
                                </span>
                            @else
                                <span class="badge-status-premium badge-pending">
                                    <i class="fas fa-hourglass-half"></i> Pending
                                </span>
                            @endif
                        </td>
                        <td class="py-3 text-end">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('salary.show', $salary) }}" class="btn-action-premium btn-view-premium" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('salary.download', $salary) }}" class="btn-action-premium btn-download-premium" title="Download Slip">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-5">
                            <div class="py-5">
                                <i class="fas fa-money-bill-wave fa-5x text-muted mb-4 d-block"></i>
                                <h4 class="fw-bold text-muted mb-2">No Salary Records Found</h4>
                                <p class="text-muted mb-4">Process salaries for your employees</p>
                                <a href="{{ route('salary.create') }}" class="btn btn-primary rounded-pill px-5 py-2">
                                    <i class="fas fa-plus me-2"></i>Process Salary
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($salaries->hasPages())
        <div class="d-flex justify-content-center py-3 border-top">
            {{ $salaries->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>
@endsection