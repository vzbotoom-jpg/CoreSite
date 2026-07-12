{{-- resources/views/admin/transactions/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Manajemen Transaksi')
@section('page-title', 'Manajemen Transaksi')

@section('content')
<div x-data="transactionManager()" x-init="init()" class="space-y-6">
    <!-- Header -->
    <div class="flex flex-wrap justify-between items-center gap-4">
        <div>
            <p class="text-text-secondary dark:text-text-dark-secondary">Kelola dan pantau semua transaksi penjualan</p>
        </div>
        <a href="{{ route('admin.transactions.create') }}" class="btn btn-primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Transaksi Baru
        </a>
    </div>
    
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="card">
            <div class="card-body py-3">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-text-secondary dark:text-text-dark-secondary">Total Pendapatan</p>
                        <p class="text-xl font-bold text-text-primary dark:text-text-dark-primary" id="totalRevenue">
                            Rp {{ number_format($stats['total_revenue'] ?? 0, 0, ',', '.') }}
                        </p>
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
                        <p class="text-xs text-text-secondary dark:text-text-dark-secondary">Total Transaksi</p>
                        <p class="text-xl font-bold text-text-primary dark:text-text-dark-primary" id="totalTransactions">
                            {{ number_format($stats['total_transactions'] ?? 0) }}
                        </p>
                    </div>
                    <div class="w-10 h-10 bg-info/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-info" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        <p class="text-xs text-text-secondary dark:text-text-dark-secondary">Rata-rata Transaksi</p>
                        <p class="text-xl font-bold text-text-primary dark:text-text-dark-primary" id="averageTransaction">
                            Rp {{ number_format($stats['average_transaction'] ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="w-10 h-10 bg-warning/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body py-3">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-text-secondary dark:text-text-dark-secondary">Hari Ini</p>
                        <p class="text-xl font-bold text-text-primary dark:text-text-dark-primary" id="todayRevenue">
                            Rp {{ number_format($stats['today_revenue'] ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="w-10 h-10 bg-success/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Filters -->
    <div class="card">
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <input type="text" x-model="filters.search" @input="debounceSearch" 
                           placeholder="Cari invoice..." class="input">
                </div>
                <div>
                    <select x-model="filters.status" @change="loadTransactions" class="input">
                        <option value="">Semua Status</option>
                        <option value="completed">Selesai</option>
                        <option value="pending">Pending</option>
                        <option value="cancelled">Dibatalkan</option>
                    </select>
                </div>
                <div>
                    <select x-model="filters.payment_method" @change="loadTransactions" class="input">
                        <option value="">Semua Metode</option>
                        <option value="cash">Tunai</option>
                        <option value="transfer">Transfer</option>
                        <option value="qris">QRIS</option>
                    </select>
                </div>
                <div>
                    <input type="date" x-model="filters.date_from" @change="loadTransactions" 
                           placeholder="Dari tanggal" class="input">
                </div>
                <div>
                    <input type="date" x-model="filters.date_to" @change="loadTransactions" 
                           placeholder="Sampai tanggal" class="input">
                </div>
            </div>
            <div class="flex justify-between items-center mt-4">
                <button @click="resetFilters" class="text-sm text-text-secondary hover:text-accent transition-colors">
                    Reset Filter
                </button>
                <button @click="exportData" class="text-sm text-accent hover:text-accent-hover transition-colors">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Export Data
                </button>
            </div>
        </div>
    </div>
    
    <!-- Transactions Table -->
    @include('admin.transactions.partials.transaction-table')
    
    <!-- Transaction Detail Modal -->
    <div x-show="showDetailModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" 
         @click.away="closeDetailModal">
        <div class="card w-full max-w-3xl mx-4 max-h-[90vh] overflow-y-auto" @click.stop>
            <div class="card-header flex justify-between items-center">
                <h3 class="text-xl font-bold text-text-primary dark:text-text-dark-primary">Detail Transaksi</h3>
                <button @click="closeDetailModal" class="text-text-secondary hover:text-text-primary transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="card-body">
                <div x-show="selectedTransaction">
                    @include('admin.transactions.partials.transaction-details')
                </div>
            </div>
            <div class="card-footer flex justify-end gap-3">
                <button @click="closeDetailModal" class="btn btn-secondary">Tutup</button>
                <button x-show="selectedTransaction?.status === 'completed'" 
                        @click="cancelTransaction(selectedTransaction.id)" 
                        class="btn btn-danger">
                    Batalkan Transaksi
                </button>
                <a :href="`/admin/transactions/${selectedTransaction?.id}/invoice`" target="_blank" 
                   class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Cetak Invoice
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function transactionManager() {
    return {
        transactions: [],
        loading: false,
        currentPage: 1,
        lastPage: 1,
        total: 0,
        from: 0,
        to: 0,
        
        filters: {
            search: '',
            status: '',
            payment_method: '',
            date_from: '',
            date_to: ''
        },
        
        showDetailModal: false,
        selectedTransaction: null,
        
        searchTimeout: null,
        
        init() {
            this.loadTransactions();
        },
        
        async loadTransactions() {
            this.loading = true;
            const params = new URLSearchParams({
                page: this.currentPage,
                search: this.filters.search,
                status: this.filters.status,
                payment_method: this.filters.payment_method,
                date_from: this.filters.date_from,
                date_to: this.filters.date_to
            });
            
            try {
                const response = await axios.get(`/api/v1/transactions?${params}`);
                if (response.data.success) {
                    this.transactions = response.data.data.data;
                    this.currentPage = response.data.data.current_page;
                    this.lastPage = response.data.data.last_page;
                    this.total = response.data.data.total;
                    this.from = response.data.data.from;
                    this.to = response.data.data.to;
                }
            } catch (error) {
                console.error('Failed to load transactions:', error);
                window.showToast('Gagal memuat transaksi', 'error');
            }
            this.loading = false;
        },
        
        debounceSearch() {
            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(() => {
                this.currentPage = 1;
                this.loadTransactions();
            }, 300);
        },
        
        resetFilters() {
            this.filters = {
                search: '',
                status: '',
                payment_method: '',
                date_from: '',
                date_to: ''
            };
            this.currentPage = 1;
            this.loadTransactions();
        },
        
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
                this.loadTransactions();
            }
        },
        
        nextPage() {
            if (this.currentPage < this.lastPage) {
                this.currentPage++;
                this.loadTransactions();
            }
        },
        
        viewDetail(transaction) {
            this.selectedTransaction = transaction;
            this.showDetailModal = true;
        },
        
        closeDetailModal() {
            this.showDetailModal = false;
            this.selectedTransaction = null;
        },
        
        async cancelTransaction(id) {
            if (!confirm('Batalkan transaksi ini? Stok akan dikembalikan.')) return;
            
            try {
                const response = await axios.post(`/api/v1/transactions/${id}/cancel`);
                if (response.data.success) {
                    window.showToast('Transaksi berhasil dibatalkan', 'success');
                    this.loadTransactions();
                    this.closeDetailModal();
                }
            } catch (error) {
                window.showToast(error.response?.data?.message || 'Gagal membatalkan transaksi', 'error');
            }
        },
        
        async exportData() {
            window.showToast('Export data akan segera tersedia', 'info');
        },
        
        formatRupiah(value) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(value);
        },
        
        formatDate(date) {
            if (!date) return '-';
            const d = new Date(date);
            return d.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        },
        
        getStatusBadge(status) {
            const classes = {
                'completed': 'badge-success',
                'pending': 'badge-warning',
                'cancelled': 'badge-error'
            };
            return classes[status] || 'badge-secondary';
        },
        
        getStatusText(status) {
            const texts = {
                'completed': 'Selesai',
                'pending': 'Pending',
                'cancelled': 'Dibatalkan'
            };
            return texts[status] || status;
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
@endsection