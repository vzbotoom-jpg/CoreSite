@extends('layouts.docs')

@section('title', 'Laporan & Analitik')

@section('content')
<div class="prose prose-slate dark:prose-invert max-w-none">
    <p class="text-lg text-text-secondary dark:text-text-dark-secondary leading-relaxed">
        Pantau performa bisnis Anda dengan laporan dan analitik yang komprehensif.
    </p>

    <h2>Jenis Laporan</h2>
    
    <div class="grid md:grid-cols-2 gap-4 my-6">
        <div class="bg-light-surface dark:bg-dark-surface/50 rounded-lg p-4">
            <div class="flex items-center gap-3 mb-2">
                <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Laporan Penjualan</h4>
            </div>
            <p class="text-sm text-text-secondary dark:text-text-dark-secondary">
                Lihat total penjualan, produk terlaris, dan tren penjualan.
            </p>
        </div>
        
        <div class="bg-light-surface dark:bg-dark-surface/50 rounded-lg p-4">
            <div class="flex items-center gap-3 mb-2">
                <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Laporan Produk</h4>
            </div>
            <p class="text-sm text-text-secondary dark:text-text-dark-secondary">
                Analisis performa produk, stok, dan kategori.
            </p>
        </div>
        
        <div class="bg-light-surface dark:bg-dark-surface/50 rounded-lg p-4">
            <div class="flex items-center gap-3 mb-2">
                <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Laporan Keuangan</h4>
            </div>
            <p class="text-sm text-text-secondary dark:text-text-dark-secondary">
                Pantau pendapatan, pengeluaran, dan profitabilitas.
            </p>
        </div>
        
        <div class="bg-light-surface dark:bg-dark-surface/50 rounded-lg p-4">
            <div class="flex items-center gap-3 mb-2">
                <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Laporan Pelanggan</h4>
            </div>
            <p class="text-sm text-text-secondary dark:text-text-dark-secondary">
                Analisis perilaku pelanggan dan pola pembelian.
            </p>
        </div>
    </div>

    <h2>Fitur Analitik</h2>
    <ul>
        <li><strong>Dashboard Real-time</strong> - Data diperbarui secara langsung</li>
        <li><strong>Filter Kustom</strong> - Filter berdasarkan tanggal, produk, atau kategori</li>
        <li><strong>Export Data</strong> - Ekspor dalam format CSV, Excel, atau PDF</li>
        <li><strong>Visualisasi Grafik</strong> - Grafik batang, garis, dan pie chart</li>
    </ul>

    <div class="bg-accent/5 border-l-4 border-accent rounded-r-lg p-6 my-8">
        <div class="flex items-start gap-4">
            <svg class="w-6 h-6 text-accent flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Analitik Lanjutan</h4>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">
                    Untuk pengguna Business dan Enterprise, tersedia fitur analitik lanjutan 
                    dengan AI dan prediksi tren.
                    <a href="{{ route('docs.show', 'subscription') }}" class="text-accent hover:underline ml-1">Upgrade paket</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection