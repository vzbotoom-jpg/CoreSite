{{-- resources/views/admin/layouts/sidebar.blade.php --}}
<aside class="w-64 bg-light-bg dark:bg-dark-bg border-r border-light-border dark:border-dark-border flex flex-col">
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
    <nav class="flex-1 px-4 py-6 space-y-1">
        <x-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')" icon="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
            Dashboard
        </x-nav-link>
        
        <x-nav-link href="{{ route('admin.products.index') }}" :active="request()->routeIs('admin.products.*')" icon="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
            Produk
        </x-nav-link>
        
        <x-nav-link href="{{ route('admin.transactions.index') }}" :active="request()->routeIs('admin.transactions.*')" icon="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
            Transaksi
        </x-nav-link>
        
        <x-nav-link href="{{ route('admin.reports.index') }}" :active="request()->routeIs('admin.reports.*')" icon="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
            Laporan
        </x-nav-link>
        
        <x-nav-link href="{{ route('admin.settings.index') }}" :active="request()->routeIs('admin.settings.*')" icon="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
            Pengaturan
        </x-nav-link>
    </nav>
    
    <!-- User Info -->
    <div class="p-4 border-t border-light-border dark:border-dark-border">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-accent/10 rounded-full flex items-center justify-center">
                <span class="text-accent font-semibold text-lg">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-text-primary dark:text-text-dark-primary truncate">
                    {{ auth()->user()->name }}
                </p>
                <p class="text-xs text-text-secondary truncate">
                    {{ auth()->user()->store->name }}
                </p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-text-secondary hover:text-error transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>

@push('styles')
<style>
    .nav-link-active {
        @apply bg-accent/10 text-accent;
    }
    .nav-link-inactive {
        @apply text-text-secondary hover:bg-light-surface dark:hover:bg-dark-surface hover:text-text-primary dark:hover:text-text-dark-primary;
    }
</style>
@endpush