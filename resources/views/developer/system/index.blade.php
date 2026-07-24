{{-- resources/views/developer/system/index.blade.php --}}
@extends('layouts.developer')

@section('title', 'System Settings')
@section('page-title', 'System Settings')

@section('content')
<div x-data="systemSettings()" x-init="init()" class="space-y-6">
    <!-- Header -->
    <div class="flex flex-wrap justify-between items-center gap-4">
        <div>
            <p class="text-text-secondary dark:text-text-dark-secondary">Kelola pengaturan sistem dan performa aplikasi</p>
        </div>
        <div class="flex gap-3">
            <button @click="checkUpdates" class="btn btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Check Updates
            </button>
            <a href="{{ route('developer.system.info') }}" class="btn btn-outline">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                System Info
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="card">
            <div class="card-body py-3">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-text-secondary">PHP Version</p>
                        <p class="text-lg font-bold text-text-primary dark:text-text-dark-primary" x-text="system.php_version"></p>
                    </div>
                    <span :class="system.php_version >= '8.0' ? 'badge-success' : 'badge-warning'" class="badge">
                        <span x-text="system.php_version >= '8.0' ? '✅' : '⚠️'"></span>
                    </span>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body py-3">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-text-secondary">Laravel</p>
                        <p class="text-lg font-bold text-text-primary dark:text-text-dark-primary" x-text="system.laravel_version"></p>
                    </div>
                    <span class="badge badge-primary">{{ $laravelVersion ?? app()->version() }}</span>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body py-3">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-text-secondary">Environment</p>
                        <p class="text-lg font-bold" :class="system.environment === 'production' ? 'text-success' : 'text-warning'" x-text="system.environment"></p>
                    </div>
                    <span :class="system.environment === 'production' ? 'badge-success' : 'badge-warning'" class="badge">
                        <span x-text="system.environment === 'production' ? '🟢' : '🟡'"></span>
                    </span>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body py-3">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-text-secondary">Debug Mode</p>
                        <p class="text-lg font-bold" :class="system.debug ? 'text-error' : 'text-success'" x-text="system.debug ? 'Enabled' : 'Disabled'"></p>
                    </div>
                    <span :class="system.debug ? 'badge-error' : 'badge-success'" class="badge">
                        <span x-text="system.debug ? '🔴' : '🟢'"></span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- System Health -->
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">System Health</h3>
        </div>
        <div class="card-body">
            <div class="grid md:grid-cols-2 gap-4">
                <div class="border rounded-lg p-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm text-text-secondary">Database Connection</span>
                        <span :class="system.db_connected ? 'text-success' : 'text-error'" class="font-medium">
                            <span x-text="system.db_connected ? '✅ Connected' : '❌ Disconnected'"></span>
                        </span>
                    </div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm text-text-secondary">Database Name</span>
                        <span class="text-sm font-medium text-text-primary dark:text-text-dark-primary" x-text="system.db_name || '-'"></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-text-secondary">Database Size</span>
                        <span class="text-sm font-medium text-text-primary dark:text-text-dark-primary" x-text="system.db_size || '-'"></span>
                    </div>
                </div>
                <div class="border rounded-lg p-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm text-text-secondary">Cache Driver</span>
                        <span class="text-sm font-medium text-text-primary dark:text-text-dark-primary" x-text="system.cache_driver || 'file'"></span>
                    </div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm text-text-secondary">Session Driver</span>
                        <span class="text-sm font-medium text-text-primary dark:text-text-dark-primary" x-text="system.session_driver || 'file'"></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-text-secondary">Queue Driver</span>
                        <span class="text-sm font-medium text-text-primary dark:text-text-dark-primary" x-text="system.queue_driver || 'sync'"></span>
                    </div>
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
                    <span class="font-medium">Clear All Caches</span>
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
                    <h4 class="font-medium text-text-primary dark:text-text-dark-primary mb-2">Migration</h4>
                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary mb-3">Jalankan migration untuk update struktur database</p>
                    <button @click="runMigration" class="btn btn-warning w-full" :disabled="loading">
                        <span x-show="!loading">Run Migration</span>
                        <span x-show="loading" class="flex items-center justify-center gap-2">
                            <div class="spinner w-4 h-4"></div>
                            Running...
                        </span>
                    </button>
                </div>
                <div class="border rounded-lg p-4">
                    <h4 class="font-medium text-text-primary dark:text-text-dark-primary mb-2">Rollback Migration</h4>
                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary mb-3">Rollback migration terakhir</p>
                    <button @click="rollbackMigration" class="btn btn-secondary w-full" :disabled="loading">
                        <span x-show="!loading">Rollback</span>
                        <span x-show="loading" class="flex items-center justify-center gap-2">
                            <div class="spinner w-4 h-4"></div>
                            Rolling back...
                        </span>
                    </button>
                </div>
                <div class="border rounded-lg p-4">
                    <h4 class="font-medium text-text-primary dark:text-text-dark-primary mb-2">Run Seeder</h4>
                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary mb-3">Isi database dengan data dummy</p>
                    <div class="flex gap-2">
                        <input type="text" x-model="seederClass" placeholder="Seeder Class" class="input flex-1">
                        <button @click="runSeeder" class="btn btn-primary" :disabled="loading">
                            <span x-show="!loading">Run</span>
                            <span x-show="loading" class="flex items-center gap-2">
                                <div class="spinner w-4 h-4"></div>
                            </span>
                        </button>
                    </div>
                    <p class="text-xs text-text-secondary mt-2">Contoh: DatabaseSeeder, StoreSeeder</p>
                </div>
                <div class="border rounded-lg p-4">
                    <h4 class="font-medium text-text-primary dark:text-text-dark-primary mb-2">Refresh Database</h4>
                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary mb-3">Reset dan migrate ulang database</p>
                    <button @click="refreshDatabase" class="btn btn-danger w-full" :disabled="loading">
                        <span x-show="!loading">Refresh Database</span>
                        <span x-show="loading" class="flex items-center justify-center gap-2">
                            <div class="spinner w-4 h-4"></div>
                            Refreshing...
                        </span>
                    </button>
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
            <div class="grid md:grid-cols-3 gap-4">
                <button @click="optimizeApp" class="btn btn-outline text-center py-4 hover:border-accent hover:text-accent transition">
                    <svg class="w-6 h-6 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <span class="font-medium">Optimize</span>
                    <p class="text-xs text-text-secondary mt-1">Optimize for production</p>
                </button>
                <button @click="clearOptimized" class="btn btn-outline text-center py-4 hover:border-error hover:text-error transition">
                    <svg class="w-6 h-6 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    <span class="font-medium">Clear Optimized</span>
                    <p class="text-xs text-text-secondary mt-1">Clear optimized files</p>
                </button>
                <button @click="clearLogs" class="btn btn-outline text-center py-4 hover:border-error hover:text-error transition">
                    <svg class="w-6 h-6 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <span class="font-medium">Clear Logs</span>
                    <p class="text-xs text-text-secondary mt-1">Clear all log files</p>
                </button>
            </div>
        </div>
    </div>

    <!-- Maintenance Mode -->
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Maintenance Mode</h3>
        </div>
        <div class="card-body">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-text-secondary dark:text-text-dark-secondary">
                        Status: 
                        <span :class="system.maintenance ? 'text-error' : 'text-success'" class="font-medium">
                            <span x-text="system.maintenance ? '🔴 Maintenance Mode Active' : '🟢 Normal Operation'"></span>
                        </span>
                    </p>
                    <p class="text-xs text-text-secondary mt-1">When enabled, only developers can access the site</p>
                </div>
                <div class="flex gap-3">
                    <button @click="enableMaintenance" class="btn btn-danger" x-show="!system.maintenance">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        Enable Maintenance
                    </button>
                    <button @click="disableMaintenance" class="btn btn-success" x-show="system.maintenance">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Disable Maintenance
                    </button>
                </div>
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
                    <button @click="resetDatabase" class="btn btn-danger w-full" :disabled="loading">
                        Reset Database
                    </button>
                </div>
                <div class="border border-error/20 rounded-lg p-4">
                    <h4 class="font-medium text-error mb-2">Clear Application</h4>
                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary mb-3">Clear all caches, logs, and optimized files</p>
                    <button @click="clearApplication" class="btn btn-danger w-full" :disabled="loading">
                        Clear Application
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Output -->
    <div x-show="output" class="card bg-dark-bg text-white">
        <div class="card-body">
            <pre class="text-sm overflow-x-auto" x-text="output"></pre>
        </div>
    </div>
</div>

@push('scripts')
<script>
function systemSettings() {
    return {
        system: {
            php_version: '{{ phpversion() }}',
            laravel_version: '{{ app()->version() }}',
            environment: '{{ app()->environment() }}',
            debug: '{{ config('app.debug') }}' === '1',
            db_connected: true,
            db_name: '{{ config('database.connections.mysql.database') }}',
            db_size: '-',
            cache_driver: '{{ config('cache.default') }}',
            session_driver: '{{ config('session.driver') }}',
            queue_driver: '{{ config('queue.default') }}',
            maintenance: false
        },
        seederClass: 'DatabaseSeeder',
        loading: false,
        output: '',

        init() {
            this.checkSystemHealth();
            this.checkMaintenanceStatus();
        },

        async checkSystemHealth() {
            try {
                const response = await axios.get('/api/developer/system/health');
                if (response.data.success) {
                    Object.assign(this.system, response.data.data);
                }
            } catch (error) {
                console.error('Failed to check system health:', error);
            }
        },

        async checkMaintenanceStatus() {
            try {
                const response = await axios.get('/api/developer/maintenance/status');
                if (response.data.success) {
                    this.system.maintenance = response.data.data.enabled;
                }
            } catch (error) {
                console.error('Failed to check maintenance status:', error);
            }
        },

        async clearCache(type) {
            try {
                const response = await axios.post('/api/developer/cache/clear', { type });
                if (response.data.success) {
                    this.output = response.data.output || response.data.message;
                    window.showToast(response.data.message || 'Cache cleared successfully', 'success');
                }
            } catch (error) {
                window.showToast('Failed to clear cache', 'error');
                this.output = error.response?.data?.message || error.message;
            }
        },

        async runMigration() {
            if (!confirm('Jalankan migration? Pastikan database sudah di-backup.')) return;
            
            this.loading = true;
            try {
                const response = await axios.post('/developer/system/database/migrate');
                if (response.data.success) {
                    this.output = response.data.output || response.data.message;
                    window.showToast('Migration berhasil dijalankan', 'success');
                }
            } catch (error) {
                window.showToast('Migration gagal', 'error');
                this.output = error.response?.data?.message || error.message;
            }
            this.loading = false;
        },

        async rollbackMigration() {
            if (!confirm('Rollback migration terakhir?')) return;
            
            this.loading = true;
            try {
                const response = await axios.post('/api/developer/migrate/rollback');
                if (response.data.success) {
                    this.output = response.data.output || response.data.message;
                    window.showToast('Rollback berhasil', 'success');
                }
            } catch (error) {
                window.showToast('Rollback gagal', 'error');
                this.output = error.response?.data?.message || error.message;
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
                const response = await axios.post('/developer/system/database/seed', { seeder: this.seederClass });
                if (response.data.success) {
                    this.output = response.data.output || response.data.message;
                    window.showToast(`Seeder ${this.seederClass} berhasil dijalankan`, 'success');
                }
            } catch (error) {
                window.showToast('Seeder gagal', 'error');
                this.output = error.response?.data?.message || error.message;
            }
            this.loading = false;
        },

        async refreshDatabase() {
            if (!confirm('⚠️ REFRESH DATABASE: Semua data akan di-reset! Lanjutkan?')) return;
            if (!confirm('Konfirmasi akhir: Yakin ingin refresh database?')) return;

            this.loading = true;
            try {
                const response = await axios.post('/developer/system/database/refresh');
                if (response.data.success) {
                    this.output = response.data.output || response.data.message;
                    window.showToast('Database berhasil di-refresh', 'success');
                }
            } catch (error) {
                window.showToast('Refresh database gagal', 'error');
                this.output = error.response?.data?.message || error.message;
            }
            this.loading = false;
        },

        async optimizeApp() {
            try {
                const response = await axios.post('/developer/system/optimize');
                if (response.data.success) {
                    this.output = response.data.output || response.data.message;
                    window.showToast('Application optimized successfully', 'success');
                }
            } catch (error) {
                window.showToast('Optimization failed', 'error');
                this.output = error.response?.data?.message || error.message;
            }
        },

        async clearOptimized() {
            try {
                const response = await axios.post('/developer/system/optimize/clear');
                if (response.data.success) {
                    this.output = response.data.output || response.data.message;
                    window.showToast('Optimized files cleared', 'success');
                }
            } catch (error) {
                window.showToast('Failed to clear optimized files', 'error');
                this.output = error.response?.data?.message || error.message;
            }
        },

        async clearLogs() {
            if (!confirm('Hapus semua log files?')) return;
            
            try {
                const response = await axios.delete('/developer/logs');
                if (response.data.success) {
                    window.showToast('Logs cleared successfully', 'success');
                }
            } catch (error) {
                window.showToast('Failed to clear logs', 'error');
            }
        },

        async enableMaintenance() {
            if (!confirm('Enable maintenance mode? Only developers can access the site.')) return;
            
            try {
                const response = await axios.post('/developer/maintenance/enable');
                if (response.data.success) {
                    this.system.maintenance = true;
                    window.showToast('Maintenance mode enabled', 'success');
                }
            } catch (error) {
                window.showToast('Failed to enable maintenance mode', 'error');
            }
        },

        async disableMaintenance() {
            if (!confirm('Disable maintenance mode?')) return;
            
            try {
                const response = await axios.post('/developer/maintenance/disable');
                if (response.data.success) {
                    this.system.maintenance = false;
                    window.showToast('Maintenance mode disabled', 'success');
                }
            } catch (error) {
                window.showToast('Failed to disable maintenance mode', 'error');
            }
        },

        async resetDatabase() {
            if (!confirm('⚠️ RESET DATABASE: Semua data akan hilang! Lanjutkan?')) return;
            if (!confirm('Konfirmasi akhir: Yakin ingin mereset database?')) return;

            this.loading = true;
            try {
                const response = await axios.post('/developer/system/database/reset');
                if (response.data.success) {
                    this.output = response.data.output || response.data.message;
                    window.showToast('Database berhasil di-reset', 'success');
                }
            } catch (error) {
                window.showToast('Reset database gagal', 'error');
                this.output = error.response?.data?.message || error.message;
            }
            this.loading = false;
        },

        async clearApplication() {
            if (!confirm('Clear all application data? This will clear all caches, logs, and optimized files.')) return;

            this.loading = true;
            try {
                const response = await axios.post('/developer/system/clear');
                if (response.data.success) {
                    this.output = response.data.output || response.data.message;
                    window.showToast('Application cleared successfully', 'success');
                }
            } catch (error) {
                window.showToast('Failed to clear application', 'error');
                this.output = error.response?.data?.message || error.message;
            }
            this.loading = false;
        },

        checkUpdates() {
            window.showToast('Fitur check updates akan segera tersedia', 'info');
        }
    }
}
</script>
@endpush
@endsection