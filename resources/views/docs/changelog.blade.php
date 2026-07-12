{{-- resources/views/docs/changelog.blade.php --}}
@extends('layouts.docs')

@section('title', 'Riwayat Pembaruan - Dokumentasi CoreSite')

@section('content')
<div class="prose dark:prose-invert max-w-none">
    <p>
        Semua perubahan dan pembaruan pada platform CoreSite dicatat di sini.
    </p>

    <!-- v1.2.0 -->
    <div class="mt-8">
        <div class="flex items-center gap-3 mb-2">
            <span class="text-xl font-bold text-accent">v1.2.0</span>
            <span class="text-sm text-text-secondary/60">17 Juni 2026</span>
            <span class="px-2 py-0.5 text-xs font-medium text-green-700 bg-green-100 dark:bg-green-900/30 dark:text-green-300 rounded-full">Terbaru</span>
        </div>
        <ul class="space-y-1 text-text-secondary dark:text-text-dark-secondary">
            <li class="flex items-start gap-2">
                <svg class="w-5 h-5 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Menambahkan fitur ekspor laporan keuangan ke Excel</span>
            </li>
            <li class="flex items-start gap-2">
                <svg class="w-5 h-5 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Meningkatkan performa dashboard admin</span>
            </li>
            <li class="flex items-start gap-2">
                <svg class="w-5 h-5 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Memperbaiki bug pada sistem kasir</span>
            </li>
            <li class="flex items-start gap-2">
                <svg class="w-5 h-5 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Menambahkan notifikasi stok menipis</span>
            </li>
        </ul>
    </div>

    <!-- v1.1.0 -->
    <div class="mt-8 pt-8 border-t border-light-border/40 dark:border-dark-border/40">
        <div class="flex items-center gap-3 mb-2">
            <span class="text-xl font-bold text-text-primary dark:text-text-dark-primary">v1.1.0</span>
            <span class="text-sm text-text-secondary/60">10 Juni 2026</span>
        </div>
        <ul class="space-y-1 text-text-secondary dark:text-text-dark-secondary">
            <li class="flex items-start gap-2">
                <svg class="w-5 h-5 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Menambahkan fitur multi-user untuk toko</span>
            </li>
            <li class="flex items-start gap-2">
                <svg class="w-5 h-5 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Integrasi QRIS untuk pembayaran</span>
            </li>
            <li class="flex items-start gap-2">
                <svg class="w-5 h-5 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Menambahkan laporan penjualan harian</span>
            </li>
        </ul>
    </div>

    <!-- v1.0.0 -->
    <div class="mt-8 pt-8 border-t border-light-border/40 dark:border-dark-border/40">
        <div class="flex items-center gap-3 mb-2">
            <span class="text-xl font-bold text-text-primary dark:text-text-dark-primary">v1.0.0</span>
            <span class="text-sm text-text-secondary/60">1 Juni 2026</span>
            <span class="px-2 py-0.5 text-xs font-medium text-blue-700 bg-blue-100 dark:bg-blue-900/30 dark:text-blue-300 rounded-full">Rilis Pertama</span>
        </div>
        <ul class="space-y-1 text-text-secondary dark:text-text-dark-secondary">
            <li class="flex items-start gap-2">
                <svg class="w-5 h-5 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Peluncuran platform CoreSite</span>
            </li>
            <li class="flex items-start gap-2">
                <svg class="w-5 h-5 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Fitur toko online dan kasir otomatis</span>
            </li>
            <li class="flex items-start gap-2">
                <svg class="w-5 h-5 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Laporan keuangan dan inventori</span>
            </li>
            <li class="flex items-start gap-2">
                <svg class="w-5 h-5 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Manajemen produk dan stok</span>
            </li>
        </ul>
    </div>
</div>
@endsection