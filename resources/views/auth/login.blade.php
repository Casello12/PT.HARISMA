<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - PT. Kharisma Sukses Persada</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #16A34A 0%, #15803D 50%, #166534 100%);
            --secondary-gradient: linear-gradient(135deg, #2563EB 0%, #1D4ED8 50%, #1E40AF 100%);
            --gold-gradient: linear-gradient(135deg, #F59E0B 0%, #D97706 50%, #B45309 100%);
            --dark-gradient: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
            --glass-bg: rgba(255, 255, 255, 0.95);
            --glass-border: rgba(255, 255, 255, 0.2);
            --shadow-soft: 0 10px 40px rgba(0, 0, 0, 0.1);
            --shadow-premium: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            background: var(--dark-gradient);
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        /* Animated Background */
        body::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(22, 163, 74, 0.1) 0%, transparent 50%);
            animation: pulse-bg 15s ease-in-out infinite;
        }
        
        body::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.1) 0%, transparent 50%);
            animation: pulse-bg 20s ease-in-out infinite reverse;
        }
        
        @keyframes pulse-bg {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            50% {
                transform: translate(-10%, -10%) scale(1.1);
            }
        }
        
        /* Floating Shapes */
        .floating-shape {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(22, 163, 74, 0.2), rgba(37, 99, 235, 0.2));
            animation: float 20s ease-in-out infinite;
        }
        
        .shape-1 {
            width: 300px;
            height: 300px;
            top: -100px;
            left: -100px;
            animation-delay: 0s;
        }
        
        .shape-2 {
            width: 200px;
            height: 200px;
            bottom: -50px;
            right: -50px;
            animation-delay: 5s;
        }
        
        .shape-3 {
            width: 150px;
            height: 150px;
            top: 50%;
            right: 10%;
            animation-delay: 10s;
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }
        
        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 480px;
            padding: 20px;
        }
        
        .login-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            box-shadow: var(--shadow-premium);
            overflow: hidden;
            position: relative;
        }
        
        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
        }
        
        .login-card::after {
            content: '';
            position: absolute;
            top: 4px;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.8), transparent);
        }
        
        .card-header-custom {
            background: linear-gradient(135deg, rgba(22, 163, 74, 0.05), rgba(37, 99, 235, 0.05));
            padding: 40px 40px 30px;
            text-align: center;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .logo-container {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: var(--primary-gradient);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 30px rgba(22, 163, 74, 0.3);
            animation: logo-float 3s ease-in-out infinite;
        }
        
        @keyframes logo-float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }
        
        .logo-container i {
            font-size: 2.5rem;
            color: white;
            line-height: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .company-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1E293B;
            margin-bottom: 5px;
            letter-spacing: -0.5px;
        }
        
        .system-name {
            font-size: 0.875rem;
            color: #64748B;
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        
        .card-body-custom {
            padding: 40px;
        }
        
        .form-group-custom {
            margin-bottom: 24px;
            position: relative;
        }
        
        .form-label-custom {
            font-size: 0.875rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: 8px;
            display: block;
        }
        
        .form-control-custom {
            width: 100%;
            padding: 14px 20px;
            border: 2px solid #E2E8F0;
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #F8FAFC;
        }
        
        .form-control-custom:focus {
            border-color: #16A34A;
            background: white;
            box-shadow: 0 0 0 4px rgba(22, 163, 74, 0.1);
            outline: none;
        }
        
        .form-control-custom::placeholder {
            color: #94A3B8;
        }
        
        .input-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #94A3B8;
            font-size: 1.1rem;
            transition: color 0.3s ease;
            line-height: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .form-control-custom:focus + .input-icon {
            color: #16A34A;
        }
        
        .form-check-custom {
            display: flex;
            align-items: center;
            margin-bottom: 24px;
        }
        
        .form-check-input-custom {
            width: 20px;
            height: 20px;
            border: 2px solid #E2E8F0;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .form-check-input-custom:checked {
            background: var(--primary-gradient);
            border-color: #16A34A;
        }
        
        .form-check-label-custom {
            margin-left: 12px;
            font-size: 0.875rem;
            color: #64748B;
            font-weight: 500;
            cursor: pointer;
        }
        
        .btn-login {
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            color: white;
            background: var(--primary-gradient);
            box-shadow: 0 10px 25px rgba(22, 163, 74, 0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(22, 163, 74, 0.4);
        }
        
        .btn-login:hover::before {
            left: 100%;
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .divider {
            display: flex;
            align-items: center;
            margin: 30px 0;
            color: #94A3B8;
            font-size: 0.875rem;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #E2E8F0;
        }
        
        .divider span {
            padding: 0 16px;
        }
        
        .footer-info {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .footer-info p {
            color: #64748B;
            font-size: 0.875rem;
            margin-bottom: 8px;
        }
        
        .footer-info a {
            color: #16A34A;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        
        .footer-info a:hover {
            color: #15803D;
        }
        
        .copyright {
            text-align: center;
            margin-top: 30px;
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.75rem;
        }
        
        .shimmer {
            position: relative;
            overflow: hidden;
        }
        
        .shimmer::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            animation: shimmer 3s infinite;
        }
        
        @keyframes shimmer {
            0% {
                left: -100%;
            }
            100% {
                left: 200%;
            }
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .login-container {
                padding: 15px;
            }
            
            .card-header-custom,
            .card-body-custom {
                padding: 30px 25px;
            }
            
            .floating-shape {
                display: none;
            }
        }
        
        /* Invalid feedback styling */
        .invalid-feedback {
            font-size: 0.8rem;
            margin-top: 6px;
            color: #DC2626;
        }
        
        .is-invalid {
            border-color: #DC2626 !important;
        }
        
        .is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.1) !important;
        }
    </style>
</head>
<body>
    <!-- Floating Background Shapes -->
    <div class="floating-shape shape-1"></div>
    <div class="floating-shape shape-2"></div>
    <div class="floating-shape shape-3"></div>
    
    <div class="login-container">
        <div class="login-card">
            <div class="card-header-custom">
                <div class="logo-container">
                    <i class="bi bi-box-seam"></i>
                </div>
                <h1 class="company-name">PT. Kharisma Sukses Persada</h1>
                <p class="system-name">Sistem Informasi Manajemen Stok</p>
            </div>
            
            <div class="card-body-custom">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="form-group-custom">
                        <label for="email" class="form-label-custom">Email Address</label>
                        <input type="email" 
                               class="form-control-custom @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autofocus
                               placeholder="Masukkan email Anda">
                        <i class="bi bi-envelope input-icon"></i>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group-custom">
                        <label for="password" class="form-label-custom">Password</label>
                        <input type="password" 
                               class="form-control-custom @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               required
                               placeholder="Masukkan password Anda">
                        <i class="bi bi-lock input-icon"></i>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-check-custom">
                        <input type="checkbox" 
                               class="form-check-input-custom" 
                               id="remember" 
                               name="remember">
                        <label class="form-check-label-custom" for="remember">
                            Ingat Saya
                        </label>
                    </div>
                    
                    <button type="submit" class="btn btn-login shimmer">
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        Masuk Dashboard
                    </button>
                </form>
                
                <div class="footer-info">
                    <p class="mb-0">Lupa password?</p>
                    <p class="mb-0">
                        @if (Route::has('register'))
                            Belum punya akun? 
                            <a href="{{ route('register') }}">Daftar disini</a>
                        @endif
                    </p>
                </div>
            </div>
        </div>
        
        <div class="copyright">
            <p>&copy; 2026 PT. Kharisma Sukses Persada. All rights reserved.</p>
        </div>
    </div>
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Add entrance animation
        document.addEventListener('DOMContentLoaded', function() {
            const loginCard = document.querySelector('.login-card');
            loginCard.style.opacity = '0';
            loginCard.style.transform = 'translateY(30px)';
            
            setTimeout(() => {
                loginCard.style.transition = 'all 0.6s ease';
                loginCard.style.opacity = '1';
                loginCard.style.transform = 'translateY(0)';
            }, 100);
            
            // Add focus effects
            const inputs = document.querySelectorAll('.form-control-custom');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                    this.parentElement.style.transition = 'transform 0.3s ease';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });
        });
    </script>
</body>
</html>