{{-- resources/views/developer/system/database.blade.php --}}
@extends('layouts.developer')

@section('title', 'Database Management')
@section('page-title', 'Database Management')

@section('content')
<div x-data="databaseManagement()" x-init="init()" class="space-y-6">
    <!-- Header -->
    <div class="flex flex-wrap justify-between items-center gap-4">
        <div>
            <p class="text-text-secondary dark:text-text-dark-secondary">Kelola database, migration, dan seeder</p>
        </div>
        <a href="{{ route('developer.system.index') }}" class="btn btn-outline text-sm">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Database Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="card">
            <div class="card-body py-3">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-text-secondary">Database Name</p>
                        <p class="text-lg font-bold text-text-primary dark:text-text-dark-primary" x-text="stats.db_name"></p>
                    </div>
                    <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        <p class="text-lg font-bold text-text-primary dark:text-text-dark-primary" x-text="stats.total_size"></p>
                    </div>
                    <div class="w-10 h-10 bg-success/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        <p class="text-xs text-text-secondary">Total Tables</p>
                        <p class="text-lg font-bold text-text-primary dark:text-text-dark-primary" x-text="stats.total_tables"></p>
                    </div>
                    <div class="w-10 h-10 bg-info/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-info" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        <p class="text-xs text-text-secondary">Total Records</p>
                        <p class="text-lg font-bold text-text-primary dark:text-text-dark-primary" x-text="formatNumber(stats.total_records)"></p>
                    </div>
                    <div class="w-10 h-10 bg-warning/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Migration Management -->
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Migration Management</h3>
        </div>
        <div class="card-body">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="border rounded-lg p-4 hover:shadow-md transition">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                            </svg>
                        </div>
                        <h4 class="font-medium text-text-primary dark:text-text-dark-primary">Run Migration</h4>
                    </div>
                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary mb-3">Jalankan migration untuk update struktur database</p>
                    <button @click="runMigration" class="btn btn-primary w-full" :disabled="loading">
                        <span x-show="!loading">Run Migration</span>
                        <span x-show="loading" class="flex items-center justify-center gap-2">
                            <div class="spinner w-4 h-4"></div>
                            Running...
                        </span>
                    </button>
                </div>

                <div class="border rounded-lg p-4 hover:shadow-md transition">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-warning/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                        </div>
                        <h4 class="font-medium text-text-primary dark:text-text-dark-primary">Rollback</h4>
                    </div>
                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary mb-3">Rollback migration terakhir</p>
                    <button @click="rollbackMigration" class="btn btn-warning w-full" :disabled="loading">
                        <span x-show="!loading">Rollback</span>
                        <span x-show="loading" class="flex items-center justify-center gap-2">
                            <div class="spinner w-4 h-4"></div>
                            Rolling back...
                        </span>
                    </button>
                </div>

                <div class="border rounded-lg p-4 hover:shadow-md transition">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-accent/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <h4 class="font-medium text-text-primary dark:text-text-dark-primary">Run Seeder</h4>
                    </div>
                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary mb-3">Isi database dengan data dummy</p>
                    <div class="flex gap-2">
                        <input type="text" x-model="seederClass" placeholder="Seeder Class" class="input flex-1 text-sm">
                        <button @click="runSeeder" class="btn btn-primary" :disabled="loading">
                            <span x-show="!loading">Run</span>
                            <span x-show="loading" class="flex items-center gap-2">
                                <div class="spinner w-4 h-4"></div>
                            </span>
                        </button>
                    </div>
                    <p class="text-xs text-text-secondary mt-2">Contoh: DatabaseSeeder, StoreSeeder</p>
                </div>

                <div class="border rounded-lg p-4 hover:shadow-md transition">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-error/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-error" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </div>
                        <h4 class="font-medium text-text-primary dark:text-text-dark-primary">Refresh Database</h4>
                    </div>
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

    <!-- Database Tables -->
    <div class="card">
        <div class="card-header flex justify-between items-center">
            <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Database Tables</h3>
            <div class="flex items-center gap-3">
                <span class="text-xs text-text-secondary" x-text="stats.total_tables + ' tables'"></span>
                <button @click="loadTables" class="btn btn-ghost btn-sm">Refresh</button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-light-border dark:border-dark-border">
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">#</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Table Name</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Rows</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Size</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Engine</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Collation</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Created</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(table, index) in tables" :key="table.name">
                        <tr class="border-b border-light-border dark:border-dark-border hover:bg-light-surface/50 transition">
                            <td class="px-6 py-3 text-sm text-text-secondary" x-text="index + 1"></td>
                            <td class="px-6 py-3">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    <span class="font-medium text-text-primary dark:text-text-dark-primary" x-text="table.name"></span>
                                </div>
                            </td>
                            <td class="px-6 py-3 text-text-primary dark:text-text-dark-primary" x-text="formatNumber(table.rows)"></td>
                            <td class="px-6 py-3 text-text-primary dark:text-text-dark-primary" x-text="table.size"></td>
                            <td class="px-6 py-3">
                                <span class="badge badge-secondary text-xs" x-text="table.engine"></span>
                            </td>
                            <td class="px-6 py-3 text-text-secondary dark:text-text-dark-secondary text-sm" x-text="table.collation || '-'"></td>
                            <td class="px-6 py-3 text-text-secondary dark:text-text-dark-secondary text-sm" x-text="table.created_at || '-'"></td>
                        </tr>
                    </template>
                    <tr x-show="tables.length === 0 && !loading">
                        <td colspan="7" class="px-6 py-12 text-center text-text-secondary dark:text-text-dark-secondary">
                            <svg class="w-12 h-12 mx-auto mb-3 text-text-secondary/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p>Belum ada data tabel</p>
                        </td>
                    </tr>
                    <tr x-show="loading">
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="spinner mx-auto"></div>
                            <p class="text-text-secondary mt-2 text-sm">Memuat data tabel...</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Database Backup -->
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Database Backup</h3>
        </div>
        <div class="card-body">
            <div class="grid md:grid-cols-2 gap-4">
                <div class="border rounded-lg p-4">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-success/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                        </div>
                        <h4 class="font-medium text-text-primary dark:text-text-dark-primary">Create Backup</h4>
                    </div>
                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary mb-3">Buat backup database lengkap</p>
                    <button @click="createBackup" class="btn btn-success w-full" :disabled="loading">
                        <span x-show="!loading">Create Backup</span>
                        <span x-show="loading" class="flex items-center justify-center gap-2">
                            <div class="spinner w-4 h-4"></div>
                            Creating...
                        </span>
                    </button>
                </div>
                <div class="border rounded-lg p-4">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-info/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-info" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <h4 class="font-medium text-text-primary dark:text-text-dark-primary">Backup Files</h4>
                    </div>
                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary mb-3">Lihat dan kelola backup files</p>
                    <a href="{{ route('developer.backup.index') }}" class="btn btn-secondary w-full">
                        View Backups →
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Database Query Runner -->
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Query Runner</h3>
        </div>
        <div class="card-body">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">SQL Query</label>
                    <textarea x-model="query" rows="5" class="input font-mono text-sm" placeholder="SELECT * FROM users LIMIT 10"></textarea>
                </div>
                <div class="flex gap-3">
                    <button @click="runQuery" class="btn btn-primary" :disabled="loading || !query">
                        <span x-show="!loading">Run Query</span>
                        <span x-show="loading" class="flex items-center gap-2">
                            <div class="spinner w-4 h-4"></div>
                            Running...
                        </span>
                    </button>
                    <button @click="query = ''" class="btn btn-secondary">Clear</button>
                    <button @click="loadSampleQuery" class="btn btn-outline text-sm">Sample Query</button>
                </div>
                <div x-show="queryResult" class="mt-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-text-primary dark:text-text-dark-primary">Result</span>
                        <span class="text-xs text-text-secondary" x-text="queryResultTime"></span>
                    </div>
                    <div class="bg-light-surface dark:bg-dark-surface rounded-lg p-4 overflow-x-auto">
                        <pre class="text-sm text-text-primary dark:text-text-dark-primary font-mono" x-text="queryResult"></pre>
                    </div>
                </div>
                <div x-show="queryError" class="mt-4">
                    <div class="bg-error/10 border border-error/20 rounded-lg p-4">
                        <p class="text-sm text-error font-medium">Error:</p>
                        <pre class="text-sm text-error font-mono mt-1" x-text="queryError"></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Output Log -->
    <div x-show="output" class="card bg-dark-bg text-white">
        <div class="card-header flex justify-between items-center">
            <h3 class="font-semibold text-white">Command Output</h3>
            <button @click="output = ''" class="text-text-secondary hover:text-white transition">✕</button>
        </div>
        <div class="card-body">
            <pre class="text-sm font-mono overflow-x-auto max-h-60 overflow-y-auto" x-text="output"></pre>
        </div>
    </div>

    <!-- Confirmation Modals -->
    <!-- Refresh Database Modal -->
    <div x-show="showRefreshModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" @click.away="showRefreshModal = false">
        <div class="card w-full max-w-md mx-4" @click.stop>
            <div class="card-header">
                <h3 class="text-xl font-bold text-warning">Konfirmasi Refresh Database</h3>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <div class="w-16 h-16 bg-warning/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-text-primary dark:text-text-dark-primary mb-2">Yakin ingin refresh database?</h4>
                    <p class="text-text-secondary dark:text-text-dark-secondary mb-4">
                        Tindakan ini akan:
                        <br>
                        <span class="text-error">• Menghapus semua data</span>
                        <br>
                        <span class="text-error">• Menjalankan migration ulang</span>
                        <br>
                        <span class="text-error">• Menjalankan seeder</span>
                    </p>
                    <div class="flex justify-center gap-3">
                        <button @click="showRefreshModal = false" class="btn btn-secondary">Batal</button>
                        <button @click="confirmRefresh" class="btn btn-danger">Refresh</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function databaseManagement() {
    return {
        stats: {
            db_name: '{{ config('database.connections.mysql.database') }}',
            total_size: '0 MB',
            total_tables: 0,
            total_records: 0
        },
        tables: [],
        loading: false,
        output: '',
        seederClass: 'DatabaseSeeder',
        query: '',
        queryResult: '',
        queryError: '',
        queryResultTime: '',
        showRefreshModal: false,

        init() {
            this.loadDatabaseInfo();
            this.loadTables();
        },

        async loadDatabaseInfo() {
            try {
                const response = await axios.get('/api/developer/database/stats');
                if (response.data.success) {
                    this.stats = { ...this.stats, ...response.data.stats };
                }
            } catch (error) {
                console.error('Failed to load database info:', error);
            }
        },

        async loadTables() {
            this.loading = true;
            try {
                const response = await axios.get('/api/developer/database/tables');
                if (response.data.success) {
                    this.tables = response.data.data;
                    this.stats.total_tables = this.tables.length;
                }
            } catch (error) {
                console.error('Failed to load tables:', error);
                window.showToast('Gagal memuat daftar tabel', 'error');
            }
            this.loading = false;
        },

        async runMigration() {
            if (!confirm('Jalankan migration? Pastikan database sudah di-backup.')) return;

            this.loading = true;
            try {
                const response = await axios.post('/api/developer/database/migrate');
                if (response.data.success) {
                    this.output = response.data.output || response.data.message;
                    window.showToast('Migration berhasil dijalankan', 'success');
                    this.loadTables();
                    this.loadDatabaseInfo();
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
                const response = await axios.post('/api/developer/database/rollback');
                if (response.data.success) {
                    this.output = response.data.output || response.data.message;
                    window.showToast('Rollback berhasil', 'success');
                    this.loadTables();
                    this.loadDatabaseInfo();
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
                const response = await axios.post('/api/developer/database/seed', { seeder: this.seederClass });
                if (response.data.success) {
                    this.output = response.data.output || response.data.message;
                    window.showToast(`Seeder ${this.seederClass} berhasil dijalankan`, 'success');
                    this.loadTables();
                    this.loadDatabaseInfo();
                }
            } catch (error) {
                window.showToast('Seeder gagal', 'error');
                this.output = error.response?.data?.message || error.message;
            }
            this.loading = false;
        },

        refreshDatabase() {
            this.showRefreshModal = true;
        },

        async confirmRefresh() {
            this.showRefreshModal = false;
            this.loading = true;
            try {
                const response = await axios.post('/api/developer/database/refresh');
                if (response.data.success) {
                    this.output = response.data.output || response.data.message;
                    window.showToast('Database berhasil di-refresh', 'success');
                    this.loadTables();
                    this.loadDatabaseInfo();
                }
            } catch (error) {
                window.showToast('Refresh database gagal', 'error');
                this.output = error.response?.data?.message || error.message;
            }
            this.loading = false;
        },

        async createBackup() {
            if (!confirm('Buat backup database?')) return;

            this.loading = true;
            try {
                const response = await axios.post('/api/developer/backup/create');
                if (response.data.success) {
                    window.showToast('Backup berhasil dibuat', 'success');
                    this.output = response.data.message;
                }
            } catch (error) {
                window.showToast('Gagal membuat backup', 'error');
                this.output = error.response?.data?.message || error.message;
            }
            this.loading = false;
        },

        loadSampleQuery() {
            this.query = 'SELECT \n' +
                '    table_name,\n' +
                '    table_rows,\n' +
                '    ROUND((data_length + index_length) / 1024 / 1024, 2) AS size_mb\n' +
                'FROM information_schema.tables\n' +
                'WHERE table_schema = DATABASE()\n' +
                'ORDER BY size_mb DESC\n' +
                'LIMIT 10;';
        },

        async runQuery() {
            if (!this.query) return;

            this.loading = true;
            this.queryResult = '';
            this.queryError = '';
            this.queryResultTime = '';

            try {
                const startTime = performance.now();
                const response = await axios.post('/api/developer/database/query', { query: this.query });
                const endTime = performance.now();

                if (response.data.success) {
                    this.queryResult = JSON.stringify(response.data.data, null, 2);
                    this.queryResultTime = `Executed in ${(endTime - startTime).toFixed(2)}ms, ${response.data.count || 0} rows returned`;
                    window.showToast('Query berhasil dijalankan', 'success');
                }
            } catch (error) {
                this.queryError = error.response?.data?.message || error.message;
                window.showToast('Query gagal dijalankan', 'error');
            }
            this.loading = false;
        },

        formatNumber(value) {
            return new Intl.NumberFormat('id-ID').format(value);
        }
    }
}
</script>
@endpush
@endsection