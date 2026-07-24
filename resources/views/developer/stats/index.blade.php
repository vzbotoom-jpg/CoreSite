{{-- resources/views/developer/stats/index.blade.php --}}
@extends('layouts.developer')

@section('title', 'Statistics Dashboard')
@section('page-title', 'Statistics Dashboard')

@section('content')
<div x-data="statisticsDashboard()" x-init="init()" class="space-y-6">
    <!-- Header -->
    <div class="flex flex-wrap justify-between items-center gap-4">
        <div>
            <p class="text-text-secondary dark:text-text-dark-secondary">Statistik lengkap sistem CoreSite</p>
        </div>
        <div class="flex gap-3">
            <select x-model="period" @change="loadStats" class="input text-sm py-1">
                <option value="today">Hari Ini</option>
                <option value="week">Minggu Ini</option>
                <option value="month">Bulan Ini</option>
                <option value="year">Tahun Ini</option>
                <option value="all">Semua Waktu</option>
            </select>
            <button @click="exportStats" class="btn btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Export
            </button>
        </div>
    </div>

    <!-- Loading -->
    <div x-show="loading" class="text-center py-12">
        <div class="spinner mx-auto"></div>
        <p class="text-text-secondary mt-4">Memuat statistik...</p>
    </div>

    <div x-show="!loading" x-cloak>
        <!-- Overview Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="card">
                <div class="card-body py-3">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-xs text-text-secondary">Total Users</p>
                            <p class="text-2xl font-bold text-text-primary dark:text-text-dark-primary" x-text="formatNumber(stats.total_users)"></p>
                            <p class="text-xs" :class="stats.user_growth >= 0 ? 'text-success' : 'text-error'">
                                <span x-text="stats.user_growth >= 0 ? '↑' : '↓'"></span>
                                <span x-text="Math.abs(stats.user_growth).toFixed(1) + '%'"></span>
                                <span class="text-text-secondary">from last period</span>
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body py-3">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-xs text-text-secondary">Total Stores</p>
                            <p class="text-2xl font-bold text-text-primary dark:text-text-dark-primary" x-text="formatNumber(stats.total_stores)"></p>
                            <p class="text-xs" :class="stats.store_growth >= 0 ? 'text-success' : 'text-error'">
                                <span x-text="stats.store_growth >= 0 ? '↑' : '↓'"></span>
                                <span x-text="Math.abs(stats.store_growth).toFixed(1) + '%'"></span>
                                <span class="text-text-secondary">from last period</span>
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-success/10 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                            <p class="text-xs text-text-secondary">Total Transactions</p>
                            <p class="text-2xl font-bold text-text-primary dark:text-text-dark-primary" x-text="formatNumber(stats.total_transactions)"></p>
                            <p class="text-xs" :class="stats.transaction_growth >= 0 ? 'text-success' : 'text-error'">
                                <span x-text="stats.transaction_growth >= 0 ? '↑' : '↓'"></span>
                                <span x-text="Math.abs(stats.transaction_growth).toFixed(1) + '%'"></span>
                                <span class="text-text-secondary">from last period</span>
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-warning/10 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                            <p class="text-xs" :class="stats.revenue_growth >= 0 ? 'text-success' : 'text-error'">
                                <span x-text="stats.revenue_growth >= 0 ? '↑' : '↓'"></span>
                                <span x-text="Math.abs(stats.revenue_growth).toFixed(1) + '%'"></span>
                                <span class="text-text-secondary">from last period</span>
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
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
                    <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">User Growth</h3>
                </div>
                <div class="card-body">
                    <div class="h-64">
                        <canvas id="userGrowthChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Revenue Trend</h3>
                </div>
                <div class="card-body">
                    <div class="h-64">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="card">
            <div class="card-header">
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Quick Statistics</h3>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="border rounded-lg p-4 text-center">
                        <p class="text-sm text-text-secondary">Active Users</p>
                        <p class="text-2xl font-bold text-success" x-text="formatNumber(stats.active_users)"></p>
                        <p class="text-xs text-text-secondary" x-text="stats.active_users_percentage + '% of total'"></p>
                    </div>
                    <div class="border rounded-lg p-4 text-center">
                        <p class="text-sm text-text-secondary">Active Stores</p>
                        <p class="text-2xl font-bold text-success" x-text="formatNumber(stats.active_stores)"></p>
                        <p class="text-xs text-text-secondary" x-text="stats.active_stores_percentage + '% of total'"></p>
                    </div>
                    <div class="border rounded-lg p-4 text-center">
                        <p class="text-sm text-text-secondary">Avg Order Value</p>
                        <p class="text-2xl font-bold text-accent" x-text="formatCurrency(stats.avg_order_value)"></p>
                    </div>
                    <div class="border rounded-lg p-4 text-center">
                        <p class="text-sm text-text-secondary">Conversion Rate</p>
                        <p class="text-2xl font-bold text-info" x-text="stats.conversion_rate + '%'"></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="grid md:grid-cols-3 gap-6">
            <a href="{{ route('developer.stats.users') }}" class="card hover:shadow-lg transition group">
                <div class="card-body">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">User Statistics</h3>
                            <p class="text-sm text-text-secondary">Detail statistik pengguna</p>
                        </div>
                        <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center group-hover:bg-primary/20 transition">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-light-border dark:border-dark-border">
                        <span class="text-accent text-sm">View Details →</span>
                    </div>
                </div>
            </a>

            <a href="{{ route('developer.stats.stores') }}" class="card hover:shadow-lg transition group">
                <div class="card-body">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Store Statistics</h3>
                            <p class="text-sm text-text-secondary">Detail statistik toko</p>
                        </div>
                        <div class="w-12 h-12 bg-success/10 rounded-xl flex items-center justify-center group-hover:bg-success/20 transition">
                            <svg class="w-6 h-6 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-light-border dark:border-dark-border">
                        <span class="text-accent text-sm">View Details →</span>
                    </div>
                </div>
            </a>

            <a href="{{ route('developer.stats.transactions') }}" class="card hover:shadow-lg transition group">
                <div class="card-body">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Transaction Statistics</h3>
                            <p class="text-sm text-text-secondary">Detail statistik transaksi</p>
                        </div>
                        <div class="w-12 h-12 bg-warning/10 rounded-xl flex items-center justify-center group-hover:bg-warning/20 transition">
                            <svg class="w-6 h-6 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-light-border dark:border-dark-border">
                        <span class="text-accent text-sm">View Details →</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
function statisticsDashboard() {
    return {
        stats: {},
        period: 'month',
        loading: false,
        charts: {},

        init() {
            this.loadStats();
        },

        async loadStats() {
            this.loading = true;
            try {
                const response = await axios.get(`/developer/stats/overview?period=${this.period}`);
                if (response.data.success) {
                    this.stats = response.data.data;
                    this.renderCharts();
                }
            } catch (error) {
                console.error('Failed to load stats:', error);
                window.showToast('Gagal memuat statistik', 'error');
            }
            this.loading = false;
        },

        renderCharts() {
            // Render charts using Chart.js
            this.renderUserGrowthChart();
            this.renderRevenueChart();
        },

        renderUserGrowthChart() {
            // Implementation with Chart.js
        },

        renderRevenueChart() {
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

        exportStats() {
            window.showToast('Export akan segera tersedia', 'info');
        }
    }
}
</script>
@endpush
@endsection