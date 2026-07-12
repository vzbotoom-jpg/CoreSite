{{-- resources/views/docs/security.blade.php --}}
@extends('layouts.docs')

@section('title', 'Keamanan - Dokumentasi CoreSite')

@section('content')
<div class="prose dark:prose-invert max-w-none">
    <p>
        CoreSite berkomitmen untuk melindungi data Anda dengan standar keamanan tertinggi. Berikut adalah langkah-langkah yang kami ambil untuk menjaga keamanan platform.
    </p>

    <div class="bg-accent/5 border-l-4 border-accent rounded-r-lg p-4 my-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-accent flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            <div>
                <strong class="text-accent text-lg">Komitmen Keamanan</strong><br>
                <span class="text-text-secondary dark:text-text-dark-secondary">Kami percaya bahwa keamanan adalah fondasi dari kepercayaan. Semua data Anda dilindungi dengan enkripsi dan praktik keamanan terbaik industri.</span>
            </div>
        </div>
    </div>

    <h2>Fitur Keamanan</h2>

    <div class="grid md:grid-cols-2 gap-4 mt-4">
        <!-- Enkripsi Data -->
        <div class="border border-light-border/40 dark:border-dark-border/40 rounded-lg p-4">
            <svg class="w-8 h-8 text-accent mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            <h4 class="font-bold text-text-primary dark:text-text-dark-primary">Enkripsi Data</h4>
            <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Semua data dienkripsi dengan AES-256 baik saat transit maupun saat istirahat</p>
        </div>

        <!-- SSL/TLS -->
        <div class="border border-light-border/40 dark:border-dark-border/40 rounded-lg p-4">
            <svg class="w-8 h-8 text-accent mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            <h4 class="font-bold text-text-primary dark:text-text-dark-primary">SSL/TLS</h4>
            <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Koneksi aman dengan sertifikat SSL/TLS untuk semua komunikasi</p>
        </div>

        <!-- Akses Terbatas -->
        <div class="border border-light-border/40 dark:border-dark-border/40 rounded-lg p-4">
            <svg class="w-8 h-8 text-accent mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A11.955 11.955 0 008.5 10.5M12 11a2 2 0 11-4 0 2 2 0 014 0zm6.753 9.571A11.955 11.955 0 0115.5 10.5m-1.887 9.571l.054-.09M12 11v2m-6 7h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/>
            </svg>
            <h4 class="font-bold text-text-primary dark:text-text-dark-primary">Akses Terbatas</h4>
            <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Hanya tim terbatas yang memiliki akses ke data Anda dengan otorisasi ketat</p>
        </div>

        <!-- Audit & Monitoring -->
        <div class="border border-light-border/40 dark:border-dark-border/40 rounded-lg p-4">
            <svg class="w-8 h-8 text-accent mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h4 class="font-bold text-text-primary dark:text-text-dark-primary">Audit & Monitoring</h4>
            <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Audit dan monitoring keamanan dilakukan secara berkala</p>
        </div>
    </div>

    <h2>Sertifikasi & Kepatuhan</h2>
    
    <ul class="space-y-2">
        <li class="flex items-center gap-2">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span><strong>ISO 27001</strong> — Dalam proses sertifikasi</span>
        </li>
        <li class="flex items-center gap-2">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span><strong>GDPR</strong> — Kepatuhan penuh terhadap regulasi perlindungan data Eropa</span>
        </li>
        <li class="flex items-center gap-2">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span><strong>PCI DSS Level 1</strong> — Untuk pemrosesan pembayaran</span>
        </li>
    </ul>

    <h2>Praktik Keamanan</h2>

    <h3>1. Enkripsi Data</h3>
    <p>
        Semua data sensitif dienkripsi menggunakan AES-256. Data dalam transit dilindungi dengan TLS 1.3.
    </p>

    <h3>2. Manajemen Akses</h3>
    <p>
        Kami menerapkan prinsip <strong>least privilege</strong> — setiap anggota tim hanya memiliki akses ke data yang diperlukan untuk pekerjaan mereka.
    </p>

    <h3>3. Pemantauan Berkelanjutan</h3>
    <p>
        Sistem kami dipantau 24/7 untuk mendeteksi dan merespons ancaman keamanan secara real-time.
    </p>

    <h3>4. Backup Reguler</h3>
    <p>
        Data dicadangkan secara reguler dan disimpan dengan aman di lokasi yang terpisah untuk pemulihan bencana.
    </p>

    <div class="bg-yellow-50 dark:bg-yellow-950/30 border-l-4 border-yellow-500 rounded-r-lg p-4 my-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
            </svg>
            <div>
                <strong class="text-yellow-700 dark:text-yellow-400 text-lg">Laporkan Masalah Keamanan</strong><br>
                <span class="text-text-secondary dark:text-text-dark-secondary">Jika Anda menemukan kerentanan keamanan, harap laporkan ke <a href="mailto:security@coresite.com" class="text-accent hover:underline">security@coresite.com</a>. Kami akan menanggapinya dengan cepat.</span>
            </div>
        </div>
    </div>
</div>
@endsection