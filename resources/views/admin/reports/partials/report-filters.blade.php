{{-- resources/views/admin/reports/partials/report-filters.blade.php --}}
@props([
    'startDate' => null,
    'endDate' => null,
    'showStatus' => true,
    'showPaymentMethod' => false,
    'onApply' => null,
    'onReset' => null,
])

<div class="card">
    <div class="card-body">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Date From -->
            <div>
                <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Dari Tanggal
                </label>
                <input type="date" name="date_from" value="{{ $startDate ?? now()->startOfMonth()->format('Y-m-d') }}" 
                       class="input" id="reportDateFrom">
            </div>
            
            <!-- Date To -->
            <div>
                <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Sampai Tanggal
                </label>
                <input type="date" name="date_to" value="{{ $endDate ?? now()->format('Y-m-d') }}" 
                       class="input" id="reportDateTo">
            </div>
            
            <!-- Status Filter -->
            @if($showStatus)
                <div>
                    <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Status
                    </label>
                    <select name="status" class="input" id="reportStatus">
                        <option value="">Semua Status</option>
                        <option value="completed">Selesai</option>
                        <option value="pending">Pending</option>
                        <option value="cancelled">Dibatalkan</option>
                    </select>
                </div>
            @endif
            
            <!-- Payment Method Filter -->
            @if($showPaymentMethod)
                <div>
                    <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        Metode Pembayaran
                    </label>
                    <select name="payment_method" class="input" id="reportPaymentMethod">
                        <option value="">Semua Metode</option>
                        <option value="cash">Tunai</option>
                        <option value="transfer">Transfer Bank</option>
                        <option value="qris">QRIS</option>
                    </select>
                </div>
            @endif
            
            <!-- Actions -->
            <div class="flex items-end gap-2">
                <button onclick="applyFilters()" class="btn btn-primary w-full">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Filter
                </button>
                <button onclick="resetFilters()" class="btn btn-secondary whitespace-nowrap">
                    Reset
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function applyFilters() {
    const dateFrom = document.getElementById('reportDateFrom')?.value;
    const dateTo = document.getElementById('reportDateTo')?.value;
    const status = document.getElementById('reportStatus')?.value || '';
    const paymentMethod = document.getElementById('reportPaymentMethod')?.value || '';
    
    // Build URL with params
    const params = new URLSearchParams();
    if (dateFrom) params.append('date_from', dateFrom);
    if (dateTo) params.append('date_to', dateTo);
    if (status) params.append('status', status);
    if (paymentMethod) params.append('payment_method', paymentMethod);
    
    const url = window.location.pathname + '?' + params.toString();
    window.location.href = url;
}

function resetFilters() {
    window.location.href = window.location.pathname;
}

// Auto-apply filters on Enter key
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('#reportDateFrom, #reportDateTo, #reportStatus, #reportPaymentMethod').forEach(input => {
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                applyFilters();
            }
        });
    });
});
</script>
@endpush