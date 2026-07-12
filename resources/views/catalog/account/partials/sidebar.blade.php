{{-- resources/views/catalog/account/partials/sidebar.blade.php --}}
<div class="sticky top-6 space-y-4">
    <!-- Profile Card -->
    <div class="card hover:shadow-lg transition-all duration-300">
        <div class="card-body text-center">
            <div class="w-20 h-20 bg-accent/10 rounded-full flex items-center justify-center mx-auto mb-3 ring-2 ring-accent/20">
                <span class="text-3xl font-bold text-accent">B</span>
            </div>
            <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Budi Santoso</h4>
            <p class="text-sm text-text-secondary dark:text-text-dark-secondary">budi@example.com</p>
            <div class="mt-2 flex justify-center gap-2">
                <span class="badge badge-success text-xs">Terverifikasi</span>
                <span class="badge badge-secondary text-xs">Member</span>
            </div>
        </div>
    </div>
    
    <!-- Navigation -->
    <div class="card">
        <div class="card-body p-2">
            <a href="{{ route('catalog.account.index') }}" class="sidebar-link {{ request()->routeIs('catalog.account.index') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span>Dashboard</span>
                <span class="ml-auto text-xs bg-accent/10 text-accent px-2 py-0.5 rounded-full">12</span>
            </a>
            
            <a href="{{ route('catalog.account.orders') }}" class="sidebar-link {{ request()->routeIs('catalog.account.orders') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <span>Pesanan</span>
                <span class="ml-auto text-xs bg-warning/10 text-warning px-2 py-0.5 rounded-full">3</span>
            </a>
            
            <a href="{{ route('catalog.account.wishlist') }}" class="sidebar-link {{ request()->routeIs('catalog.account.wishlist') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
                <span>Wishlist</span>
                <span class="ml-auto text-xs bg-accent/10 text-accent px-2 py-0.5 rounded-full">8</span>
            </a>
            
            <a href="{{ route('catalog.account.profile') }}" class="sidebar-link {{ request()->routeIs('catalog.account.profile') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span>Profil</span>
            </a>
            
            <a href="{{ route('catalog.account.settings') }}" class="sidebar-link {{ request()->routeIs('catalog.account.settings') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                </svg>
                <span>Pengaturan</span>
            </a>
            
            <div class="border-t border-light-border/40 dark:border-dark-border/40 my-2"></div>
            
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="sidebar-link text-error hover:bg-error/5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span>Logout</span>
            </a>
            <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
                @csrf
            </form>
        </div>
    </div>
    
    <!-- Support Card -->
    <div class="card bg-accent/5 border border-accent/20">
        <div class="card-body text-center">
            <div class="w-12 h-12 bg-accent/10 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 5.636a9 9 0 010 12.728m0 0a9 9 0 01-12.728 0m12.728 0L21 21M5.636 5.636a9 9 0 00-4.243 12.728m0 0L3 21m12.728-12.728L21 3"/>
                </svg>
            </div>
            <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Butuh Bantuan?</h4>
            <p class="text-sm text-text-secondary dark:text-text-dark-secondary mb-3">Tim support siap membantu Anda</p>
            <a href="{{ route('contact') }}" class="btn btn-secondary w-full text-sm">Hubungi Support</a>
        </div>
    </div>
</div>

<style>
.sidebar-link {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.6rem 0.875rem;
    border-radius: 0.5rem;
    transition: all 0.2s ease;
    color: var(--color-text-secondary);
    font-size: 0.875rem;
    text-decoration: none;
}
.sidebar-link:hover {
    background-color: rgba(0, 210, 122, 0.08);
    color: var(--color-accent);
}
.sidebar-link.active {
    background-color: rgba(0, 210, 122, 0.1);
    color: var(--color-accent);
}
.sidebar-link svg {
    flex-shrink: 0;
}
</style>