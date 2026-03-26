<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FutureWave') }} - Enterprise Management System</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* ========================================
           ULTRA PREMIUM LANDING PAGE DESIGN
        ======================================== */
        
        :root {
            --primary: #4361ee;
            --primary-dark: #3a0ca3;
            --primary-light: #4895ef;
            --secondary: #4cc9f0;
            --accent: #ec4899;
            --dark: #0f172a;
            --light: #f8fafc;
            --white: #ffffff;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes float-slow {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }
            100% {
                background-position: 200% 0;
            }
        }

        @keyframes gradient-flow {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes pulse-ring {
            0% {
                transform: scale(0.8);
                opacity: 0.8;
            }
            100% {
                transform: scale(1.2);
                opacity: 0;
            }
        }

        @keyframes rotate-slow {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        /* Body */
        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated Background Gradient */
        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, #4f46e5, #06b6d4, #ec4899, #4f46e5);
            background-size: 300% 300%;
            animation: gradient-flow 15s ease infinite;
            opacity: 0.15;
            z-index: 0;
        }

        /* Floating Orbs */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
            z-index: 0;
        }

        .orb-1 {
            width: 500px;
            height: 500px;
            background: #4f46e5;
            top: -200px;
            left: -200px;
            animation: float-slow 8s ease-in-out infinite;
        }

        .orb-2 {
            width: 400px;
            height: 400px;
            background: #06b6d4;
            bottom: -150px;
            right: -150px;
            animation: float 6s ease-in-out infinite;
        }

        .orb-3 {
            width: 300px;
            height: 300px;
            background: #ec4899;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation: rotate-slow 20s linear infinite;
        }

        /* Particles */
        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.2);
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
                opacity: 0.5;
            }
        }

        /* Navigation */
        .nav-premium {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            padding: 1rem 2rem;
            z-index: 1000;
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .nav-link-premium {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            padding: 0.6rem 1.5rem;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-left: 0.5rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-link-premium:hover {
            color: white;
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        /* Hero Card */
        .hero-card-premium {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(20px);
            border-radius: 48px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
            animation: fadeInUp 0.8s ease;
            position: relative;
            z-index: 2;
        }

        /* Logo Section */
        .logo-section-premium {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.2), rgba(6, 182, 212, 0.2));
            padding: 2.5rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .logo-section-premium::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.05), transparent);
            transform: rotate(45deg);
            animation: shimmer 3s infinite;
        }

        .logo-icon-premium {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #4f46e5, #06b6d4);
            border-radius: 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            box-shadow: 0 10px 30px rgba(79, 70, 229, 0.3);
            animation: float 4s ease-in-out infinite;
        }

        .logo-icon-premium i {
            font-size: 3.5rem;
            color: white;
        }

        .logo-section-premium h1 {
            background: linear-gradient(135deg, #fff, #a5f3fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
            letter-spacing: -0.5px;
        }

        .logo-section-premium p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1rem;
        }

        /* Content Section */
        .content-section-premium {
            padding: 3rem;
        }

        .content-section-premium h2 {
            font-size: 2.2rem;
            font-weight: 700;
            background: linear-gradient(135deg, #fff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1rem;
        }

        .content-section-premium p {
            color: #94a3b8;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        /* Feature Cards */
        .feature-grid-premium {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }

        .feature-card-premium {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 24px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .feature-card-premium:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(79, 70, 229, 0.3);
        }

        .feature-icon-premium {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.2), rgba(6, 182, 212, 0.2));
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .feature-icon-premium i {
            font-size: 2rem;
            background: linear-gradient(135deg, #4f46e5, #06b6d4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .feature-card-premium h4 {
            font-size: 1.1rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.5rem;
        }

        .feature-card-premium p {
            font-size: 0.85rem;
            color: #94a3b8;
            margin-bottom: 0;
        }

        /* CTA Buttons */
        .btn-primary-premium {
            background: linear-gradient(135deg, #4f46e5, #06b6d4);
            border: none;
            padding: 0.9rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .btn-primary-premium::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .btn-primary-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.4);
            color: white;
        }

        .btn-primary-premium:hover::before {
            left: 100%;
        }

        .btn-outline-premium {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 0.9rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-outline-premium:hover {
            border-color: #4f46e5;
            background: rgba(79, 70, 229, 0.1);
            transform: translateY(-2px);
            color: white;
        }

        /* Footer */
        .footer-premium {
            margin-top: 2rem;
            text-align: center;
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.875rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-premium {
                padding: 1rem;
            }
            
            .nav-link-premium {
                padding: 0.4rem 1rem;
                font-size: 0.875rem;
            }
            
            .hero-card-premium {
                margin: 1rem;
                border-radius: 32px;
            }
            
            .logo-section-premium {
                padding: 1.5rem;
            }
            
            .logo-icon-premium {
                width: 70px;
                height: 70px;
            }
            
            .logo-icon-premium i {
                font-size: 2.5rem;
            }
            
            .content-section-premium {
                padding: 1.5rem;
            }
            
            .content-section-premium h2 {
                font-size: 1.5rem;
            }
            
            .feature-grid-premium {
                grid-template-columns: 1fr;
            }
            
            .btn-primary-premium, .btn-outline-premium {
                width: 100%;
                justify-content: center;
            }
        }

        @media (min-width: 768px) {
            .btn-group-premium {
                display: flex;
                gap: 1rem;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="animated-bg"></div>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
    <div id="particles"></div>

    <!-- Premium Navigation -->
    @if (Route::has('login'))
        <nav class="nav-premium">
            <div class="container">
                <div class="d-flex justify-content-end">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="nav-link-premium">
                            <i class="fas fa-chart-line"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="nav-link-premium">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="nav-link-premium">
                                <i class="fas fa-user-plus"></i> Register
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </nav>
    @endif

    <div class="min-vh-100 d-flex align-items-center justify-content-center p-3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="hero-card-premium">
                        <!-- Logo Section -->
                        <div class="logo-section-premium text-center">
                            <div class="logo-icon-premium mx-auto">
                                <i class="fas fa-waveform"></i>
                            </div>
                            <h1>FutureWave</h1>
                            <p>Enterprise Management System</p>
                        </div>
                        
                        <!-- Content Section -->
                        <div class="content-section-premium text-center">
                            <h2>Streamline Your Business Operations</h2>
                            <p>
                                FutureWave is a powerful, all-in-one enterprise management solution designed to help you manage employees, attendance, leaves, salaries, and generate insightful reports — all from one intuitive dashboard.
                            </p>
                            
                            <!-- Feature Cards -->
                            <div class="feature-grid-premium">
                                <div class="feature-card-premium">
                                    <div class="feature-icon-premium mx-auto">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <h4>Employee Management</h4>
                                    <p>Manage all employee records with ease</p>
                                </div>
                                <div class="feature-card-premium">
                                    <div class="feature-icon-premium mx-auto">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                    <h4>Attendance Tracking</h4>
                                    <p>Monitor daily attendance and leaves</p>
                                </div>
                                <div class="feature-card-premium">
                                    <div class="feature-icon-premium mx-auto">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                    <h4>Advanced Reports</h4>
                                    <p>Generate detailed insights and analytics</p>
                                </div>
                                <div class="feature-card-premium">
                                    <div class="feature-icon-premium mx-auto">
                                        <i class="fas fa-wallet"></i>
                                    </div>
                                    <h4>Salary Management</h4>
                                    <p>Process and track salary records</p>
                                </div>
                            </div>
                            
                            <!-- CTA Buttons -->
                            @auth
                                <div class="btn-group-premium">
                                    <a href="{{ route('dashboard') }}" class="btn-primary-premium">
                                        <i class="fas fa-chart-line"></i> Go to Dashboard
                                    </a>
                                </div>
                            @else
                                <div class="btn-group-premium">
                                    <a href="{{ route('login') }}" class="btn-primary-premium">
                                        <i class="fas fa-sign-in-alt"></i> Login to Your Account
                                    </a>
                                    <a href="{{ route('register') }}" class="btn-outline-premium">
                                        <i class="fas fa-user-plus"></i> Create New Account
                                    </a>
                                </div>
                            @endauth
                        </div>
                    </div>
                    
                    <!-- Footer -->
                    <div class="footer-premium">
                        <p>© {{ date('Y') }} FutureWave Technologies. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Create floating particles
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            const particleCount = 60;
            
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                const size = Math.random() * 6 + 2;
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDuration = Math.random() * 12 + 6 + 's';
                particle.style.animationDelay = Math.random() * 8 + 's';
                particle.style.opacity = Math.random() * 0.5 + 0.2;
                particlesContainer.appendChild(particle);
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            createParticles();
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
            z-index: 1;
            overflow: hidden;
        }
        
        .hero-card-premium {
            position: relative;
            z-index: 2;
        }
        
        .btn-group-premium {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: center;
        }
    </style>
</body>
</html>