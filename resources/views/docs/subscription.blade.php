@extends('layouts.docs')

@section('title', 'Paket & Harga')

@section('content')
<div class="prose prose-slate dark:prose-invert max-w-none">
    <p class="text-lg text-text-secondary dark:text-text-dark-secondary leading-relaxed">
        Pilih paket yang sesuai dengan kebutuhan dan skala bisnis Anda.
    </p>

    <div class="grid md:grid-cols-3 gap-4 my-8">
        <!-- Starter -->
        <div class="bg-light-surface dark:bg-dark-surface/50 rounded-xl p-6 border border-light-border/40 dark:border-dark-border/40">
            <h3 class="text-lg font-bold text-text-primary dark:text-text-dark-primary">Starter</h3>
            <p class="text-sm text-text-secondary/60 mt-1">Untuk bisnis kecil</p>
            <div class="mt-4">
                <span class="text-3xl font-bold text-text-primary dark:text-text-dark-primary">Rp49.000</span>
                <span class="text-sm text-text-secondary/60">/bulan</span>
            </div>
            <ul class="mt-4 space-y-2 text-sm text-text-secondary">
                <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>100 produk</span>
                </li>
                <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>1 pengguna</span>
                </li>
                <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>E-Katalog dasar</span>
                </li>
                <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Laporan mingguan</span>
                </li>
                <li class="flex items-center gap-2 text-text-secondary/40">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    <span>API akses</span>
                </li>
            </ul>
            <a href="{{ route('register') }}" class="block text-center mt-6 px-4 py-2.5 bg-accent text-white font-medium rounded-lg hover:opacity-80 transition">
                Pilih Starter
            </a>
        </div>

        <!-- Business -->
        <div class="bg-accent/5 border-2 border-accent rounded-xl p-6 relative">
            <span class="absolute -top-3 left-1/2 transform -translate-x-1/2 px-3 py-0.5 bg-accent text-white text-xs font-semibold rounded-full">
                POPULER
            </span>
            <h3 class="text-lg font-bold text-text-primary dark:text-text-dark-primary">Business</h3>
            <p class="text-sm text-text-secondary/60 mt-1">Untuk bisnis berkembang</p>
            <div class="mt-4">
                <span class="text-3xl font-bold text-text-primary dark:text-text-dark-primary">Rp149.000</span>
                <span class="text-sm text-text-secondary/60">/bulan</span>
            </div>
            <ul class="mt-4 space-y-2 text-sm text-text-secondary">
                <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>1000 produk</span>
                </li>
                <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>5 pengguna</span>
                </li>
                <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>E-Katalog profesional</span>
                </li>
                <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Laporan real-time</span>
                </li>
                <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>API akses</span>
                </li>
            </ul>
            <a href="{{ route('register') }}" class="block text-center mt-6 px-4 py-2.5 bg-accent text-white font-medium rounded-lg hover:opacity-80 transition">
                Pilih Business
            </a>
        </div>

        <!-- Enterprise -->
        <div class="bg-light-surface dark:bg-dark-surface/50 rounded-xl p-6 border border-light-border/40 dark:border-dark-border/40">
            <h3 class="text-lg font-bold text-text-primary dark:text-text-dark-primary">Enterprise</h3>
            <p class="text-sm text-text-secondary/60 mt-1">Untuk perusahaan besar</p>
            <div class="mt-4">
                <span class="text-3xl font-bold text-text-primary dark:text-text-dark-primary">Kustom</span>
            </div>
            <ul class="mt-4 space-y-2 text-sm text-text-secondary">
                <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Produk unlimited</span>
                </li>
                <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Pengguna unlimited</span>
                </li>
                <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>E-Katalog premium</span>
                </li>
                <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Analitik advanced</span>
                </li>
                <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Dukungan prioritas</span>
                </li>
            </ul>
            <a href="{{ route('docs.show', 'support') }}" class="block text-center mt-6 px-4 py-2.5 bg-light-border/40 dark:bg-dark-border/40 text-text-primary dark:text-text-dark-primary font-medium rounded-lg hover:bg-light-border/60 transition">
                Hubungi Kami
            </a>
        </div>
    </div>

    <div class="bg-light-surface dark:bg-dark-surface/50 rounded-xl p-6 my-8">
        <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Semua Paket Termasuk:</h4>
        <ul class="mt-2 grid md:grid-cols-2 gap-2 text-sm text-text-secondary">
            <li class="flex items-center gap-2">
                <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Support 24/7
            </li>
            <li class="flex items-center gap-2">
                <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Keamanan data terjamin
            </li>
            <li class="flex items-center gap-2">
                <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Update fitur rutin
            </li>
            <li class="flex items-center gap-2">
                <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Backup data otomatis
            </li>
        </ul>
    </div>
</div>
@endsection