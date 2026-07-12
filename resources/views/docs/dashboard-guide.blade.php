@extends('layouts.docs')

@section('title', 'Panduan Dashboard')

@section('content')
<div class="prose prose-slate dark:prose-invert max-w-none">
    <p class="text-lg text-text-secondary dark:text-text-dark-secondary leading-relaxed">
        Panduan lengkap untuk menggunakan dashboard CoreSite.
    </p>

    <h2>Navigasi Dashboard</h2>
    
    <div class="bg-light-surface dark:bg-dark-surface/50 rounded-lg p-6 my-6">
        <div class="space-y-4">
            <div>
                <h4 class="font-semibold text-text-primary dark:text-text-dark-primary flex items-center gap-2">
                    <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/>
                    </svg>
                    Sidebar
                </h4>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">
                    Terletak di sebelah kiri, berisi semua menu utama CoreSite.
                </p>
            </div>
            <div>
                <h4 class="font-semibold text-text-primary dark:text-text-dark-primary flex items-center gap-2">
                    <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Top Bar
                </h4>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">
                    Berisi notifikasi, profil pengguna, dan pengaturan cepat.
                </p>
            </div>
            <div>
                <h4 class="font-semibold text-text-primary dark:text-text-dark-primary flex items-center gap-2">
                    <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Main Content
                </h4>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">
                    Area utama yang menampilkan data, tabel, grafik, dan formulir.
                </p>
            </div>
        </div>
    </div>

    <h2>Menu Utama</h2>
    <ul>
        <li><strong>Dashboard</strong> - Ringkasan bisnis Anda dengan grafik dan metrik penting</li>
        <li><strong>Produk</strong> - Kelola daftar produk, stok, dan harga</li>
        <li><strong>E-Katalog</strong> - Buat dan kelola katalog digital</li>
        <li><strong>Kasir (POS)</strong> - Lakukan transaksi penjualan</li>
        <li><strong>Laporan</strong> - Lihat laporan penjualan dan analitik</li>
        <li><strong>Pengaturan</strong> - Atur profil toko dan preferensi</li>
    </ul>

    <h2>Tips Menggunakan Dashboard</h2>
    <ul>
        <li>Gunakan fitur <strong>pencarian</strong> untuk menemukan data dengan cepat</li>
        <li>Manfaatkan <strong>filter</strong> untuk menyaring data berdasarkan tanggal atau kategori</li>
        <li>Ekspor data ke <strong>CSV/Excel</strong> untuk analisis lebih lanjut</li>
        <li>Atur <strong>notifikasi</strong> untuk mendapatkan update penting</li>
    </ul>
</div>
@endsection