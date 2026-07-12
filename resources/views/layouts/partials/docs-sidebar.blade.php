{{-- resources/views/layouts/partials/docs-sidebar.blade.php --}}
<aside class="w-full">
    <div class="sticky top-16 h-[calc(100vh-4rem)] overflow-y-auto pr-6">
        <!-- Search Bar -->
        <div class="mb-8">
            <form action="{{ route('docs.search') }}" method="GET" class="relative">
                <input 
                    type="text" 
                    name="q"
                    placeholder="Cari dokumentasi..." 
                    class="w-full px-4 py-2.5 bg-light-surface dark:bg-dark-surface/50 border border-light-border/40 dark:border-dark-border/40 rounded-lg text-sm text-text-primary dark:text-text-dark-primary placeholder:text-text-secondary/50 focus:ring-1 focus:ring-accent/50 transition outline-none"
                    id="docs-search"
                    value="{{ request('q') }}"
                >
                <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-text-secondary/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
            </form>
        </div>

        <!-- Navigation Menu -->
        <nav class="space-y-8">
            <!-- Memulai -->
            <div>
                <h3 class="text-xs font-semibold text-text-secondary dark:text-text-dark-secondary uppercase tracking-wider mb-3">
                    Memulai
                </h3>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('docs.show', 'introduction') }}" 
                           class="block px-3 py-1.5 text-sm rounded-lg transition {{ request()->is('docs/introduction') ? 'text-accent bg-accent/5 font-medium' : 'text-text-secondary hover:text-text-primary dark:hover:text-text-dark-primary hover:bg-light-surface/50 dark:hover:bg-dark-surface/50' }}">
                            Pengenalan CoreSite
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('docs.show', 'registration') }}" 
                           class="block px-3 py-1.5 text-sm rounded-lg transition {{ request()->is('docs/registration') ? 'text-accent bg-accent/5 font-medium' : 'text-text-secondary hover:text-text-primary dark:hover:text-text-dark-primary hover:bg-light-surface/50 dark:hover:bg-dark-surface/50' }}">
                            Cara Registrasi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('docs.show', 'subscription') }}" 
                           class="block px-3 py-1.5 text-sm rounded-lg transition {{ request()->is('docs/subscription') ? 'text-accent bg-accent/5 font-medium' : 'text-text-secondary hover:text-text-primary dark:hover:text-text-dark-primary hover:bg-light-surface/50 dark:hover:bg-dark-surface/50' }}">
                            Paket & Harga
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Panduan Cepat -->
            <div>
                <h3 class="text-xs font-semibold text-text-secondary dark:text-text-dark-secondary uppercase tracking-wider mb-3">
                    Panduan Cepat
                </h3>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('docs.show', 'quick-start') }}" 
                           class="block px-3 py-1.5 text-sm rounded-lg transition {{ request()->is('docs/quick-start') ? 'text-accent bg-accent/5 font-medium' : 'text-text-secondary hover:text-text-primary dark:hover:text-text-dark-primary hover:bg-light-surface/50 dark:hover:bg-dark-surface/50' }}">
                            Mulai Cepat
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('docs.show', 'dashboard-guide') }}" 
                           class="block px-3 py-1.5 text-sm rounded-lg transition {{ request()->is('docs/dashboard-guide') ? 'text-accent bg-accent/5 font-medium' : 'text-text-secondary hover:text-text-primary dark:hover:text-text-dark-primary hover:bg-light-surface/50 dark:hover:bg-dark-surface/50' }}">
                            Panduan Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('docs.show', 'profile-settings') }}" 
                           class="block px-3 py-1.5 text-sm rounded-lg transition {{ request()->is('docs/profile-settings') ? 'text-accent bg-accent/5 font-medium' : 'text-text-secondary hover:text-text-primary dark:hover:text-text-dark-primary hover:bg-light-surface/50 dark:hover:bg-dark-surface/50' }}">
                            Pengaturan Akun
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Fitur Utama -->
            <div>
                <h3 class="text-xs font-semibold text-text-secondary dark:text-text-dark-secondary uppercase tracking-wider mb-3">
                    Fitur Utama
                </h3>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('docs.show', 'product-management') }}" 
                           class="block px-3 py-1.5 text-sm rounded-lg transition {{ request()->is('docs/product-management') ? 'text-accent bg-accent/5 font-medium' : 'text-text-secondary hover:text-text-primary dark:hover:text-text-dark-primary hover:bg-light-surface/50 dark:hover:bg-dark-surface/50' }}">
                            Manajemen Produk
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('docs.show', 'e-catalog-setup') }}" 
                           class="block px-3 py-1.5 text-sm rounded-lg transition {{ request()->is('docs/e-catalog-setup') ? 'text-accent bg-accent/5 font-medium' : 'text-text-secondary hover:text-text-primary dark:hover:text-text-dark-primary hover:bg-light-surface/50 dark:hover:bg-dark-surface/50' }}">
                            Pengaturan E-Katalog
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('docs.show', 'pos-transactions') }}" 
                           class="block px-3 py-1.5 text-sm rounded-lg transition {{ request()->is('docs/pos-transactions') ? 'text-accent bg-accent/5 font-medium' : 'text-text-secondary hover:text-text-primary dark:hover:text-text-dark-primary hover:bg-light-surface/50 dark:hover:bg-dark-surface/50' }}">
                            Transaksi Kasir
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Lanjutan -->
            <div>
                <h3 class="text-xs font-semibold text-text-secondary dark:text-text-dark-secondary uppercase tracking-wider mb-3">
                    Lanjutan
                </h3>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('docs.show', 'exporting-data') }}" 
                           class="block px-3 py-1.5 text-sm rounded-lg transition {{ request()->is('docs/exporting-data') ? 'text-accent bg-accent/5 font-medium' : 'text-text-secondary hover:text-text-primary dark:hover:text-text-dark-primary hover:bg-light-surface/50 dark:hover:bg-dark-surface/50' }}">
                            Ekspor Data
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('docs.show', 'reports-analytics') }}" 
                           class="block px-3 py-1.5 text-sm rounded-lg transition {{ request()->is('docs/reports-analytics') ? 'text-accent bg-accent/5 font-medium' : 'text-text-secondary hover:text-text-primary dark:hover:text-text-dark-primary hover:bg-light-surface/50 dark:hover:bg-dark-surface/50' }}">
                            Laporan & Analitik
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('docs.show', 'faq') }}" 
                           class="block px-3 py-1.5 text-sm rounded-lg transition {{ request()->is('docs/faq') ? 'text-accent bg-accent/5 font-medium' : 'text-text-secondary hover:text-text-primary dark:hover:text-text-dark-primary hover:bg-light-surface/50 dark:hover:bg-dark-surface/50' }}">
                            FAQ
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Informasi Perusahaan -->
            <div>
                <h3 class="text-xs font-semibold text-text-secondary dark:text-text-dark-secondary uppercase tracking-wider mb-3">
                    Informasi Perusahaan
                </h3>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('docs.show', 'changelog') }}" 
                           class="block px-3 py-1.5 text-sm rounded-lg transition {{ request()->is('docs/changelog') ? 'text-accent bg-accent/5 font-medium' : 'text-text-secondary hover:text-text-primary dark:hover:text-text-dark-primary hover:bg-light-surface/50 dark:hover:bg-dark-surface/50' }}">
                            Riwayat Pembaruan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('docs.show', 'roadmap') }}" 
                           class="block px-3 py-1.5 text-sm rounded-lg transition {{ request()->is('docs/roadmap') ? 'text-accent bg-accent/5 font-medium' : 'text-text-secondary hover:text-text-primary dark:hover:text-text-dark-primary hover:bg-light-surface/50 dark:hover:bg-dark-surface/50' }}">
                            Peta Jalan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('docs.show', 'security') }}" 
                           class="block px-3 py-1.5 text-sm rounded-lg transition {{ request()->is('docs/security') ? 'text-accent bg-accent/5 font-medium' : 'text-text-secondary hover:text-text-primary dark:hover:text-text-dark-primary hover:bg-light-surface/50 dark:hover:bg-dark-surface/50' }}">
                            Keamanan & Privasi
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Referensi API -->
            <div>
                <h3 class="text-xs font-semibold text-text-secondary dark:text-text-dark-secondary uppercase tracking-wider mb-3">
                    Referensi API
                </h3>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('docs.show', 'api-overview') }}" 
                           class="block px-3 py-1.5 text-sm rounded-lg transition {{ request()->is('docs/api-overview') ? 'text-accent bg-accent/5 font-medium' : 'text-text-secondary hover:text-text-primary dark:hover:text-text-dark-primary hover:bg-light-surface/50 dark:hover:bg-dark-surface/50' }}">
                            Gambaran API
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('docs.show', 'authentication') }}" 
                           class="block px-3 py-1.5 text-sm rounded-lg transition {{ request()->is('docs/authentication') ? 'text-accent bg-accent/5 font-medium' : 'text-text-secondary hover:text-text-primary dark:hover:text-text-dark-primary hover:bg-light-surface/50 dark:hover:bg-dark-surface/50' }}">
                            Autentikasi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('docs.show', 'endpoints') }}" 
                           class="block px-3 py-1.5 text-sm rounded-lg transition {{ request()->is('docs/endpoints') ? 'text-accent bg-accent/5 font-medium' : 'text-text-secondary hover:text-text-primary dark:hover:text-text-dark-primary hover:bg-light-surface/50 dark:hover:bg-dark-surface/50' }}">
                            Endpoint
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Bantuan - Baru -->
            <div>
                <h3 class="text-xs font-semibold text-text-secondary dark:text-text-dark-secondary uppercase tracking-wider mb-3">
                    Bantuan
                </h3>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('docs.show', 'support') }}" 
                           class="block px-3 py-1.5 text-sm rounded-lg transition {{ request()->is('docs/support') ? 'text-accent bg-accent/5 font-medium' : 'text-text-secondary hover:text-text-primary dark:hover:text-text-dark-primary hover:bg-light-surface/50 dark:hover:bg-dark-surface/50' }}">
                            Hubungi Dukungan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('docs.show', 'billing') }}" 
                           class="block px-3 py-1.5 text-sm rounded-lg transition {{ request()->is('docs/billing') ? 'text-accent bg-accent/5 font-medium' : 'text-text-secondary hover:text-text-primary dark:hover:text-text-dark-primary hover:bg-light-surface/50 dark:hover:bg-dark-surface/50' }}">
                            Penagihan & Invoice
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Footer -->
        <div class="mt-8 pt-6 border-t border-light-border/40 dark:border-dark-border/40">
            <p class="text-xs text-text-secondary/60">
                <span class="font-medium text-text-secondary dark:text-text-dark-secondary">CoreSite</span> Dokumentasi
            </p>
            <p class="text-xs text-text-secondary/40 mt-1">v{{ config('app.version', '1.0.0') }}</p>
        </div>
    </div>
</aside>

@push('scripts')
<script>
    document.addEventListener('keydown', function(e) {
        if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
            e.preventDefault();
            document.getElementById('docs-search')?.focus();
        }
    });
</script>
@endpush