@extends('layouts.app')

@section('title', 'Edit Employee')

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
        background: linear-gradient(135deg, #f59e0b, #ef4444);
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

    .form-card {
        background: white;
        border-radius: 28px;
        box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        animation: fadeInUp 0.6s ease;
        transition: all 0.3s ease;
    }

    .form-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 25px 40px -12px rgba(0, 0, 0, 0.15);
    }

    .form-header {
        background: linear-gradient(135deg, #4f46e5, #06b6d4);
        padding: 1.8rem 2rem;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .form-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
        transform: rotate(45deg);
        animation: shimmer 3s infinite;
    }

    .form-body {
        padding: 2rem;
    }

    .form-label {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label i {
        color: #4f46e5;
        font-size: 0.9rem;
    }

    .form-control, .form-select {
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        padding: 0.85rem 1.2rem;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        outline: none;
    }

    .current-image {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
        transition: all 0.3s ease;
    }

    .current-image:hover {
        transform: scale(1.05);
        box-shadow: 0 15px 35px rgba(79, 70, 229, 0.4);
    }

    .btn-update {
        background: linear-gradient(135deg, #4f46e5, #06b6d4);
        border: none;
        padding: 0.85rem 2.5rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-update::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s ease;
    }

    .btn-update:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(79, 70, 229, 0.3);
    }

    .btn-update:hover::before {
        left: 100%;
    }

    .btn-cancel {
        background: #f1f5f9;
        border: none;
        color: #475569;
        padding: 0.85rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-cancel:hover {
        background: #e2e8f0;
        transform: translateY(-2px);
    }

    .btn-back {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        padding: 0.6rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        color: white;
    }

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
        color: white;
    }

    .password-card {
        background: linear-gradient(135deg, #fef9e7, #fff5e6);
        border-radius: 24px;
        padding: 1.5rem;
        border-left: 4px solid #f59e0b;
        transition: all 0.3s ease;
    }

    .password-card:hover {
        transform: translateX(5px);
    }

    .employee-badge {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        border-radius: 20px;
        padding: 1rem 1.2rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .error-feedback {
        color: #ef4444;
        font-size: 0.8rem;
        margin-top: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .required-star {
        color: #ef4444;
        margin-left: 0.25rem;
    }

    @media (max-width: 768px) {
        .form-header {
            padding: 1.2rem;
        }
        .form-body {
            padding: 1.2rem;
        }
        .form-control, .form-select {
            padding: 0.7rem 1rem;
        }
        .current-image {
            width: 100px;
            height: 100px;
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
                        <i class="fas fa-user-edit fa-3x opacity-75"></i>
                        <div>
                            <h1 class="display-5 fw-bold mb-1">Edit Employee</h1>
                            <p class="mb-0 opacity-90 fs-5">Update employee information</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('employees.index') }}" class="btn-back mt-3 mt-sm-0">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="form-card">
                <div class="form-header">
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-white bg-opacity-20 rounded-circle p-2">
                            <i class="fas fa-pen-alt text-white fa-lg"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-1">Edit Employee Information</h3>
                            <p class="mb-0 opacity-75">Update the details of {{ $employee->name }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="form-body">
                    @if($errors->any())
                        <div class="alert alert-danger rounded-4 mb-4">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-exclamation-triangle fa-lg"></i>
                                <strong>Please fix the following errors:</strong>
                            </div>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Employee Info Badge -->
                    <div class="employee-badge">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-info-circle text-warning"></i>
                            <span>You are editing: <strong>{{ $employee->name }}</strong></span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-id-card"></i>
                            <span class="text-muted">Employee ID: <strong>#{{ $employee->id }}</strong></span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-calendar-alt"></i>
                            <span class="text-muted">Joined: <strong>{{ $employee->joining_date ? \Carbon\Carbon::parse($employee->joining_date)->format('d M Y') : 'N/A' }}</strong></span>
                        </div>
                    </div>

                    <form action="{{ route('employees.update', $employee) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-4">
                            <!-- Current Image Display -->
                            @if($employee->image)
                            <div class="col-12 mb-2 text-center">
                                <label class="form-label justify-content-center">
                                    <i class="fas fa-image"></i> Current Profile Picture
                                </label>
                                <div>
                                    <img src="{{ asset($employee->image) }}" alt="{{ $employee->name }}" class="current-image">
                                </div>
                            </div>
                            @endif
                            
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-user"></i> Full Name <span class="required-star">*</span>
                                </label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $employee->name) }}" required>
                                @error('name')
                                    <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-envelope"></i> Email Address <span class="required-star">*</span>
                                </label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email', $employee->email) }}" required>
                                @error('email')
                                    <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-phone"></i> Phone Number
                                </label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                       value="{{ old('phone', $employee->phone) }}">
                                @error('phone')
                                    <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-building"></i> Department <span class="required-star">*</span>
                                </label>
                                <select name="department_id" class="form-select @error('department_id') is-invalid @enderror" required>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->id }}" {{ old('department_id', $employee->department_id) == $dept->id ? 'selected' : '' }}>
                                            {{ $dept->department_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                    <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-briefcase"></i> Position <span class="required-star">*</span>
                                </label>
                                <input type="text" name="position" class="form-control @error('position') is-invalid @enderror" 
                                       value="{{ old('position', $employee->position) }}" required>
                                @error('position')
                                    <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-dollar-sign"></i> Salary <span class="required-star">*</span>
                                </label>
                                <input type="number" name="salary" class="form-control @error('salary') is-invalid @enderror" 
                                       value="{{ old('salary', $employee->salary) }}" required>
                                @error('salary')
                                    <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-calendar-alt"></i> Joining Date <span class="required-star">*</span>
                                </label>
                                <input type="date" name="joining_date" class="form-control @error('joining_date') is-invalid @enderror" 
                                       value="{{ old('joining_date', $employee->joining_date ? \Carbon\Carbon::parse($employee->joining_date)->format('Y-m-d') : '') }}" required>
                                @error('joining_date')
                                    <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-image"></i> Profile Picture
                                </label>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" 
                                       accept="image/jpeg,image/png,image/jpg">
                                <small class="text-muted d-block mt-1">
                                    <i class="fas fa-info-circle me-1"></i>Allowed: JPG, PNG, JPEG. Max size: <strong>20MB</strong>
                                </small>
                                @error('image')
                                    <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12">
                                <label class="form-label">
                                    <i class="fas fa-map-marker-alt"></i> Address
                                </label>
                                <textarea name="address" class="form-control @error('address') is-invalid @enderror" 
                                          rows="3" placeholder="Enter employee address">{{ old('address', $employee->address) }}</textarea>
                                @error('address')
                                    <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-end gap-3 mt-4 pt-3 border-top">
                            <a href="{{ route('employees.index') }}" class="btn-cancel">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn-update">
                                <i class="fas fa-save"></i> Update Employee
                            </button>
                        </div>
                    </form>
                    
                    <!-- Password Reset Section -->
                    <hr class="my-4">
                    
                    <div class="password-card">
                        <h5 class="fw-bold mb-3">
                            <i class="fas fa-key text-warning me-2"></i>Reset Employee Password
                        </h5>
                        <p class="text-muted small mb-3">Reset password if employee forgot their credentials. New password will be displayed after reset.</p>
                        
                        <form action="{{ route('employees.reset-password', $employee) }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-5">
                                    <input type="password" name="password" class="form-control" placeholder="New Password" required>
                                </div>
                                <div class="col-md-5">
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-warning w-100" onclick="return confirm('Reset password for {{ $employee->name }}?')">
                                        <i class="fas fa-sync-alt me-1"></i>Reset
                                    </button>
                                </div>
                            </div>
                            <small class="text-muted mt-2 d-block">
                                <i class="fas fa-info-circle me-1"></i>Password must be at least 8 characters
                            </small>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection