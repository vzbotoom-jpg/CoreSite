{{-- resources/views/landing/partials/features.blade.php --}}
<section id="features" class="py-16 md:py-24 bg-light-surface dark:bg-dark-surface">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="inline-flex items-center gap-2 px-3 py-1 bg-accent/10 text-accent text-sm font-medium rounded-full">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                Fitur Unggulan
            </span>
            <h2 class="text-3xl md:text-4xl font-bold text-text-primary dark:text-text-dark-primary tracking-tight">
                Semua yang Anda <span class="text-accent">Butuhkan</span>
            </h2>
            <p class="mt-4 text-lg text-text-secondary dark:text-text-dark-secondary">
                Kelola bisnis Anda dengan mudah menggunakan fitur-fitur canggih CoreSite
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            <!-- Feature 1: Dashboard Admin -->
            <div class="group bg-light-bg dark:bg-dark-bg rounded-2xl p-6 md:p-8 border border-light-border/40 dark:border-dark-border/40 hover:border-accent/50 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="w-14 h-14 bg-accent/10 rounded-xl flex items-center justify-center mb-5 group-hover:bg-accent/20 transition-colors duration-300">
                    <svg class="w-7 h-7 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-text-primary dark:text-text-dark-primary mb-3">Dashboard Admin</h3>
                <p class="text-text-secondary dark:text-text-dark-secondary leading-relaxed">
                    Kelola inventori, pantau penjualan, dan lihat laporan keuangan dalam satu dashboard yang intuitif.
                </p>
                <ul class="mt-4 space-y-2 text-sm text-text-secondary dark:text-text-dark-secondary">
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Pantau penjualan real-time</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Kelola inventori terpusat</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Laporan keuangan otomatis</span>
                    </li>
                </ul>
            </div>

            <!-- Feature 2: E-Katalog Profesional -->
            <div class="group bg-light-bg dark:bg-dark-bg rounded-2xl p-6 md:p-8 border border-light-border/40 dark:border-dark-border/40 hover:border-accent/50 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="w-14 h-14 bg-accent/10 rounded-xl flex items-center justify-center mb-5 group-hover:bg-accent/20 transition-colors duration-300">
                    <svg class="w-7 h-7 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-text-primary dark:text-text-dark-primary mb-3">E-Katalog Profesional</h3>
                <p class="text-text-secondary dark:text-text-dark-secondary leading-relaxed">
                    Tampilkan produk Anda di halaman publik dengan URL unik <code class="text-accent bg-accent/10 px-1.5 py-0.5 rounded text-xs">coresite.com/nama-toko-anda</code>.
                </p>
                <ul class="mt-4 space-y-2 text-sm text-text-secondary dark:text-text-dark-secondary">
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>URL toko unik dan profesional</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Halaman publik siap dibagikan</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Tampilan responsif semua device</span>
                    </li>
                </ul>
            </div>

            <!-- Feature 3: Laporan Keuangan -->
            <div class="group bg-light-bg dark:bg-dark-bg rounded-2xl p-6 md:p-8 border border-light-border/40 dark:border-dark-border/40 hover:border-accent/50 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="w-14 h-14 bg-accent/10 rounded-xl flex items-center justify-center mb-5 group-hover:bg-accent/20 transition-colors duration-300">
                    <svg class="w-7 h-7 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-text-primary dark:text-text-dark-primary mb-3">Laporan Keuangan</h3>
                <p class="text-text-secondary dark:text-text-dark-secondary leading-relaxed">
                    Pantau pendapatan, pengeluaran, dan profit dengan laporan otomatis yang akurat.
                </p>
                <ul class="mt-4 space-y-2 text-sm text-text-secondary dark:text-text-dark-secondary">
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Laporan pendapatan otomatis</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Analisis profitabilitas</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Ekspor laporan ke Excel/PDF</span>
                    </li>
                </ul>
            </div>

            <!-- Feature 4: Multi User -->
            <div class="group bg-light-bg dark:bg-dark-bg rounded-2xl p-6 md:p-8 border border-light-border/40 dark:border-dark-border/40 hover:border-accent/50 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="w-14 h-14 bg-accent/10 rounded-xl flex items-center justify-center mb-5 group-hover:bg-accent/20 transition-colors duration-300">
                    <svg class="w-7 h-7 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-text-primary dark:text-text-dark-primary mb-3">Multi User</h3>
                <p class="text-text-secondary dark:text-text-dark-secondary leading-relaxed">
                    Tambahkan staf atau karyawan untuk membantu mengelola toko dengan role yang berbeda.
                </p>
                <ul class="mt-4 space-y-2 text-sm text-text-secondary dark:text-text-dark-secondary">
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Tambahkan staf/karyawan</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Role akses berbeda</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Kolaborasi tim lebih mudah</span>
                    </li>
                </ul>
            </div>

            <!-- Feature 5: Manajemen Stok -->
            <div class="group bg-light-bg dark:bg-dark-bg rounded-2xl p-6 md:p-8 border border-light-border/40 dark:border-dark-border/40 hover:border-accent/50 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="w-14 h-14 bg-accent/10 rounded-xl flex items-center justify-center mb-5 group-hover:bg-accent/20 transition-colors duration-300">
                    <svg class="w-7 h-7 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-text-primary dark:text-text-dark-primary mb-3">Manajemen Stok</h3>
                <p class="text-text-secondary dark:text-text-dark-secondary leading-relaxed">
                    Kelola stok produk dengan mudah, dapatkan notifikasi saat stok menipis.
                </p>
                <ul class="mt-4 space-y-2 text-sm text-text-secondary dark:text-text-dark-secondary">
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Kelola stok real-time</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Notifikasi stok menipis</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Histori pergerakan stok</span>
                    </li>
                </ul>
            </div>

            <!-- Feature 6: Keamanan Terjamin -->
            <div class="group bg-light-bg dark:bg-dark-bg rounded-2xl p-6 md:p-8 border border-light-border/40 dark:border-dark-border/40 hover:border-accent/50 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="w-14 h-14 bg-accent/10 rounded-xl flex items-center justify-center mb-5 group-hover:bg-accent/20 transition-colors duration-300">
                    <svg class="w-7 h-7 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-text-primary dark:text-text-dark-primary mb-3">Keamanan Terjamin</h3>
                <p class="text-text-secondary dark:text-text-dark-secondary leading-relaxed">
                    Data toko Anda aman dengan enkripsi SSL dan backup rutin setiap hari.
                </p>
                <ul class="mt-4 space-y-2 text-sm text-text-secondary dark:text-text-dark-secondary">
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Enkripsi SSL terjamin</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Backup data otomatis</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Keamanan data terpercaya</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>