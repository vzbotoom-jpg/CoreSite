{{-- resources/views/layouts/partials/sidebar.blade.php --}}
<aside class="w-64 bg-light-bg dark:bg-dark-bg border-r border-light-border dark:border-dark-border flex flex-col h-screen sticky top-0">
    <!-- Logo -->
    <div class="p-6 border-b border-light-border dark:border-dark-border">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
            <div class="w-8 h-8 bg-accent rounded-lg flex items-center justify-center">
                <span class="text-white font-bold text-lg">C</span>
            </div>
            <span class="text-xl font-bold text-text-primary dark:text-text-dark-primary">CoreSite</span>
        </a>
    </div>
    
    <!-- Navigation -->
    <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'sidebar-link-active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span>Dashboard</span>
        </a>
        
        <!-- Manajemen -->
        <div class="pt-4 pb-2">
            <p class="text-[10px] font-semibold text-text-secondary uppercase tracking-wider px-3">Manajemen</p>
        </div>
        
        <a href="{{ route('admin.products.index') }}" class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'sidebar-link-active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            <span>Produk</span>
            <span class="ml-auto text-xs bg-accent/10 text-accent px-2 py-0.5 rounded-full">Stok</span>
        </a>
        
        <a href="{{ route('admin.transactions.index') }}" class="sidebar-link {{ request()->routeIs('admin.transactions.*') ? 'sidebar-link-active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <span>Transaksi</span>
        </a>
        
        <!-- Laporan -->
        <div class="pt-4 pb-2">
            <p class="text-[10px] font-semibold text-text-secondary uppercase tracking-wider px-3">Laporan</p>
        </div>
        
        <a href="{{ route('admin.reports.index') }}" class="sidebar-link {{ request()->routeIs('admin.reports.*') ? 'sidebar-link-active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            <span>Laporan</span>
        </a>
        
        <!-- Pengaturan dengan Sub-menu -->
        <div class="pt-4 pb-2">
            <p class="text-[10px] font-semibold text-text-secondary uppercase tracking-wider px-3">Pengaturan</p>
        </div>
        
        <!-- Settings Parent (with dropdown) -->
        <div x-data="{ open: {{ request()->routeIs('admin.settings.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" 
                    class="sidebar-link w-full text-left {{ request()->routeIs('admin.settings.*') ? 'sidebar-link-active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                </svg>
                <span>Pengaturan</span>
                <svg class="w-4 h-4 ml-auto transition-transform duration-200" 
                     :class="open ? 'rotate-180' : ''" 
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            
            <!-- Sub-menu -->
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="ml-4 space-y-1 mt-1">
                
                <a href="{{ route('admin.settings.profile') }}" 
                   class="sidebar-link text-sm {{ request()->routeIs('admin.settings.profile') ? 'sidebar-link-active' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span>Profil</span>
                </a>
                
                <a href="{{ route('admin.settings.users') }}" 
                   class="sidebar-link text-sm {{ request()->routeIs('admin.settings.users') ? 'sidebar-link-active' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span>User</span>
                </a>
                
                <a href="{{ route('admin.settings.payment') }}" 
                   class="sidebar-link text-sm {{ request()->routeIs('admin.settings.payment') ? 'sidebar-link-active' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    <span>Pembayaran</span>
                </a>
                
                <a href="{{ route('admin.settings.notification') }}" 
                   class="sidebar-link text-sm {{ request()->routeIs('admin.settings.notification') ? 'sidebar-link-active' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span>Notifikasi</span>
                </a>
            </div>
        </div>
        
        <!-- Developer Section (Only for developer role) -->
        @if(auth()->user()->hasRole('developer') ?? false)
        <div class="pt-4 pb-2">
            <p class="text-[10px] font-semibold text-text-secondary uppercase tracking-wider px-3">Developer</p>
        </div>
        
        <a href="{{ route('developer.dashboard') }}" class="sidebar-link {{ request()->routeIs('developer.*') ? 'sidebar-link-active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
            </svg>
            <span>Developer</span>
        </a>
        @endif
    </nav>
    
    <!-- User Info -->
    <div class="p-4 border-t border-light-border dark:border-dark-border bg-light-surface/50 dark:bg-dark-surface/50">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-accent/10 rounded-full flex items-center justify-center flex-shrink-0">
                <span class="text-accent font-semibold text-lg">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-text-primary dark:text-text-dark-primary truncate">
                    {{ auth()->user()->name ?? 'User' }}
                </p>
                <p class="text-xs text-text-secondary truncate">
                    {{ auth()->user()->store->name ?? 'Store' }}
                </p>
            </div>
            <button onclick="document.getElementById('logout-form').submit()" 
                    class="p-2 rounded-lg text-text-secondary hover:text-error hover:bg-error/10 transition-colors"
                    title="Logout">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
            </button>
            <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
                @csrf
            </form>
        </div>
    </div>
</aside>

<style>
    /* Scrollbar styling for sidebar */
    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.65rem 0.875rem;
        border-radius: 0.5rem;
        transition: all 0.2s ease;
        color: var(--color-text-secondary);
        font-size: 0.875rem;
    }

    .sidebar-link:hover {
        background-color: rgba(0, 210, 122, 0.08);
        color: var(--color-accent);
    }

    .dark .sidebar-link {
        color: var(--color-text-dark-secondary);
    }

    .dark .sidebar-link:hover {
        background-color: rgba(0, 210, 122, 0.12);
        color: var(--color-accent);
    }

    .sidebar-link-active {
        background-color: rgba(0, 210, 122, 0.1);
        color: var(--color-accent);
    }

    .dark .sidebar-link-active {
        background-color: rgba(0, 210, 122, 0.15);
        color: var(--color-accent);
    }

    /* Scrollbar */
    nav::-webkit-scrollbar {
        width: 4px;
    }

    nav::-webkit-scrollbar-track {
        background: transparent;
    }

    nav::-webkit-scrollbar-thumb {
        background: var(--color-light-border);
        border-radius: 2px;
    }

    .dark nav::-webkit-scrollbar-thumb {
        background: var(--color-dark-border);
    }

    nav::-webkit-scrollbar-thumb:hover {
        background: var(--color-accent);
    }
</style>