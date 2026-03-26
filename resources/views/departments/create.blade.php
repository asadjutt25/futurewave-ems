@extends('layouts.app')

@section('title', 'Add Department')

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

    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.02); }
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

    .form-control::placeholder {
        color: #94a3b8;
    }

    .input-icon {
        position: relative;
    }

    .input-icon i {
        position: absolute;
        left: 1.2rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 1rem;
        z-index: 1;
    }

    .input-icon .form-control {
        padding-left: 3rem;
    }

    .btn-save {
        background: linear-gradient(135deg, #4f46e5, #06b6d4);
        border: none;
        padding: 0.85rem 2.5rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        position: relative;
        overflow: hidden;
    }

    .btn-save::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s ease;
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(79, 70, 229, 0.3);
    }

    .btn-save:hover::before {
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
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
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

    .info-card {
        background: linear-gradient(135deg, #fef9e7, #fff5e6);
        border-radius: 20px;
        padding: 1.2rem;
        margin-top: 1.5rem;
        border-left: 4px solid #4f46e5;
        transition: all 0.3s ease;
    }

    .info-card:hover {
        transform: translateX(5px);
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

    .character-count {
        font-size: 0.7rem;
        color: #94a3b8;
        margin-top: 0.25rem;
        text-align: right;
    }

    @media (max-width: 768px) {
        .form-header {
            padding: 1.2rem;
        }
        .form-body {
            padding: 1.2rem;
        }
        .btn-save, .btn-cancel {
            padding: 0.7rem 1.5rem;
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
                            <h1 class="display-5 fw-bold mb-1">Add New Department</h1>
                            <p class="mb-0 opacity-90 fs-5">Create a new department in your organization</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('departments.index') }}" class="btn-back mt-3 mt-sm-0">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="form-card">
                <div class="form-header">
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-white bg-opacity-20 rounded-circle p-2">
                            <i class="fas fa-building text-white fa-lg"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">Department Information</h5>
                            <p class="mb-0 mt-1 opacity-75 small">Fill in the details to create a new department</p>
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
                        </div>
                    @endif

                    <form action="{{ route('departments.store') }}" method="POST">
                        @csrf

                        <div class="row g-4">
                            <!-- Department Name -->
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-tag"></i>
                                    Department Name
                                    <span class="required-star">*</span>
                                </label>
                                <div class="input-icon">
                                    <i class="fas fa-building"></i>
                                    <input type="text" name="department_name" 
                                           class="form-control @error('department_name') is-invalid @enderror" 
                                           value="{{ old('department_name') }}" 
                                           placeholder="e.g., Information Technology" 
                                           required>
                                </div>
                                @error('department_name')
                                    <div class="error-feedback">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                                <small class="text-muted d-block mt-1">
                                    <i class="fas fa-info-circle me-1"></i>Use a clear and descriptive name
                                </small>
                            </div>

                            <!-- Department Head -->
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-user-tie"></i>
                                    Department Head
                                    <span class="required-star">*</span>
                                </label>
                                <div class="input-icon">
                                    <i class="fas fa-user"></i>
                                    <input type="text" name="department_head" 
                                           class="form-control @error('department_head') is-invalid @enderror" 
                                           value="{{ old('department_head') }}" 
                                           placeholder="e.g., John Doe" 
                                           required>
                                </div>
                                @error('department_head')
                                    <div class="error-feedback">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="col-12">
                                <label class="form-label">
                                    <i class="fas fa-align-left"></i>
                                    Description
                                    <span class="required-star">*</span>
                                </label>
                                <textarea name="description" 
                                          class="form-control @error('description') is-invalid @enderror" 
                                          rows="5" 
                                          placeholder="Describe the department's purpose, responsibilities, and scope..."
                                          id="descriptionText">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="error-feedback">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                                <div class="character-count">
                                    <i class="fas fa-font me-1"></i><span id="charCount">0</span> characters
                                </div>
                                <small class="text-muted d-block mt-1">
                                    <i class="fas fa-info-circle me-1"></i>Provide a clear description of the department's role and responsibilities
                                </small>
                            </div>
                        </div>

                        <!-- Info Card -->
                        <div class="info-card mt-4">
                            <div class="d-flex gap-3">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                                    <i class="fas fa-lightbulb fa-lg text-primary"></i>
                                </div>
                                <div>
                                    <strong class="text-dark">Pro Tip</strong>
                                    <p class="text-muted small mb-0">A well-defined department helps organize your company structure. Add a clear description to help employees understand the department's purpose, goals, and responsibilities.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-end gap-3 mt-5 pt-3 border-top">
                            <button type="reset" class="btn-cancel" onclick="resetForm()">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                            <button type="submit" class="btn-save">
                                <i class="fas fa-save"></i> Create Department
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Character counter for description
    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.getElementById('descriptionText');
        const charCount = document.getElementById('charCount');
        
        function updateCharCount() {
            charCount.textContent = textarea.value.length;
        }
        
        textarea.addEventListener('input', updateCharCount);
        updateCharCount();
    });
    
    // Reset form confirmation
    function resetForm() {
        if (confirm('Are you sure you want to reset the form? All entered data will be lost.')) {
            document.querySelector('form').reset();
            document.getElementById('charCount').textContent = '0';
        }
    }
</script>
@endsection