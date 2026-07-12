{{-- resources/views/admin/dashboard/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div x-data="dashboard()" x-init="init()" class="space-y-6">
    <!-- Stats Cards -->
    @include('admin.dashboard.partials.stats-cards')
    
    <!-- Charts Row -->
    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Revenue Chart -->
        <div class="lg:col-span-2 card">
            <div class="card-header flex flex-wrap justify-between items-center gap-3">
                <div>
                    <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Tren Pendapatan</h3>
                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Visualisasi pendapatan harian</p>
                </div>
                <div class="flex gap-2">
                    <button @click="setPeriod('7days')" 
                            :class="period === '7days' ? 'bg-accent text-white' : 'bg-light-surface dark:bg-dark-surface text-text-secondary dark:text-text-dark-secondary hover:bg-accent/10'"
                            class="px-3 py-1 text-sm rounded-lg transition-colors">
                        7 Hari
                    </button>
                    <button @click="setPeriod('30days')" 
                            :class="period === '30days' ? 'bg-accent text-white' : 'bg-light-surface dark:bg-dark-surface text-text-secondary dark:text-text-dark-secondary hover:bg-accent/10'"
                            class="px-3 py-1 text-sm rounded-lg transition-colors">
                        30 Hari
                    </button>
                    <button @click="setPeriod('90days')" 
                            :class="period === '90days' ? 'bg-accent text-white' : 'bg-light-surface dark:bg-dark-surface text-text-secondary dark:text-text-dark-secondary hover:bg-accent/10'"
                            class="px-3 py-1 text-sm rounded-lg transition-colors">
                        90 Hari
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="relative" style="height: 300px;">
                    <canvas x-ref="revenueChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Top Products -->
        <div class="card">
            <div class="card-header">
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Produk Terlaris</h3>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Berdasarkan penjualan bulan ini</p>
            </div>
            <div class="card-body">
                <div class="space-y-4">
                    <template x-for="(product, index) in topProducts" :key="product.id">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="w-6 h-6 rounded-full bg-accent/10 flex items-center justify-center text-sm font-semibold text-accent" 
                                      x-text="index + 1"></span>
                                <div>
                                    <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="product.name"></p>
                                    <p class="text-xs text-text-secondary dark:text-text-dark-secondary" 
                                       x-text="'Terjual: ' + formatNumber(product.total_sold) + ' pcs'"></p>
                                </div>
                            </div>
                            <p class="font-semibold text-accent" x-text="formatRupiah(product.total_revenue)"></p>
                        </div>
                    </template>
                    
                    <div x-show="topProducts.length === 0" class="text-center text-text-secondary dark:text-text-dark-secondary py-8">
                        <svg class="w-12 h-12 mx-auto mb-3 text-text-secondary/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <p>Belum ada data produk</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Transactions -->
    @include('admin.dashboard.partials.recent-transactions')
</div>

@push('scripts')
<script>
function dashboard() {
    return {
        period: '7days',
        topProducts: @json($topProducts ?? []),
        chart: null,
        loading: false,
        
        init() {
            this.loadChartData();
            this.updateTopProducts();
        },
        
        setPeriod(period) {
            this.period = period;
            this.loadChartData();
        },
        
        async loadChartData() {
            this.loading = true;
            try {
                const response = await axios.get(`/api/v1/dashboard/chart?period=${this.period}`);
                if (response.data.success) {
                    this.updateChart(response.data.data);
                }
            } catch (error) {
                console.error('Failed to load chart data:', error);
                window.showToast('Gagal memuat data grafik', 'error');
            }
            this.loading = false;
        },
        
        updateChart(data) {
            const ctx = this.$refs.revenueChart?.getContext('2d');
            if (!ctx) return;
            
            if (this.chart) {
                this.chart.destroy();
            }
            
            // Gradient fill
            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(0, 210, 122, 0.2)');
            gradient.addColorStop(1, 'rgba(0, 210, 122, 0)');
            
            this.chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Pendapatan',
                        data: data.values,
                        borderColor: '#00D27A',
                        backgroundColor: gradient,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#00D27A',
                        pointBorderColor: '#fff',
                        pointHoverRadius: 6,
                        pointRadius: 4,
                        pointHoverBackgroundColor: '#00D27A'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: (context) => this.formatRupiah(context.raw)
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                callback: (value) => this.formatRupiahShort(value)
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    }
                }
            });
        },
        
        updateTopProducts() {
            // Update top products dynamically if needed
        },
        
        formatRupiah(value) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(value);
        },
        
        formatRupiahShort(value) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                notation: 'compact',
                compactDisplay: 'short'
            }).format(value);
        },
        
        formatNumber(value) {
            return new Intl.NumberFormat('id-ID').format(value);
        }
    }
}
</script>
@endpush
@endsection