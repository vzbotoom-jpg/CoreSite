{{-- resources/views/developer/system.blade.php --}}
@extends('layouts.app')

@section('title', 'System Settings')
@section('page-title', 'System Settings')

@section('content')
<div x-data="systemSettings()" x-init="init()" class="space-y-6">
    <!-- System Info -->
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">System Information</h3>
        </div>
        <div class="card-body">
            <div class="grid md:grid-cols-2 gap-4">
                <div class="flex justify-between py-2 border-b border-light-border dark:border-dark-border">
                    <span class="text-text-secondary">Laravel Version</span>
                    <span class="font-medium text-text-primary dark:text-text-dark-primary">{{ $laravelVersion ?? app()->version() }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-light-border dark:border-dark-border">
                    <span class="text-text-secondary">PHP Version</span>
                    <span class="font-medium text-text-primary dark:text-text-dark-primary">{{ $phpVersion ?? phpversion() }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-light-border dark:border-dark-border">
                    <span class="text-text-secondary">Environment</span>
                    <span class="font-medium" :class="'{{ $environment ?? app()->environment() }}' === 'production' ? 'text-success' : 'text-warning'">
                        {{ $environment ?? app()->environment() }}
                    </span>
                </div>
                <div class="flex justify-between py-2 border-b border-light-border dark:border-dark-border">
                    <span class="text-text-secondary">Debug Mode</span>
                    <span class="font-medium" :class="'{{ $debug ?? config('app.debug') }}' ? 'text-error' : 'text-success'">
                        {{ $debug ?? config('app.debug') ? 'Enabled' : 'Disabled' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Cache Management -->
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Cache Management</h3>
        </div>
        <div class="card-body">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <button @click="clearCache('config')" class="btn btn-outline text-center py-3 hover:border-accent hover:text-accent transition">
                    <svg class="w-6 h-6 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    </svg>
                    <span class="text-sm">Config</span>
                </button>
                <button @click="clearCache('cache')" class="btn btn-outline text-center py-3 hover:border-accent hover:text-accent transition">
                    <svg class="w-6 h-6 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <span class="text-sm">Cache</span>
                </button>
                <button @click="clearCache('view')" class="btn btn-outline text-center py-3 hover:border-accent hover:text-accent transition">
                    <svg class="w-6 h-6 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <span class="text-sm">Views</span>
                </button>
                <button @click="clearCache('route')" class="btn btn-outline text-center py-3 hover:border-accent hover:text-accent transition">
                    <svg class="w-6 h-6 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    <span class="text-sm">Routes</span>
                </button>
                <button @click="clearCache('all')" class="col-span-2 btn-primary text-center py-3">
                    <svg class="w-5 h-5 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Clear All Caches
                </button>
            </div>
        </div>
    </div>

    <!-- Database Management -->
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Database Management</h3>
        </div>
        <div class="card-body">
            <div class="grid md:grid-cols-2 gap-4">
                <div class="border rounded-lg p-4">
                    <h4 class="font-medium text-text-primary dark:text-text-dark-primary mb-2">Run Migration</h4>
                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary mb-3">Jalankan migration untuk update struktur database</p>
                    <button @click="runMigration" class="btn btn-warning w-full">Run Migration</button>
                </div>
                <div class="border rounded-lg p-4">
                    <h4 class="font-medium text-text-primary dark:text-text-dark-primary mb-2">Run Seeder</h4>
                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary mb-3">Isi database dengan data dummy</p>
                    <div class="flex gap-2">
                        <input type="text" x-model="seederClass" placeholder="Seeder Class" class="input flex-1">
                        <button @click="runSeeder" class="btn btn-primary">Run</button>
                    </div>
                    <p class="text-xs text-text-secondary mt-2">Contoh: DatabaseSeeder, StoreSeeder, ProductSeeder</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Optimization -->
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Optimization</h3>
        </div>
        <div class="card-body">
            <div class="grid md:grid-cols-2 gap-4">
                <button @click="optimizeApp" class="btn btn-outline text-center py-4 hover:border-accent hover:text-accent transition">
                    <svg class="w-6 h-6 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <span class="font-medium">Optimize Application</span>
                    <p class="text-xs text-text-secondary mt-1">Optimize for production</p>
                </button>
                <button @click="clearLogs" class="btn btn-outline text-center py-4 hover:border-error hover:text-error transition">
                    <svg class="w-6 h-6 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    <span class="font-medium">Clear Logs</span>
                    <p class="text-xs text-text-secondary mt-1">Clear all log files</p>
                </button>
            </div>
        </div>
    </div>

    <!-- Danger Zone -->
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
            <div class="grid md:grid-cols-2 gap-4">
                <div class="border border-error/20 rounded-lg p-4">
                    <h4 class="font-medium text-error mb-2">Reset Database</h4>
                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary mb-3">Hapus semua data dan migration ulang</p>
                    <button @click="resetDatabase" class="btn btn-danger w-full">Reset Database</button>
                </div>
                <div class="border border-error/20 rounded-lg p-4">
                    <h4 class="font-medium text-error mb-2">Clear All Data</h4>
                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary mb-3">Hapus semua data dari semua tabel</p>
                    <button @click="clearAllData" class="btn btn-danger w-full">Clear All Data</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function systemSettings() {
    return {
        seederClass: 'DatabaseSeeder',
        loading: false,

        init() {
            // Initialize
        },

        async clearCache(type) {
            try {
                const response = await axios.post('/api/developer/cache/clear', { type });
                if (response.data.success) {
                    window.showToast(response.data.message || 'Cache cleared successfully', 'success');
                }
            } catch (error) {
                window.showToast('Failed to clear cache', 'error');
            }
        },

        async runMigration() {
            if (!confirm('Jalankan migration? Pastikan database sudah di-backup.')) return;
            
            this.loading = true;
            try {
                const response = await axios.post('/api/developer/migrate');
                if (response.data.success) {
                    window.showToast('Migration berhasil dijalankan', 'success');
                    if (response.data.output) {
                        console.log(response.data.output);
                    }
                }
            } catch (error) {
                window.showToast('Migration gagal: ' + (error.response?.data?.message || error.message), 'error');
            }
            this.loading = false;
        },

        async runSeeder() {
            if (!this.seederClass) {
                window.showToast('Masukkan nama seeder class', 'warning');
                return;
            }
            if (!confirm(`Jalankan seeder "${this.seederClass}"?`)) return;

            this.loading = true;
            try {
                const response = await axios.post('/api/developer/seed', { seeder: this.seederClass });
                if (response.data.success) {
                    window.showToast(`Seeder ${this.seederClass} berhasil dijalankan`, 'success');
                }
            } catch (error) {
                window.showToast('Seeder gagal: ' + (error.response?.data?.message || error.message), 'error');
            }
            this.loading = false;
        },

        async optimizeApp() {
            try {
                const response = await axios.post('/api/developer/optimize');
                if (response.data.success) {
                    window.showToast('Application optimized successfully', 'success');
                }
            } catch (error) {
                window.showToast('Optimization failed', 'error');
            }
        },

        async clearLogs() {
            if (!confirm('Hapus semua log files?')) return;
            
            try {
                const response = await axios.delete('/api/developer/logs');
                if (response.data.success) {
                    window.showToast('Logs cleared successfully', 'success');
                }
            } catch (error) {
                window.showToast('Failed to clear logs', 'error');
            }
        },

        async resetDatabase() {
            if (!confirm('⚠️ RESET DATABASE: Semua data akan hilang! Lanjutkan?')) return;
            if (!confirm('Konfirmasi akhir: Yakin ingin mereset database?')) return;

            window.showToast('Fitur ini akan segera tersedia', 'info');
        },

        async clearAllData() {
            if (!confirm('⚠️ CLEAR ALL DATA: Semua data akan dihapus! Lanjutkan?')) return;
            if (!confirm('Konfirmasi akhir: Yakin ingin menghapus semua data?')) return;

            window.showToast('Fitur ini akan segera tersedia', 'info');
        }
    }
}
</script>
@endpush
@endsection