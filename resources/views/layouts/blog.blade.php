{{-- resources/views/layouts/blog.blade.php --}}
<!DOCTYPE html>
<html lang="id" class="{{ session('theme', 'light') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Blog') - {{ config('app.name', 'CoreSite') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css'])
    @stack('styles')
</head>
<body class="bg-light-bg dark:bg-dark-bg antialiased">
    <!-- Header -->
    <header class="border-b border-light-border/40 dark:border-dark-border/40 bg-light-bg/80 dark:bg-dark-bg/80 backdrop-blur-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="{{ route('landing') }}" class="flex items-center gap-2 group">
                    <div class="w-8 h-8 bg-accent rounded-lg flex items-center justify-center transition group-hover:scale-105">
                        <span class="text-white font-bold text-lg">C</span>
                    </div>
                    <span class="text-xl font-bold text-text-primary dark:text-text-dark-primary">CoreSite</span>
                </a>

                <!-- Navigation -->
                <nav class="hidden md:flex items-center gap-8">
                    <a href="{{ route('blog.index') }}" class="text-sm font-medium text-accent border-b-2 border-accent pb-1">Blog</a>
                    <a href="{{ route('landing') }}" class="text-sm font-medium text-text-secondary hover:text-text-primary dark:hover:text-text-dark-primary transition">Home</a>
                    <a href="{{ route('about') }}" class="text-sm font-medium text-text-secondary hover:text-text-primary dark:hover:text-text-dark-primary transition">About</a>
                    <a href="{{ route('contact') }}" class="text-sm font-medium text-text-secondary hover:text-text-primary dark:hover:text-text-dark-primary transition">Contact</a>
                </nav>

                <!-- Right Side -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('register') }}" class="btn-primary text-sm px-4 py-2">
                        Mulai Sekarang
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
            <!-- Left Column: Sidebar (3 kolom) -->
            <div class="lg:col-span-3">
                @include('layouts.partials.blog-sidebar')
            </div>

            <!-- Right Column: Content (9 kolom) -->
            <div class="lg:col-span-9">
                @yield('content')
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-light-border/40 dark:border-dark-border/40 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-text-secondary/70">
                     &copy; {{ date('Y') }} <span class="font-medium text-text-primary dark:text-text-dark-primary">CoreSite</span>. 
                    All rights reserved.
                </p>
                <div class="flex items-center gap-6 text-sm text-text-secondary/70">
                    <a href="{{ route('privacy') }}" class="hover:text-text-primary dark:hover:text-text-dark-primary transition">Privacy</a>
                    <a href="{{ route('terms') }}" class="hover:text-text-primary dark:hover:text-text-dark-primary transition">Terms</a>
                    <a href="{{ route('contact') }}" class="hover:text-text-primary dark:hover:text-text-dark-primary transition">Contact</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    @vite(['resources/js/app.js'])
    <script>
        document.getElementById('theme-toggle')?.addEventListener('click', function() {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
        });

        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
    @stack('scripts')
</body>
</html>