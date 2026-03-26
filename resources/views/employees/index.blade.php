@extends('layouts.app')

@section('title', 'Employees List')

@section('content')
<style>
    /* ========================================
       ULTRA PREMIUM EMPLOYEE MANAGEMENT DESIGN
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
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    @keyframes borderFlow {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Header */
    .header-premium {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-radius: var(--radius-xl);
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-xl);
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
        border: 1px solid rgba(0,0,0,0.05);
        position: relative;
        overflow: hidden;
        animation: slideUp 0.4s ease;
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

    /* Search Card */
    .search-card-premium {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
        animation: slideUp 0.45s ease;
    }

    .search-card-premium:hover {
        box-shadow: var(--shadow-lg);
    }

    .search-input-premium {
        border: 2px solid #e2e8f0;
        border-radius: 50px;
        padding: 0.85rem 1.5rem;
        transition: all 0.2s ease;
        font-size: 0.95rem;
    }

    .search-input-premium:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(67,97,238,0.1);
        outline: none;
    }

    /* Table */
    .table-container-premium {
        background: var(--white);
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        animation: slideUp 0.5s ease;
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
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: var(--white);
        box-shadow: var(--shadow-sm);
    }

    .avatar-premium:hover {
        transform: scale(1.05);
        box-shadow: var(--shadow-md);
    }

    .avatar-img-premium {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--white);
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
    }

    .avatar-img-premium:hover {
        transform: scale(1.05);
        border-color: var(--primary);
        box-shadow: var(--shadow-md);
    }

    /* Badges */
    .badge-department-premium {
        background: linear-gradient(135deg, rgba(67,97,238,0.1), rgba(76,201,240,0.1));
        color: var(--primary);
        padding: 0.4rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Buttons */
    .btn-action-premium {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 0.9rem;
    }

    .btn-action-premium:hover {
        transform: translateY(-2px);
    }

    .btn-view-premium {
        background: rgba(67,97,238,0.1);
        color: var(--primary);
    }

    .btn-view-premium:hover {
        background: var(--primary);
        color: var(--white);
    }

    .btn-edit-premium {
        background: rgba(245,158,11,0.1);
        color: var(--warning);
    }

    .btn-edit-premium:hover {
        background: var(--warning);
        color: var(--white);
    }

    .btn-reset-premium {
        background: rgba(16,185,129,0.1);
        color: var(--success);
    }

    .btn-reset-premium:hover {
        background: var(--success);
        color: var(--white);
    }

    .btn-delete-premium {
        background: rgba(239,68,68,0.1);
        color: var(--danger);
    }

    .btn-delete-premium:hover {
        background: var(--danger);
        color: var(--white);
    }

    /* Modal Premium */
    .modal-premium {
        border-radius: var(--radius-xl);
        overflow: hidden;
        border: none;
    }

    .modal-header-premium {
        padding: 1.25rem;
        border: none;
    }

    .modal-header-success {
        background: linear-gradient(135deg, var(--success), #059669);
    }

    .modal-header-warning {
        background: linear-gradient(135deg, var(--warning), #ea580c);
    }

    .modal-header-danger {
        background: linear-gradient(135deg, var(--danger), #dc2626);
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
        box-shadow: 0 0 0 3px rgba(67,97,238,0.1);
        outline: none;
    }

    /* Alert */
    .alert-premium {
        border-radius: var(--radius-lg);
        border: none;
        padding: 1rem 1.25rem;
        box-shadow: var(--shadow-sm);
        animation: slideUp 0.3s ease;
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

    /* Responsive */
    @media (max-width: 768px) {
        .stat-number-premium { font-size: 1.5rem; }
        .btn-action-premium { width: 32px; height: 32px; }
        .table-premium th, .table-premium td { padding: 0.75rem; }
        .avatar-premium, .avatar-img-premium { width: 40px; height: 40px; }
    }
</style>

<div class="container-fluid px-4 py-4">
    
    <!-- Header Section -->
    <div class="header-premium mb-4">
        <div class="p-4 position-relative">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="text-white">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <i class="fas fa-users fa-3x opacity-75"></i>
                        <div>
                            <h1 class="display-5 fw-bold mb-1">Employee Management</h1>
                            <p class="mb-0 opacity-90 fs-5">Manage and track all your team members</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('employees.create') }}" class="btn btn-light rounded-pill px-4 py-2 shadow-sm mt-3 mt-sm-0">
                    <i class="fas fa-plus-circle me-2"></i>Add New Employee
                </a>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
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
                    <i class="fas fa-users fa-2x" style="color: var(--primary);"></i>
                </div>
                <div class="stat-number-premium">{{ $employees->total() }}</div>
                <div class="stat-label-premium">Total Employees</div>
                <div class="mt-2">
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill">Active Team</span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card-premium">
                <div class="stat-icon-premium" style="background: linear-gradient(135deg, rgba(16,185,129,0.1), rgba(5,150,105,0.1));">
                    <i class="fas fa-calendar-plus fa-2x" style="color: var(--success);"></i>
                </div>
                <div class="stat-number-premium">{{ $employees->where('joining_date', '>=', now()->startOfMonth())->count() }}</div>
                <div class="stat-label-premium">New This Month</div>
                <div class="mt-2">
                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill">+{{ $employees->where('joining_date', '>=', now()->startOfMonth())->count() }} this month</span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card-premium">
                <div class="stat-icon-premium" style="background: linear-gradient(135deg, rgba(245,158,11,0.1), rgba(234,88,12,0.1));">
                    <i class="fas fa-dollar-sign fa-2x" style="color: var(--warning);"></i>
                </div>
                <div class="stat-number-premium">${{ number_format($employees->sum('salary'), 0) }}</div>
                <div class="stat-label-premium">Total Monthly Salary</div>
                <div class="mt-2">
                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill">Payroll Budget</span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card-premium">
                <div class="stat-icon-premium" style="background: linear-gradient(135deg, rgba(59,130,246,0.1), rgba(37,99,235,0.1));">
                    <i class="fas fa-chart-line fa-2x" style="color: var(--info);"></i>
                </div>
                <div class="stat-number-premium">${{ number_format($employees->avg('salary') ?? 0, 0) }}</div>
                <div class="stat-label-premium">Average Salary</div>
                <div class="mt-2">
                    <span class="badge bg-info bg-opacity-10 text-info rounded-pill">Per Employee</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Card -->
    <div class="search-card-premium mb-4">
        <div class="d-flex align-items-center gap-2 mb-3">
            <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                <i class="fas fa-search text-primary"></i>
            </div>
            <h5 class="fw-bold mb-0">Find Employees</h5>
        </div>
        <form action="{{ route('employees.index') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-9">
                    <input type="text" name="search" class="form-control search-input-premium w-100" 
                           placeholder="🔍 Search by name, email, position, or phone number..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold">
                        <i class="fas fa-search me-2"></i>Search
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Table Container -->
    <div class="table-container-premium">
        <div class="table-responsive">
            <table class="table table-premium">
                <thead>
                    <tr>
                        <th style="width: 28%">Employee</th>
                        <th style="width: 18%">Department</th>
                        <th style="width: 18%">Position</th>
                        <th style="width: 12%">Salary</th>
                        <th style="width: 12%">Joined</th>
                        <th style="width: 12%" class="text-end">Actions</th>
                     </thead>
                <tbody>
                    @forelse($employees as $employee)
                    <tr class="table-row-premium">
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                @if($employee->image && file_exists(public_path($employee->image)))
                                    <img src="{{ asset($employee->image) }}" alt="{{ $employee->name }}" class="avatar-img-premium">
                                @else
                                    <div class="avatar-premium">
                                        {{ strtoupper(substr($employee->name ?? 'U', 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-bold text-dark">{{ $employee->name ?? 'N/A' }}</div>
                                    <div class="small text-muted">{{ $employee->email ?? '' }}</div>
                                    @if($employee->phone)
                                        <div class="small text-muted"><i class="fas fa-phone-alt me-1"></i>{{ $employee->phone }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge-department-premium">
                                <i class="fas fa-building me-1"></i>{{ $employee->department->department_name ?? 'N/A' }}
                            </span>
                        </td>
                        <td>
                            <span class="fw-medium">{{ $employee->position ?? 'N/A' }}</span>
                        </td>
                        <td>
                            <span class="fw-bold text-success">${{ number_format($employee->salary ?? 0, 2) }}</span>
                        </td>
                        <td>
                            <div>
                                <div class="fw-semibold">{{ $employee->joining_date ? \Carbon\Carbon::parse($employee->joining_date)->format('d M Y') : 'N/A' }}</div>
                                <div class="small text-muted">{{ $employee->joining_date ? \Carbon\Carbon::parse($employee->joining_date)->diffForHumans() : '' }}</div>
                            </div>
                        </td>
                        <td class="text-end">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('employees.show', $employee) }}" class="btn-action-premium btn-view-premium" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('employees.edit', $employee) }}" class="btn-action-premium btn-edit-premium" title="Edit Employee">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn-action-premium btn-reset-premium" title="Reset Password" 
                                        data-bs-toggle="modal" data-bs-target="#resetPasswordModal{{ $employee->id }}">
                                    <i class="fas fa-key"></i>
                                </button>
                                <button type="button" class="btn-action-premium btn-delete-premium" title="Delete Employee" 
                                        data-bs-toggle="modal" data-bs-target="#deleteEmployeeModal{{ $employee->id }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Reset Password Modal -->
                    <div class="modal fade" id="resetPasswordModal{{ $employee->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content modal-premium">
                                <div class="modal-header-premium modal-header-success text-white">
                                    <h5 class="modal-title fw-bold">
                                        <i class="fas fa-key me-2"></i>Reset Password
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('employees.reset-password', $employee) }}" method="POST">
                                    @csrf
                                    <div class="modal-body p-4">
                                        <p class="mb-3">Reset password for <strong class="text-primary">{{ $employee->name }}</strong></p>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">New Password</label>
                                            <input type="password" name="password" class="form-control-premium w-100" placeholder="Enter new password" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Confirm Password</label>
                                            <input type="password" name="password_confirmation" class="form-control-premium w-100" placeholder="Confirm new password" required>
                                        </div>
                                        <div class="alert alert-info mb-0">
                                            <i class="fas fa-info-circle me-2"></i>
                                            <small>Password must be at least 8 characters. Employee can change it after first login.</small>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0 pb-4 pe-4">
                                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                                            <i class="fas fa-times me-2"></i>Cancel
                                        </button>
                                        <button type="submit" class="btn btn-success rounded-pill px-4">
                                            <i class="fas fa-save me-2"></i>Reset Password
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Employee Modal -->
                    <div class="modal fade" id="deleteEmployeeModal{{ $employee->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content modal-premium">
                                <div class="modal-header-premium modal-header-danger text-white">
                                    <h5 class="modal-title fw-bold">
                                        <i class="fas fa-exclamation-triangle me-2"></i>Delete Employee
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <div class="text-center mb-3">
                                        <i class="fas fa-user-slash fa-4x text-danger mb-3"></i>
                                        <h5 class="fw-bold">Delete {{ $employee->name }}?</h5>
                                        <p class="text-muted">This action cannot be undone. All employee data will be permanently removed.</p>
                                    </div>
                                    <div class="alert alert-warning">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <small>This will also delete the user account and all associated records.</small>
                                    </div>
                                    <form action="{{ route('employees.destroy', $employee) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger w-100 rounded-pill py-2">
                                            <i class="fas fa-trash-alt me-2"></i>Delete Permanently
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="py-5">
                                <i class="fas fa-users fa-5x text-muted mb-4 d-block"></i>
                                <h4 class="fw-bold text-muted mb-2">No Employees Found</h4>
                                <p class="text-muted mb-4">Get started by adding your first team member</p>
                                <a href="{{ route('employees.create') }}" class="btn btn-primary rounded-pill px-5 py-2">
                                    <i class="fas fa-plus me-2"></i>Add Employee
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($employees->hasPages())
        <div class="px-4 py-3 border-top">
            <div class="d-flex justify-content-center">
                {{ $employees->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Reset Info Modal -->
@if(session('reset_info'))
<div class="modal fade" id="resetInfoModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-premium">
            <div class="modal-header-premium modal-header-warning text-white">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-check-circle me-2"></i>Password Reset Successful!
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <p>Password has been reset successfully. Share these credentials with the employee:</p>
                
                <div class="bg-light p-3 rounded-3 mb-3">
                    <div class="mb-2">
                        <strong><i class="fas fa-envelope me-2 text-primary"></i>Email:</strong>
                        <code class="d-block mt-1 p-2 bg-white rounded border">{{ session('reset_info.email') }}</code>
                    </div>
                    <div>
                        <strong><i class="fas fa-key me-2 text-success"></i>New Password:</strong>
                        <code class="d-block mt-1 p-2 bg-white rounded border">{{ session('reset_info.password') }}</code>
                    </div>
                </div>
                
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <small>Share these credentials with the employee. They can change password after first login.</small>
                </div>
            </div>
            <div class="modal-footer border-0 pb-4 pe-4">
                <button type="button" class="btn btn-primary rounded-pill px-4" data-bs-dismiss="modal">
                    <i class="fas fa-check me-2"></i>OK
                </button>
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" onclick="copyResetCredentials()">
                    <i class="fas fa-copy me-2"></i>Copy Credentials
                </button>
            </div>
        </div>
    </div>
</div>
@endif

<script>
    function copyResetCredentials() {
        const email = "{{ session('reset_info.email') }}";
        const password = "{{ session('reset_info.password') }}";
        const text = `Email: ${email}\nNew Password: ${password}\nLogin URL: {{ url('/login') }}`;
        
        navigator.clipboard.writeText(text).then(() => {
            alert('Credentials copied to clipboard!');
        });
    }
    
    // Auto show reset modal on page load
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('reset_info'))
            var resetModal = new bootstrap.Modal(document.getElementById('resetInfoModal'));
            resetModal.show();
        @endif
    });
</script>
@endsection