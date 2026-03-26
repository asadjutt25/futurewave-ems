@extends('layouts.app')

@section('title', 'Process Salary')

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
        0% { background-position: -1000px 0; }
        100% { background-position: 1000px 0; }
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    .salary-header {
        background: linear-gradient(135deg, #4f46e5, #06b6d4);
        border-radius: 24px;
        padding: 1.5rem;
        color: white;
        position: relative;
        overflow: hidden;
        margin-bottom: 2rem;
        animation: fadeInUp 0.6s ease;
    }
    
    .salary-header::before {
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
        box-shadow: 0 20px 35px -10px rgba(0,0,0,0.1);
        overflow: hidden;
        animation: fadeInUp 0.7s ease;
        transition: all 0.3s ease;
    }
    
    .form-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 25px 40px -12px rgba(0,0,0,0.15);
    }
    
    .form-header {
        background: linear-gradient(135deg, #f59e0b, #ef4444);
        padding: 1rem 1.5rem;
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
    
    .form-control, .form-select {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #f59e0b;
        box-shadow: 0 0 0 3px rgba(245,158,11,0.1);
        outline: none;
    }
    
    .input-group-icon {
        position: relative;
    }
    
    .input-group-icon i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
    }
    
    .input-group-icon input, 
    .input-group-icon select {
        padding-left: 2.5rem;
    }
    
    .btn-submit {
        background: linear-gradient(135deg, #f59e0b, #ef4444);
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(245,158,11,0.3);
    }
    
    .btn-reset {
        background: #f1f5f9;
        border: none;
        color: #475569;
        padding: 0.75rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-reset:hover {
        background: #e2e8f0;
        transform: translateY(-2px);
    }
    
    .btn-back {
        background: #f1f5f9;
        border: none;
        color: #475569;
        padding: 0.6rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-back:hover {
        background: #e2e8f0;
        transform: translateY(-2px);
    }
    
    .summary-card {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border-radius: 20px;
        padding: 1rem;
        margin-top: 1.5rem;
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
    
    .info-badge {
        background: linear-gradient(135deg, rgba(79,70,229,0.1), rgba(6,182,212,0.1));
        color: #4f46e5;
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 600;
    }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="salary-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h2 class="fw-bold mb-2">
                    <i class="fas fa-dollar-sign me-2"></i>Process Salary
                </h2>
                <p class="mb-0 opacity-90">Process monthly salary for employees</p>
            </div>
            <a href="{{ route('salary.index') }}" class="btn-back btn mt-2 mt-sm-0">
                <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
        </div>
    </div>

    <!-- Salary Form Card -->
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="form-card">
                <div class="form-header">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-calculator me-2"></i>Salary Details
                    </h5>
                    <p class="mb-0 mt-1 opacity-75 small">Fill in the details to process salary</p>
                </div>
                <div class="form-body">
                    @if($errors->any())
                        <div class="alert alert-danger rounded-4 mb-4">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-exclamation-triangle"></i>
                                <strong>Please fix the following errors:</strong>
                            </div>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('salary.store') }}" method="POST">
                        @csrf

                        <div class="row g-4">
                            <!-- Employee Selection -->
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-user text-primary"></i>
                                    Employee <span class="required-star">*</span>
                                </label>
                                <div class="input-group-icon">
                                    <i class="fas fa-users"></i>
                                    <select name="employee_id" class="form-select @error('employee_id') is-invalid @enderror" required>
                                        <option value="">Select Employee</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->name }} ({{ $employee->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('employee_id')
                                    <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Month -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    <i class="fas fa-calendar-alt text-primary"></i>
                                    Month <span class="required-star">*</span>
                                </label>
                                <div class="input-group-icon">
                                    <i class="fas fa-calendar"></i>
                                    <select name="month" class="form-select @error('month') is-invalid @enderror" required>
                                        <option value="">Select Month</option>
                                        @foreach($months as $month)
                                            <option value="{{ $month }}" {{ old('month') == $month ? 'selected' : '' }}>
                                                {{ $month }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('month')
                                    <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Year -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    <i class="fas fa-calendar-alt text-primary"></i>
                                    Year <span class="required-star">*</span>
                                </label>
                                <div class="input-group-icon">
                                    <i class="fas fa-calendar"></i>
                                    <select name="year" class="form-select @error('year') is-invalid @enderror" required>
                                        <option value="">Select Year</option>
                                        @for($y = date('Y'); $y >= date('Y')-2; $y--)
                                            <option value="{{ $y }}" {{ old('year') == $y ? 'selected' : '' }}>
                                                {{ $y }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                @error('year')
                                    <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Basic Salary -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    <i class="fas fa-dollar-sign text-primary"></i>
                                    Basic Salary <span class="required-star">*</span>
                                </label>
                                <div class="input-group-icon">
                                    <i class="fas fa-dollar-sign"></i>
                                    <input type="number" name="basic_salary" class="form-control @error('basic_salary') is-invalid @enderror" 
                                           value="{{ old('basic_salary') }}" step="0.01" placeholder="0.00" required>
                                </div>
                                @error('basic_salary')
                                    <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Allowances -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    <i class="fas fa-plus-circle text-success"></i>
                                    Allowances
                                </label>
                                <div class="input-group-icon">
                                    <i class="fas fa-plus-circle"></i>
                                    <input type="number" name="allowances" class="form-control @error('allowances') is-invalid @enderror" 
                                           value="{{ old('allowances', 0) }}" step="0.01" placeholder="0.00">
                                </div>
                                @error('allowances')
                                    <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Deductions -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    <i class="fas fa-minus-circle text-danger"></i>
                                    Deductions
                                </label>
                                <div class="input-group-icon">
                                    <i class="fas fa-minus-circle"></i>
                                    <input type="number" name="deductions" class="form-control @error('deductions') is-invalid @enderror" 
                                           value="{{ old('deductions', 0) }}" step="0.01" placeholder="0.00">
                                </div>
                                @error('deductions')
                                    <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tax -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    <i class="fas fa-chart-line text-warning"></i>
                                    Tax
                                </label>
                                <div class="input-group-icon">
                                    <i class="fas fa-chart-line"></i>
                                    <input type="number" name="tax" class="form-control @error('tax') is-invalid @enderror" 
                                           value="{{ old('tax', 0) }}" step="0.01" placeholder="0.00">
                                </div>
                                @error('tax')
                                    <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Payment Method -->
                            <div class="col-md-4">
                                <label class="form-label">
                                    <i class="fas fa-credit-card text-primary"></i>
                                    Payment Method <span class="required-star">*</span>
                                </label>
                                <div class="input-group-icon">
                                    <i class="fas fa-credit-card"></i>
                                    <select name="payment_method" class="form-select @error('payment_method') is-invalid @enderror" required>
                                        <option value="bank" {{ old('payment_method') == 'bank' ? 'selected' : '' }}>🏦 Bank Transfer</option>
                                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>💵 Cash</option>
                                        <option value="check" {{ old('payment_method') == 'check' ? 'selected' : '' }}>📝 Check</option>
                                    </select>
                                </div>
                                @error('payment_method')
                                    <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Transaction ID -->
                            <div class="col-md-4">
                                <label class="form-label">
                                    <i class="fas fa-qrcode text-primary"></i>
                                    Transaction ID
                                </label>
                                <div class="input-group-icon">
                                    <i class="fas fa-qrcode"></i>
                                    <input type="text" name="transaction_id" class="form-control @error('transaction_id') is-invalid @enderror" 
                                           value="{{ old('transaction_id') }}" placeholder="Enter transaction ID">
                                </div>
                                @error('transaction_id')
                                    <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Payment Date -->
                            <div class="col-md-4">
                                <label class="form-label">
                                    <i class="fas fa-calendar-day text-primary"></i>
                                    Payment Date <span class="required-star">*</span>
                                </label>
                                <div class="input-group-icon">
                                    <i class="fas fa-calendar"></i>
                                    <input type="date" name="payment_date" class="form-control @error('payment_date') is-invalid @enderror" 
                                           value="{{ old('payment_date', date('Y-m-d')) }}" required>
                                </div>
                                @error('payment_date')
                                    <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Notes -->
                            <div class="col-12">
                                <label class="form-label">
                                    <i class="fas fa-sticky-note text-primary"></i>
                                    Notes
                                </label>
                                <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" 
                                          rows="3" placeholder="Additional notes about this salary payment...">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Salary Summary -->
                        <div class="summary-card">
                            <div class="row">
                                <div class="col-md-12">
                                    <h6 class="fw-bold mb-3">
                                        <i class="fas fa-chart-simple me-2 text-primary"></i>Salary Summary
                                    </h6>
                                    <div class="row text-center">
                                        <div class="col-md-3">
                                            <span class="text-muted small">Basic Salary</span>
                                            <h6 class="fw-bold text-primary" id="basicPreview">$0.00</h6>
                                        </div>
                                        <div class="col-md-3">
                                            <span class="text-muted small">Allowances</span>
                                            <h6 class="fw-bold text-success" id="allowancesPreview">$0.00</h6>
                                        </div>
                                        <div class="col-md-3">
                                            <span class="text-muted small">Deductions</span>
                                            <h6 class="fw-bold text-danger" id="deductionsPreview">$0.00</h6>
                                        </div>
                                        <div class="col-md-3">
                                            <span class="text-muted small">Net Salary</span>
                                            <h6 class="fw-bold text-warning" id="netPreview">$0.00</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-end gap-3 mt-4 pt-3 border-top">
                            <button type="reset" class="btn-reset">
                                <i class="fas fa-undo me-2"></i>Reset
                            </button>
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-save me-2"></i>Process Salary
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Live Salary Calculation
    document.addEventListener('DOMContentLoaded', function() {
        const basicSalary = document.querySelector('input[name="basic_salary"]');
        const allowances = document.querySelector('input[name="allowances"]');
        const deductions = document.querySelector('input[name="deductions"]');
        const tax = document.querySelector('input[name="tax"]');
        
        const basicPreview = document.getElementById('basicPreview');
        const allowancesPreview = document.getElementById('allowancesPreview');
        const deductionsPreview = document.getElementById('deductionsPreview');
        const netPreview = document.getElementById('netPreview');
        
        function updatePreview() {
            const basic = parseFloat(basicSalary.value) || 0;
            const allow = parseFloat(allowances.value) || 0;
            const deduct = parseFloat(deductions.value) || 0;
            const taxVal = parseFloat(tax.value) || 0;
            
            const net = basic + allow - deduct - taxVal;
            
            basicPreview.textContent = `$${basic.toFixed(2)}`;
            allowancesPreview.textContent = `$${allow.toFixed(2)}`;
            deductionsPreview.textContent = `-$${deduct.toFixed(2)}`;
            netPreview.textContent = `$${net.toFixed(2)}`;
        }
        
        basicSalary.addEventListener('input', updatePreview);
        allowances.addEventListener('input', updatePreview);
        deductions.addEventListener('input', updatePreview);
        tax.addEventListener('input', updatePreview);
        
        // Initial calculation
        updatePreview();
    });
</script>
@endsection