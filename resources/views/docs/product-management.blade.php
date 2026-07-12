{{-- resources/views/docs/product-management.blade.php --}}
@extends('layouts.docs')

@section('title', 'Manajemen Produk - Dokumentasi CoreSite')

@section('content')
<div class="prose dark:prose-invert max-w-none">
    <p>
        Kelola semua produk Anda dari satu dashboard. Tambahkan, edit, hapus, dan pantau stok produk dengan mudah.
    </p>

    <div class="bg-accent/5 border-l-4 border-accent rounded-r-lg p-4 my-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-accent flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
            </svg>
            <div>
                <strong class="text-accent text-lg">Apa itu Manajemen Produk?</strong><br>
                <span class="text-text-secondary dark:text-text-dark-secondary">Fitur ini memungkinkan Anda mengelola katalog produk, stok, harga, dan informasi produk lainnya secara terpusat.</span>
            </div>
        </div>
    </div>

    <h2>Mengakses Manajemen Produk</h2>
    
    <ol>
        <li>Login ke dashboard admin</li>
        <li>Klik menu <strong>Produk</strong> di sidebar kiri</li>
        <li>Anda akan melihat daftar semua produk Anda</li>
    </ol>

    <h2>Menambahkan Produk Baru</h2>

    <h3>1. Klik Tombol "Tambah Produk"</h3>
    <p>Di halaman daftar produk, klik tombol <span class="px-2 py-0.5 text-xs font-medium text-white bg-accent rounded">Tambah Produk</span> di pojok kanan atas.</p>

    <h3>2. Isi Form Produk</h3>
    <ul>
        <li><strong>Nama Produk</strong> — Nama produk yang akan ditampilkan</li>
        <li><strong>Kategori</strong> — Pilih kategori produk</li>
        <li><strong>Deskripsi</strong> — Deskripsi lengkap produk</li>
        <li><strong>Harga</strong> — Harga jual produk</li>
        <li><strong>Stok</strong> — Jumlah stok yang tersedia</li>
        <li><strong>Minimal Stok Peringatan</strong> — Notifikasi saat stok mencapai angka ini</li>
        <li><strong>Status</strong> — Aktif/nonaktif produk</li>
    </ul>

    <h3>3. Simpan Produk</h3>
    <p>Klik tombol <span class="px-2 py-0.5 text-xs font-medium text-white bg-green-600 rounded">Simpan</span> untuk menyimpan produk baru.</p>

    <h2>Mengelola Stok</h2>

    <h3>Melacak Stok</h3>
    <p>Stok produk dapat dilihat di kolom "Stok" pada tabel daftar produk. Stok akan diperbarui secara otomatis setiap kali ada transaksi penjualan.</p>

    <h3>Peringatan Stok Menipis</h3>
    <p>Ketika stok produk mencapai batas minimal yang ditentukan, sistem akan menampilkan peringatan di dashboard.</p>

    <div class="bg-yellow-50 dark:bg-yellow-950/30 border-l-4 border-yellow-500 rounded-r-lg p-4 my-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <div>
                <strong class="text-yellow-700 dark:text-yellow-400 text-lg">Tips:</strong>
                <span class="text-text-secondary dark:text-text-dark-secondary">Atur <strong>Minimal Stok Peringatan</strong> untuk setiap produk agar Anda selalu tahu kapan harus restok.</span>
            </div>
        </div>
    </div>

    <h2>Mengedit Produk</h2>
    
    <ol>
        <li>Buka halaman daftar produk</li>
        <li>Klik tombol <span class="px-2 py-0.5 text-xs font-medium text-white bg-blue-600 rounded">Edit</span> pada produk yang ingin diedit</li>
        <li>Ubah informasi yang diperlukan</li>
        <li>Klik <span class="px-2 py-0.5 text-xs font-medium text-white bg-green-600 rounded">Simpan</span></li>
    </ol>

    <h2>Menghapus Produk</h2>
    
    <div class="bg-red-50 dark:bg-red-950/30 border-l-4 border-red-500 rounded-r-lg p-4 my-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div>
                <strong class="text-red-700 dark:text-red-400 text-lg">Perhatian:</strong>
                <span class="text-text-secondary dark:text-text-dark-secondary">Menghapus produk akan menghapus semua data terkait produk tersebut, termasuk riwayat inventaris.</span>
            </div>
        </div>
    </div>
    
    <ol>
        <li>Buka halaman daftar produk</li>
        <li>Klik tombol <span class="px-2 py-0.5 text-xs font-medium text-white bg-red-600 rounded">Hapus</span> pada produk yang ingin dihapus</li>
        <li>Konfirmasi penghapusan</li>
    </ol>

    <h2>Ekspor & Impor Produk</h2>

    <h3>Ekspor Produk</h3>
    <p>Klik tombol <span class="px-2 py-0.5 text-xs font-medium text-white bg-gray-600 rounded">Export</span> untuk mengekspor data produk ke file Excel atau PDF.</p>

    <h3>Impor Produk</h3>
    <p>Klik tombol <span class="px-2 py-0.5 text-xs font-medium text-white bg-gray-600 rounded">Import</span> untuk mengimpor produk dari file Excel.</p>

    <div class="bg-accent/5 border-l-4 border-accent rounded-r-lg p-4 my-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-accent flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <div>
                <strong class="text-accent text-lg">Format File Impor:</strong>
                <ul class="mt-2 text-text-secondary dark:text-text-dark-secondary">
                    <li>File harus dalam format .xlsx atau .csv</li>
                    <li>Kolom yang diperlukan: name, price, stock</li>
                    <li>Kolom opsional: category, description, min_stock_alert</li>
                </ul>
            </div>
        </div>
    </div>

    <h2>Tips Manajemen Produk</h2>

    <ul>
        <li><strong>Gunakan Kategori</strong> — Kelompokkan produk dalam kategori untuk memudahkan pencarian</li>
        <li><strong>Update Stok Secara Teratur</strong> — Pastikan stok selalu akurat</li>
        <li><strong>Gunakan Deskripsi yang Jelas</strong> — Deskripsi yang baik membantu pelanggan memahami produk</li>
        <li><strong>Pantau Produk Terlaris</strong> — Fokus pada produk yang paling laris</li>
    </ul>
</div>
@endsection