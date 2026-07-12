{{-- resources/views/landing/changelog.blade.php --}}
@extends('layouts.guest')

@section('title', 'Changelog - CoreSite')
@section('description', 'Riwayat pembaruan dan perubahan pada platform CoreSite.')

@section('content')
<section class="py-20">
    <div class="container mx-auto px-4 max-w-4xl">
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-bold text-text-primary dark:text-text-dark-primary mb-4">
                <span class="text-accent">Changelog</span>
            </h1>
            <p class="text-text-secondary dark:text-text-dark-secondary">
                Riwayat pembaruan dan perbaikan pada platform CoreSite
            </p>
        </div>

        <div class="space-y-12">
            <!-- v1.2.0 -->
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-2xl font-bold text-accent">v1.2.0</span>
                    <span class="text-sm text-text-secondary">17 Juni 2026</span>
                    <span class="badge badge-success">Terbaru</span>
                </div>
                <ul class="space-y-2 text-text-secondary dark:text-text-dark-secondary">
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Menambahkan fitur export laporan keuangan ke Excel</span>
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
                </ul>
            </div>

            <!-- v1.1.0 -->
            <div class="border-t border-light-border dark:border-dark-border pt-8">
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-2xl font-bold text-text-primary dark:text-text-dark-primary">v1.1.0</span>
                    <span class="text-sm text-text-secondary">10 Juni 2026</span>
                </div>
                <ul class="space-y-2 text-text-secondary dark:text-text-dark-secondary">
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
                </ul>
            </div>

            <!-- v1.0.0 -->
            <div class="border-t border-light-border dark:border-dark-border pt-8">
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-2xl font-bold text-text-primary dark:text-text-dark-primary">v1.0.0</span>
                    <span class="text-sm text-text-secondary">1 Juni 2026</span>
                    <span class="badge badge-primary">Rilis Pertama</span>
                </div>
                <ul class="space-y-2 text-text-secondary dark:text-text-dark-secondary">
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Launching platform CoreSite</span>
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
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection