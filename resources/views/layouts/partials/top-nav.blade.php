{{-- resources/views/layouts/partials/top-nav.blade.php --}}
<nav class="bg-light-bg dark:bg-dark-bg border-b border-light-border dark:border-dark-border px-6 py-3 transition-colors duration-200">
    <div class="flex justify-between items-center">
        <!-- Mobile Menu Button -->
        <button id="mobileMenuBtn" class="lg:hidden p-2 rounded-lg hover:bg-light-surface dark:hover:bg-dark-surface transition-colors" aria-label="Toggle mobile menu">
            <svg class="w-6 h-6 text-text-primary dark:text-text-dark-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
        
        <!-- Page Title -->
        <h1 class="text-xl font-semibold text-text-primary dark:text-text-dark-primary transition-colors duration-200">
            @yield('page-title', 'Dashboard')
        </h1>
        
        <!-- Right Side -->
        <div class="flex items-center gap-4">
            <!-- Theme Indicator (READ ONLY - shows current theme) -->
            
            <!-- Notifications -->
            <div class="relative dropdown">
                <button class="p-2 rounded-lg hover:bg-light-surface dark:hover:bg-dark-surface transition-colors text-text-primary dark:text-text-dark-primary relative group" aria-label="Notifications">
                    <svg class="w-5 h-5 group-hover:text-accent transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-error rounded-full animate-pulse"></span>
                </button>
                <div class="dropdown-menu hidden min-w-[280px]">
                    <div class="p-3 border-b border-light-border dark:border-dark-border">
                        <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Notifikasi</h3>
                        <p class="text-xs text-text-secondary dark:text-text-dark-secondary">Belum ada notifikasi baru</p>
                    </div>
                    <div class="max-h-64 overflow-y-auto">
                        <div class="dropdown-item text-sm text-text-secondary dark:text-text-dark-secondary hover:text-text-primary dark:hover:text-text-dark-primary">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 bg-accent rounded-full"></div>
                                <div>
                                    <p class="font-medium text-text-primary dark:text-text-dark-primary">Selamat datang!</p>
                                    <p class="text-xs text-text-secondary dark:text-text-dark-secondary">Mulai kelola toko Anda sekarang</p>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-item text-sm text-text-secondary dark:text-text-dark-secondary hover:text-text-primary dark:hover:text-text-dark-primary">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 bg-warning rounded-full"></div>
                                <div>
                                    <p class="font-medium text-text-primary dark:text-text-dark-primary">Tips: Kelola Stok</p>
                                    <p class="text-xs text-text-secondary dark:text-text-dark-secondary">Periksa stok produk Anda</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-3 border-t border-light-border dark:border-dark-border text-center">
                        <a href="#" class="text-sm text-accent hover:text-accent-hover transition-colors">
                            Lihat semua notifikasi
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Settings -->
            <a href="{{ route('admin.settings.index') }}" 
               class="p-2 rounded-lg hover:bg-light-surface dark:hover:bg-dark-surface transition-colors text-text-primary dark:text-text-dark-primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                </svg>
            </a>
            
            <!-- User Profile -->
            <div class="relative dropdown">
                <button class="flex items-center gap-2 p-1 rounded-lg hover:bg-light-surface dark:hover:bg-dark-surface transition-colors group">
                    <div class="w-8 h-8 bg-accent/10 rounded-full flex items-center justify-center">
                        <span class="text-accent font-semibold text-sm">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </span>
                    </div>
                    <svg class="w-4 h-4 text-text-secondary dark:text-text-dark-secondary group-hover:text-accent transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="dropdown-menu hidden min-w-[200px]">
                    <div class="p-3 border-b border-light-border dark:border-dark-border">
                        <p class="font-medium text-text-primary dark:text-text-dark-primary">{{ auth()->user()->name ?? 'User' }}</p>
                        <p class="text-xs text-text-secondary dark:text-text-dark-secondary">{{ auth()->user()->email ?? '' }}</p>
                    </div>
                    <a href="{{ route('admin.settings.index') }}" class="dropdown-item flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        </svg>
                        Pengaturan
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item w-full text-left flex items-center gap-2 text-error hover:text-error/80">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ============================================
        // MOBILE MENU TOGGLE
        // ============================================
        const mobileBtn = document.getElementById('mobileMenuBtn');
        const sidebar = document.querySelector('aside');
        
        if (mobileBtn && sidebar) {
            mobileBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                sidebar.classList.toggle('-translate-x-full');
                
                // Update button icon
                const isOpen = !sidebar.classList.contains('-translate-x-full');
                this.innerHTML = isOpen
                    ? `<svg class="w-6 h-6 text-text-primary dark:text-text-dark-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                       </svg>`
                    : `<svg class="w-6 h-6 text-text-primary dark:text-text-dark-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                       </svg>`;
            });
        }
        
        // ============================================
        // DROPDOWN MENUS
        // ============================================
        document.querySelectorAll('.dropdown').forEach(dropdown => {
            const btn = dropdown.querySelector('button:first-child');
            const menu = dropdown.querySelector('.dropdown-menu');
            
            if (btn && menu) {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    
                    // Close other dropdowns
                    document.querySelectorAll('.dropdown-menu').forEach(m => {
                        if (m !== menu) m.classList.add('hidden');
                    });
                    
                    menu.classList.toggle('hidden');
                });
            }
        });
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function() {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.add('hidden');
            });
        });
        
        // Close dropdowns on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.classList.add('hidden');
                });
            }
        });
        
        // ============================================
        // RESPONSIVE: Close sidebar on window resize
        // ============================================
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                if (window.innerWidth >= 1024 && sidebar) {
                    sidebar.classList.add('-translate-x-full');
                    
                    // Reset mobile button
                    if (mobileBtn) {
                        mobileBtn.innerHTML = `<svg class="w-6 h-6 text-text-primary dark:text-text-dark-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>`;
                    }
                }
            }, 250);
        });
    });
</script>

<style>
    /* Dropdown animation */
    .dropdown-menu {
        transition: opacity 0.2s ease, transform 0.2s ease;
        transform-origin: top right;
        opacity: 0;
        transform: scale(0.95);
    }
    
    .dropdown-menu:not(.hidden) {
        opacity: 1;
        transform: scale(1);
    }
</style>