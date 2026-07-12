{{-- resources/views/layouts/catalog.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#FFFFFF">
    <title>@yield('title') - {{ config('app.name', 'CoreSite') }}</title>
    
    <!-- ============================================ -->
    <!-- ANTI-FLICKER SCRIPT - 100% AUTO FOLLOW CHROME -->
    <!-- ============================================ -->
    <script>
        (function() {
            // Detect Chrome theme preference IMMEDIATELY
            const isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            
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
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/css/components.css'])
    @stack('styles')
</head>
<body class="bg-light-bg dark:bg-dark-bg text-text-primary dark:text-text-dark-primary antialiased transition-colors duration-200">
    <!-- Catalog Navigation -->
    @include('layouts.partials.catalog-nav')
    
    <!-- Main Content -->
    <main id="catalog-app" class="min-h-screen">
        @yield('content')
    </main>
    
    <!-- Footer -->
    @include('layouts.partials.catalog-footer')
    
    @vite(['resources/js/app.js', 'resources/js/bootstrap.js', 'resources/js/catalog.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</body>
</html>