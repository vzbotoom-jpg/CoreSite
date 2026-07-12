{{-- resources/views/admin/dashboard/partials/revenue-chart.blade.php --}}
@push('styles')
<style>
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }
</style>
@endpush

<div class="card">
    <div class="card-header flex flex-wrap gap-4 justify-between items-center">
        <div>
            <h3 class="font-semibold">Grafik Pendapatan</h3>
            <p class="text-sm text-text-secondary mt-1">Visualisasi pendapatan harian</p>
        </div>
        <div class="flex gap-2">
            <button onclick="window.dashboard?.setPeriod('7days')" class="btn btn-sm btn-outline">
                7 Hari
            </button>
            <button onclick="window.dashboard?.setPeriod('30days')" class="btn btn-sm btn-outline">
                30 Hari
            </button>
            <button onclick="window.dashboard?.setPeriod('90days')" class="btn btn-sm btn-outline">
                90 Hari
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="chart-container">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('revenueChart')?.getContext('2d');
    if (!ctx) return;
    
    window.revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartLabels ?? []),
            datasets: [{
                label: 'Pendapatan',
                data: @json($chartData ?? []),
                borderColor: '#00D27A',
                backgroundColor: 'rgba(0, 210, 122, 0.1)',
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
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                minimumFractionDigits: 0
                            }).format(context.raw);
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                minimumFractionDigits: 0,
                                notation: 'compact',
                                compactDisplay: 'short'
                            }).format(value);
                        }
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
});
</script>
@endpush