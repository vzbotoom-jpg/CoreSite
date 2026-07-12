{{-- resources/views/catalog/checkout/failed.blade.php --}}
@extends('layouts.catalog')

@section('title', 'Pesanan Gagal')

@section('content')
<div x-data="checkoutFailed()" x-init="init()" class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="card border-error/20">
        <div class="card-body py-16 text-center">
            <!-- Error Animation -->
            <div class="relative w-32 h-32 mx-auto mb-8">
                <div class="absolute inset-0 bg-error/10 rounded-full animate-pulse"></div>
                <div class="relative w-32 h-32 bg-error/20 rounded-full flex items-center justify-center">
                    <svg class="w-16 h-16 text-error" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            
            <h1 class="text-3xl font-bold text-text-primary dark:text-text-dark-primary mb-3">Pesanan Gagal 😓</h1>
            <p class="text-text-secondary dark:text-text-dark-secondary mb-8 max-w-md mx-auto">
                Maaf, terjadi kesalahan saat memproses pesanan Anda. 
                Silakan periksa kembali data pembayaran dan coba lagi.
            </p>
            
            <!-- Error Details -->
            <div class="bg-error/5 border border-error/20 rounded-xl p-6 max-w-sm mx-auto mb-8">
                <div class="flex items-center gap-3 mb-2">
                    <svg class="w-5 h-5 text-error" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <span class="font-medium text-text-primary dark:text-text-dark-primary">Kode Error: #ERR-2026-001</span>
                </div>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Gagal memproses pembayaran. Silakan coba metode pembayaran lain.</p>
            </div>
            
            <!-- Actions -->
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('catalog.cart') }}" class="btn btn-primary gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Keranjang
                </a>
                <a href="{{ route('catalog.store') }}" class="btn btn-secondary gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6M17 13l1.5 6M9 21h6"/>
                    </svg>
                    Kembali Belanja
                </a>
                <a href="{{ route('contact') }}" class="btn btn-outline gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Hubungi Support
                </a>
            </div>
            
            <!-- Help Section -->
            <div class="mt-8 pt-6 border-t border-light-border/40 dark:border-dark-border/40">
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">
                    Butuh bantuan? Tim support kami siap membantu Anda.
                </p>
                <div class="flex justify-center gap-6 mt-3">
                    <a href="mailto:support@coresite.com" class="text-sm text-accent hover:underline flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        support@coresite.com
                    </a>
                    <a href="https://wa.me/628123456789" class="text-sm text-accent hover:underline flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        +62 812-3456-789
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function checkoutFailed() {
    return {
        init() {
            // Any initialization
        }
    }
}
</script>
@endpush
@endsection