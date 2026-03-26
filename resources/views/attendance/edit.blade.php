@extends('layouts.app')

@section('title', 'Edit Attendance')

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
        50% { transform: scale(1.05); }
    }

    @keyframes shimmer {
        0% { transform: translateX(-100%) rotate(45deg); }
        100% { transform: translateX(100%) rotate(45deg); }
    }

    .edit-header {
        background: linear-gradient(135deg, #f59e0b, #ef4444);
        border-radius: 24px;
        padding: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
        animation: fadeInUp 0.6s ease;
    }

    .edit-header::before {
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

    .form-card {
        background: white;
        border-radius: 28px;
        box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        animation: fadeInUp 0.7s ease;
        transition: all 0.3s ease;
    }

    .form-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 25px 40px -12px rgba(0, 0, 0, 0.15);
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
        color: #f59e0b;
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
        border-color: #f59e0b;
        box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.1);
        outline: none;
    }

    .form-control[readonly] {
        background: #f8fafc;
        cursor: not-allowed;
    }

    .btn-update {
        background: linear-gradient(135deg, #f59e0b, #ef4444);
        border: none;
        padding: 0.9rem 2rem;
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
        box-shadow: 0 10px 20px rgba(245, 158, 11, 0.3);
    }

    .btn-update:hover::before {
        left: 100%;
    }

    .btn-cancel {
        background: #f1f5f9;
        border: none;
        color: #475569;
        padding: 0.9rem 2rem;
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

    .info-badge {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .employee-card {
        background: linear-gradient(135deg, #fef9e7, #fff5e6);
        border-radius: 20px;
        padding: 1rem 1.5rem;
        border-left: 4px solid #f59e0b;
    }

    .required-star {
        color: #ef4444;
        margin-left: 0.25rem;
    }

    .error-feedback {
        color: #ef4444;
        font-size: 0.8rem;
        margin-top: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    @media (max-width: 768px) {
        .edit-header {
            padding: 1.5rem;
        }
        .edit-header h1 {
            font-size: 1.3rem;
        }
        .form-control, .form-select {
            padding: 0.7rem 1rem;
        }
    }
</style>

<div class="container-fluid px-4 py-4">
    
    <!-- Header Section -->
    <div class="edit-header mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <div class="d-flex align-items-center gap-3 mb-2">
                    <i class="fas fa-edit fa-3x opacity-75"></i>
                    <div>
                        <h1 class="display-5 fw-bold mb-1">Edit Attendance</h1>
                        <p class="mb-0 opacity-90 fs-5">Update attendance record for employee</p>
                    </div>
                </div>
            </div>
            <a href="{{ route('attendance.index') }}" class="btn-back btn mt-3 mt-sm-0">
                <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
        </div>
    </div>

    <!-- Edit Form Card -->
    <div class="form-card">
        <div class="card-header bg-white py-4 px-4 border-0">
            <div class="d-flex align-items-center gap-2">
                <div class="bg-warning bg-opacity-10 rounded-circle p-2">
                    <i class="fas fa-pen text-warning fa-lg"></i>
                </div>
                <h5 class="fw-bold mb-0">Edit Attendance Details</h5>
                <span class="info-badge ms-3">
                    <i class="fas fa-clock"></i> Record ID: #{{ $attendance->id }}
                </span>
            </div>
        </div>
        <div class="card-body p-4 pt-0">
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
                </div>
            @endif

            <form action="{{ route('attendance.update', $attendance) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <!-- Employee Info Card -->
                    <div class="col-12">
                        <div class="employee-card">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                    <i class="fas fa-user-circle fa-2x text-warning"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Employee</small>
                                    <h5 class="fw-bold mb-0">{{ $attendance->employee->name ?? 'N/A' }}</h5>
                                    <small class="text-muted">{{ $attendance->employee->position ?? 'Employee' }}</small>
                                </div>
                                <div class="ms-auto">
                                    <span class="info-badge">
                                        <i class="fas fa-id-card"></i> ID: {{ $attendance->employee_id }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="employee_id" value="{{ $attendance->employee_id }}">
                    </div>

                    <!-- Date -->
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-calendar-day"></i>
                            Date <span class="required-star">*</span>
                        </label>
                        <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" 
                               value="{{ old('date', $attendance->date) }}" required>
                        @error('date')
                            <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-chart-simple"></i>
                            Status <span class="required-star">*</span>
                        </label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="present" {{ old('status', $attendance->status) == 'present' ? 'selected' : '' }}>✅ Present</option>
                            <option value="absent" {{ old('status', $attendance->status) == 'absent' ? 'selected' : '' }}>❌ Absent</option>
                            <option value="late" {{ old('status', $attendance->status) == 'late' ? 'selected' : '' }}>⏰ Late</option>
                            <option value="half-day" {{ old('status', $attendance->status) == 'half-day' ? 'selected' : '' }}>🌓 Half Day</option>
                        </select>
                        @error('status')
                            <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Check In Time -->
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-sign-in-alt"></i>
                            Check In Time
                        </label>
                        <input type="time" name="check_in" class="form-control @error('check_in') is-invalid @enderror" 
                               value="{{ old('check_in', $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i') : '09:00') }}">
                        @error('check_in')
                            <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Check Out Time -->
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-sign-out-alt"></i>
                            Check Out Time
                        </label>
                        <input type="time" name="check_out" class="form-control @error('check_out') is-invalid @enderror" 
                               value="{{ old('check_out', $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('H:i') : '18:00') }}">
                        @error('check_out')
                            <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div class="col-12">
                        <label class="form-label">
                            <i class="fas fa-sticky-note"></i>
                            Notes
                        </label>
                        <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" 
                                  rows="3" placeholder="Add any additional notes about this attendance...">{{ old('notes', $attendance->notes) }}</textarea>
                        @error('notes')
                            <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="d-flex justify-content-end gap-3 mt-4 pt-3 border-top">
                    <a href="{{ route('attendance.index') }}" class="btn-cancel">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn-update">
                        <i class="fas fa-save me-2"></i>Update Attendance
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Quick Info Card -->
    <div class="mt-4 p-4 bg-light rounded-4">
        <div class="d-flex align-items-center gap-3">
            <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                <i class="fas fa-info-circle text-warning fa-2x"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-1">Need Help?</h6>
                <p class="text-muted mb-0 small">Make sure to update the correct date and status. Changes will reflect in attendance reports and salary calculations.</p>
            </div>
        </div>
    </div>
</div>
@endsection