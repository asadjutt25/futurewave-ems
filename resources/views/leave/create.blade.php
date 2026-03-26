@extends('layouts.app')

@section('title', 'Apply for Leave')

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

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-8px); }
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

    .btn-submit {
        background: linear-gradient(135deg, #4f46e5, #06b6d4);
        border: none;
        padding: 0.85rem 2.5rem;
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
        padding: 0.85rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-reset:hover {
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

    .balance-card {
        border-radius: 24px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        animation: fadeInUp 0.7s ease;
        cursor: pointer;
    }

    .balance-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 35px -15px rgba(0, 0, 0, 0.2);
    }

    .balance-card::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 4px;
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .balance-card.sick::after { background: #ef4444; }
    .balance-card.casual::after { background: #10b981; }
    .balance-card.annual::after { background: #8b5cf6; }
    .balance-card.unpaid::after { background: #f59e0b; }

    .balance-card:hover::after {
        transform: scaleX(1);
    }

    .float-card {
        animation: float 4s ease-in-out infinite;
    }

    .search-container {
        position: relative;
    }

    .search-input {
        border: 2px solid #e2e8f0;
        border-radius: 50px;
        padding: 0.85rem 1rem 0.85rem 3rem;
        width: 100%;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .search-input:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        outline: none;
    }

    .search-icon {
        position: absolute;
        left: 1.2rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 1rem;
    }

    .dropdown-list {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        max-height: 320px;
        overflow-y: auto;
        z-index: 1000;
        margin-top: 0.5rem;
        display: none;
        border: 1px solid #e2e8f0;
    }

    .employee-option {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.9rem 1rem;
        cursor: pointer;
        transition: all 0.2s ease;
        border-bottom: 1px solid #f1f5f9;
    }

    .employee-option:hover {
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.05), rgba(6, 182, 212, 0.05));
    }

    .employee-option.active {
        background: linear-gradient(135deg, #4f46e5, #06b6d4);
        color: white;
    }

    .option-avatar {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #4f46e5, #06b6d4);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1rem;
    }

    .selected-employee {
        background: linear-gradient(135deg, #dcfce7, #bbf7d0);
        border-radius: 20px;
        padding: 1rem 1.2rem;
        margin-top: 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        animation: slideIn 0.3s ease;
        border: 1px solid #86efac;
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
    }
</style>

<div class="container-fluid px-4 py-4">
    
    <!-- Premium Header -->
    <div class="page-header mb-4">
        <div class="p-4 position-relative">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="text-white">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <i class="fas fa-plus-circle fa-3x opacity-75"></i>
                        <div>
                            <h1 class="display-5 fw-bold mb-1">Apply for Leave</h1>
                            <p class="mb-0 opacity-90 fs-5">Submit a new leave request</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('leave.index') }}" class="btn-back mt-3 mt-sm-0">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
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

    <!-- Leave Application Form -->
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="form-card">
                <div class="form-header">
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-white bg-opacity-20 rounded-circle p-2">
                            <i class="fas fa-clock text-white fa-lg"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">Leave Application Details</h5>
                            <p class="mb-0 mt-1 opacity-75 small">Fill in the details to submit your leave request</p>
                        </div>
                    </div>
                </div>
                <div class="form-body">
                    <form action="{{ route('leave.store') }}" method="POST" id="leaveForm">
                        @csrf

                        <div class="row g-4">
                            <!-- Employee Selection -->
                            <div class="col-12">
                                <label class="form-label">
                                    <i class="fas fa-user"></i>
                                    Select Employee
                                    <span class="required-star">*</span>
                                </label>
                                <div class="search-container">
                                    <i class="fas fa-search search-icon"></i>
                                    <input type="text" id="searchEmployee" class="search-input" 
                                           placeholder="🔍 Search by name or email..." autocomplete="off">
                                    <div id="employeeDropdown" class="dropdown-list">
                                        @if(isset($employees) && count($employees) > 0)
                                            @foreach($employees as $emp)
                                                <div class="employee-option" data-id="{{ $emp->id }}" 
                                                     data-name="{{ $emp->name }}" data-email="{{ $emp->email ?? '' }}">
                                                    <div class="option-avatar">
                                                        {{ strtoupper(substr($emp->name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold">{{ $emp->name }}</div>
                                                        <small class="text-muted">{{ $emp->email ?? '' }}</small>
                                                        <div><span class="badge bg-light text-dark">{{ $emp->position ?? 'Employee' }}</span></div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <input type="hidden" name="employee_id" id="selectedEmployeeId" value="{{ old('employee_id') }}">
                                <div id="selectedEmployeeDisplay" class="selected-employee" style="display: none;">
                                    <div class="d-flex align-items-center gap-3">
                                        <i class="fas fa-check-circle text-success fa-2x"></i>
                                        <div>
                                            <strong>Selected Employee:</strong><br>
                                            <span id="selectedEmployeeName"></span>
                                            <span id="selectedEmployeeEmail" class="text-muted ms-2"></span>
                                        </div>
                                    </div>
                                    <button type="button" id="clearSelection" class="btn btn-sm btn-outline-danger rounded-pill">
                                        <i class="fas fa-times"></i> Change
                                    </button>
                                </div>
                                <small class="text-muted mt-2 d-block">
                                    <i class="fas fa-info-circle me-1"></i>Click on search box and type to search employees
                                </small>
                                @error('employee_id')
                                    <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Leave Type -->
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-tag"></i>
                                    Leave Type
                                    <span class="required-star">*</span>
                                </label>
                                <select name="leave_type" class="form-select @error('leave_type') is-invalid @enderror" required>
                                    <option value="">Select Leave Type</option>
                                    <option value="sick" {{ old('leave_type') == 'sick' ? 'selected' : '' }}>🤒 Sick Leave</option>
                                    <option value="casual" {{ old('leave_type') == 'casual' ? 'selected' : '' }}>🏖️ Casual Leave</option>
                                    <option value="annual" {{ old('leave_type') == 'annual' ? 'selected' : '' }}>📅 Annual Leave</option>
                                    <option value="unpaid" {{ old('leave_type') == 'unpaid' ? 'selected' : '' }}>💰 Unpaid Leave</option>
                                </select>
                                @error('leave_type')
                                    <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Total Days -->
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-calculator"></i>
                                    Total Days
                                </label>
                                <input type="text" id="total_days" class="form-control bg-light" value="0" readonly>
                            </div>

                            <!-- Start Date -->
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-calendar-alt"></i>
                                    Start Date
                                    <span class="required-star">*</span>
                                </label>
                                <input type="date" name="start_date" id="start_date" 
                                       class="form-control @error('start_date') is-invalid @enderror" 
                                       value="{{ old('start_date') }}" required min="{{ date('Y-m-d') }}">
                                @error('start_date')
                                    <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <!-- End Date -->
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-calendar-alt"></i>
                                    End Date
                                    <span class="required-star">*</span>
                                </label>
                                <input type="date" name="end_date" id="end_date" 
                                       class="form-control @error('end_date') is-invalid @enderror" 
                                       value="{{ old('end_date') }}" required>
                                @error('end_date')
                                    <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Reason -->
                            <div class="col-12">
                                <label class="form-label">
                                    <i class="fas fa-comment"></i>
                                    Reason for Leave
                                    <span class="required-star">*</span>
                                </label>
                                <textarea name="reason" class="form-control @error('reason') is-invalid @enderror" 
                                          rows="5" placeholder="Please provide detailed reason for your leave request...">{{ old('reason') }}</textarea>
                                @error('reason')
                                    <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                                <small class="text-muted mt-2 d-block">
                                    <i class="fas fa-info-circle me-1"></i>Please provide a clear reason for your leave request
                                </small>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-end gap-3 mt-5 pt-3 border-top">
                            <button type="reset" class="btn-reset" onclick="resetForm()">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-paper-plane"></i> Submit Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Leave Balance Cards -->
    <div class="row mt-5 g-4">
        <div class="col-md-3">
            <div class="balance-card sick float-card" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                <div class="card-body p-4 text-white">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0 fw-bold">🤒 Sick Leave</h5>
                        <div class="bg-white bg-opacity-20 rounded-circle p-3">
                            <i class="fas fa-thermometer-half fa-2x"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold mb-0">12</h2>
                    <p class="text-white-50 mb-0">days remaining</p>
                    <div class="progress mt-3" style="height: 4px;">
                        <div class="progress-bar bg-white" style="width: 20%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="balance-card casual float-card" style="background: linear-gradient(135deg, #10b981, #059669);">
                <div class="card-body p-4 text-white">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0 fw-bold">🏖️ Casual Leave</h5>
                        <div class="bg-white bg-opacity-20 rounded-circle p-3">
                            <i class="fas fa-umbrella-beach fa-2x"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold mb-0">12</h2>
                    <p class="text-white-50 mb-0">days remaining</p>
                    <div class="progress mt-3" style="height: 4px;">
                        <div class="progress-bar bg-white" style="width: 15%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="balance-card annual float-card" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                <div class="card-body p-4 text-white">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0 fw-bold">📅 Annual Leave</h5>
                        <div class="bg-white bg-opacity-20 rounded-circle p-3">
                            <i class="fas fa-calendar-alt fa-2x"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold mb-0">15</h2>
                    <p class="text-white-50 mb-0">days remaining</p>
                    <div class="progress mt-3" style="height: 4px;">
                        <div class="progress-bar bg-white" style="width: 10%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="balance-card unpaid float-card" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                <div class="card-body p-4 text-white">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0 fw-bold">💰 Unpaid Leave</h5>
                        <div class="bg-white bg-opacity-20 rounded-circle p-3">
                            <i class="fas fa-coins fa-2x"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold mb-0">∞</h2>
                    <p class="text-white-50 mb-0">with approval</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Date Calculation
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');
    const totalDays = document.getElementById('total_days');

    function calculateDays() {
        if (startDate.value && endDate.value) {
            const start = new Date(startDate.value);
            const end = new Date(endDate.value);
            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            totalDays.value = diffDays;
        }
    }

    startDate.addEventListener('change', function() {
        endDate.min = this.value;
        calculateDays();
    });

    endDate.addEventListener('change', calculateDays);

    // Employee Search and Select
    const searchInput = document.getElementById('searchEmployee');
    const dropdown = document.getElementById('employeeDropdown');
    const options = document.querySelectorAll('.employee-option');
    const selectedId = document.getElementById('selectedEmployeeId');
    const selectedDisplay = document.getElementById('selectedEmployeeDisplay');
    const selectedName = document.getElementById('selectedEmployeeName');
    const selectedEmail = document.getElementById('selectedEmployeeEmail');
    const clearBtn = document.getElementById('clearSelection');

    function filterOptions() {
        const term = searchInput.value.toLowerCase().trim();
        let hasVisible = false;
        
        options.forEach(opt => {
            const name = opt.getAttribute('data-name').toLowerCase();
            const email = opt.getAttribute('data-email').toLowerCase();
            if (term === '' || name.includes(term) || email.includes(term)) {
                opt.style.display = 'flex';
                hasVisible = true;
            } else {
                opt.style.display = 'none';
            }
        });
        
        dropdown.style.display = hasVisible ? 'block' : 'none';
    }

    searchInput.addEventListener('focus', () => {
        filterOptions();
        dropdown.style.display = 'block';
    });

    searchInput.addEventListener('keyup', filterOptions);

    options.forEach(opt => {
        opt.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const email = this.getAttribute('data-email');
            
            selectedId.value = id;
            selectedName.textContent = name;
            selectedEmail.textContent = `(${email})`;
            selectedDisplay.style.display = 'flex';
            searchInput.value = name;
            dropdown.style.display = 'none';
            
            options.forEach(o => o.classList.remove('active'));
            this.classList.add('active');
        });
    });

    clearBtn.addEventListener('click', function() {
        selectedId.value = '';
        searchInput.value = '';
        selectedDisplay.style.display = 'none';
        dropdown.style.display = 'block';
        options.forEach(o => o.classList.remove('active'));
        filterOptions();
    });

    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.style.display = 'none';
        }
    });

    // Initialize with old values
    if (selectedId.value && selectedName.textContent) {
        selectedDisplay.style.display = 'flex';
        searchInput.value = selectedName.textContent;
    }
    
    if (startDate.value && endDate.value) calculateDays();
});

function resetForm() {
    if (confirm('Are you sure you want to reset the form? All entered data will be lost.')) {
        document.getElementById('leaveForm').reset();
        document.getElementById('total_days').value = '0';
        document.getElementById('selectedEmployeeId').value = '';
        document.getElementById('selectedEmployeeDisplay').style.display = 'none';
        document.getElementById('searchEmployee').value = '';
    }
}
</script>
@endsection