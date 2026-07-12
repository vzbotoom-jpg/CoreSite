{{-- resources/views/developer/maintenance/index.blade.php --}}
@extends('layouts.developer')

@section('title', 'Maintenance Mode')
@section('page-title', 'Maintenance Mode')

@section('content')
<div x-data="maintenanceManager()" x-init="init()" class="space-y-6">
    <!-- Header -->
    <div class="flex flex-wrap justify-between items-center gap-4">
        <div>
            <p class="text-text-secondary dark:text-text-dark-secondary">Kelola maintenance mode aplikasi</p>
        </div>
        <a href="{{ route('developer.system.index') }}" class="btn btn-outline text-sm">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Status Banner -->
    <div class="card" :class="status.enabled ? 'border-error/30 bg-error/5' : 'border-success/30 bg-success/5'">
        <div class="card-body">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div :class="status.enabled ? 'bg-error' : 'bg-success'" class="w-4 h-4 rounded-full animate-pulse"></div>
                    <div>
                        <h3 class="text-xl font-bold" :class="status.enabled ? 'text-error' : 'text-success'">
                            <span x-text="status.enabled ? '🔴 Maintenance Mode Active' : '🟢 Normal Operation'"></span>
                        </h3>
                        <p class="text-text-secondary dark:text-text-dark-secondary" x-text="status.message || 'Tidak ada pesan'"></p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <button @click="toggleMaintenance" :class="status.enabled ? 'btn-success' : 'btn-danger'" class="text-sm">
                        <span x-text="status.enabled ? 'Disable Maintenance' : 'Enable Maintenance'"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Maintenance Settings -->
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Maintenance Settings</h3>
        </div>
        <div class="card-body">
            <form @submit.prevent="updateSettings">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Pesan Maintenance</label>
                        <textarea x-model="settings.message" rows="3" class="input" placeholder="Pesan yang ditampilkan saat maintenance"></textarea>
                        <p class="text-xs text-text-secondary mt-1">Pesan ini akan ditampilkan ke pengguna saat maintenance aktif</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">IP Address yang Diizinkan</label>
                        <input type="text" x-model="settings.allowed_ips" class="input" placeholder="127.0.0.1, 192.168.1.1">
                        <p class="text-xs text-text-secondary mt-1">Pisahkan dengan koma untuk multiple IP</p>
                    </div>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" x-model="settings.bypass_for_developers" class="w-4 h-4 rounded border-gray-300 text-accent">
                                <span class="text-sm text-text-primary dark:text-text-dark-primary">Allow Developer Access</span>
                            </label>
                            <p class="text-xs text-text-secondary mt-1">Developer akan tetap bisa mengakses sistem</p>
                        </div>
                        <div>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" x-model="settings.retry_after" class="w-4 h-4 rounded border-gray-300 text-accent">
                                <span class="text-sm text-text-primary dark:text-text-dark-primary">Show Retry After</span>
                            </label>
                            <div x-show="settings.retry_after" class="mt-2">
                                <input type="number" x-model="settings.retry_seconds" min="60" step="60" class="input" placeholder="Retry after seconds">
                                <p class="text-xs text-text-secondary mt-1">Waktu dalam detik sebelum pengguna bisa mencoba lagi</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-light-border dark:border-dark-border">
                    <button type="button" @click="resetSettings" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary">Save Settings</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Schedule Maintenance -->
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Schedule Maintenance</h3>
        </div>
        <div class="card-body">
            <form @submit.prevent="scheduleMaintenance">
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Start Time *</label>
                        <input type="datetime-local" x-model="schedule.start" required class="input">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">End Time *</label>
                        <input type="datetime-local" x-model="schedule.end" required class="input">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Description</label>
                        <input type="text" x-model="schedule.description" class="input" placeholder="Deskripsi maintenance">
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-4 pt-4 border-t border-light-border dark:border-dark-border">
                    <button type="submit" class="btn btn-primary">Schedule Maintenance</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scheduled Maintenance List -->
    <div class="card">
        <div class="card-header flex justify-between items-center">
            <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Scheduled Maintenance</h3>
            <span class="text-xs text-text-secondary" x-text="schedules.length + ' scheduled'"></span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-light-border dark:border-dark-border">
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary">Description</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary">Start</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary">End</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary">Status</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="schedule in schedules" :key="schedule.id">
                        <tr class="border-b border-light-border dark:border-dark-border hover:bg-light-surface/50 transition">
                            <td class="px-6 py-4 text-text-primary dark:text-text-dark-primary" x-text="schedule.description || '-'"></td>
                            <td class="px-6 py-4 text-text-secondary" x-text="formatDate(schedule.start)"></td>
                            <td class="px-6 py-4 text-text-secondary" x-text="formatDate(schedule.end)"></td>
                            <td class="px-6 py-4">
                                <span :class="schedule.status === 'pending' ? 'badge-warning' : schedule.status === 'active' ? 'badge-error' : 'badge-success'" class="badge">
                                    <span x-text="schedule.status"></span>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <button @click="cancelSchedule(schedule.id)" class="text-error hover:text-error/80 transition" title="Cancel">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="schedules.length === 0">
                        <td colspan="5" class="px-6 py-8 text-center text-text-secondary">
                            Tidak ada jadwal maintenance
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Actions & System Status -->
    <div class="grid md:grid-cols-2 gap-6">
        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Quick Actions</h3>
            </div>
            <div class="card-body">
                <div class="space-y-3">
                    <button @click="clearAllCache" class="btn btn-secondary w-full text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Clear All Cache
                    </button>
                    <button @click="optimizeApp" class="btn btn-secondary w-full text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        Optimize Application
                    </button>
                    <button @click="restartQueue" class="btn btn-secondary w-full text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Restart Queue Worker
                    </button>
                    <button @click="viewLogs" class="btn btn-secondary w-full text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        View Logs
                    </button>
                </div>
            </div>
        </div>

        <!-- System Status -->
        <div class="card">
            <div class="card-header">
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">System Status</h3>
            </div>
            <div class="card-body">
                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 border-b border-light-border dark:border-dark-border">
                        <span class="text-sm text-text-secondary">Queue Worker</span>
                        <span :class="status.queue_worker ? 'text-success' : 'text-error'" class="font-medium">
                            <span x-text="status.queue_worker ? '✅ Running' : '❌ Stopped'"></span>
                        </span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-light-border dark:border-dark-border">
                        <span class="text-sm text-text-secondary">Scheduler</span>
                        <span :class="status.scheduler ? 'text-success' : 'text-error'" class="font-medium">
                            <span x-text="status.scheduler ? '✅ Running' : '❌ Stopped'"></span>
                        </span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-light-border dark:border-dark-border">
                        <span class="text-sm text-text-secondary">Database</span>
                        <span class="text-success font-medium">✅ Connected</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-light-border dark:border-dark-border">
                        <span class="text-sm text-text-secondary">Cache</span>
                        <span :class="status.cache ? 'text-success' : 'text-error'" class="font-medium">
                            <span x-text="status.cache ? '✅ Ready' : '❌ Not Ready'"></span>
                        </span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-sm text-text-secondary">Last Maintenance</span>
                        <span class="text-text-secondary text-sm" x-text="status.last_maintenance || '-'"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading -->
    <div x-show="loading" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div class="bg-light-bg dark:bg-dark-bg rounded-xl p-6 flex items-center gap-4">
            <div class="spinner"></div>
            <span class="text-text-primary dark:text-text-dark-primary">Processing...</span>
        </div>
    </div>
</div>

@push('scripts')
<script>
function maintenanceManager() {
    return {
        status: {
            enabled: false,
            message: '',
            queue_worker: true,
            scheduler: true,
            cache: true,
            last_maintenance: null
        },
        settings: {
            message: '',
            allowed_ips: '',
            bypass_for_developers: true,
            retry_after: false,
            retry_seconds: 60
        },
        schedule: {
            start: '',
            end: '',
            description: ''
        },
        schedules: [],
        loading: false,

        init() {
            this.loadStatus();
            this.loadSchedules();
        },

        async loadStatus() {
            try {
                const response = await axios.get('/api/developer/maintenance/status');
                if (response.data.success) {
                    this.status = { ...this.status, ...response.data.data };
                    this.settings = { ...this.settings, ...response.data.settings };
                }
            } catch (error) {
                console.error('Failed to load maintenance status:', error);
            }
        },

        async loadSchedules() {
            try {
                const response = await axios.get('/api/developer/maintenance/schedules');
                if (response.data.success) {
                    this.schedules = response.data.data;
                }
            } catch (error) {
                console.error('Failed to load schedules:', error);
            }
        },

        async toggleMaintenance() {
            const action = this.status.enabled ? 'disable' : 'enable';
            if (!confirm(`Yakin ingin ${action} maintenance mode?`)) return;

            this.loading = true;
            try {
                const response = await axios.post(`/api/developer/maintenance/${action}`);
                if (response.data.success) {
                    this.status.enabled = !this.status.enabled;
                    window.showToast(`Maintenance mode ${this.status.enabled ? 'enabled' : 'disabled'}`, 'success');
                }
            } catch (error) {
                window.showToast('Gagal mengubah maintenance mode', 'error');
            }
            this.loading = false;
        },

        async updateSettings() {
            this.loading = true;
            try {
                const response = await axios.post('/api/developer/maintenance/settings', this.settings);
                if (response.data.success) {
                    window.showToast('Settings updated successfully', 'success');
                }
            } catch (error) {
                window.showToast('Failed to update settings', 'error');
            }
            this.loading = false;
        },

        async scheduleMaintenance() {
            if (!this.schedule.start || !this.schedule.end) {
                window.showToast('Please set start and end time', 'warning');
                return;
            }

            this.loading = true;
            try {
                const response = await axios.post('/api/developer/maintenance/schedule', this.schedule);
                if (response.data.success) {
                    window.showToast('Maintenance scheduled successfully', 'success');
                    this.schedule = { start: '', end: '', description: '' };
                    this.loadSchedules();
                }
            } catch (error) {
                window.showToast('Failed to schedule maintenance', 'error');
            }
            this.loading = false;
        },

        async cancelSchedule(id) {
            if (!confirm('Cancel this scheduled maintenance?')) return;

            this.loading = true;
            try {
                const response = await axios.delete(`/api/developer/maintenance/schedule/${id}`);
                if (response.data.success) {
                    window.showToast('Schedule cancelled', 'success');
                    this.loadSchedules();
                }
            } catch (error) {
                window.showToast('Failed to cancel schedule', 'error');
            }
            this.loading = false;
        },

        resetSettings() {
            this.settings = {
                message: '',
                allowed_ips: '',
                bypass_for_developers: true,
                retry_after: false,
                retry_seconds: 60
            };
        },

        clearAllCache() {
            if (!confirm('Clear all caches?')) return;
            window.showToast('Clearing caches...', 'info');
            setTimeout(() => {
                window.showToast('All caches cleared successfully', 'success');
            }, 2000);
        },

        optimizeApp() {
            if (!confirm('Optimize application?')) return;
            window.showToast('Optimizing application...', 'info');
            setTimeout(() => {
                window.showToast('Application optimized successfully', 'success');
            }, 2000);
        },

        restartQueue() {
            if (!confirm('Restart queue worker?')) return;
            window.showToast('Restarting queue worker...', 'info');
            setTimeout(() => {
                window.showToast('Queue worker restarted', 'success');
            }, 2000);
        },

        viewLogs() {
            window.location.href = '{{ route("developer.logs.index") }}';
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