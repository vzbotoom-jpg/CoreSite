{{-- resources/views/catalog/order/tracking.blade.php --}}
@extends('layouts.catalog')

@section('title', 'Tracking Pesanan')

@section('content')
<div x-data="orderTracking()" x-init="init()" class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header -->
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('catalog.order.index') }}" class="text-text-secondary hover:text-accent transition-colors group">
            <svg class="w-6 h-6 group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-text-primary dark:text-text-dark-primary">Tracking Pesanan</h1>
            <p class="text-sm text-text-secondary dark:text-text-dark-secondary">
                <span class="font-mono" x-text="order.invoice_number"></span>
            </p>
        </div>
        <span class="badge ml-auto" :class="getStatusBadge(order.status)" x-text="getStatusText(order.status)"></span>
    </div>

    <!-- Tracking Map / Visual -->
    <div class="card mb-8 border-accent/20 bg-gradient-to-br from-accent/5 to-transparent">
        <div class="card-body">
            <div class="relative">
                <!-- Timeline with dots and lines -->
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 md:gap-0">
                    <template x-for="(step, index) in trackingSteps" :key="index">
                        <div class="flex items-center gap-4 md:gap-0">
                            <div class="flex flex-col items-center">
                                <div class="relative">
                                    <div class="w-14 h-14 rounded-full flex items-center justify-center text-2xl border-2 transition-all duration-500"
                                         :class="step.status === 'completed' ? 'bg-accent text-white border-accent' :
                                                 step.status === 'active' ? 'bg-accent/20 text-accent border-accent animate-pulse' :
                                                 'bg-light-surface dark:bg-dark-surface text-text-secondary border-light-border/40 dark:border-dark-border/40'">
                                        <span x-text="step.icon"></span>
                                    </div>
                                    <!-- Checkmark overlay for completed -->
                                    <div x-show="step.status === 'completed'" 
                                         class="absolute -top-1 -right-1 w-5 h-5 bg-accent rounded-full flex items-center justify-center text-white text-xs">
                                        ✓
                                    </div>
                                </div>
                                <div class="mt-2 text-center max-w-[80px]">
                                    <p class="text-xs font-medium" :class="step.status === 'completed' ? 'text-accent' : step.status === 'active' ? 'text-text-primary dark:text-text-dark-primary' : 'text-text-secondary'" 
                                       x-text="step.label"></p>
                                    <p class="text-[10px] text-text-secondary mt-0.5" x-text="step.time"></p>
                                </div>
                            </div>
                            <!-- Connector line -->
                            <div x-show="index < trackingSteps.length - 1" 
                                 class="hidden md:block flex-1 h-0.5 min-w-[40px]"
                                 :class="step.status === 'completed' ? 'bg-accent' : step.status === 'active' ? 'bg-accent/50' : 'bg-light-border/40 dark:bg-dark-border/40'">
                            </div>
                            <div x-show="index < trackingSteps.length - 1" 
                                 class="block md:hidden w-0.5 h-8 ml-7"
                                 :class="step.status === 'completed' ? 'bg-accent' : step.status === 'active' ? 'bg-accent/50' : 'bg-light-border/40 dark:bg-dark-border/40'">
                            </div>
                        </div>
                    </template>
                </div>
                
                <!-- Estimated delivery -->
                <div class="mt-8 pt-6 border-t border-light-border/40 dark:border-dark-border/40 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <svg class="w-8 h-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="text-sm text-text-secondary">Estimasi Pengiriman</p>
                            <p class="font-bold text-text-primary dark:text-text-dark-primary" x-text="order.estimated_delivery"></p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 bg-accent rounded-full"></span>
                            <span class="text-sm text-text-secondary">Selesai</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 bg-accent/50 rounded-full animate-pulse"></span>
                            <span class="text-sm text-text-secondary">Dalam Proses</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 bg-light-border/40 dark:bg-dark-border/40 rounded-full"></span>
                            <span class="text-sm text-text-secondary">Belum</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Courier Info -->
    <div class="grid md:grid-cols-2 gap-6 mb-8">
        <div class="card">
            <div class="card-header">
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Informasi Kurir</h3>
            </div>
            <div class="card-body space-y-3">
                <div class="flex items-center gap-3 p-3 bg-light-surface/50 dark:bg-dark-surface/50 rounded-lg">
                    <div class="w-12 h-12 bg-accent/10 rounded-full flex items-center justify-center">
                        <span class="text-2xl">🚚</span>
                    </div>
                    <div>
                        <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="order.courier"></p>
                        <p class="text-sm text-text-secondary" x-text="order.courier_service"></p>
                    </div>
                </div>
                <div>
                    <p class="text-sm text-text-secondary">Nomor Resi</p>
                    <p class="font-mono font-medium text-text-primary dark:text-text-dark-primary" x-text="order.tracking_number"></p>
                </div>
                <a :href="order.tracking_url" target="_blank" class="btn btn-secondary w-full text-sm gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    Lacak di Website Kurir
                </a>
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
    </div>

    <!-- Tracking Updates -->
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Riwayat Tracking</h3>
            <span class="text-sm text-text-secondary" x-text="order.tracking_updates.length + ' update'"></span>
        </div>
        <div class="card-body">
            <div class="relative pl-6 space-y-6 before:absolute before:left-[5px] before:top-2 before:bottom-2 before:w-0.5 before:bg-light-border/40 dark:before:bg-dark-border/40">
                <template x-for="update in order.tracking_updates" :key="update.id">
                    <div class="relative">
                        <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full border-2"
                             :class="update.status === 'delivered' ? 'bg-accent border-accent' : 'bg-accent/30 border-accent/50'">
                        </div>
                        <div class="flex flex-wrap items-start justify-between gap-2">
                            <div>
                                <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="update.title"></p>
                                <p class="text-sm text-text-secondary dark:text-text-dark-secondary" x-text="update.description"></p>
                                <p class="text-xs text-text-secondary/60 mt-1" x-text="update.location"></p>
                            </div>
                            <p class="text-sm text-text-secondary whitespace-nowrap" x-text="formatTime(update.time)"></p>
                        </div>
                    </div>
                </template>
            </div>
            
            <!-- Loading shimmer effect -->
            <div x-show="loading" class="space-y-4">
                <div class="animate-pulse flex items-start gap-4">
                    <div class="w-3 h-3 bg-light-border/40 rounded-full mt-1"></div>
                    <div class="flex-1">
                        <div class="h-4 bg-light-border/40 rounded w-3/4 mb-2"></div>
                        <div class="h-3 bg-light-border/40 rounded w-1/2"></div>
                    </div>
                </div>
                <div class="animate-pulse flex items-start gap-4">
                    <div class="w-3 h-3 bg-light-border/40 rounded-full mt-1"></div>
                    <div class="flex-1">
                        <div class="h-4 bg-light-border/40 rounded w-2/3 mb-2"></div>
                        <div class="h-3 bg-light-border/40 rounded w-1/3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Help / Contact -->
    <div class="mt-6 p-4 bg-accent/5 border border-accent/20 rounded-xl text-center">
        <p class="text-sm text-text-secondary dark:text-text-dark-secondary">
            Ada masalah dengan pengiriman? 
            <a href="{{ route('contact') }}" class="text-accent hover:underline font-medium">Hubungi Tim Support</a>
        </p>
    </div>
</div>

@push('scripts')
<script>
function orderTracking() {
    return {
        order: {
            id: 1,
            invoice_number: '#ORD-2026-001',
            status: 'shipped',
            estimated_delivery: '20 Juni 2026',
            courier: 'J&T Express',
            courier_service: 'J&T Standard',
            tracking_number: 'JT1234567890',
            tracking_url: '#',
            shipping: {
                name: 'Budi Santoso',
                address: 'Jl. Contoh No. 123, RT 01 RW 02',
                city: 'Jakarta Selatan',
                postal_code: '12345',
                phone: '08123456789'
            },
            tracking_updates: [
                { id: 1, title: 'Pesanan Dibuat', description: 'Pesanan telah berhasil dibuat', location: 'Online', time: '2026-06-17T14:30:00', status: 'delivered' },
                { id: 2, title: 'Pesanan Diproses', description: 'Pesanan sedang diproses oleh toko', location: 'Toko CoreSite', time: '2026-06-18T09:00:00', status: 'delivered' },
                { id: 3, title: 'Pesanan Dikirim', description: 'Pesanan telah dikirim melalui kurir', location: 'Gudang CoreSite', time: '2026-06-19T08:30:00', status: 'active' },
                { id: 4, title: 'Dalam Perjalanan', description: 'Paket sedang dalam perjalanan menuju alamat tujuan', location: 'Jakarta', time: '2026-06-19T14:00:00', status: 'pending' },
                { id: 5, title: 'Paket Tiba', description: 'Paket telah tiba di kota tujuan', location: 'Jakarta Selatan', time: '2026-06-20T10:00:00', status: 'pending' }
            ]
        },
        loading: false,
        
        get trackingSteps() {
            const steps = [
                { label: 'Dibuat', icon: '📦', status: 'completed', time: this.formatTime(this.order.tracking_updates[0]?.time) },
                { label: 'Diproses', icon: '⚙️', status: 'completed', time: this.formatTime(this.order.tracking_updates[1]?.time) },
                { label: 'Dikirim', icon: '🚚', status: 'active', time: this.formatTime(this.order.tracking_updates[2]?.time) },
                { label: 'Diterima', icon: '🏠', status: 'pending', time: this.formatTime(this.order.tracking_updates[4]?.time) }
            ];
            return steps;
        },
        
        init() {
            // Load tracking data
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
        
        formatTime(date) {
            if (!date) return '-';
            const d = new Date(date);
            return d.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }
    }
}
</script>
@endpush
@endsection