{{-- resources/views/catalog/notifications/index.blade.php --}}
@extends('layouts.catalog')

@section('title', 'Notifikasi')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="notificationsManager()" x-init="init()">
    <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-text-primary dark:text-text-dark-primary">Notifikasi</h1>
            <p class="text-text-secondary dark:text-text-dark-secondary">Update terbaru tentang pesanan dan aktivitas Anda</p>
        </div>
        <div class="flex gap-3">
            <button @click="markAllAsRead" class="btn btn-secondary text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Tandai Semua Dibaca
            </button>
            <button @click="clearAll" class="btn btn-outline text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Hapus Semua
            </button>
        </div>
    </div>

    <!-- Stats -->
    <div class="flex flex-wrap items-center gap-4 mb-6">
        <span class="text-sm text-text-secondary">
            <span class="font-bold text-text-primary dark:text-text-dark-primary" x-text="notifications.filter(n => !n.read).length"></span> belum dibaca
        </span>
        <div class="flex gap-2">
            <button @click="filter = 'all'" :class="filter === 'all' ? 'btn-primary' : 'btn-outline'" class="text-sm px-3 py-1">Semua</button>
            <button @click="filter = 'unread'" :class="filter === 'unread' ? 'btn-primary' : 'btn-outline'" class="text-sm px-3 py-1">Belum Dibaca</button>
            <button @click="filter = 'read'" :class="filter === 'read' ? 'btn-primary' : 'btn-outline'" class="text-sm px-3 py-1">Sudah Dibaca</button>
        </div>
    </div>

    <!-- Notifications List -->
    <div class="space-y-3">
        <template x-for="notification in filteredNotifications" :key="notification.id">
            <div class="card hover:shadow-lg transition-all duration-300" :class="notification.read ? 'opacity-70' : 'border-accent/20'">
                <div class="card-body">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0"
                             :class="{
                                 'bg-accent/10': notification.type === 'order',
                                 'bg-success/10': notification.type === 'success',
                                 'bg-warning/10': notification.type === 'warning',
                                 'bg-error/10': notification.type === 'error',
                                 'bg-info/10': notification.type === 'info'
                             }">
                            <span class="text-xl" x-text="notification.icon"></span>
                        </div>
                        <div class="flex-1">
                            <div class="flex flex-wrap items-start justify-between gap-2">
                                <div>
                                    <h4 class="font-semibold text-text-primary dark:text-text-dark-primary" x-text="notification.title"></h4>
                                    <p class="text-text-secondary dark:text-text-dark-secondary mt-0.5" x-text="notification.message"></p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-text-secondary" x-text="timeAgo(notification.created_at)"></span>
                                    <span x-show="!notification.read" class="w-2 h-2 bg-accent rounded-full"></span>
                                </div>
                            </div>
                            <div class="mt-3 flex items-center gap-3">
                                <button @click="markAsRead(notification.id)" x-show="!notification.read" class="text-xs text-accent hover:underline">
                                    Tandai Dibaca
                                </button>
                                <a :href="notification.link" x-show="notification.link" class="text-xs text-accent hover:underline">
                                    Lihat Detail →
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- Empty State -->
    <div x-show="filteredNotifications.length === 0" class="text-center py-16">
        <div class="w-24 h-24 bg-accent/10 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12 text-accent/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-text-primary dark:text-text-dark-primary mb-2">Tidak Ada Notifikasi</h3>
        <p class="text-text-secondary dark:text-text-dark-secondary">Belum ada notifikasi baru untuk Anda</p>
    </div>

    <!-- Mark All Read Confirmation -->
    <div x-show="showClearModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div class="card w-full max-w-md mx-4" @click.stop>
            <div class="card-header">
                <h3 class="text-xl font-bold text-warning">Konfirmasi</h3>
            </div>
            <div class="card-body">
                <p class="text-text-secondary dark:text-text-dark-secondary mb-6">
                    Yakin ingin menghapus semua notifikasi?
                </p>
                <div class="flex justify-center gap-3">
                    <button @click="showClearModal = false" class="btn btn-secondary">Batal</button>
                    <button @click="confirmClear" class="btn btn-danger">Hapus Semua</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function notificationsManager() {
    return {
        notifications: [
            { id: 1, type: 'order', icon: '📦', title: 'Pesanan Diproses', message: 'Pesanan #ORD-2026-001 sedang diproses', read: false, link: '/order/1', created_at: '2026-06-19T10:00:00' },
            { id: 2, type: 'success', icon: '✅', title: 'Pembayaran Berhasil', message: 'Pembayaran untuk pesanan #ORD-2026-002 berhasil', read: false, link: '/order/2', created_at: '2026-06-18T15:30:00' },
            { id: 3, type: 'info', icon: '📢', title: 'Promo Spesial', message: 'Dapatkan diskon 20% untuk pembelian pertama', read: true, link: null, created_at: '2026-06-17T08:00:00' },
            { id: 4, type: 'warning', icon: '⚠️', title: 'Stok Menipis', message: 'Produk "Smartphone Pro Max" hampir habis!', read: true, link: '/product/1', created_at: '2026-06-16T12:00:00' }
        ],
        filter: 'all',
        showClearModal: false,
        
        get filteredNotifications() {
            if (this.filter === 'unread') {
                return this.notifications.filter(n => !n.read);
            }
            if (this.filter === 'read') {
                return this.notifications.filter(n => n.read);
            }
            return this.notifications;
        },
        
        init() {},
        
        markAsRead(id) {
            const notif = this.notifications.find(n => n.id === id);
            if (notif) notif.read = true;
            window.showToast('Notifikasi ditandai dibaca', 'success');
        },
        
        markAllAsRead() {
            this.notifications.forEach(n => n.read = true);
            window.showToast('Semua notifikasi ditandai dibaca', 'success');
        },
        
        clearAll() {
            this.showClearModal = true;
        },
        
        confirmClear() {
            this.notifications = [];
            this.showClearModal = false;
            window.showToast('Semua notifikasi dihapus', 'success');
        },
        
        timeAgo(date) {
            const seconds = Math.floor((new Date() - new Date(date)) / 1000);
            if (seconds < 60) return 'Baru saja';
            const minutes = Math.floor(seconds / 60);
            if (minutes < 60) return minutes + ' menit lalu';
            const hours = Math.floor(minutes / 60);
            if (hours < 24) return hours + ' jam lalu';
            const days = Math.floor(hours / 24);
            return days + ' hari lalu';
        }
    }
}
</script>
@endpush
@endsection