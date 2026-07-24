{{-- resources/views/developer/jobs/index.blade.php --}}
@extends('layouts.developer')

@section('title', 'Scheduled Jobs')
@section('page-title', 'Scheduled Jobs')

@section('content')
<div x-data="jobManager()" x-init="init()" class="space-y-6">
    <!-- Header -->
    <div class="flex flex-wrap justify-between items-center gap-4">
        <div>
            <p class="text-text-secondary dark:text-text-dark-secondary">Kelola scheduled jobs dan task scheduler</p>
        </div>
        <div class="flex gap-3">
            <button @click="refreshJobs" class="btn btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Refresh
            </button>
            <button @click="runAllJobs" class="btn btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                Run All Jobs
            </button>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="card">
            <div class="card-body py-3">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-text-secondary">Total Jobs</p>
                        <p class="text-xl font-bold text-text-primary dark:text-text-dark-primary" x-text="stats.total"></p>
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
                        <p class="text-xs text-text-secondary">Active Jobs</p>
                        <p class="text-xl font-bold text-success" x-text="stats.active"></p>
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
                        <p class="text-xs text-text-secondary">Inactive Jobs</p>
                        <p class="text-xl font-bold text-error" x-text="stats.inactive"></p>
                    </div>
                    <div class="w-10 h-10 bg-error/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-error" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body py-3">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-text-secondary">Failed Jobs</p>
                        <p class="text-xl font-bold text-warning" x-text="stats.failed"></p>
                    </div>
                    <div class="w-10 h-10 bg-warning/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="card">
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <input type="text" x-model="filters.search" @input="debounceSearch" 
                           placeholder="Cari job..." class="input">
                </div>
                <div>
                    <select x-model="filters.status" @change="filterJobs" class="input">
                        <option value="">Semua Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="running">Running</option>
                        <option value="failed">Failed</option>
                    </select>
                </div>
                <div>
                    <select x-model="filters.frequency" @change="filterJobs" class="input">
                        <option value="">Semua Frekuensi</option>
                        <option value="everyMinute">Every Minute</option>
                        <option value="everyFiveMinutes">Every 5 Minutes</option>
                        <option value="everyTenMinutes">Every 10 Minutes</option>
                        <option value="everyThirtyMinutes">Every 30 Minutes</option>
                        <option value="hourly">Hourly</option>
                        <option value="daily">Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly">Monthly</option>
                    </select>
                </div>
                <div>
                    <select x-model="filters.group" @change="filterJobs" class="input">
                        <option value="">Semua Group</option>
                        <template x-for="group in groups" :key="group">
                            <option :value="group" x-text="group"></option>
                        </template>
                    </select>
                </div>
            </div>
            <div class="flex justify-between items-center mt-4">
                <button @click="resetFilters" class="text-sm text-text-secondary hover:text-accent transition-colors">
                    Reset Filter
                </button>
                <span class="text-sm text-text-secondary" x-text="`${filteredJobs.length} job ditemukan`"></span>
            </div>
        </div>
    </div>

    <!-- Jobs List -->
    <div class="space-y-4">
        <template x-for="job in filteredJobs" :key="job.id || job.name">
            <div class="card hover:shadow-lg transition group" :class="job.status === 'failed' ? 'border-error/30' : ''">
                <div class="card-body">
                    <div class="flex flex-wrap justify-between items-start gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center" 
                                     :class="job.status === 'active' ? 'bg-success/10' : job.status === 'running' ? 'bg-info/10' : job.status === 'failed' ? 'bg-error/10' : 'bg-gray-100 dark:bg-gray-800'">
                                    <span class="text-lg" x-text="getJobIcon(job.type)"></span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-text-primary dark:text-text-dark-primary" x-text="job.name"></h3>
                                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary" x-text="job.description || 'Tidak ada deskripsi'"></p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span :class="job.status === 'active' ? 'badge-success' : job.status === 'running' ? 'badge-info' : job.status === 'failed' ? 'badge-error' : 'badge-secondary'" class="badge">
                                <span x-text="job.status"></span>
                            </span>
                            <button @click="runJob(job)" class="btn btn-primary text-sm" :disabled="job.status === 'running'">
                                <span x-show="job.status !== 'running'">Run</span>
                                <span x-show="job.status === 'running'" class="flex items-center gap-1">
                                    <div class="spinner w-3 h-3"></div>
                                    Running
                                </span>
                            </button>
                            <button @click="toggleJob(job)" class="btn btn-secondary text-sm">
                                <span x-text="job.status === 'active' ? 'Disable' : 'Enable'"></span>
                            </button>
                            <button @click="viewJobLogs(job)" class="text-info hover:text-info/80 transition" title="View Logs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Job Details -->
                    <div class="grid md:grid-cols-4 gap-4 mt-4 pt-4 border-t border-light-border dark:border-dark-border">
                        <div>
                            <p class="text-xs text-text-secondary">Frequency</p>
                            <p class="text-sm font-medium text-text-primary dark:text-text-dark-primary" x-text="formatFrequency(job.frequency)"></p>
                        </div>
                        <div>
                            <p class="text-xs text-text-secondary">Last Run</p>
                            <p class="text-sm font-medium text-text-primary dark:text-text-dark-primary" x-text="formatDate(job.last_run)"></p>
                        </div>
                        <div>
                            <p class="text-xs text-text-secondary">Next Run</p>
                            <p class="text-sm font-medium text-text-primary dark:text-text-dark-primary" x-text="formatDate(job.next_run)"></p>
                        </div>
                        <div>
                            <p class="text-xs text-text-secondary">Total Runs</p>
                            <p class="text-sm font-medium text-text-primary dark:text-text-dark-primary" x-text="job.total_runs || 0"></p>
                        </div>
                        <div>
                            <p class="text-xs text-text-secondary">Group</p>
                            <p class="text-sm font-medium text-text-primary dark:text-text-dark-primary" x-text="job.group || 'Default'"></p>
                        </div>
                        <div>
                            <p class="text-xs text-text-secondary">Cron Expression</p>
                            <p class="text-sm font-mono text-text-primary dark:text-text-dark-primary" x-text="job.cron || '-'"></p>
                        </div>
                        <div>
                            <p class="text-xs text-text-secondary">Timeout</p>
                            <p class="text-sm font-medium text-text-primary dark:text-text-dark-primary" x-text="job.timeout ? job.timeout + 's' : 'Default'"></p>
                        </div>
                        <div>
                            <p class="text-xs text-text-secondary">Memory Limit</p>
                            <p class="text-sm font-medium text-text-primary dark:text-text-dark-primary" x-text="job.memory_limit || 'Default'"></p>
                        </div>
                    </div>

                    <!-- Last Output -->
                    <div x-show="job.last_output" class="mt-3 p-3 bg-light-surface dark:bg-dark-surface rounded-lg">
                        <p class="text-xs text-text-secondary mb-1">Last Output:</p>
                        <pre class="text-sm text-text-primary dark:text-text-dark-primary overflow-x-auto" x-text="job.last_output"></pre>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- Empty State -->
    <div x-show="filteredJobs.length === 0 && !loading" class="text-center py-12">
        <svg class="w-16 h-16 mx-auto text-text-secondary/50 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        <p class="text-text-secondary dark:text-text-dark-secondary">Tidak ada job ditemukan</p>
        <button @click="resetFilters" class="btn btn-ghost btn-sm">
            Reset filter →
        </button>
    </div>

    <!-- Loading State -->
    <div x-show="loading" class="text-center py-12">
        <div class="spinner mx-auto"></div>
        <p class="text-text-secondary mt-4">Memuat data jobs...</p>
    </div>

    <!-- Job Logs Modal -->
    <div x-show="showLogsModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" @click.away="closeLogsModal">
        <div class="card w-full max-w-3xl mx-4 max-h-[90vh]" @click.stop>
            <div class="card-header flex justify-between items-center">
                <h3 class="text-xl font-bold text-text-primary dark:text-text-dark-primary">
                    Job Logs: <span x-text="selectedJob?.name"></span>
                </h3>
                <button @click="closeLogsModal" class="text-text-secondary hover:text-text-primary">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="card-body overflow-y-auto max-h-[70vh]">
                <div x-show="loadingLogs" class="text-center py-8">
                    <div class="spinner mx-auto"></div>
                    <p class="text-text-secondary mt-4">Memuat logs...</p>
                </div>
                <div x-show="!loadingLogs && jobLogs.length === 0" class="text-center py-8 text-text-secondary">
                    Belum ada logs untuk job ini
                </div>
                <div x-show="!loadingLogs && jobLogs.length > 0" class="space-y-2">
                    <template x-for="log in jobLogs" :key="log.id">
                        <div class="p-3 border border-light-border dark:border-dark-border rounded-lg">
                            <div class="flex justify-between items-start">
                                <div>
                                    <span :class="log.status === 'success' ? 'text-success' : log.status === 'failed' ? 'text-error' : 'text-warning'" class="font-medium">
                                        <span x-text="log.status"></span>
                                    </span>
                                    <span class="text-sm text-text-secondary ml-2" x-text="formatDate(log.created_at)"></span>
                                </div>
                                <span class="text-xs text-text-secondary" x-text="log.duration ? log.duration + 's' : '-'"></span>
                            </div>
                            <p class="text-sm text-text-primary dark:text-text-dark-primary mt-1" x-text="log.message"></p>
                            <pre x-show="log.output" class="text-xs text-text-secondary mt-2 bg-light-surface dark:bg-dark-surface p-2 rounded overflow-x-auto" x-text="log.output"></pre>
                        </div>
                    </template>
                </div>
            </div>
            <div class="card-footer flex justify-end">
                <button @click="closeLogsModal" class="btn btn-secondary">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Run All Confirmation -->
    <div x-show="showRunAllModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div class="card w-full max-w-md mx-4" @click.stop>
            <div class="card-header">
                <h3 class="text-xl font-bold text-warning">Konfirmasi Run All</h3>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <div class="w-16 h-16 bg-warning/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-text-primary dark:text-text-dark-primary mb-2">Jalankan Semua Jobs?</h4>
                    <p class="text-text-secondary dark:text-text-dark-secondary mb-6">
                        Semua job yang aktif akan dijalankan sekarang.
                        <br>
                        <span class="text-xs text-warning">⚠️ Proses ini mungkin memakan waktu</span>
                    </p>
                    <div class="flex justify-center gap-3">
                        <button @click="showRunAllModal = false" class="btn btn-secondary">Batal</button>
                        <button @click="confirmRunAll" class="btn btn-warning">Run All</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function jobManager() {
    return {
        jobs: [],
        filteredJobs: [],
        groups: [],
        loading: false,
        loadingLogs: false,
        jobLogs: [],
        selectedJob: null,
        stats: {
            total: 0,
            active: 0,
            inactive: 0,
            failed: 0
        },
        filters: {
            search: '',
            status: '',
            frequency: '',
            group: ''
        },
        searchTimeout: null,
        showLogsModal: false,
        showRunAllModal: false,

        init() {
            this.loadJobs();
        },

        async loadJobs() {
            this.loading = true;
            try {
                const response = await axios.get('/developer/jobs/data');
                if (response.data.success) {
                    this.jobs = response.data.data;
                    this.stats = response.data.stats || this.stats;
                    this.groups = [...new Set(this.jobs.map(j => j.group || 'Default'))];
                    this.filterJobs();
                }
            } catch (error) {
                console.error('Failed to load jobs:', error);
                window.showToast('Gagal memuat jobs', 'error');
            }
            this.loading = false;
        },

        filterJobs() {
            this.filteredJobs = this.jobs.filter(job => {
                // Search filter
                if (this.filters.search) {
                    const search = this.filters.search.toLowerCase();
                    if (!job.name.toLowerCase().includes(search) && 
                        !(job.description || '').toLowerCase().includes(search)) {
                        return false;
                    }
                }
                
                // Status filter
                if (this.filters.status && job.status !== this.filters.status) {
                    return false;
                }
                
                // Frequency filter
                if (this.filters.frequency && job.frequency !== this.filters.frequency) {
                    return false;
                }
                
                // Group filter
                if (this.filters.group && (job.group || 'Default') !== this.filters.group) {
                    return false;
                }
                
                return true;
            });
        },

        debounceSearch() {
            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(() => {
                this.filterJobs();
            }, 300);
        },

        resetFilters() {
            this.filters = {
                search: '',
                status: '',
                frequency: '',
                group: ''
            };
            this.filterJobs();
        },

        refreshJobs() {
            this.loadJobs();
        },

        async runJob(job) {
            if (job.status === 'running') {
                window.showToast('Job sedang berjalan', 'warning');
                return;
            }

            try {
                const response = await axios.post(`/developer/jobs/run/${job.id || job.name}`);
                if (response.data.success) {
                    window.showToast(`Job "${job.name}" berhasil dijalankan`, 'success');
                    this.loadJobs();
                }
            } catch (error) {
                window.showToast(`Gagal menjalankan job "${job.name}"`, 'error');
            }
        },

        async toggleJob(job) {
            const action = job.status === 'active' ? 'disable' : 'enable';
            try {
                const response = await axios.post(`/developer/jobs/${action}/${job.id || job.name}`);
                if (response.data.success) {
                    window.showToast(`Job "${job.name}" ${action}d`, 'success');
                    this.loadJobs();
                }
            } catch (error) {
                window.showToast(`Gagal ${action} job`, 'error');
            }
        },

        runAllJobs() {
            this.showRunAllModal = true;
        },

        async confirmRunAll() {
            this.showRunAllModal = false;
            this.loading = true;
            try {
                const response = await axios.post('/developer/jobs/run-all');
                if (response.data.success) {
                    window.showToast('Semua jobs berhasil dijalankan', 'success');
                    this.loadJobs();
                }
            } catch (error) {
                window.showToast('Gagal menjalankan semua jobs', 'error');
            }
            this.loading = false;
        },

        async viewJobLogs(job) {
            this.selectedJob = job;
            this.showLogsModal = true;
            this.loadingLogs = true;
            try {
                const response = await axios.get(`/developer/jobs/logs/${job.id || job.name}`);
                if (response.data.success) {
                    this.jobLogs = response.data.data;
                }
            } catch (error) {
                console.error('Failed to load job logs:', error);
                window.showToast('Gagal memuat logs', 'error');
            }
            this.loadingLogs = false;
        },

        closeLogsModal() {
            this.showLogsModal = false;
            this.selectedJob = null;
            this.jobLogs = [];
        },

        getJobIcon(type) {
            const icons = {
                'backup': '💾',
                'cleanup': '🧹',
                'notification': '📧',
                'report': '📊',
                'sync': '🔄',
                'import': '📥',
                'export': '📤',
                'cache': '🚀',
                'database': '🗄️',
                'email': '✉️',
                'webhook': '🔗',
                'queue': '📋',
                'default': '⚙️'
            };
            return icons[type] || icons.default;
        },

        formatFrequency(frequency) {
            const frequencies = {
                'everyMinute': 'Every Minute',
                'everyFiveMinutes': 'Every 5 Minutes',
                'everyTenMinutes': 'Every 10 Minutes',
                'everyThirtyMinutes': 'Every 30 Minutes',
                'hourly': 'Hourly',
                'daily': 'Daily',
                'weekly': 'Weekly',
                'monthly': 'Monthly',
                'quarterly': 'Quarterly',
                'yearly': 'Yearly'
            };
            return frequencies[frequency] || frequency || 'Custom';
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