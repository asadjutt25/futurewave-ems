<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'FutureWave - Employee Management')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* ========== PREMIUM NAVBAR STYLES ========== */
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --secondary: #06b6d4;
            --dark: #0f172a;
            --light: #f8fafc;
            --gray: #64748b;
        }
        
        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
        }
        
        /* Premium Navbar */
        .navbar-premium {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            padding: 0.75rem 1rem;
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(79, 70, 229, 0.1);
        }
        
        /* Logo */
        .navbar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .navbar-logo:hover {
            transform: translateY(-1px);
        }
        
        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.2);
        }
        
        .logo-icon i {
            font-size: 1.2rem;
            color: white;
        }
        
        .logo-text {
            font-size: 1.35rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.5px;
        }
        
        .logo-text span {
            background: none;
            -webkit-text-fill-color: var(--dark);
            font-weight: 600;
        }
        
        /* Navigation Links */
        .nav-links {
            display: flex;
            gap: 0.5rem;
            margin-left: 2rem;
        }
        
        .nav-link-custom {
            color: var(--gray) !important;
            font-weight: 500;
            padding: 0.6rem 1rem !important;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .nav-link-custom i {
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .nav-link-custom:hover {
            color: var(--primary) !important;
            background: rgba(79, 70, 229, 0.08);
            transform: translateY(-2px);
        }
        
        .nav-link-custom.active {
            color: var(--primary) !important;
            background: rgba(79, 70, 229, 0.12);
            font-weight: 600;
            position: relative;
        }
        
        .nav-link-custom.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            transform: translateX(-50%);
            width: 30px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            border-radius: 3px;
        }
        
        /* User Dropdown */
        .user-dropdown {
            position: relative;
        }
        
        .user-dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.5rem 1rem;
            background: transparent;
            border: none;
            border-radius: 50px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .user-dropdown-toggle:hover {
            background: rgba(79, 70, 229, 0.05);
        }
        
        .user-avatar {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .user-name {
            font-weight: 500;
            color: var(--dark);
            font-size: 0.9rem;
        }
        
        .dropdown-menu-custom {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 0.5rem;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            min-width: 220px;
            overflow: hidden;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1000;
        }
        
        .user-dropdown:hover .dropdown-menu-custom {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .dropdown-item-custom {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.75rem 1.25rem;
            color: var(--gray);
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 0.875rem;
        }
        
        .dropdown-item-custom:hover {
            background: rgba(79, 70, 229, 0.05);
            color: var(--primary);
            transform: translateX(5px);
        }
        
        .dropdown-divider {
            height: 1px;
            background: #e2e8f0;
            margin: 0.5rem 0;
        }
        
        /* Mobile Menu Button */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--dark);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        
        .mobile-menu-btn:hover {
            background: rgba(79, 70, 229, 0.05);
        }
        
        /* Mobile Menu */
        .mobile-menu {
            display: none;
            background: white;
            border-radius: 20px;
            margin-top: 1rem;
            padding: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .mobile-menu.show {
            display: block;
            animation: fadeInUp 0.3s ease;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .mobile-nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.75rem 1rem;
            color: var(--gray);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
        }
        
        .mobile-nav-link:hover {
            background: rgba(79, 70, 229, 0.05);
            color: var(--primary);
            transform: translateX(5px);
        }
        
        .mobile-nav-link.active {
            background: rgba(79, 70, 229, 0.1);
            color: var(--primary);
            font-weight: 600;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .nav-links {
                display: none;
            }
            
            .mobile-menu-btn {
                display: block;
            }
            
            .user-name {
                display: none;
            }
        }
        
        /* Main Content */
        .main-content {
            min-height: calc(100vh - 140px);
            padding: 20px 0;
        }
        
        /* Footer */
        .footer {
            background: white;
            border-top: 1px solid #e2e8f0;
            padding: 20px 0;
            margin-top: 40px;
            font-size: 0.875rem;
            color: #64748b;
        }
        
        /* Alert Messages */
        .alert {
            border-radius: 16px;
            padding: 12px 20px;
            margin-bottom: 20px;
            border: none;
        }
        
        .alert-success {
            background: #dcfce7;
            color: #166534;
        }
        
        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>
<body>
    <!-- Premium Navbar -->
    <nav class="navbar-premium">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="navbar-logo">
                    <div class="logo-icon">
                        <i class="fas fa-waveform"></i>
                    </div>
                    <span class="logo-text">Future<span>Wave</span></span>
                </a>

                <!-- Desktop Navigation Links -->
                <div class="nav-links">
                    @auth
                        <a href="{{ route('dashboard') }}" class="nav-link-custom {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="fas fa-chart-line"></i> Dashboard
                        </a>
                        <a href="{{ route('employees.index') }}" class="nav-link-custom {{ request()->routeIs('employees.*') ? 'active' : '' }}">
                            <i class="fas fa-users"></i> Employees
                        </a>
                        <a href="{{ route('departments.index') }}" class="nav-link-custom {{ request()->routeIs('departments.*') ? 'active' : '' }}">
                            <i class="fas fa-building"></i> Departments
                        </a>
                        <a href="{{ route('attendance.index') }}" class="nav-link-custom {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
                            <i class="fas fa-calendar-check"></i> Attendance
                        </a>
                        <a href="{{ route('leave.index') }}" class="nav-link-custom {{ request()->routeIs('leave.*') ? 'active' : '' }}">
                            <i class="fas fa-clock"></i> Leave
                        </a>
                        <a href="{{ route('salary.index') }}" class="nav-link-custom {{ request()->routeIs('salary.*') ? 'active' : '' }}">
                            <i class="fas fa-wallet"></i> Salary
                        </a>
                        <a href="{{ route('leave.balance') }}" class="nav-link-custom {{ request()->routeIs('leave.balance') ? 'active' : '' }}">
                            <i class="fas fa-chart-pie"></i> Balance
                        </a>
                        <a href="{{ route('reports.index') }}" class="nav-link-custom {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                            <i class="fas fa-chart-simple"></i> Reports
                        </a>
                    @endauth
                </div>

                <!-- User Dropdown -->
                @auth
                <div class="user-dropdown">
                    <button class="user-dropdown-toggle" onclick="toggleDropdown()">
                        <div class="user-avatar">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <span class="user-name">{{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down" style="font-size: 0.8rem; color: var(--gray);"></i>
                    </button>
                    <div class="dropdown-menu-custom" id="dropdownMenu">
                        <a href="{{ route('profile.show') }}" class="dropdown-item-custom">
                            <i class="fas fa-user"></i> My Profile
                        </a>
                        <a href="{{ route('profile.edit') }}" class="dropdown-item-custom">
                            <i class="fas fa-edit"></i> Edit Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}" id="logout-form">
                            @csrf
                            <button type="submit" class="dropdown-item-custom" style="width: 100%; background: none; border: none; cursor: pointer;">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <div class="d-flex gap-2">
                    <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-pill px-4">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary rounded-pill px-4">Register</a>
                </div>
                @endauth

                <!-- Mobile Menu Button -->
                <button class="mobile-menu-btn" id="mobileMenuBtn">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div class="mobile-menu" id="mobileMenu">
                @auth
                    <a href="{{ route('dashboard') }}" class="mobile-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i> Dashboard
                    </a>
                    <a href="{{ route('employees.index') }}" class="mobile-nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i> Employees
                    </a>
                    <a href="{{ route('departments.index') }}" class="mobile-nav-link {{ request()->routeIs('departments.*') ? 'active' : '' }}">
                        <i class="fas fa-building"></i> Departments
                    </a>
                    <a href="{{ route('attendance.index') }}" class="mobile-nav-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-check"></i> Attendance
                    </a>
                    <a href="{{ route('leave.index') }}" class="mobile-nav-link {{ request()->routeIs('leave.*') ? 'active' : '' }}">
                        <i class="fas fa-clock"></i> Leave
                    </a>
                    <a href="{{ route('salary.index') }}" class="mobile-nav-link {{ request()->routeIs('salary.*') ? 'active' : '' }}">
                        <i class="fas fa-wallet"></i> Salary
                    </a>
                    <a href="{{ route('leave.balance') }}" class="mobile-nav-link {{ request()->routeIs('leave.balance') ? 'active' : '' }}">
                        <i class="fas fa-chart-pie"></i> Balance
                    </a>
                    <a href="{{ route('reports.index') }}" class="mobile-nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-simple"></i> Reports
                    </a>
                    <div class="dropdown-divider my-2"></div>
                    <a href="{{ route('profile.show') }}" class="mobile-nav-link">
                        <i class="fas fa-user"></i> Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="mobile-nav-link" style="width: 100%; background: none; border: none; text-align: left;">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Page Heading -->
    @if (isset($header))
        <header class="bg-white shadow-sm border-bottom">
            <div class="container py-3">
                {{ $header }}
            </div>
        </header>
    @endif

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Page Content -->
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container text-center">
            <p class="mb-0">© {{ date('Y') }} FutureWave Software. All rights reserved.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        
        mobileMenuBtn.addEventListener('click', function() {
            mobileMenu.classList.toggle('show');
            const icon = this.querySelector('i');
            if (mobileMenu.classList.contains('show')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });
        
        // User Dropdown Toggle
        let dropdownOpen = false;
        
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdownMenu');
            dropdownOpen = !dropdownOpen;
            if (dropdownOpen) {
                dropdown.style.opacity = '1';
                dropdown.style.visibility = 'visible';
                dropdown.style.transform = 'translateY(0)';
            } else {
                dropdown.style.opacity = '0';
                dropdown.style.visibility = 'hidden';
                dropdown.style.transform = 'translateY(-10px)';
            }
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('dropdownMenu');
            const toggle = document.querySelector('.user-dropdown-toggle');
            if (!toggle?.contains(event.target) && !dropdown?.contains(event.target)) {
                dropdownOpen = false;
                if (dropdown) {
                    dropdown.style.opacity = '0';
                    dropdown.style.visibility = 'hidden';
                    dropdown.style.transform = 'translateY(-10px)';
                }
            }
        });
        
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                document.querySelectorAll('.alert').forEach(function(alert) {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.remove();
                    }, 500);
                });
            }, 5000);
        });
    </script>
</body>
</html>