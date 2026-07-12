{{-- resources/views/layouts/partials/guest-nav.blade.php --}}
<nav class="bg-light-bg dark:bg-dark-bg border-b border-light-border dark:border-dark-border sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <a href="{{ route('landing') }}" class="flex items-center gap-2">
                <div class="w-8 h-8 bg-accent rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold text-lg">C</span>
                </div>
                <span class="font-bold text-xl text-text-primary dark:text-text-dark-primary">CoreSite</span>
            </a>
            
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('landing') }}" class="text-text-secondary hover:text-accent transition-colors">Beranda</a>
                <a href="{{ route('pricing') }}" class="text-text-secondary hover:text-accent transition-colors">Harga</a>
                <a href="{{ route('about') }}" class="text-text-secondary hover:text-accent transition-colors">Tentang</a>
                <a href="{{ route('contact') }}" class="text-text-secondary hover:text-accent transition-colors">Kontak</a>
            </div>
            
            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="text-text-secondary hover:text-accent transition-colors">
                    Login
                </a>
                <a href="{{ route('register') }}" class="btn btn-primary">
                    Daftar
                </a>
            </div>
        </div>
    </div>
</nav>