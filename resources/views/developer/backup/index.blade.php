{{-- resources/views/developer/backup/index.blade.php --}}
@extends('layouts.developer')

@section('title', 'Backup Management')
@section('page-title', 'Backup Management')

@section('content')
<div x-data="backupManager()" x-init="init()" class="space-y-6">
    <!-- Header -->
    <div class="flex flex-wrap justify-between items-center gap-4">
        <div>
            <p class="text-text-secondary dark:text-text-dark-secondary">Kelola backup database dan file</p>
        </div>
        <div class="flex gap-3">
            <button @click="createBackup" class="btn btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Create Backup
            </button>
            <button @click="refreshBackups" class="btn btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Refresh
            </button>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="card">
            <div class="card-body py-3">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-text-secondary">Total Backups</p>
                        <p class="text-xl font-bold text-text-primary dark:text-text-dark-primary" x-text="stats.total"></p>
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
                        <p class="text-xs text-text-secondary">Latest Backup</p>
                        <p class="text-xl font-bold text-success" x-text="stats.latest || '-'"></p>
                    </div>
                    <div class="w-10 h-10 bg-success/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body py-3">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-text-secondary">Storage Used</p>
                        <p class="text-xl font-bold text-accent" x-text="stats.storage_used"></p>
                    </div>
                    <div class="w-10 h-10 bg-accent/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Backup Settings -->
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Backup Settings</h3>
        </div>
        <div class="card-body">
            <form @submit.prevent="updateSettings">
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Auto Backup</label>
                        <div class="flex items-center gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" x-model="settings.auto_backup" value="daily" class="w-4 h-4 text-accent">
                                <span class="text-sm">Daily</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" x-model="settings.auto_backup" value="weekly" class="w-4 h-4 text-accent">
                                <span class="text-sm">Weekly</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" x-model="settings.auto_backup" value="monthly" class="w-4 h-4 text-accent">
                                <span class="text-sm">Monthly</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" x-model="settings.auto_backup" value="disabled" class="w-4 h-4 text-accent">
                                <span class="text-sm">Disabled</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Keep Backups</label>
                        <select x-model="settings.keep_backups" class="input">
                            <option value="5">5 Latest</option>
                            <option value="10">10 Latest</option>
                            <option value="20">20 Latest</option>
                            <option value="50">50 Latest</option>
                            <option value="all">All</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Backup Type</label>
                        <div class="flex items-center gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" x-model="settings.backup_database" class="w-4 h-4 rounded border-gray-300 text-accent">
                                <span class="text-sm">Database</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" x-model="settings.backup_files" class="w-4 h-4 rounded border-gray-300 text-accent">
                                <span class="text-sm">Files</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" x-model="settings.backup_media" class="w-4 h-4 rounded border-gray-300 text-accent">
                                <span class="text-sm">Media</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Storage Location</label>
                        <select x-model="settings.storage" class="input">
                            <option value="local">Local Storage</option>
                            <option value="s3">Amazon S3</option>
                            <option value="google">Google Drive</option>
                            <option value="dropbox">Dropbox</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-4 pt-4 border-t border-light-border dark:border-dark-border">
                    <button type="submit" class="btn btn-primary">Save Settings</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Backup List -->
    <div class="card">
        <div class="card-header flex justify-between items-center">
            <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Backup Files</h3>
            <span class="text-xs text-text-secondary" x-text="backups.length + ' files'"></span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-light-border dark:border-dark-border">
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary">File Name</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary">Size</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary">Type</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary">Created</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="backup in backups" :key="backup.id || backup.name">
                        <tr class="border-b border-light-border dark:border-dark-border hover:bg-light-surface/50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    <span class="font-medium text-text-primary dark:text-text-dark-primary" x-text="backup.name"></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-text-primary" x-text="formatSize(backup.size)"></td>
                            <td class="px-6 py-4">
                                <span class="badge badge-secondary" x-text="backup.type || 'Full'"></span>
                            </td>
                            <td class="px-6 py-4 text-text-secondary" x-text="formatDate(backup.created_at)"></td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a :href="`/api/developer/backup/download/${backup.name}`" class="text-success hover:text-success/80 transition" title="Download">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                        </svg>
                                    </a>
                                    <button @click="restoreBackup(backup.name)" class="text-info hover:text-info/80 transition" title="Restore">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                        </svg>
                                    </button>
                                    <button @click="deleteBackup(backup.name)" class="text-error hover:text-error/80 transition" title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="backups.length === 0 && !loading">
                        <td colspan="5" class="px-6 py-12 text-center text-text-secondary">
                            <svg class="w-12 h-12 mx-auto mb-3 text-text-secondary/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            <p>Belum ada backup</p>
                            <button @click="createBackup" class="btn btn-ghost btn-sm">
                                Buat backup pertama →
                            </button>
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

    <!-- Create Backup Modal -->
    <div x-show="showCreateModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" @click.away="closeCreateModal">
        <div class="card w-full max-w-md mx-4" @click.stop>
            <div class="card-header flex justify-between items-center">
                <h3 class="text-xl font-bold text-text-primary dark:text-text-dark-primary">Create Backup</h3>
                <button @click="closeCreateModal" class="text-text-secondary hover:text-text-primary">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="card-body">
                <form @submit.prevent="createBackupConfirm">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Backup Name</label>
                            <input type="text" x-model="backupForm.name" class="input" placeholder="Nama backup (opsional)">
                            <p class="text-xs text-text-secondary mt-1">Kosongkan untuk menggunakan timestamp</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Backup Type</label>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" x-model="backupForm.include_database" class="w-4 h-4 rounded border-gray-300 text-accent">
                                    <span class="text-sm">Include Database</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" x-model="backupForm.include_files" class="w-4 h-4 rounded border-gray-300 text-accent">
                                    <span class="text-sm">Include Files</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" x-model="backupForm.include_media" class="w-4 h-4 rounded border-gray-300 text-accent">
                                    <span class="text-sm">Include Media</span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Description</label>
                            <textarea x-model="backupForm.description" rows="2" class="input" placeholder="Deskripsi backup"></textarea>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-light-border dark:border-dark-border">
                        <button type="button" @click="closeCreateModal" class="btn btn-secondary">Batal</button>
                        <button type="submit" class="btn btn-primary" :disabled="loading">
                            <span x-show="!loading">Create Backup</span>
                            <span x-show="loading" class="flex items-center gap-2">
                                <div class="spinner w-4 h-4"></div>
                                Creating...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Restore Confirmation -->
    <div x-show="showRestoreModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div class="card w-full max-w-md mx-4" @click.stop>
            <div class="card-header">
                <h3 class="text-xl font-bold text-warning">Konfirmasi Restore</h3>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <div class="w-16 h-16 bg-warning/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-text-primary dark:text-text-dark-primary mb-2">Yakin ingin restore?</h4>
                    <p class="text-text-secondary dark:text-text-dark-secondary mb-6">
                        Restore backup akan mengembalikan data ke versi sebelumnya.
                        <br>
                        <span class="text-xs text-error">⚠️ Data saat ini akan diganti!</span>
                    </p>
                    <div class="flex justify-center gap-3">
                        <button @click="showRestoreModal = false" class="btn btn-secondary">Batal</button>
                        <button @click="confirmRestore" class="btn btn-warning">Restore</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function backupManager() {
    return {
        backups: [],
        stats: {
            total: 0,
            total_size: '0 B',
            latest: null,
            storage_used: '0%'
        },
        settings: {
            auto_backup: 'daily',
            keep_backups: 10,
            backup_database: true,
            backup_files: false,
            backup_media: false,
            storage: 'local'
        },
        loading: false,
        showCreateModal: false,
        showRestoreModal: false,
        backupForm: {
            name: '',
            include_database: true,
            include_files: false,
            include_media: false,
            description: ''
        },
        restoreFile: null,

        init() {
            this.loadBackups();
            this.loadSettings();
        },

        async loadBackups() {
            this.loading = true;
            try {
                const response = await axios.get('/api/developer/backup/list');
                if (response.data.success) {
                    this.backups = response.data.data;
                    this.stats = response.data.stats || this.stats;
                }
            } catch (error) {
                console.error('Failed to load backups:', error);
                window.showToast('Gagal memuat daftar backup', 'error');
            }
            this.loading = false;
        },

        async loadSettings() {
            try {
                const response = await axios.get('/api/developer/backup/settings');
                if (response.data.success) {
                    this.settings = { ...this.settings, ...response.data.data };
                }
            } catch (error) {
                console.error('Failed to load backup settings:', error);
            }
        },

        refreshBackups() {
            this.loadBackups();
        },

        openCreateModal() {
            this.backupForm = {
                name: '',
                include_database: true,
                include_files: false,
                include_media: false,
                description: ''
            };
            this.showCreateModal = true;
        },

        closeCreateModal() {
            this.showCreateModal = false;
        },

        async createBackup() {
            this.openCreateModal();
        },

        async createBackupConfirm() {
            if (!this.backupForm.include_database && !this.backupForm.include_files && !this.backupForm.include_media) {
                window.showToast('Pilih minimal satu jenis backup', 'warning');
                return;
            }

            this.loading = true;
            try {
                const response = await axios.post('/api/developer/backup/create', this.backupForm);
                if (response.data.success) {
                    this.closeCreateModal();
                    this.loadBackups();
                    window.showToast('Backup berhasil dibuat', 'success');
                }
            } catch (error) {
                window.showToast('Gagal membuat backup', 'error');
            }
            this.loading = false;
        },

        restoreBackup(name) {
            this.restoreFile = name;
            this.showRestoreModal = true;
        },

        async confirmRestore() {
            if (!this.restoreFile) return;

            this.loading = true;
            try {
                const response = await axios.post(`/api/developer/backup/restore/${this.restoreFile}`);
                if (response.data.success) {
                    this.showRestoreModal = false;
                    this.restoreFile = null;
                    window.showToast('Backup berhasil direstore', 'success');
                }
            } catch (error) {
                window.showToast('Gagal restore backup', 'error');
            }
            this.loading = false;
        },

        async deleteBackup(name) {
            if (!confirm(`Hapus backup "${name}"?`)) return;

            this.loading = true;
            try {
                const response = await axios.delete(`/api/developer/backup/delete/${name}`);
                if (response.data.success) {
                    this.loadBackups();
                    window.showToast('Backup berhasil dihapus', 'success');
                }
            } catch (error) {
                window.showToast('Gagal menghapus backup', 'error');
            }
            this.loading = false;
        },

        async updateSettings() {
            this.loading = true;
            try {
                const response = await axios.post('/api/developer/backup/settings', this.settings);
                if (response.data.success) {
                    window.showToast('Settings updated successfully', 'success');
                }
            } catch (error) {
                window.showToast('Failed to update settings', 'error');
            }
            this.loading = false;
        },

        formatSize(bytes) {
            if (!bytes || bytes === 0) return '0 B';
            const k = 1024;
            const sizes = ['B', 'KB', 'MB', 'GB', 'TB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        },

        formatDate(date) {
            if (!date) return '-';
            return new Date(date).toLocaleDateString('id-ID', {
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