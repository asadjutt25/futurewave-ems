@extends('layouts.app')

@section('title', 'Add Employee')

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

    .form-section-premium {
        background: linear-gradient(135deg, rgba(79,70,229,0.02), rgba(6,182,212,0.02));
        border-radius: 24px;
        padding: 1.8rem;
        margin-bottom: 1.8rem;
        border: 1px solid rgba(79,70,229,0.08);
        transition: all 0.3s ease;
    }

    .form-section-premium:hover {
        border-color: rgba(79,70,229,0.2);
        box-shadow: 0 5px 20px rgba(79,70,229,0.05);
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

    .preview-image {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
        transition: all 0.3s ease;
    }

    .preview-image:hover {
        transform: scale(1.05);
        box-shadow: 0 15px 35px rgba(79, 70, 229, 0.4);
    }

    .image-placeholder {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        border: 2px dashed #cbd5e1;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .image-placeholder:hover {
        border-color: #4f46e5;
        background: rgba(79,70,229,0.05);
    }

    .btn-upload {
        background: linear-gradient(135deg, #4f46e5, #06b6d4);
        border: none;
        color: white;
        padding: 10px 24px;
        border-radius: 50px;
        transition: all 0.3s ease;
        cursor: pointer;
        font-weight: 600;
        position: relative;
        overflow: hidden;
    }

    .btn-upload::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s ease;
    }

    .btn-upload:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(79, 70, 229, 0.3);
    }

    .btn-upload:hover::before {
        left: 100%;
    }

    .btn-submit {
        background: linear-gradient(135deg, #4f46e5, #06b6d4);
        border: none;
        padding: 0.9rem 2.5rem;
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

    .section-title {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #e2e8f0;
    }

    .section-title i {
        font-size: 1.3rem;
        color: #4f46e5;
    }

    .section-title h5 {
        font-weight: 700;
        margin-bottom: 0;
        color: #1e293b;
    }

    @media (max-width: 768px) {
        .form-section-premium {
            padding: 1.2rem;
        }
        .form-control, .form-select {
            padding: 0.7rem 1rem;
        }
        .preview-image, .image-placeholder {
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
                        <i class="fas fa-user-plus fa-3x opacity-75"></i>
                        <div>
                            <h1 class="display-5 fw-bold mb-1">Add New Employee</h1>
                            <p class="mb-0 opacity-90 fs-5">Add a new team member to your organization</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('employees.index') }}" class="btn-back mt-3 mt-sm-0">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
            </div>
        </div>
    </div>

    <!-- Employee Form -->
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="form-card">
                <div class="card-body p-4 p-lg-5">
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

                    <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Basic Information Section -->
                        <div class="form-section-premium">
                            <div class="section-title">
                                <i class="fas fa-user-circle"></i>
                                <h5>Basic Information</h5>
                            </div>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-user"></i> Full Name <span class="required-star">*</span>
                                    </label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name') }}" placeholder="e.g., John Doe" required>
                                    @error('name')
                                        <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-envelope"></i> Email Address <span class="required-star">*</span>
                                    </label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                           value="{{ old('email') }}" placeholder="employee@company.com" required>
                                    @error('email')
                                        <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-phone"></i> Phone Number <span class="required-star">*</span>
                                    </label>
                                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                           value="{{ old('phone') }}" placeholder="+92 300 1234567" required>
                                    @error('phone')
                                        <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-calendar-alt"></i> Joining Date <span class="required-star">*</span>
                                    </label>
                                    <input type="date" name="joining_date" class="form-control @error('joining_date') is-invalid @enderror" 
                                           value="{{ old('joining_date', date('Y-m-d')) }}" required>
                                    @error('joining_date')
                                        <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Professional Information Section -->
                        <div class="form-section-premium">
                            <div class="section-title">
                                <i class="fas fa-briefcase"></i>
                                <h5>Professional Information</h5>
                            </div>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-building"></i> Department <span class="required-star">*</span>
                                    </label>
                                    <select name="department_id" class="form-select @error('department_id') is-invalid @enderror" required>
                                        <option value="">Select Department</option>
                                        @foreach($departments as $dept)
                                            <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
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
                                           value="{{ old('position') }}" placeholder="e.g., Software Engineer" required>
                                    @error('position')
                                        <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-dollar-sign"></i> Salary <span class="required-star">*</span>
                                    </label>
                                    <input type="number" name="salary" class="form-control @error('salary') is-invalid @enderror" 
                                           value="{{ old('salary') }}" placeholder="0.00" required>
                                    @error('salary')
                                        <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-key"></i> Password <span class="required-star">*</span>
                                    </label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                                           placeholder="Enter password" required>
                                    @error('password')
                                        <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-check-circle"></i> Confirm Password <span class="required-star">*</span>
                                    </label>
                                    <input type="password" name="password_confirmation" class="form-control" 
                                           placeholder="Confirm password" required>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Image Section -->
                        <div class="form-section-premium">
                            <div class="section-title">
                                <i class="fas fa-image"></i>
                                <h5>Profile Image</h5>
                            </div>
                            <div class="text-center">
                                <div class="d-flex justify-content-center mb-3">
                                    <img id="imagePreview" src="#" alt="Preview" class="preview-image" style="display: none;">
                                    <div id="imagePlaceholder" class="image-placeholder">
                                        <i class="fas fa-user fa-3x text-secondary"></i>
                                    </div>
                                </div>
                                <div>
                                    <label class="btn-upload">
                                        <i class="fas fa-cloud-upload-alt me-2"></i>Choose Image
                                        <input type="file" name="image" id="imageInput" style="display: none;" accept="image/jpeg,image/png,image/jpg">
                                    </label>
                                    <small class="text-muted d-block mt-2">
                                        <i class="fas fa-info-circle me-1"></i>Allowed: JPG, PNG, JPEG. Max size: <strong class="text-primary">20MB</strong>
                                    </small>
                                    @error('image')
                                        <div class="error-feedback justify-content-center mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Address Section -->
                        <div class="form-section-premium">
                            <div class="section-title">
                                <i class="fas fa-map-marker-alt"></i>
                                <h5>Address</h5>
                            </div>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" 
                                      rows="4" placeholder="Enter employee address (Street, City, Country)">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="error-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-end gap-3 mt-4 pt-3 border-top">
                            <button type="reset" class="btn-reset" onclick="resetForm()">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-save"></i> Save Employee
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Image preview functionality with size validation
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const imagePlaceholder = document.getElementById('imagePlaceholder');

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Check file size (20MB)
            const maxSize = 20 * 1024 * 1024;
            if (file.size > maxSize) {
                alert('File size must be less than 20MB. Your file size: ' + (file.size / 1024 / 1024).toFixed(2) + 'MB');
                this.value = '';
                return false;
            }
            
            // Check file type
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!allowedTypes.includes(file.type)) {
                alert('Only JPG, JPEG, and PNG files are allowed');
                this.value = '';
                return false;
            }
            
            // Preview image
            const reader = new FileReader();
            reader.onload = function(event) {
                imagePreview.src = event.target.result;
                imagePreview.style.display = 'block';
                imagePlaceholder.style.display = 'none';
            }
            reader.readAsDataURL(file);
        }
    });

    // Reset form confirmation
    function resetForm() {
        if (confirm('Are you sure you want to reset the form? All entered data will be lost.')) {
            document.querySelector('form').reset();
            imagePreview.style.display = 'none';
            imagePlaceholder.style.display = 'flex';
            imageInput.value = '';
        }
    }
</script>
@endsection