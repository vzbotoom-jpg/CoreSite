{{-- resources/views/docs/authentication.blade.php --}}
@extends('layouts.docs')

@section('title', 'Autentikasi API - Dokumentasi CoreSite')

@section('content')
<div class="prose dark:prose-invert max-w-none">
    <p>
        Pelajari cara mengautentikasi permintaan API CoreSite dengan aman.
    </p>

    <div class="bg-accent/5 border-l-4 border-accent rounded-r-lg p-4 my-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-accent flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            <div>
                <strong class="text-accent text-lg">Keamanan API</strong><br>
                <span class="text-text-secondary dark:text-text-dark-secondary">Semua permintaan API CoreSite harus diautentikasi menggunakan API Token untuk memastikan keamanan data Anda.</span>
            </div>
        </div>
    </div>

    <h2>Mendapatkan API Token</h2>

    <ol>
        <li>Login ke dashboard CoreSite</li>
        <li>Buka menu <strong>Pengaturan → API</strong></li>
        <li>Klik tombol <span class="px-2 py-0.5 text-xs font-medium text-white bg-accent rounded">Buat API Token</span></li>
        <li>Berikan nama untuk token (misalnya: "Aplikasi Mobile")</li>
        <li>Salin dan simpan token yang dihasilkan</li>
    </ol>

    <div class="bg-red-50 dark:bg-red-950/30 border-l-4 border-red-500 rounded-r-lg p-4 my-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div>
                <strong class="text-red-700 dark:text-red-400 text-lg">Perhatian:</strong>
                <span class="text-text-secondary dark:text-text-dark-secondary">Simpan API Token dengan aman. Jangan pernah membagikan token kepada pihak yang tidak berwenang atau menyimpannya di kode publik.</span>
            </div>
        </div>
    </div>

    <h2>Cara Menggunakan API Token</h2>

    <p>
        Sertakan API Token di header permintaan HTTP:
    </p>

    <pre><code>Authorization: Bearer YOUR_API_TOKEN</code></pre>

    <h3>Contoh Menggunakan cURL</h3>
    <pre><code>curl -X GET \
  https://api.coresite.com/v1/products \
  -H 'Authorization: Bearer YOUR_API_TOKEN'</code></pre>

    <h3>Contoh Menggunakan JavaScript (Fetch)</h3>
    <pre><code>fetch('https://api.coresite.com/v1/products', {
    method: 'GET',
    headers: {
        'Authorization': 'Bearer YOUR_API_TOKEN',
        'Content-Type': 'application/json'
    }
})
.then(response => response.json())
.then(data => console.log(data));</code></pre>

    <h2>Mengelola API Token</h2>

    <ul>
        <li><strong>Lihat Token Aktif</strong> — Lihat semua token yang telah Anda buat</li>
        <li><strong>Revoke Token</strong> — Batalkan token jika dicurigai terjadi pelanggaran keamanan</li>
        <li><strong>Token Expiry</strong> — Token akan kadaluwarsa setelah periode tertentu</li>
    </ul>

    <div class="bg-yellow-50 dark:bg-yellow-950/30 border-l-4 border-yellow-500 rounded-r-lg p-4 my-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <strong class="text-yellow-700 dark:text-yellow-400 text-lg">Tips:</strong>
                <span class="text-text-secondary dark:text-text-dark-secondary">Buat token terpisah untuk setiap aplikasi atau integrasi untuk memudahkan manajemen akses.</span>
            </div>
        </div>
    </div>

    <div class="bg-accent/5 border-l-4 border-accent rounded-r-lg p-4 my-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-accent flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <strong class="text-accent text-lg">Lanjutkan Membaca</strong><br>
                <span class="text-text-secondary dark:text-text-dark-secondary">Pelajari <a href="{{ route('docs.show', 'endpoints') }}" class="text-accent hover:underline">Endpoint API</a> untuk melihat daftar lengkap endpoint yang tersedia.</span>
            </div>
        </div>
    </div>
</div>
@endsection