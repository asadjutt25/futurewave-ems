@extends('layouts.app')

@section('title', 'Employee Details')

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

    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.8);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
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
        background: linear-gradient(135deg, #4f46e5, #06b6d4);
        border-radius: 28px;
        padding: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
        animation: fadeInUp 0.6s ease;
        transition: all 0.3s ease;
    }

    .profile-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.2);
    }

    .profile-avatar {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        animation: scaleIn 0.5s ease;
    }

    .profile-avatar:hover {
        transform: scale(1.05);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
    }

    .avatar-placeholder {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 4px solid white;
        transition: all 0.3s ease;
    }

    .avatar-placeholder:hover {
        transform: scale(1.05);
    }

    .info-card {
        background: white;
        border-radius: 24px;
        padding: 1.8rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
        animation: slideInRight 0.5s ease;
    }

    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .info-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-value {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1e293b;
        word-break: break-word;
    }

    .badge-department {
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(6, 182, 212, 0.1));
        color: #4f46e5;
        padding: 8px 16px;
        border-radius: 50px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .badge-salary {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(52, 211, 153, 0.1));
        color: #10b981;
        padding: 8px 16px;
        border-radius: 50px;
        font-weight: 600;
    }

    .btn-action {
        padding: 12px 28px;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        position: relative;
        overflow: hidden;
    }

    .btn-action::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s ease;
    }

    .btn-action:hover::before {
        left: 100%;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    .btn-edit {
        background: linear-gradient(135deg, #f59e0b, #ef4444);
        color: white;
    }

    .btn-back {
        background: linear-gradient(135deg, #64748b, #475569);
        color: white;
    }

    .btn-delete {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
    }

    .detail-section {
        background: #f8fafc;
        border-radius: 20px;
        padding: 1rem 1.5rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
        border: 1px solid #f1f5f9;
    }

    .detail-section:hover {
        background: #f1f5f9;
        transform: translateX(5px);
        border-color: #e2e8f0;
    }

    .timeline-icon {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #4f46e5, #06b6d4);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        transition: all 0.3s ease;
    }

    .timeline-icon:hover {
        transform: scale(1.05);
    }

    .employee-id-badge {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 50px;
        padding: 8px 20px;
        font-size: 0.9rem;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .profile-avatar, .avatar-placeholder {
            width: 120px;
            height: 120px;
        }
        .info-card {
            padding: 1.2rem;
        }
        .btn-action {
            padding: 10px 20px;
            font-size: 0.9rem;
        }
        .detail-section {
            padding: 0.8rem 1rem;
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
                        <i class="fas fa-user-circle fa-3x opacity-75"></i>
                        <div>
                            <h1 class="display-5 fw-bold mb-1">Employee Profile</h1>
                            <p class="mb-0 opacity-90 fs-5">View detailed information about {{ $employee->name }}</p>
                        </div>
                    </div>
                </div>
                <div class="employee-id-badge mt-3 mt-sm-0">
                    <i class="fas fa-id-card me-2"></i> Employee ID: #{{ str_pad($employee->id, 4, '0', STR_PAD_LEFT) }}
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Section -->
    <div class="row g-4 mb-4">
        <!-- Left Column - Profile Card -->
        <div class="col-md-4">
            <div class="profile-card text-center">
                <div class="position-relative d-inline-block mb-4">
                    @if($employee->image && file_exists(public_path($employee->image)))
                        <img src="{{ asset($employee->image) }}" alt="{{ $employee->name }}" class="profile-avatar">
                    @else
                        <div class="avatar-placeholder">
                            <i class="fas fa-user fa-4x"></i>
                        </div>
                    @endif
                </div>
                <h3 class="fw-bold mb-2">{{ $employee->name }}</h3>
                <p class="mb-2">
                    <span class="badge-department">
                        <i class="fas fa-briefcase"></i> {{ $employee->position ?? 'N/A' }}
                    </span>
                </p>
                <p class="mb-3">
                    <span class="badge-salary">
                        <i class="fas fa-dollar-sign"></i> {{ number_format($employee->salary, 2) }}
                    </span>
                </p>
                <div class="d-flex justify-content-center gap-2 mt-3">
                    <span class="badge bg-light text-dark rounded-pill px-3 py-2">
                        <i class="fas fa-calendar-alt me-1"></i> Joined {{ $employee->joining_date ? \Carbon\Carbon::parse($employee->joining_date)->format('M Y') : 'N/A' }}
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Right Column - Information Cards -->
        <div class="col-md-8">
            <div class="row g-4">
                <!-- Contact Information -->
                <div class="col-12">
                    <div class="info-card">
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="timeline-icon">
                                <i class="fas fa-address-card fa-lg"></i>
                            </div>
                            <h5 class="fw-bold mb-0">Contact Information</h5>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="detail-section">
                                    <div class="info-label">
                                        <i class="fas fa-envelope"></i> Email Address
                                    </div>
                                    <div class="info-value">
                                        <a href="mailto:{{ $employee->email }}" class="text-decoration-none text-primary">
                                            {{ $employee->email }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-section">
                                    <div class="info-label">
                                        <i class="fas fa-phone"></i> Phone Number
                                    </div>
                                    <div class="info-value">
                                        <a href="tel:{{ $employee->phone }}" class="text-decoration-none">
                                            {{ $employee->phone ?? 'Not provided' }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Professional Information -->
                <div class="col-12">
                    <div class="info-card">
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="timeline-icon">
                                <i class="fas fa-briefcase fa-lg"></i>
                            </div>
                            <h5 class="fw-bold mb-0">Professional Information</h5>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="detail-section">
                                    <div class="info-label">
                                        <i class="fas fa-building"></i> Department
                                    </div>
                                    <div class="info-value">
                                        <span class="badge-department">
                                            <i class="fas fa-building"></i> {{ $employee->department->department_name ?? 'N/A' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-section">
                                    <div class="info-label">
                                        <i class="fas fa-user-tie"></i> Position
                                    </div>
                                    <div class="info-value">{{ $employee->position ?? 'N/A' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-section">
                                    <div class="info-label">
                                        <i class="fas fa-calendar-alt"></i> Joining Date
                                    </div>
                                    <div class="info-value">
                                        @if($employee->joining_date)
                                            {{ \Carbon\Carbon::parse($employee->joining_date)->format('d F Y') }}
                                            <small class="text-muted">({{ \Carbon\Carbon::parse($employee->joining_date)->diffForHumans() }})</small>
                                        @else
                                            N/A
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-section">
                                    <div class="info-label">
                                        <i class="fas fa-dollar-sign"></i> Salary
                                    </div>
                                    <div class="info-value text-success fw-bold">${{ number_format($employee->salary, 2) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Address & Timeline -->
                <div class="col-12">
                    <div class="info-card">
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="timeline-icon">
                                <i class="fas fa-map-marker-alt fa-lg"></i>
                            </div>
                            <h5 class="fw-bold mb-0">Address & Timeline</h5>
                        </div>
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="detail-section">
                                    <div class="info-label">
                                        <i class="fas fa-location-dot"></i> Residential Address
                                    </div>
                                    <div class="info-value">{{ $employee->address ?? 'Not provided' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-section">
                                    <div class="info-label">
                                        <i class="fas fa-calendar-plus"></i> Created At
                                    </div>
                                    <div class="info-value">
                                        {{ $employee->created_at->format('d F Y, h:i A') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-section">
                                    <div class="info-label">
                                        <i class="fas fa-calendar-edit"></i> Last Updated
                                    </div>
                                    <div class="info-value">
                                        {{ $employee->updated_at->format('d F Y, h:i A') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Action Buttons -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex flex-wrap justify-content-center gap-3">
                <a href="{{ route('employees.edit', $employee) }}" class="btn-action btn-edit">
                    <i class="fas fa-edit"></i> Edit Employee
                </a>
                <a href="{{ route('employees.index') }}" class="btn-action btn-back">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
                <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-action btn-delete" onclick="return confirm('⚠️ Are you sure you want to delete this employee? This action cannot be undone.')">
                        <i class="fas fa-trash-alt"></i> Delete Employee
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection