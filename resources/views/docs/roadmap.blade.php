{{-- resources/views/docs/roadmap.blade.php --}}
@extends('layouts.docs')

@section('title', 'Peta Jalan - Dokumentasi CoreSite')

@section('content')
<div class="prose dark:prose-invert max-w-none">
    <p>
        Rencana pengembangan CoreSite untuk 12 bulan ke depan. Kami selalu mendengarkan masukan dari pengguna untuk menentukan prioritas fitur.
    </p>

    <!-- Q3 2026 -->
    <div class="mt-8 border border-light-border/40 dark:border-dark-border/40 rounded-lg p-6">
        <div class="flex items-center gap-3 mb-4">
            <span class="px-2 py-0.5 text-xs font-medium text-white bg-accent rounded">Q3 2026</span>
            <span class="text-sm text-text-secondary/60">Juli - September</span>
        </div>
        <ul class="space-y-2 text-text-secondary dark:text-text-dark-secondary">
            <li class="flex items-center gap-3">
                <span class="w-2 h-2 bg-accent rounded-full"></span>
                <span>Fitur multi-toko untuk satu akun</span>
            </li>
            <li class="flex items-center gap-3">
                <span class="w-2 h-2 bg-accent rounded-full"></span>
                <span>Integrasi dengan marketplace (Shopee, Tokopedia)</span>
            </li>
            <li class="flex items-center gap-3">
                <span class="w-2 h-2 bg-accent rounded-full"></span>
                <span>Aplikasi mobile untuk kasir</span>
            </li>
        </ul>
    </div>

    <!-- Q4 2026 -->
    <div class="mt-4 border border-light-border/40 dark:border-dark-border/40 rounded-lg p-6">
        <div class="flex items-center gap-3 mb-4">
            <span class="px-2 py-0.5 text-xs font-medium text-white bg-blue-600 rounded">Q4 2026</span>
            <span class="text-sm text-text-secondary/60">Oktober - Desember</span>
        </div>
        <ul class="space-y-2 text-text-secondary dark:text-text-dark-secondary">
            <li class="flex items-center gap-3">
                <span class="w-2 h-2 bg-accent rounded-full"></span>
                <span>Manajemen inventaris berbasis AI</span>
            </li>
            <li class="flex items-center gap-3">
                <span class="w-2 h-2 bg-accent rounded-full"></span>
                <span>Program loyalitas pelanggan</span>
            </li>
            <li class="flex items-center gap-3">
                <span class="w-2 h-2 bg-accent rounded-full"></span>
                <span>Laporan & analitik lanjutan</span>
            </li>
        </ul>
    </div>

    <!-- Q1 2027 -->
    <div class="mt-4 border border-light-border/40 dark:border-dark-border/40 rounded-lg p-6">
        <div class="flex items-center gap-3 mb-4">
            <span class="px-2 py-0.5 text-xs font-medium text-white bg-gray-600 rounded">Q1 2027</span>
            <span class="text-sm text-text-secondary/60">Januari - Maret</span>
        </div>
        <ul class="space-y-2 text-text-secondary dark:text-text-dark-secondary">
            <li class="flex items-center gap-3">
                <span class="w-2 h-2 bg-accent rounded-full"></span>
                <span>Integrasi dengan hardware POS</span>
            </li>
            <li class="flex items-center gap-3">
                <span class="w-2 h-2 bg-accent rounded-full"></span>
                <span>Dukungan multi-bahasa</span>
            </li>
            <li class="flex items-center gap-3">
                <span class="w-2 h-2 bg-accent rounded-full"></span>
                <span>API publik untuk developer</span>
            </li>
        </ul>
    </div>

    <!-- Coming Soon -->
    <div class="mt-4 border border-accent/30 bg-accent/5 rounded-lg p-6">
        <div class="flex items-center gap-3 mb-4">
            <span class="px-2 py-0.5 text-xs font-medium text-yellow-800 bg-yellow-100 dark:bg-yellow-900/30 dark:text-yellow-300 rounded">Segera Hadir</span>
            <span class="text-sm text-text-secondary/60">Fitur yang sedang dikembangkan</span>
        </div>
        <ul class="space-y-2 text-text-secondary dark:text-text-dark-secondary">
            <li class="flex items-center gap-3">
                <span class="w-2 h-2 bg-yellow-500 rounded-full animate-pulse"></span>
                <span>Chatbot support untuk pelanggan</span>
            </li>
            <li class="flex items-center gap-3">
                <span class="w-2 h-2 bg-yellow-500 rounded-full animate-pulse"></span>
                <span>Peringatan restok inventaris otomatis</span>
            </li>
            <li class="flex items-center gap-3">
                <span class="w-2 h-2 bg-yellow-500 rounded-full animate-pulse"></span>
                <span>Integrasi WhatsApp Business</span>
            </li>
        </ul>
    </div>

    <div class="bg-accent/5 border-l-4 border-accent rounded-r-lg p-4 my-6">
        <strong class="text-accent">💡 Punya saran fitur?</strong><br>
        <span class="text-text-secondary dark:text-text-dark-secondary">Kami terbuka untuk masukan! Kirim saran Anda melalui <a href="{{ route('contact') }}" class="text-accent hover:underline">halaman kontak</a> atau <a href="mailto:support@coresite.com" class="text-accent hover:underline">support@coresite.com</a>.</span>
    </div>
</div>
@endsection