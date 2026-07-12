{{-- resources/views/docs/quick-start.blade.php --}}
@extends('layouts.docs')

@section('title', 'Mulai Cepat - Dokumentasi CoreSite')

@section('content')
<div class="prose dark:prose-invert max-w-none">
    <p>
        Panduan ini akan membantu Anda memulai menggunakan CoreSite dalam hitungan menit. Ikuti langkah-langkah di bawah ini untuk memulai.
    </p>

    <div class="bg-accent/5 border-l-4 border-accent rounded-r-lg p-4 my-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-accent flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <strong class="text-accent text-lg">Estimasi Waktu:</strong>
                <span class="text-text-secondary dark:text-text-dark-secondary">3-5 menit</span>
            </div>
        </div>
    </div>

    <h2>Cara Mendapatkan CoreSite</h2>
    
    <div class="grid md:grid-cols-2 gap-4 my-6">
        <!-- Mobile -->
        <div class="border border-light-border/40 dark:border-dark-border/40 rounded-lg p-6 text-center">
            <svg class="w-12 h-12 text-accent mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
            </svg>
            <h4 class="font-bold text-text-primary dark:text-text-dark-primary">Unduh dari PlayStore</h4>
            <p class="text-sm text-text-secondary dark:text-text-dark-secondary mt-2">
                Untuk pengguna mobile, unduh aplikasi CoreSite langsung dari Google Play Store.
            </p>
            <a href="#" class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-accent text-white font-medium rounded-lg hover:opacity-80 transition">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M3.609 1.814L13.792 12 3.609 22.186A1.5 1.5 0 011.5 20.993V3.007a1.5 1.5 0 012.109-1.193z"/>
                    <path d="M20.5 9.5L5.5 2.5a2 2 0 00-2 0l15 9.5-15 9.5a2 2 0 002 0l15-9.5a2 2 0 000-3.5z"/>
                </svg>
                Download di PlayStore
            </a>
        </div>

        <!-- Desktop -->
        <div class="border border-light-border/40 dark:border-dark-border/40 rounded-lg p-6 text-center">
            <svg class="w-12 h-12 text-accent mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            <h4 class="font-bold text-text-primary dark:text-text-dark-primary">Download untuk Desktop</h4>
            <p class="text-sm text-text-secondary dark:text-text-dark-secondary mt-2">
                Untuk pengguna desktop, download aplikasi CoreSite untuk Windows, Mac, atau Linux.
            </p>
            <a href="#" class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-accent text-white font-medium rounded-lg hover:opacity-80 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Download untuk Desktop
            </a>
        </div>
    </div>

    <div class="bg-yellow-50 dark:bg-yellow-950/30 border-l-4 border-yellow-500 rounded-r-lg p-4 my-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <strong class="text-yellow-700 dark:text-yellow-400 text-lg">Info Penting:</strong>
                <span class="text-text-secondary dark:text-text-dark-secondary">CoreSite adalah aplikasi SaaS yang siap pakai. Tidak perlu instalasi server atau konfigurasi rumit. Cukup download dan daftar!</span>
            </div>
        </div>
    </div>

    <h2>Langkah Memulai CoreSite</h2>

    <div class="space-y-6 my-8">
        <!-- Step 1 -->
        <div class="flex gap-4 items-start">
            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-accent text-white flex items-center justify-center font-bold text-sm">1</div>
            <div>
                <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Download Aplikasi</h4>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">
                    Unduh CoreSite melalui <strong>PlayStore</strong> (mobile) atau <strong>Desktop Installer</strong> sesuai perangkat Anda.
                </p>
            </div>
        </div>
        
        <!-- Step 2 -->
        <div class="flex gap-4 items-start">
            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-accent text-white flex items-center justify-center font-bold text-sm">2</div>
            <div>
                <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Buka Aplikasi & Daftar</h4>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">
                    Buka aplikasi CoreSite dan klik tombol <strong>Daftar</strong>. Isi data diri Anda dengan lengkap.
                </p>
            </div>
        </div>
        
        <!-- Step 3 -->
        <div class="flex gap-4 items-start">
            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-accent text-white flex items-center justify-center font-bold text-sm">3</div>
            <div>
                <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Verifikasi Email</h4>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">
                    Cek email Anda dan klik tautan verifikasi untuk mengaktifkan akun CoreSite.
                </p>
            </div>
        </div>
        
        <!-- Step 4 -->
        <div class="flex gap-4 items-start">
            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-accent text-white flex items-center justify-center font-bold text-sm">4</div>
            <div>
                <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Mulai Menggunakan</h4>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">
                    Login ke dashboard dan mulai kelola bisnis Anda! Tambahkan produk, buat E-Katalog, dan lakukan transaksi.
                </p>
            </div>
        </div>
    </div>

    <div class="bg-green-50 dark:bg-green-950/30 border-l-4 border-green-500 rounded-r-lg p-4 my-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <strong class="text-green-700 dark:text-green-400 text-lg">🎉 Selesai!</strong><br>
                <span class="text-text-secondary dark:text-text-dark-secondary">Anda sudah siap menggunakan CoreSite. Mulai kelola bisnis Anda dengan lebih efisien!</span>
            </div>
        </div>
    </div>

    <h2>Langkah Selanjutnya</h2>
    
    <ul>
        <li><a href="{{ route('docs.show', 'registration') }}" class="text-accent hover:underline">Cara Registrasi</a> - Panduan lengkap mendaftar akun CoreSite</li>
        <li><a href="{{ route('docs.show', 'product-management') }}" class="text-accent hover:underline">Manajemen Produk</a> - Tambahkan produk pertama Anda</li>
        <li><a href="{{ route('docs.show', 'e-catalog-setup') }}" class="text-accent hover:underline">Pengaturan E-Katalog</a> - Buat toko online Anda</li>
    </ul>
</div>
@endsection