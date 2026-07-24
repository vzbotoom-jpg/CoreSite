{{-- resources/views/developer/stats/transactions.blade.php --}}
@extends('layouts.developer')

@section('title', 'Transaction Statistics')
@section('page-title', 'Transaction Statistics')

@section('content')
<div x-data="transactionStats()" x-init="init()" class="space-y-6">
    <div class="flex flex-wrap justify-between items-center gap-4">
        <div>
            <p class="text-text-secondary dark:text-text-dark-secondary">Statistik lengkap transaksi di sistem</p>
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
                            <p class="text-xs text-text-secondary">Total Transactions</p>
                            <p class="text-2xl font-bold" x-text="formatNumber(stats.total)"></p>
                        </div>
                        <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body py-3">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-xs text-text-secondary">Total Revenue</p>
                            <p class="text-2xl font-bold text-accent" x-text="formatCurrency(stats.total_revenue)"></p>
                        </div>
                        <div class="w-10 h-10 bg-accent/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body py-3">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-xs text-text-secondary">Avg Order Value</p>
                            <p class="text-2xl font-bold text-success" x-text="formatCurrency(stats.avg_value)"></p>
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
                            <p class="text-xs text-text-secondary">Conversion Rate</p>
                            <p class="text-2xl font-bold text-info" x-text="stats.conversion_rate + '%'"></p>
                        </div>
                        <div class="w-10 h-10 bg-info/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-info" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="grid lg:grid-cols-2 gap-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Revenue Trend</h3>
                </div>
                <div class="card-body">
                    <div class="h-64">
                        <canvas id="revenueTrendChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Payment Methods</h3>
                </div>
                <div class="card-body">
                    <div class="h-64">
                        <canvas id="paymentMethodChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="card">
            <div class="card-header">
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Recent Transactions</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-light-border dark:border-dark-border">
                            <th class="text-left px-6 py-3 text-sm font-medium">ID</th>
                            <th class="text-left px-6 py-3 text-sm font-medium">Store</th>
                            <th class="text-left px-6 py-3 text-sm font-medium">Amount</th>
                            <th class="text-left px-6 py-3 text-sm font-medium">Status</th>
                            <th class="text-left px-6 py-3 text-sm font-medium">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="transaction in stats.recent_transactions" :key="transaction.id">
                            <tr class="border-b border-light-border dark:border-dark-border hover:bg-light-surface/50 transition">
                                <td class="px-6 py-4 text-text-secondary" x-text="'#' + transaction.id"></td>
                                <td class="px-6 py-4 text-text-primary" x-text="transaction.store"></td>
                                <td class="px-6 py-4 text-accent" x-text="formatCurrency(transaction.amount)"></td>
                                <td class="px-6 py-4">
                                    <span :class="transaction.status === 'completed' ? 'badge-success' : 'badge-warning'" class="badge">
                                        <span x-text="transaction.status"></span>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-text-secondary" x-text="formatDate(transaction.date)"></td>
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
function transactionStats() {
    return {
        stats: {},
        loading: false,

        init() {
            this.loadStats();
        },

        async loadStats() {
            this.loading = true;
            try {
                const response = await axios.get('/developer/stats/transactions');
                if (response.data.success) {
                    this.stats = response.data.data;
                    this.renderCharts();
                }
            } catch (error) {
                console.error('Failed to load transaction stats:', error);
                window.showToast('Gagal memuat statistik transaksi', 'error');
            }
            this.loading = false;
        },

        renderCharts() {
            // Implementation with Chart.js
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
        },

        formatDate(date) {
            return new Date(date).toLocaleDateString('id-ID', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }
    }
}
</script>
@endpush
@endsection