{{-- resources/views/admin/settings/partials/store-form.blade.php --}}
<div x-data="storeSettings()" x-init="init()" class="max-w-2xl mx-auto">
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold">Informasi Toko</h3>
        </div>
        <div class="card-body">
            <form @submit.prevent="saveStore">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Nama Toko</label>
                        <input type="text" x-model="store.name" required class="input">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-2">Slug URL</label>
                        <div class="flex items-center gap-2">
                            <span class="text-text-secondary">coresite.com/</span>
                            <input type="text" x-model="store.slug" required class="input flex-1">
                        </div>
                        <p class="text-xs text-text-secondary mt-1">URL unik untuk toko Anda</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-2">Email Toko</label>
                        <input type="email" x-model="store.email" required class="input">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-2">Nomor Telepon</label>
                        <input type="tel" x-model="store.phone" class="input">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-2">Logo Toko</label>
                        <div class="flex items-center gap-4">
                            <div class="w-20 h-20 bg-light-surface dark:bg-dark-surface rounded-lg flex items-center justify-center overflow-hidden">
                                <img :src="store.logo_url || '/default-logo.png'" alt="Logo" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <input type="file" @change="uploadLogo" accept="image/*" class="hidden" ref="logoInput">
                                <button type="button" @click="$refs.logoInput.click()" class="btn btn-secondary text-sm">
                                    Ganti Logo
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="border-t pt-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-semibold">Status Toko</h4>
                                <p class="text-sm text-text-secondary">Aktifkan atau nonaktifkan toko Anda</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" x-model="store.is_active" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:bg-accent"></div>
                                <span class="ml-3 text-sm font-medium" x-text="store.is_active ? 'Aktif' : 'Nonaktif'"></span>
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end gap-3 mt-6 pt-4 border-t">
                    <button type="button" @click="resetForm" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Danger Zone -->
    <div class="card border-error/20 mt-6">
        <div class="card-header bg-error/5">
            <h3 class="font-semibold text-error">Danger Zone</h3>
        </div>
        <div class="card-body">
            <div class="flex justify-between items-center">
                <div>
                    <h4 class="font-semibold">Hapus Toko</h4>
                    <p class="text-sm text-text-secondary">Tindakan ini tidak dapat dibatalkan</p>
                </div>
                <button @click="confirmDeleteStore" class="btn btn-danger">
                    Hapus Toko
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function storeSettings() {
    return {
        store: @json($store ?? []),
        loading: false,
        
        init() {
            // Initialize store data
        },
        
        async saveStore() {
            this.loading = true;
            try {
                const response = await axios.put('/api/v1/admin/store', this.store);
                if (response.data.success) {
                    window.showToast('Informasi toko berhasil disimpan', 'success');
                }
            } catch (error) {
                window.showToast(error.response?.data?.message || 'Gagal menyimpan', 'error');
            }
            this.loading = false;
        },
        
        async uploadLogo(event) {
            const file = event.target.files[0];
            if (!file) return;
            
            const formData = new FormData();
            formData.append('logo', file);
            
            try {
                const response = await axios.post('/api/v1/admin/store/logo', formData, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                });
                if (response.data.success) {
                    this.store.logo_url = response.data.data.logo_url;
                    window.showToast('Logo berhasil diupload', 'success');
                }
            } catch (error) {
                window.showToast('Gagal upload logo', 'error');
            }
        },
        
        resetForm() {
            this.store = @json($store ?? []);
        },
        
        confirmDeleteStore() {
            if (confirm('Yakin ingin menghapus toko? Semua data akan hilang permanen.')) {
                window.showToast('Fitur ini akan segera tersedia', 'info');
            }
        }
    }
}
</script>
@endpush