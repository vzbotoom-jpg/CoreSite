{{-- resources/views/catalog/account/order-detail.blade.php --}}
@extends('layouts.catalog')

@section('title', 'Detail Pesanan')

@section('content')
<div x-data="orderDetail()" x-init="init()" class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Navigation -->
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('catalog.account.orders') }}" class="text-text-secondary hover:text-accent transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <h1 class="text-2xl font-bold text-text-primary dark:text-text-dark-primary">Detail Pesanan</h1>
        <span class="badge badge-warning">Pending</span>
        <span class="text-sm text-text-secondary">#ORD-2026-001</span>
    </div>

    <!-- Status Timeline -->
    <div class="card mb-6">
        <div class="card-body">
            <div class="relative">
                <div class="flex items-center justify-between">
                    <!-- Step 1: Order Placed -->
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 bg-accent rounded-full flex items-center justify-center text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <p class="text-xs font-medium mt-2 text-accent">Pesanan Dibuat</p>
                        <p class="text-xs text-text-secondary">17 Jun 14:30</p>
                    </div>
                    
                    <!-- Progress Line -->
                    <div class="flex-1 h-1 mx-2 bg-accent/30 relative">
                        <div class="h-full w-2/3 bg-accent rounded-full"></div>
                    </div>
                    
                    <!-- Step 2: Processing -->
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 bg-accent/50 rounded-full flex items-center justify-center text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            </svg>
                        </div>
                        <p class="text-xs font-medium mt-2 text-text-secondary">Diproses</p>
                        <p class="text-xs text-text-secondary">Estimasi 18 Jun</p>
                    </div>
                    
                    <!-- Progress Line -->
                    <div class="flex-1 h-1 mx-2 bg-light-border/40 dark:bg-dark-border/40 relative"></div>
                    
                    <!-- Step 3: Shipped -->
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 bg-light-border/40 dark:bg-dark-border/40 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <p class="text-xs font-medium mt-2 text-text-secondary">Dikirim</p>
                    </div>
                    
                    <!-- Progress Line -->
                    <div class="flex-1 h-1 mx-2 bg-light-border/40 dark:border-dark-border/40 relative"></div>
                    
                    <!-- Step 4: Delivered -->
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 bg-light-border/40 dark:border-dark-border/40 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <p class="text-xs font-medium mt-2 text-text-secondary">Selesai</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        <!-- Order Items -->
        <div class="md:col-span-2 space-y-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Item Pesanan</h3>
                </div>
                <div class="card-body">
                    <div class="space-y-4">
                        <div class="flex items-center gap-4 p-3 bg-light-surface/50 dark:bg-dark-surface/50 rounded-lg">
                            <div class="w-20 h-20 bg-light-surface dark:bg-dark-surface rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-10 h-10 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Product Name 1</h4>
                                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Kategori: Elektronik</p>
                                <div class="flex items-center gap-4 mt-1">
                                    <span class="text-sm text-text-secondary">Qty: 2</span>
                                    <span class="text-sm font-medium text-accent">Rp 50.000 / pcs</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-accent">Rp 100.000</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4 p-3 bg-light-surface/50 dark:bg-dark-surface/50 rounded-lg">
                            <div class="w-20 h-20 bg-light-surface dark:bg-dark-surface rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-10 h-10 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Product Name 2</h4>
                                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Kategori: Fashion</p>
                                <div class="flex items-center gap-4 mt-1">
                                    <span class="text-sm text-text-secondary">Qty: 1</span>
                                    <span class="text-sm font-medium text-accent">Rp 49.000 / pcs</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-accent">Rp 49.000</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 pt-4 border-t border-light-border/40 dark:border-dark-border/40">
                        <div class="flex justify-between py-1">
                            <span class="text-text-secondary">Subtotal</span>
                            <span class="font-medium">Rp 149.000</span>
                        </div>
                        <div class="flex justify-between py-1">
                            <span class="text-text-secondary">Pengiriman</span>
                            <span class="text-success">Gratis</span>
                        </div>
                        <div class="flex justify-between py-1">
                            <span class="text-text-secondary">Diskon</span>
                            <span class="text-error">-Rp 0</span>
                        </div>
                        <div class="flex justify-between pt-2 border-t border-light-border/40 dark:border-dark-border/40">
                            <span class="font-bold text-text-primary dark:text-text-dark-primary">Total</span>
                            <span class="font-bold text-accent text-lg">Rp 149.000</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Order Information -->
        <div class="space-y-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Informasi Pesanan</h3>
                </div>
                <div class="card-body space-y-4">
                    <div>
                        <p class="text-sm text-text-secondary">Order ID</p>
                        <p class="font-medium text-text-primary dark:text-text-dark-primary font-mono">#ORD-2026-001</p>
                    </div>
                    <div>
                        <p class="text-sm text-text-secondary">Tanggal</p>
                        <p class="font-medium">17 Juni 2026, 14:30 WIB</p>
                    </div>
                    <div>
                        <p class="text-sm text-text-secondary">Status</p>
                        <span class="badge badge-warning">Pending</span>
                    </div>
                    <div>
                        <p class="text-sm text-text-secondary">Metode Pembayaran</p>
                        <p class="font-medium">Transfer Bank</p>
                    </div>
                    <div>
                        <p class="text-sm text-text-secondary">Status Pembayaran</p>
                        <span class="badge badge-warning">Menunggu Konfirmasi</span>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Alamat Pengiriman</h3>
                </div>
                <div class="card-body">
                    <p class="font-medium">Budi Santoso</p>
                    <p class="text-sm text-text-secondary">Jl. Contoh No. 123, RT 01 RW 02</p>
                    <p class="text-sm text-text-secondary">Kelurahan Contoh, Kecamatan Contoh</p>
                    <p class="text-sm text-text-secondary">Jakarta Selatan, DKI Jakarta 12345</p>
                    <p class="text-sm text-text-secondary mt-1">📱 08123456789</p>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body space-y-2">
                    <button class="btn btn-secondary w-full text-sm">Hubungi Toko</button>
                    <button class="btn btn-outline w-full text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Download Invoice
                    </button>
                    <button class="btn btn-danger w-full text-sm" onclick="if(confirm('Batalkan pesanan ini?')) { window.showToast('Pesanan dibatalkan', 'success') }">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Batalkan Pesanan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function orderDetail() {
    return {
        init() {
            // Initialize any data
        }
    }
}
</script>
@endpush
@endsection