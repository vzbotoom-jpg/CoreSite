{{-- resources/views/developer/stats/stores.blade.php --}}
@extends('layouts.developer')

@section('title', 'Store Statistics')
@section('page-title', 'Store Statistics')

@section('content')
<div x-data="storeStats()" x-init="init()" class="space-y-6">
    <div class="flex flex-wrap justify-between items-center gap-4">
        <div>
            <p class="text-text-secondary dark:text-text-dark-secondary">Statistik lengkap toko di sistem</p>
        </div>
        <a href="{{ route('developer.stats.index') }}" class="btn btn-outline text-sm">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <div x-show="loading" class="text-center py-12">
        <div class="spinner mx-auto"></div>
        <p class="text-text-secondary mt-4">Memuat data...</p>
    </div>

    <div x-show="!loading" x-cloak>
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="card">
                <div class="card-body py-3">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-xs text-text-secondary">Total Stores</p>
                            <p class="text-2xl font-bold" x-text="formatNumber(stats.total)"></p>
                        </div>
                        <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body py-3">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-xs text-text-secondary">Active Stores</p>
                            <p class="text-2xl font-bold text-success" x-text="formatNumber(stats.active)"></p>
                        </div>
                        <div class="w-10 h-10 bg-success/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body py-3">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-xs text-text-secondary">Total Products</p>
                            <p class="text-2xl font-bold text-accent" x-text="formatNumber(stats.total_products)"></p>
                        </div>
                        <div class="w-10 h-10 bg-accent/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body py-3">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-xs text-text-secondary">Avg Products/Store</p>
                            <p class="text-2xl font-bold text-info" x-text="formatNumber(stats.avg_products)"></p>
                        </div>
                        <div class="w-10 h-10 bg-info/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-info" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Stores -->
        <div class="card">
            <div class="card-header">
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Top Stores by Revenue</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-light-border dark:border-dark-border">
                            <th class="text-left px-6 py-3 text-sm font-medium">#</th>
                            <th class="text-left px-6 py-3 text-sm font-medium">Store Name</th>
                            <th class="text-left px-6 py-3 text-sm font-medium">Revenue</th>
                            <th class="text-left px-6 py-3 text-sm font-medium">Transactions</th>
                            <th class="text-left px-6 py-3 text-sm font-medium">Products</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(store, index) in stats.top_stores" :key="store.id">
                            <tr class="border-b border-light-border dark:border-dark-border hover:bg-light-surface/50 transition">
                                <td class="px-6 py-4 text-text-secondary" x-text="index + 1"></td>
                                <td class="px-6 py-4 font-medium text-text-primary dark:text-text-dark-primary" x-text="store.name"></td>
                                <td class="px-6 py-4 text-accent" x-text="formatCurrency(store.revenue)"></td>
                                <td class="px-6 py-4 text-text-primary" x-text="formatNumber(store.transactions)"></td>
                                <td class="px-6 py-4 text-text-primary" x-text="formatNumber(store.products)"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function storeStats() {
    return {
        stats: {},
        loading: false,

        init() {
            this.loadStats();
        },

        async loadStats() {
            this.loading = true;
            try {
                const response = await axios.get('/developer/stats/stores');
                if (response.data.success) {
                    this.stats = response.data.data;
                }
            } catch (error) {
                console.error('Failed to load store stats:', error);
                window.showToast('Gagal memuat statistik toko', 'error');
            }
            this.loading = false;
        },

        formatNumber(value) {
            return new Intl.NumberFormat('id-ID').format(value);
        },

        formatCurrency(value) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(value);
        }
    }
}
</script>
@endpush
@endsection