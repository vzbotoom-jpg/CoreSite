{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#FFFFFF">
    <title>@yield('title', 'Dashboard') - {{ config('app.name', 'CoreSite') }}</title>
    
    <!-- ============================================ -->
    <!-- ANTI-FLICKER SCRIPT - 100% AUTO FOLLOW CHROME -->
    <!-- ============================================ -->
    <script>
        (function() {
            // Detect Chrome theme preference IMMEDIATELY
            // No localStorage, no manual override - purely follows system
            const isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            
            // Apply class BEFORE any CSS renders
            if (isDark) {
                document.documentElement.classList.add('dark');
                const meta = document.querySelector('meta[name="theme-color"]');
                if (meta) meta.content = '#0A0B0E';
            } else {
                document.documentElement.classList.remove('dark');
                const meta = document.querySelector('meta[name="theme-color"]');
                if (meta) meta.content = '#FFFFFF';
            }
        })();
    </script>
    <!-- ============================================ -->
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/css/components.css'])
    @stack('styles')
</head>
<body class="bg-light-bg dark:bg-dark-bg antialiased transition-colors duration-200">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        @include('layouts.partials.sidebar')
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            @include('layouts.partials.top-nav')
            
            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                <!-- Breadcrumb -->
                @if(isset($breadcrumb))
                    @include('layouts.partials.breadcrumb', ['items' => $breadcrumb])
                @endif
                
                <!-- Alerts -->
                @if(session('success'))
                    <div class="mb-4 alert alert-success">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="mb-4 alert alert-error">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="mb-4 alert alert-error">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Global Loader -->
    <div id="global-loader" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
        <div class="spinner-lg"></div>
    </div>
    
    <!-- Scripts -->
    @vite(['resources/js/app.js', 'resources/js/bootstrap.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Theme Sync - Auto follow Chrome changes -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Listen for theme changes from Chrome
            const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
            
            // Update meta tag when theme changes
            mediaQuery.addEventListener('change', function(e) {
                const meta = document.querySelector('meta[name="theme-color"]');
                if (meta) {
                    meta.content = e.matches ? '#0A0B0E' : '#FFFFFF';
                }
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>