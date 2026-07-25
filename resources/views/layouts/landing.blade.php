<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#FFFFFF">
    <title>@yield('title', config('app.name', 'CoreSite')) - {{ config('app.name', 'CoreSite') }}</title>
    
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

    <!-- SEO Meta -->
    <meta name="description" content="@yield('description', 'CoreSite - Platform toko online dan kasir otomatis untuk UMKM Indonesia.')">
    <meta name="keywords" content="CoreSite, toko online, kasir, UMKM, e-commerce, manajemen bisnis">
    
    <!-- Open Graph -->
    <meta property="og:title" content="@yield('title', config('app.name', 'CoreSite')) - {{ config('app.name', 'CoreSite') }}">
    <meta property="og:description" content="@yield('description', 'CoreSite - Platform toko online dan kasir otomatis untuk UMKM Indonesia.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', config('app.name', 'CoreSite')) - {{ config('app.name', 'CoreSite') }}">
    <meta name="twitter:description" content="@yield('description', 'CoreSite - Platform toko online dan kasir otomatis untuk UMKM Indonesia.')">
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css'])
    
    @stack('styles')
</head>
<body class="bg-light-bg dark:bg-dark-bg antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- Skip to content -->
        <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:px-4 focus:py-2 focus:bg-accent focus:text-white focus:rounded-lg">
            Skip to content
        </a>

        <!-- Header/Navbar -->
        <header class="border-b border-light-border dark:border-dark-border bg-light-bg dark:bg-dark-bg sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                        <div class="w-8 h-8 bg-accent rounded-lg flex items-center justify-center transition group-hover:scale-105">
                            <span class="text-white font-bold text-lg">C</span>
                        </div>
                        <span class="text-xl font-bold text-text-primary dark:text-text-dark-primary">CoreSite</span>
                    </a>

                    <!-- Navigation - Desktop -->
                    <nav class="hidden md:flex items-center gap-8">
                        <a href="{{ route('features') }}" class="text-sm font-medium text-text-secondary hover:text-text-primary dark:hover:text-text-dark-primary transition">Fitur</a>
                        <a href="{{ route('pricing') }}" class="text-sm font-medium text-text-secondary hover:text-text-primary dark:hover:text-text-dark-primary transition">Harga</a>
                        <a href="{{ route('about') }}" class="text-sm font-medium text-text-secondary hover:text-text-primary dark:hover:text-text-dark-primary transition">Tentang</a>
                        <a href="{{ route('blog.index') }}" class="text-sm font-medium text-text-secondary hover:text-text-primary dark:hover:text-text-dark-primary transition">Blog</a>
                        <a href="{{ route('contact') }}" class="text-sm font-medium text-text-secondary hover:text-text-primary dark:hover:text-text-dark-primary transition">Kontak</a>
                    </nav>

                    <!-- Right Side -->
                    <div class="flex items-center gap-4">
                        @auth
                            <a href="{{ route('admin.dashboard') }}" class="btn-primary text-sm px-4 py-2 hidden sm:inline-flex">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-text-secondary hover:text-text-primary dark:hover:text-text-dark-primary transition hidden sm:inline-block">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="btn-primary text-sm px-4 py-2 hidden sm:inline-flex">
                                Daftar
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <!-- Mobile Menu Overlay -->
        <div id="mobile-menu-overlay" class="fixed inset-0 z-40 bg-light-bg/95 dark:bg-dark-bg/95 backdrop-blur-sm md:hidden hidden">
            <div class="p-4">
                <div class="flex justify-end mb-4">
                    <button id="mobile-menu-close" class="p-2 rounded-lg hover:bg-light-surface/50 dark:hover:bg-dark-surface/50 transition" aria-label="Close menu">
                        <svg class="w-6 h-6 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <nav class="flex flex-col gap-4">
                    <a href="{{ route('features') }}" class="text-lg font-medium text-text-primary dark:text-text-dark-primary hover:text-accent transition">Fitur</a>
                    <a href="{{ route('pricing') }}" class="text-lg font-medium text-text-primary dark:text-text-dark-primary hover:text-accent transition">Harga</a>
                    <a href="{{ route('about') }}" class="text-lg font-medium text-text-primary dark:text-text-dark-primary hover:text-accent transition">Tentang</a>
                    <a href="{{ route('blog.index') }}" class="text-lg font-medium text-text-primary dark:text-text-dark-primary hover:text-accent transition">Blog</a>
                    <a href="{{ route('contact') }}" class="text-lg font-medium text-text-primary dark:text-text-dark-primary hover:text-accent transition">Kontak</a>
                    <hr class="border-light-border/40 dark:border-dark-border/40">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="btn-primary text-center text-sm px-4 py-2">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-lg font-medium text-text-primary dark:text-text-dark-primary hover:text-accent transition">Login</a>
                        <a href="{{ route('register') }}" class="btn-primary text-center text-sm px-4 py-2">Daftar</a>
                    @endauth
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <main id="main-content" class="flex-1">
            @yield('content')
        </main>

        <!-- Floating Chat Widget -->
        <div class="coresite-chat-widget" id="coresite-chat-widget">
            <div class="coresite-chat-panel coresite-chat-hidden" id="coresite-chat-panel" role="dialog" aria-label="CoreSite AI chat panel">
                <div class="coresite-chat-panel-header">
                    <div class="coresite-chat-panel-title">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M8 10h8M8 14h5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M4 5.75C4 4.231 5.231 3 6.75 3h10.5C18.769 3 20 4.231 20 5.75v12.5c0 1.519-1.231 2.75-2.75 2.75H8.5L4 22V5.75Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        CoreSite AI
                    </div>
                    <button type="button" class="coresite-chat-panel-close" id="coresite-chat-close" aria-label="Tutup chat">×</button>
                </div>
                <div class="coresite-chat-panel-body">
                    <p>Ada pertanyaan seputar CoreSite? Klik tombol chat untuk memulai. AI kami siap membantu ide produk, fitur, dan panduan penggunaan.</p>
                </div>
            </div>

            <button type="button" class="coresite-chat-button" id="coresite-chat-toggle" aria-label="Buka chat CoreSite AI">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M4 4h16v12H7l-3 3V4Z" fill="currentColor"/>
                    <path d="M8.5 9.5h7M8.5 12.5h4" stroke="#fff" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
            </button>
        </div>

        <!-- Footer -->
        @include('layouts.partials.footer')
    </div>

    @stack('scripts')
    
    <script>
        // ==================== THEME SYNC ====================
        function syncThemeIcons(isDark) {
            const icon = document.getElementById('theme-icon');
            if (icon) {
                if (isDark) {
                    icon.setAttribute('d', 'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z');
                } else {
                    icon.setAttribute('d', 'M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z');
                }
            }
        }

        // Initial sync
        syncThemeIcons(document.documentElement.classList.contains('dark'));

        // Dynamic observer
        const mqTheme = window.matchMedia('(prefers-color-scheme: dark)');
        mqTheme.addEventListener('change', function(e) {
            syncThemeIcons(e.matches);
        });

        // ==================== MOBILE MENU ====================
        const menuToggle = document.getElementById('mobile-menu-toggle');
        const menuOverlay = document.getElementById('mobile-menu-overlay');
        const menuClose = document.getElementById('mobile-menu-close');

        if (menuToggle && menuOverlay) {
            menuToggle.addEventListener('click', function() {
                menuOverlay.classList.remove('hidden');
            });
        }

        if (menuClose && menuOverlay) {
            menuClose.addEventListener('click', function() {
                menuOverlay.classList.add('hidden');
            });
        }

        // Close menu on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && menuOverlay && !menuOverlay.classList.contains('hidden')) {
                menuOverlay.classList.add('hidden');
            }
        });

        // ==================== SMOOTH SCROLL ====================
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href === '#') return;
                
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    history.pushState(null, null, href);
                }
            });
        });

        // ==================== CORE SITE CHAT WIDGET ====================
        const chatToggle = document.getElementById('coresite-chat-toggle');
        const chatPanel = document.getElementById('coresite-chat-panel');
        const chatClose = document.getElementById('coresite-chat-close');

        if (chatToggle && chatPanel) {
            chatToggle.addEventListener('click', () => {
                chatPanel.classList.toggle('coresite-chat-hidden');
            });
        }

        if (chatClose && chatPanel) {
            chatClose.addEventListener('click', () => {
                chatPanel.classList.add('coresite-chat-hidden');
            });
        }
    </script>
</body>
</html>