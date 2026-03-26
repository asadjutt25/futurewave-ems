@extends('layouts.app')

@section('title', 'Mark Attendance')

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

    .form-header {
        background: linear-gradient(135deg, #4f46e5, #06b6d4);
        border-radius: 24px;
        padding: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
        animation: fadeInUp 0.6s ease;
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

    @keyframes shimmer {
        0% { transform: translateX(-100%) rotate(45deg); }
        100% { transform: translateX(100%) rotate(45deg); }
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

    .btn-submit {
        background: linear-gradient(135deg, #4f46e5, #06b6d4);
        border: none;
        padding: 0.9rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-submit::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s ease;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(79, 70, 229, 0.3);
    }

    .btn-submit:hover::before {
        left: 100%;
    }

    .btn-reset {
        background: #f1f5f9;
        border: none;
        color: #475569;
        padding: 0.9rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-reset:hover {
        background: #e2e8f0;
        transform: translateY(-2px);
    }

    .btn-back {
        background: linear-gradient(135deg, #64748b, #475569);
        border: none;
        padding: 0.6rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        color: white;
    }

    .btn-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(100, 116, 139, 0.3);
        color: white;
    }

    .tips-card {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border-radius: 24px;
        padding: 1.5rem;
        transition: all 0.3s ease;
        animation: fadeInUp 0.8s ease;
    }

    .tips-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        background: rgba(79, 70, 229, 0.1);
        color: #4f46e5;
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
        .form-header {
            padding: 1.5rem;
        }
        .form-header h2 {
            font-size: 1.3rem;
        }
        .form-control, .form-select {
            padding: 0.7rem 1rem;
        }
    }
</style>

<div class="container-fluid px-4 py-4">
    
    <!-- Header Section -->
    <div class="form-header mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <div class="d-flex align-items-center gap-3 mb-2">
                    <i class="fas fa-plus-circle fa-3x opacity-75"></i>
                    <div>
                        <h1 class="display-5 fw-bold mb-1">Mark Attendance</h1>
                        <p class="mb-0 opacity-90 fs-5">Record daily attendance for employees</p>
                    </div>
                </div>
            </div>
            <a href="{{ route('attendance.index') }}" class="btn-back btn mt-3 mt-sm-0">
                <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
        </div>
    </div>

    <!-- Attendance Form Card -->
    <div class="form-card">
        <div class="card-header bg-white py-4 px-4 border-0">
            <div class="d-flex align-items-center gap-2">
                <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                    <i class="fas fa-calendar-check text-primary fa-lg"></i>
                </div>
                <h5 class="fw-bold mb-0">Attendance Details</h5>
                <span class="status-badge ms-3">
                    <i class="fas fa-clock"></i> Today's Date: {{ date('d M Y') }}
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

            <form action="{{ route('attendance.store') }}" method="POST">
                @csrf

                <div class="row g-4">
                    <!-- Employee Selection -->
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-user-circle"></i>
                            Employee <span class="required-star">*</span>
                        </label>
                        <select name="employee_id" class="form-select @error('employee_id') is-invalid @enderror" required>
                            <option value="">Select Employee</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->name }} - {{ $employee->position }}
                                </option>
                            @endforeach
                        </select>
                        @error('employee_id')
                            <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Date -->
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-calendar-day"></i>
                            Date <span class="required-star">*</span>
                        </label>
                        <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" 
                               value="{{ old('date', date('Y-m-d')) }}" required>
                        @error('date')
                            <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-md-4">
                        <label class="form-label">
                            <i class="fas fa-chart-simple"></i>
                            Status <span class="required-star">*</span>
                        </label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="present" {{ old('status') == 'present' ? 'selected' : '' }}>✅ Present</option>
                            <option value="absent" {{ old('status') == 'absent' ? 'selected' : '' }}>❌ Absent</option>
                            <option value="late" {{ old('status') == 'late' ? 'selected' : '' }}>⏰ Late</option>
                            <option value="half-day" {{ old('status') == 'half-day' ? 'selected' : '' }}>🌓 Half Day</option>
                        </select>
                        @error('status')
                            <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Check In Time -->
                    <div class="col-md-4">
                        <label class="form-label">
                            <i class="fas fa-sign-in-alt"></i>
                            Check In Time
                        </label>
                        <input type="time" name="check_in" class="form-control @error('check_in') is-invalid @enderror" 
                               value="{{ old('check_in', '09:00') }}">
                        @error('check_in')
                            <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Check Out Time -->
                    <div class="col-md-4">
                        <label class="form-label">
                            <i class="fas fa-sign-out-alt"></i>
                            Check Out Time
                        </label>
                        <input type="time" name="check_out" class="form-control @error('check_out') is-invalid @enderror" 
                               value="{{ old('check_out', '18:00') }}">
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
                                  rows="3" placeholder="Add any additional notes about this attendance...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="d-flex justify-content-end gap-3 mt-4 pt-3 border-top">
                    <button type="reset" class="btn-reset">
                        <i class="fas fa-undo me-2"></i>Reset
                    </button>
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save me-2"></i>Save Attendance
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Quick Tips Card -->
    <div class="tips-card mt-4">
        <div class="d-flex align-items-center gap-3">
            <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                <i class="fas fa-lightbulb text-primary fa-2x"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-1">Quick Tips</h5>
                <p class="text-muted mb-0">Mark attendance daily for accurate tracking. Use 'Late' status for employees arriving after 9:30 AM. Half-day can be used for partial attendance.</p>
            </div>
        </div>
    </div>
</div>
@endsection