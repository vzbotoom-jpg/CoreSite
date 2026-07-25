<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#FFFFFF">
    <title>@yield('title') - {{ config('app.name', 'CoreSite') }}</title>
    
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
    <meta name="description" content="@yield('description', 'Dokumentasi lengkap CoreSite - Platform manajemen bisnis all-in-one untuk UMKM.')">
    <meta name="keywords" content="CoreSite, dokumentasi, manajemen produk, e-katalog, pos, kasir, UMKM">
    
    <!-- Open Graph -->
    <meta property="og:title" content="@yield('title') - {{ config('app.name', 'CoreSite') }}">
    <meta property="og:description" content="@yield('description', 'Dokumentasi lengkap CoreSite - Platform manajemen bisnis all-in-one untuk UMKM.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title') - {{ config('app.name', 'CoreSite') }}">
    <meta name="twitter:description" content="@yield('description', 'Dokumentasi lengkap CoreSite - Platform manajemen bisnis all-in-one untuk UMKM.')">
    
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
        <header class="border-b border-light-border/40 dark:border-dark-border/40 bg-light-bg/80 dark:bg-dark-bg/80 backdrop-blur-sm sticky top-0 z-50">
            <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <div class="flex items-center gap-4">
                        <a href="{{ route('landing') }}" class="flex items-center gap-2 group">
                            <div class="w-8 h-8 bg-accent rounded-lg flex items-center justify-center transition group-hover:scale-105">
                                <span class="text-white font-bold text-lg">C</span>
                            </div>
                            <span class="text-xl font-bold text-text-primary dark:text-text-dark-primary">CoreSite</span>
                            <span class="text-xs text-accent bg-accent/10 px-2 py-0.5 rounded-full">Docs</span>
                        </a>
                    </div>

                    <!-- Navigation - Desktop -->
                    <nav class="hidden md:flex items-center gap-6">
                        <a href="{{ route('docs.index') }}" class="text-sm font-medium text-accent border-b-2 border-accent pb-1">Documentation</a>
                        <a href="{{ route('landing') }}" class="text-sm font-medium text-text-secondary hover:text-text-primary dark:hover:text-text-dark-primary transition">Home</a>
                        <a href="{{ route('blog.index') }}" class="text-sm font-medium text-text-secondary hover:text-text-primary dark:hover:text-text-dark-primary transition">Blog</a>
                        <a href="{{ route('about') }}" class="text-sm font-medium text-text-secondary hover:text-text-primary dark:hover:text-text-dark-primary transition">About</a>
                        <a href="{{ route('contact') }}" class="text-sm font-medium text-text-secondary hover:text-text-primary dark:hover:text-text-dark-primary transition">Contact</a>
                    </nav>

                    <!-- Right Side -->
                    <div class="flex items-center gap-3">
                        <!-- Search Button (Mobile) -->
                        <button id="mobile-search-toggle" class="lg:hidden p-2 rounded-lg hover:bg-light-surface/50 dark:hover:bg-dark-surface/50 transition" aria-label="Search">
                            <svg class="w-5 h-5 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>

                        @auth
                            <a href="{{ route('admin.dashboard') }}" class="btn-primary text-sm px-4 py-2 hidden sm:inline-flex">
                                Buka Aplikasi
                            </a>
                            <a href="{{ route('admin.dashboard') }}" class="sm:hidden p-2 rounded-lg bg-accent text-white hover:opacity-80 transition" aria-label="Buka Aplikasi">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn-primary text-sm px-4 py-2 hidden sm:inline-flex">
                                Login
                            </a>
                            <a href="{{ route('login') }}" class="sm:hidden p-2 rounded-lg bg-accent text-white hover:opacity-80 transition" aria-label="Login">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                </svg>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <!-- Mobile Search Overlay -->
        <div id="mobile-search-overlay" class="fixed inset-0 z-40 bg-light-bg/95 dark:bg-dark-bg/95 backdrop-blur-sm lg:hidden hidden">
            <div class="p-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-text-primary dark:text-text-dark-primary">Cari Dokumentasi</h3>
                    <button id="mobile-search-close" class="p-2 rounded-lg hover:bg-light-surface/50 dark:hover:bg-dark-surface/50 transition" aria-label="Close search">
                        <svg class="w-6 h-6 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <form action="{{ route('docs.search') }}" method="GET">
                    <input 
                        type="text" 
                        name="q"
                        placeholder="Cari dokumentasi..." 
                        class="w-full px-4 py-3 bg-light-surface dark:bg-dark-surface/50 border border-light-border/40 dark:border-dark-border/40 rounded-lg text-text-primary dark:text-text-dark-primary placeholder:text-text-secondary/50 focus:ring-2 focus:ring-accent transition outline-none"
                        autofocus
                    >
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <main id="main-content" class="flex-1 max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12 w-full">
            <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
                <!-- Sidebar -->
                <aside class="lg:w-72 xl:w-80 flex-shrink-0" aria-label="Documentation navigation">
                    @include('layouts.partials.docs-sidebar')
                </aside>

                <!-- Content -->
                <div class="flex-1 min-w-0">
                    <!-- Page Header -->
                    <div class="mb-8">
                        <h1 class="text-3xl sm:text-4xl font-bold text-text-primary dark:text-text-dark-primary tracking-tight">
                            @yield('title')
                        </h1>
                        @hasSection('subtitle')
                            <p class="mt-2 text-text-secondary dark:text-text-dark-secondary text-lg">
                                @yield('subtitle')
                            </p>
                        @endif
                    </div>

                    <!-- Page Content -->
                    <div class="prose prose-slate dark:prose-invert max-w-none">
                        @yield('content')
                    </div>

                    <!-- Navigation (Previous/Next) -->
                    @if(isset($previous) || isset($next))
                        <nav class="mt-12 pt-8 border-t border-light-border/40 dark:border-dark-border/40 flex flex-col sm:flex-row justify-between gap-4" aria-label="Page navigation">
                            @if($previous)
                                <a href="{{ route('docs.show', $previous['slug']) }}" class="group flex items-center gap-2 text-sm text-text-secondary hover:text-text-primary dark:hover:text-text-dark-primary transition">
                                    <svg class="w-4 h-4 group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                    <span>
                                        <span class="block text-xs text-text-secondary/60">Previous</span>
                                        <span class="font-medium">{{ $previous['title'] }}</span>
                                    </span>
                                </a>
                            @else
                                <div></div>
                            @endif
                            
                            @if($next)
                                <a href="{{ route('docs.show', $next['slug']) }}" class="group flex items-center gap-2 text-sm text-text-secondary hover:text-text-primary dark:hover:text-text-dark-primary transition text-right">
                                    <span>
                                        <span class="block text-xs text-text-secondary/60">Next</span>
                                        <span class="font-medium">{{ $next['title'] }}</span>
                                    </span>
                                    <svg class="w-4 h-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            @endif
                        </nav>
                    @endif

                    <!-- Last Updated -->
                    @if(isset($lastUpdated))
                        <p class="mt-8 text-xs text-text-secondary/40">
                            Last updated: {{ $lastUpdated }}
                        </p>
                    @endif
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="border-t border-light-border/40 dark:border-dark-border/40 mt-8">
            <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <p class="text-sm text-text-secondary/70">
                         &copy; {{ date('Y') }} <span class="font-medium text-text-primary dark:text-text-dark-primary">CoreSite</span>. 
                    All rights reserved.
                    </p>
                    <div class="flex flex-wrap items-center justify-center gap-4 sm:gap-6 text-sm text-text-secondary/70">
                        <a href="{{ route('docs.show', 'introduction') }}" class="hover:text-text-primary dark:hover:text-text-dark-primary transition">Documentation</a>
                        <a href="{{ route('docs.show', 'support') }}" class="hover:text-text-primary dark:hover:text-text-dark-primary transition">Support</a>
                        <a href="{{ route('docs.show', 'security') }}" class="hover:text-text-primary dark:hover:text-text-dark-primary transition">Security</a>
                        <a href="{{ route('privacy') }}" class="hover:text-text-primary dark:hover:text-text-dark-primary transition">Privacy</a>
                        <a href="{{ route('terms') }}" class="hover:text-text-primary dark:hover:text-text-dark-primary transition">Terms</a>
                    </div>
                </div>
            </div>
        </footer>
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

        // ==================== MOBILE SEARCH ====================
        const searchToggle = document.getElementById('mobile-search-toggle');
        const searchOverlay = document.getElementById('mobile-search-overlay');
        const searchClose = document.getElementById('mobile-search-close');

        if (searchToggle && searchOverlay) {
            searchToggle.addEventListener('click', function() {
                searchOverlay.classList.remove('hidden');
                setTimeout(() => {
                    searchOverlay.querySelector('input')?.focus();
                }, 100);
            });
        }

        if (searchClose && searchOverlay) {
            searchClose.addEventListener('click', function() {
                searchOverlay.classList.add('hidden');
            });
        }

        // Close search overlay on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && searchOverlay && !searchOverlay.classList.contains('hidden')) {
                searchOverlay.classList.add('hidden');
            }
        });

        // ==================== KEYBOARD SHORTCUTS ====================
        document.addEventListener('keydown', function(e) {
            if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                e.preventDefault();
                const searchInput = document.querySelector('#docs-search');
                if (searchInput) {
                    searchInput.focus();
                } else {
                    if (searchToggle) {
                        searchToggle.click();
                    }
                }
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

        // ==================== ACTIVE NAVIGATION HIGHLIGHT ====================
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('nav a[href]');
            
            navLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href && currentPath.endsWith(href)) {
                    link.classList.add('text-accent', 'bg-accent/5', 'font-medium');
                }
            });
        });
    </script>
</body>
</html>