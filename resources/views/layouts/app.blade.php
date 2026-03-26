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

    <!-- Custom Styles -->
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --primary-light: #818cf8;
            --secondary: #ec4899;
            --secondary-light: #f472b6;
            --cyan: #06b6d4;
            --purple: #a855f7;
            --orange: #f97316;
            --green: #10b981;
            --yellow: #eab308;
            --gray-50: #f9fafc;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --white: #ffffff;
        }
        
        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #eef2f6 100%);
            min-height: 100vh;
        }
        
        /* ========================================
           GLASSMORPHISM NAVBAR WITH 3D ANIMATION
        ======================================== */
        .navbar-glass {
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            padding: 0.75rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(255, 255, 255, 0.5);
        }
        
        /* ========================================
           COLORFUL 3D LOGO
        ======================================== */
        .logo-3d-colorful {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }
        
        .logo-3d-colorful:hover {
            transform: scale(1.02) translateY(-2px);
        }
        
        .logo-icon-3d {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, var(--primary), var(--secondary), var(--cyan), var(--purple));
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            animation: floatLogo 3s ease-in-out infinite;
            box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.4);
            transition: all 0.3s ease;
        }
        
        .logo-icon-3d::before {
            content: '';
            position: absolute;
            inset: -2px;
            background: linear-gradient(135deg, var(--primary), var(--secondary), var(--cyan), var(--purple));
            border-radius: 16px;
            filter: blur(10px);
            opacity: 0.5;
            z-index: -1;
            animation: pulseGlow 2s ease-in-out infinite;
        }
        
        @keyframes floatLogo {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-3px) rotate(2deg); }
        }
        
        @keyframes pulseGlow {
            0%, 100% { opacity: 0.4; }
            50% { opacity: 0.8; }
        }
        
        .logo-icon-3d i {
            font-size: 1.4rem;
            color: white;
            animation: rotateIcon 4s linear infinite;
        }
        
        @keyframes rotateIcon {
            0% { transform: rotate(0deg); }
            25% { transform: rotate(5deg); }
            75% { transform: rotate(-5deg); }
            100% { transform: rotate(0deg); }
        }
        
        .logo-text-3d {
            display: flex;
            flex-direction: column;
        }
        
        .logo-main-3d {
            font-size: 1.4rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--secondary), var(--cyan), var(--purple));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.5px;
            background-size: 200% auto;
            animation: gradientFlow 3s ease infinite;
        }
        
        @keyframes gradientFlow {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .logo-sub-3d {
            font-size: 0.6rem;
            color: var(--gray-500);
            letter-spacing: 0.5px;
        }
        
        /* ========================================
           3D ANIMATED NAVIGATION LINKS
        ======================================== */
        .nav-links-3d {
            display: flex;
            gap: 0.5rem;
            margin-left: 2rem;
        }
        
        .nav-link-3d {
            padding: 0.55rem 1.1rem;
            color: var(--gray-600);
            font-weight: 500;
            text-decoration: none;
            border-radius: 40px;
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            position: relative;
            background: transparent;
            overflow: hidden;
        }
        
        .nav-link-3d::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(99, 102, 241, 0.15), transparent);
            transition: left 0.5s ease;
        }
        
        .nav-link-3d:hover::before {
            left: 100%;
        }
        
        .nav-link-3d i {
            font-size: 0.95rem;
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }
        
        .nav-link-3d:hover {
            color: white;
            background: linear-gradient(135deg, var(--primary), var(--secondary), var(--cyan));
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 10px 20px -5px rgba(99, 102, 241, 0.4);
        }
        
        .nav-link-3d:hover i {
            transform: translateX(3px) rotate(5deg);
            color: white;
        }
        
        .nav-link-3d.active {
            color: white;
            background: linear-gradient(135deg, var(--primary), var(--secondary), var(--cyan));
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
            animation: activePulse 2s ease-in-out infinite;
        }
        
        @keyframes activePulse {
            0%, 100% { box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3); }
            50% { box-shadow: 0 8px 20px rgba(99, 102, 241, 0.5); }
        }
        
        /* Dropdown Menu */
        .dropdown-menu-custom {
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 16px;
            padding: 0.5rem;
            margin-top: 8px;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.98);
            min-width: 200px;
        }
        
        .dropdown-item-custom {
            padding: 0.6rem 1.2rem;
            font-size: 0.875rem;
            border-radius: 10px;
            transition: all 0.2s ease;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }
        
        .dropdown-item-custom:hover {
            background: linear-gradient(135deg, rgba(79,70,229,0.1), rgba(6,182,212,0.1));
            transform: translateX(5px);
            color: var(--primary);
        }
        
        /* ========================================
           USER DROPDOWN WITH 3D EFFECT
        ======================================== */
        .user-section {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .user-dropdown {
            position: relative;
        }
        
        .user-trigger {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 5px 12px 5px 8px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50px;
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            cursor: pointer;
            border: 1px solid rgba(99, 102, 241, 0.2);
        }
        
        .user-trigger:hover {
            background: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.15);
            border-color: var(--primary);
        }
        
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary), var(--cyan));
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            animation: avatarPulse 3s ease-in-out infinite;
        }
        
        @keyframes avatarPulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(99, 102, 241, 0.4); }
            50% { box-shadow: 0 0 0 5px rgba(99, 102, 241, 0.2); }
        }
        
        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .user-avatar span {
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .user-name {
            font-weight: 500;
            font-size: 0.85rem;
            color: var(--gray-700);
        }
        
        .dropdown-arrow {
            font-size: 0.7rem;
            color: var(--gray-500);
            transition: transform 0.3s ease;
        }
        
        .user-dropdown.active .dropdown-arrow {
            transform: rotate(180deg);
        }
        
        /* Dropdown Menu */
        .dropdown-menu-glass {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 10px;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.1);
            min-width: 260px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px) scale(0.95);
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            border: 1px solid rgba(99, 102, 241, 0.1);
            z-index: 1000;
        }
        
        .user-dropdown.active .dropdown-menu-glass {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
        }
        
        .dropdown-header {
            padding: 1rem;
            border-bottom: 1px solid var(--gray-100);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .dropdown-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        
        .dropdown-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .dropdown-avatar span {
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
        }
        
        .dropdown-user-info {
            flex: 1;
        }
        
        .dropdown-user-name {
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 2px;
            font-size: 0.9rem;
        }
        
        .dropdown-user-email {
            font-size: 0.7rem;
            color: var(--gray-500);
        }
        
        .dropdown-role-badge {
            display: inline-block;
            margin-top: 4px;
            padding: 2px 8px;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(236, 72, 153, 0.1));
            border-radius: 20px;
            font-size: 0.6rem;
            font-weight: 500;
            color: var(--primary);
        }
        
        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.7rem 1rem;
            color: var(--gray-700);
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 0.85rem;
        }
        
        .dropdown-item:hover {
            background: linear-gradient(90deg, rgba(99, 102, 241, 0.08), transparent);
            padding-left: 1.3rem;
            color: var(--primary);
        }
        
        .dropdown-item i {
            width: 20px;
            font-size: 0.9rem;
            color: var(--gray-500);
        }
        
        .dropdown-item:hover i {
            color: var(--primary);
        }
        
        .dropdown-divider {
            height: 1px;
            background: var(--gray-100);
            margin: 0.3rem 0;
        }
        
        /* Mobile Menu */
        .mobile-menu-btn {
            display: none;
            background: rgba(99, 102, 241, 0.1);
            border: 1px solid rgba(99, 102, 241, 0.2);
            width: 42px;
            height: 42px;
            border-radius: 12px;
            color: var(--primary);
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }
        
        .mobile-menu-btn:hover {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            transform: scale(1.05);
        }
        
        .mobile-menu {
            display: none;
            position: fixed;
            top: 72px;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(12px);
            padding: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            z-index: 999;
            border-bottom: 1px solid rgba(99, 102, 241, 0.1);
        }
        
        .mobile-menu.active {
            display: block;
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
        
        .mobile-nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.8rem 1rem;
            color: var(--gray-600);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.2s ease;
            font-weight: 500;
        }
        
        .mobile-nav-link:hover,
        .mobile-nav-link.active {
            background: linear-gradient(90deg, rgba(99, 102, 241, 0.1), transparent);
            color: var(--primary);
        }
        
        /* Responsive */
        @media (max-width: 991px) {
            .nav-links-3d {
                display: none;
            }
            
            .mobile-menu-btn {
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            .user-name {
                display: none;
            }
            
            .user-trigger {
                padding: 5px 8px;
            }
        }
        
        @media (max-width: 576px) {
            .logo-sub-3d {
                display: none;
            }
            .logo-main-3d {
                font-size: 1rem;
            }
            .logo-icon-3d {
                width: 36px;
                height: 36px;
            }
        }
        
        /* ========================================
           EXISTING STYLES
        ======================================== */
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            border-left: 4px solid;
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .stat-card.blue { border-left-color: #6366f1; }
        .stat-card.green { border-left-color: #22c55e; }
        .stat-card.purple { border-left-color: #a855f7; }
        .stat-card.yellow { border-left-color: #eab308; }
        
        .stat-label {
            font-size: 0.875rem;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .stat-value {
            font-size: 1.875rem;
            font-weight: 700;
            color: #0f172a;
            margin-top: 5px;
        }
        
        .table-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table th {
            background: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
            color: #475569;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .table td {
            vertical-align: middle;
            color: #334155;
        }
        
        .table tbody tr:hover {
            background-color: #f1f5f9;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            padding: 8px 20px;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }
        
        .footer {
            background: white;
            border-top: 1px solid #e2e8f0;
            padding: 20px 0;
            margin-top: 40px;
            font-size: 0.875rem;
            color: #64748b;
        }
        
        .alert {
            border-radius: 12px;
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
        
        .main-content {
            min-height: calc(100vh - 140px);
            padding: 20px 0;
        }
    </style>
</head>
<body>
    <!-- Glassmorphism Navbar with 3D Animation -->
    <nav class="navbar-glass">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between w-100">
                <!-- Colorful 3D Logo -->
                <a class="logo-3d-colorful" href="{{ route('dashboard') }}">
                    <div class="logo-icon-3d">
                        <i class="fas fa-waveform"></i>
                    </div>
                    <div class="logo-text-3d">
                        <span class="logo-main-3d">FutureWave</span>
                        <span class="logo-sub-3d">Enterprise Solutions</span>
                    </div>
                </a>

                <!-- 3D Animated Navigation Links -->
                <div class="nav-links-3d">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <a class="nav-link-3d {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <i class="fas fa-chart-line"></i> Dashboard
                            </a>
                            <a class="nav-link-3d {{ request()->routeIs('employees.*') ? 'active' : '' }}" href="{{ route('employees.index') }}">
                                <i class="fas fa-users"></i> Employees
                            </a>
                            <a class="nav-link-3d {{ request()->routeIs('departments.*') ? 'active' : '' }}" href="{{ route('departments.index') }}">
                                <i class="fas fa-building"></i> Departments
                            </a>
                            <!-- Leave Dropdown with Holidays -->
                            <div class="dropdown">
                                <a class="nav-link-3d dropdown-toggle {{ request()->routeIs('leave.*') || request()->routeIs('holidays.*') ? 'active' : '' }}" 
                                   href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-clock"></i> Leave
                                </a>
                                <ul class="dropdown-menu dropdown-menu-custom">
                                    <li>
                                        <a class="dropdown-item-custom {{ request()->routeIs('leave.index') ? 'active' : '' }}" 
                                           href="{{ route('leave.index') }}">
                                            <i class="fas fa-list"></i> Leave Requests
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item-custom {{ request()->routeIs('leave.create') ? 'active' : '' }}" 
                                           href="{{ route('leave.create') }}">
                                            <i class="fas fa-plus-circle"></i> Apply for Leave
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item-custom {{ request()->routeIs('leave.balance') ? 'active' : '' }}" 
                                           href="{{ route('leave.balance') }}">
                                            <i class="fas fa-chart-pie"></i> Leave Balance
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item-custom {{ request()->routeIs('holidays.*') ? 'active' : '' }}" 
                                           href="{{ route('holidays.index') }}">
                                            <i class="fas fa-calendar-alt"></i> Holidays
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <a class="nav-link-3d {{ request()->routeIs('attendance.*') ? 'active' : '' }}" href="{{ route('attendance.index') }}">
                                <i class="fas fa-calendar-check"></i> Attendance
                            </a>
                            <a class="nav-link-3d {{ request()->routeIs('salary.*') ? 'active' : '' }}" href="{{ route('salary.index') }}">
                                <i class="fas fa-wallet"></i> Salary
                            </a>
                            <a class="nav-link-3d {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                                <i class="fas fa-chart-simple"></i> Reports
                            </a>
                        @else
                            <a class="nav-link-3d {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <i class="fas fa-chart-line"></i> Dashboard
                            </a>
                            <!-- Employee Leave Dropdown -->
                            <div class="dropdown">
                                <a class="nav-link-3d dropdown-toggle {{ request()->routeIs('leave.*') || request()->routeIs('holidays.*') ? 'active' : '' }}" 
                                   href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-clock"></i> Leave
                                </a>
                                <ul class="dropdown-menu dropdown-menu-custom">
                                    <li>
                                        <a class="dropdown-item-custom {{ request()->routeIs('leave.index') ? 'active' : '' }}" 
                                           href="{{ route('leave.index') }}">
                                            <i class="fas fa-list"></i> My Leaves
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item-custom {{ request()->routeIs('leave.create') ? 'active' : '' }}" 
                                           href="{{ route('leave.create') }}">
                                            <i class="fas fa-plus-circle"></i> Apply for Leave
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item-custom {{ request()->routeIs('leave.balance') ? 'active' : '' }}" 
                                           href="{{ route('leave.balance') }}">
                                            <i class="fas fa-chart-pie"></i> Leave Balance
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item-custom {{ request()->routeIs('holidays.*') ? 'active' : '' }}" 
                                           href="{{ route('holidays.index') }}">
                                            <i class="fas fa-calendar-alt"></i> Holidays
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <a class="nav-link-3d {{ request()->routeIs('attendance.*') ? 'active' : '' }}" href="{{ route('attendance.index') }}">
                                <i class="fas fa-calendar-check"></i> My Attendance
                            </a>
                        @endif
                    @endauth
                </div>

                <!-- User Section -->
                <div class="user-section">
                    @auth
                        @php
                            $user = Auth::user();
                            $employee = \App\Models\Employee::where('email', $user->email)->first();
                            $profileImage = null;
                            if($employee && $employee->image && file_exists(public_path($employee->image))) {
                                $profileImage = asset($employee->image);
                            } elseif($user->profile_picture && file_exists(public_path($user->profile_picture))) {
                                $profileImage = asset($user->profile_picture);
                            }
                        @endphp
                        
                        <div class="user-dropdown" id="userDropdown">
                            <div class="user-trigger" onclick="toggleDropdown()">
                                <div class="user-avatar">
                                    @if($profileImage)
                                        <img src="{{ $profileImage }}" alt="{{ $user->name }}">
                                    @else
                                        <span>{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    @endif
                                </div>
                                <span class="user-name">{{ $user->name }}</span>
                                <i class="fas fa-chevron-down dropdown-arrow"></i>
                            </div>
                            
                            <div class="dropdown-menu-glass">
                                <div class="dropdown-header">
                                    <div class="dropdown-avatar">
                                        @if($profileImage)
                                            <img src="{{ $profileImage }}" alt="{{ $user->name }}">
                                        @else
                                            <span>{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                        @endif
                                    </div>
                                    <div class="dropdown-user-info">
                                        <div class="dropdown-user-name">{{ $user->name }}</div>
                                        <div class="dropdown-user-email">{{ $user->email }}</div>
                                        <span class="dropdown-role-badge">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('profile.show') }}">
                                    <i class="fas fa-user"></i> My Profile
                                </a>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-edit"></i> Edit Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer;">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="nav-link-3d" style="background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white;">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    @endauth
                    
                    <!-- Mobile Menu Button -->
                    <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        @auth
            @if(Auth::user()->role === 'admin')
                <a class="mobile-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="fas fa-chart-line"></i> Dashboard
                </a>
                <a class="mobile-nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}" href="{{ route('employees.index') }}">
                    <i class="fas fa-users"></i> Employees
                </a>
                <a class="mobile-nav-link {{ request()->routeIs('departments.*') ? 'active' : '' }}" href="{{ route('departments.index') }}">
                    <i class="fas fa-building"></i> Departments
                </a>
                <a class="mobile-nav-link {{ request()->routeIs('leave.*') ? 'active' : '' }}" href="{{ route('leave.index') }}">
                    <i class="fas fa-clock"></i> Leave
                </a>
                <a class="mobile-nav-link {{ request()->routeIs('holidays.*') ? 'active' : '' }}" href="{{ route('holidays.index') }}">
                    <i class="fas fa-calendar-alt"></i> Holidays
                </a>
                <a class="mobile-nav-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}" href="{{ route('attendance.index') }}">
                    <i class="fas fa-calendar-check"></i> Attendance
                </a>
                <a class="mobile-nav-link {{ request()->routeIs('salary.*') ? 'active' : '' }}" href="{{ route('salary.index') }}">
                    <i class="fas fa-wallet"></i> Salary
                </a>
                <a class="mobile-nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                    <i class="fas fa-chart-simple"></i> Reports
                </a>
            @else
                <a class="mobile-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="fas fa-chart-line"></i> Dashboard
                </a>
                <a class="mobile-nav-link {{ request()->routeIs('leave.*') ? 'active' : '' }}" href="{{ route('leave.index') }}">
                    <i class="fas fa-clock"></i> My Leaves
                </a>
                <a class="mobile-nav-link {{ request()->routeIs('holidays.*') ? 'active' : '' }}" href="{{ route('holidays.index') }}">
                    <i class="fas fa-calendar-alt"></i> Holidays
                </a>
                <a class="mobile-nav-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}" href="{{ route('attendance.index') }}">
                    <i class="fas fa-calendar-check"></i> My Attendance
                </a>
            @endif
        @endauth
    </div>

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

            @yield('content')
        </div>
    </main>

    <footer class="footer">
        <div class="container text-center">
            <p class="mb-0">© {{ date('Y') }} FutureWave Technologies. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function toggleDropdown() {
            document.getElementById('userDropdown').classList.toggle('active');
        }
        
        function toggleMobileMenu() {
            document.getElementById('mobileMenu').classList.toggle('active');
        }
        
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdown');
            if (dropdown && !dropdown.contains(event.target)) {
                dropdown.classList.remove('active');
            }
            
            const mobileMenu = document.getElementById('mobileMenu');
            const mobileBtn = document.querySelector('.mobile-menu-btn');
            if (mobileMenu && !mobileMenu.contains(event.target) && mobileBtn && !mobileBtn.contains(event.target)) {
                mobileMenu.classList.remove('active');
            }
        });
        
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
    @stack('scripts')
</body>
</html>