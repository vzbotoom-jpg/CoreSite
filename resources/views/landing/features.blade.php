{{-- resources/views/landing/features.blade.php --}}
@extends('layouts.landing')

@section('title', 'Fitur - CoreSite')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden bg-light-bg dark:bg-dark-bg pt-20 pb-16 md:pt-28 md:pb-24">
    <div class="absolute inset-0 opacity-5">
        <div class="absolute top-0 left-0 w-96 h-96 bg-accent rounded-full filter blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-accent rounded-full filter blur-3xl translate-x-1/2 translate-y-1/2"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto">
            <span class="inline-flex items-center gap-2 px-3 py-1 bg-accent/10 text-accent text-sm font-medium rounded-full">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                Fitur Unggulan
            </span>
            <h1 class="mt-6 text-4xl md:text-5xl lg:text-6xl font-bold text-text-primary dark:text-text-dark-primary tracking-tight">
                Semua yang Anda Butuhkan untuk
                <span class="text-accent">Mengelola Bisnis</span>
            </h1>
            <p class="mt-6 text-lg text-text-secondary dark:text-text-dark-secondary max-w-2xl mx-auto">
                CoreSite menyediakan solusi lengkap untuk mengelola produk, katalog, dan transaksi bisnis Anda dengan mudah dan efisien.
            </p>
        </div>
    </div>
</section>

<!-- Main Features Grid -->
<section class="py-16 md:py-24 bg-light-surface dark:bg-dark-surface">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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

<!-- Additional Features Section -->
<section class="py-16 md:py-24 bg-light-bg dark:bg-dark-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-text-primary dark:text-text-dark-primary tracking-tight">
                Fitur <span class="text-accent">Lengkap</span> untuk Bisnis Anda
            </h2>
            <p class="mt-4 text-text-secondary dark:text-text-dark-secondary">
                CoreSite hadir dengan fitur-fitur yang dirancang khusus untuk membantu UMKM berkembang.
            </p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Harga Terjangkau -->
            <div class="text-center p-6 bg-light-surface dark:bg-dark-surface rounded-2xl border border-light-border/40 dark:border-dark-border/40 hover:border-accent/50 transition-all duration-300 hover:shadow-lg">
                <div class="w-16 h-16 bg-accent/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Harga Terjangkau</h4>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary mt-2">Mulai dari Rp49.000/bulan</p>
            </div>

            <!-- Aplikasi Mobile -->
            <div class="text-center p-6 bg-light-surface dark:bg-dark-surface rounded-2xl border border-light-border/40 dark:border-dark-border/40 hover:border-accent/50 transition-all duration-300 hover:shadow-lg">
                <div class="w-16 h-16 bg-accent/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Aplikasi Mobile</h4>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary mt-2">Tersedia di PlayStore</p>
            </div>

            <!-- Desktop App -->
            <div class="text-center p-6 bg-light-surface dark:bg-dark-surface rounded-2xl border border-light-border/40 dark:border-dark-border/40 hover:border-accent/50 transition-all duration-300 hover:shadow-lg">
                <div class="w-16 h-16 bg-accent/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Desktop App</h4>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary mt-2">Windows, Mac, Linux</p>
            </div>

            <!-- Support 24/7 -->
            <div class="text-center p-6 bg-light-surface dark:bg-dark-surface rounded-2xl border border-light-border/40 dark:border-dark-border/40 hover:border-accent/50 transition-all duration-300 hover:shadow-lg">
                <div class="w-16 h-16 bg-accent/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Support 24/7</h4>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary mt-2">Tim siap membantu Anda</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 md:py-20 bg-accent">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white tracking-tight">
            Siap Mengelola Bisnis dengan Lebih Mudah?
        </h2>
        <p class="mt-4 text-white/80 text-lg max-w-2xl mx-auto">
            Mulai gunakan CoreSite sekarang dan rasakan kemudahan mengelola produk, katalog, dan transaksi dalam satu platform.
        </p>
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-white text-accent font-semibold rounded-lg hover:bg-gray-100 transition">
                Daftar Sekarang
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
            <a href="{{ route('demo') }}" class="inline-flex items-center gap-2 px-8 py-3 border-2 border-white text-white font-semibold rounded-lg hover:bg-white/10 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Lihat Demo
            </a>
        </div>
    </div>
</section>
@endsection