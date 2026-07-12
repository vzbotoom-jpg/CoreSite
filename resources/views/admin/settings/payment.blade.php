{{-- resources/views/admin/settings/payment.blade.php --}}
@extends('layouts.app')

@section('title', 'Pengaturan Pembayaran')
@section('page-title', 'Pengaturan Pembayaran')

@section('content')
<div class="max-w-3xl mx-auto" x-data="paymentSettings()" x-init="init()">
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Metode Pembayaran</h3>
            <p class="text-sm text-text-secondary dark:text-text-dark-secondary mt-1">Konfigurasi metode pembayaran yang diterima</p>
        </div>
        <div class="card-body">
            <form @submit.prevent="saveSettings">
                <!-- Payment Methods -->
                <div class="space-y-4">
                    <h4 class="font-medium text-text-primary dark:text-text-dark-primary">Metode Pembayaran</h4>
                    <div class="space-y-3">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" x-model="settings.payment_methods.cash" class="w-4 h-4 rounded border-gray-300 text-accent focus:ring-accent">
                            <span class="text-text-primary dark:text-text-dark-primary">Tunai</span>
                            <span class="text-xs text-text-secondary dark:text-text-dark-secondary ml-auto">Pembayaran langsung tunai</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" x-model="settings.payment_methods.transfer" class="w-4 h-4 rounded border-gray-300 text-accent focus:ring-accent">
                            <span class="text-text-primary dark:text-text-dark-primary">Transfer Bank</span>
                            <span class="text-xs text-text-secondary dark:text-text-dark-secondary ml-auto">Transfer antar bank</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" x-model="settings.payment_methods.qris" class="w-4 h-4 rounded border-gray-300 text-accent focus:ring-accent">
                            <span class="text-text-primary dark:text-text-dark-primary">QRIS</span>
                            <span class="text-xs text-text-secondary dark:text-text-dark-secondary ml-auto">Pembayaran via QR Code</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" x-model="settings.payment_methods.ewallet" class="w-4 h-4 rounded border-gray-300 text-accent focus:ring-accent">
                            <span class="text-text-primary dark:text-text-dark-primary">E-Wallet</span>
                            <span class="text-xs text-text-secondary dark:text-text-dark-secondary ml-auto">OVO, GoPay, DANA, dll</span>
                        </label>
                    </div>
                </div>
                
                <!-- Bank Accounts -->
                <div x-show="settings.payment_methods.transfer" class="mt-8 border-t border-light-border dark:border-dark-border pt-6">
                    <h4 class="font-medium text-text-primary dark:text-text-dark-primary mb-4">Rekening Bank</h4>
                    <template x-for="(bank, index) in settings.bank_accounts" :key="index">
                        <div class="flex gap-3 items-start mb-3">
                            <div class="flex-1 grid grid-cols-2 gap-3">
                                <select x-model="bank.bank_name" class="input">
                                    <option value="BCA">BCA</option>
                                    <option value="Mandiri">Mandiri</option>
                                    <option value="BNI">BNI</option>
                                    <option value="BRI">BRI</option>
                                    <option value="CIMB">CIMB Niaga</option>
                                    <option value="Danamon">Danamon</option>
                                    <option value="Permata">Permata</option>
                                    <option value="OCBC">OCBC NISP</option>
                                    <option value="BTN">BTN</option>
                                    <option value="Maybank">Maybank</option>
                                </select>
                                <input type="text" x-model="bank.account_number" placeholder="Nomor Rekening" class="input">
                            </div>
                            <button type="button" @click="removeBankAccount(index)" class="text-error hover:text-error/80 transition-colors p-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </template>
                    <button type="button" @click="addBankAccount" class="btn btn-secondary text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Rekening
                    </button>
                </div>
                
                <!-- QRIS -->
                <div x-show="settings.payment_methods.qris" class="mt-8 border-t border-light-border dark:border-dark-border pt-6">
                    <h4 class="font-medium text-text-primary dark:text-text-dark-primary mb-4">QRIS</h4>
                    <div class="border-2 border-dashed border-light-border dark:border-dark-border rounded-lg p-8 text-center hover:border-accent transition-colors">
                        <div class="mb-4">
                            <svg class="w-16 h-16 mx-auto text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <p class="text-text-secondary dark:text-text-dark-secondary mb-2">Upload gambar QRIS Anda</p>
                        <p class="text-xs text-text-secondary dark:text-text-dark-secondary mb-4">Format: JPG, PNG • Maks: 2MB</p>
                        <input type="file" @change="uploadQRIS" accept="image/*" class="hidden" ref="qrisInput">
                        <button type="button" @click="$refs.qrisInput.click()" class="btn btn-secondary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            Upload QRIS
                        </button>
                    </div>
                    <div x-show="settings.qris_image" class="mt-4">
                        <p class="text-sm text-text-secondary dark:text-text-dark-secondary mb-2">QRIS Saat Ini:</p>
                        <img :src="settings.qris_image" alt="QRIS" class="w-48 h-48 border rounded-lg object-contain">
                    </div>
                </div>
                
                <!-- E-Wallet -->
                <div x-show="settings.payment_methods.ewallet" class="mt-8 border-t border-light-border dark:border-dark-border pt-6">
                    <h4 class="font-medium text-text-primary dark:text-text-dark-primary mb-4">E-Wallet</h4>
                    <div class="space-y-3">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" x-model="settings.ewallet.ovo" class="w-4 h-4 rounded border-gray-300 text-accent focus:ring-accent">
                            <span class="text-text-primary dark:text-text-dark-primary">OVO</span>
                            <input type="text" x-model="settings.ewallet.ovo_number" placeholder="Nomor OVO" class="input ml-auto max-w-xs">
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" x-model="settings.ewallet.gopay" class="w-4 h-4 rounded border-gray-300 text-accent focus:ring-accent">
                            <span class="text-text-primary dark:text-text-dark-primary">GoPay</span>
                            <input type="text" x-model="settings.ewallet.gopay_number" placeholder="Nomor GoPay" class="input ml-auto max-w-xs">
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" x-model="settings.ewallet.dana" class="w-4 h-4 rounded border-gray-300 text-accent focus:ring-accent">
                            <span class="text-text-primary dark:text-text-dark-primary">DANA</span>
                            <input type="text" x-model="settings.ewallet.dana_number" placeholder="Nomor DANA" class="input ml-auto max-w-xs">
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" x-model="settings.ewallet.linkaja" class="w-4 h-4 rounded border-gray-300 text-accent focus:ring-accent">
                            <span class="text-text-primary dark:text-text-dark-primary">LinkAja</span>
                            <input type="text" x-model="settings.ewallet.linkaja_number" placeholder="Nomor LinkAja" class="input ml-auto max-w-xs">
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
function paymentSettings() {
    return {
        settings: {
            payment_methods: {
                cash: true,
                transfer: true,
                qris: true,
                ewallet: false
            },
            bank_accounts: [],
            qris_image: null,
            ewallet: {
                ovo: false,
                ovo_number: '',
                gopay: false,
                gopay_number: '',
                dana: false,
                dana_number: '',
                linkaja: false,
                linkaja_number: ''
            }
        },
        
        init() {
            this.loadSettings();
        },
        
        async loadSettings() {
            try {
                const response = await axios.get('/api/v1/admin/settings/payment');
                if (response.data.success) {
                    this.settings = response.data.data;
                }
            } catch (error) {
                console.error('Failed to load payment settings:', error);
            }
        },
        
        async saveSettings() {
            try {
                const response = await axios.post('/api/v1/admin/settings/payment', this.settings);
                if (response.data.success) {
                    window.showToast('Pengaturan pembayaran berhasil disimpan', 'success');
                }
            } catch (error) {
                window.showToast(error.response?.data?.message || 'Gagal menyimpan pengaturan', 'error');
            }
        },
        
        addBankAccount() {
            this.settings.bank_accounts.push({
                bank_name: 'BCA',
                account_number: ''
            });
        },
        
        removeBankAccount(index) {
            this.settings.bank_accounts.splice(index, 1);
        },
        
        async uploadQRIS(event) {
            const file = event.target.files[0];
            if (!file) return;
            
            const formData = new FormData();
            formData.append('qris', file);
            
            try {
                const response = await axios.post('/api/v1/admin/settings/qris', formData, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                });
                if (response.data.success) {
                    this.settings.qris_image = response.data.data.url;
                    window.showToast('QRIS berhasil diupload', 'success');
                }
            } catch (error) {
                window.showToast('Gagal upload QRIS', 'error');
            }
        }
    }
}
</script>
@endpush
@endsection