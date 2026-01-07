@extends('layouts.guest')
@section('title', 'Login')

@section('content')
    <div class="min-vh-100 d-flex align-items-center justify-content-center py-4 px-3">
        <div class="login-container">
            <!-- Logo/Brand Section -->
            <div class="text-center mb-4">
                <div class="brand-logo mb-3">
                    <div class="logo-circle">
                        <i class="fas fa-mosque text-white"></i>
                    </div>
                </div>
                <h1 class="brand-title mb-2">Aplikasi Masjid</h1>
                <p class="brand-subtitle text-muted">Sistem Manajemen Masjid Digital</p>
            </div>

            <!-- Login Card -->
            <div class="login-card">
                <div class="card-header">
                    <h2 class="login-title">{{ __('Selamat Datang') }}</h2>
                    <p class="login-subtitle">{{ __('Silakan masuk ke akun Anda') }}</p>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" class="login-form">
                        @csrf

                        <!-- Email Field -->
                        <div class="form-group">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-2"></i>{{ __('Alamat Email') }}
                            </label>
                            <div class="input-wrapper">
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}"
                                    required
                                    autocomplete="email"
                                    autofocus
                                    placeholder="contoh@email.com"
                                >
                                <div class="input-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                            </div>
                            @error('email')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="form-group">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-2"></i>{{ __('Kata Sandi') }}
                            </label>
                            <div class="input-wrapper">
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    required
                                    autocomplete="current-password"
                                    placeholder="Masukkan kata sandi"
                                >
                                <div class="input-icon">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <button type="button" class="password-toggle" onclick="togglePassword()">
                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                </button>
                            </div>
                            @error('password')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="form-options">
                            <div class="remember-me">
                                <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember">{{ __('Ingat Saya') }}</label>
                            </div>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="forgot-password">
                                    {{ __('Lupa Kata Sandi?') }}
                                </a>
                            @endif
                        </div>

                        <!-- Login Button -->
                        <button type="submit" class="btn-login">
                            <span class="btn-text">{{ __('Masuk') }}</span>
                            <div class="btn-loader" style="display: none;">
                                <div class="spinner"></div>
                            </div>
                        </button>
                    </form>

                    <!-- Register Link -->
                    <div class="register-link">
                        <span>{{ __('Belum punya akun?') }}</span>
                        <a href="{{ route('register') }}">{{ __('Daftar Sekarang') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Modern CSS Variables */
        :root {
            --primary-color: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-light: #3b82f6;
            --success-color: #059669;
            --error-color: #dc2626;
            --warning-color: #d97706;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --text-light: #9ca3af;
            --border-color: #e5e7eb;
            --border-focus: #3b82f6;
            --bg-light: #f9fafb;
            --bg-white: #ffffff;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --radius-sm: 0.375rem;
            --radius-md: 0.5rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
        }

        /* Base Styles */
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 50%, #cbd5e1 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        /* Login Container */
        .login-container {
            width: 100%;
            max-width: 420px;
            margin: 0 auto;
        }

        /* Brand Section */
        .brand-logo {
            display: flex;
            justify-content: center;
        }

        .logo-circle {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-lg);
        }

        .logo-circle i {
            font-size: 2rem;
        }

        .brand-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
            text-shadow: 0 2px 8px rgba(255,255,255,0.9);
            background: linear-gradient(135deg, #1f2937 0%, #374151 50%, #1f2937 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            filter: drop-shadow(0 2px 4px rgba(255,255,255,0.3));
        }

        .brand-subtitle {
            font-size: 1rem;
            color: #374151;
            margin: 0;
            text-shadow: 0 1px 3px rgba(255,255,255,0.8);
            font-weight: 500;
        }

        /* Login Card */
        .login-card {
            background: var(--bg-white);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
        }

        .card-header {
            padding: 2rem 2rem 1rem;
            text-align: center;
            border-bottom: 1px solid var(--border-color);
        }

        .login-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0 0 0.5rem;
        }

        .login-subtitle {
            color: var(--text-secondary);
            margin: 0;
            font-size: 0.95rem;
        }

        .card-body {
            padding: 2rem;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .input-wrapper {
            position: relative;
        }

        .form-control {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 3rem;
            border: 2px solid var(--border-color);
            border-radius: var(--radius-md);
            font-size: 1rem;
            transition: all 0.2s ease;
            background: var(--bg-white);
            box-sizing: border-box;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--border-focus);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-control.is-invalid {
            border-color: var(--error-color);
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
            pointer-events: none;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-light);
            cursor: pointer;
            padding: 0.25rem;
            transition: color 0.2s ease;
        }

        .password-toggle:hover {
            color: var(--text-secondary);
        }

        /* Error Messages */
        .error-message {
            color: var(--error-color);
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
        }

        /* Form Options */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
        }

        .remember-me input[type="checkbox"] {
            margin-right: 0.5rem;
            width: 1rem;
            height: 1rem;
            accent-color: var(--primary-color);
        }

        .remember-me label {
            font-size: 0.9rem;
            color: var(--text-secondary);
            cursor: pointer;
            margin: 0;
        }

        .forgot-password {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .forgot-password:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        /* Login Button */
        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white;
            border: none;
            padding: 1rem;
            border-radius: var(--radius-md);
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .btn-loader {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Register Link */
        .register-link {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color);
            color: var(--text-secondary);
            font-size: 0.95rem;
        }

        .register-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            margin-left: 0.5rem;
            transition: color 0.2s ease;
        }

        .register-link a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .login-container {
                max-width: 100%;
                margin: 0 1rem;
            }

            .brand-title {
                font-size: 1.75rem;
            }

            .login-title {
                font-size: 1.5rem;
            }

            .card-body,
            .card-header {
                padding: 1.5rem;
            }

            .form-options {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }

            .logo-circle {
                width: 70px;
                height: 70px;
            }

            .logo-circle i {
                font-size: 1.75rem;
            }
        }

        @media (max-width: 480px) {
            .login-container {
                margin: 0 0.75rem;
            }

            .card-body,
            .card-header {
                padding: 1.25rem;
            }

            .brand-title {
                font-size: 1.5rem;
            }

            .login-title {
                font-size: 1.25rem;
            }

            .form-control {
                padding: 0.75rem 0.875rem 0.75rem 2.75rem;
            }

            .input-icon {
                left: 0.875rem;
            }

            .password-toggle {
                right: 0.875rem;
            }
        }

        /* Accessibility Improvements */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        /* Focus visibility for keyboard navigation */
        .btn-login:focus-visible,
        .form-control:focus-visible,
        .forgot-password:focus-visible,
        .register-link a:focus-visible {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }
    </style>

    <script>
        // Password toggle functionality
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Form submission with loading state
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.login-form');
            const submitBtn = document.querySelector('.btn-login');
            const btnText = document.querySelector('.btn-text');
            const btnLoader = document.querySelector('.btn-loader');

            form.addEventListener('submit', function(e) {
                // Show loading state
                submitBtn.disabled = true;
                btnText.style.opacity = '0';
                btnLoader.style.display = 'block';

                // Optional: Add a small delay to show the loading state
                // Remove this in production if not needed
                setTimeout(() => {
                    // The form will submit naturally after this timeout
                }, 500);
            });

            // Reset loading state if there are validation errors
            window.addEventListener('pageshow', function() {
                submitBtn.disabled = false;
                btnText.style.opacity = '1';
                btnLoader.style.display = 'none';
            });
        });

        // Enhanced form validation feedback
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.form-control');

            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    validateField(this);
                });

                input.addEventListener('input', function() {
                    if (this.classList.contains('is-invalid')) {
                        validateField(this);
                    }
                });
            });

            function validateField(field) {
                const isValid = field.checkValidity();

                if (isValid) {
                    field.classList.remove('is-invalid');
                    field.classList.add('is-valid');
                } else {
                    field.classList.remove('is-valid');
                    field.classList.add('is-invalid');
                }
            }
        });
    </script>
@endsection
