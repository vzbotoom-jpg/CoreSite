{{-- resources/views/landing/pricing.blade.php --}}
@extends('layouts.guest')

@section('title', 'Harga - CoreSite')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <!-- Header -->
    <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-bold text-text-primary dark:text-text-dark-primary mb-4">
            Pilih Paket yang <span class="text-accent">Tepat</span>
        </h1>
        <p class="text-lg text-text-secondary dark:text-text-dark-secondary max-w-2xl mx-auto">
            Mulai gratis, kembangkan bisnis Anda bersama CoreSite
        </p>
    </div>
    
    <!-- Pricing Cards -->
    <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
        <!-- Starter Plan -->
        <div class="card hover:shadow-lg transition-shadow">
            <div class="card-body text-center">
                <div class="mb-4">
                    <span class="px-3 py-1 bg-light-surface dark:bg-dark-surface text-xs font-medium rounded-full">Gratis</span>
                </div>
                <h3 class="text-xl font-bold text-text-primary dark:text-text-dark-primary mb-2">Starter</h3>
                <div class="text-4xl font-bold text-accent mb-1">Rp0</div>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary mb-6">Selamanya</p>
                <ul class="space-y-3 text-left mb-8">
                    <li class="flex items-center gap-2 text-text-secondary dark:text-text-dark-secondary">
                        <svg class="w-5 h-5 text-success flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>1 Toko</span>
                    </li>
                    <li class="flex items-center gap-2 text-text-secondary dark:text-text-dark-secondary">
                        <svg class="w-5 h-5 text-success flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Maksimal 100 produk</span>
                    </li>
                    <li class="flex items-center gap-2 text-text-secondary dark:text-text-dark-secondary">
                        <svg class="w-5 h-5 text-success flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Laporan dasar</span>
                    </li>
                    <li class="flex items-center gap-2 text-text-secondary dark:text-text-dark-secondary">
                        <svg class="w-5 h-5 text-success flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>E-catalog publik</span>
                    </li>
                    <li class="flex items-center gap-2 text-text-secondary dark:text-text-dark-secondary">
                        <svg class="w-5 h-5 text-text-secondary/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <span class="line-through">Export data</span>
                    </li>
                </ul>
                <a href="{{ route('register') }}" class="btn btn-secondary w-full">Mulai Gratis</a>
            </div>
        </div>
        
        <!-- Business Plan -->
        <div class="card border-2 border-accent shadow-lg relative">
            <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 bg-accent text-white px-4 py-1 rounded-full text-sm font-medium">
                Populer
            </div>
            <div class="card-body text-center">
                <div class="mb-4">
                    <span class="px-3 py-1 bg-accent/10 text-accent text-xs font-medium rounded-full">Best Value</span>
                </div>
                <h3 class="text-xl font-bold text-text-primary dark:text-text-dark-primary mb-2">Business</h3>
                <div class="text-4xl font-bold text-accent mb-1">Rp149.000</div>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary mb-6">/bulan</p>
                <ul class="space-y-3 text-left mb-8">
                    <li class="flex items-center gap-2 text-text-secondary dark:text-text-dark-secondary">
                        <svg class="w-5 h-5 text-success flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>1 Toko</span>
                    </li>
                    <li class="flex items-center gap-2 text-text-secondary dark:text-text-dark-secondary">
                        <svg class="w-5 h-5 text-success flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Unlimited produk</span>
                    </li>
                    <li class="flex items-center gap-2 text-text-secondary dark:text-text-dark-secondary">
                        <svg class="w-5 h-5 text-success flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Laporan lengkap</span>
                    </li>
                    <li class="flex items-center gap-2 text-text-secondary dark:text-text-dark-secondary">
                        <svg class="w-5 h-5 text-success flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>E-catalog publik</span>
                    </li>
                    <li class="flex items-center gap-2 text-text-secondary dark:text-text-dark-secondary">
                        <svg class="w-5 h-5 text-success flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Export data</span>
                    </li>
                    <li class="flex items-center gap-2 text-text-secondary dark:text-text-dark-secondary">
                        <svg class="w-5 h-5 text-success flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Multi user (3 user)</span>
                    </li>
                </ul>
                <a href="{{ route('register') }}" class="btn btn-primary w-full">Pilih Business</a>
            </div>
        </div>
        
        <!-- Enterprise Plan -->
        <div class="card hover:shadow-lg transition-shadow">
            <div class="card-body text-center">
                <div class="mb-4">
                    <span class="px-3 py-1 bg-accent/10 text-accent text-xs font-medium rounded-full">Enterprise</span>
                </div>
                <h3 class="text-xl font-bold text-text-primary dark:text-text-dark-primary mb-2">Enterprise</h3>
                <div class="text-4xl font-bold text-accent mb-1">Rp499.000</div>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary mb-6">/bulan</p>
                <ul class="space-y-3 text-left mb-8">
                    <li class="flex items-center gap-2 text-text-secondary dark:text-text-dark-secondary">
                        <svg class="w-5 h-5 text-success flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>5 Toko</span>
                    </li>
                    <li class="flex items-center gap-2 text-text-secondary dark:text-text-dark-secondary">
                        <svg class="w-5 h-5 text-success flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Unlimited produk</span>
                    </li>
                    <li class="flex items-center gap-2 text-text-secondary dark:text-text-dark-secondary">
                        <svg class="w-5 h-5 text-success flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Laporan advanced</span>
                    </li>
                    <li class="flex items-center gap-2 text-text-secondary dark:text-text-dark-secondary">
                        <svg class="w-5 h-5 text-success flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>E-catalog premium</span>
                    </li>
                    <li class="flex items-center gap-2 text-text-secondary dark:text-text-dark-secondary">
                        <svg class="w-5 h-5 text-success flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>API access</span>
                    </li>
                    <li class="flex items-center gap-2 text-text-secondary dark:text-text-dark-secondary">
                        <svg class="w-5 h-5 text-success flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Custom domain</span>
                    </li>
                </ul>
                <a href="{{ route('contact') }}" class="btn btn-secondary w-full">Hubungi Sales</a>
            </div>
        </div>
    </div>
    
    <!-- FAQ Section -->
    <div class="mt-16 max-w-3xl mx-auto">
        <h2 class="text-2xl font-bold text-text-primary dark:text-text-dark-primary text-center mb-8">
            Pertanyaan Umum
        </h2>
        <div class="space-y-4">
            <details class="border border-light-border dark:border-dark-border rounded-lg">
                <summary class="px-6 py-4 font-medium text-text-primary dark:text-text-dark-primary cursor-pointer hover:text-accent transition-colors">
                    Apakah ada biaya pendaftaran?
                </summary>
                <div class="px-6 pb-4 text-text-secondary dark:text-text-dark-secondary">
                    Tidak ada biaya pendaftaran! Anda bisa mulai dengan paket Starter gratis selamanya.
                </div>
            </details>
            <details class="border border-light-border dark:border-dark-border rounded-lg">
                <summary class="px-6 py-4 font-medium text-text-primary dark:text-text-dark-primary cursor-pointer hover:text-accent transition-colors">
                    Bisakah saya upgrade paket kapan saja?
                </summary>
                <div class="px-6 pb-4 text-text-secondary dark:text-text-dark-secondary">
                    Ya, Anda bisa upgrade atau downgrade paket kapan saja sesuai kebutuhan bisnis Anda.
                </div>
            </details>
            <details class="border border-light-border dark:border-dark-border rounded-lg">
                <summary class="px-6 py-4 font-medium text-text-primary dark:text-text-dark-primary cursor-pointer hover:text-accent transition-colors">
                    Apada support untuk berbagai pembayaran?
                </summary>
                <div class="px-6 pb-4 text-text-secondary dark:text-text-dark-secondary">
                    Saat ini support cash, transfer bank, dan QRIS. Kami akan menambah payment gateway segera.
                </div>
            </details>
        </div>
    </div>
</div>
@endsection