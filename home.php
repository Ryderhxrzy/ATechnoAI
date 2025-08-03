<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>W3Schools Clone - Learn Web Development</title>
    <style>
        :root {
          /* Light mode colors */
          --bg-primary: #ffffff;
          --bg-secondary: #f5f7fa;
          --bg-tertiary: #ebeff5;
          --bg-elevated: #ffffff;
          
          --text-primary: #1a1a1a;
          --text-secondary: #4a5568;
          --text-tertiary: #718096;
          --text-muted: #a0aec0;
          
          --border-primary: #e2e8f0;
          --border-secondary: #d0d9e6;
          --border-focus: #4299e1;
          
          --accent-primary: #3182ce;
          --accent-hover: #2c5282;
          --accent-light: #ebf8ff;
          
          --success: #38a169;
          --warning: #d69e2e;
          --error: #e53e3e;
          
          --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.08);
          --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1), 0 2px 4px rgba(0, 0, 0, 0.06);
          --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1), 0 4px 6px rgba(0, 0, 0, 0.05);
          
          /* Code theme */
          --code-bg: #2d3748;
          --code-text: #e2e8f0;
          --code-header-bg: #1a202c;
          --code-header-text: #f7fafc;
          --code-border: #4a5568;
          
          /* Scrollbar */
          --scrollbar-track: #edf2f7;
          --scrollbar-thumb: #cbd5e0;
          --scrollbar-thumb-hover: #a0aec0;
        }

        /* Dark mode colors */
        [data-theme="dark"] {
          --bg-primary: #2d3748;
          --bg-secondary: #1a202c;
          --bg-tertiary: #4a5568;
          --bg-elevated: #2d3748;
          
          --text-primary: #f7fafc;
          --text-secondary: #e2e8f0;
          --text-tertiary: #cbd5e0;
          --text-muted: #a0aec0;
          
          --border-primary: #4a5568;
          --border-secondary: #718096;
          --border-focus: #63b3ed;
          
          --accent-primary: #63b3ed;
          --accent-hover: #90cdf4;
          --accent-light: #2d3748;
          
          --success: #68d391;
          --warning: #f6ad55;
          --error: #fc8181;
          
          --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.25);
          --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.3), 0 2px 4px rgba(0, 0, 0, 0.2);
          --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.3), 0 4px 6px rgba(0, 0, 0, 0.2);
          
          /* Code theme - slightly brighter for dark mode */
          --code-bg: #2d3748;
          --code-text: #f7fafc;
          --code-header-bg: #1a202c;
          --code-header-text: #ffffff;
          --code-border: #4a5568;
          
          /* Scrollbar */
          --scrollbar-track: #2d3748;
          --scrollbar-thumb: #4a5568;
          --scrollbar-thumb-hover: #718096;

          --profile-avatar-color: white;
          --button-text-color: white;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-secondary);
            color: var(--text-primary);
            line-height: 1.6;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--scrollbar-track);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--scrollbar-thumb);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--scrollbar-thumb-hover);
        }

        /* Header */
        .header {
            background-color: var(--accent-primary);
            color: white;
            padding: 12px 0;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            box-shadow: var(--shadow-md);
            transition: background-color 0.3s ease;
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            text-decoration: none;
            color: white;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 30px;
        }

        .nav-menu a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            padding: 8px 12px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .nav-menu a:hover {
            background-color: rgba(255,255,255,0.1);
        }

        .header-controls {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .search-box {
            padding: 8px 12px;
            border: 1px solid var(--border-primary);
            border-radius: 20px;
            font-size: 14px;
            width: 200px;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            transition: all 0.3s ease;
        }

        .search-box:focus {
            outline: none;
            border-color: var(--border-focus);
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
        }

        /* Theme Toggle */
        .theme-toggle {
            background: none;
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            padding: 8px 12px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .theme-toggle:hover {
            background-color: rgba(255,255,255,0.1);
        }

        /* Main Layout */
        .main-container {
            margin-top: 60px;
            display: flex;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
            min-height: calc(100vh - 60px);
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: var(--bg-elevated);
            border-right: 1px solid var(--border-primary);
            padding: 20px 0;
            position: sticky;
            top: 60px;
            height: fit-content;
            max-height: calc(100vh - 60px);
            overflow-y: auto;
            transition: all 0.3s ease;
        }

        .sidebar h3 {
            color: var(--accent-primary);
            padding: 0 20px 10px;
            font-size: 18px;
            border-bottom: 1px solid var(--border-primary);
            margin-bottom: 15px;
            transition: color 0.3s ease;
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar li {
            margin-bottom: 2px;
        }

        .sidebar a {
            display: block;
            padding: 8px 20px;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .sidebar a:hover, .sidebar a.active {
            background-color: var(--accent-primary);
            color: white;
        }

        /* Content Area */
        .content {
            flex: 1;
            padding: 20px;
            background-color: var(--bg-primary);
            margin: 20px;
            border-radius: 8px;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }

        .breadcrumb {
            color: var(--text-tertiary);
            margin-bottom: 20px;
            font-size: 14px;
        }

        .breadcrumb a {
            color: var(--accent-primary);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .breadcrumb a:hover {
            color: var(--accent-hover);
        }

        h1 {
            color: var(--accent-primary);
            font-size: 36px;
            margin-bottom: 20px;
            transition: color 0.3s ease;
        }

        h2 {
            color: var(--text-primary);
            font-size: 24px;
            margin: 30px 0 15px;
            padding-bottom: 5px;
            border-bottom: 2px solid var(--accent-primary);
            transition: all 0.3s ease;
        }

        .intro-text {
            font-size: 18px;
            color: var(--text-secondary);
            margin-bottom: 30px;
            padding: 20px;
            background-color: var(--accent-light);
            border-left: 4px solid var(--accent-primary);
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        /* Code Examples */
        .code-example {
            background-color: var(--bg-secondary);
            border: 1px solid var(--border-primary);
            border-radius: 4px;
            margin: 20px 0;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .code-header {
            background-color: var(--code-header-bg);
            color: var(--code-header-text);
            padding: 10px 15px;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .code-content {
            padding: 15px;
            background-color: var(--bg-primary);
            border-top: 1px solid var(--border-primary);
            transition: all 0.3s ease;
        }

        .code-block {
            background-color: var(--code-bg);
            color: var(--code-text);
            border: 1px solid var(--code-border);
            padding: 15px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            line-height: 1.4;
            overflow-x: auto;
            border-radius: 4px;
            margin: 10px 0;
        }

        /* Buttons */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: var(--accent-primary);
            color: white;
            text-decoration: none;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease;
            margin: 5px;
        }

        .btn:hover {
            background-color: var(--accent-hover);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background-color: var(--text-tertiary);
        }

        .btn-secondary:hover {
            background-color: var(--text-secondary);
        }

        .btn-success {
            background-color: var(--success);
        }

        .btn-warning {
            background-color: var(--warning);
        }

        .btn-error {
            background-color: var(--error);
        }

        /* Try It Yourself Section */
        .try-it {
            background-color: var(--accent-light);
            border: 1px solid var(--accent-primary);
            border-radius: 4px;
            padding: 20px;
            margin: 20px 0;
            transition: all 0.3s ease;
        }

        .try-it h3 {
            color: var(--accent-primary);
            margin-bottom: 10px;
        }

        /* Progress Bar */
        .progress-container {
            background-color: var(--bg-secondary);
            border-radius: 10px;
            padding: 3px;
            margin: 20px 0;
            transition: background-color 0.3s ease;
        }

        .progress-bar {
            background-color: var(--accent-primary);
            height: 20px;
            border-radius: 10px;
            width: 65%;
            transition: all 0.3s ease;
        }

        /* Alert/Notification Styles */
        .alert {
            padding: 15px;
            border-radius: 4px;
            margin: 15px 0;
            border-left: 4px solid;
        }

        .alert-success {
            background-color: rgba(56, 161, 105, 0.1);
            border-left-color: var(--success);
            color: var(--success);
        }

        .alert-warning {
            background-color: rgba(214, 158, 46, 0.1);
            border-left-color: var(--warning);
            color: var(--warning);
        }

        .alert-error {
            background-color: rgba(229, 62, 62, 0.1);
            border-left-color: var(--error);
            color: var(--error);
        }

        /* Footer */
        .footer {
            background-color: var(--bg-tertiary);
            color: var(--text-secondary);
            text-align: center;
            padding: 40px 20px;
            margin-top: 50px;
            border-top: 1px solid var(--border-primary);
            transition: all 0.3s ease;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .footer-links a {
            color: var(--text-tertiary);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--accent-primary);
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .main-container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                position: static;
                max-height: none;
            }

            .nav-menu {
                display: none;
            }

            .search-box {
                width: 150px;
            }

            .header-content {
                padding: 0 10px;
            }

            .content {
                margin: 10px;
                padding: 15px;
            }

            h1 {
                font-size: 28px;
            }

            .header-controls {
                gap: 10px;
            }
        }

        /* Smooth transitions for theme switching */
        * {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <a href="#" class="logo">W3Schools</a>
            <nav>
                <ul class="nav-menu">
                    <li><a href="#tutorials">Tutorials</a></li>
                    <li><a href="#references">References</a></li>
                    <li><a href="#exercises">Exercises</a></li>
                    <li><a href="#videos">Videos</a></li>
                    <li><a href="#pro">Pro</a></li>
                </ul>
            </nav>
            <div class="header-controls">
                <input type="search" class="search-box" placeholder="Search..." />
                <button class="theme-toggle" onclick="toggleTheme()">
                    <span id="theme-icon">🌙</span>
                    <span id="theme-text">Dark</span>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h3>HTML Tutorial</h3>
            <ul>
                <li><a href="#" class="active">HTML HOME</a></li>
                <li><a href="#">HTML Introduction</a></li>
                <li><a href="#">HTML Editors</a></li>
                <li><a href="#">HTML Basic</a></li>
                <li><a href="#">HTML Elements</a></li>
                <li><a href="#">HTML Attributes</a></li>
                <li><a href="#">HTML Headings</a></li>
                <li><a href="#">HTML Paragraphs</a></li>
                <li><a href="#">HTML Styles</a></li>
                <li><a href="#">HTML Formatting</a></li>
                <li><a href="#">HTML Quotations</a></li>
                <li><a href="#">HTML Comments</a></li>
                <li><a href="#">HTML Colors</a></li>
                <li><a href="#">HTML CSS</a></li>
                <li><a href="#">HTML Links</a></li>
                <li><a href="#">HTML Images</a></li>
                <li><a href="#">HTML Favicon</a></li>
                <li><a href="#">HTML Tables</a></li>
                <li><a href="#">HTML Lists</a></li>
                <li><a href="#">HTML Block & Inline</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="content">
            <div class="breadcrumb">
                <a href="#">HOME</a> / HTML Tutorial
            </div>

            <h1>HTML Tutorial</h1>

            <div class="intro-text">
                HTML is the standard markup language for Web pages. With HTML you can create your own Website. HTML is easy to learn - You will enjoy it!
            </div>

            <div class="alert alert-success">
                <strong>New!</strong> Try our enhanced learning experience with interactive examples.
            </div>

            <div class="code-example">
                <div class="code-header">
                    Example
                    <button class="btn" onclick="runCode()">Try it Yourself »</button>
                </div>
                <div class="code-content">
                    <div class="code-block" id="codeBlock">&lt;!DOCTYPE html&gt;
&lt;html&gt;
&lt;head&gt;
&lt;title&gt;Page Title&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;

&lt;h1&gt;This is a Heading&lt;/h1&gt;
&lt;p&gt;This is a paragraph.&lt;/p&gt;

&lt;/body&gt;
&lt;/html&gt;</div>
                </div>
            </div>

            <div class="try-it">
                <h3>Try it Yourself!</h3>
                <p>Click on the "Try it Yourself" button to see how it works.</p>
                <button class="btn">Try it Yourself »</button>
            </div>

            <h2>What is HTML?</h2>
            <p>HTML stands for Hyper Text Markup Language. HTML is the standard markup language for creating Web pages. HTML describes the structure of a Web page using markup. HTML elements are the building blocks of HTML pages.</p>

            <div class="alert alert-warning">
                <strong>Note:</strong> HTML elements are represented by tags and are not case-sensitive.
            </div>

            <h2>Learning Progress</h2>
            <p>Track your learning progress:</p>
            <div class="progress-container">
                <div class="progress-bar"></div>
            </div>
            <p><strong>65%</strong> Complete</p>

            <h2>HTML Examples</h2>
            <p>In this HTML tutorial, you will find more than 200 examples. With our online "Try it Yourself" editor, you can edit and test each example yourself!</p>

            <div class="code-example">
                <div class="code-header">
                    HTML Document Example
                    <button class="btn" onclick="showResult()">Show Result</button>
                </div>
                <div class="code-content">
                    <div class="code-block">&lt;h1&gt;My First Heading&lt;/h1&gt;
&lt;p&gt;My first paragraph.&lt;/p&gt;</div>
                    <div id="result" style="display: none; margin-top: 15px; padding: 15px; background-color: var(--bg-secondary); border: 1px solid var(--border-primary); border-radius: 4px;">
                        <h1 style="color: var(--text-primary); margin: 0 0 10px 0;">My First Heading</h1>
                        <p style="margin: 0; color: var(--text-secondary);">My first paragraph.</p>
                    </div>
                </div>
            </div>

            <h2>HTML Exercises</h2>
            <p>Test your HTML skills with our exercises.</p>
            <button class="btn btn-success">Start HTML Exercises</button>
            <button class="btn btn-warning">HTML Quiz</button>
            <button class="btn btn-secondary">Reference Guide</button>

            <h2>My Learning</h2>
            <p>Track your progress with the free "My Learning" program here at W3Schools.</p>
            <button class="btn">Get Started</button>

            <div class="alert alert-error" style="margin-top: 30px;">
                <strong>Important:</strong> Always validate your HTML code to ensure it follows web standards.
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-links">
            <a href="#">About W3Schools</a>
            <a href="#">Contact</a>
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of Use</a>
            <a href="#">Help</a>
            <a href="#">Accessibility</a>
        </div>
        <p>&copy; 1999-2025 by Refsnes Data. All Rights Reserved. W3Schools is Powered by W3.CSS.</p>
    </footer>

    <script>
        // Theme management
        let currentTheme = 'light';

        function toggleTheme() {
            const html = document.documentElement;
            const themeIcon = document.getElementById('theme-icon');
            const themeText = document.getElementById('theme-text');
            
            if (currentTheme === 'light') {
                html.setAttribute('data-theme', 'dark');
                themeIcon.textContent = '☀️';
                themeText.textContent = 'Light';
                currentTheme = 'dark';
            } else {
                html.removeAttribute('data-theme');
                themeIcon.textContent = '🌙';
                themeText.textContent = 'Dark';
                currentTheme = 'light';
            }
        }

        // Initialize theme based on user preference
        function initTheme() {
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (prefersDark) {
                toggleTheme();
            }
        }

        // Interactive functionality
        function runCode() {
            const alerts = [
                'This would open the code editor in a real W3Schools implementation!',
                'Interactive coding environment would launch here!',
                'Try it yourself feature activated!'
            ];
            alert(alerts[Math.floor(Math.random() * alerts.length)]);
        }

        function showResult() {
            const result = document.getElementById('result');
            const button = event.target;
            
            if (result.style.display === 'none') {
                result.style.display = 'block';
                button.textContent = 'Hide Result';
                button.className = 'btn btn-secondary';
            } else {
                result.style.display = 'none';
                button.textContent = 'Show Result';
                button.className = 'btn';
            }
        }

        // Sidebar navigation
        document.querySelectorAll('.sidebar a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all links
                document.querySelectorAll('.sidebar a').forEach(l => l.classList.remove('active'));
                
                // Add active class to clicked link
                this.classList.add('active');
                
                // Update main content title
                const title = this.textContent;
                document.querySelector('h1').textContent = title;
                
                // Simple content update simulation
                const content = document.querySelector('.intro-text');
                content.textContent = `Welcome to the ${title} section. Here you'll learn everything you need to know about ${title.toLowerCase()}.`;
                
                // Scroll to top of content
                document.querySelector('.content').scrollTop = 0;
            });
        });

        // Enhanced search functionality
        document.querySelector('.search-box').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const query = this.value.trim();
                if (query) {
                    alert(`Searching for: "${query}"\n\nIn a real implementation, this would show search results.`);
                    // Simulate search highlighting
                    highlightSearchTerm(query);
                }
            }
        });

        function highlightSearchTerm(term) {
            // Simple search term highlighting simulation
            const content = document.querySelector('.content');
            const originalBg = content.style.backgroundColor;
            content.style.backgroundColor = 'rgba(63, 179, 237, 0.1)';
            
            setTimeout(() => {
                content.style.backgroundColor = originalBg;
            }, 1000);
        }

        // Progress bar animation
        function animateProgress() {
            const progressBar = document.querySelector('.progress-bar');
            let width = 0;
            const targetWidth = 65;
            
            const interval = setInterval(() => {
                if (width >= targetWidth) {
                    clearInterval(interval);
                } else {
                    width += 2;
                    progressBar.style.width = Math.min(width, targetWidth) + '%';
                }
            }, 50);
        }

        // Enhanced mobile menu functionality
        let mobileMenuOpen = false;
        document.querySelector('.logo').addEventListener('dblclick', function() {
            const navMenu = document.querySelector('.nav-menu');
            if (window.innerWidth <= 768) {
                if (mobileMenuOpen) {
                    navMenu.style.display = 'none';
                    mobileMenuOpen = false;
                } else {
                    navMenu.style.display = 'flex';
                    navMenu.style.flexDirection = 'column';
                    navMenu.style.position = 'absolute';
                    navMenu.style.top = '100%';
                    navMenu.style.left = '0';
                    navMenu.style.right = '0';
                    navMenu.style.backgroundColor = 'var(--accent-primary)';
                    navMenu.style.padding = '10px';
                    navMenu.style.zIndex = '999';
                    mobileMenuOpen = true;
                }
            }
        });

        // Listen for system theme changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
            if (e.matches && currentTheme === 'light') {
                toggleTheme();
            } else if (!e.matches && currentTheme === 'dark') {
                toggleTheme();
            }
        });

        // Initialize everything when page loads
        window.addEventListener('load', function() {
            initTheme();
            animateProgress();
            
            // Add some interactive feedback
            console.log('W3Schools Clone loaded successfully!');
            console.log('Theme system active - toggle with the button in the header');
        });

        // Add keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + Shift + T to toggle theme
            if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'T') {
                e.preventDefault();
                toggleTheme();
            }
            
            // Ctrl/Cmd + K to focus search
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                document.querySelector('.search-box').focus();
            }
        });
    </script>
</body>
</html>