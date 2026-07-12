{{-- resources/views/catalog/account/orders.blade.php --}}
@extends('layouts.catalog')

@section('title', 'Riwayat Pesanan')

@section('content')
<div x-data="ordersManager()" x-init="init()" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid md:grid-cols-4 gap-8">
        <div class="md:col-span-1">
            @include('catalog.account.partials.sidebar')
        </div>
        
        <div class="md:col-span-3">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-text-primary dark:text-text-dark-primary">Riwayat Pesanan</h1>
                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Kelola dan pantau semua pesanan Anda</p>
                </div>
                <a href="{{ route('catalog.store') }}" class="btn btn-primary text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Belanja Lagi
                </a>
            </div>

            <!-- Stats Summary -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
                <div class="card">
                    <div class="card-body py-3 text-center">
                        <p class="text-lg font-bold text-text-primary dark:text-text-dark-primary">12</p>
                        <p class="text-xs text-text-secondary">Semua</p>
                    </div>
                </div>
                <div class="card border-warning/20">
                    <div class="card-body py-3 text-center">
                        <p class="text-lg font-bold text-warning">3</p>
                        <p class="text-xs text-text-secondary">Pending</p>
                    </div>
                </div>
                <div class="card border-success/20">
                    <div class="card-body py-3 text-center">
                        <p class="text-lg font-bold text-success">8</p>
                        <p class="text-xs text-text-secondary">Selesai</p>
                    </div>
                </div>
                <div class="card border-error/20">
                    <div class="card-body py-3 text-center">
                        <p class="text-lg font-bold text-error">1</p>
                        <p class="text-xs text-text-secondary">Dibatalkan</p>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="flex flex-wrap gap-2 mb-6">
                <button @click="filter = 'all'" :class="filter === 'all' ? 'btn-primary' : 'btn-outline'" class="text-sm">Semua</button>
                <button @click="filter = 'pending'" :class="filter === 'pending' ? 'btn-primary' : 'btn-outline'" class="text-sm">Pending</button>
                <button @click="filter = 'processing'" :class="filter === 'processing' ? 'btn-primary' : 'btn-outline'" class="text-sm">Diproses</button>
                <button @click="filter = 'completed'" :class="filter === 'completed' ? 'btn-primary' : 'btn-outline'" class="text-sm">Selesai</button>
                <button @click="filter = 'cancelled'" :class="filter === 'cancelled' ? 'btn-primary' : 'btn-outline'" class="text-sm">Dibatalkan</button>
            </div>

            <!-- Orders List -->
            <div class="space-y-4">
                <!-- Order Card 1 -->
                <div class="card hover:shadow-lg transition-all duration-300">
                    <div class="card-body">
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-text-primary dark:text-text-dark-primary">#ORD-2026-001</p>
                                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary">17 Juni 2026, 14:30</p>
                                </div>
                            </div>
                            <div class="flex flex-wrap items-center gap-3">
                                <span class="badge badge-warning">Pending</span>
                                <span class="font-bold text-accent">Rp 149.000</span>
                                <span class="text-sm text-text-secondary">3 item</span>
                            </div>
                        </div>
                        
                        <div class="mt-4 pt-4 border-t border-light-border/40 dark:border-dark-border/40 flex flex-wrap justify-between items-center">
                            <div class="flex items-center gap-2">
                                <span class="text-sm text-text-secondary">Metode Pembayaran:</span>
                                <span class="text-sm font-medium">Transfer Bank</span>
                            </div>
                            <div class="flex gap-2">
                                <a href="#" class="btn btn-ghost btn-sm text-accent">Detail →</a>
                                <button class="btn btn-secondary btn-sm">Hubungi Toko</button>
                            </div>
                        </div>
                        
                        <!-- Expandable Items -->
                        <div x-data="{ open: false }" class="mt-3">
                            <button @click="open = !open" class="text-sm text-accent hover:underline flex items-center gap-1">
                                <span x-text="open ? 'Sembunyikan item' : 'Lihat item'"></span>
                                <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open" x-collapse class="mt-3 space-y-2">
                                <div class="flex items-center gap-4 p-3 bg-light-surface/50 dark:bg-dark-surface/50 rounded-lg">
                                    <div class="w-12 h-12 bg-light-surface dark:bg-dark-surface rounded-lg"></div>
                                    <div class="flex-1">
                                        <p class="font-medium">Product Name 1</p>
                                        <p class="text-sm text-text-secondary">Qty: 2</p>
                                    </div>
                                    <p class="font-medium">Rp 100.000</p>
                                </div>
                                <div class="flex items-center gap-4 p-3 bg-light-surface/50 dark:bg-dark-surface/50 rounded-lg">
                                    <div class="w-12 h-12 bg-light-surface dark:bg-dark-surface rounded-lg"></div>
                                    <div class="flex-1">
                                        <p class="font-medium">Product Name 2</p>
                                        <p class="text-sm text-text-secondary">Qty: 1</p>
                                    </div>
                                    <p class="font-medium">Rp 49.000</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Card 2 -->
                <div class="card hover:shadow-lg transition-all duration-300">
                    <div class="card-body">
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-success/10 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-text-primary dark:text-text-dark-primary">#ORD-2026-002</p>
                                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary">15 Juni 2026, 10:15</p>
                                </div>
                            </div>
                            <div class="flex flex-wrap items-center gap-3">
                                <span class="badge badge-success">Selesai</span>
                                <span class="font-bold text-accent">Rp 75.000</span>
                                <span class="text-sm text-text-secondary">2 item</span>
                            </div>
                        </div>
                        
                        <div class="mt-4 pt-4 border-t border-light-border/40 dark:border-dark-border/40 flex flex-wrap justify-between items-center">
                            <div class="flex items-center gap-2">
                                <span class="text-sm text-text-secondary">Metode Pembayaran:</span>
                                <span class="text-sm font-medium">QRIS</span>
                            </div>
                            <div class="flex gap-2">
                                <a href="#" class="btn btn-ghost btn-sm text-accent">Detail →</a>
                                <a href="#" class="btn btn-primary btn-sm">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                    Beli Lagi
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Card 3 -->
                <div class="card hover:shadow-lg transition-all duration-300">
                    <div class="card-body">
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-error/10 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-error" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-text-primary dark:text-text-dark-primary">#ORD-2026-003</p>
                                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary">12 Juni 2026, 09:00</p>
                                </div>
                            </div>
                            <div class="flex flex-wrap items-center gap-3">
                                <span class="badge badge-error">Dibatalkan</span>
                                <span class="font-bold text-accent">Rp 220.000</span>
                                <span class="text-sm text-text-secondary">4 item</span>
                            </div>
                        </div>
                        
                        <div class="mt-4 pt-4 border-t border-light-border/40 dark:border-dark-border/40 flex flex-wrap justify-between items-center">
                            <div class="flex items-center gap-2">
                                <span class="text-sm text-text-secondary">Metode Pembayaran:</span>
                                <span class="text-sm font-medium">Tunai</span>
                            </div>
                            <div class="flex gap-2">
                                <a href="#" class="btn btn-ghost btn-sm text-accent">Detail →</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-8 flex justify-between items-center">
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Menampilkan 3 dari 12 pesanan</p>
                <div class="flex gap-2">
                    <button disabled class="px-3 py-1 border border-light-border/40 dark:border-dark-border/40 rounded-lg text-sm text-text-secondary/50 cursor-not-allowed">Sebelumnya</button>
                    <button class="px-3 py-1 bg-accent text-white rounded-lg text-sm">1</button>
                    <button class="px-3 py-1 border border-light-border/40 dark:border-dark-border/40 rounded-lg text-sm hover:bg-light-surface/50 dark:hover:bg-dark-surface/50 transition">2</button>
                    <button class="px-3 py-1 border border-light-border/40 dark:border-dark-border/40 rounded-lg text-sm hover:bg-light-surface/50 dark:hover:bg-dark-surface/50 transition">3</button>
                    <button class="px-3 py-1 border border-light-border/40 dark:border-dark-border/40 rounded-lg text-sm hover:bg-light-surface/50 dark:hover:bg-dark-surface/50 transition">Selanjutnya</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function ordersManager() {
    return {
        filter: 'all',
        orders: [],
        loading: false,
        
        init() {
            this.loadOrders();
        },
        
        async loadOrders() {
            this.loading = true;
            // Simulate API call
            setTimeout(() => {
                this.loading = false;
            }, 500);
        }
    }
}
</script>
@endpush
@endsection