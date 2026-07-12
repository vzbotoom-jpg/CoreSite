{{-- resources/views/developer/users/show.blade.php --}}
@extends('layouts.developer')

@section('title', 'Detail User')
@section('page-title', 'Detail User')

@section('content')
<div x-data="userDetail()" x-init="init()" class="max-w-4xl mx-auto">
    <!-- Loading State -->
    <div x-show="loading" class="text-center py-12">
        <div class="spinner mx-auto"></div>
        <p class="text-text-secondary mt-4">Memuat data user...</p>
    </div>

    <!-- User Detail -->
    <div x-show="!loading && user" x-cloak>
        <!-- Header -->
        <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
            <div class="flex items-center gap-4">
                <a href="{{ route('developer.users.index') }}" class="text-text-secondary hover:text-accent transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h1 class="text-2xl font-bold text-text-primary dark:text-text-dark-primary" x-text="user.name"></h1>
                <span :class="user.is_active ? 'badge-success' : 'badge-error'" class="badge">
                    <span x-text="user.is_active ? 'Aktif' : 'Nonaktif'"></span>
                </span>
            </div>
            <div class="flex gap-3">
                <button @click="toggleStatus" class="btn btn-secondary text-sm">
                    <span x-text="user.is_active ? 'Nonaktifkan' : 'Aktifkan'"></span>
                </button>
                <a :href="`/developer/users/${user.id}/edit`" class="btn btn-primary text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit User
                </a>
            </div>
        </div>

        <!-- User Info -->
        <div class="grid md:grid-cols-3 gap-6">
            <!-- Profile Card -->
            <div class="card md:col-span-1">
                <div class="card-body text-center">
                    <div class="w-24 h-24 bg-accent/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-4xl font-bold text-accent" x-text="getInitials(user.name)"></span>
                    </div>
                    <h3 class="text-xl font-bold text-text-primary dark:text-text-dark-primary" x-text="user.name"></h3>
                    <p class="text-text-secondary dark:text-text-dark-secondary" x-text="user.email"></p>
                    <div class="mt-3 flex justify-center gap-2">
                        <span :class="user.is_active ? 'badge-success' : 'badge-error'" class="badge">
                            <span x-text="user.is_active ? 'Aktif' : 'Nonaktif'"></span>
                        </span>
                        <span class="badge badge-primary" x-text="user.role"></span>
                    </div>
                    <div class="mt-4 pt-4 border-t border-light-border dark:border-dark-border">
                        <p class="text-sm text-text-secondary">Member sejak</p>
                        <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="formatDate(user.created_at)"></p>
                    </div>
                </div>
            </div>

            <!-- Details Card -->
            <div class="card md:col-span-2">
                <div class="card-header">
                    <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Informasi Lengkap</h3>
                </div>
                <div class="card-body space-y-4">
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm text-text-secondary">Nama Lengkap</label>
                            <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="user.name"></p>
                        </div>
                        <div>
                            <label class="text-sm text-text-secondary">Email</label>
                            <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="user.email"></p>
                        </div>
                        <div>
                            <label class="text-sm text-text-secondary">Role</label>
                            <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="user.role"></p>
                        </div>
                        <div>
                            <label class="text-sm text-text-secondary">Status</label>
                            <p>
                                <span :class="user.is_active ? 'text-success' : 'text-error'" class="font-medium">
                                    <span x-text="user.is_active ? 'Aktif' : 'Nonaktif'"></span>
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="text-sm text-text-secondary">Toko</label>
                            <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="user.store?.name || '-'"></p>
                        </div>
                        <div>
                            <label class="text-sm text-text-secondary">Last Login</label>
                            <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="formatDate(user.last_login_at)"></p>
                        </div>
                        <div>
                            <label class="text-sm text-text-secondary">Email Verified</label>
                            <p class="font-medium text-text-primary dark:text-text-dark-primary">
                                <span x-text="user.email_verified_at ? '✅ Ya' : '❌ Tidak'"></span>
                            </p>
                        </div>
                        <div>
                            <label class="text-sm text-text-secondary">IP Address</label>
                            <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="user.last_login_ip || '-'"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Roles & Permissions -->
        <div class="grid md:grid-cols-2 gap-6 mt-6">
            <!-- Roles -->
            <div class="card">
                <div class="card-header">
                    <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Roles</h3>
                </div>
                <div class="card-body">
                    <div class="flex flex-wrap gap-2">
                        <template x-for="role in user.roles" :key="role.id">
                            <span class="badge badge-primary text-sm" x-text="role.name"></span>
                        </template>
                        <span x-show="!user.roles || user.roles.length === 0" class="text-text-secondary">Tidak ada role</span>
                    </div>
                    <div class="mt-4 pt-4 border-t border-light-border dark:border-dark-border">
                        <a :href="`/developer/roles/${user.id}/assign`" class="btn btn-ghost btn-sm">
                            Kelola Roles →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Quick Actions</h3>
                </div>
                <div class="card-body space-y-2">
                    <button @click="toggleStatus" class="btn btn-outline w-full text-sm">
                        <span x-text="user.is_active ? '🔴 Nonaktifkan User' : '🟢 Aktifkan User'"></span>
                    </button>
                    <button @click="resetPassword" class="btn btn-outline w-full text-sm">
                        🔑 Reset Password
                    </button>
                    <button @click="sendVerification" class="btn btn-outline w-full text-sm">
                        📧 Kirim Ulang Verifikasi
                    </button>
                    <button @click="deleteUser" class="btn btn-danger w-full text-sm" x-show="user.id !== {{ auth()->id() }}">
                        🗑️ Hapus User
                    </button>
                </div>
            </div>
        </div>

        <!-- Activity Log -->
        <div class="card mt-6">
            <div class="card-header flex justify-between items-center">
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Aktivitas Terbaru</h3>
                <span class="text-xs text-text-secondary">5 aktivitas terakhir</span>
            </div>
            <div class="card-body">
                <div class="space-y-3">
                    <template x-for="activity in activities" :key="activity.id">
                        <div class="flex items-start gap-3 pb-3 border-b border-light-border dark:border-dark-border last:border-0">
                            <div class="w-8 h-8 bg-accent/10 rounded-full flex items-center justify-center">
                                <span class="text-accent text-sm" x-text="getActivityIcon(activity.type)"></span>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-text-primary dark:text-text-dark-primary" x-text="activity.description"></p>
                                <p class="text-xs text-text-secondary" x-text="formatDate(activity.created_at)"></p>
                            </div>
                        </div>
                    </template>
                    <div x-show="activities.length === 0" class="text-center text-text-secondary py-4">
                        Belum ada aktivitas
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
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
                            User <span class="font-medium text-text-primary dark:text-text-dark-primary" x-text="user?.name"></span> akan dihapus permanen.
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

    <!-- Error State -->
    <div x-show="!loading && !user" class="text-center py-12">
        <svg class="w-16 h-16 mx-auto text-text-secondary/50 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        <p class="text-text-secondary">User tidak ditemukan</p>
        <a href="{{ route('developer.users.index') }}" class="btn btn-ghost btn-sm">Kembali ke daftar user</a>
    </div>
</div>

@push('scripts')
<script>
function userDetail() {
    return {
        user: null,
        activities: [],
        loading: true,
        showDeleteModal: false,
        userId: {{ $id ?? 0 }},

        init() {
            this.loadUser();
        },

        async loadUser() {
            this.loading = true;
            try {
                const response = await axios.get(`/api/developer/users/${this.userId}`);
                if (response.data.success) {
                    this.user = response.data.data;
                    this.activities = response.data.activities || [];
                }
            } catch (error) {
                console.error('Failed to load user:', error);
                window.showToast('Gagal memuat data user', 'error');
            }
            this.loading = false;
        },

        async toggleStatus() {
            const action = this.user.is_active ? 'nonaktifkan' : 'aktifkan';
            if (!confirm(`Yakin ingin ${action} user "${this.user.name}"?`)) return;

            try {
                const response = await axios.post(`/api/developer/users/${this.userId}/toggle-status`);
                if (response.data.success) {
                    this.user.is_active = !this.user.is_active;
                    window.showToast(`User berhasil ${action}`, 'success');
                }
            } catch (error) {
                window.showToast('Gagal mengubah status user', 'error');
            }
        },

        async resetPassword() {
            if (!confirm(`Reset password untuk user "${this.user.name}"?`)) return;
            
            try {
                const response = await axios.post(`/api/developer/users/${this.userId}/reset-password`);
                if (response.data.success) {
                    window.showToast(`Password reset berhasil. Password baru: ${response.data.password}`, 'success');
                }
            } catch (error) {
                window.showToast('Gagal reset password', 'error');
            }
        },

        async sendVerification() {
            try {
                const response = await axios.post(`/api/developer/users/${this.userId}/send-verification`);
                if (response.data.success) {
                    window.showToast('Email verifikasi berhasil dikirim', 'success');
                }
            } catch (error) {
                window.showToast('Gagal mengirim email verifikasi', 'error');
            }
        },

        deleteUser() {
            this.showDeleteModal = true;
        },

        async confirmDelete() {
            try {
                const response = await axios.delete(`/api/developer/users/${this.userId}`);
                if (response.data.success) {
                    this.showDeleteModal = false;
                    window.showToast('User berhasil dihapus', 'success');
                    setTimeout(() => {
                        window.location.href = '{{ route("developer.users.index") }}';
                    }, 1500);
                }
            } catch (error) {
                window.showToast('Gagal menghapus user', 'error');
            }
        },

        getInitials(name) {
            if (!name) return '?';
            return name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
        },

        getActivityIcon(type) {
            const icons = {
                'login': '🔑',
                'logout': '🚪',
                'create': '📝',
                'update': '✏️',
                'delete': '🗑️',
                'status_change': '🔄',
                'role_change': '🎭'
            };
            return icons[type] || '📌';
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