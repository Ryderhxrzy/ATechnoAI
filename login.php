<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AI Chat</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/styles.css">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: var(--bg-secondary);
            min-height: 100vh;
            color: var(--text-primary);
            transition: background-color 0.2s ease, color 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            line-height: 1.5;
        }

        /* Login Container */
        .login-container {
            width: 100%;
            max-width: 400px;
            background: var(--bg-elevated);
            border-radius: 16px;
            border: 1px solid var(--border-primary);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            margin: 20px auto;
        }

        /* Header */
        .login-header {
            padding: 32px 32px 24px;
            text-align: center;
        }

        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 24px;
        }

       .logo-icon {
    position: relative;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.logo-icon .gear {
    font-size: 36px;
    color: var(--accent-primary);
    position: absolute;
}

.logo-icon .robot {
    font-size: 18px;
    color: white;
    z-index: 1;
    filter: drop-shadow(0 0 0.5px #1a1a1a);
}

.logo-text {
    font-size: 1.5rem;
    font-weight: bold;
    color: var(--text-primary);
}

        .login-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .login-subtitle {
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin-bottom: 0;
        }

        /* Form */
        .login-form {
            padding: 0 32px 32px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            border: 1px solid var(--border-secondary);
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 0.875rem;
            outline: none;
            transition: all 0.2s ease;
            background: var(--bg-primary);
            color: var(--text-primary);
            font-family: inherit;
        }

        .form-input:focus {
            border-color: var(--border-focus);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-input::placeholder {
            color: var(--text-muted);
        }

        /* Password Input Container */
        .password-container {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 4px;
            border-radius: 4px;
            transition: color 0.2s ease;
        }

        .password-toggle:hover {
            color: var(--text-secondary);
        }

        /* Remember & Forgot */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            font-size: 0.875rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-secondary);
        }

        .remember-me input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: var(--accent-primary);
        }

        .forgot-password {
            color: var(--accent-primary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .forgot-password:hover {
            color: var(--accent-hover);
        }

        /* Buttons */
        .btn {
            width: 100%;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
            font-family: inherit;
        }

        .btn-primary {
            background: var(--accent-primary);
            color: white;
            margin-bottom: 16px;
        }

        .btn-primary:hover:not(:disabled) {
            background: var(--accent-hover);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn-primary:disabled {
            background: var(--text-muted);
            cursor: not-allowed;
            transform: none;
            opacity: 0.5;
        }

        .btn-google {
            background: var(--bg-primary);
            color: var(--text-primary);
            border: 1px solid var(--border-secondary);
            margin-bottom: 24px;
        }

        .btn-google:hover {
            background: var(--bg-secondary);
            border-color: var(--border-primary);
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .google-icon {
            width: 18px;
            height: 18px;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><path fill="%23EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/><path fill="%2334A853" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/><path fill="%23FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/><path fill="%23EA4335" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/></svg>') no-repeat center;
            background-size: contain;
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            margin: 24px 0;
            color: var(--text-muted);
            font-size: 0.875rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border-primary);
        }

        .divider span {
            padding: 0 16px;
        }

        /* Register Link */
        .register-link {
            text-align: center;
            padding-top: 24px;
            border-top: 1px solid var(--border-primary);
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        .register-link a {
            color: var(--accent-primary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .register-link a:hover {
            color: var(--accent-hover);
        }

        .theme-toggle {
            position: fixed;
            top: 16px;
            right: 20px;
            background: var(--accent-light);
            color: var(--accent-primary);
            border: 1px solid var(--border-primary);
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            z-index: 100;
        }

        .theme-toggle:hover {
            background: var(--accent-primary);
            color: white;
        }

        /* Mobile Responsive */
        @media (max-width: 480px) {
            body {
                padding: 0;
                display: block;
            }
            
            .login-container {
                margin: 0;
                border-radius: 0;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
                max-width: 100%;
                border: none;
            }

            .login-header {
                padding: 24px 24px 20px;
            }

            .login-form {
                padding: 0 24px 24px;
            }

            .theme-toggle {
                top: 12px;
                right: 12px;
                width: 40px;
                height: 40px;
            }
        }

        /* Small devices (landscape phones, 576px and up) */
        @media (min-width: 576px) and (max-width: 767px) {
            .login-container {
                max-width: 90%;
            }
        }

        /* Medium devices (tablets, 768px and up) */
        @media (min-width: 768px) {
            .login-container {
                max-width: 400px;
            }
        }

        /* Focus and Accessibility */
        button:focus-visible,
        input:focus-visible,
        a:focus-visible {
            outline: 2px solid var(--border-focus);
            outline-offset: 2px;
        }

        /* Loading State */
        .btn.loading {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .btn.loading::after {
            content: '';
            width: 16px;
            height: 16px;
            border: 2px solid transparent;
            border-top: 2px solid currentColor;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-left: 8px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Animation for gear icon */
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- Theme Toggle -->
    <button class="theme-toggle" onclick="toggleTheme()" aria-label="Toggle dark mode">
        <i class="fas fa-moon" id="theme-icon"></i>
    </button>

    <!-- Login Container -->
    <div class="login-container">
        <!-- Header -->
        <div class="login-header">
            <div class="logo">
                <div class="logo-icon">
                    <i class="fas fa-cog gear"></i>
                    <i class="fas fa-robot robot"></i>
                </div>
                <span class="logo-text">Techno.ai</span>
            </div>
            <h1 class="login-title">Welcome back</h1>
            <p class="login-subtitle">Sign in to your account to continue</p>
        </div>

        <!-- Form -->
        <form class="login-form" onsubmit="handleLogin(event)">
            <!-- Google Login Button -->
            <button type="button" class="btn btn-google" onclick="handleGoogleLogin()">
                <div class="google-icon"></div>
                Continue with Google
            </button>

            <!-- Divider -->
            <div class="divider">
                <span>or</span>
            </div>

            <!-- Email Field -->
            <div class="form-group">
                <label for="email" class="form-label">Email address</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-input" 
                    placeholder="Enter your email"
                    required
                >
            </div>

            <!-- Password Field -->
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="password-container">
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-input" 
                        placeholder="Enter your password"
                        required
                    >
                    <button type="button" class="password-toggle" onclick="togglePassword()" aria-label="Toggle password visibility">
                        <i class="fas fa-eye" id="password-icon"></i>
                    </button>
                </div>
            </div>

            <!-- Form Options -->
            <div class="form-options">
                <label class="remember-me">
                    <input type="checkbox" name="remember" id="remember">
                    Remember me
                </label>
                <a href="#" class="forgot-password">Forgot password?</a>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary" id="login-btn">
                <i class="fas fa-sign-in-alt"></i>
                Sign in
            </button>

            <!-- Register Link -->
            <div class="register-link">
                Don't have an account? <a href="#register">Create account</a>
            </div>
        </form>
    </div>

    <script>
        // Theme Management
        function initTheme() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            setTheme(savedTheme);
        }

        function setTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
            
            const themeIcon = document.getElementById('theme-icon');
            if (theme === 'dark') {
                themeIcon.className = 'fas fa-sun';
            } else {
                themeIcon.className = 'fas fa-moon';
            }
        }

        function toggleTheme() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            setTheme(newTheme);
        }

        // Password Toggle
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('password-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.className = 'fas fa-eye-slash';
            } else {
                passwordInput.type = 'password';
                passwordIcon.className = 'fas fa-eye';
            }
        }

        // Handle Login Form
        function handleLogin(event) {
            event.preventDefault();
            const loginBtn = document.getElementById('login-btn');
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            // Add loading state
            loginBtn.classList.add('loading');
            loginBtn.innerHTML = '<i class="fas fa-sign-in-alt"></i>Signing in...';
            
            // Simulate login process
            setTimeout(() => {
                alert(`Login attempt with email: ${email}`);
                loginBtn.classList.remove('loading');
                loginBtn.innerHTML = '<i class="fas fa-sign-in-alt"></i>Sign in';
            }, 2000);
        }

        // Handle Google Login
        function handleGoogleLogin() {
            const googleBtn = document.querySelector('.btn-google');
            googleBtn.classList.add('loading');
            googleBtn.innerHTML = '<div class="google-icon"></div>Connecting...';
            
            // Simulate Google login process
            setTimeout(() => {
                alert('Google login initiated');
                googleBtn.classList.remove('loading');
                googleBtn.innerHTML = '<div class="google-icon"></div>Continue with Google';
            }, 2000);
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            initTheme();
            
            // Add focus management for better accessibility
            const inputs = document.querySelectorAll('.form-input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('focused');
                });
            });
        });

        // Handle register link click
        document.querySelector('.register-link a').addEventListener('click', function(e) {
            e.preventDefault();
            alert('Redirect to registration page');
        });

        // Handle forgot password click
        document.querySelector('.forgot-password').addEventListener('click', function(e) {
            e.preventDefault();
            alert('Redirect to password reset page');
        });
    </script>
</body>
</html>