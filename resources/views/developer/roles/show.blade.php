  {{-- resources/views/developer/roles/show.blade.php --}}
@extends('layouts.developer')

@section('title', 'Detail Role')
@section('page-title', 'Detail Role')

@section('content')
<div x-data="roleDetail()" x-init="init()" class="max-w-4xl mx-auto">
    <!-- Loading -->
    <div x-show="loading" class="text-center py-12">
        <div class="spinner mx-auto"></div>
        <p class="text-text-secondary mt-4">Memuat data role...</p>
    </div>

    <!-- Role Detail -->
    <div x-show="!loading && role" x-cloak>
        <!-- Header -->
        <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
            <div class="flex items-center gap-4">
                <a href="{{ route('developer.roles.index') }}" class="text-text-secondary hover:text-accent transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h1 class="text-2xl font-bold text-text-primary dark:text-text-dark-primary" x-text="role.name"></h1>
                <span class="badge badge-primary" x-text="role.is_default ? 'Default' : 'Custom'"></span>
                <span x-show="role.slug === 'developer'" class="badge badge-error">System</span>
            </div>
            <div class="flex gap-3">
                <a :href="`/developer/roles/${role.id}/edit`" class="btn btn-primary text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Role
                </a>
            </div>
        </div>

        <!-- Role Info -->
        <div class="grid md:grid-cols-3 gap-6">
            <!-- Info Card -->
            <div class="card md:col-span-1">
                <div class="card-body">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-accent/10 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl font-bold text-accent" x-text="getInitials(role.name)"></span>
                        </div>
                        <h3 class="text-xl font-bold text-text-primary dark:text-text-dark-primary" x-text="role.name"></h3>
                        <p class="text-sm text-text-secondary dark:text-text-dark-secondary" x-text="role.slug"></p>
                        <div class="mt-3 flex justify-center gap-2">
                            <span class="badge badge-primary" x-text="role.is_default ? 'Default' : 'Custom'"></span>
                            <span class="badge badge-secondary" x-text="'ID: ' + role.id"></span>
                        </div>
                        <div class="mt-4 pt-4 border-t border-light-border dark:border-dark-border">
                            <p class="text-sm text-text-secondary">Dibuat</p>
                            <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="formatDate(role.created_at)"></p>
                        </div>
                        <div class="mt-2 pt-2 border-t border-light-border dark:border-dark-border">
                            <p class="text-sm text-text-secondary">Terakhir Update</p>
                            <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="formatDate(role.updated_at)"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Details Card -->
            <div class="card md:col-span-2">
                <div class="card-header">
                    <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Informasi Role</h3>
                </div>
                <div class="card-body space-y-4">
                    <div>
                        <label class="text-sm text-text-secondary">Deskripsi</label>
                        <p class="text-text-primary dark:text-text-dark-primary" x-text="role.description || 'Tidak ada deskripsi'"></p>
                    </div>
                    <div>
                        <label class="text-sm text-text-secondary">Users dengan Role Ini</label>
                        <p class="text-text-primary dark:text-text-dark-primary">
                            <span class="font-bold" x-text="role.users_count || 0"></span> user(s)
                        </p>
                    </div>
                    <div>
                        <label class="text-sm text-text-secondary">Permissions</label>
                        <div class="flex flex-wrap gap-2 mt-2">
                            <template x-for="permission in role.permissions" :key="permission.id">
                                <span class="badge badge-secondary" x-text="permission.name"></span>
                            </template>
                            <span x-show="!role.permissions || role.permissions.length === 0" class="text-text-secondary">Tidak ada permission</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users with this Role -->
        <div class="card mt-6">
            <div class="card-header flex justify-between items-center">
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Users dengan Role Ini</h3>
                <span class="text-xs text-text-secondary" x-text="role.users_count + ' user(s)'"></span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-light-border dark:border-dark-border">
                            <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">User</th>
                            <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Email</th>
                            <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Status</th>
                            <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="user in role.users" :key="user.id">
                            <tr class="border-b border-light-border dark:border-dark-border hover:bg-light-surface/50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-accent/10 rounded-full flex items-center justify-center">
                                            <span class="text-accent font-semibold text-xs" x-text="getInitials(user.name)"></span>
                                        </div>
                                        <span class="font-medium text-text-primary dark:text-text-dark-primary" x-text="user.name"></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-text-primary dark:text-text-dark-primary" x-text="user.email"></td>
                                <td class="px-6 py-4">
                                    <span :class="user.is_active ? 'badge-success' : 'badge-error'" class="badge">
                                        <span x-text="user.is_active ? 'Aktif' : 'Nonaktif'"></span>
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <a :href="`/developer/users/${user.id}`" class="btn btn-ghost btn-sm">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        </template>
                        <tr x-show="!role.users || role.users.length === 0">
                            <td colspan="4" class="px-6 py-8 text-center text-text-secondary dark:text-text-dark-secondary">
                                Belum ada user dengan role ini
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
                            Role <span class="font-medium text-text-primary dark:text-text-dark-primary" x-text="role?.name"></span> akan dihapus permanen.
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
    <div x-show="!loading && !role" class="text-center py-12">
        <svg class="w-16 h-16 mx-auto text-text-secondary/50 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        <p class="text-text-secondary">Role tidak ditemukan</p>
        <a href="{{ route('developer.roles.index') }}" class="btn btn-ghost btn-sm">Kembali ke daftar role</a>
    </div>
</div>

@push('scripts')
<script>
function roleDetail() {
    return {
        role: null,
        loading: true,
        showDeleteModal: false,
        roleId: {{ $id ?? 0 }},

        init() {
            this.loadRole();
        },

        async loadRole() {
            this.loading = true;
            try {
                const response = await axios.get(`/api/developer/roles/${this.roleId}`);
                if (response.data.success) {
                    this.role = response.data.data;
                }
            } catch (error) {
                console.error('Failed to load role:', error);
                window.showToast('Gagal memuat data role', 'error');
            }
            this.loading = false;
        },

        async deleteRole() {
            this.showDeleteModal = true;
        },

        async confirmDelete() {
            try {
                const response = await axios.delete(`/api/developer/roles/${this.roleId}`);
                if (response.data.success) {
                    this.showDeleteModal = false;
                    window.showToast('Role berhasil dihapus', 'success');
                    setTimeout(() => {
                        window.location.href = '{{ route("developer.roles.index") }}';
                    }, 1500);
                }
            } catch (error) {
                window.showToast('Gagal menghapus role', 'error');
            }
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
                minute: '2-digit'
            });
        }
    }
}
</script>
@endpush
@endsection