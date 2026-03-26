@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<style>
    /* ========================================
       ULTRA PREMIUM PROFILE DESIGN SYSTEM
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
    .profile-header-premium {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-radius: var(--radius-xl);
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-xl);
        animation: fadeInUp 0.5s ease;
    }

    .profile-header-premium::before {
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

    /* Profile Card */
    .profile-card-premium {
        background: var(--white);
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        animation: fadeInUp 0.6s ease;
    }

    .profile-card-premium:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-xl);
    }

    .profile-cover {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        height: 100px;
        position: relative;
    }

    .profile-avatar-premium {
        position: relative;
        margin-top: -50px;
        margin-bottom: 1rem;
        text-align: center;
    }

    .avatar-wrapper {
        width: 120px;
        height: 120px;
        margin: 0 auto;
        position: relative;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .avatar-wrapper:hover {
        transform: scale(1.02);
    }

    .avatar-image {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid var(--white);
        box-shadow: var(--shadow-lg);
        transition: all 0.3s ease;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
    }

    .avatar-placeholder {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: 700;
        color: var(--white);
        border: 4px solid var(--white);
        box-shadow: var(--shadow-lg);
    }

    /* Info Cards */
    .info-card-premium {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
        animation: fadeInUp 0.7s ease;
    }

    .info-card-premium:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
        border-color: var(--primary-light);
    }

    .info-header-premium {
        border-bottom: 2px solid #eef2f6;
        padding-bottom: 1rem;
        margin-bottom: 1rem;
    }

    .info-header-premium h5 {
        font-weight: 700;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-header-premium i {
        color: var(--primary);
        font-size: 1.2rem;
    }

    .info-row-premium {
        display: flex;
        padding: 0.875rem 0;
        border-bottom: 1px solid #f1f5f9;
        transition: all 0.2s ease;
    }

    .info-row-premium:hover {
        transform: translateX(5px);
    }

    .info-row-premium:last-child {
        border-bottom: none;
    }

    .info-label-premium {
        width: 130px;
        font-weight: 600;
        color: var(--gray);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-label-premium i {
        width: 20px;
        color: var(--primary);
    }

    .info-value-premium {
        flex: 1;
        color: var(--dark);
        font-weight: 500;
    }

    /* Stats Cards */
    .stat-card-premium {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 1.25rem;
        text-align: center;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(0, 0, 0, 0.05);
        animation: fadeInUp 0.8s ease;
    }

    .stat-card-premium:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
    }

    .stat-icon-premium {
        width: 50px;
        height: 50px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.5rem;
        transition: all 0.3s ease;
    }

    .stat-card-premium:hover .stat-icon-premium {
        transform: scale(1.05) rotate(5deg);
    }

    .stat-number-premium {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--dark);
        line-height: 1.2;
    }

    .stat-label-premium {
        color: var(--gray);
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    /* Buttons */
    .btn-premium {
        padding: 0.6rem 1.25rem;
        border-radius: var(--radius-md);
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: none;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .btn-premium::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s ease;
    }

    .btn-premium:hover::before {
        left: 100%;
    }

    .btn-edit-premium {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: var(--white);
        box-shadow: var(--shadow-sm);
    }

    .btn-edit-premium:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        color: var(--white);
    }

    .btn-password-premium {
        background: linear-gradient(135deg, var(--warning), #ea580c);
        color: var(--white);
    }

    .btn-password-premium:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        color: var(--white);
    }

    .btn-danger-premium {
        background: linear-gradient(135deg, var(--danger), #dc2626);
        color: var(--white);
    }

    .btn-danger-premium:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        color: var(--white);
    }

    /* Badges */
    .badge-premium {
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .badge-active {
        background: linear-gradient(135deg, #10b981, #059669);
        color: var(--white);
    }

    .badge-verified {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: var(--white);
    }

    /* Alert */
    .alert-premium {
        border-radius: var(--radius-lg);
        border: none;
        padding: 1rem 1.25rem;
        box-shadow: var(--shadow-sm);
        animation: fadeInUp 0.3s ease;
    }

    /* Modal */
    .modal-premium {
        border-radius: var(--radius-xl);
        overflow: hidden;
    }

    .modal-header-premium {
        background: linear-gradient(135deg, var(--danger), #dc2626);
        padding: 1.25rem;
        border: none;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .info-label-premium {
            width: 100px;
            font-size: 0.85rem;
        }
        .stat-number-premium {
            font-size: 1.25rem;
        }
        .avatar-wrapper {
            width: 100px;
            height: 100px;
        }
        .avatar-placeholder span {
            font-size: 2rem;
        }
    }
</style>

<div class="container-fluid px-4 py-4">
    
    <!-- Premium Header -->
    <div class="profile-header-premium mb-4">
        <div class="p-4 position-relative">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="text-white">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <i class="fas fa-id-card fa-3x opacity-75"></i>
                        <div>
                            <h1 class="display-5 fw-bold mb-1">My Profile</h1>
                            <p class="mb-0 opacity-90 fs-5">Manage your account information and preferences</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('dashboard') }}" class="btn btn-light rounded-pill px-4 py-2 shadow-sm mt-3 mt-sm-0">
                    <i class="fas fa-arrow-left me-2"></i>Dashboard
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

    <div class="row g-4">
        
        <!-- Left Column - Profile Card -->
        <div class="col-lg-4">
            <div class="profile-card-premium">
                <div class="profile-cover"></div>
                
                <div class="text-center px-4 pb-4">
                    <!-- Profile Avatar -->
                    <div class="profile-avatar-premium">
                        <div class="avatar-wrapper">
                            @php
                                $imagePath = null;
                                if(isset($employee) && $employee && !empty($employee->image) && file_exists(public_path($employee->image))) {
                                    $imagePath = asset($employee->image);
                                } 
                                elseif(isset($user) && !empty($user->profile_picture) && file_exists(public_path($user->profile_picture))) {
                                    $imagePath = asset($user->profile_picture);
                                }
                            @endphp
                            
                            @if($imagePath)
                                <img src="{{ $imagePath }}" alt="{{ $user->name }}" class="avatar-image">
                            @else
                                <div class="avatar-placeholder">
                                    <span>{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <h3 class="fw-bold mb-1">{{ $user->name }}</h3>
                    <p class="text-muted mb-2">
                        <i class="fas fa-briefcase me-1"></i>{{ ucfirst($user->role ?? 'Employee') }}
                    </p>
                    
                    <div class="d-flex gap-2 justify-content-center mb-3">
                        <span class="badge-premium badge-active">
                            <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>Active
                        </span>
                        <span class="badge-premium badge-verified">
                            <i class="fas fa-check-circle me-1"></i>Verified
                        </span>
                    </div>
                    
                    <div class="border-top pt-3 mt-2">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-calendar-alt text-primary"></i>
                                    <div>
                                        <div class="small text-muted">Joined</div>
                                        <div class="fw-semibold small">{{ $user->created_at->format('M Y') }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-id-badge text-primary"></i>
                                    <div>
                                        <div class="small text-muted">Employee ID</div>
                                        <div class="fw-semibold small">#{{ str_pad($employee->id ?? 0, 4, '0', STR_PAD_LEFT) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-light p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0">
                            <i class="fas fa-address-card me-2 text-primary"></i>Contact Information
                        </h6>
                    </div>
                    
                    <div class="mb-3">
                        <div class="small text-muted mb-1">Email Address</div>
                        <div class="fw-semibold">
                            <i class="fas fa-envelope me-2 text-primary"></i>{{ $user->email }}
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="small text-muted mb-1">Phone Number</div>
                        <div class="fw-semibold">
                            <i class="fas fa-phone me-2 text-primary"></i>{{ $employee->phone ?? 'Not provided' }}
                        </div>
                    </div>
                    
                    <div>
                        <div class="small text-muted mb-1">Address</div>
                        <div class="fw-semibold">
                            <i class="fas fa-map-marker-alt me-2 text-primary"></i>{{ $employee->address ?? 'Not provided' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column -->
        <div class="col-lg-8">
            
            <!-- Stats Row -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="stat-card-premium">
                        <div class="stat-icon-premium" style="background: linear-gradient(135deg, rgba(67,97,238,0.1), rgba(76,201,240,0.1));">
                            <i class="fas fa-calendar-check fa-2x text-primary"></i>
                        </div>
                        <div class="stat-number-premium">{{ $user->created_at ? $user->created_at->diffInMonths(now()) : 0 }}</div>
                        <div class="stat-label-premium">Months Active</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card-premium">
                        <div class="stat-icon-premium" style="background: linear-gradient(135deg, rgba(16,185,129,0.1), rgba(5,150,105,0.1));">
                            <i class="fas fa-chart-line fa-2x text-success"></i>
                        </div>
                        <div class="stat-number-premium">{{ $leavesCount ?? 0 }}</div>
                        <div class="stat-label-premium">Leaves Taken</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card-premium">
                        <div class="stat-icon-premium" style="background: linear-gradient(135deg, rgba(245,158,11,0.1), rgba(234,88,12,0.1));">
                            <i class="fas fa-dollar-sign fa-2x text-warning"></i>
                        </div>
                        <div class="stat-number-premium">${{ number_format($employee->salary ?? 0, 0) }}</div>
                        <div class="stat-label-premium">Monthly Salary</div>
                    </div>
                </div>
            </div>
            
            <!-- Attendance Rate Card -->
            <div class="info-card-premium mb-4">
                <div class="info-header-premium">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line text-primary"></i>
                        Attendance Rate
                    </h5>
                </div>
                <div class="mt-2">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Overall Attendance</span>
                        <span class="fw-bold text-primary">{{ $attendancePercentage ?? 0 }}%</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-primary" style="width: {{ $attendancePercentage ?? 0 }}%; border-radius: 10px;"></div>
                    </div>
                    <div class="mt-3">
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="text-success fw-bold">{{ $presentCount ?? 0 }}</div>
                                <small class="text-muted">Present</small>
                            </div>
                            <div class="col-4">
                                <div class="text-warning fw-bold">{{ $lateCount ?? 0 }}</div>
                                <small class="text-muted">Late</small>
                            </div>
                            <div class="col-4">
                                <div class="text-danger fw-bold">{{ $absentCount ?? 0 }}</div>
                                <small class="text-muted">Absent</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Personal Information Card -->
            <div class="info-card-premium mb-4">
                <div class="info-header-premium">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-user-circle"></i>
                            Personal Information
                        </h5>
                        <a href="{{ route('profile.edit') }}" class="btn-premium btn-edit-premium">
                            <i class="fas fa-edit"></i> Edit Profile
                        </a>
                    </div>
                </div>
                
                <div class="info-row-premium">
                    <div class="info-label-premium">
                        <i class="fas fa-user"></i> Full Name
                    </div>
                    <div class="info-value-premium">{{ $user->name }}</div>
                </div>
                <div class="info-row-premium">
                    <div class="info-label-premium">
                        <i class="fas fa-envelope"></i> Email Address
                    </div>
                    <div class="info-value-premium">{{ $user->email }}</div>
                </div>
                <div class="info-row-premium">
                    <div class="info-label-premium">
                        <i class="fas fa-building"></i> Department
                    </div>
                    <div class="info-value-premium">{{ $employee->department->department_name ?? 'Not assigned' }}</div>
                </div>
                <div class="info-row-premium">
                    <div class="info-label-premium">
                        <i class="fas fa-briefcase"></i> Position
                    </div>
                    <div class="info-value-premium">{{ $employee->position ?? 'Employee' }}</div>
                </div>
                <div class="info-row-premium">
                    <div class="info-label-premium">
                        <i class="fas fa-calendar-alt"></i> Member Since
                    </div>
                    <div class="info-value-premium">{{ $user->created_at->format('d F Y') }}</div>
                </div>
                <div class="info-row-premium">
                    <div class="info-label-premium">
                        <i class="fas fa-clock"></i> Last Updated
                    </div>
                    <div class="info-value-premium">{{ $user->updated_at->format('d F Y, h:i A') }}</div>
                </div>
            </div>
            
            <!-- Recent Attendance Card -->
            <div class="info-card-premium">
                <div class="info-header-premium">
                    <h5 class="mb-0">
                        <i class="fas fa-clock text-primary"></i>
                        Recent Attendance
                    </h5>
                </div>
                <div class="mt-2">
                    @if(isset($recentAttendance) && count($recentAttendance) > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Check In</th>
                                        <th>Check Out</th>
                                     </thead>
                                <tbody>
                                    @foreach($recentAttendance as $att)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($att->date)->format('d M Y') }}</td>
                                        <td>
                                            @if($att->status == 'present')
                                                <span class="badge bg-success">Present</span>
                                            @elseif($att->status == 'late')
                                                <span class="badge bg-warning">Late</span>
                                            @else
                                                <span class="badge bg-danger">Absent</span>
                                            @endif
                                        </td>
                                        <td>{{ $att->check_in ? \Carbon\Carbon::parse($att->check_in)->format('h:i A') : '—' }}</td>
                                        <td>{{ $att->check_out ? \Carbon\Carbon::parse($att->check_out)->format('h:i A') : '—' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-3 text-muted">
                            <i class="fas fa-calendar-times fa-2x mb-2"></i>
                            <p>No attendance records found</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Danger Zone - Admin Only -->
    @if(Auth::user()->role === 'admin')
    <div class="row mt-4">
        <div class="col-12">
            <div class="info-card-premium" style="border: 1px solid #fee2e2;">
                <div class="info-header-premium" style="border-bottom-color: #fee2e2;">
                    <h5 class="mb-0" style="color: #dc2626;">
                        <i class="fas fa-exclamation-triangle"></i>
                        Danger Zone
                    </h5>
                </div>
                <div class="mt-3">
                    <div class="alert alert-warning mb-3" style="background: #fef3c7; border: none; border-radius: var(--radius-md);">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Warning:</strong> This action is irreversible. All associated data will be permanently deleted.
                    </div>
                    <button type="button" class="btn-premium btn-danger-premium" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                        <i class="fas fa-trash-alt"></i> Delete Account
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Delete Account Modal -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-premium">
                <div class="modal-header-premium text-white">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-exclamation-triangle me-2"></i>Delete Account
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <p>Are you sure you want to delete <strong class="text-danger">{{ $user->name }}</strong>'s account?</p>
                    <p class="text-muted">This action cannot be undone. All associated data including leave records, attendance, and salary information will be permanently removed.</p>
                    <form id="deleteAccountForm" action="{{ route('profile.destroy') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Confirm with your admin password</label>
                            <input type="password" name="password" class="form-control-premium w-100" 
                                   placeholder="Enter your admin password" required>
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0 pb-4 pe-4">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="submit" form="deleteAccountForm" class="btn btn-danger rounded-pill px-4">
                        <i class="fas fa-trash-alt me-2"></i>Delete Permanently
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
    // Auto-hide alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 500);
            });
        }, 5000);
    });
</script>
@endsection