@extends('layouts.app')

@section('title', 'Edit Profile')

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

    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
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

    .profile-card-premium {
        background: white;
        border-radius: 28px;
        box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: all 0.3s ease;
        animation: fadeInUp 0.6s ease;
    }

    .profile-card-premium:hover {
        transform: translateY(-3px);
        box-shadow: 0 25px 40px -12px rgba(0, 0, 0, 0.15);
    }

    .profile-header-premium {
        background: linear-gradient(135deg, #4f46e5, #06b6d4);
        padding: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .profile-header-premium::before {
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

    .profile-avatar-premium {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        transition: all 0.3s ease;
        border: 4px solid white;
        position: relative;
        cursor: pointer;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    .profile-avatar-premium:hover {
        transform: scale(1.05) rotate(5deg);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
    }

    .profile-avatar-premium img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-avatar-premium span {
        font-size: 3rem;
        font-weight: 800;
        color: white;
    }

    .avatar-overlay-premium {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(5px);
        color: white;
        text-align: center;
        padding: 8px;
        font-size: 12px;
        transform: translateY(100%);
        transition: transform 0.3s ease;
        font-weight: 600;
    }

    .profile-avatar-premium:hover .avatar-overlay-premium {
        transform: translateY(0);
    }

    .profile-section-premium {
        padding: 2rem;
    }

    .section-title-premium {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-title-premium i {
        color: #4f46e5;
        font-size: 1.2rem;
    }

    .info-row-premium {
        display: flex;
        padding: 0.9rem 0;
        border-bottom: 1px solid #f1f5f9;
        transition: all 0.2s ease;
    }

    .info-row-premium:hover {
        transform: translateX(5px);
    }

    .info-label-premium {
        width: 130px;
        font-weight: 600;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-label-premium i {
        width: 20px;
        color: #4f46e5;
    }

    .info-value-premium {
        flex: 1;
        color: #1e293b;
        font-weight: 500;
    }

    .form-label-premium {
        font-weight: 600;
        color: #475569;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label-premium i {
        color: #4f46e5;
    }

    .form-control-premium {
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        padding: 0.85rem 1rem;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .form-control-premium:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        outline: none;
    }

    .btn-update-premium {
        background: linear-gradient(135deg, #4f46e5, #06b6d4);
        border: none;
        padding: 0.85rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-update-premium::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s ease;
    }

    .btn-update-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(79, 70, 229, 0.3);
    }

    .btn-update-premium:hover::before {
        left: 100%;
    }

    .btn-password-premium {
        background: linear-gradient(135deg, #f59e0b, #ef4444);
        border: none;
        padding: 0.85rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-password-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(245, 158, 11, 0.3);
    }

    .btn-danger-premium {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        border: none;
        padding: 0.85rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-danger-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(239, 68, 68, 0.3);
    }

    .alert-premium {
        border-radius: 20px;
        padding: 1rem 1.2rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        animation: fadeInUp 0.3s ease;
    }

    .alert-success-premium {
        background: #dcfce7;
        color: #166534;
        border-left: 4px solid #22c55e;
    }

    .alert-error-premium {
        background: #fee2e2;
        color: #991b1b;
        border-left: 4px solid #ef4444;
    }

    .modal-premium {
        border-radius: 24px;
        border: none;
        overflow: hidden;
    }

    .modal-header-premium {
        background: linear-gradient(135deg, #ef4444, #f97316);
        color: white;
        padding: 1.2rem;
        border: none;
    }

    .input-group-icon-premium {
        position: relative;
    }

    .input-group-icon-premium i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 1rem;
    }

    .input-group-icon-premium input,
    .input-group-icon-premium textarea {
        padding-left: 2.5rem;
    }

    @media (max-width: 768px) {
        .profile-avatar-premium {
            width: 100px;
            height: 100px;
        }
        .profile-avatar-premium span {
            font-size: 2.5rem;
        }
        .info-label-premium {
            width: 100px;
            font-size: 0.85rem;
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
                            <h1 class="display-5 fw-bold mb-1">Edit Profile</h1>
                            <p class="mb-0 opacity-90 fs-5">Update your personal information and profile picture</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('profile.show') }}" class="btn btn-light rounded-pill px-4 py-2 shadow-sm mt-3 mt-sm-0">
                    <i class="fas fa-arrow-left me-2"></i>Back to Profile
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Left Column - Profile Card -->
        <div class="col-lg-6">
            <div class="profile-card-premium">
                <div class="profile-header-premium text-center">
                    <!-- Avatar with Upload Feature -->
                    <div class="profile-avatar-premium mx-auto" id="avatarContainer" onclick="document.getElementById('imageInput').click()">
                        @php
                            $imagePath = null;
                            if(isset($employee) && $employee && $employee->image && file_exists(public_path($employee->image))) {
                                $imagePath = asset($employee->image);
                            } elseif(isset($user) && $user->profile_picture && file_exists(public_path($user->profile_picture))) {
                                $imagePath = asset($user->profile_picture);
                            }
                        @endphp
                        
                        @if($imagePath)
                            <img src="{{ $imagePath }}" alt="Profile Picture" id="avatarImage">
                        @else
                            <span id="avatarText">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                        @endif
                        <div class="avatar-overlay-premium">
                            <i class="fas fa-camera"></i> Change Photo
                        </div>
                    </div>
                    <h3 class="mt-3 mb-0 fw-bold">{{ Auth::user()->name }}</h3>
                    <p class="mb-0 opacity-75">{{ Auth::user()->email }}</p>
                    <p class="mb-0 mt-2">
                        <span class="badge bg-light text-dark rounded-pill px-3 py-1">
                            <i class="fas fa-user-tag me-1"></i>{{ Auth::user()->role ?? 'Employee' }}
                        </span>
                    </p>
                </div>
                <div class="profile-section-premium">
                    <div class="section-title-premium">
                        <i class="fas fa-info-circle"></i>
                        Personal Information
                    </div>
                    <div class="info-row-premium">
                        <div class="info-label-premium">
                            <i class="fas fa-user"></i> Full Name
                        </div>
                        <div class="info-value-premium">{{ Auth::user()->name }}</div>
                    </div>
                    <div class="info-row-premium">
                        <div class="info-label-premium">
                            <i class="fas fa-envelope"></i> Email Address
                        </div>
                        <div class="info-value-premium">{{ Auth::user()->email }}</div>
                    </div>
                    <div class="info-row-premium">
                        <div class="info-label-premium">
                            <i class="fas fa-phone"></i> Phone Number
                        </div>
                        <div class="info-value-premium">{{ $employee->phone ?? 'Not provided' }}</div>
                    </div>
                    <div class="info-row-premium">
                        <div class="info-label-premium">
                            <i class="fas fa-map-marker-alt"></i> Address
                        </div>
                        <div class="info-value-premium">{{ $employee->address ?? 'Not provided' }}</div>
                    </div>
                    <div class="info-row-premium">
                        <div class="info-label-premium">
                            <i class="fas fa-calendar-alt"></i> Member Since
                        </div>
                        <div class="info-value-premium">{{ Auth::user()->created_at->format('d F Y') }}</div>
                    </div>
                    <div class="info-row-premium">
                        <div class="info-label-premium">
                            <i class="fas fa-shield-alt"></i> Account Status
                        </div>
                        <div class="info-value-premium">
                            <span class="badge bg-success rounded-pill">Active</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Update Form -->
        <div class="col-lg-6">
            <div class="profile-card-premium">
                <div class="profile-header-premium">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-edit me-2"></i>Edit Profile
                    </h5>
                    <p class="mb-0 mt-1 opacity-75 small">Update your personal information</p>
                </div>
                <div class="profile-section-premium">
                    @if(session('success'))
                        <div class="alert-premium alert-success-premium">
                            <i class="fas fa-check-circle fa-lg"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert-premium alert-error-premium">
                            <i class="fas fa-exclamation-circle fa-lg"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert-premium alert-error-premium">
                            <i class="fas fa-exclamation-triangle fa-lg"></i>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Hidden Image Input -->
                        <input type="file" name="image" id="imageInput" class="d-none" accept="image/jpeg,image/png,image/jpg" onchange="previewImage(this)">

                        <div class="mb-4">
                            <label class="form-label-premium">
                                <i class="fas fa-user"></i> Full Name
                            </label>
                            <div class="input-group-icon-premium">
                                <i class="fas fa-user"></i>
                                <input type="text" name="name" class="form-control-premium" value="{{ old('name', Auth::user()->name) }}" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label-premium">
                                <i class="fas fa-envelope"></i> Email Address
                            </label>
                            <div class="input-group-icon-premium">
                                <i class="fas fa-envelope"></i>
                                <input type="email" name="email" class="form-control-premium" value="{{ old('email', Auth::user()->email) }}" required>
                            </div>
                            <small class="text-muted mt-1 d-block">
                                <i class="fas fa-info-circle me-1"></i>Changing email will require re-verification
                            </small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label-premium">
                                <i class="fas fa-phone"></i> Phone Number
                            </label>
                            <div class="input-group-icon-premium">
                                <i class="fas fa-phone"></i>
                                <input type="text" name="phone" class="form-control-premium" value="{{ old('phone', $employee->phone ?? '') }}" placeholder="+92 300 1234567">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label-premium">
                                <i class="fas fa-map-marker-alt"></i> Address
                            </label>
                            <div class="input-group-icon-premium">
                                <i class="fas fa-map-marker-alt"></i>
                                <textarea name="address" class="form-control-premium" rows="3" placeholder="Your address">{{ old('address', $employee->address ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label-premium">
                                <i class="fas fa-camera"></i> Profile Picture
                            </label>
                            <div class="input-group">
                                <input type="file" name="image" class="form-control-premium" id="profileImageInput" accept="image/jpeg,image/png,image/jpg">
                                <label class="input-group-text" for="profileImageInput">
                                    <i class="fas fa-upload"></i> Browse
                                </label>
                            </div>
                            <small class="text-muted mt-1 d-block">
                                <i class="fas fa-info-circle me-1"></i>Allowed formats: JPG, JPEG, PNG. Max size: <strong class="text-primary">20MB</strong>
                            </small>
                            @error('image')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn-update-premium w-100">
                            <i class="fas fa-save me-2"></i>Update Profile
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Change Password & Account Actions Row -->
    <div class="row mt-4 g-4">
        <!-- Change Password Card -->
        <div class="col-lg-6">
            <div class="profile-card-premium">
                <div class="profile-header-premium" style="background: linear-gradient(135deg, #f59e0b, #ef4444);">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-key me-2"></i>Change Password
                    </h5>
                    <p class="mb-0 mt-1 opacity-75 small">Update your password to keep your account secure</p>
                </div>
                <div class="profile-section-premium">
                    <form method="POST" action="{{ route('profile.password') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="form-label-premium">
                                <i class="fas fa-lock"></i> Current Password
                            </label>
                            <div class="input-group-icon-premium">
                                <i class="fas fa-key"></i>
                                <input type="password" name="current_password" class="form-control-premium" placeholder="Enter current password" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label-premium">
                                <i class="fas fa-lock"></i> New Password
                            </label>
                            <div class="input-group-icon-premium">
                                <i class="fas fa-key"></i>
                                <input type="password" name="new_password" class="form-control-premium" placeholder="Enter new password" required>
                            </div>
                            <small class="text-muted mt-1 d-block">
                                <i class="fas fa-info-circle me-1"></i>Password must be at least 8 characters
                            </small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label-premium">
                                <i class="fas fa-check-circle"></i> Confirm New Password
                            </label>
                            <div class="input-group-icon-premium">
                                <i class="fas fa-check-circle"></i>
                                <input type="password" name="new_password_confirmation" class="form-control-premium" placeholder="Confirm new password" required>
                            </div>
                        </div>

                        <button type="submit" class="btn-password-premium w-100">
                            <i class="fas fa-sync-alt me-2"></i>Change Password
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Account Actions Card -->
        <div class="col-lg-6">
            <div class="profile-card-premium">
                <div class="profile-header-premium" style="background: linear-gradient(135deg, #ef4444, #f97316);">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>Account Actions
                    </h5>
                    <p class="mb-0 mt-1 opacity-75 small">Manage your account settings</p>
                </div>
                <div class="profile-section-premium">
                    <div class="alert-premium alert-error-premium mb-4" style="background: #fff5f5; border-left-color: #ef4444;">
                        <i class="fas fa-shield-alt fa-lg"></i>
                        <div>
                            <strong>Security Notice</strong><br>
                            <small>Account deletion is permanent and cannot be undone.</small>
                        </div>
                    </div>

                    <button type="button" class="btn-danger-premium w-100" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                        <i class="fas fa-trash-alt me-2"></i>Delete Account
                    </button>

                    <div class="mt-4 pt-3 border-top">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-sign-out-alt text-muted me-2"></i>
                                <span class="text-muted">Logout from account</span>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-secondary rounded-pill px-4">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-premium">
            <div class="modal-header-premium">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-exclamation-triangle me-2"></i>Delete Account
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <i class="fas fa-user-slash fa-4x text-danger mb-3"></i>
                    <h4>Are you sure?</h4>
                    <p class="text-muted">This action cannot be undone. All your data will be permanently removed.</p>
                </div>
                <div class="alert alert-warning">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Warning:</strong> This will permanently delete your account and all associated data.
                </div>
            </div>
            <div class="modal-footer border-0 pb-4 pe-4">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger rounded-pill px-4">
                        <i class="fas fa-trash-alt me-2"></i>Delete Account
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Preview image function with validation
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            
            const maxSize = 20 * 1024 * 1024;
            if (file.size > maxSize) {
                alert('File size must be less than 20MB. Your file size: ' + (file.size / 1024 / 1024).toFixed(2) + 'MB');
                input.value = '';
                return false;
            }
            
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!allowedTypes.includes(file.type)) {
                alert('Only JPG, JPEG, and PNG files are allowed');
                input.value = '';
                return false;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const avatarContainer = document.getElementById('avatarContainer');
                const existingImg = avatarContainer.querySelector('img');
                const existingSpan = avatarContainer.querySelector('span');
                
                if (existingImg) {
                    existingImg.src = e.target.result;
                } else if (existingSpan) {
                    existingSpan.style.display = 'none';
                    const newImg = document.createElement('img');
                    newImg.id = 'avatarImage';
                    newImg.src = e.target.result;
                    avatarContainer.insertBefore(newImg, existingSpan);
                } else {
                    const newImg = document.createElement('img');
                    newImg.id = 'avatarImage';
                    newImg.src = e.target.result;
                    avatarContainer.appendChild(newImg);
                }
            }
            reader.readAsDataURL(file);
        }
    }

    // Handle file input change with validation
    document.getElementById('profileImageInput')?.addEventListener('change', function(e) {
        const file = this.files[0];
        if (file) {
            const maxSize = 20 * 1024 * 1024;
            if (file.size > maxSize) {
                alert('File size must be less than 20MB. Your file size: ' + (file.size / 1024 / 1024).toFixed(2) + 'MB');
                this.value = '';
                return false;
            }
            
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!allowedTypes.includes(file.type)) {
                alert('Only JPG, JPEG, and PNG files are allowed');
                this.value = '';
                return false;
            }
            
            previewImage(this);
        }
    });

    // Auto-hide alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            document.querySelectorAll('.alert-premium').forEach(function(alert) {
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