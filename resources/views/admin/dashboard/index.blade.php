{{-- resources/views/admin/dashboard/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div x-data="dashboard()" x-init="init()" class="space-y-6">
    <!-- Stats Cards / Total Summary -->
    @include('admin.dashboard.partials.stats-cards')
    
    <!-- Quick Business Actions Bar -->
    <div class="bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border rounded-xl p-4 flex flex-wrap items-center justify-between gap-4 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-accent/10 rounded-lg">
                <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div>
                <h4 class="font-semibold text-text-primary dark:text-text-dark-primary text-sm">Aksi Cepat Bisnis</h4>
                <p class="text-xs text-text-secondary dark:text-text-dark-secondary">Akses langsung ke operasional harian toko Anda</p>
            </div>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.transactions.create') }}" class="btn btn-primary flex items-center gap-2 text-xs py-2 px-4 shadow-sm hover:scale-[1.02] transition-transform">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Transaksi Baru
            </a>
            <a href="{{ route('admin.products.create') }}" class="btn btn-secondary flex items-center gap-2 text-xs py-2 px-4 bg-light-surface hover:bg-slate-100 dark:bg-dark-bg dark:hover:bg-slate-800 border border-light-border dark:border-dark-border hover:scale-[1.02] transition-transform">
                <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                Tambah Produk
            </a>
            <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary flex items-center gap-2 text-xs py-2 px-4 bg-light-surface hover:bg-slate-100 dark:bg-dark-bg dark:hover:bg-slate-800 border border-light-border dark:border-dark-border hover:scale-[1.02] transition-transform">
                <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Laporan Penjualan
            </a>
            <button @click="window.print()" class="btn btn-secondary flex items-center gap-2 text-xs py-2 px-4 bg-light-surface hover:bg-slate-100 dark:bg-dark-bg dark:hover:bg-slate-800 border border-light-border dark:border-dark-border hover:scale-[1.02] transition-transform">
                <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak/Export
            </button>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Revenue Chart -->
        <div class="lg:col-span-2 card relative bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border">
            <!-- Skeleton Loading Overlay -->
            <div x-show="loading" class="absolute inset-0 bg-white/75 dark:bg-dark-surface/75 backdrop-blur-xs flex items-center justify-center z-10 rounded-xl transition-all">
                <div class="flex flex-col items-center gap-3">
                    <svg class="animate-spin h-8 w-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-xs font-semibold text-text-secondary dark:text-text-dark-secondary">Memuat data grafik...</span>
                </div>
            </div>

            <div class="card-header border-b border-light-border dark:border-dark-border pb-4 flex flex-wrap justify-between items-center gap-3">
                <div>
                    <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Tren Pendapatan</h3>
                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Visualisasi pendapatan harian</p>
                </div>
                <div class="flex gap-2">
                    <button @click="setPeriod('7days')" 
                            :class="period === '7days' ? 'bg-accent text-white' : 'bg-light-surface dark:bg-dark-surface text-text-secondary dark:text-text-dark-secondary hover:bg-accent/10'"
                            class="px-3 py-1.5 text-xs font-semibold rounded-lg transition-colors">
                        7 Hari
                    </button>
                    <button @click="setPeriod('30days')" 
                            :class="period === '30days' ? 'bg-accent text-white' : 'bg-light-surface dark:bg-dark-surface text-text-secondary dark:text-text-dark-secondary hover:bg-accent/10'"
                            class="px-3 py-1.5 text-xs font-semibold rounded-lg transition-colors">
                        30 Hari
                    </button>
                    <button @click="setPeriod('90days')" 
                            :class="period === '90days' ? 'bg-accent text-white' : 'bg-light-surface dark:bg-dark-surface text-text-secondary dark:text-text-dark-secondary hover:bg-accent/10'"
                            class="px-3 py-1.5 text-xs font-semibold rounded-lg transition-colors">
                        90 Hari
                    </button>
                </div>
            </div>
            <div class="card-body p-6">
                <div class="relative" style="height: 300px;">
                    <canvas x-ref="revenueChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Breakdown Metode Pembayaran (Doughnut Chart) -->
        <div class="card bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border">
            <div class="card-header border-b border-light-border dark:border-dark-border pb-4">
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Metode Pembayaran</h3>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Komposisi penjualan bulan ini</p>
            </div>
            <div class="card-body p-6 flex flex-col justify-between h-[300px]">
                <div class="relative flex-1">
                    <canvas x-ref="paymentChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Operational Row: Low Stock Alerts & Top Products -->
    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Low Stock Alerts -->
        <div class="card bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border">
            <div class="card-header border-b border-light-border dark:border-dark-border pb-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="font-semibold text-text-primary dark:text-text-dark-primary text-sm flex items-center gap-2">
                            <span class="flex h-2 w-2 relative">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                            </span>
                            Stok Perlu Perhatian
                        </h3>
                        <p class="text-xs text-text-secondary dark:text-text-dark-secondary">Sisa stok paling sedikit/di bawah batas minimum</p>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="space-y-3.5">
                    @forelse($lowStockProductsList ?? [] as $product)
                        @if(is_object($product) && $product->name)
                        <div class="flex items-center justify-between p-2.5 rounded-lg bg-light-bg/50 dark:bg-dark-bg/40 border border-light-border/60 dark:border-dark-border/40 hover:bg-light-bg dark:hover:bg-dark-bg/60 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-rose-500/10 flex items-center justify-center text-rose-500 font-semibold text-xs shrink-0">
                                    {{ $loop->iteration }}
                                </div>
                                <div class="min-w-0">
                                    <p class="font-medium text-text-primary dark:text-text-dark-primary text-xs truncate max-w-[120px] sm:max-w-[160px]" title="{{ $product->name }}">
                                        {{ $product->name }}
                                    </p>
                                    <p class="text-[10px] text-text-secondary dark:text-text-dark-secondary">
                                        Min. Alert: {{ $product->min_stock_alert }} pcs
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                @if($product->stock == 0)
                                    <span class="px-2 py-0.5 text-[10px] font-bold text-rose-500 bg-rose-500/10 rounded-full border border-rose-500/20 shrink-0">
                                        Habis
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 text-[10px] font-bold text-amber-500 bg-amber-500/10 rounded-full border border-amber-500/20 shrink-0">
                                        Sisa {{ $product->stock }} pcs
                                    </span>
                                @endif
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="p-1 text-accent hover:text-accent-hover hover:bg-accent/10 rounded transition-colors" title="Restock">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 15H19"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        @endif
                    @empty
                        <div class="text-center py-12 flex flex-col items-center justify-center">
                            <div class="w-12 h-12 rounded-full bg-emerald-500/10 text-emerald-500 flex items-center justify-center mb-3 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h4 class="text-xs font-semibold text-text-primary dark:text-text-dark-primary">Stok Semua Aman</h4>
                            <p class="text-[11px] text-text-secondary dark:text-text-dark-secondary px-4 mt-1">Tidak ada produk dengan sisa stok di bawah batas minimum.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Top Products -->
        <div class="lg:col-span-2 card bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border">
            <div class="card-header border-b border-light-border dark:border-dark-border pb-4">
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Produk Terlaris</h3>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Berdasarkan penjualan bulan ini</p>
            </div>
            <div class="card-body p-6">
                <div class="space-y-4">
                    <template x-for="(product, index) in topProducts" :key="product.id">
                        <div class="flex items-center justify-between p-1 hover:bg-light-bg/30 dark:hover:bg-dark-bg/30 rounded-lg transition-colors">
                            <div class="flex items-center gap-3">
                                <span class="w-6 h-6 rounded-full bg-accent/10 flex items-center justify-center text-xs font-bold text-accent"
                                      x-text="index + 1"></span>
                                <div>
                                    <p class="font-semibold text-text-primary dark:text-text-dark-primary text-xs" x-text="product.name"></p>
                                    <p class="text-[10px] text-text-secondary dark:text-text-dark-secondary"
                                       x-text="'Terjual: ' + formatNumber(product.total_sold) + ' pcs'"></p>
                                </div>
                            </div>
                            <p class="font-bold text-accent text-xs" x-text="formatRupiah(product.total_revenue)"></p>
                        </div>
                    </template>
                    
                    <div x-show="topProducts.length === 0" class="text-center text-text-secondary dark:text-text-dark-secondary py-12">
                        <svg class="w-12 h-12 mx-auto mb-3 text-text-secondary/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <p class="text-xs">Belum ada data produk</p>
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
        paymentBreakdown: @json($paymentBreakdown ?? []),
        chart: null,
        paymentChart: null,
        loading: false,
        
        init() {
            // Initialize charts after DOM is ready
            this.$nextTick(() => {
                this.loadChartData();
                this.initPaymentChart();
            });
        },
        
        setPeriod(period) {
            this.period = period;
            this.loadChartData();
        },
        
        async loadChartData() {
            this.loading = true;
            try {
                const response = await axios.get(`/admin/dashboard/chart?period=${this.period}`);
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
                                color: document.documentElement.classList.contains('dark') ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                color: document.documentElement.classList.contains('dark') ? '#94A3B8' : '#64748B',
                                callback: (value) => this.formatRupiahShort(value)
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: document.documentElement.classList.contains('dark') ? '#94A3B8' : '#64748B'
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

        initPaymentChart() {
            const ctx = this.$refs.paymentChart?.getContext('2d');
            if (!ctx) return;

            if (this.paymentChart) {
                this.paymentChart.destroy();
            }

            const backgroundColors = ['#00D27A', '#3B82F6', '#F59E0B']; // Emerald, Blue, Orange

            const methodNames = {
                'cash': 'Tunai (Cash)',
                'transfer': 'Transfer Bank',
                'qris': 'QRIS'
            };

            const methods = {
                'cash': 0,
                'transfer': 0,
                'qris': 0
            };

            // Ensure paymentBreakdown is an array
            if (Array.isArray(this.paymentBreakdown) && this.paymentBreakdown.length > 0) {
                this.paymentBreakdown.forEach(item => {
                    const method = item.payment_method?.toLowerCase();
                    if (methods.hasOwnProperty(method)) {
                        methods[method] = parseFloat(item.total || 0);
                    }
                });
            }

            const labelsMap = [];
            const valuesMap = [];

            Object.keys(methods).forEach(key => {
                labelsMap.push(methodNames[key]);
                valuesMap.push(methods[key]);
            });

            this.paymentChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labelsMap,
                    datasets: [{
                        data: valuesMap,
                        backgroundColor: backgroundColors,
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: document.documentElement.classList.contains('dark') ? '#94A3B8' : '#64748B',
                                font: {
                                    size: 11
                                },
                                boxWidth: 12,
                                padding: 15
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: (context) => {
                                    return ` ${context.label}: ${this.formatRupiah(context.raw)}`;
                                }
                            }
                        }
                    },
                    cutout: '70%'
                }
            });
        },
        
        formatRupiah(value) {
            const num = parseFloat(value);
            if (isNaN(num)) return 'Rp 0';
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(num);
        },
        
        formatRupiahShort(value) {
            const num = parseFloat(value);
            if (isNaN(num)) return 'Rp 0';
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                notation: 'compact',
                compactDisplay: 'short'
            }).format(num);
        },
        
        formatNumber(value) {
            const num = parseFloat(value);
            if (isNaN(num)) return '0';
            return new Intl.NumberFormat('id-ID').format(num);
        }
    }
}
</script>
@endpush
@endsection