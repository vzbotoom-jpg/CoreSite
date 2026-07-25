{{-- resources/views/landing/guides.blade.php --}}
@extends('layouts.landing')

@section('title', 'Panduan Penggunaan - CoreSite')
@section('description', 'Panduan langkah demi langkah menggunakan platform e-catalog dan kasir otomatis CoreSite.')

@section('content')
<section class="py-20 bg-light-bg dark:bg-dark-bg text-text-primary dark:text-text-dark-primary">
    <div class="container mx-auto px-4 max-w-4xl">
        <div class="text-center mb-16">
            <span class="inline-flex items-center gap-2 px-3 py-1 bg-accent/10 text-accent text-sm font-medium rounded-full">
                📖 Pusat Bantuan
            </span>
            <h1 class="text-4xl md:text-5xl font-bold tracking-tight mt-4">
                <span class="text-accent text-emerald-400">Panduan</span> Penggunaan
            </h1>
            <p class="text-text-secondary dark:text-text-dark-secondary mt-4">
                Pelajari cara mengoptimalkan seluruh fitur kasir dan e-catalog CoreSite untuk pertumbuhan bisnis Anda.
            </p>
        </div>

        <div class="space-y-12">
            <!-- LEVEL 1: PANDUAN PEMULA (STARTER) -->
            <div class="space-y-4">
                <h3 class="text-base font-extrabold text-accent uppercase tracking-wider flex items-center gap-2 border-b border-light-border dark:border-dark-border pb-2">
                    <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Tingkat Pemula (Dasar Setup)
                </h3>

                <div class="grid gap-4">
                    <!-- Guide 1 -->
                    <a href="{{ route('docs.show', 'introduction') }}" class="card hover:shadow-lg hover:border-accent/40 transition bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border block">
                        <div class="card-body p-5 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center text-accent shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h4 class="font-bold text-text-primary dark:text-text-dark-primary text-sm truncate">Panduan Memulai CoreSite</h4>
                                        <span class="badge badge-secondary text-[10px] font-bold py-0.5 px-1.5 shrink-0 bg-accent/10 text-accent">10 Menit Baca</span>
                                    </div>
                                    <p class="text-xs text-text-secondary mt-1">Pelajari langkah pendaftaran, verifikasi, hingga konfigurasi awal profil toko Anda.</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-text-secondary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>

                    <!-- Guide 2 -->
                    <a href="{{ route('docs.show', 'product-management') }}" class="card hover:shadow-lg hover:border-accent/40 transition bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border block">
                        <div class="card-body p-5 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center text-accent shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h4 class="font-bold text-text-primary dark:text-text-dark-primary text-sm truncate">Cara Menambahkan Produk & Stok</h4>
                                        <span class="badge badge-secondary text-[10px] font-bold py-0.5 px-1.5 shrink-0 bg-accent/10 text-accent">5 Menit Baca</span>
                                    </div>
                                    <p class="text-xs text-text-secondary mt-1">Panduan lengkap mengunggah foto, mengatur kategori, harga jual, dan limit alarm stok minimum.</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-text-secondary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>
                </div>
            </div>

            <!-- LEVEL 2: PANDUAN LANJUTAN (ADVANCED) -->
            <div class="space-y-4">
                <h3 class="text-base font-extrabold text-accent uppercase tracking-wider flex items-center gap-2 border-b border-light-border dark:border-dark-border pb-2">
                    <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Tingkat Lanjutan (Transaksi & Analitik)
                </h3>

                <div class="grid gap-4">
                    <!-- Guide 3 -->
                    <a href="{{ route('docs.show', 'pos-transactions') }}" class="card hover:shadow-lg hover:border-accent/40 transition bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border block">
                        <div class="card-body p-5 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center text-accent shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 11h.01M12 14h.01M15 11h.01M15 14h.01M12 7H9v2h3V7zm3-3H9v2h6V4z"/>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h4 class="font-bold text-text-primary dark:text-text-dark-primary text-sm truncate">Mengelola Transaksi & Printer Bluetooth</h4>
                                        <span class="badge badge-secondary text-[10px] font-bold py-0.5 px-1.5 shrink-0 bg-accent/10 text-accent">8 Menit Baca</span>
                                    </div>
                                    <p class="text-xs text-text-secondary mt-1">Langkah memproses penjualan kasir, memilih metode bayar, hingga cetak struk thermal.</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-text-secondary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>

                    <!-- Guide 4 -->
                    <a href="{{ route('docs.show', 'reports-analytics') }}" class="card hover:shadow-lg hover:border-accent/40 transition bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border block">
                        <div class="card-body p-5 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center text-accent shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h4 class="font-bold text-text-primary dark:text-text-dark-primary text-sm truncate">Membaca Laporan Laba Rugi</h4>
                                        <span class="badge badge-secondary text-[10px] font-bold py-0.5 px-1.5 shrink-0 bg-accent/10 text-accent">6 Menit Baca</span>
                                    </div>
                                    <p class="text-xs text-text-secondary mt-1">Tips melacak profit bersih, menganalisis metode pembayaran favorit, dan mengekspor laporan bulanan.</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-text-secondary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>

                    <!-- Guide 5 -->
                    <a href="{{ route('docs.show', 'e-catalog-setup') }}" class="card hover:shadow-lg hover:border-accent/40 transition bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border block">
                        <div class="card-body p-5 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center text-accent shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h4 class="font-bold text-text-primary dark:text-text-dark-primary text-sm truncate">Mengatur & Membagikan E-Catalog Publik</h4>
                                        <span class="badge badge-secondary text-[10px] font-bold py-0.5 px-1.5 shrink-0 bg-accent/10 text-accent">5 Menit Baca</span>
                                    </div>
                                    <p class="text-xs text-text-secondary mt-1">Trik membuat katalog digital toko Anda terlihat menarik dan integrasi pesanan chat WhatsApp.</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-text-secondary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection