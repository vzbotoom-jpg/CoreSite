{{-- resources/views/admin/reports/partials/financial-report.blade.php --}}
<div x-data="financialReport()" x-init="init()" class="space-y-6">
    <!-- Period Selector -->
    <div class="card">
        <div class="card-body">
            <div class="flex flex-wrap gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium mb-2">Periode</label>
                    <select x-model="period" @change="loadReport" class="input">
                        <option value="this_month">Bulan Ini</option>
                        <option value="last_month">Bulan Lalu</option>
                        <option value="this_year">Tahun Ini</option>
                        <option value="custom">Custom</option>
                    </select>
                </div>
                <div x-show="period === 'custom'">
                    <label class="block text-sm font-medium mb-2">Dari Tanggal</label>
                    <input type="date" x-model="dateFrom" @change="loadReport" class="input">
                </div>
                <div x-show="period === 'custom'">
                    <label class="block text-sm font-medium mb-2">Sampai Tanggal</label>
                    <input type="date" x-model="dateTo" @change="loadReport" class="input">
                </div>
                <div>
                    <button @click="exportReport" class="btn btn-outline">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Export
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="card">
            <div class="card-body">
                <p class="text-sm text-text-secondary">Total Pendapatan</p>
                <p class="text-2xl font-bold" x-text="formatRupiah(data?.summary?.total_revenue || 0)"></p>
                <div class="flex items-center gap-1 mt-2">
                    <span :class="trendClass(data?.summary?.revenue_trend)" 
                          x-text="formatTrend(data?.summary?.revenue_trend)"></span>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <p class="text-sm text-text-secondary">Total Transaksi</p>
                <p class="text-2xl font-bold" x-text="formatNumber(data?.summary?.total_transactions || 0)"></p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <p class="text-sm text-text-secondary">Total Produk Terjual</p>
                <p class="text-2xl font-bold" x-text="formatNumber(data?.summary?.total_products_sold || 0)"></p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <p class="text-sm text-text-secondary">Rata-rata Transaksi</p>
                <p class="text-2xl font-bold" x-text="formatRupiah(data?.summary?.average_transaction || 0)"></p>
            </div>
        </div>
    </div>
    
    <!-- Revenue Chart -->
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold">Grafik Pendapatan</h3>
        </div>
        <div class="card-body">
            <canvas x-ref="revenueChart" height="300"></canvas>
        </div>
    </div>
    
    <!-- Payment Method Breakdown -->
    <div class="grid md:grid-cols-2 gap-6">
        <div class="card">
            <div class="card-header">
                <h3 class="font-semibold">Metode Pembayaran</h3>
            </div>
            <div class="card-body">
                <div class="space-y-3">
                    <template x-for="method in data?.payment_breakdown || []" :key="method.payment_method">
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span x-text="getPaymentMethodText(method.payment_method)"></span>
                                <span x-text="formatRupiah(method.total)"></span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" :style="{ width: getPercentage(method.total, data?.summary?.total_revenue) + '%' }"></div>
                            </div>
                            <p class="text-xs text-text-secondary mt-1" x-text="method.count + ' transaksi'"></p>
                        </div>
                    </template>
                </div>
            </div>
        </div>
        
        <!-- Top Products -->
        <div class="card">
            <div class="card-header">
                <h3 class="font-semibold">Produk Terlaris</h3>
            </div>
            <div class="card-body">
                <div class="space-y-4">
                    <template x-for="(product, index) in (data?.top_products || []).slice(0, 5)" :key="product.id">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="w-6 h-6 rounded-full bg-accent/10 flex items-center justify-center text-sm font-semibold" 
                                      x-text="index + 1"></span>
                                <div>
                                    <p class="font-medium" x-text="product.name"></p>
                                    <p class="text-xs text-text-secondary" x-text="product.total_sold + ' terjual'"></p>
                                </div>
                            </div>
                            <p class="font-semibold" x-text="formatRupiah(product.total_revenue)"></p>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Daily Breakdown Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold">Rincian Harian</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b">
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary">Tanggal</th>
                        <th class="text-right px-6 py-3 text-sm font-medium text-text-secondary">Transaksi</th>
                        <th class="text-right px-6 py-3 text-sm font-medium text-text-secondary">Pendapatan</th>
                        <th class="text-right px-6 py-3 text-sm font-medium text-text-secondary">Rata-rata</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="day in data?.daily_breakdown || []" :key="day.date">
                        <tr class="border-b hover:bg-light-surface/50">
                            <td class="px-6 py-3" x-text="formatDate(day.date)"></td>
                            <td class="px-6 py-3 text-right" x-text="formatNumber(day.count)"></td>
                            <td class="px-6 py-3 text-right font-medium" x-text="formatRupiah(day.revenue)"></td>
                            <td class="px-6 py-3 text-right" x-text="formatRupiah(day.average)"></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
function financialReport() {
    return {
        data: null,
        period: 'this_month',
        dateFrom: '',
        dateTo: '',
        chart: null,
        loading: false,
        
        init() {
            this.setDefaultDates();
            this.loadReport();
        },
        
        setDefaultDates() {
            const today = new Date();
            const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
            this.dateFrom = firstDay.toISOString().split('T')[0];
            this.dateTo = today.toISOString().split('T')[0];
        },
        
        async loadReport() {
            this.loading = true;
            
            let params = {};
            if (this.period === 'custom') {
                params = { start_date: this.dateFrom, end_date: this.dateTo };
            } else {
                params = { period: this.period };
            }
            
            try {
                const response = await axios.get('/admin/reports/financial', { params });
                if (response.data.success) {
                    this.data = response.data.data;
                    this.updateChart();
                }
            } catch (error) {
                console.error('Failed to load report:', error);
                window.showToast('Gagal memuat laporan', 'error');
            }
            this.loading = false;
        },
        
        updateChart() {
            const ctx = this.$refs.revenueChart?.getContext('2d');
            if (!ctx || !this.data?.daily_breakdown) return;
            
            const labels = this.data.daily_breakdown.map(day => this.formatDate(day.date));
            const values = this.data.daily_breakdown.map(day => day.revenue);
            
            if (this.chart) this.chart.destroy();
            
            this.chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Pendapatan',
                        data: values,
                        borderColor: '#00D27A',
                        backgroundColor: 'rgba(0, 210, 122, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: (ctx) => this.formatRupiah(ctx.raw)
                            }
                        }
                    },
                    scales: {
                        y: {
                            ticks: {
                                callback: (value) => this.formatRupiah(value)
                            }
                        }
                    }
                }
            });
        },
        
        async exportReport() {
            window.showToast('Export akan segera tersedia', 'info');
        },
        
        formatRupiah(value) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(value);
        },
        
        formatNumber(value) {
            return new Intl.NumberFormat('id-ID').format(value);
        },
        
        formatDate(date) {
            const d = new Date(date);
            return d.toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' });
        },
        
        formatTrend(value) {
            if (!value) return '0%';
            const sign = value > 0 ? '+' : '';
            return sign + value.toFixed(1) + '%';
        },
        
        trendClass(value) {
            if (value > 0) return 'text-success';
            if (value < 0) return 'text-error';
            return 'text-text-secondary';
        },
        
        getPercentage(value, total) {
            if (!total) return 0;
            return (value / total) * 100;
        },
        
        getPaymentMethodText(method) {
            const methods = {
                'cash': 'Tunai',
                'transfer': 'Transfer Bank',
                'qris': 'QRIS'
            };
            return methods[method] || method;
        }
    }
}
</script>
@endpush