{{-- resources/views/landing/roadmap.blade.php --}}
@extends('layouts.guest')

@section('title', 'Roadmap - CoreSite')
@section('description', 'Rencana pengembangan CoreSite ke depan.')

@section('content')
<section class="py-20">
    <div class="container mx-auto px-4 max-w-4xl">
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-bold text-text-primary dark:text-text-dark-primary mb-4">
                <span class="text-accent">Roadmap</span>
            </h1>
            <p class="text-text-secondary dark:text-text-dark-secondary">
                Rencana pengembangan CoreSite untuk 12 bulan ke depan
            </p>
        </div>

        <div class="space-y-8">
            <!-- Q3 2026 -->
            <div class="card">
                <div class="card-body">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="badge badge-primary text-sm">Q3 2026</span>
                        <span class="text-sm text-text-secondary">Juli - September</span>
                    </div>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3 text-text-secondary">
                            <span class="w-2 h-2 bg-accent rounded-full"></span>
                            <span>Fitur multi-toko untuk satu akun</span>
                        </li>
                        <li class="flex items-center gap-3 text-text-secondary">
                            <span class="w-2 h-2 bg-accent rounded-full"></span>
                            <span>Integrasi dengan marketplace (Shopee, Tokopedia)</span>
                        </li>
                        <li class="flex items-center gap-3 text-text-secondary">
                            <span class="w-2 h-2 bg-accent rounded-full"></span>
                            <span>Mobile app untuk kasir</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Q4 2026 -->
            <div class="card">
                <div class="card-body">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="badge badge-accent text-sm">Q4 2026</span>
                        <span class="text-sm text-text-secondary">Oktober - Desember</span>
                    </div>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3 text-text-secondary">
                            <span class="w-2 h-2 bg-accent rounded-full"></span>
                            <span>AI-powered inventory management</span>
                        </li>
                        <li class="flex items-center gap-3 text-text-secondary">
                            <span class="w-2 h-2 bg-accent rounded-full"></span>
                            <span>Customer loyalty program</span>
                        </li>
                        <li class="flex items-center gap-3 text-text-secondary">
                            <span class="w-2 h-2 bg-accent rounded-full"></span>
                            <span>Advanced reporting & analytics</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Q1 2027 -->
            <div class="card">
                <div class="card-body">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="badge badge-secondary text-sm">Q1 2027</span>
                        <span class="text-sm text-text-secondary">Januari - Maret</span>
                    </div>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3 text-text-secondary">
                            <span class="w-2 h-2 bg-accent rounded-full"></span>
                            <span>Integrasi dengan POS hardware</span>
                        </li>
                        <li class="flex items-center gap-3 text-text-secondary">
                            <span class="w-2 h-2 bg-accent rounded-full"></span>
                            <span>Multi-language support</span>
                        </li>
                        <li class="flex items-center gap-3 text-text-secondary">
                            <span class="w-2 h-2 bg-accent rounded-full"></span>
                            <span>API public untuk developer</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Coming Soon -->
            <div class="card border-accent/30">
                <div class="card-body">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="badge badge-warning text-sm">Coming Soon</span>
                        <span class="text-sm text-text-secondary">Fitur yang sedang dikembangkan</span>
                    </div>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3 text-text-secondary">
                            <span class="w-2 h-2 bg-yellow-500 rounded-full animate-pulse"></span>
                            <span>Chatbot support untuk pelanggan</span>
                        </li>
                        <li class="flex items-center gap-3 text-text-secondary">
                            <span class="w-2 h-2 bg-yellow-500 rounded-full animate-pulse"></span>
                            <span>Automatic inventory restock alerts</span>
                        </li>
                        <li class="flex items-center gap-3 text-text-secondary">
                            <span class="w-2 h-2 bg-yellow-500 rounded-full animate-pulse"></span>
                            <span>WhatsApp Business integration</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection