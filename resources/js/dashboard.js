// resources/js/dashboard.js
import Chart from 'chart.js/auto';

class Dashboard {
    constructor() {
        this.charts = {};
        this.init();
    }
    
    init() {
        this.initRevenueChart();
        this.initSalesChart();
        this.initRealTimeStats();
    }
    
    initRevenueChart() {
        const ctx = document.getElementById('revenueChart')?.getContext('2d');
        if (!ctx) return;
        
        this.charts.revenue = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Pendapatan',
                    data: [],
                    borderColor: '#00D27A',
                    backgroundColor: 'rgba(0, 210, 122, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#00D27A',
                    pointBorderColor: '#fff',
                    pointHoverRadius: 6,
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: (context) => `Rp ${context.raw.toLocaleString('id-ID')}`
                        }
                    },
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        ticks: {
                            callback: (value) => `Rp ${value.toLocaleString('id-ID')}`
                        }
                    }
                }
            }
        });
    }
    
    initSalesChart() {
        const ctx = document.getElementById('salesChart')?.getContext('2d');
        if (!ctx) return;
        
        this.charts.sales = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Jumlah Transaksi',
                    data: [],
                    backgroundColor: 'rgba(0, 210, 122, 0.5)',
                    borderColor: '#00D27A',
                    borderWidth: 1,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: (context) => `${context.raw} transaksi`
                        }
                    }
                }
            }
        });
    }
    
    async initRealTimeStats() {
        this.fetchStats();
        setInterval(() => this.fetchStats(), 30000); // Update every 30 seconds
    }
    
    async fetchStats() {
        try {
            const response = await axios.get('/api/v1/dashboard-stats');
            if (response.data.success) {
                this.updateStats(response.data.data);
            }
        } catch (error) {
            console.error('Failed to fetch stats:', error);
        }
    }
    
    updateStats(data) {
        // Update stat cards
        document.getElementById('totalRevenue')?.setAttribute('data-value', data.total_revenue);
        document.getElementById('totalSales')?.setAttribute('data-value', data.total_sales);
        document.getElementById('totalProducts')?.setAttribute('data-value', data.total_products);
        document.getElementById('lowStock')?.setAttribute('data-value', data.low_stock);
        
        // Update chart data
        if (this.charts.revenue && data.revenue_chart) {
            this.charts.revenue.data.labels = data.revenue_chart.labels;
            this.charts.revenue.data.datasets[0].data = data.revenue_chart.values;
            this.charts.revenue.update();
        }
        
        if (this.charts.sales && data.sales_chart) {
            this.charts.sales.data.labels = data.sales_chart.labels;
            this.charts.sales.data.datasets[0].data = data.sales_chart.values;
            this.charts.sales.update();
        }
    }
}

// Initialize dashboard when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('dashboard-app')) {
        window.dashboard = new Dashboard();
    }
});