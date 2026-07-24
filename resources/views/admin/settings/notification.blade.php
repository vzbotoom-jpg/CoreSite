{{-- resources/views/admin/settings/notification.blade.php --}}
@extends('layouts.app')

@section('title', 'Pengaturan Notifikasi')
@section('page-title', 'Pengaturan Notifikasi')

@section('content')
<div class="max-w-3xl mx-auto" x-data="notificationSettings()" x-init="init()">
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Pengaturan Notifikasi</h3>
            <p class="text-sm text-text-secondary dark:text-text-dark-secondary mt-1">Atur preferensi notifikasi untuk toko Anda</p>
        </div>
        <div class="card-body">
            <form @submit.prevent="saveSettings">
                <!-- Email Notifications -->
                <div class="space-y-6">
                    <h4 class="font-medium text-text-primary dark:text-text-dark-primary">Notifikasi Email</h4>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 border border-light-border dark:border-dark-border rounded-lg hover:bg-light-surface dark:hover:bg-dark-surface transition-colors">
                            <div>
                                <p class="font-medium text-text-primary dark:text-text-dark-primary">Low Stock Alert</p>
                                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Dikirim saat stok produk mencapai batas minimum</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" x-model="settings.low_stock_alert" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-300 rounded-full peer peer-checked:bg-accent transition-colors"></div>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between p-4 border border-light-border dark:border-dark-border rounded-lg hover:bg-light-surface dark:hover:bg-dark-surface transition-colors">
                            <div>
                                <p class="font-medium text-text-primary dark:text-text-dark-primary">Monthly Report</p>
                                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Laporan keuangan bulanan via email</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" x-model="settings.monthly_report" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-300 rounded-full peer peer-checked:bg-accent transition-colors"></div>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between p-4 border border-light-border dark:border-dark-border rounded-lg hover:bg-light-surface dark:hover:bg-dark-surface transition-colors">
                            <div>
                                <p class="font-medium text-text-primary dark:text-text-dark-primary">Daily Sales Summary</p>
                                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Ringkasan penjualan harian via email</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" x-model="settings.daily_sales" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-300 rounded-full peer peer-checked:bg-accent transition-colors"></div>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between p-4 border border-light-border dark:border-dark-border rounded-lg hover:bg-light-surface dark:hover:bg-dark-surface transition-colors">
                            <div>
                                <p class="font-medium text-text-primary dark:text-text-dark-primary">New Order Notification</p>
                                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Notifikasi saat ada transaksi baru</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" x-model="settings.new_order" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-300 rounded-full peer peer-checked:bg-accent transition-colors"></div>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between p-4 border border-light-border dark:border-dark-border rounded-lg hover:bg-light-surface dark:hover:bg-dark-surface transition-colors">
                            <div>
                                <p class="font-medium text-text-primary dark:text-text-dark-primary">Product Review</p>
                                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Notifikasi review produk baru</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" x-model="settings.product_review" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-300 rounded-full peer peer-checked:bg-accent transition-colors"></div>
                            </label>
                        </div>
                    </div>
                </div>
                
                <!-- Notification Email -->
                <div class="mt-8 border-t border-light-border dark:border-dark-border pt-6">
                    <h4 class="font-medium text-text-primary dark:text-text-dark-primary mb-4">Email Tujuan Notifikasi</h4>
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Email</label>
                        <input type="email" x-model="settings.notification_email" class="input" placeholder="notification@example.com">
                        <p class="text-xs text-text-secondary dark:text-text-dark-secondary mt-1">Email yang akan menerima semua notifikasi</p>
                    </div>
                </div>
                
                <!-- In-App Notifications -->
                <div class="mt-8 border-t border-light-border dark:border-dark-border pt-6">
                    <h4 class="font-medium text-text-primary dark:text-text-dark-primary mb-4">Notifikasi In-App</h4>
                    <div class="space-y-3">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" x-model="settings.in_app_notifications" class="w-4 h-4 rounded border-gray-300 text-accent focus:ring-accent">
                            <span class="text-text-primary dark:text-text-dark-primary">Aktifkan notifikasi di dashboard</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" x-model="settings.in_app_sound" class="w-4 h-4 rounded border-gray-300 text-accent focus:ring-accent">
                            <span class="text-text-primary dark:text-text-dark-primary">Suara notifikasi</span>
                        </label>
                    </div>
                </div>
                
                <!-- Submit -->
                <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-light-border dark:border-dark-border">
                    <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function notificationSettings() {
    return {
        settings: {
            low_stock_alert: true,
            monthly_report: true,
            daily_sales: false,
            new_order: true,
            product_review: false,
            notification_email: '',
            in_app_notifications: true,
            in_app_sound: true
        },
        
        init() {
            this.loadSettings();
        },
        
        async loadSettings() {
            try {
                const response = await axios.get('/admin/settings/notification-data');
                if (response.data.success) {
                    this.settings = response.data.data;
                }
            } catch (error) {
                console.error('Failed to load notification settings:', error);
            }
        },
        
        async saveSettings() {
            try {
                const response = await axios.post('/admin/settings/notification', this.settings);
                if (response.data.success) {
                    window.showToast('Pengaturan notifikasi berhasil disimpan', 'success');
                }
            } catch (error) {
                window.showToast(error.response?.data?.message || 'Gagal menyimpan pengaturan', 'error');
            }
        }
    }
}
</script>
@endpush
@endsection