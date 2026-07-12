{{-- resources/views/catalog/order/index.blade.php --}}
@extends('layouts.catalog')

@section('title', 'Pesanan Saya')

@section('content')
<div x-data="orderList()" x-init="init()" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-text-primary dark:text-text-dark-primary tracking-tight">
                Pesanan Saya
            </h1>
            <p class="text-text-secondary dark:text-text-dark-secondary mt-1">
                Kelola dan pantau semua pesanan Anda
            </p>
        </div>
        <a href="{{ route('catalog.store') }}" class="btn btn-primary gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Belanja Lagi
        </a>
    </div>

    <!-- Stats Summary -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer" @click="filter = 'all'">
            <div class="card-body py-4 text-center">
                <div class="flex items-center justify-center gap-2">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <span class="text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Semua</span>
                </div>
                <p class="text-2xl font-bold text-text-primary dark:text-text-dark-primary mt-1">12</p>
            </div>
        </div>
        <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer border-warning/20" @click="filter = 'pending'">
            <div class="card-body py-4 text-center">
                <div class="flex items-center justify-center gap-2">
                    <svg class="w-5 h-5 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Pending</span>
                </div>
                <p class="text-2xl font-bold text-warning mt-1">3</p>
            </div>
        </div>
        <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer border-success/20" @click="filter = 'completed'">
            <div class="card-body py-4 text-center">
                <div class="flex items-center justify-center gap-2">
                    <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Selesai</span>
                </div>
                <p class="text-2xl font-bold text-success mt-1">8</p>
            </div>
        </div>
        <div class="card hover:shadow-lg transition-all duration-300 cursor-pointer border-error/20" @click="filter = 'cancelled'">
            <div class="card-body py-4 text-center">
                <div class="flex items-center justify-center gap-2">
                    <svg class="w-5 h-5 text-error" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    <span class="text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Dibatalkan</span>
                </div>
                <p class="text-2xl font-bold text-error mt-1">1</p>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="card mb-6">
        <div class="card-body">
            <div class="flex flex-wrap items-center gap-4">
                <div class="flex-1 min-w-[200px]">
                    <div class="relative">
                        <input type="text" x-model="searchQuery" @input="filterOrders" 
                               placeholder="Cari pesanan..." class="input pl-10">
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-text-secondary" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2">
                    <button @click="filter = 'all'" :class="filter === 'all' ? 'btn-primary' : 'btn-outline'" class="text-sm px-4 py-2">
                        Semua
                    </button>
                    <button @click="filter = 'pending'" :class="filter === 'pending' ? 'btn-primary' : 'btn-outline'" class="text-sm px-4 py-2">
                        ⏳ Pending
                    </button>
                    <button @click="filter = 'processing'" :class="filter === 'processing' ? 'btn-primary' : 'btn-outline'" class="text-sm px-4 py-2">
                        📦 Diproses
                    </button>
                    <button @click="filter = 'shipped'" :class="filter === 'shipped' ? 'btn-primary' : 'btn-outline'" class="text-sm px-4 py-2">
                        🚚 Dikirim
                    </button>
                    <button @click="filter = 'completed'" :class="filter === 'completed' ? 'btn-primary' : 'btn-outline'" class="text-sm px-4 py-2">
                        ✅ Selesai
                    </button>
                    <button @click="filter = 'cancelled'" :class="filter === 'cancelled' ? 'btn-primary' : 'btn-outline'" class="text-sm px-4 py-2">
                        ❌ Dibatalkan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders List -->
    <div class="space-y-4" x-show="filteredOrders.length > 0">
        <template x-for="order in filteredOrders" :key="order.id">
            <div class="card hover:shadow-xl transition-all duration-300 group">
                <div class="card-body p-6">
                    <!-- Order Header -->
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center"
                                 :class="{
                                     'bg-accent/10': order.status === 'completed',
                                     'bg-warning/10': order.status === 'pending' || order.status === 'processing',
                                     'bg-error/10': order.status === 'cancelled',
                                     'bg-info/10': order.status === 'shipped'
                                 }">
                                <span x-text="getStatusIcon(order.status)" class="text-2xl"></span>
                            </div>
                            <div>
                                <p class="font-semibold text-text-primary dark:text-text-dark-primary">
                                    <span class="font-mono" x-text="order.invoice_number"></span>
                                </p>
                                <p class="text-sm text-text-secondary dark:text-text-dark-secondary" x-text="formatDate(order.created_at)"></p>
                            </div>
                        </div>
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="badge" :class="getStatusBadge(order.status)" x-text="getStatusText(order.status)"></span>
                            <span class="font-bold text-accent text-lg" x-text="formatRupiah(order.total)"></span>
                            <span class="text-sm text-text-secondary" x-text="order.items_count + ' item'"></span>
                        </div>
                    </div>

                    <!-- Order Items Preview -->
                    <div class="mt-4 pt-4 border-t border-light-border/40 dark:border-dark-border/40">
                        <div class="flex flex-wrap items-center gap-4">
                            <div class="flex -space-x-2">
                                <template x-for="(item, index) in order.items.slice(0, 3)" :key="index">
                                    <div class="w-10 h-10 bg-light-surface dark:bg-dark-surface rounded-lg border-2 border-light-bg dark:border-dark-bg flex items-center justify-center text-xs font-medium text-text-secondary">
                                        <span x-text="item.name.charAt(0).toUpperCase()"></span>
                                    </div>
                                </template>
                                <div x-show="order.items.length > 3" 
                                     class="w-10 h-10 bg-light-surface dark:bg-dark-surface rounded-lg border-2 border-light-bg dark:border-dark-bg flex items-center justify-center text-xs font-medium text-text-secondary">
                                    +<span x-text="order.items.length - 3"></span>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-text-secondary" x-text="order.items.map(i => i.name).join(', ').substring(0, 60) + (order.items.length > 3 ? '...' : '')"></p>
                            </div>
                            <div class="flex items-center gap-2">
                                <a :href="`/order/${order.id}`" class="btn btn-ghost btn-sm text-accent hover:text-accent-hover">
                                    Detail →
                                </a>
                                <button x-show="order.status === 'pending'" 
                                        @click="cancelOrder(order.id)" 
                                        class="btn btn-ghost btn-sm text-error hover:text-error/80">
                                    Batalkan
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons (expandable) -->
                    <div x-data="{ expanded: false }" class="mt-3 pt-3 border-t border-light-border/40 dark:border-dark-border/40">
                        <button @click="expanded = !expanded" class="text-sm text-text-secondary hover:text-accent transition flex items-center gap-1">
                            <span x-text="expanded ? 'Sembunyikan detail' : 'Lihat detail lengkap'"></span>
                            <svg class="w-4 h-4 transition-transform" :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        
                        <div x-show="expanded" x-collapse class="mt-4 space-y-4">
                            <!-- Order Items Detail -->
                            <div class="space-y-2">
                                <h4 class="font-medium text-text-primary dark:text-text-dark-primary">Item Pesanan</h4>
                                <template x-for="item in order.items" :key="item.id">
                                    <div class="flex items-center gap-4 p-3 bg-light-surface/50 dark:bg-dark-surface/50 rounded-lg">
                                        <div class="w-12 h-12 bg-light-surface dark:bg-dark-surface rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="w-6 h-6 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="item.name"></p>
                                            <p class="text-sm text-text-secondary">Qty: <span x-text="item.quantity"></span></p>
                                        </div>
                                        <p class="font-medium text-accent" x-text="formatRupiah(item.subtotal)"></p>
                                    </div>
                                </template>
                            </div>
                            
                            <!-- Shipping Info -->
                            <div class="grid sm:grid-cols-2 gap-4">
                                <div>
                                    <h4 class="font-medium text-text-primary dark:text-text-dark-primary mb-2">Alamat Pengiriman</h4>
                                    <div class="p-3 bg-light-surface/50 dark:bg-dark-surface/50 rounded-lg">
                                        <p class="font-medium" x-text="order.shipping.name"></p>
                                        <p class="text-sm text-text-secondary" x-text="order.shipping.address"></p>
                                        <p class="text-sm text-text-secondary" x-text="order.shipping.phone"></p>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="font-medium text-text-primary dark:text-text-dark-primary mb-2">Metode Pembayaran</h4>
                                    <div class="p-3 bg-light-surface/50 dark:bg-dark-surface/50 rounded-lg">
                                        <p class="font-medium" x-text="order.payment_method"></p>
                                        <p class="text-sm text-text-secondary" x-text="order.payment_status"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- Empty State -->
    <div x-show="filteredOrders.length === 0" class="text-center py-16">
        <div class="w-24 h-24 bg-accent/10 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12 text-accent/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-text-primary dark:text-text-dark-primary mb-2">Belum Ada Pesanan</h3>
        <p class="text-text-secondary dark:text-text-dark-secondary mb-6">
            <span x-show="searchQuery || filter !== 'all'">Tidak ada pesanan yang sesuai dengan filter yang dipilih</span>
            <span x-show="!searchQuery && filter === 'all'">Mulai belanja sekarang untuk melihat pesanan Anda</span>
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('catalog.store') }}" class="btn btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6M17 13l1.5 6M9 21h6"/>
                </svg>
                Mulai Belanja
            </a>
            <button @click="filter = 'all'; searchQuery = ''" x-show="searchQuery || filter !== 'all'" class="btn btn-secondary">
                Reset Filter
            </button>
        </div>
    </div>

    <!-- Pagination -->
    <div x-show="filteredOrders.length > 0" class="mt-8 flex flex-wrap items-center justify-between gap-4">
        <p class="text-sm text-text-secondary dark:text-text-dark-secondary">
            Menampilkan <span x-text="filteredOrders.length"></span> dari <span x-text="orders.length"></span> pesanan
        </p>
        <div class="flex gap-2">
            <button class="px-3 py-1 border border-light-border/40 dark:border-dark-border/40 rounded-lg text-sm hover:bg-light-surface/50 dark:hover:bg-dark-surface/50 transition disabled:opacity-50 disabled:cursor-not-allowed">
                Sebelumnya
            </button>
            <button class="px-3 py-1 bg-accent text-white rounded-lg text-sm">1</button>
            <button class="px-3 py-1 border border-light-border/40 dark:border-dark-border/40 rounded-lg text-sm hover:bg-light-surface/50 dark:hover:bg-dark-surface/50 transition">2</button>
            <button class="px-3 py-1 border border-light-border/40 dark:border-dark-border/40 rounded-lg text-sm hover:bg-light-surface/50 dark:hover:bg-dark-surface/50 transition">3</button>
            <button class="px-3 py-1 border border-light-border/40 dark:border-dark-border/40 rounded-lg text-sm hover:bg-light-surface/50 dark:hover:bg-dark-surface/50 transition">
                Selanjutnya
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
function orderList() {
    return {
        orders: [
            {
                id: 1,
                invoice_number: '#ORD-2026-001',
                created_at: '2026-06-17T14:30:00',
                total: 149000,
                status: 'pending',
                items_count: 3,
                items: [
                    { id: 1, name: 'Smartphone Pro Max', quantity: 1, subtotal: 100000 },
                    { id: 2, name: 'Kemeja Casual Premium', quantity: 2, subtotal: 49000 }
                ],
                shipping: {
                    name: 'Budi Santoso',
                    address: 'Jl. Contoh No. 123, Jakarta Selatan',
                    phone: '08123456789'
                },
                payment_method: 'Transfer Bank',
                payment_status: 'Menunggu Konfirmasi'
            },
            {
                id: 2,
                invoice_number: '#ORD-2026-002',
                created_at: '2026-06-15T10:15:00',
                total: 75000,
                status: 'completed',
                items_count: 2,
                items: [
                    { id: 3, name: 'Kopi Arabika 250gr', quantity: 2, subtotal: 75000 }
                ],
                shipping: {
                    name: 'Budi Santoso',
                    address: 'Jl. Contoh No. 123, Jakarta Selatan',
                    phone: '08123456789'
                },
                payment_method: 'QRIS',
                payment_status: 'Lunas'
            },
            {
                id: 3,
                invoice_number: '#ORD-2026-003',
                created_at: '2026-06-12T09:00:00',
                total: 220000,
                status: 'cancelled',
                items_count: 4,
                items: [
                    { id: 4, name: 'Yoga Mat Premium', quantity: 1, subtotal: 180000 },
                    { id: 5, name: 'Headphone Bluetooth', quantity: 1, subtotal: 35000 }
                ],
                shipping: {
                    name: 'Budi Santoso',
                    address: 'Jl. Contoh No. 123, Jakarta Selatan',
                    phone: '08123456789'
                },
                payment_method: 'Tunai',
                payment_status: 'Dibatalkan'
            }
        ],
        filter: 'all',
        searchQuery: '',
        
        get filteredOrders() {
            return this.orders.filter(order => {
                // Filter by status
                if (this.filter !== 'all' && order.status !== this.filter) return false;
                
                // Filter by search
                if (this.searchQuery) {
                    const query = this.searchQuery.toLowerCase();
                    return order.invoice_number.toLowerCase().includes(query) ||
                           order.items.some(item => item.name.toLowerCase().includes(query));
                }
                
                return true;
            });
        },
        
        init() {
            // Auto-refresh or any initialization
        },
        
        filterOrders() {
            // Triggered by search input
        },
        
        getStatusBadge(status) {
            const map = {
                'pending': 'badge-warning',
                'processing': 'badge-info',
                'shipped': 'badge-primary',
                'completed': 'badge-success',
                'cancelled': 'badge-error'
            };
            return map[status] || 'badge-secondary';
        },
        
        getStatusText(status) {
            const map = {
                'pending': '⏳ Menunggu',
                'processing': '📦 Diproses',
                'shipped': '🚚 Dikirim',
                'completed': '✅ Selesai',
                'cancelled': '❌ Dibatalkan'
            };
            return map[status] || status;
        },
        
        getStatusIcon(status) {
            const map = {
                'pending': '⏳',
                'processing': '📦',
                'shipped': '🚚',
                'completed': '✅',
                'cancelled': '❌'
            };
            return map[status] || '📌';
        },
        
        formatDate(date) {
            const d = new Date(date);
            return d.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'long',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        },
        
        formatRupiah(value) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(value);
        },
        
        cancelOrder(id) {
            if (confirm('Yakin ingin membatalkan pesanan ini?')) {
                window.showToast('Pesanan berhasil dibatalkan', 'success');
            }
        }
    }
}
</script>
@endpush
@endsection