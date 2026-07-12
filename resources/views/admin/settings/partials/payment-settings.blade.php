{{-- resources/views/admin/settings/partials/payment-settings.blade.php --}}
<div x-data="paymentSettings()" x-init="init()" class="max-w-2xl mx-auto">
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold">Pengaturan Pembayaran</h3>
        </div>
        <div class="card-body">
            <form @submit.prevent="saveSettings">
                <div class="space-y-6">
                    <!-- Payment Methods -->
                    <div>
                        <h4 class="font-semibold mb-3">Metode Pembayaran</h4>
                        <div class="space-y-2">
                            <label class="flex items-center gap-3">
                                <input type="checkbox" x-model="settings.payment_methods.cash" class="w-4 h-4 rounded">
                                <span>Tunai</span>
                            </label>
                            <label class="flex items-center gap-3">
                                <input type="checkbox" x-model="settings.payment_methods.transfer" class="w-4 h-4 rounded">
                                <span>Transfer Bank</span>
                            </label>
                            <label class="flex items-center gap-3">
                                <input type="checkbox" x-model="settings.payment_methods.qris" class="w-4 h-4 rounded">
                                <span>QRIS</span>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Bank Accounts -->
                    <div x-show="settings.payment_methods.transfer">
                        <h4 class="font-semibold mb-3">Rekening Bank</h4>
                        <div class="space-y-3">
                            <template x-for="(bank, index) in settings.bank_accounts" :key="index">
                                <div class="flex gap-2 items-start">
                                    <div class="flex-1 grid grid-cols-2 gap-2">
                                        <select x-model="bank.bank_name" class="input">
                                            <option value="BCA">BCA</option>
                                            <option value="Mandiri">Mandiri</option>
                                            <option value="BNI">BNI</option>
                                            <option value="BRI">BRI</option>
                                            <option value="CIMB">CIMB Niaga</option>
                                            <option value="Danamon">Danamon</option>
                                            <option value="Permata">Permata</option>
                                        </select>
                                        <input type="text" x-model="bank.account_number" placeholder="Nomor Rekening" class="input">
                                    </div>
                                    <button type="button" @click="removeBankAccount(index)" class="text-error">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </template>
                            <button type="button" @click="addBankAccount" class="btn btn-outline text-sm">
                                + Tambah Rekening
                            </button>
                        </div>
                    </div>
                    
                    <!-- QRIS Settings -->
                    <div x-show="settings.payment_methods.qris">
                        <h4 class="font-semibold mb-3">QRIS</h4>
                        <div class="border-2 border-dashed rounded-lg p-6 text-center">
                            <div class="mb-4">
                                <svg class="w-12 h-12 mx-auto text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <p class="text-sm text-text-secondary mb-4">Upload gambar QRIS Anda</p>
                            <input type="file" @change="uploadQRIS" accept="image/*" class="hidden" ref="qrisInput">
                            <button type="button" @click="$refs.qrisInput.click()" class="btn btn-secondary text-sm">
                                Upload QRIS
                            </button>
                            <div x-show="settings.qris_image" class="mt-4">
                                <img :src="settings.qris_image" alt="QRIS" class="w-40 h-40 mx-auto border rounded-lg">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end gap-3 mt-6 pt-4 border-t">
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
                qris: true
            },
            bank_accounts: [],
            qris_image: null
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
                window.showToast('Gagal menyimpan pengaturan', 'error');
            }
        },
        
        addBankAccount() {
            this.settings.bank_accounts.push({
                bank_name: 'BCA',
                account_number: '',
                account_name: ''
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