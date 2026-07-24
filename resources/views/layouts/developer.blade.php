{{-- resources/views/layouts/developer.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#FFFFFF">
    <title>@yield('title', 'Developer') - {{ config('app.name', 'CoreSite') }}</title>
    
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

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/css/components.css'])
    
    <!-- Essential libraries for developer dashboard -->
    <script src="https://cdn.jsdelivr.net/npm/axios@1.6.2/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @stack('styles')
</head>
<body class="bg-light-bg dark:bg-dark-bg">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        @include('layouts.partials.developer-sidebar')

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navbar -->
            <header class="bg-white dark:bg-dark-bg border-b border-light-border dark:border-dark-border px-6 py-3 flex items-center justify-between flex-shrink-0">
                <div class="flex items-center gap-4">
                    <!-- Mobile Sidebar Toggle -->
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-text-secondary hover:text-text-primary transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    
                    <!-- Page Title -->
                    <div>
                        <h1 class="text-lg font-semibold text-text-primary dark:text-text-dark-primary">
                            @yield('page-title', 'Developer Dashboard')
                        </h1>
                        @hasSection('sub-title')
                        <p class="text-xs text-text-secondary dark:text-text-dark-secondary">@yield('sub-title')</p>
                        @endif
                    </div>
                </div>

                <!-- Right Side -->
                <div class="flex items-center gap-4">
                    <!-- Search (Optional) -->
                    <div class="hidden md:flex items-center gap-2 bg-light-surface dark:bg-dark-surface rounded-lg px-3 py-1.5 border border-light-border dark:border-dark-border">
                        <svg class="w-4 h-4 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" placeholder="Search..." class="bg-transparent border-none focus:outline-none text-sm text-text-primary dark:text-text-dark-primary w-32 lg:w-48">
                    </div>

                    <!-- System Status -->
                    <div class="hidden sm:flex items-center gap-2">
                        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="text-xs text-text-secondary">System Online</span>
                    </div>

                    <!-- User Profile -->
                    <div class="flex items-center gap-3">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-medium text-text-primary dark:text-text-dark-primary">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-text-secondary">Developer</p>
                        </div>
                        <div class="w-9 h-9 bg-accent/10 rounded-full flex items-center justify-center text-accent font-semibold text-sm ring-2 ring-accent/20">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-text-secondary hover:text-error transition" title="Logout">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-4 md:p-6 bg-light-bg dark:bg-dark-bg">
                <!-- Breadcrumb -->
                @hasSection('breadcrumb')
                <nav class="text-sm text-text-secondary mb-4">
                    @yield('breadcrumb')
                </nav>
                @endif

                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-white dark:bg-dark-bg border-t border-light-border dark:border-dark-border px-6 py-3 flex-shrink-0">
                <div class="flex flex-wrap justify-between items-center gap-3 text-xs text-text-secondary">
                    <div class="flex items-center gap-3">
                        <span class="font-medium text-text-primary dark:text-text-dark-primary">CoreSite</span>
                        <span>Developer Panel v{{ config('app.version', '1.0.0') }}</span>
                    </div>
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="flex items-center gap-1">
                            <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>
                            PHP {{ phpversion() }}
                        </span>
                        <span class="hidden sm:inline">|</span>
                        <span class="flex items-center gap-1">
                            <span class="w-1.5 h-1.5 bg-purple-500 rounded-full"></span>
                            Laravel {{ app()->version() }}
                        </span>
                        <span class="hidden sm:inline">|</span>
                        <span class="flex items-center gap-1">
                            <span class="w-1.5 h-1.5 {{ app()->environment() === 'production' ? 'bg-green-500' : 'bg-yellow-500' }} rounded-full"></span>
                            {{ ucfirst(app()->environment()) }}
                        </span>
                        <span class="hidden sm:inline">|</span>
                        <span class="flex items-center gap-1">
                            <span class="w-1.5 h-1.5 {{ config('app.debug') ? 'bg-red-500' : 'bg-green-500' }} rounded-full"></span>
                            Debug: {{ config('app.debug') ? 'On' : 'Off' }}
                        </span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Alpine.js untuk sidebar toggle -->
    <script>
        // Define showToast globally before inline scripts use it
        window.showToast = (message, type = 'success', duration = 3000) => {
            const existingToast = document.querySelector('.toast-notification');
            if (existingToast) existingToast.remove();
            
            const toast = document.createElement('div');
            toast.className = 'toast-notification';
            
            const typeClasses = {
                success: 'bg-green-500 text-white',
                error: 'bg-red-500 text-white',
                warning: 'bg-yellow-500 text-black',
                info: 'bg-blue-500 text-white'
            };
            
            const icons = {
                success: '✓',
                error: '✕',
                warning: '!',
                info: 'ℹ'
            };
            
            toast.innerHTML = `
                <div class="${typeClasses[type] || typeClasses.info} px-6 py-4 rounded-lg shadow-lg flex items-center gap-3">
                    <span class="text-xl font-bold">${icons[type] || icons.info}</span>
                    <span>${message}</span>
                </div>
            `;
            
            toast.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; max-width: 500px;';
            document.body.appendChild(toast);
            
            setTimeout(() => {
                if (toast.parentElement) toast.remove();
            }, duration);
        };
        
        document.addEventListener('alpine:init', () => {
            Alpine.data('developerLayout', () => ({
                sidebarOpen: window.innerWidth >= 1024,
                init() {
                    window.addEventListener('resize', () => {
                        if (window.innerWidth >= 1024) {
                            this.sidebarOpen = true;
                        }
                    });
                }
            }))
        })
    </script>
    
    @vite(['resources/js/app.js', 'resources/js/bootstrap.js'])
    @stack('scripts')
</body>
</html>