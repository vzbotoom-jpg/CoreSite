{{-- resources/views/developer/system/cache.blade.php --}}
@extends('layouts.developer')

@section('title', 'Cache Management')
@section('page-title', 'Cache Management')

@section('content')
<div x-data="cacheManagement()" x-init="init()" class="space-y-6">
    <!-- Header -->
    <div class="flex flex-wrap justify-between items-center gap-4">
        <div>
            <p class="text-text-secondary dark:text-text-dark-secondary">Kelola cache aplikasi untuk meningkatkan performa</p>
        </div>
        <a href="{{ route('developer.system.index') }}" class="btn btn-outline text-sm">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Cache Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="card">
            <div class="card-body py-3">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-text-secondary">Cache Driver</p>
                        <p class="text-lg font-bold text-text-primary dark:text-text-dark-primary" x-text="stats.driver"></p>
                    </div>
                    <div class="w-10 h-10 bg-info/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-info" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body py-3">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-text-secondary">Cache Size</p>
                        <p class="text-lg font-bold text-text-primary dark:text-text-dark-primary" x-text="stats.size"></p>
                    </div>
                    <div class="w-10 h-10 bg-warning/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body py-3">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-text-secondary">Cache Items</p>
                        <p class="text-lg font-bold text-text-primary dark:text-text-dark-primary" x-text="stats.items"></p>
                    </div>
                    <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body py-3">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-text-secondary">Cache Hits</p>
                        <p class="text-lg font-bold text-success" x-text="stats.hits"></p>
                    </div>
                    <div class="w-10 h-10 bg-success/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cache Operations -->
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Cache Operations</h3>
        </div>
        <div class="card-body">
            <div class="grid md:grid-cols-2 gap-4">
                <div class="border rounded-lg p-4">
                    <h4 class="font-medium text-text-primary dark:text-text-dark-primary mb-2">Clear Cache</h4>
                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary mb-3">Hapus semua cache application</p>
                    <button @click="clearCache" class="btn btn-warning w-full">
                        <span x-show="!loading">Clear Cache</span>
                        <span x-show="loading" class="flex items-center justify-center gap-2">
                            <div class="spinner w-4 h-4"></div>
                            Clearing...
                        </span>
                    </button>
                </div>
                <div class="border rounded-lg p-4">
                    <h4 class="font-medium text-text-primary dark:text-text-dark-primary mb-2">Clear Config</h4>
                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary mb-3">Hapus cache konfigurasi</p>
                    <button @click="clearConfig" class="btn btn-secondary w-full">
                        <span x-show="!loading">Clear Config</span>
                        <span x-show="loading" class="flex items-center justify-center gap-2">
                            <div class="spinner w-4 h-4"></div>
                            Clearing...
                        </span>
                    </button>
                </div>
                <div class="border rounded-lg p-4">
                    <h4 class="font-medium text-text-primary dark:text-text-dark-primary mb-2">Clear Views</h4>
                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary mb-3">Hapus cache view (blade)</p>
                    <button @click="clearViews" class="btn btn-secondary w-full">
                        <span x-show="!loading">Clear Views</span>
                        <span x-show="loading" class="flex items-center justify-center gap-2">
                            <div class="spinner w-4 h-4"></div>
                            Clearing...
                        </span>
                    </button>
                </div>
                <div class="border rounded-lg p-4">
                    <h4 class="font-medium text-text-primary dark:text-text-dark-primary mb-2">Clear Routes</h4>
                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary mb-3">Hapus cache route</p>
                    <button @click="clearRoutes" class="btn btn-secondary w-full">
                        <span x-show="!loading">Clear Routes</span>
                        <span x-show="loading" class="flex items-center justify-center gap-2">
                            <div class="spinner w-4 h-4"></div>
                            Clearing...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Cache Warmup -->
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Cache Warmup</h3>
        </div>
        <div class="card-body">
            <p class="text-sm text-text-secondary dark:text-text-dark-secondary mb-4">Warmup cache untuk meningkatkan performa aplikasi</p>
            <div class="grid md:grid-cols-2 gap-4">
                <button @click="warmupCache" class="btn btn-primary w-full">
                    <span x-show="!loading">Warmup Cache</span>
                    <span x-show="loading" class="flex items-center justify-center gap-2">
                        <div class="spinner w-4 h-4"></div>
                        Warming up...
                    </span>
                </button>
                <button @click="clearAll" class="btn btn-danger w-full">
                    <span x-show="!loading">Clear All Cache</span>
                    <span x-show="loading" class="flex items-center justify-center gap-2">
                        <div class="spinner w-4 h-4"></div>
                        Clearing...
                    </span>
                </button>
            </div>
        </div>
    </div>

    <!-- Output -->
    <div x-show="output" class="card bg-dark-bg text-white">
        <div class="card-body">
            <pre class="text-sm overflow-x-auto" x-text="output"></pre>
        </div>
    </div>
</div>

@push('scripts')
<script>
function cacheManagement() {
    return {
        stats: {
            driver: '{{ config('cache.default') }}',
            size: '0 B',
            items: 0,
            hits: 0
        },
        loading: false,
        output: '',

        init() {
            this.loadStats();
        },

        async loadStats() {
            try {
                const response = await axios.get('/developer/system/cache/stats');
                if (response.data.success) {
                    this.stats = response.data.data;
                }
            } catch (error) {
                console.error('Failed to load cache stats:', error);
            }
        },

        async clearCache() {
            if (!confirm('Hapus semua cache aplikasi?')) return;

            this.loading = true;
            try {
                const response = await axios.post('/developer/system/cache/clear');
                if (response.data.success) {
                    this.output = response.data.output || response.data.message;
                    window.showToast('Cache berhasil dihapus', 'success');
                }
            } catch (error) {
                window.showToast('Gagal menghapus cache', 'error');
                this.output = error.response?.data?.message || error.message;
            }
            this.loading = false;
        },

        async clearConfig() {
            this.loading = true;
            try {
                const response = await axios.post('/developer/system/cache/clear/config');
                if (response.data.success) {
                    this.output = response.data.output || response.data.message;
                    window.showToast('Config cache berhasil dihapus', 'success');
                }
            } catch (error) {
                window.showToast('Gagal menghapus config cache', 'error');
                this.output = error.response?.data?.message || error.message;
            }
            this.loading = false;
        },

        async clearViews() {
            this.loading = true;
            try {
                const response = await axios.post('/developer/system/cache/clear/view');
                if (response.data.success) {
                    this.output = response.data.output || response.data.message;
                    window.showToast('View cache berhasil dihapus', 'success');
                }
            } catch (error) {
                window.showToast('Gagal menghapus view cache', 'error');
                this.output = error.response?.data?.message || error.message;
            }
            this.loading = false;
        },

        async clearRoutes() {
            this.loading = true;
            try {
                const response = await axios.post('/developer/system/cache/clear/route');
                if (response.data.success) {
                    this.output = response.data.output || response.data.message;
                    window.showToast('Route cache berhasil dihapus', 'success');
                }
            } catch (error) {
                window.showToast('Gagal menghapus route cache', 'error');
                this.output = error.response?.data?.message || error.message;
            }
            this.loading = false;
        },

        async warmupCache() {
            if (!confirm('Warmup cache?')) return;

            this.loading = true;
            try {
                const response = await axios.post('/developer/system/cache/warmup');
                if (response.data.success) {
                    this.output = response.data.output || response.data.message;
                    window.showToast('Cache warmup berhasil', 'success');
                }
            } catch (error) {
                window.showToast('Gagal warmup cache', 'error');
                this.output = error.response?.data?.message || error.message;
            }
            this.loading = false;
        },

        async clearAll() {
            if (!confirm('⚠️ Hapus semua cache termasuk config, views, routes?')) return;

            this.loading = true;
            try {
                const response = await axios.post('/developer/system/cache/clear/all');
                if (response.data.success) {
                    this.output = response.data.output || response.data.message;
                    window.showToast('Semua cache berhasil dihapus', 'success');
                }
            } catch (error) {
                window.showToast('Gagal menghapus semua cache', 'error');
                this.output = error.response?.data?.message || error.message;
            }
            this.loading = false;
        }
    }
}
</script>
@endpush
@endsection