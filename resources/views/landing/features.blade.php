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
                <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                Solusi Lengkap Bisnis Anda
            </span>
            <h1 class="mt-6 text-4xl md:text-5xl lg:text-6xl font-bold text-text-primary dark:text-text-dark-primary tracking-tight leading-tight">
                Semua yang Anda Butuhkan untuk
                <span class="text-accent text-emerald-400">Mengelola Toko & Kasir</span>
            </h1>
            <p class="mt-6 text-lg text-text-secondary dark:text-text-dark-secondary max-w-2xl mx-auto">
                Dari pencatatan kasir, kontrol inventaris otomatis, hingga pembuatan e-catalog publik profesional untuk memajukan bisnis UMKM Anda.
            </p>
        </div>
    </div>
</section>

<!-- Social Proof Statistics Panel -->
<section class="py-12 bg-light-surface dark:bg-dark-surface border-y border-light-border dark:border-dark-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 text-center">
            <div class="space-y-1">
                <p class="text-4xl md:text-5xl font-extrabold text-accent">1,000+</p>
                <p class="text-xs uppercase font-bold text-text-secondary tracking-wider">Pemilik UMKM Aktif</p>
            </div>
            <div class="space-y-1">
                <p class="text-4xl md:text-5xl font-extrabold text-accent">99.9%</p>
                <p class="text-xs uppercase font-bold text-text-secondary tracking-wider">Uptime Server Terjamin</p>
            </div>
            <div class="space-y-1">
                <p class="text-4xl md:text-5xl font-extrabold text-accent">Rp10M+</p>
                <p class="text-xs uppercase font-bold text-text-secondary tracking-wider">Transaksi Diproses</p>
            </div>
        </div>
    </div>
</section>

<!-- Detailed Features Grid -->
<section class="py-16 md:py-24 bg-light-bg dark:bg-dark-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-text-primary dark:text-text-dark-primary tracking-tight">
                Fitur Kasir & Toko Terintegrasi
            </h2>
            <p class="mt-4 text-text-secondary dark:text-text-dark-secondary text-sm md:text-base">
                CoreSite dirancang khusus dengan workflow sederhana dan profesional untuk operasional harian Anda tanpa ribet.
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- POS Offline & Online -->
            <div class="card p-6 bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border hover:shadow-md transition">
                <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center mb-5">
                    <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-text-primary dark:text-text-dark-primary mb-2">POS Kasir Cepat</h3>
                <p class="text-xs text-text-secondary leading-relaxed">
                    Sistem kasir digital yang lancar diakses online maupun offline. Transaksi tidak akan terhambat oleh gangguan internet.
                </p>
            </div>

            <!-- Bluetooth Printing -->
            <div class="card p-6 bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border hover:shadow-md transition">
                <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center mb-5">
                    <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-text-primary dark:text-text-dark-primary mb-2">Cetak Bluetooth</h3>
                <p class="text-xs text-text-secondary leading-relaxed">
                    Cetak struk belanja fisik instan menggunakan printer thermal Bluetooth langsung dari browser handphone atau desktop Anda.
                </p>
            </div>

            <!-- Multi-Outlet -->
            <div class="card p-6 bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border hover:shadow-md transition">
                <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center mb-5">
                    <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-text-primary dark:text-text-dark-primary mb-2">Multi-Outlet</h3>
                <p class="text-xs text-text-secondary leading-relaxed">
                    Kelola dan pantau stok serta transaksi dari berbagai cabang toko sekaligus dalam satu akun kontrol pusat.
                </p>
            </div>

            <!-- WhatsApp Catalog -->
            <div class="card p-6 bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border hover:shadow-md transition">
                <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center mb-5">
                    <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-text-primary dark:text-text-dark-primary mb-2">WhatsApp Catalog</h3>
                <p class="text-xs text-text-secondary leading-relaxed">
                    Bagikan link e-catalog publik Anda ke WhatsApp pelanggan. Pelanggan dapat memesan langsung dan diarahkan ke chat Anda.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Comparison Table: CoreSite vs Tradisional -->
<section class="py-16 md:py-24 bg-light-surface dark:bg-dark-surface">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-2xl md:text-3xl font-bold text-text-primary dark:text-text-dark-primary">
                Mengapa Memilih CoreSite?
            </h2>
            <p class="text-xs text-text-secondary mt-2">Perbandingan CoreSite vs Pencatatan Manual / Kasir Tradisional</p>
        </div>

        <div class="overflow-x-auto rounded-xl border border-light-border dark:border-dark-border shadow-sm">
            <table class="w-full text-left bg-white dark:bg-dark-surface text-sm">
                <thead>
                    <tr class="bg-light-bg/60 dark:bg-dark-bg/60 border-b border-light-border dark:border-dark-border text-xs uppercase font-bold text-text-secondary">
                        <th class="px-6 py-4">Fungsionalitas</th>
                        <th class="px-6 py-4 text-accent">CoreSite Platform</th>
                        <th class="px-6 py-4">Manual / Kasir Lama</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-light-border dark:divide-dark-border">
                    <tr>
                        <td class="px-6 py-4 font-semibold">Toko Online / Catalog</td>
                        <td class="px-6 py-4 text-accent font-semibold flex items-center gap-1.5">
                            <span class="text-emerald-500">✔</span> Otomatis dalam 1 menit
                        </td>
                        <td class="px-6 py-4 text-text-secondary">Tidak ada / Bayar mahal jasa buat web</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 font-semibold">Stok & Inventori</td>
                        <td class="px-6 py-4 text-accent font-semibold flex items-center gap-1.5">
                            <span class="text-emerald-500">✔</span> Otomatis berkurang saat terjual
                        </td>
                        <td class="px-6 py-4 text-text-secondary">Hitung manual di buku log kertas</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 font-semibold">Laporan Untung / Rugi</td>
                        <td class="px-6 py-4 text-accent font-semibold flex items-center gap-1.5">
                            <span class="text-emerald-500">✔</span> Kalkulasi instan & real-time
                        </td>
                        <td class="px-6 py-4 text-text-secondary">Harus kalkulasi kalkulator di akhir bulan</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 font-semibold">Akses Staf / Kasir</td>
                        <td class="px-6 py-4 text-accent font-semibold flex items-center gap-1.5">
                            <span class="text-emerald-500">✔</span> Akun staf terbatas & terpantau
                        </td>
                        <td class="px-6 py-4 text-text-secondary">Satu mesin kasir rawan kecurangan</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Security & Trust Badge Panel -->
<section class="py-16 bg-light-bg dark:bg-dark-bg">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
            <div class="text-center p-6 bg-light-surface dark:bg-dark-surface rounded-2xl border border-light-border dark:border-dark-border">
                <div class="w-14 h-14 bg-emerald-500/10 text-emerald-500 flex items-center justify-center rounded-full mx-auto mb-4">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h4 class="font-bold text-text-primary dark:text-text-dark-primary text-sm">Garansi 14 Hari</h4>
                <p class="text-xs text-text-secondary mt-1">Uang kembali jika tidak puas dengan layanan berbayar kami</p>
            </div>

            <div class="text-center p-6 bg-light-surface dark:bg-dark-surface rounded-2xl border border-light-border dark:border-dark-border">
                <div class="w-14 h-14 bg-emerald-500/10 text-emerald-500 flex items-center justify-center rounded-full mx-auto mb-4">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h4 class="font-bold text-text-primary dark:text-text-dark-primary text-sm">Enkripsi SSL 256-Bit</h4>
                <p class="text-xs text-text-secondary mt-1">Semua data transaksi dan data sensitif dijamin aman & terenkripsi</p>
            </div>

            <div class="text-center p-6 bg-light-surface dark:bg-dark-surface rounded-2xl border border-light-border dark:border-dark-border">
                <div class="w-14 h-14 bg-emerald-500/10 text-emerald-500 flex items-center justify-center rounded-full mx-auto mb-4">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 15H19"/>
                    </svg>
                </div>
                <h4 class="font-bold text-text-primary dark:text-text-dark-primary text-sm">Backup Harian Otomatis</h4>
                <p class="text-xs text-text-secondary mt-1">Kami mem-backup data Anda berkala agar tidak hilang akibat insiden</p>
            </div>
        </div>

        <!-- Payment logos -->
        <div class="mt-12 flex flex-col items-center gap-4">
            <span class="text-xs font-bold text-text-secondary uppercase tracking-wider">Mendukung Pembayaran & Kasir:</span>
            <div class="flex flex-wrap items-center justify-center gap-6 opacity-65 dark:opacity-85 text-xs font-bold text-text-secondary">
                <span class="bg-light-surface dark:bg-dark-surface border border-light-border dark:border-dark-border px-3 py-1.5 rounded-lg flex items-center gap-1">📱 QRIS</span>
                <span class="bg-light-surface dark:bg-dark-surface border border-light-border dark:border-dark-border px-3 py-1.5 rounded-lg flex items-center gap-1">🏦 Bank Transfer</span>
                <span class="bg-light-surface dark:bg-dark-surface border border-light-border dark:border-dark-border px-3 py-1.5 rounded-lg flex items-center gap-1">💳 E-Wallet</span>
                <span class="bg-light-surface dark:bg-dark-surface border border-light-border dark:border-dark-border px-3 py-1.5 rounded-lg flex items-center gap-1">💵 Tunai (Cash)</span>
            </div>
        </div>
    </div>
</section>

<!-- Client Testimonials -->
<section class="py-16 md:py-24 bg-light-surface dark:bg-dark-surface border-t border-light-border dark:border-dark-border">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-2xl md:text-3xl font-bold text-text-primary dark:text-text-dark-primary mb-12">
            Cerita Sukses Rekan UMKM
        </h2>
        <div class="grid md:grid-cols-2 gap-8 text-left">
            <div class="card p-6 bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border space-y-4">
                <p class="text-xs text-text-secondary leading-relaxed italic">
                    "Semenjak pakai CoreSite, warung kelontong saya sekarang punya katalog online sendiri. Pelanggan tinggal pilih lewat WhatsApp dan saya terima rekap transaksinya langsung di dashboard kasir. Menghemat waktu berjam-jam!"
                </p>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-accent/20 flex items-center justify-center font-bold text-accent text-xs">SP</div>
                    <div>
                        <h4 class="font-bold text-text-primary dark:text-text-dark-primary text-xs">Siti Patimah</h4>
                        <p class="text-[10px] text-text-secondary">Pemilik Warung Berkah, Bandung</p>
                    </div>
                </div>
            </div>

            <div class="card p-6 bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border space-y-4">
                <p class="text-xs text-text-secondary leading-relaxed italic">
                    "Sistem muti-outlet di CoreSite luar biasa membantu bisnis kopi susu saya yang punya 3 cabang. Manajemen stoknya otomatis dan laporan keuangannya real-time sehingga saya tidak perlu bolak-balik memeriksa pembukuan cabang."
                </p>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-accent/20 flex items-center justify-center font-bold text-accent text-xs">AD</div>
                    <div>
                        <h4 class="font-bold text-text-primary dark:text-text-dark-primary text-xs">Andi Darmawan</h4>
                        <p class="text-[10px] text-text-secondary">Pemilik Kopi Seduh, Jakarta</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 md:py-20 bg-accent text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold tracking-tight">
            Siap Mengembangkan UMKM Anda?
        </h2>
        <p class="mt-4 text-white/80 text-lg max-w-2xl mx-auto">
            Dapatkan website toko profesional dan dashboard kasir Anda gratis sekarang juga.
        </p>
        <div class="mt-8 flex justify-center">
            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-white text-accent font-bold rounded-lg hover:bg-gray-100 transition shadow-md">
                Mulai Gratis
                <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
        </div>
    </div>
</section>
@endsection