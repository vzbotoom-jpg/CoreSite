{{-- resources/views/admin/reports/partials/sales-report.blade.php --}}
<div x-data="salesReport()" x-init="init()" class="space-y-6">
    <!-- Filters -->
    <div class="card">
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Dari Tanggal</label>
                    <input type="date" x-model="dateFrom" @change="loadReport" class="input">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Sampai Tanggal</label>
                    <input type="date" x-model="dateTo" @change="loadReport" class="input">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Status</label>
                    <select x-model="status" @change="loadReport" class="input">
                        <option value="">Semua</option>
                        <option value="completed">Selesai</option>
                        <option value="pending">Pending</option>
                        <option value="cancelled">Dibatalkan</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button @click="exportReport" class="btn btn-outline w-full">
                        Export CSV
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sales Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold">Daftar Penjualan</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b">
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary">Invoice</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary">Tanggal</th>
                        <th class="text-right px-6 py-3 text-sm font-medium text-text-secondary">Total</th>
                        <th class="text-right px-6 py-3 text-sm font-medium text-text-secondary">Items</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary">Metode</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="sale in sales" :key="sale.id">
                        <tr class="border-b hover:bg-light-surface/50 cursor-pointer" 
                            @click="viewDetail(sale.id)">
                            <td class="px-6 py-3 font-mono" x-text="sale.invoice_number"></td>
                            <td class="px-6 py-3" x-text="formatDateTime(sale.transaction_date)"></td>
                            <td class="px-6 py-3 text-right font-medium" x-text="formatRupiah(sale.total_amount)"></td>
                            <td class="px-6 py-3 text-right" x-text="sale.items_count"></td>
                            <td class="px-6 py-3" x-text="getPaymentMethodText(sale.payment_method)"></td>
                            <td class="px-6 py-3">
                                <span :class="getStatusClass(sale.status)" class="badge" x-text="getStatusText(sale.status)"></span>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="sales.length === 0 && !loading">
                        <td colspan="6" class="px-6 py-12 text-center text-text-secondary">
                            Tidak ada data penjualan
                        </td>
                    </tr>
                    <tr x-show="loading">
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="spinner mx-auto"></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div x-show="lastPage > 1" class="card-footer">
            <div class="flex justify-between items-center">
                <div class="text-sm text-text-secondary">
                    Menampilkan <span x-text="from"></span> - <span x-text="to"></span> dari <span x-text="total"></span>
                </div>
                <div class="flex gap-2">
                    <button @click="prevPage" :disabled="currentPage === 1" 
                            class="px-3 py-1 border rounded hover:bg-light-surface disabled:opacity-50">
                        Sebelumnya
                    </button>
                    <span class="px-3 py-1 text-text-secondary" x-text="'Halaman ' + currentPage + ' dari ' + lastPage"></span>
                    <button @click="nextPage" :disabled="currentPage === lastPage" 
                            class="px-3 py-1 border rounded hover:bg-light-surface disabled:opacity-50">
                        Selanjutnya
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function salesReport() {
    return {
        sales: [],
        loading: false,
        currentPage: 1,
        lastPage: 1,
        total: 0,
        from: 0,
        to: 0,
        dateFrom: '',
        dateTo: '',
        status: '',
        
        init() {
            const today = new Date();
            const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
            this.dateFrom = firstDay.toISOString().split('T')[0];
            this.dateTo = today.toISOString().split('T')[0];
            this.loadReport();
        },
        
        async loadReport() {
            this.loading = true;
            const params = {
                page: this.currentPage,
                date_from: this.dateFrom,
                date_to: this.dateTo,
                status: this.status
            };
            
            try {
                const response = await axios.get('/api/v1/transactions', { params });
                if (response.data.success) {
                    this.sales = response.data.data.data || [];
                    this.currentPage = response.data.data.current_page || 1;
                    this.lastPage = response.data.data.last_page || 1;
                    this.total = response.data.data.total || 0;
                    this.from = response.data.data.from || 0;
                    this.to = response.data.data.to || 0;
                }
            } catch (error) {
                console.error('Failed to load sales:', error);
                window.showToast('Gagal memuat data penjualan', 'error');
            }
            this.loading = false;
        },
        
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
                this.loadReport();
            }
        },
        
        nextPage() {
            if (this.currentPage < this.lastPage) {
                this.currentPage++;
                this.loadReport();
            }
        },
        
        viewDetail(id) {
            window.location.href = `/admin/transactions/${id}`;
        },
        
        exportReport() {
            window.showToast('Export akan segera tersedia', 'info');
        },
        
        formatRupiah(value) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(value);
        },
        
        formatDateTime(date) {
            const d = new Date(date);
            return d.toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' });
        },
        
        getPaymentMethodText(method) {
            const methods = { 'cash': 'Tunai', 'transfer': 'Transfer', 'qris': 'QRIS' };
            return methods[method] || method;
        },
        
        getStatusClass(status) {
            const classes = { 'completed': 'badge-success', 'pending': 'badge-warning', 'cancelled': 'badge-error' };
            return classes[status] || 'badge-secondary';
        },
        
        getStatusText(status) {
            const texts = { 'completed': 'Selesai', 'pending': 'Pending', 'cancelled': 'Dibatalkan' };
            return texts[status] || status;
        }
    }
}
</script>
@endpush