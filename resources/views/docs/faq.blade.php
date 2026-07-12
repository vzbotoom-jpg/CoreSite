{{-- resources/views/docs/faq.blade.php --}}
@extends('layouts.docs')

@section('title', 'FAQ - Dokumentasi CoreSite')

@section('content')
<div class="prose dark:prose-invert max-w-none">
    <p>
        Pertanyaan yang sering diajukan tentang CoreSite. Temukan jawaban cepat untuk pertanyaan Anda.
    </p>

    <div class="space-y-6 my-8">
        <!-- FAQ 1 -->
        <div class="border border-light-border/40 dark:border-dark-border/40 rounded-lg p-6">
            <h4 class="font-bold text-text-primary dark:text-text-dark-primary flex items-start gap-3">
                <span class="text-accent text-xl">Q:</span>
                <span>Apa itu CoreSite?</span>
            </h4>
            <div class="flex items-start gap-3 mt-2">
                <span class="text-green-600 dark:text-green-400 text-xl">A:</span>
                <p class="text-text-secondary dark:text-text-dark-secondary">CoreSite adalah platform manajemen bisnis all-in-one yang membantu UMKM mengelola produk, katalog, dan transaksi dengan mudah.</p>
            </div>
        </div>

        <!-- FAQ 2 -->
        <div class="border border-light-border/40 dark:border-dark-border/40 rounded-lg p-6">
            <h4 class="font-bold text-text-primary dark:text-text-dark-primary flex items-start gap-3">
                <span class="text-accent text-xl">Q:</span>
                <span>Apakah CoreSite gratis?</span>
            </h4>
            <div class="flex items-start gap-3 mt-2">
                <span class="text-green-600 dark:text-green-400 text-xl">A:</span>
                <p class="text-text-secondary dark:text-text-dark-secondary">CoreSite menyediakan paket gratis untuk mencoba semua fitur. Untuk penggunaan lanjutan, tersedia paket berbayar dengan fitur lebih lengkap. <a href="{{ route('docs.show', 'subscription') }}" class="text-accent hover:underline">Lihat paket dan harga</a>.</p>
            </div>
        </div>

        <!-- FAQ 3 -->
        <div class="border border-light-border/40 dark:border-dark-border/40 rounded-lg p-6">
            <h4 class="font-bold text-text-primary dark:text-text-dark-primary flex items-start gap-3">
                <span class="text-accent text-xl">Q:</span>
                <span>Bagaimana cara mendaftar akun CoreSite?</span>
            </h4>
            <div class="flex items-start gap-3 mt-2">
                <span class="text-green-600 dark:text-green-400 text-xl">A:</span>
                <p class="text-text-secondary dark:text-text-dark-secondary">Kunjungi halaman <a href="{{ route('register') }}" class="text-accent hover:underline">Daftar Akun</a>, isi formulir pendaftaran, verifikasi email, dan mulai menggunakan CoreSite. <a href="{{ route('docs.show', 'registration') }}" class="text-accent hover:underline">Panduan lengkap registrasi</a>.</p>
            </div>
        </div>

        <!-- FAQ 4 -->
        <div class="border border-light-border/40 dark:border-dark-border/40 rounded-lg p-6">
            <h4 class="font-bold text-text-primary dark:text-text-dark-primary flex items-start gap-3">
                <span class="text-accent text-xl">Q:</span>
                <span>Apakah data saya aman di CoreSite?</span>
            </h4>
            <div class="flex items-start gap-3 mt-2">
                <span class="text-green-600 dark:text-green-400 text-xl">A:</span>
                <p class="text-text-secondary dark:text-text-dark-secondary">Ya, CoreSite menggunakan enkripsi AES-256 dan SSL/TLS untuk melindungi data Anda. Kami juga mematuhi standar keamanan internasional. <a href="{{ route('docs.show', 'security') }}" class="text-accent hover:underline">Pelajari lebih lanjut</a>.</p>
            </div>
        </div>

        <!-- FAQ 5 -->
        <div class="border border-light-border/40 dark:border-dark-border/40 rounded-lg p-6">
            <h4 class="font-bold text-text-primary dark:text-text-dark-primary flex items-start gap-3">
                <span class="text-accent text-xl">Q:</span>
                <span>Bagaimana cara menambahkan produk?</span>
            </h4>
            <div class="flex items-start gap-3 mt-2">
                <span class="text-green-600 dark:text-green-400 text-xl">A:</span>
                <p class="text-text-secondary dark:text-text-dark-secondary">Login ke dashboard, klik menu <strong>Produk</strong>, lalu klik tombol <strong>Tambah Produk</strong>. Isi informasi produk dan simpan. <a href="{{ route('docs.show', 'product-management') }}" class="text-accent hover:underline">Panduan manajemen produk</a>.</p>
            </div>
        </div>

        <!-- FAQ 6 -->
        <div class="border border-light-border/40 dark:border-dark-border/40 rounded-lg p-6">
            <h4 class="font-bold text-text-primary dark:text-text-dark-primary flex items-start gap-3">
                <span class="text-accent text-xl">Q:</span>
                <span>Bagaimana cara membuat E-Katalog?</span>
            </h4>
            <div class="flex items-start gap-3 mt-2">
                <span class="text-green-600 dark:text-green-400 text-xl">A:</span>
                <p class="text-text-secondary dark:text-text-dark-secondary">Setelah menambahkan produk, buka menu <strong>E-Katalog</strong> dan klik <strong>Buat Katalog Baru</strong>. Pilih produk yang ingin ditampilkan dan publikasikan. <a href="{{ route('docs.show', 'e-catalog-setup') }}" class="text-accent hover:underline">Panduan E-Katalog</a>.</p>
            </div>
        </div>

        <!-- FAQ 7 -->
        <div class="border border-light-border/40 dark:border-dark-border/40 rounded-lg p-6">
            <h4 class="font-bold text-text-primary dark:text-text-dark-primary flex items-start gap-3">
                <span class="text-accent text-xl">Q:</span>
                <span>Apakah CoreSite memiliki aplikasi mobile?</span>
            </h4>
            <div class="flex items-start gap-3 mt-2">
                <span class="text-green-600 dark:text-green-400 text-xl">A:</span>
                <p class="text-text-secondary dark:text-text-dark-secondary">Ya, CoreSite tersedia di Google Play Store untuk pengguna mobile dan juga tersedia versi desktop untuk Windows, Mac, dan Linux. <a href="{{ route('docs.show', 'quick-start') }}" class="text-accent hover:underline">Cara mendapatkan CoreSite</a>.</p>
            </div>
        </div>

        <!-- FAQ 8 -->
        <div class="border border-light-border/40 dark:border-dark-border/40 rounded-lg p-6">
            <h4 class="font-bold text-text-primary dark:text-text-dark-primary flex items-start gap-3">
                <span class="text-accent text-xl">Q:</span>
                <span>Bagaimana cara menghubungi dukungan?</span>
            </h4>
            <div class="flex items-start gap-3 mt-2">
                <span class="text-green-600 dark:text-green-400 text-xl">A:</span>
                <p class="text-text-secondary dark:text-text-dark-secondary">Anda dapat menghubungi tim dukungan melalui email <a href="mailto:support@coresite.com" class="text-accent">support@coresite.com</a> atau WhatsApp <a href="https://wa.me/628123456789" class="text-accent">+62 812-3456-789</a>. <a href="{{ route('docs.show', 'support') }}" class="text-accent hover:underline">Halaman dukungan</a>.</p>
            </div>
        </div>
    </div>

    <div class="bg-accent/5 border-l-4 border-accent rounded-r-lg p-4 my-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-accent flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <strong class="text-accent text-lg">Masih Ada Pertanyaan?</strong><br>
                <span class="text-text-secondary dark:text-text-dark-secondary">Jika pertanyaan Anda tidak terjawab di sini, <a href="{{ route('docs.show', 'support') }}" class="text-accent hover:underline">hubungi tim dukungan kami</a>.</span>
            </div>
        </div>
    </div>
</div>
@endsection