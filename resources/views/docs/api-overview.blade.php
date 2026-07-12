{{-- resources/views/docs/api-overview.blade.php --}}
@extends('layouts.docs')

@section('title', 'Gambaran API - Dokumentasi CoreSite')

@section('content')
<div class="prose dark:prose-invert max-w-none">
    <p>
        CoreSite menyediakan API yang powerful untuk mengintegrasikan platform dengan sistem dan aplikasi lain.
    </p>

    <div class="bg-accent/5 border-l-4 border-accent rounded-r-lg p-4 my-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-accent flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9"/>
            </svg>
            <div>
                <strong class="text-accent text-lg">Apa itu API CoreSite?</strong><br>
                <span class="text-text-secondary dark:text-text-dark-secondary">API (Application Programming Interface) CoreSite memungkinkan pengembang untuk mengintegrasikan CoreSite dengan aplikasi pihak ketiga secara programatik.</span>
            </div>
        </div>
    </div>

    <h2>Fitur API</h2>

    <ul>
        <li><strong>Autentikasi</strong> — Menggunakan token API untuk akses yang aman</li>
        <li><strong>Manajemen Produk</strong> — CRUD (Create, Read, Update, Delete) untuk produk</li>
        <li><strong>Manajemen Transaksi</strong> — Akses dan kelola data transaksi</li>
        <li><strong>Laporan & Analitik</strong> — Ambil data laporan secara programatik</li>
        <li><strong>E-Katalog</strong> — Kelola katalog produk melalui API</li>
    </ul>

    <div class="bg-yellow-50 dark:bg-yellow-950/30 border-l-4 border-yellow-500 rounded-r-lg p-4 my-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <strong class="text-yellow-700 dark:text-yellow-400 text-lg">Catatan:</strong>
                <span class="text-text-secondary dark:text-text-dark-secondary">API CoreSite hanya tersedia untuk pengguna paket Business dan Enterprise. <a href="{{ route('docs.show', 'subscription') }}" class="text-accent hover:underline">Upgrade paket Anda</a>.</span>
            </div>
        </div>
    </div>

    <h2>Base URL</h2>
    <pre><code>https://api.coresite.com/v1</code></pre>

    <h2>Endpoint Utama</h2>
    <ul>
        <li><code>/products</code> — Manajemen produk</li>
        <li><code>/transactions</code> — Manajemen transaksi</li>
        <li><code>/reports</code> — Laporan dan analitik</li>
        <li><code>/catalog</code> — Manajemen E-Katalog</li>
        <li><code>/users</code> — Manajemen pengguna</li>
    </ul>

    <div class="bg-accent/5 border-l-4 border-accent rounded-r-lg p-4 my-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-accent flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <strong class="text-accent text-lg">Lanjutkan Membaca</strong><br>
                <ul class="mt-2 text-text-secondary dark:text-text-dark-secondary">
                    <li><a href="{{ route('docs.show', 'authentication') }}" class="text-accent hover:underline">Autentikasi API</a> — Cara mengautentikasi permintaan API</li>
                    <li><a href="{{ route('docs.show', 'endpoints') }}" class="text-accent hover:underline">Endpoint API</a> — Dokumentasi lengkap semua endpoint</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection