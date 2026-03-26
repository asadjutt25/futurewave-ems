<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FutureWave') }} - {{ $title ?? 'Authentication' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Premium Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        @keyframes pulse-ring {
            0% { transform: scale(0.8); opacity: 0.8; }
            100% { transform: scale(1.2); opacity: 0; }
        }
        
        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            background-size: 200% 200%;
            animation: gradient-shift 10s ease infinite;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        
        /* Animated Background Elements */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="5" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="30" r="8" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="85" r="12" fill="rgba(255,255,255,0.1)"/></svg>');
            background-repeat: repeat;
            opacity: 0.3;
            pointer-events: none;
        }
        
        /* Floating Particles */
        .particle {
            position: absolute;
            background: rgba(255,255,255,0.3);
            border-radius: 50%;
            pointer-events: none;
            animation: float-particle linear infinite;
        }
        
        @keyframes float-particle {
            from {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            to {
                transform: translateY(-100vh) rotate(360deg);
                opacity: 1;
            }
        }
        
        /* Main Card */
        .auth-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border-radius: 32px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
            overflow: hidden;
            animation: fadeIn 0.6s ease;
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        /* Logo Section */
        .logo-section {
            background: linear-gradient(135deg, #4f46e5, #06b6d4);
            padding: 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .logo-section::before {
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
        
        .logo-icon {
            width: 80px;
            height: 80px;
            background: rgba(255,255,255,0.2);
            border-radius: 24px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            backdrop-filter: blur(10px);
            animation: float 4s ease-in-out infinite;
        }
        
        .logo-icon i {
            font-size: 3rem;
            color: white;
        }
        
        .logo-section h2 {
            color: white;
            font-weight: 800;
            margin-bottom: 0.5rem;
            letter-spacing: -0.5px;
        }
        
        .logo-section p {
            color: rgba(255,255,255,0.9);
            font-size: 0.9rem;
            margin-bottom: 0;
        }
        
        /* Form Section */
        .form-section {
            padding: 2rem;
        }
        
        .form-label {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }
        
        .input-group-custom {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .input-group-custom i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1rem;
            z-index: 1;
        }
        
        .input-group-custom input {
            width: 100%;
            padding: 0.85rem 1rem 0.85rem 2.8rem;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #f8fafc;
        }
        
        .input-group-custom input:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
            background: white;
        }
        
        .btn-auth {
            width: 100%;
            background: linear-gradient(135deg, #4f46e5, #06b6d4);
            border: none;
            padding: 0.85rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            color: white;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-auth::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }
        
        .btn-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(79,70,229,0.3);
        }
        
        .btn-auth:hover::before {
            left: 100%;
        }
        
        .auth-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
            color: #64748b;
        }
        
        .auth-link a {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        
        .auth-link a:hover {
            color: #06b6d4;
            text-decoration: underline;
        }
        
        /* Error Messages */
        .error-message {
            color: #ef4444;
            font-size: 0.8rem;
            margin-top: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        /* Remember Me Checkbox */
        .form-check {
            margin-bottom: 1rem;
        }
        
        .form-check-input {
            border-radius: 4px;
            border: 1px solid #cbd5e1;
            cursor: pointer;
        }
        
        .form-check-input:checked {
            background-color: #4f46e5;
            border-color: #4f46e5;
        }
        
        .form-check-label {
            font-size: 0.9rem;
            color: #475569;
            cursor: pointer;
        }
        
        /* Alert Messages */
        .alert-custom {
            border-radius: 16px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border: none;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .alert-custom i {
            font-size: 1.2rem;
        }
        
        .alert-custom.error {
            background: #fee2e2;
            color: #991b1b;
        }
        
        .alert-custom.success {
            background: #dcfce7;
            color: #166534;
        }
        
        /* Responsive */
        @media (max-width: 640px) {
            .auth-card {
                margin: 1rem;
                border-radius: 24px;
            }
            
            .logo-section {
                padding: 1.5rem;
            }
            
            .form-section {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Floating Particles -->
    <div id="particles"></div>

    <div class="min-vh-100 d-flex align-items-center justify-content-center p-3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6">
                    <div class="auth-card">
                        <!-- Logo Section -->
                        <div class="logo-section text-center">
                            <div class="logo-icon mx-auto">
                                <i class="fas fa-waveform"></i>
                            </div>
                            <h2>FutureWave</h2>
                            <p>Enterprise Management System</p>
                        </div>
                        
                        <!-- Form Section -->
                        <div class="form-section">
                            <!-- Alert Messages -->
                            @if(session('status'))
                                <div class="alert-custom success">
                                    <i class="fas fa-check-circle"></i>
                                    <span>{{ session('status') }}</span>
                                </div>
                            @endif
                            
                            @if($errors->any())
                                <div class="alert-custom error">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $errors->first() }}</span>
                                </div>
                            @endif
                            
                            {{ $slot }}
                        </div>
                    </div>
                    
                    <!-- Footer Text -->
                    <div class="text-center mt-4">
                        <p class="text-white-50 small">
                            &copy; {{ date('Y') }} FutureWave Software. All rights reserved.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Create floating particles
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            const particleCount = 30;
            
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                const size = Math.random() * 8 + 2;
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDuration = Math.random() * 10 + 5 + 's';
                particle.style.animationDelay = Math.random() * 5 + 's';
                particlesContainer.appendChild(particle);
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            createParticles();
            
            // Add animation to input fields
            const inputs = document.querySelectorAll('.input-group-custom input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                });
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });
        });
    </script>
    
    <style>
        #particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }
        
        .auth-card {
            position: relative;
            z-index: 1;
        }
    </style>
</body>
</html>