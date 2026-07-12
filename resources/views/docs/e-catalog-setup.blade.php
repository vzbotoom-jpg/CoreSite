{{-- resources/views/docs/e-catalog-setup.blade.php --}}
@extends('layouts.docs')

@section('title', 'Pengaturan E-Katalog - Dokumentasi CoreSite')

@section('content')
<div class="prose dark:prose-invert max-w-none">
    <p>
        Buat dan kelola toko online profesional dengan E-Katalog CoreSite. Pelanggan dapat melihat produk Anda melalui URL unik.
    </p>

    <div class="bg-accent/5 border-l-4 border-accent rounded-r-lg p-4 my-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-accent flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9"/>
            </svg>
            <div>
                <strong class="text-accent text-lg">Apa itu E-Katalog?</strong><br>
                <span class="text-text-secondary dark:text-text-dark-secondary">E-Katalog adalah halaman publik yang menampilkan semua produk toko Anda. Pelanggan dapat melihat produk, harga, dan detail tanpa harus login.</span>
            </div>
        </div>
    </div>

    <h2>URL E-Katalog</h2>
    
    <p>
        Setiap toko memiliki URL E-Katalog unik:
    </p>
    <pre><code>https://coresite.com/[slug-toko]</code></pre>
    
    <p>
        Contoh: <code>https://coresite.com/toko-kopi</code>
    </p>

    <div class="bg-yellow-50 dark:bg-yellow-950/30 border-l-4 border-yellow-500 rounded-r-lg p-4 my-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <div>
                <strong class="text-yellow-700 dark:text-yellow-400 text-lg">Tips:</strong>
                <span class="text-text-secondary dark:text-text-dark-secondary">Pilih slug yang mudah diingat dan relevan dengan bisnis Anda.</span>
            </div>
        </div>
    </div>

    <h2>Mengatur Tampilan E-Katalog</h2>

    <h3>1. Logo Toko</h3>
    <p>Upload logo toko melalui menu <strong>Pengaturan → Profil</strong>. Logo akan muncul di header E-Katalog.</p>

    <h3>2. Informasi Toko</h3>
    <p>Isi informasi toko seperti nama, alamat, dan kontak di menu <strong>Pengaturan → Profil</strong>.</p>

    <h3>3. Tampilan Produk</h3>
    <p>Produk yang aktif akan otomatis muncul di E-Katalog. Atur urutan tampilan melalui menu <strong>Produk</strong>.</p>

    <h2>Fitur E-Katalog</h2>

    <h3>Pencarian Produk</h3>
    <p>Pelanggan dapat mencari produk berdasarkan nama atau kategori.</p>

    <h3>Filter Kategori</h3>
    <p>Pelanggan dapat memfilter produk berdasarkan kategori.</p>

    <h3>Detail Produk</h3>
    <p>Klik produk untuk melihat detail lengkap termasuk deskripsi, harga, dan stok.</p>

    <h3>Responsive Design</h3>
    <p>E-Katalog dapat diakses dari semua perangkat (desktop, tablet, mobile).</p>

    <h2>Kustomisasi Tampilan</h2>

    <h3>Warna Tema</h3>
    <p>Kustomisasi warna tema sesuai dengan brand Anda di menu <strong>Pengaturan → Preferensi</strong>.</p>

    <div class="bg-accent/5 border-l-4 border-accent rounded-r-lg p-4 my-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-accent flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
            </svg>
            <div>
                <strong class="text-accent text-lg">Warna yang Dapat Dikustomisasi:</strong>
                <ul class="mt-2 text-text-secondary dark:text-text-dark-secondary">
                    <li>Warna utama (Primary)</li>
                    <li>Warna aksen (Accent)</li>
                    <li>Warna latar belakang</li>
                    <li>Warna teks</li>
                </ul>
            </div>
        </div>
    </div>

    <h2>Tips E-Katalog</h2>

    <ul>
        <li>
            <svg class="w-4 h-4 inline-block text-accent mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <strong>Gunakan Gambar Produk Berkualitas</strong> — Gambar yang baik meningkatkan kepercayaan pelanggan
        </li>
        <li>
            <svg class="w-4 h-4 inline-block text-accent mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            <strong>Deskripsi Produk yang Jelas</strong> — Bantu pelanggan memahami produk Anda
        </li>
        <li>
            <svg class="w-4 h-4 inline-block text-accent mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <strong>Update Harga Secara Teratur</strong> — Pastikan harga selalu akurat
        </li>
        <li>
            <svg class="w-4 h-4 inline-block text-accent mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
            </svg>
            <strong>Promosikan URL E-Katalog</strong> — Sebarkan URL toko Anda di media sosial
        </li>
    </ul>
</div>
@endsection