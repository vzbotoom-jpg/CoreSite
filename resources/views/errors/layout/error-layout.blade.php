{{-- resources/views/errors/layout/error-layout.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ config('app.name', 'CoreSite') }}</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            background: #f8f9fa;
            color: #1a1c23;
        }
        
        .dark body {
            background: #0A0B0E;
            color: #ffffff;
        }
        
        .error-container {
            max-width: 480px;
            width: 100%;
            text-align: center;
        }
        
        .error-logo {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 2rem;
            text-decoration: none;
        }
        
        .error-logo .logo-icon {
            width: 44px;
            height: 44px;
            background: #00D27A;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 22px;
        }
        
        .error-logo .logo-text {
            font-size: 24px;
            font-weight: 700;
            color: #1a1c23;
        }
        
        .dark .error-logo .logo-text {
            color: #ffffff;
        }
        
        .error-code {
            font-size: 96px;
            font-weight: 800;
            line-height: 1;
            background: linear-gradient(135deg, #00D27A 0%, #00B868 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }
        
        .error-message {
            font-size: 28px;
            font-weight: 700;
            color: #1a1c23;
            margin-bottom: 0.75rem;
        }
        
        .dark .error-message {
            color: #ffffff;
        }
        
        .error-description {
            font-size: 16px;
            color: #6C757D;
            line-height: 1.6;
            margin-bottom: 2rem;
        }
        
        .dark .error-description {
            color: #A0A5B0;
        }
        
        .error-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            justify-content: center;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
            border: 1px solid transparent;
            cursor: pointer;
        }
        
        .btn-primary {
            background: #00D27A;
            color: white;
            border-color: #00D27A;
        }
        
        .btn-primary:hover {
            background: #00B868;
            border-color: #00B868;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 210, 122, 0.3);
        }
        
        .btn-secondary {
            background: transparent;
            border-color: #E9ECEF;
            color: #1a1c23;
        }
        
        .dark .btn-secondary {
            border-color: #2C2F36;
            color: #ffffff;
        }
        
        .btn-secondary:hover {
            background: #F8F9FA;
            border-color: #00D27A;
            color: #00D27A;
        }
        
        .dark .btn-secondary:hover {
            background: #1A1C23;
            border-color: #00D27A;
            color: #00D27A;
        }
        
        .error-help {
            margin-top: 2rem;
            font-size: 14px;
            color: #6C757D;
        }
        
        .dark .error-help {
            color: #A0A5B0;
        }
        
        .error-help a {
            color: #00D27A;
            text-decoration: none;
        }
        
        .error-help a:hover {
            text-decoration: underline;
        }
        
        /* Illustration */
        .error-illustration {
            margin-bottom: 1.5rem;
        }
        
        .error-illustration svg {
            max-width: 180px;
            height: auto;
        }
        
        /* Animations */
        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }
        
        .error-illustration {
            animation: float 3s ease-in-out infinite;
        }
        
        @media (max-width: 640px) {
            .error-code {
                font-size: 72px;
            }
            .error-message {
                font-size: 22px;
            }
            .error-actions {
                flex-direction: column;
                align-items: center;
            }
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="error-logo">
            <div class="logo-icon">C</div>
            <span class="logo-text">CoreSite</span>
        </a>
        
        <!-- Illustration -->
        <div class="error-illustration">
            @yield('illustration')
        </div>
        
        <!-- Error Code -->
        <div class="error-code">@yield('code')</div>
        
        <!-- Message -->
        <h1 class="error-message">@yield('message')</h1>
        
        <!-- Description -->
        <p class="error-description">@yield('description')</p>
        
        <!-- Actions -->
        <div class="error-actions">
            @yield('actions')
        </div>
        
        <!-- Help -->
        <p class="error-help">
            Butuh bantuan? <a href="mailto:support@coresite.com">Hubungi Support</a>
        </p>
    </div>
    
    <script>
        // Detect system preference for dark mode
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.documentElement.classList.add('dark');
        }
        
        // Listen for system preference changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
            if (e.matches) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        });
    </script>
</body>
</html>