<?php
session_start();
if (isset($_SESSION['user'])) {
    header('Location: users/index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AI Chat</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/login.css">
    <link rel="stylesheet" href="assets/styles.css">
    <style>
        .loading {
            position: relative;
            pointer-events: none;
        }
        .loading::after {
            content: "";
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            to { transform: translateY(-50%) rotate(360deg); }
        }
        .google-icon {
            display: inline-block;
            width: 18px;
            height: 18px;
            background: url('https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg') no-repeat center;
            background-size: contain;
            margin-right: 8px;
            vertical-align: middle;
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
            
            <?php if (isset($_SESSION['login_error'])): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($_SESSION['login_error']); unset($_SESSION['login_error']); ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Form -->
        <form class="login-form" onsubmit="handleLogin(event)">
            <!-- Google Login Button -->
            <a href="google/authentication/auth_handler.php?action=google-login" class="btn btn-google" id="google-login-btn">
                <div class="google-icon"></div>
                Continue with Google
            </a>
            
            <?php if (isset($_SESSION['auth_error'])): ?>
                <div class="error-message">
                    <?= htmlspecialchars($_SESSION['auth_error']); 
                    unset($_SESSION['auth_error']); ?>
                </div>
            <?php endif; ?>

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
            
            loginBtn.classList.add('loading');
            loginBtn.innerHTML = '<i class="fas fa-sign-in-alt"></i>Signing in...';
            
            // Simulate login process
            setTimeout(() => {
                alert(`Login attempt with email: ${email}`);
                loginBtn.classList.remove('loading');
                loginBtn.innerHTML = '<i class="fas fa-sign-in-alt"></i>Sign in';
            }, 2000);
        }

        // Handle Google Login Button Click
        document.getElementById('google-login-btn').addEventListener('click', function(e) {
            const btn = this;
            btn.classList.add('loading');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<div class="google-icon"></div>Redirecting...';
            
            setTimeout(() => {
                btn.classList.remove('loading');
                btn.innerHTML = originalText;
            }, 2000);
        });

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            initTheme();
            
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