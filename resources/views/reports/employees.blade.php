@extends('layouts.app')

@section('title', 'Employees Report')

@section('content')
<style>
    /* ========================================
       ULTRA PREMIUM EMPLOYEES REPORT DESIGN
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

    /* Filter Card */
    .filter-card-premium {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
        animation: fadeInUp 0.6s ease;
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
        animation: fadeInUp 0.7s ease;
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
        width: 40px;
        height: 40px;
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
    .badge-department-premium {
        background: linear-gradient(135deg, rgba(67,97,238,0.1), rgba(76,201,240,0.1));
        color: var(--primary);
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    /* Summary Cards */
    .summary-card-premium {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(0, 0, 0, 0.05);
        animation: fadeInUp 0.8s ease;
    }

    .summary-card-premium:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .summary-icon-premium {
        width: 55px;
        height: 55px;
        border-radius: 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .summary-card-premium:hover .summary-icon-premium {
        transform: scale(1.05) rotate(5deg);
    }

    .stat-value-premium {
        font-size: 2rem;
        font-weight: 800;
        line-height: 1.2;
    }

    .stat-label-premium {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--gray);
        margin-top: 0.25rem;
    }

    /* Department Distribution */
    .dept-dist-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        animation: fadeInUp 0.9s ease;
    }

    .dept-item {
        transition: all 0.2s ease;
        padding: 0.5rem;
        border-radius: var(--radius-md);
    }

    .dept-item:hover {
        background: linear-gradient(90deg, #f8f9ff, transparent);
        transform: translateX(5px);
    }

    .progress-premium {
        height: 6px;
        border-radius: 10px;
        background: #e2e8f0;
        overflow: hidden;
    }

    .progress-bar-premium {
        background: linear-gradient(90deg, var(--primary), var(--secondary));
        border-radius: 10px;
        position: relative;
        overflow: hidden;
    }

    .progress-bar-premium::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        animation: shimmer 2s infinite;
    }

    /* Buttons */
    .btn-export-premium {
        background: linear-gradient(135deg, #10b981, #059669);
        border: none;
        padding: 0.7rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-export-premium::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s ease;
    }

    .btn-export-premium:hover::before {
        left: 100%;
    }

    .btn-export-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
    }

    .btn-back-premium {
        background: #f1f5f9;
        border: none;
        color: #475569;
        padding: 0.7rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-back-premium:hover {
        background: #e2e8f0;
        transform: translateY(-2px);
    }

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
            width: 35px;
            height: 35px;
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
                        <i class="fas fa-chart-line fa-3x opacity-75"></i>
                        <div>
                            <h1 class="display-5 fw-bold mb-1">Employees Report</h1>
                            <p class="mb-0 opacity-90 fs-5">View and export employee data with detailed analytics</p>
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-2 mt-3 mt-sm-0">
                    <a href="{{ route('reports.employees', ['export' => 'csv'] + request()->all()) }}" 
                       class="btn-export-premium btn">
                        <i class="fas fa-download me-2"></i>Export CSV
                    </a>
                    <a href="{{ route('reports.index') }}" class="btn-back-premium btn">
                        <i class="fas fa-arrow-left me-2"></i>Back
                    </a>
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
            <h5 class="fw-bold mb-0">Filter Employees</h5>
        </div>
        <form method="GET" action="{{ route('reports.employees') }}" class="row g-3">
            <div class="col-md-5">
                <label class="form-label fw-semibold small text-muted">
                    <i class="fas fa-building me-1"></i>Department
                </label>
                <select name="department_id" class="form-select-premium w-100">
                    <option value="">All Departments</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                            {{ $dept->department_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <label class="form-label fw-semibold small text-muted">
                    <i class="fas fa-briefcase me-1"></i>Position
                </label>
                <input type="text" name="position" class="form-control-premium w-100" 
                       placeholder="Search by position..." value="{{ request('position') }}">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold">
                    <i class="fas fa-search me-2"></i>Apply Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Employees Table -->
    <div class="table-container-premium mb-4">
        <div class="table-responsive">
            <table class="table table-premium">
                <thead>
                    <tr>
                        <th style="width: 8%">ID</th>
                        <th style="width: 25%">Employee</th>
                        <th style="width: 20%">Department</th>
                        <th style="width: 15%">Position</th>
                        <th style="width: 12%">Salary</th>
                        <th style="width: 20%">Joined</th>
                    </thead>
                <tbody>
                    @forelse($employees as $emp)
                    <tr class="table-row-premium">
                        <td class="px-4 py-3">
                            <span class="fw-semibold">#{{ str_pad($emp->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </td>
                        <td class="py-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-premium">
                                    {{ strtoupper(substr($emp->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $emp->name }}</div>
                                    <div class="small text-muted">{{ $emp->email }}</div>
                                    @if($emp->phone)
                                        <div class="small text-muted"><i class="fas fa-phone-alt me-1"></i>{{ $emp->phone }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="py-3">
                            <span class="badge-department-premium">
                                <i class="fas fa-building me-1"></i>{{ $emp->department->department_name ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="py-3">{{ $emp->position ?? 'N/A' }}</td>
                        <td class="py-3">
                            <span class="fw-bold text-success">${{ number_format($emp->salary, 2) }}</span>
                        </td>
                        <td class="py-3">
                            <div class="fw-semibold">{{ $emp->joining_date ? \Carbon\Carbon::parse($emp->joining_date)->format('d M Y') : 'N/A' }}</div>
                            <div class="small text-muted">{{ $emp->joining_date ? \Carbon\Carbon::parse($emp->joining_date)->diffForHumans() : '' }}</div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="py-5">
                                <i class="fas fa-users fa-5x text-muted mb-4 d-block"></i>
                                <h4 class="fw-bold text-muted mb-2">No Employees Found</h4>
                                <p class="text-muted mb-0">Try adjusting your filter criteria</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="summary-card-premium">
                <div class="summary-icon-premium bg-primary bg-opacity-10 mx-auto">
                    <i class="fas fa-users fa-2x text-primary"></i>
                </div>
                <div class="stat-value-premium text-primary">{{ $employees->count() }}</div>
                <div class="stat-label-premium">Total Employees</div>
                <div class="mt-2">
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill">
                        <i class="fas fa-chart-line me-1"></i>Active Workforce
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="summary-card-premium">
                <div class="summary-icon-premium bg-success bg-opacity-10 mx-auto">
                    <i class="fas fa-dollar-sign fa-2x text-success"></i>
                </div>
                <div class="stat-value-premium text-success">${{ number_format($employees->avg('salary') ?? 0, 0) }}</div>
                <div class="stat-label-premium">Average Salary</div>
                <div class="mt-2">
                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill">
                        <i class="fas fa-trend-up me-1"></i>Monthly Average
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="summary-card-premium">
                <div class="summary-icon-premium bg-info bg-opacity-10 mx-auto">
                    <i class="fas fa-building fa-2x text-info"></i>
                </div>
                <div class="stat-value-premium text-info">{{ $employees->pluck('department_id')->unique()->count() }}</div>
                <div class="stat-label-premium">Departments</div>
                <div class="mt-2">
                    <span class="badge bg-info bg-opacity-10 text-info rounded-pill">
                        <i class="fas fa-organization-chart me-1"></i>Active Departments
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Department Distribution -->
    @if($employees->count() > 0)
    <div class="dept-dist-card">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <div class="d-flex align-items-center gap-2">
                <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                    <i class="fas fa-chart-pie text-primary"></i>
                </div>
                <h5 class="fw-bold mb-0">Department Distribution</h5>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                @php
                    $departmentGroups = $employees->groupBy('department_id');
                @endphp
                @foreach($departmentGroups as $deptId => $group)
                    @php
                        $deptName = $group->first()->department->department_name ?? 'Unknown';
                        $count = $group->count();
                        $percentage = ($count / $employees->count()) * 100;
                    @endphp
                    <div class="col-md-6 col-lg-4">
                        <div class="dept-item">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div>
                                    <span class="fw-semibold">{{ $deptName }}</span>
                                    <br>
                                    <small class="text-muted">{{ $count }} employees</small>
                                </div>
                                <span class="badge bg-primary rounded-pill">{{ round($percentage, 1) }}%</span>
                            </div>
                            <div class="progress-premium">
                                <div class="progress-bar-premium" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
@endsection