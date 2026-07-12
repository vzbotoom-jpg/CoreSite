{{-- resources/views/landing/guides.blade.php --}}
@extends('layouts.guest')

@section('title', 'Panduan - CoreSite')
@section('description', 'Panduan lengkap menggunakan CoreSite.')

@section('content')
<section class="py-20">
    <div class="container mx-auto px-4 max-w-4xl">
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-bold text-text-primary dark:text-text-dark-primary mb-4">
                <span class="text-accent">Panduan</span> Penggunaan
            </h1>
            <p class="text-text-secondary dark:text-text-dark-secondary">
                Pelajari cara menggunakan CoreSite dengan panduan langkah demi langkah
            </p>
        </div>

        <div class="space-y-4">
            <a href="#" class="card hover:shadow-lg transition block">
                <div class="card-body flex items-center gap-4">
                    <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center flex-shrink-0">
                        <span class="text-2xl">📖</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Panduan Memulai CoreSite</h4>
                        <p class="text-sm text-text-secondary">Pelajari dasar-dasar penggunaan CoreSite dalam 10 menit</p>
                    </div>
                    <svg class="w-5 h-5 text-text-secondary ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            <a href="#" class="card hover:shadow-lg transition block">
                <div class="card-body flex items-center gap-4">
                    <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center flex-shrink-0">
                        <span class="text-2xl">🛒</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Cara Menambahkan Produk</h4>
                        <p class="text-sm text-text-secondary">Panduan menambahkan dan mengelola produk di toko Anda</p>
                    </div>
                    <svg class="w-5 h-5 text-text-secondary ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            <a href="#" class="card hover:shadow-lg transition block">
                <div class="card-body flex items-center gap-4">
                    <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center flex-shrink-0">
                        <span class="text-2xl">💰</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Mengelola Transaksi</h4>
                        <p class="text-sm text-text-secondary">Cara mencatat dan mengelola transaksi penjualan</p>
                    </div>
                    <svg class="w-5 h-5 text-text-secondary ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            <a href="#" class="card hover:shadow-lg transition block">
                <div class="card-body flex items-center gap-4">
                    <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center flex-shrink-0">
                        <span class="text-2xl">📊</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Membaca Laporan Keuangan</h4>
                        <p class="text-sm text-text-secondary">Memahami laporan keuangan dan analisis bisnis Anda</p>
                    </div>
                    <svg class="w-5 h-5 text-text-secondary ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            <a href="#" class="card hover:shadow-lg transition block">
                <div class="card-body flex items-center gap-4">
                    <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center flex-shrink-0">
                        <span class="text-2xl">📱</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Mengatur E-Catalog Publik</h4>
                        <p class="text-sm text-text-secondary">Tips membuat halaman toko online yang menarik</p>
                    </div>
                    <svg class="w-5 h-5 text-text-secondary ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>
        </div>
    </div>
</section>
@endsection