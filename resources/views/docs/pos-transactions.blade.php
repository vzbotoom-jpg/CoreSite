{{-- resources/views/docs/pos-transactions.blade.php --}}
@extends('layouts.docs')

@section('title', 'Transaksi Kasir (POS) - Dokumentasi CoreSite')

@section('content')
<div class="prose prose-slate dark:prose-invert max-w-none">
    <p class="text-lg text-text-secondary dark:text-text-dark-secondary leading-relaxed">
        Sistem Point of Sale (POS) CoreSite memungkinkan Anda memproses transaksi penjualan dengan cepat dan akurat.
    </p>

    <div class="bg-accent/5 border-l-4 border-accent rounded-r-lg p-4 my-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-accent flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
            </svg>
            <div>
                <strong class="text-accent text-lg">Apa itu POS?</strong><br>
                <span class="text-text-secondary dark:text-text-dark-secondary">POS (Point of Sale) adalah sistem yang digunakan untuk memproses transaksi penjualan di toko fisik atau online.</span>
            </div>
        </div>
    </div>

    <h2>Mengakses Fitur Kasir</h2>
    
    <ol>
        <li>Login ke dashboard admin</li>
        <li>Klik menu <strong>Kasir</strong> di sidebar kiri</li>
        <li>Anda akan melihat antarmuka kasir</li>
    </ol>

    <h2>Melakukan Transaksi</h2>

    <h3>1. Cari Produk</h3>
    <p>
        Gunakan fitur pencarian untuk menemukan produk yang akan dijual. Anda dapat mencari berdasarkan:
    </p>
    <ul>
        <li>Nama produk</li>
        <li>Kode produk/SKU</li>
        <li>Kategori produk</li>
    </ul>

    <h3>2. Tambahkan ke Keranjang</h3>
    <p>
        Klik produk yang ditemukan untuk menambahkannya ke keranjang belanja. Atur jumlah barang yang dibeli.
    </p>

    <h3>3. Atur Jumlah & Diskon</h3>
    <ul>
        <li><strong>Jumlah:</strong> Sesuaikan kuantitas barang</li>
        <li><strong>Diskon:</strong> Terapkan diskon per item atau total transaksi</li>
    </ul>

    <h3>4. Pilih Metode Pembayaran</h3>
    <p>
        Pilih metode pembayaran yang digunakan pelanggan:
    </p>
    <ul>
        <li>Tunai</li>
        <li>Kartu Kredit/Debit</li>
        <li>E-Wallet (OVO, GoPay, DANA)</li>
        <li>QRIS</li>
        <li>Transfer Bank</li>
    </ul>

    <h3>5. Selesaikan Transaksi</h3>
    <p>
        Klik tombol <strong>Selesaikan Transaksi</strong> untuk menyelesaikan penjualan.
    </p>

    <div class="bg-green-50 dark:bg-green-950/30 border-l-4 border-green-500 rounded-r-lg p-4 my-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <strong class="text-green-700 dark:text-green-400 text-lg">Transaksi Selesai!</strong><br>
                <span class="text-text-secondary dark:text-text-dark-secondary">Sistem akan:</span>
                <ul class="mt-2 text-text-secondary dark:text-text-dark-secondary">
                    <li>Mengurangi stok produk secara otomatis</li>
                    <li>Mencatat transaksi dalam laporan penjualan</li>
                    <li>Menghasilkan faktur/invoice</li>
                </ul>
            </div>
        </div>
    </div>

    <h2>Mencetak Invoice</h2>
    <p>
        Setelah transaksi selesai, Anda dapat mencetak invoice untuk pelanggan:
    </p>
    <ol>
        <li>Klik tombol <strong>Cetak Invoice</strong></li>
        <li>Invoice akan terbuka dalam format PDF</li>
        <li>Cetak atau kirimkan ke pelanggan</li>
    </ol>

    <h2>Membatalkan Transaksi</h2>
    
    <div class="bg-red-50 dark:bg-red-950/30 border-l-4 border-red-500 rounded-r-lg p-4 my-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div>
                <strong class="text-red-700 dark:text-red-400 text-lg">Perhatian:</strong>
                <span class="text-text-secondary dark:text-text-dark-secondary">Pembatalan transaksi akan mengembalikan stok produk dan menghapus catatan transaksi.</span>
            </div>
        </div>
    </div>
    
    <ol>
        <li>Buka halaman <strong>Riwayat Transaksi</strong></li>
        <li>Cari transaksi yang ingin dibatalkan</li>
        <li>Klik tombol <strong>Batalkan</strong></li>
        <li>Konfirmasi pembatalan</li>
    </ol>

    <h2>Tips Menggunakan POS</h2>

    <ul>
        <li>
            <svg class="w-4 h-4 inline-block text-accent mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
            </svg>
            <strong>Scan Barcode</strong> — Gunakan scanner barcode untuk input produk yang lebih cepat
        </li>
        <li>
            <svg class="w-4 h-4 inline-block text-accent mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <strong>Shortcut Keyboard</strong> — Pelajari shortcut keyboard untuk mempercepat proses
        </li>
        <li>
            <svg class="w-4 h-4 inline-block text-accent mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
            </svg>
            <strong>Cek Stok</strong> — Pastikan stok produk tersedia sebelum transaksi
        </li>
        <li>
            <svg class="w-4 h-4 inline-block text-accent mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <strong>Pelanggan</strong> — Catat data pelanggan untuk program loyalitas
        </li>
    </ul>

    <div class="bg-light-surface dark:bg-dark-surface/50 rounded-lg p-4 my-6 border border-light-border/40 dark:border-dark-border/40">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-accent flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <div>
                <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Shortcut Keyboard</h4>
                <ul class="text-sm text-text-secondary dark:text-text-dark-secondary">
                    <li><kbd class="px-2 py-1 bg-light-bg dark:bg-dark-bg border border-light-border/40 dark:border-dark-border/40 rounded text-xs">F2</kbd> - Fokus ke pencarian produk</li>
                    <li><kbd class="px-2 py-1 bg-light-bg dark:bg-dark-bg border border-light-border/40 dark:border-dark-border/40 rounded text-xs">Enter</kbd> - Tambahkan produk ke keranjang</li>
                    <li><kbd class="px-2 py-1 bg-light-bg dark:bg-dark-bg border border-light-border/40 dark:border-dark-border/40 rounded text-xs">F9</kbd> - Selesaikan transaksi</li>
                    <li><kbd class="px-2 py-1 bg-light-bg dark:bg-dark-bg border border-light-border/40 dark:border-dark-border/40 rounded text-xs">Esc</kbd> - Batalkan transaksi</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection