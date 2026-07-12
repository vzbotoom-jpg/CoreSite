{{-- resources/views/admin/dashboard/components/chart-widget.blade.php --}}
@props(['title', 'chartId', 'height' => '300', 'showPeriodSelect' => false])

<div class="card">
    <div class="card-header flex justify-between items-center">
        <h3 class="font-semibold">{{ $title }}</h3>
        @if($showPeriodSelect)
            <select x-model="chartPeriod" @change="refreshChart" class="input w-32 text-sm">
                <option value="7days">7 Hari Terakhir</option>
                <option value="30days">30 Hari Terakhir</option>
                <option value="90days">90 Hari Terakhir</option>
            </select>
        @endif
    </div>
    <div class="card-body">
        <div class="chart-container" style="height: {{ $height }}px;">
            <canvas id="{{ $chartId }}"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script>
class ChartWidget {
    constructor(chartId, options = {}) {
        this.chartId = chartId;
        this.options = options;
        this.chart = null;
        this.init();
    }
    
    init() {
        const ctx = document.getElementById(this.chartId)?.getContext('2d');
        if (!ctx) return;
        
        this.chart = new Chart(ctx, {
            type: this.options.type || 'line',
            data: this.options.data || { labels: [], datasets: [] },
            options: this.options.chartOptions || {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top' },
                    tooltip: {
                        callbacks: {
                            label: (context) => {
                                return window.formatRupiah ? 
                                    window.formatRupiah(context.raw) : 
                                    context.raw;
                            }
                        }
                    }
                }
            }
        });
    }
    
    updateData(newData) {
        if (this.chart) {
            this.chart.data = newData;
            this.chart.update();
        }
    }
    
    destroy() {
        if (this.chart) {
            this.chart.destroy();
            this.chart = null;
        }
    }
}

// Register widget globally
window.ChartWidget = ChartWidget;
</script>
@endpush