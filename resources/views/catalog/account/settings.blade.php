{{-- resources/views/catalog/account/settings.blade.php --}}
@extends('layouts.catalog')

@section('title', 'Pengaturan Akun')

@section('content')
<div x-data="settingsManager()" x-init="init()" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid md:grid-cols-4 gap-8">
        <div class="md:col-span-1">
            @include('catalog.account.partials.sidebar')
        </div>
        
        <div class="md:col-span-3">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-text-primary dark:text-text-dark-primary">Pengaturan Akun</h1>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Kelola keamanan dan preferensi akun Anda</p>
            </div>
            
            <div class="space-y-6">
                <!-- Change Password -->
                <div class="card">
                    <div class="card-header">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Ubah Password</h3>
                        </div>
                        <p class="text-sm text-text-secondary dark:text-text-dark-secondary mt-1">Perbarui password untuk keamanan akun</p>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="changePassword">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Password Lama *</label>
                                    <div class="relative">
                                        <input :type="showCurrentPassword ? 'text' : 'password'" x-model="passwordForm.current" required class="input" placeholder="Masukkan password lama">
                                        <button type="button" @click="showCurrentPassword = !showCurrentPassword" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-text-secondary hover:text-text-primary transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Password Baru *</label>
                                    <div class="relative">
                                        <input :type="showNewPassword ? 'text' : 'password'" x-model="passwordForm.new" required class="input" placeholder="Masukkan password baru">
                                        <button type="button" @click="showNewPassword = !showNewPassword" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-text-secondary hover:text-text-primary transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="mt-1 flex items-center gap-2">
                                        <div class="w-full h-1 bg-light-border/40 dark:bg-dark-border/40 rounded-full overflow-hidden">
                                            <div class="h-full bg-accent rounded-full transition-all" :style="{ width: passwordStrength + '%' }"></div>
                                        </div>
                                        <span class="text-xs text-text-secondary" x-text="passwordStrengthText"></span>
                                    </div>
                                    <p class="text-xs text-text-secondary mt-1">Minimal 8 karakter dengan kombinasi huruf, angka, dan simbol</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Konfirmasi Password Baru *</label>
                                    <div class="relative">
                                        <input :type="showConfirmPassword ? 'text' : 'password'" x-model="passwordForm.confirm" required class="input" placeholder="Konfirmasi password baru">
                                        <button type="button" @click="showConfirmPassword = !showConfirmPassword" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-text-secondary hover:text-text-primary transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <p x-show="passwordForm.new && passwordForm.confirm && passwordForm.new !== passwordForm.confirm" class="text-error text-sm mt-1">Password tidak cocok</p>
                                </div>
                            </div>
                            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-light-border/40 dark:border-dark-border/40">
                                <button type="submit" class="btn btn-primary" :disabled="loading || (passwordForm.new && passwordForm.confirm && passwordForm.new !== passwordForm.confirm)">
                                    <span x-show="!loading">Update Password</span>
                                    <span x-show="loading" class="flex items-center gap-2">
                                        <div class="spinner w-4 h-4"></div>
                                        Memproses...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Notification Settings -->
                <div class="card">
                    <div class="card-header">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Notifikasi</h3>
                        </div>
                        <p class="text-sm text-text-secondary dark:text-text-dark-secondary mt-1">Atur preferensi notifikasi Anda</p>
                    </div>
                    <div class="card-body space-y-4">
                        <div class="flex items-center justify-between p-4 border border-light-border/40 dark:border-dark-border/40 rounded-lg hover:bg-light-surface/50 dark:hover:bg-dark-surface/50 transition">
                            <div>
                                <p class="font-medium text-text-primary dark:text-text-dark-primary">Email Notifikasi</p>
                                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Terima notifikasi pesanan via email</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" x-model="notifications.email" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-300 dark:bg-gray-600 rounded-full peer peer-checked:bg-accent transition-colors"></div>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between p-4 border border-light-border/40 dark:border-dark-border/40 rounded-lg hover:bg-light-surface/50 dark:hover:bg-dark-surface/50 transition">
                            <div>
                                <p class="font-medium text-text-primary dark:text-text-dark-primary">Promosi & Penawaran</p>
                                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Terima promo dan penawaran menarik</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" x-model="notifications.promotions" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-300 dark:bg-gray-600 rounded-full peer peer-checked:bg-accent transition-colors"></div>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between p-4 border border-light-border/40 dark:border-dark-border/40 rounded-lg hover:bg-light-surface/50 dark:hover:bg-dark-surface/50 transition">
                            <div>
                                <p class="font-medium text-text-primary dark:text-text-dark-primary">Status Pesanan</p>
                                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Update status pesanan via email</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" x-model="notifications.order_status" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-300 dark:bg-gray-600 rounded-full peer peer-checked:bg-accent transition-colors"></div>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between p-4 border border-light-border/40 dark:border-dark-border/40 rounded-lg hover:bg-light-surface/50 dark:hover:bg-dark-surface/50 transition">
                            <div>
                                <p class="font-medium text-text-primary dark:text-text-dark-primary">In-App Notifikasi</p>
                                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Notifikasi di dalam aplikasi</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" x-model="notifications.in_app" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-300 dark:bg-gray-600 rounded-full peer peer-checked:bg-accent transition-colors"></div>
                            </label>
                        </div>
                        
                        <div class="flex justify-end pt-4 border-t border-light-border/40 dark:border-dark-border/40">
                            <button @click="saveNotifications" class="btn btn-primary">
                                <span x-show="!notifLoading">Simpan Pengaturan</span>
                                <span x-show="notifLoading" class="flex items-center gap-2">
                                    <div class="spinner w-4 h-4"></div>
                                    Menyimpan...
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Account Actions -->
                <div class="card border-error/20">
                    <div class="card-header bg-error/5">
                        <h3 class="font-semibold text-error flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            Danger Zone
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div>
                                <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Hapus Akun</h4>
                                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Tindakan ini tidak dapat dibatalkan. Semua data akan hilang.</p>
                            </div>
                            <button @click="confirmDeleteAccount" class="btn btn-danger">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Hapus Akun
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Delete Account Confirmation Modal -->
    <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div class="card w-full max-w-md mx-4" @click.stop>
            <div class="card-header bg-error/5">
                <h3 class="text-xl font-bold text-error">Konfirmasi Hapus Akun</h3>
            </div>
            <div class="card-body text-center">
                <div class="w-16 h-16 bg-error/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-error" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <h4 class="text-lg font-semibold text-text-primary dark:text-text-dark-primary mb-2">Yakin ingin menghapus akun?</h4>
                <p class="text-text-secondary dark:text-text-dark-secondary mb-4">
                    Semua data Anda akan dihapus permanen. Tindakan ini tidak dapat dibatalkan.
                </p>
                <div class="flex justify-center gap-3">
                    <button @click="showDeleteModal = false" class="btn btn-secondary">Batal</button>
                    <button @click="deleteAccount" class="btn btn-danger">Ya, Hapus Akun</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function settingsManager() {
    return {
        passwordForm: {
            current: '',
            new: '',
            confirm: ''
        },
        showCurrentPassword: false,
        showNewPassword: false,
        showConfirmPassword: false,
        notifications: {
            email: true,
            promotions: false,
            order_status: true,
            in_app: true
        },
        loading: false,
        notifLoading: false,
        showDeleteModal: false,
        
        get passwordStrength() {
            const pwd = this.passwordForm.new;
            if (!pwd) return 0;
            let score = 0;
            if (pwd.length >= 8) score += 25;
            if (pwd.match(/[a-z]/)) score += 25;
            if (pwd.match(/[A-Z]/)) score += 25;
            if (pwd.match(/[^a-zA-Z0-9]/) || pwd.match(/[0-9]/)) score += 25;
            return Math.min(100, score);
        },
        
        get passwordStrengthText() {
            const score = this.passwordStrength;
            if (score === 0) return 'Kosong';
            if (score < 30) return 'Lemah';
            if (score < 60) return 'Sedang';
            if (score < 80) return 'Kuat';
            return 'Sangat Kuat';
        },
        
        init() {
            // Initialize settings
        },
        
        async changePassword() {
            if (this.passwordForm.new !== this.passwordForm.confirm) {
                window.showToast('Password tidak cocok', 'error');
                return;
            }
            
            this.loading = true;
            await new Promise(resolve => setTimeout(resolve, 1500));
            this.loading = false;
            this.passwordForm = { current: '', new: '', confirm: '' };
            window.showToast('Password berhasil diubah!', 'success');
        },
        
        async saveNotifications() {
            this.notifLoading = true;
            await new Promise(resolve => setTimeout(resolve, 1000));
            this.notifLoading = false;
            window.showToast('Pengaturan notifikasi disimpan!', 'success');
        },
        
        confirmDeleteAccount() {
            this.showDeleteModal = true;
        },
        
        async deleteAccount() {
            this.showDeleteModal = false;
            window.showToast('Akun berhasil dihapus', 'info');
            setTimeout(() => {
                window.location.href = '/';
            }, 1500);
        }
    }
}
</script>
@endpush
@endsection