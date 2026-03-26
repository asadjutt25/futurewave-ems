<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Forgot Password - FutureWave EMS</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a0ca3;
            --primary-light: #4895ef;
            --secondary: #4cc9f0;
            --white: #ffffff;
            --gray-800: #1f2937;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Figtree', sans-serif;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* Fullscreen Background Image */
        .hero-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.65), rgba(0, 0, 0, 0.75)), 
                        url('https://images.unsplash.com/photo-1556761175-5973dc0f32e7?ixlib=rb-4.0.3&auto=format&fit=crop&w=1932&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            z-index: 0;
        }

        /* Animated Particles */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            pointer-events: none;
            animation: floatParticle 12s infinite linear;
        }

        @keyframes floatParticle {
            0% {
                transform: translateY(100vh) translateX(-30px) rotate(0deg);
                opacity: 0;
            }
            15% { opacity: 0.4; }
            85% { opacity: 0.4; }
            100% {
                transform: translateY(-100px) translateX(30px) rotate(360deg);
                opacity: 0;
            }
        }

        /* Container */
        .forgot-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            z-index: 2;
        }

        /* Glassmorphism Card */
        .forgot-card {
            background: rgba(255, 255, 255, 0.97);
            backdrop-filter: blur(12px);
            border-radius: 32px;
            padding: 2.8rem;
            width: 100%;
            max-width: 460px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
            border: 1px solid rgba(255, 255, 255, 0.4);
            transition: all 0.3s ease;
            animation: fadeInUp 0.6s ease;
        }

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

        .forgot-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.4);
        }

        /* Logo Section */
        .logo-section {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-icon {
            width: 75px;
            height: 75px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            animation: floatLogo 3s ease-in-out infinite;
            box-shadow: 0 10px 25px -5px rgba(67, 97, 238, 0.4);
        }

        @keyframes floatLogo {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
        }

        .logo-icon i {
            font-size: 2.3rem;
            color: white;
        }

        .logo-text {
            font-size: 1.8rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.5px;
        }

        .logo-sub {
            font-size: 0.75rem;
            color: #6b7280;
            margin-top: 0.25rem;
            letter-spacing: 0.5px;
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
            color: #6b7280;
            line-height: 1.5;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .input-group-custom {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            color: #9ca3af;
            font-size: 1rem;
            z-index: 1;
        }

        .form-control-custom {
            width: 100%;
            padding: 0.9rem 1rem 0.9rem 2.8rem;
            border: 2px solid #e5e7eb;
            border-radius: 16px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: var(--white);
        }

        .form-control-custom:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
        }

        /* Send Button */
        .btn-send {
            width: 100%;
            padding: 0.9rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            border-radius: 16px;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .btn-send::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s ease;
        }

        .btn-send:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(67, 97, 238, 0.4);
        }

        .btn-send:hover::before {
            left: 100%;
        }

        /* Back to Login Link */
        .back-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid #e5e7eb;
        }

        .back-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .back-link a:hover {
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

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border-left: 4px solid #22c55e;
        }

        .alert-info {
            background: #dbeafe;
            color: #1e40af;
            border-left: 4px solid #3b82f6;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .forgot-card {
                padding: 1.8rem;
                margin: 1rem;
            }
            
            .logo-text {
                font-size: 1.4rem;
            }
            
            .header-text h3 {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Fullscreen Background Image -->
    <div class="hero-bg"></div>

    <!-- Animated Particles -->
    <div class="particles" id="particles"></div>

    <div class="forgot-container">
        <div class="forgot-card">
            <!-- Logo Section -->
            <div class="logo-section">
                <div class="logo-icon">
                    <i class="fas fa-waveform"></i>
                </div>
                <div class="logo-text">FutureWave</div>
                <div class="logo-sub">Reset Password</div>
            </div>

            <!-- Header Text -->
            <div class="header-text">
                <h3>Forgot Password?</h3>
                <p>Enter your email address and we'll send you a link to reset your password.</p>
            </div>

            <!-- Error Messages -->
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

            <!-- Success Message - This will show when email is sent -->
            @if(session('status'))
                <div class="alert-custom alert-success">
                    <i class="fas fa-check-circle fa-lg"></i>
                    <div>
                        <strong>Success!</strong><br>
                        {{ session('status') }}
                    </div>
                </div>
            @endif

            <!-- Forgot Password Form -->
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Field -->
                <div class="form-group">
                    <div class="input-group-custom">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" name="email" class="form-control-custom" 
                               placeholder="Enter your registered email address" 
                               value="{{ old('email') }}" required autofocus>
                    </div>
                </div>

                <!-- Send Reset Link Button -->
                <button type="submit" class="btn-send">
                    <i class="fas fa-paper-plane me-2"></i> Send Reset Link
                </button>

                <!-- Back to Login Link -->
                <div class="back-link">
                    <a href="{{ route('login') }}">
                        <i class="fas fa-arrow-left"></i> Back to Login
                    </a>
                </div>
            </form>

            <!-- Info Box - What happens next -->
            <div class="alert-custom alert-info mt-3" style="margin-bottom: 0;">
                <i class="fas fa-info-circle fa-lg"></i>
                <div>
                    <small>If the email exists in our system, you will receive a password reset link shortly.</small>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Create Animated Particles
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            const particleCount = 40;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                
                const size = Math.random() * 6 + 2;
                const left = Math.random() * 100;
                const duration = Math.random() * 10 + 8;
                const delay = Math.random() * 10;
                
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';
                particle.style.left = left + '%';
                particle.style.animationDuration = duration + 's';
                particle.style.animationDelay = delay + 's';
                particle.style.opacity = Math.random() * 0.4 + 0.1;
                
                particlesContainer.appendChild(particle);
            }
        }

        createParticles();

        // Auto-hide alerts after 5 seconds
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