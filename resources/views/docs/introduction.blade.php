{{-- resources/views/docs/introduction.blade.php --}}
@extends('layouts.docs')

@section('title', 'Pengenalan - Dokumentasi CoreSite')

@section('content')
<div class="prose dark:prose-invert max-w-none">
    <p>
        Selamat datang di <strong>CoreSite</strong> — platform e-commerce dan kasir yang dapat di-hosting sendiri yang menghubungkan toko dan saluran penjualan Anda ke sistem manajemen bisnis yang cerdas.
    </p>

    <div class="bg-accent/5 border-l-4 border-accent rounded-r-lg p-4 my-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-accent flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
            </svg>
            <div>
                <strong class="text-accent text-lg">Apa itu CoreSite?</strong><br>
                <span class="text-text-secondary dark:text-text-dark-secondary">CoreSite adalah platform SaaS Multi-Tenant yang memberdayakan bisnis UMKM dengan toko online profesional, sistem kasir otomatis, dan manajemen inventaris yang komprehensif — semuanya dari satu dashboard.</span>
            </div>
        </div>
    </div>

    <h2>Apa yang Dapat Dilakukan CoreSite</h2>
    
    <ul>
        <li><strong>Toko Online (E-Katalog):</strong> Buat katalog produk profesional yang dapat diakses melalui URL unik Anda sendiri (<code>coresite.com/toko-anda</code>)</li>
        <li><strong>Sistem Kasir:</strong> Proses transaksi, kelola inventaris, dan lacak penjualan secara real-time</li>
        <li><strong>Manajemen Inventaris:</strong> Lacak tingkat stok, atur peringatan stok rendah, dan kelola varian produk</li>
        <li><strong>Laporan Keuangan:</strong> Hasilkan laporan penjualan, laporan laba-rugi, dan analitik pendapatan</li>
        <li><strong>Dukungan Multi-User:</strong> Kelola beberapa akun staf dengan izin berbasis peran</li>
    </ul>

    <h2>Untuk Siapa CoreSite?</h2>
    
    <p>
        <strong>CoreSite dirancang untuk bisnis UMKM</strong> — usaha kecil dan menengah, toko ritel, kafe, dan penjual e-commerce yang ingin mendigitalkan operasi mereka tanpa kerumitan perangkat lunak perusahaan.
    </p>


    <h2>Fitur Utama</h2>
    
    <h3>1. Arsitektur Multi-Tenant</h3>
    <p>
        Setiap pemilik toko mendapatkan lingkungan terisolasi mereka sendiri. Data dipisahkan dengan aman menggunakan foreign key <code>store_id</code> yang memastikan tidak ada penyewa yang dapat mengakses data penyewa lain.
    </p>

    <h3>2. E-Katalog Profesional</h3>
    <p>
        Tampilkan produk Anda dengan halaman toko yang indah. Sesuaikan tampilan dan nuansa agar sesuai dengan merek Anda.
    </p>

    <h3>3. Sistem Kasir Otomatis</h3>
    <p>
        Proses penjualan dengan cepat menggunakan antarmuka kasir yang intuitif. Lacak inventaris secara otomatis, kelola data pelanggan, dan hasilkan faktur.
    </p>

    <h3>4. Inventaris Real-Time</h3>
    <p>
        Tingkat stok diperbarui secara otomatis dengan setiap penjualan. Dapatkan peringatan saat barang hampir habis.
    </p>

    <h2>Bagaimana Cara Kerjanya</h2>
    
    <p>
        CoreSite bekerja sebagai satu platform yang melayani banyak toko. Setiap pemilik toko mendaftar dan mendapatkan:
    </p>
    
    <ol>
        <li>URL toko unik (misalnya, <code>coresite.com/toko-anda</code>)</li>
        <li>Dashboard admin untuk mengelola produk, transaksi, dan laporan</li>
        <li>E-katalog publik untuk pelanggan melihat produk</li>
    </ol>

    <div class="bg-accent/5 border-l-4 border-accent rounded-r-lg p-4 my-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-accent flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
            </svg>
            <div>
                <strong class="text-accent text-lg">Siap untuk memulai?</strong><br>
                <span class="text-text-secondary dark:text-text-dark-secondary">Lanjutkan ke <a href="{{ route('docs.show', 'quick-start') }}" class="text-accent hover:underline">Mulai Cepat</a> untuk mengatur CoreSite dalam hitungan menit.</span>
            </div>
        </div>
    </div>
</div>
@endsection