<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Register - FutureWave EMS</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --primary-light: #818cf8;
            --secondary: #ec4899;
            --secondary-light: #f472b6;
            --cyan: #06b6d4;
            --purple: #a855f7;
            --green: #10b981;
            --gray-50: #f9fafc;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Figtree', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow-x: hidden;
        }

        /* Animated Background */
        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
        }

        .bg-animation .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 20s infinite ease-in-out;
        }

        .bg-animation .circle:nth-child(1) {
            width: 300px;
            height: 300px;
            top: -100px;
            left: -100px;
            animation-duration: 25s;
        }

        .bg-animation .circle:nth-child(2) {
            width: 500px;
            height: 500px;
            bottom: -200px;
            right: -200px;
            animation-duration: 30s;
        }

        .bg-animation .circle:nth-child(3) {
            width: 200px;
            height: 200px;
            top: 50%;
            left: 20%;
            animation-duration: 18s;
        }

        .bg-animation .circle:nth-child(4) {
            width: 400px;
            height: 400px;
            bottom: 10%;
            left: 30%;
            animation-duration: 22s;
        }

        .bg-animation .circle:nth-child(5) {
            width: 150px;
            height: 150px;
            top: 20%;
            right: 15%;
            animation-duration: 15s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-50px) rotate(10deg);
            }
        }

        /* Container */
        .register-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            position: relative;
            z-index: 1;
        }

        /* Glassmorphism Card */
        .register-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 32px;
            padding: 2.5rem;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .register-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.3);
        }

        /* Logo Section */
        .logo-section {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary), var(--secondary), var(--cyan));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            animation: floatLogo 3s ease-in-out infinite;
            box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.4);
        }

        @keyframes floatLogo {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
        }

        .logo-icon i {
            font-size: 2.2rem;
            color: white;
        }

        .logo-text {
            font-size: 1.8rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--secondary), var(--cyan));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.5px;
        }

        .logo-sub {
            font-size: 0.8rem;
            color: var(--gray-500);
            margin-top: 0.25rem;
        }

        /* Header Text */
        .header-text {
            text-align: center;
            margin-bottom: 2rem;
        }

        .header-text h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 0.5rem;
        }

        .header-text p {
            font-size: 0.85rem;
            color: var(--gray-500);
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 1.2rem;
        }

        .input-group-custom {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            color: var(--gray-400);
            font-size: 1rem;
            z-index: 1;
        }

        .form-control-custom {
            width: 100%;
            padding: 0.85rem 1rem 0.85rem 2.8rem;
            border: 2px solid var(--gray-200);
            border-radius: 16px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: var(--white);
        }

        .form-control-custom:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        /* Password Toggle */
        .password-toggle {
            position: absolute;
            right: 1rem;
            color: var(--gray-400);
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .password-toggle:hover {
            color: var(--primary);
        }

        /* Register Button */
        .btn-register {
            width: 100%;
            padding: 0.9rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary), var(--cyan));
            border: none;
            border-radius: 16px;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            margin-top: 0.5rem;
        }

        .btn-register::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s ease;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.4);
        }

        .btn-register:hover::before {
            left: 100%;
        }

        /* Login Link */
        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid var(--gray-200);
        }

        .login-link p {
            font-size: 0.85rem;
            color: var(--gray-600);
        }

        .login-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .login-link a:hover {
            color: var(--secondary);
        }

        /* Alert Messages */
        .alert-custom {
            border-radius: 16px;
            padding: 0.85rem 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .register-card {
                padding: 1.8rem;
            }
            
            .logo-text {
                font-size: 1.4rem;
            }
            
            .header-text h3 {
                font-size: 1.2rem;
            }
            
            .form-control-custom {
                padding: 0.75rem 1rem 0.75rem 2.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="bg-animation">
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
    </div>

    <div class="register-container">
        <div class="register-card">
            <div class="logo-section">
                <div class="logo-icon">
                    <i class="fas fa-waveform"></i>
                </div>
                <div class="logo-text">FutureWave</div>
                <div class="logo-sub">Create Account</div>
            </div>

            <div class="header-text">
                <h3>Get Started</h3>
                <p>Create your account to access the system</p>
            </div>

            @if($errors->any())
                <div class="alert-custom alert-error">
                    <i class="fas fa-exclamation-circle fa-lg"></i>
                    <div>
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <div class="input-group-custom">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" name="name" class="form-control-custom" 
                               placeholder="Full Name" value="{{ old('name') }}" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group-custom">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" name="email" class="form-control-custom" 
                               placeholder="Email Address" value="{{ old('email') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group-custom">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password" id="password" class="form-control-custom" 
                               placeholder="Password" required>
                        <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group-custom">
                        <i class="fas fa-check-circle input-icon"></i>
                        <input type="password" name="password_confirmation" id="passwordConfirm" class="form-control-custom" 
                               placeholder="Confirm Password" required>
                        <i class="fas fa-eye password-toggle" id="togglePasswordConfirm"></i>
                    </div>
                </div>

                <button type="submit" class="btn-register">
                    <i class="fas fa-user-plus me-2"></i> Register
                </button>

                <div class="login-link">
                    <p>Already have an account? <a href="{{ route('login') }}">Sign In</a></p>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Password Toggle for Password Field
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        // Password Toggle for Confirm Password Field
        const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
        const passwordConfirm = document.getElementById('passwordConfirm');

        togglePasswordConfirm.addEventListener('click', function() {
            const type = passwordConfirm.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirm.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        setTimeout(function() {
            document.querySelectorAll('.alert-custom').forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
</body>
</html>