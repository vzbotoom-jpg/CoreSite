{{-- resources/views/admin/settings/partials/preference-form.blade.php --}}
<div x-data="preferenceSettings()" x-init="init()" class="max-w-2xl mx-auto">
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold">Preferensi Toko</h3>
        </div>
        <div class="card-body">
            <form @submit.prevent="savePreferences">
                <div class="space-y-6">
                    <!-- Currency -->
                    <div>
                        <label class="block text-sm font-medium mb-2">Mata Uang</label>
                        <select x-model="preferences.currency" class="input">
                            <option value="IDR">Indonesian Rupiah (IDR)</option>
                            <option value="USD">US Dollar (USD)</option>
                        </select>
                    </div>
                    
                    <!-- Timezone -->
                    <div>
                        <label class="block text-sm font-medium mb-2">Zona Waktu</label>
                        <select x-model="preferences.timezone" class="input">
                            <option value="Asia/Jakarta">Asia/Jakarta (WIB)</option>
                            <option value="Asia/Makassar">Asia/Makassar (WITA)</option>
                            <option value="Asia/Jayapura">Asia/Jayapura (WIT)</option>
                        </select>
                    </div>
                    
                    <!-- Date Format -->
                    <div>
                        <label class="block text-sm font-medium mb-2">Format Tanggal</label>
                        <select x-model="preferences.date_format" class="input">
                            <option value="d-m-Y">DD-MM-YYYY</option>
                            <option value="m-d-Y">MM-DD-YYYY</option>
                            <option value="Y-m-d">YYYY-MM-DD</option>
                        </select>
                    </div>
                    
                    <!-- Invoice Prefix -->
                    <div>
                        <label class="block text-sm font-medium mb-2">Prefix Invoice</label>
                        <input type="text" x-model="preferences.invoice_prefix" class="input" placeholder="INV">
                        <p class="text-xs text-text-secondary mt-1">Contoh: INV/TOKO/20240101/0001</p>
                    </div>
                    
                    <!-- Notifications -->
                    <div class="border-t pt-4">
                        <h4 class="font-semibold mb-3">Notifikasi</h4>
                        <div class="space-y-3">
                            <label class="flex items-center justify-between">
                                <div>
                                    <span class="font-medium">Notifikasi Stok Menipis</span>
                                    <p class="text-xs text-text-secondary">Dikirim saat stok mencapai minimal</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" x-model="preferences.low_stock_alert" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-accent"></div>
                                </label>
                            </label>
                            
                            <label class="flex items-center justify-between">
                                <div>
                                    <span class="font-medium">Laporan Bulanan via Email</span>
                                    <p class="text-xs text-text-secondary">Dikirim setiap awal bulan</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" x-model="preferences.monthly_report" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-accent"></div>
                                </label>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Theme -->
                    <div class="border-t pt-4">
                        <h4 class="font-semibold mb-3">Tampilan</h4>
                        <div class="flex gap-4">
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" x-model="preferences.theme" value="light" class="hidden peer">
                                <div class="border rounded-lg p-4 text-center peer-checked:border-accent peer-checked:bg-accent/5">
                                    <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                    <span>Light</span>
                                </div>
                            </label>
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" x-model="preferences.theme" value="dark" class="hidden peer">
                                <div class="border rounded-lg p-4 text-center peer-checked:border-accent peer-checked:bg-accent/5">
                                    <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                                    </svg>
                                    <span>Dark</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end gap-3 mt-6 pt-4 border-t">
                    <button type="submit" class="btn btn-primary">Simpan Preferensi</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function preferenceSettings() {
    return {
        preferences: {
            currency: 'IDR',
            timezone: 'Asia/Jakarta',
            date_format: 'd-m-Y',
            invoice_prefix: 'INV',
            low_stock_alert: true,
            monthly_report: true,
            theme: 'light'
        },
        
        init() {
            this.loadPreferences();
        },
        
        async loadPreferences() {
            try {
                const response = await axios.get('/api/v1/admin/settings/preferences');
                if (response.data.success) {
                    this.preferences = response.data.data;
                    // Apply theme
                    if (this.preferences.theme === 'dark') {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                }
            } catch (error) {
                console.error('Failed to load preferences:', error);
            }
        },
        
        async savePreferences() {
            try {
                const response = await axios.post('/api/v1/admin/settings/preferences', this.preferences);
                if (response.data.success) {
                    window.showToast('Preferensi berhasil disimpan', 'success');
                    // Reload page to apply theme
                    if (this.preferences.theme === 'dark') {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                    localStorage.setItem('theme', this.preferences.theme);
                }
            } catch (error) {
                window.showToast('Gagal menyimpan preferensi', 'error');
            }
        }
    }
}
</script>
@endpush