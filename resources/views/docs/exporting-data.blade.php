{{-- resources/views/docs/exporting-data.blade.php --}}
@extends('layouts.docs')

@section('title', 'Ekspor Data - Dokumentasi CoreSite')

@section('content')
<div class="prose dark:prose-invert max-w-none">
    <p>
        Ekspor data bisnis Anda untuk analisis lebih lanjut atau kebutuhan pelaporan.
    </p>

    <div class="bg-accent/5 border-l-4 border-accent rounded-r-lg p-4 my-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-accent flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            <div>
                <strong class="text-accent text-lg">Apa itu Ekspor Data?</strong><br>
                <span class="text-text-secondary dark:text-text-dark-secondary">Fitur ini memungkinkan Anda mengekspor data produk, transaksi, dan laporan ke berbagai format file.</span>
            </div>
        </div>
    </div>

    <h2>Format Ekspor yang Didukung</h2>
    
    <div class="grid md:grid-cols-3 gap-4 my-6">
        <div class="bg-light-surface dark:bg-dark-surface/50 rounded-lg p-4 border border-light-border/40 dark:border-dark-border/40 text-center">
            <svg class="w-10 h-10 text-accent mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/>
            </svg>
            <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Excel (.xlsx)</h4>
            <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Untuk analisis data lanjutan</p>
        </div>
        
        <div class="bg-light-surface dark:bg-dark-surface/50 rounded-lg p-4 border border-light-border/40 dark:border-dark-border/40 text-center">
            <svg class="w-10 h-10 text-accent mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
            </svg>
            <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">PDF</h4>
            <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Untuk laporan profesional</p>
        </div>
        
        <div class="bg-light-surface dark:bg-dark-surface/50 rounded-lg p-4 border border-light-border/40 dark:border-dark-border/40 text-center">
            <svg class="w-10 h-10 text-accent mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
            </svg>
            <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">CSV</h4>
            <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Untuk kompatibilitas universal</p>
        </div>
    </div>

    <h2>Jenis Data yang Dapat Diekspor</h2>
    
    <ul>
        <li><strong>Data Produk</strong> — Nama, harga, stok, kategori, dan deskripsi produk</li>
        <li><strong>Data Transaksi</strong> — Riwayat penjualan, metode pembayaran, dan total transaksi</li>
        <li><strong>Laporan Keuangan</strong> — Pendapatan, pengeluaran, dan profitabilitas</li>
        <li><strong>Data Pelanggan</strong> — Informasi pelanggan dan riwayat pembelian</li>
        <li><strong>Laporan Inventaris</strong> — Stok produk dan peringatan stok menipis</li>
    </ul>

    <h2>Cara Mengekspor Data</h2>

    <h3>1. Buka Halaman yang Ingin Diekspor</h3>
    <p>
        Navigasi ke halaman yang berisi data yang ingin Anda ekspor, misalnya:
    </p>
    <ul>
        <li>Produk → Daftar Produk</li>
        <li>Laporan → Laporan Penjualan</li>
        <li>Kasir → Riwayat Transaksi</li>
    </ul>

    <h3>2. Klik Tombol Ekspor</h3>
    <p>
        Cari dan klik tombol <span class="px-2 py-0.5 text-xs font-medium text-white bg-accent rounded">Ekspor</span> atau <span class="px-2 py-0.5 text-xs font-medium text-white bg-accent rounded">Download</span> di halaman tersebut.
    </p>

    <h3>3. Pilih Format File</h3>
    <p>
        Pilih format file yang diinginkan (Excel, PDF, atau CSV).
    </p>

    <h3>4. Unduh File</h3>
    <p>
        File akan otomatis terunduh ke perangkat Anda.
    </p>

    <div class="bg-yellow-50 dark:bg-yellow-950/30 border-l-4 border-yellow-500 rounded-r-lg p-4 my-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <strong class="text-yellow-700 dark:text-yellow-400 text-lg">Tips:</strong>
                <span class="text-text-secondary dark:text-text-dark-secondary">Gunakan filter tanggal dan kategori sebelum mengekspor untuk mendapatkan data yang lebih spesifik.</span>
            </div>
        </div>
    </div>

    <div class="bg-red-50 dark:bg-red-950/30 border-l-4 border-red-500 rounded-r-lg p-4 my-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div>
                <strong class="text-red-700 dark:text-red-400 text-lg">Perhatian:</strong>
                <span class="text-text-secondary dark:text-text-dark-secondary">Data yang diekspor mungkin berisi informasi sensitif. Simpan file dengan aman dan jangan bagikan kepada pihak yang tidak berwenang.</span>
            </div>
        </div>
    </div>
</div>
@endsection