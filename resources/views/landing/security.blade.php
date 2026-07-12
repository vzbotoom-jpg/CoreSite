{{-- resources/views/landing/security.blade.php --}}
@extends('layouts.guest')

@section('title', 'Keamanan - CoreSite')
@section('description', 'Komitmen keamanan CoreSite.')

@section('content')
<section class="py-16">
    <div class="container mx-auto px-4 max-w-4xl">
        <h1 class="text-4xl font-bold text-text-primary dark:text-text-dark-primary mb-4">
            <span class="text-accent">Keamanan</span> Data
        </h1>
        <p class="text-text-secondary dark:text-text-dark-secondary mb-8">Komitmen CoreSite untuk melindungi data Anda</p>

        <div class="grid md:grid-cols-2 gap-6 mb-12">
            <div class="card">
                <div class="card-body">
                    <span class="text-3xl mb-3 block">🔒</span>
                    <h4 class="font-bold text-text-primary dark:text-text-dark-primary">Enkripsi Data</h4>
                    <p class="text-sm text-text-secondary">Semua data dienkripsi dengan AES-256 baik saat transit maupun istirahat</p>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <span class="text-3xl mb-3 block">🛡️</span>
                    <h4 class="font-bold text-text-primary dark:text-text-dark-primary">SSL/TLS</h4>
                    <p class="text-sm text-text-secondary">Koneksi aman dengan sertifikat SSL/TLS untuk semua komunikasi</p>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <span class="text-3xl mb-3 block">🔑</span>
                    <h4 class="font-bold text-text-primary dark:text-text-dark-primary">Akses Terbatas</h4>
                    <p class="text-sm text-text-secondary">Hanya tim terbatas yang memiliki akses ke data Anda dengan otorisasi ketat</p>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <span class="text-3xl mb-3 block">📋</span>
                    <h4 class="font-bold text-text-primary dark:text-text-dark-primary">Audit & Monitoring</h4>
                    <p class="text-sm text-text-secondary">Audit dan monitoring keamanan dilakukan secara berkala</p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Sertifikasi & Kepatuhan</h3>
            </div>
            <div class="card-body">
                <ul class="space-y-2 text-text-secondary">
                    <li class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>ISO 27001 Certified (dalam proses)</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>GDPR Compliant</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>PCI DSS Level 1 (untuk pembayaran)</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card bg-accent/5 border-accent/20 mt-8">
            <div class="card-body text-center">
                <p class="text-text-secondary">Ada masalah keamanan? Laporkan segera.</p>
                <a href="mailto:security@coresite.com" class="text-accent hover:underline font-medium">
                    security@coresite.com →
                </a>
            </div>
        </div>
    </div>
</section>
@endsection