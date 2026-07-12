{{-- resources/views/catalog/order/show.blade.php --}}
@extends('layouts.catalog')

@section('title', 'Detail Pesanan')

@section('content')
<div x-data="orderDetail()" x-init="init()" class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Navigation -->
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('catalog.order.index') }}" class="text-text-secondary hover:text-accent transition-colors group">
            <svg class="w-6 h-6 group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-text-primary dark:text-text-dark-primary">Detail Pesanan</h1>
            <p class="text-sm text-text-secondary dark:text-text-dark-secondary">
                <span class="font-mono" x-text="order.invoice_number"></span>
            </p>
        </div>
        <span class="badge ml-auto" :class="getStatusBadge(order.status)" x-text="getStatusText(order.status)"></span>
    </div>

    <!-- Status Timeline -->
    <div class="card mb-6">
        <div class="card-body">
            <div class="relative">
                <div class="flex items-center justify-between">
                    <!-- Step 1: Order Placed -->
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center"
                             :class="order.status !== 'cancelled' ? 'bg-accent text-white' : 'bg-light-border/40 dark:bg-dark-border/40 text-text-secondary'">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <p class="text-xs font-medium mt-2" :class="order.status !== 'cancelled' ? 'text-accent' : 'text-text-secondary'">Pesanan Dibuat</p>
                        <p class="text-xs text-text-secondary" x-text="formatDate(order.created_at)"></p>
                    </div>
                    
                    <!-- Progress Line -->
                    <div class="flex-1 h-1 mx-2 relative" :class="order.status !== 'cancelled' ? 'bg-accent/30' : 'bg-light-border/40 dark:bg-dark-border/40'">
                        <div class="h-full rounded-full transition-all" 
                             :class="{
                                 'bg-accent w-full': order.status === 'completed' || order.status === 'shipped',
                                 'bg-accent w-2/3': order.status === 'processing',
                                 'bg-accent w-1/3': order.status === 'pending',
                                 'bg-light-border/40 dark:bg-dark-border/40 w-0': order.status === 'cancelled'
                             }"></div>
                    </div>
                    
                    <!-- Step 2: Processing -->
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center"
                             :class="{
                                 'bg-accent text-white': order.status === 'processing' || order.status === 'shipped' || order.status === 'completed',
                                 'bg-accent/50 text-white': order.status === 'pending',
                                 'bg-light-border/40 dark:bg-dark-border/40 text-text-secondary': order.status === 'cancelled'
                             }">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            </svg>
                        </div>
                        <p class="text-xs font-medium mt-2" :class="order.status === 'cancelled' ? 'text-text-secondary' : 'text-text-primary dark:text-text-dark-primary'">Diproses</p>
                        <p class="text-xs text-text-secondary" x-show="order.status !== 'cancelled'">Estimasi 1-2 hari</p>
                    </div>
                    
                    <!-- Progress Line -->
                    <div class="flex-1 h-1 mx-2 relative" :class="order.status !== 'cancelled' ? 'bg-accent/30' : 'bg-light-border/40 dark:bg-dark-border/40'">
                        <div class="h-full rounded-full transition-all" 
                             :class="{
                                 'bg-accent w-full': order.status === 'shipped' || order.status === 'completed',
                                 'bg-accent w-1/2': order.status === 'processing',
                                 'bg-accent w-0': order.status === 'pending' || order.status === 'cancelled'
                             }"></div>
                    </div>
                    
                    <!-- Step 3: Shipped -->
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center"
                             :class="{
                                 'bg-accent text-white': order.status === 'shipped' || order.status === 'completed',
                                 'bg-accent/30 text-white': order.status === 'processing',
                                 'bg-light-border/40 dark:bg-dark-border/40 text-text-secondary': order.status === 'pending' || order.status === 'cancelled'
                             }">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <p class="text-xs font-medium mt-2" :class="order.status === 'cancelled' ? 'text-text-secondary' : 'text-text-primary dark:text-text-dark-primary'">Dikirim</p>
                    </div>
                    
                    <!-- Progress Line -->
                    <div class="flex-1 h-1 mx-2 relative" :class="order.status !== 'cancelled' ? 'bg-accent/30' : 'bg-light-border/40 dark:bg-dark-border/40'">
                        <div class="h-full rounded-full transition-all" 
                             :class="{
                                 'bg-accent w-full': order.status === 'completed',
                                 'bg-accent w-0': order.status !== 'completed' && order.status !== 'cancelled',
                                 'bg-light-border/40 dark:bg-dark-border/40 w-0': order.status === 'cancelled'
                             }"></div>
                    </div>
                    
                    <!-- Step 4: Delivered -->
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center"
                             :class="{
                                 'bg-accent text-white': order.status === 'completed',
                                 'bg-accent/30 text-white': order.status === 'shipped',
                                 'bg-light-border/40 dark:bg-dark-border/40 text-text-secondary': order.status === 'pending' || order.status === 'processing' || order.status === 'cancelled'
                             }">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <p class="text-xs font-medium mt-2" :class="order.status === 'cancelled' ? 'text-text-secondary' : 'text-text-primary dark:text-text-dark-primary'">Selesai</p>
                        <p class="text-xs text-text-secondary" x-show="order.status === 'completed'">Pesanan selesai</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        <!-- Order Items -->
        <div class="md:col-span-2 space-y-6">
            <div class="card">
                <div class="card-header flex items-center gap-2">
                    <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Item Pesanan</h3>
                    <span class="ml-auto text-sm text-text-secondary" x-text="order.items.length + ' item'"></span>
                </div>
                <div class="card-body space-y-4">
                    <template x-for="item in order.items" :key="item.id">
                        <div class="flex items-center gap-4 p-4 bg-light-surface/50 dark:bg-dark-surface/50 rounded-xl hover:shadow-md transition">
                            <div class="w-20 h-20 bg-light-surface dark:bg-dark-surface rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-10 h-10 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-text-primary dark:text-text-dark-primary" x-text="item.name"></h4>
                                <div class="flex flex-wrap items-center gap-4 mt-1">
                                    <span class="text-sm text-text-secondary">Qty: <span x-text="item.quantity"></span></span>
                                    <span class="text-sm text-text-secondary">@ <span x-text="formatRupiah(item.price)"></span></span>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-accent" x-text="formatRupiah(item.subtotal)"></p>
                            </div>
                        </div>
                    </template>
                    
                    <div class="mt-4 pt-4 border-t border-light-border/40 dark:border-dark-border/40 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-text-secondary">Subtotal</span>
                            <span x-text="formatRupiah(order.subtotal)"></span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-text-secondary">Pengiriman</span>
                            <span class="text-success" x-text="order.shipping_cost === 0 ? 'Gratis' : formatRupiah(order.shipping_cost)"></span>
                        </div>
                        <div class="flex justify-between text-sm" x-show="order.discount > 0">
                            <span class="text-text-secondary">Diskon</span>
                            <span class="text-error">-<span x-text="formatRupiah(order.discount)"></span></span>
                        </div>
                        <div class="flex justify-between pt-2 border-t border-light-border/40 dark:border-dark-border/40">
                            <span class="font-bold text-text-primary dark:text-text-dark-primary">Total</span>
                            <span class="font-bold text-accent text-xl" x-text="formatRupiah(order.total)"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Order Information -->
        <div class="space-y-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Informasi Pesanan</h3>
                </div>
                <div class="card-body space-y-4">
                    <div>
                        <p class="text-sm text-text-secondary">Order ID</p>
                        <p class="font-medium text-text-primary dark:text-text-dark-primary font-mono" x-text="order.invoice_number"></p>
                    </div>
                    <div>
                        <p class="text-sm text-text-secondary">Tanggal</p>
                        <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="formatDate(order.created_at)"></p>
                    </div>
                    <div>
                        <p class="text-sm text-text-secondary">Status</p>
                        <span class="badge" :class="getStatusBadge(order.status)" x-text="getStatusText(order.status)"></span>
                    </div>
                    <div>
                        <p class="text-sm text-text-secondary">Metode Pembayaran</p>
                        <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="order.payment_method"></p>
                    </div>
                    <div>
                        <p class="text-sm text-text-secondary">Status Pembayaran</p>
                        <span class="badge" :class="order.payment_status === 'Lunas' ? 'badge-success' : 'badge-warning'" x-text="order.payment_status"></span>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Alamat Pengiriman</h3>
                </div>
                <div class="card-body">
                    <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="order.shipping.name"></p>
                    <p class="text-sm text-text-secondary" x-text="order.shipping.address"></p>
                    <p class="text-sm text-text-secondary" x-text="order.shipping.city + ', ' + order.shipping.postal_code"></p>
                    <p class="text-sm text-text-secondary mt-2">📱 <span x-text="order.shipping.phone"></span></p>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body space-y-2">
                    <button class="btn btn-secondary w-full text-sm gap-2" @click="downloadInvoice">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Download Invoice
                    </button>
                    <button class="btn btn-outline w-full text-sm gap-2" @click="contactSeller">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        Hubungi Toko
                    </button>
                    <button x-show="order.status === 'pending'" 
                            class="btn btn-danger w-full text-sm gap-2" 
                            @click="cancelOrder">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Batalkan Pesanan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function orderDetail() {
    return {
        order: {
            id: 1,
            invoice_number: '#ORD-2026-001',
            created_at: '2026-06-17T14:30:00',
            status: 'processing',
            subtotal: 149000,
            shipping_cost: 0,
            discount: 0,
            total: 149000,
            items: [
                { id: 1, name: 'Smartphone Pro Max', quantity: 1, price: 100000, subtotal: 100000 },
                { id: 2, name: 'Kemeja Casual Premium', quantity: 2, price: 24500, subtotal: 49000 }
            ],
            shipping: {
                name: 'Budi Santoso',
                address: 'Jl. Contoh No. 123, RT 01 RW 02',
                city: 'Jakarta Selatan',
                postal_code: '12345',
                phone: '08123456789'
            },
            payment_method: 'Transfer Bank',
            payment_status: 'Menunggu Konfirmasi'
        },
        
        init() {
            // Load order data
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
        
        downloadInvoice() {
            window.showToast('Download invoice akan dimulai', 'success');
        },
        
        contactSeller() {
            window.showToast('Fitur chat akan segera tersedia', 'info');
        },
        
        cancelOrder() {
            if (confirm('Yakin ingin membatalkan pesanan ini?')) {
                window.showToast('Pesanan berhasil dibatalkan', 'success');
            }
        }
    }
}
</script>
@endpush
@endsection