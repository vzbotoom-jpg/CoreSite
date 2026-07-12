{{-- resources/views/developer/activity/show.blade.php --}}
@extends('layouts.developer')

@section('title', 'Activity Detail')
@section('page-title', 'Activity Detail')

@section('content')
<div x-data="activityDetail()" x-init="init()" class="max-w-4xl mx-auto">
    <!-- Loading -->
    <div x-show="loading" class="text-center py-12">
        <div class="spinner mx-auto"></div>
        <p class="text-text-secondary mt-4">Memuat data aktivitas...</p>
    </div>

    <!-- Activity Detail -->
    <div x-show="!loading && activity" x-cloak>
        <!-- Header -->
        <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
            <div class="flex items-center gap-4">
                <a href="{{ route('developer.activity.index') }}" class="text-text-secondary hover:text-accent transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-text-primary dark:text-text-dark-primary">Detail Aktivitas</h1>
                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary" x-text="`ID: ${activity.id}`"></p>
                </div>
                <span :class="getTypeClass(activity.type)" class="badge">
                    <span x-text="getTypeLabel(activity.type)"></span>
                </span>
            </div>
            <div class="flex gap-3">
                <button @click="deleteActivity" class="btn btn-danger text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Hapus
                </button>
            </div>
        </div>

        <!-- Activity Info -->
        <div class="grid md:grid-cols-3 gap-6">
            <!-- User Info -->
            <div class="card md:col-span-1">
                <div class="card-body">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-accent/10 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl font-bold text-accent" x-text="getInitials(activity.user?.name)"></span>
                        </div>
                        <h3 class="text-xl font-bold text-text-primary dark:text-text-dark-primary" x-text="activity.user?.name || 'System'"></h3>
                        <p class="text-sm text-text-secondary dark:text-text-dark-secondary" x-text="activity.user?.email || '-'"></p>
                        <div class="mt-3 flex justify-center gap-2">
                            <span :class="activity.user?.is_active ? 'badge-success' : 'badge-error'" class="badge">
                                <span x-text="activity.user?.is_active ? 'Aktif' : 'Nonaktif'"></span>
                            </span>
                            <span class="badge badge-secondary" x-text="activity.user?.role || 'System'"></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Details -->
            <div class="card md:col-span-2">
                <div class="card-header">
                    <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Informasi Aktivitas</h3>
                </div>
                <div class="card-body space-y-4">
                    <div>
                        <label class="text-sm text-text-secondary">Tipe Aktivitas</label>
                        <p>
                            <span :class="getTypeClass(activity.type)" class="badge">
                                <span x-text="getTypeLabel(activity.type)"></span>
                            </span>
                        </p>
                    </div>
                    <div>
                        <label class="text-sm text-text-secondary">Deskripsi</label>
                        <p class="text-text-primary dark:text-text-dark-primary" x-text="activity.description"></p>
                    </div>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm text-text-secondary">Waktu</label>
                            <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="formatDate(activity.created_at)"></p>
                        </div>
                        <div>
                            <label class="text-sm text-text-secondary">IP Address</label>
                            <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="activity.ip_address || '-'"></p>
                        </div>
                        <div>
                            <label class="text-sm text-text-secondary">User Agent</label>
                            <p class="font-medium text-text-primary dark:text-text-dark-primary text-sm" x-text="activity.user_agent || '-'"></p>
                        </div>
                        <div>
                            <label class="text-sm text-text-secondary">Platform</label>
                            <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="getPlatform(activity.user_agent)"></p>
                        </div>
                    </div>

                    <!-- Additional Data -->
                    <div x-show="activity.data" class="mt-4 pt-4 border-t border-light-border dark:border-dark-border">
                        <label class="text-sm text-text-secondary block mb-2">Data Tambahan</label>
                        <div class="bg-light-surface dark:bg-dark-surface rounded-lg p-4 overflow-x-auto">
                            <pre class="text-sm text-text-primary dark:text-text-dark-primary" x-text="formatData(activity.data)"></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Activities -->
        <div class="card mt-6" x-show="relatedActivities.length > 0">
            <div class="card-header flex justify-between items-center">
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Aktivitas Terkait</h3>
                <span class="text-xs text-text-secondary" x-text="relatedActivities.length + ' aktivitas'"></span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-light-border dark:border-dark-border">
                            <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Waktu</th>
                            <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Tipe</th>
                            <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Deskripsi</th>
                            <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="related in relatedActivities" :key="related.id">
                            <tr class="border-b border-light-border dark:border-dark-border hover:bg-light-surface/50 transition">
                                <td class="px-6 py-4 text-sm text-text-secondary dark:text-text-dark-secondary" x-text="formatDate(related.created_at)"></td>
                                <td class="px-6 py-4">
                                    <span :class="getTypeClass(related.type)" class="badge">
                                        <span x-text="getTypeLabel(related.type)"></span>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-text-primary dark:text-text-dark-primary" x-text="related.description"></td>
                                <td class="px-6 py-4">
                                    <a :href="`/developer/activity/${related.id}`" class="btn btn-ghost btn-sm">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        </template>
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
                            Aktivitas ini akan dihapus permanen.
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

    <!-- Not Found -->
    <div x-show="!loading && !activity" class="text-center py-12">
        <svg class="w-16 h-16 mx-auto text-text-secondary/50 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        <p class="text-text-secondary">Aktivitas tidak ditemukan</p>
        <a href="{{ route('developer.activity.index') }}" class="btn btn-ghost btn-sm">
            Kembali ke daftar aktivitas
        </a>
    </div>
</div>

@push('scripts')
<script>
function activityDetail() {
    return {
        activity: null,
        relatedActivities: [],
        loading: true,
        showDeleteModal: false,
        activityId: {{ $id ?? 0 }},

        init() {
            this.loadActivity();
        },

        async loadActivity() {
            this.loading = true;
            try {
                const response = await axios.get(`/api/developer/activity/${this.activityId}`);
                if (response.data.success) {
                    this.activity = response.data.data;
                    this.relatedActivities = response.data.related || [];
                }
            } catch (error) {
                console.error('Failed to load activity:', error);
                window.showToast('Gagal memuat data aktivitas', 'error');
            }
            this.loading = false;
        },

        deleteActivity() {
            this.showDeleteModal = true;
        },

        async confirmDelete() {
            try {
                const response = await axios.delete(`/api/developer/activity/${this.activityId}`);
                if (response.data.success) {
                    this.showDeleteModal = false;
                    window.showToast('Aktivitas berhasil dihapus', 'success');
                    setTimeout(() => {
                        window.location.href = '{{ route("developer.activity.index") }}';
                    }, 1500);
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

        getPlatform(userAgent) {
            if (!userAgent) return '-';
            if (userAgent.includes('Windows')) return 'Windows';
            if (userAgent.includes('Mac')) return 'Mac';
            if (userAgent.includes('Linux')) return 'Linux';
            if (userAgent.includes('Android')) return 'Android';
            if (userAgent.includes('iPhone') || userAgent.includes('iPad')) return 'iOS';
            return 'Unknown';
        },

        formatData(data) {
            if (!data) return 'Tidak ada data';
            return JSON.stringify(data, null, 2);
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