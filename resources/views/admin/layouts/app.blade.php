{{-- resources/views/admin/layouts/app.blade.php --}}
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
            const mq = window.matchMedia('(prefers-color-scheme: dark)');
            function applyTheme(isDark) {
                if (isDark) {
                    document.documentElement.classList.add('dark');
                    const meta = document.querySelector('meta[name="theme-color"]');
                    if (meta) meta.content = '#0A0B0E';
                } else {
                    document.documentElement.classList.remove('dark');
                    const meta = document.querySelector('meta[name="theme-color"]');
                    if (meta) meta.content = '#FFFFFF';
                }
            }
            applyTheme(mq.matches);
            mq.addEventListener('change', function(e) {
                applyTheme(e.matches);
            });
        })();
    </script>
    <!-- ============================================ -->

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css'])
    @stack('styles')
</head>
<body class="bg-light-surface dark:bg-dark-surface antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        @include('admin.layouts.sidebar')
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            @include('admin.layouts.top-nav')
            
            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-success/10 border border-success/20 text-success rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="mb-4 p-4 bg-error/10 border border-error/20 text-error rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Scripts -->
    @vite(['resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @stack('scripts')
</body>
</html>