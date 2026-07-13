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
                <a href="{{ route('landing') }}" class="text-text-secondary hover:text-accent transition-colors duration-200 ease-out">Beranda</a>
                <a href="{{ route('pricing') }}" class="text-text-secondary hover:text-accent transition-colors duration-200 ease-out">Harga</a>
                <a href="{{ route('about') }}" class="text-text-secondary hover:text-accent transition-colors duration-200 ease-out">Tentang</a>
                <a href="{{ route('contact') }}" class="text-text-secondary hover:text-accent transition-colors duration-200 ease-out">Kontak</a>

                <div class="relative group">
                    <button class="flex items-center gap-2 text-text-secondary hover:text-accent transition-colors duration-200 ease-out focus:outline-none">
                        <span>Resources</span>
                        <svg class="w-4 h-4 text-text-secondary group-hover:text-accent transition-colors" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.293l3.71-4.063a.75.75 0 111.12 1.0l-4.25 4.656a.75.75 0 01-1.08 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div class="absolute right-0 mt-2 w-56 bg-light-surface dark:bg-dark-surface border border-light-border dark:border-dark-border rounded-lg shadow-lg opacity-0 invisible group-hover:visible group-hover:opacity-100 transform -translate-y-1 group-hover:translate-y-0 transition-all duration-150 z-50">
                        <div class="py-2 px-2">
                            <a href="{{ route('documentation') }}" class="block px-3 py-2 text-text-primary dark:text-text-dark-primary hover:bg-light-surface/50 dark:hover:bg-dark-surface/50 rounded">Documentation</a>
                            <a href="{{ route('changelog') }}" class="block px-3 py-2 text-text-primary dark:text-text-dark-primary hover:bg-light-surface/50 dark:hover:bg-dark-surface/50 rounded">Changelog</a>
                            <a href="{{ route('contact') }}" class="block px-3 py-2 text-text-primary dark:text-text-dark-primary hover:bg-light-surface/50 dark:hover:bg-dark-surface/50 rounded">Support</a>
                            <a href="#" class="block px-3 py-2 text-text-primary dark:text-text-dark-primary hover:bg-light-surface/50 dark:hover:bg-dark-surface/50 rounded">Press</a>
                            <a href="#" class="block px-3 py-2 text-text-primary dark:text-text-dark-primary hover:bg-light-surface/50 dark:hover:bg-dark-surface/50 rounded">Releases</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="text-text-secondary hover:text-accent transition-colors duration-200 ease-out">
                    Login
                </a>
                <a href="{{ route('register') }}" class="btn btn-primary">
                    Daftar
                </a>
            </div>
        </div>
    </div>
</nav>