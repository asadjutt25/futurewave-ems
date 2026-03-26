@extends('layouts.app')

@section('title', 'Departments')

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

    .stat-card-premium {
        background: white;
        border-radius: 24px;
        padding: 1.5rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        animation: fadeInUp 0.6s ease;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
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
        box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.1);
    }

    .stat-card-premium.departments::after { background: #4f46e5; }
    .stat-card-premium.employees::after { background: #10b981; }
    .stat-card-premium.average::after { background: #f59e0b; }

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

    .stat-value {
        font-size: 2.2rem;
        font-weight: 800;
        line-height: 1.2;
    }

    .table-container-premium {
        border-radius: 28px;
        overflow: hidden;
        animation: fadeInUp 0.7s ease;
    }

    .table-row-premium {
        transition: all 0.2s ease;
        border-bottom: 1px solid #f0f0f0;
    }

    .table-row-premium:hover {
        background: linear-gradient(90deg, #f8f9ff, transparent);
        transform: translateX(3px);
    }

    .dept-avatar-premium {
        width: 48px;
        height: 48px;
        border-radius: 16px;
        background: linear-gradient(135deg, #4f46e5, #06b6d4);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.2rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
    }

    .dept-avatar-premium:hover {
        transform: scale(1.1);
        box-shadow: 0 8px 20px rgba(79, 70, 229, 0.3);
    }

    .badge-employees-premium {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        padding: 6px 14px;
        border-radius: 100px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
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

    .description-text {
        max-width: 250px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        color: #64748b;
    }

    .insight-card {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border-radius: 20px;
        padding: 1.2rem;
        transition: all 0.3s ease;
    }

    .insight-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
    }

    @media (max-width: 768px) {
        .stat-value {
            font-size: 1.5rem;
        }
        .dept-avatar-premium {
            width: 40px;
            height: 40px;
            font-size: 1rem;
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
                        <i class="fas fa-building fa-3x opacity-75"></i>
                        <div>
                            <h1 class="display-5 fw-bold mb-1">Department Management</h1>
                            <p class="mb-0 opacity-90 fs-5">Manage and organize your company departments</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('departments.create') }}" class="btn btn-light rounded-pill px-4 py-2 shadow-sm mt-3 mt-sm-0">
                    <i class="fas fa-plus-circle me-2"></i>Add Department
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-4">
            <div class="stat-card-premium departments">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stat-icon-premium bg-primary bg-opacity-10">
                        <i class="fas fa-building fa-2x text-primary"></i>
                    </div>
                </div>
                <div class="stat-value text-primary">{{ $departments->total() }}</div>
                <div class="text-muted mb-2">Total Departments</div>
                <div class="progress-premium mt-2">
                    <div class="progress-bar bg-primary" style="width: 100%; height: 4px; border-radius: 10px;"></div>
                </div>
                <div class="mt-2">
                    <small class="text-success"><i class="fas fa-check-circle me-1"></i>Active departments</small>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4">
            <div class="stat-card-premium employees">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stat-icon-premium bg-success bg-opacity-10">
                        <i class="fas fa-users fa-2x text-success"></i>
                    </div>
                </div>
                <div class="stat-value text-success">{{ $departments->sum('employees_count') }}</div>
                <div class="text-muted mb-2">Total Employees</div>
                <div class="progress-premium mt-2">
                    <div class="progress-bar bg-success" style="width: {{ $departments->sum('employees_count') > 0 ? min(($departments->sum('employees_count') / 500) * 100, 100) : 0 }}%; height: 4px; border-radius: 10px;"></div>
                </div>
                <div class="mt-2">
                    <small class="text-success"><i class="fas fa-chart-line me-1"></i>Across all departments</small>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4">
            <div class="stat-card-premium average">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stat-icon-premium bg-warning bg-opacity-10">
                        <i class="fas fa-chart-line fa-2x text-warning"></i>
                    </div>
                </div>
                <div class="stat-value text-warning">{{ number_format($departments->avg('employees_count') ?? 0, 1) }}</div>
                <div class="text-muted mb-2">Avg Employees/Dept</div>
                <div class="progress-premium mt-2">
                    <div class="progress-bar bg-warning" style="width: {{ ($departments->avg('employees_count') ?? 0) > 0 ? min(($departments->avg('employees_count') / 50) * 100, 100) : 0 }}%; height: 4px; border-radius: 10px;"></div>
                </div>
                <div class="mt-2">
                    <small class="text-warning"><i class="fas fa-chart-simple me-1"></i>Average team size</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-check-circle fa-lg"></i>
                <span class="fw-semibold">{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-4 mb-4">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-exclamation-circle fa-lg"></i>
                <span class="fw-semibold">{{ session('error') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Departments Table -->
    <div class="table-container-premium bg-white shadow-sm">
        <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-list text-primary me-2"></i>
                <h5 class="fw-bold mb-0 d-inline">All Departments</h5>
                <span class="badge bg-primary rounded-pill ms-2">{{ $departments->total() }}</span>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3">Department</th>
                        <th class="py-3">Head</th>
                        <th class="py-3">Description</th>
                        <th class="py-3">Employees</th>
                        <th class="py-3 text-end px-4">Actions</th>
                    </thead>
                <tbody>
                    @forelse($departments as $department)
                    <tr class="table-row-premium">
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="dept-avatar-premium">
                                    {{ strtoupper(substr($department->department_name ?? 'D', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $department->department_name ?? 'N/A' }}</div>
                                    <small class="text-muted">ID: #{{ $department->id }}</small>
                                </div>
                            </div>
                         </td>
                        <td class="py-3">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-user-circle text-muted"></i>
                                <span>{{ $department->department_head ?? 'Not Assigned' }}</span>
                            </div>
                         </td>
                        <td class="py-3">
                            <div class="description-text" title="{{ $department->description }}">
                                @if($department->description)
                                    <i class="fas fa-quote-left text-muted me-1"></i>
                                    {{ \Illuminate\Support\Str::limit($department->description, 50) }}
                                @else
                                    <span class="text-muted">No description</span>
                                @endif
                            </div>
                         </td>
                        <td class="py-3">
                            <span class="badge-employees-premium">
                                <i class="fas fa-users me-1"></i>{{ $department->employees_count ?? $department->employees->count() }} Employees
                            </span>
                         </td>
                        <td class="py-3 text-end px-4">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('departments.edit', $department) }}" class="btn-action-premium btn-edit-premium" title="Edit Department">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('departments.destroy', $department) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action-premium btn-delete-premium border-0" 
                                            title="Delete Department" 
                                            onclick="return confirm('⚠️ Are you sure you want to delete this department? This will also affect employees assigned to it.')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                         </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="py-5">
                                <i class="fas fa-building fa-5x text-muted mb-4 d-block"></i>
                                <h5 class="text-muted mb-2">No Departments Found</h5>
                                <p class="text-muted mb-3">Get started by creating your first department</p>
                                <a href="{{ route('departments.create') }}" class="btn btn-primary rounded-pill px-4">
                                    <i class="fas fa-plus me-2"></i>Add Department
                                </a>
                            </div>
                         </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($departments->hasPages())
        <div class="d-flex justify-content-center py-3 border-top">
            {{ $departments->withQueryString()->links() }}
        </div>
        @endif
    </div>

    <!-- Department Insights -->
    @if($departments->count() > 0)
    <div class="row g-4 mt-2">
        <div class="col-md-6">
            <div class="insight-card">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                        <i class="fas fa-chart-line text-primary"></i>
                    </div>
                    <h6 class="fw-bold mb-0">Largest Department</h6>
                </div>
                @php
                    $largestDept = $departments->sortByDesc('employees_count')->first();
                @endphp
                <div class="d-flex align-items-center gap-3">
                    <div class="dept-avatar-premium" style="width: 45px; height: 45px; font-size: 1rem;">
                        {{ strtoupper(substr($largestDept->department_name ?? 'N', 0, 1)) }}
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-bold">{{ $largestDept->department_name ?? 'N/A' }}</div>
                        <small class="text-muted">Head: {{ $largestDept->department_head ?? 'Not Assigned' }}</small>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-primary rounded-pill">{{ $largestDept->employees_count ?? 0 }} Employees</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="insight-card">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="bg-success bg-opacity-10 rounded-circle p-2">
                        <i class="fas fa-chart-pie text-success"></i>
                    </div>
                    <h6 class="fw-bold mb-0">Capacity Utilization</h6>
                </div>
                @php
                    $totalEmployees = $departments->sum('employees_count');
                    $maxCapacity = $departments->count() * 50;
                    $percentage = $maxCapacity > 0 ? ($totalEmployees / $maxCapacity) * 100 : 0;
                @endphp
                <div class="mb-2">
                    <div class="d-flex justify-content-between mb-1">
                        <small class="text-muted">Total Employees: {{ $totalEmployees }}</small>
                        <small class="text-muted">Max Capacity: {{ $maxCapacity }}</small>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
                <div class="mt-2">
                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill">
                        {{ number_format($percentage, 1) }}% utilized
                    </span>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection