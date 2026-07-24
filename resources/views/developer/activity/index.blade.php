{{-- resources/views/developer/activity/index.blade.php --}}
@extends('layouts.developer')

@section('title', 'Activity Logs')
@section('page-title', 'Activity Logs')

@section('content')
<div x-data="activityManagement()" x-init="init()" class="space-y-6">
    <!-- Header -->
    <div class="flex flex-wrap justify-between items-center gap-4">
        <div>
            <p class="text-text-secondary dark:text-text-dark-secondary">Pantau semua aktivitas pengguna di sistem</p>
        </div>
        <div class="flex gap-3">
            <button @click="refreshActivities" class="btn btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Refresh
            </button>
            <button @click="clearAllActivities" class="btn btn-danger">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Clear All
            </button>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="card">
            <div class="card-body py-3">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-text-secondary">Total Activities</p>
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
                        <p class="text-xs text-text-secondary">Today</p>
                        <p class="text-xl font-bold text-success" x-text="stats.today"></p>
                    </div>
                    <div class="w-10 h-10 bg-success/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body py-3">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-text-secondary">This Week</p>
                        <p class="text-xl font-bold text-primary" x-text="stats.week"></p>
                    </div>
                    <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body py-3">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-text-secondary">Unique Users</p>
                        <p class="text-xl font-bold text-accent" x-text="stats.users"></p>
                    </div>
                    <div class="w-10 h-10 bg-accent/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card">
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <input type="text" x-model="filters.search" @input="debounceSearch" 
                           placeholder="Cari aktivitas..." class="input">
                </div>
                <div>
                    <select x-model="filters.type" @change="loadActivities" class="input">
                        <option value="">Semua Tipe</option>
                        <option value="login">Login</option>
                        <option value="logout">Logout</option>
                        <option value="create">Create</option>
                        <option value="update">Update</option>
                        <option value="delete">Delete</option>
                        <option value="status_change">Status Change</option>
                        <option value="role_change">Role Change</option>
                        <option value="permission_change">Permission Change</option>
                        <option value="export">Export</option>
                        <option value="import">Import</option>
                        <option value="system">System</option>
                    </select>
                </div>
                <div>
                    <select x-model="filters.user" @change="loadActivities" class="input">
                        <option value="">Semua User</option>
                        <template x-for="user in users" :key="user.id">
                            <option :value="user.id" x-text="user.name"></option>
                        </template>
                    </select>
                </div>
                <div>
                    <select x-model="filters.date" @change="loadActivities" class="input">
                        <option value="">Semua Waktu</option>
                        <option value="today">Hari Ini</option>
                        <option value="yesterday">Kemarin</option>
                        <option value="week">Minggu Ini</option>
                        <option value="month">Bulan Ini</option>
                        <option value="custom">Custom</option>
                    </select>
                </div>
            </div>
            <div x-show="filters.date === 'custom'" class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-1">Dari Tanggal</label>
                    <input type="date" x-model="filters.date_from" @change="loadActivities" class="input">
                </div>
                <div>
                    <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-1">Sampai Tanggal</label>
                    <input type="date" x-model="filters.date_to" @change="loadActivities" class="input">
                </div>
            </div>
            <div class="flex justify-between items-center mt-4">
                <button @click="resetFilters" class="text-sm text-text-secondary hover:text-accent transition-colors">
                    Reset Filter
                </button>
                <span class="text-sm text-text-secondary" x-text="`${total} aktivitas ditemukan`"></span>
            </div>
        </div>
    </div>

    <!-- Activities Table -->
    <div class="card">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-light-border dark:border-dark-border">
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">
                            <button @click="sortBy('created_at')" class="flex items-center gap-1 hover:text-accent">
                                Waktu
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                </svg>
                            </button>
                        </th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">User</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Tipe</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Deskripsi</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">IP Address</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="activity in activities" :key="activity.id">
                        <tr class="border-b border-light-border dark:border-dark-border hover:bg-light-surface/50 transition">
                            <td class="px-6 py-4 text-sm text-text-secondary dark:text-text-dark-secondary" x-text="formatDate(activity.created_at)"></td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-accent/10 rounded-full flex items-center justify-center">
                                        <span class="text-accent font-semibold text-xs" x-text="getInitials(activity.user?.name)"></span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-text-primary dark:text-text-dark-primary" x-text="activity.user?.name || 'System'"></p>
                                        <p class="text-xs text-text-secondary" x-text="activity.user?.email || '-'"></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span :class="getTypeClass(activity.type)" class="badge">
                                    <span x-text="getTypeLabel(activity.type)"></span>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-text-primary dark:text-text-dark-primary" x-text="activity.description"></td>
                            <td class="px-6 py-4 text-sm text-text-secondary dark:text-text-dark-secondary" x-text="activity.ip_address || '-'"></td>
                            <td class="px-6 py-4">
                                <button @click="viewActivity(activity.id)" class="text-info hover:text-info/80 transition" title="Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="activities.length === 0 && !loading">
                        <td colspan="6" class="px-6 py-12 text-center text-text-secondary dark:text-text-dark-secondary">
                            <svg class="w-12 h-12 mx-auto mb-3 text-text-secondary/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <p>Belum ada aktivitas</p>
                        </td>
                    </tr>
                    <tr x-show="loading">
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="spinner mx-auto"></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div x-show="lastPage > 1" class="card-footer">
            <div class="flex justify-between items-center">
                <div class="text-sm text-text-secondary dark:text-text-dark-secondary">
                    Menampilkan <span x-text="from"></span> - <span x-text="to"></span> dari <span x-text="total"></span> aktivitas
                </div>
                <div class="flex gap-2">
                    <button @click="prevPage" :disabled="currentPage === 1" 
                            class="px-3 py-1 border border-light-border dark:border-dark-border rounded hover:bg-light-surface disabled:opacity-50 transition">
                        Sebelumnya
                    </button>
                    <span class="px-3 py-1 text-text-secondary dark:text-text-dark-secondary">
                        Halaman <span x-text="currentPage"></span> dari <span x-text="lastPage"></span>
                    </span>
                    <button @click="nextPage" :disabled="currentPage === lastPage" 
                            class="px-3 py-1 border border-light-border dark:border-dark-border rounded hover:bg-light-surface disabled:opacity-50 transition">
                        Selanjutnya
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Clear All Confirmation -->
    <div x-show="showClearModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
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
                    <h4 class="text-lg font-semibold text-text-primary dark:text-text-dark-primary mb-2">Hapus Semua Aktivitas?</h4>
                    <p class="text-text-secondary dark:text-text-dark-secondary mb-6">
                        Semua data aktivitas akan dihapus permanen. Tindakan ini tidak dapat dibatalkan.
                    </p>
                    <div class="flex justify-center gap-3">
                        <button @click="showClearModal = false" class="btn btn-secondary">Batal</button>
                        <button @click="confirmClearAll" class="btn btn-danger">Hapus Semua</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function activityManagement() {
    return {
        activities: [],
        users: @json($users ?? []),
        loading: false,
        currentPage: 1,
        lastPage: 1,
        total: 0,
        from: 0,
        to: 0,
        stats: {
            total: 0,
            today: 0,
            week: 0,
            users: 0
        },
        filters: {
            search: '',
            type: '',
            user: '',
            date: '',
            date_from: '',
            date_to: ''
        },
        sortField: 'created_at',
        sortDirection: 'desc',
        searchTimeout: null,
        showClearModal: false,

        init() {
            this.loadActivities();
        },

        async loadActivities() {
            this.loading = true;
            const params = new URLSearchParams({
                page: this.currentPage,
                search: this.filters.search,
                type: this.filters.type,
                user: this.filters.user,
                date: this.filters.date,
                date_from: this.filters.date_from,
                date_to: this.filters.date_to,
                sort: this.sortField,
                direction: this.sortDirection
            });

            try {
                const response = await axios.get(`/developer/activity/data?${params}`);
                if (response.data.success) {
                    this.activities = response.data.data.data;
                    this.currentPage = response.data.data.current_page;
                    this.lastPage = response.data.data.last_page;
                    this.total = response.data.data.total;
                    this.from = response.data.data.from;
                    this.to = response.data.data.to;
                    this.stats = response.data.stats || this.stats;
                }
            } catch (error) {
                console.error('Failed to load activities:', error);
                window.showToast('Gagal memuat aktivitas', 'error');
            }
            this.loading = false;
        },

        debounceSearch() {
            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(() => {
                this.currentPage = 1;
                this.loadActivities();
            }, 300);
        },

        resetFilters() {
            this.filters = {
                search: '',
                type: '',
                user: '',
                date: '',
                date_from: '',
                date_to: ''
            };
            this.currentPage = 1;
            this.loadActivities();
        },

        sortBy(field) {
            if (this.sortField === field) {
                this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                this.sortField = field;
                this.sortDirection = 'asc';
            }
            this.loadActivities();
        },

        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
                this.loadActivities();
            }
        },

        nextPage() {
            if (this.currentPage < this.lastPage) {
                this.currentPage++;
                this.loadActivities();
            }
        },

        refreshActivities() {
            this.loadActivities();
        },

        viewActivity(id) {
            window.location.href = `/developer/activity/${id}`;
        },

        clearAllActivities() {
            this.showClearModal = true;
        },

        async confirmClearAll() {
            try {
                const response = await axios.delete('/developer/activity/clear');
                if (response.data.success) {
                    this.showClearModal = false;
                    this.loadActivities();
                    window.showToast('Semua aktivitas berhasil dihapus', 'success');
                }
            } catch (error) {
                window.showToast('Gagal menghapus aktivitas', 'error');
            }
        },

        getTypeClass(type) {
            const classes = {
                'login': 'badge-success',
                'logout': 'badge-secondary',
                'create': 'badge-primary',
                'update': 'badge-info',
                'delete': 'badge-error',
                'status_change': 'badge-warning',
                'role_change': 'badge-accent',
                'permission_change': 'badge-purple',
                'export': 'badge-cyan',
                'import': 'badge-cyan',
                'system': 'badge-dark'
            };
            return classes[type] || 'badge-secondary';
        },

        getTypeLabel(type) {
            const labels = {
                'login': 'Login',
                'logout': 'Logout',
                'create': 'Create',
                'update': 'Update',
                'delete': 'Delete',
                'status_change': 'Status Change',
                'role_change': 'Role Change',
                'permission_change': 'Permission Change',
                'export': 'Export',
                'import': 'Import',
                'system': 'System'
            };
            return labels[type] || type;
        },

        getInitials(name) {
            if (!name) return '?';
            return name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
        },

        formatDate(date) {
            if (!date) return '-';
            return new Date(date).toLocaleDateString('id-ID', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
        }
    }
}
</script>
@endpush
@endsection