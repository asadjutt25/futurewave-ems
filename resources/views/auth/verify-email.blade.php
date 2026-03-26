<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Verify Email - FutureWave EMS</title>

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
            --secondary: #ec4899;
            --cyan: #06b6d4;
            --green: #10b981;
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

        .bg-animation .circle:nth-child(1) { width: 300px; height: 300px; top: -100px; left: -100px; animation-duration: 25s; }
        .bg-animation .circle:nth-child(2) { width: 500px; height: 500px; bottom: -200px; right: -200px; animation-duration: 30s; }
        .bg-animation .circle:nth-child(3) { width: 200px; height: 200px; top: 50%; left: 20%; animation-duration: 18s; }
        .bg-animation .circle:nth-child(4) { width: 400px; height: 400px; bottom: 10%; left: 30%; animation-duration: 22s; }
        .bg-animation .circle:nth-child(5) { width: 150px; height: 150px; top: 20%; right: 15%; animation-duration: 15s; }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-50px) rotate(10deg); }
        }

        .verify-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            position: relative;
            z-index: 1;
        }

        .verify-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 32px;
            padding: 2.5rem;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.3);
            text-align: center;
        }

        .logo-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary), var(--secondary), var(--cyan));
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            animation: floatLogo 3s ease-in-out infinite;
            box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.4);
        }

        @keyframes floatLogo {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
        }

        .logo-icon i {
            font-size: 2.5rem;
            color: white;
        }

        .verify-icon {
            width: 80px;
            height: 80px;
            background: rgba(16, 185, 129, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .verify-icon i {
            font-size: 3rem;
            color: var(--green);
        }

        h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 0.75rem;
        }

        p {
            font-size: 0.9rem;
            color: var(--gray-600);
            line-height: 1.5;
            margin-bottom: 1.5rem;
        }

        .btn-resend {
            background: linear-gradient(135deg, var(--primary), var(--secondary), var(--cyan));
            border: none;
            padding: 0.85rem 1.5rem;
            border-radius: 16px;
            color: white;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            cursor: pointer;
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .btn-resend::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s ease;
        }

        .btn-resend:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.4);
        }

        .btn-resend:hover::before {
            left: 100%;
        }

        .btn-logout {
            background: transparent;
            border: 1px solid var(--gray-200);
            padding: 0.85rem 1.5rem;
            border-radius: 16px;
            color: var(--gray-700);
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 1rem;
        }

        .btn-logout:hover {
            background: var(--gray-100);
            border-color: var(--gray-300);
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border-radius: 16px;
            padding: 0.85rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        @media (max-width: 576px) {
            .verify-card { padding: 1.8rem; }
            h3 { font-size: 1.3rem; }
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

    <div class="verify-container">
        <div class="verify-card">
            <div class="logo-icon">
                <i class="fas fa-waveform"></i>
            </div>

            <div class="verify-icon">
                <i class="fas fa-envelope-open-text"></i>
            </div>

            <h3>Verify Your Email Address</h3>
            <p>Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.</p>

            @if (session('status') == 'verification-link-sent')
                <div class="alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>A new verification link has been sent to your email address.</span>
                </div>
            @endif

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn-resend">
                    <i class="fas fa-paper-plane me-2"></i> Resend Verification Email
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <script>
        setTimeout(function() {
            document.querySelectorAll('.alert-success').forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
</body>
</html>