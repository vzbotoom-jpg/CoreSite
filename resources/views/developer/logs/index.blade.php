{{-- resources/views/developer/logs/index.blade.php --}}
@extends('layouts.developer')

@section('title', 'Log Management')
@section('page-title', 'Log Management')

@section('content')
<div x-data="logManagement()" x-init="init()" class="space-y-6">
    <!-- Header -->
    <div class="flex flex-wrap justify-between items-center gap-4">
        <div>
            <p class="text-text-secondary dark:text-text-dark-secondary">Kelola log files dan aktivitas sistem</p>
        </div>
        <div class="flex gap-3">
            <button @click="refreshLogs" class="btn btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Refresh
            </button>
            <button @click="clearAllLogs" class="btn btn-danger">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Clear All Logs
            </button>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="card">
            <div class="card-body py-3">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-text-secondary">Total Log Files</p>
                        <p class="text-xl font-bold text-text-primary dark:text-text-dark-primary" x-text="stats.total_files"></p>
                    </div>
                    <div class="w-10 h-10 bg-info/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-info" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body py-3">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-text-secondary">Total Size</p>
                        <p class="text-xl font-bold text-text-primary dark:text-text-dark-primary" x-text="stats.total_size"></p>
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
                        <p class="text-xs text-text-secondary">Largest File</p>
                        <p class="text-xl font-bold text-text-primary dark:text-text-dark-primary" x-text="stats.largest_file"></p>
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
                        <p class="text-xs text-text-secondary">Last Modified</p>
                        <p class="text-xl font-bold text-text-primary dark:text-text-dark-primary" x-text="stats.last_modified"></p>
                    </div>
                    <div class="w-10 h-10 bg-success/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Log Files Table -->
    <div class="card">
        <div class="card-header flex justify-between items-center">
            <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Log Files</h3>
            <div class="flex gap-2">
                <select x-model="filter" @change="loadLogs" class="input text-sm py-1">
                    <option value="all">All Files</option>
                    <option value="laravel">Laravel Logs</option>
                    <option value="access">Access Logs</option>
                    <option value="error">Error Logs</option>
                </select>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-light-border dark:border-dark-border">
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">File Name</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Size</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Modified</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Lines</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="log in logs" :key="log.name">
                        <tr class="border-b border-light-border dark:border-dark-border hover:bg-light-surface/50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    <span class="font-medium text-text-primary dark:text-text-dark-primary" x-text="log.name"></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-text-primary dark:text-text-dark-primary" x-text="formatSize(log.size)"></td>
                            <td class="px-6 py-4 text-text-secondary dark:text-text-dark-secondary" x-text="formatDate(log.modified)"></td>
                            <td class="px-6 py-4 text-text-primary dark:text-text-dark-primary" x-text="log.lines || '-'"></td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a :href="`/developer/logs/${log.name}`" class="text-info hover:text-info/80 transition" title="View">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a :href="`/developer/logs/download/${log.name}`" class="text-success hover:text-success/80 transition" title="Download">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                        </svg>
                                    </a>
                                    <button @click="deleteLog(log.name)" class="text-error hover:text-error/80 transition" title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="logs.length === 0 && !loading">
                        <td colspan="5" class="px-6 py-12 text-center text-text-secondary dark:text-text-dark-secondary">
                            <svg class="w-12 h-12 mx-auto mb-3 text-text-secondary/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <p>Belum ada log files</p>
                        </td>
                    </tr>
                    <tr x-show="loading">
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="spinner mx-auto"></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Delete Confirmation -->
    <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div class="card w-full max-w-md mx-4" @click.stop>
            <div class="card-header">
                <h3 class="text-xl font-bold text-error">Konfirmasi Hapus</h3>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <div class="w-16 h-16 bg-error/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-error" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-text-primary dark:text-text-dark-primary mb-2">Yakin ingin menghapus?</h4>
                    <p class="text-text-secondary dark:text-text-dark-secondary mb-6">
                        Log file <span class="font-medium text-text-primary dark:text-text-dark-primary" x-text="deleteData?.name"></span> akan dihapus permanen.
                    </p>
                    <div class="flex justify-center gap-3">
                        <button @click="showDeleteModal = false" class="btn btn-secondary">Batal</button>
                        <button @click="confirmDelete" class="btn btn-danger">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function logManagement() {
    return {
        logs: [],
        loading: false,
        filter: 'all',
        stats: {
            total_files: 0,
            total_size: '0 B',
            largest_file: '0 B',
            last_modified: '-'
        },
        showDeleteModal: false,
        deleteData: null,

        init() {
            this.loadLogs();
        },

        async loadLogs() {
            this.loading = true;
            const params = new URLSearchParams({
                filter: this.filter
            });

            try {
                const response = await axios.get(`/api/developer/logs?${params}`);
                if (response.data.success) {
                    this.logs = response.data.data;
                    this.stats = response.data.stats || this.stats;
                }
            } catch (error) {
                console.error('Failed to load logs:', error);
                window.showToast('Gagal memuat logs', 'error');
            }
            this.loading = false;
        },

        refreshLogs() {
            this.loadLogs();
        },

        async clearAllLogs() {
            if (!confirm('Hapus semua log files?')) return;
            if (!confirm('Konfirmasi: Yakin ingin menghapus semua log files?')) return;

            try {
                const response = await axios.delete('/api/developer/logs');
                if (response.data.success) {
                    this.loadLogs();
                    window.showToast('Semua logs berhasil dihapus', 'success');
                }
            } catch (error) {
                window.showToast('Gagal menghapus logs', 'error');
            }
        },

        deleteLog(name) {
            this.deleteData = { name };
            this.showDeleteModal = true;
        },

        async confirmDelete() {
            if (!this.deleteData) return;

            try {
                const response = await axios.delete(`/api/developer/logs/${this.deleteData.name}`);
                if (response.data.success) {
                    this.showDeleteModal = false;
                    this.deleteData = null;
                    this.loadLogs();
                    window.showToast('Log berhasil dihapus', 'success');
                }
            } catch (error) {
                window.showToast('Gagal menghapus log', 'error');
            }
        },

        formatSize(bytes) {
            if (!bytes || bytes === 0) return '0 B';
            const k = 1024;
            const sizes = ['B', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        },

        formatDate(timestamp) {
            if (!timestamp) return '-';
            const date = new Date(timestamp * 1000);
            return date.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }
    }
}
</script>
@endpush
@endsection