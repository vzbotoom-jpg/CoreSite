{{-- resources/views/developer/roles/index.blade.php --}}
@extends('layouts.developer')

@section('title', 'Role Management')
@section('page-title', 'Role Management')

@section('content')
<div x-data="roleManagement()" x-init="init()" class="space-y-6">
    <!-- Header -->
    <div class="flex flex-wrap justify-between items-center gap-4">
        <div>
            <p class="text-text-secondary dark:text-text-dark-secondary">Kelola roles dan permissions di sistem</p>
        </div>
        <button @click="openCreateModal" class="btn btn-primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Role
        </button>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="card">
            <div class="card-body py-3">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-text-secondary">Total Roles</p>
                        <p class="text-xl font-bold text-text-primary dark:text-text-dark-primary" x-text="stats.total"></p>
                    </div>
                    <div class="w-10 h-10 bg-info/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-info" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body py-3">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-text-secondary">System Roles</p>
                        <p class="text-xl font-bold text-primary" x-text="stats.system"></p>
                    </div>
                    <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body py-3">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-text-secondary">Custom Roles</p>
                        <p class="text-xl font-bold text-warning" x-text="stats.custom"></p>
                    </div>
                    <div class="w-10 h-10 bg-warning/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body py-3">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-text-secondary">Total Permissions</p>
                        <p class="text-xl font-bold text-accent" x-text="stats.permissions"></p>
                    </div>
                    <div class="w-10 h-10 bg-accent/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="card bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border">
        <div class="card-body p-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <input type="text" x-model="filters.search" @input="debounceSearch" 
                           placeholder="Cari role..." class="input">
                </div>
                <div>
                    <select x-model="filters.type" @change="loadRoles" class="input">
                        <option value="">Semua Tipe</option>
                        <option value="system">System Roles</option>
                        <option value="custom">Custom Roles</option>
                    </select>
                </div>
                <div>
                    <select x-model="filters.permission" @change="loadRoles" class="input">
                        <option value="">Semua Permission</option>
                        <template x-for="permission in allPermissions" :key="permission.id">
                            <option :value="permission.id" x-text="permission.name"></option>
                        </template>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Roles Grid -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        <template x-for="role in roles" :key="role.id">
            <div class="card hover:shadow-lg transition group bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border" :class="role.is_default ? 'border-accent/30' : ''">
                <div class="card-body p-5 flex flex-col justify-between h-full">
                    <div>
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="text-base font-bold text-text-primary dark:text-text-dark-primary truncate" x-text="role.name"></h3>
                                    <span x-show="role.is_default" class="badge badge-primary text-[10px] py-0.5 px-1.5 font-bold">Default</span>
                                    <span x-show="role.slug === 'developer' || role.slug === 'super-admin' || role.slug === 'store-owner'" class="badge badge-error text-[10px] py-0.5 px-1.5 font-bold">System</span>
                                </div>
                                <p class="text-xs text-text-secondary dark:text-text-dark-secondary font-mono mt-0.5" x-text="role.slug"></p>
                            </div>
                            <div class="flex gap-1 shrink-0 ml-2">
                                <a :href="`/developer/roles/${role.id}`" class="text-info hover:text-info/80 transition p-1" title="Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a :href="`/developer/roles/${role.id}/edit`" class="text-info hover:text-info/80 transition p-1" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <button @click="deleteRole(role)" class="text-error hover:text-error/80 transition p-1" title="Hapus" x-show="role.slug !== 'developer'">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <p class="text-xs text-text-secondary dark:text-text-dark-secondary mb-4 line-clamp-2 min-h-8" x-text="role.description || 'Tidak ada deskripsi'"></p>

                        <div class="mb-4">
                            <p class="text-[11px] font-bold text-text-secondary uppercase tracking-wider mb-2">Permissions:</p>
                            <div class="flex flex-wrap gap-1 max-h-24 overflow-y-auto">
                                <template x-for="permission in role.permissions" :key="permission.id">
                                    <span class="badge badge-secondary text-[10px] py-0.5 px-1.5 font-medium" x-text="permission.name"></span>
                                </template>
                                <span x-show="!role.permissions || role.permissions.length === 0" class="text-xs text-text-secondary italic">Tidak ada permission</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-light-border dark:border-dark-border flex justify-between items-center mt-4">
                        <span class="text-xs text-text-secondary font-medium">
                            👥 <span x-text="role.users_count || 0"></span> user(s)
                        </span>
                        <span class="text-xs text-text-secondary font-medium">
                            🛡️ <span x-text="role.permissions?.length || 0"></span> permission(s)
                        </span>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- Empty State -->
    <div x-show="roles.length === 0 && !loading" class="text-center py-12">
        <svg class="w-16 h-16 mx-auto text-text-secondary/50 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
        </svg>
        <p class="text-text-secondary dark:text-text-dark-secondary">Belum ada role</p>
        <button @click="openCreateModal" class="btn btn-ghost btn-sm">
            Tambah role pertama →
        </button>
    </div>

    <!-- Loading State -->
    <div x-show="loading" class="text-center py-12">
        <div class="spinner mx-auto"></div>
        <p class="text-text-secondary mt-4">Memuat data...</p>
    </div>

    <!-- Create Role Modal -->
    <div x-show="showCreateModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs" @click.away="closeCreateModal">
        <div class="card w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border" @click.stop>
            <div class="card-header flex justify-between items-center border-b border-light-border dark:border-dark-border pb-4">
                <h3 class="text-lg font-bold text-text-primary dark:text-text-dark-primary">Tambah Role Baru</h3>
                <button @click="closeCreateModal" class="text-text-secondary hover:text-text-primary">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="card-body p-6">
                <form @submit.prevent="saveRole">
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-text-primary dark:text-text-dark-primary mb-2">Nama Role *</label>
                            <input type="text" x-model="form.name" required class="input" placeholder="Nama role">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-text-primary dark:text-text-dark-primary mb-2">Slug *</label>
                            <input type="text" x-model="form.slug" required class="input" placeholder="role-slug">
                            <p class="text-xs text-text-secondary mt-1">Identifier unik untuk role</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-text-primary dark:text-text-dark-primary mb-2">Deskripsi</label>
                            <textarea x-model="form.description" rows="2" class="input" placeholder="Deskripsi role"></textarea>
                        </div>
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <label class="block text-sm font-semibold text-text-primary dark:text-text-dark-primary">Permissions</label>
                                <label class="flex items-center gap-1.5 cursor-pointer text-xs font-bold text-accent hover:underline">
                                    <input type="checkbox" @change="toggleSelectAllPermissions" :checked="isAllPermissionsSelected" class="w-3.5 h-3.5 rounded border-gray-300 text-accent">
                                    Pilih Semua
                                </label>
                            </div>
                            <div class="space-y-4 max-h-60 overflow-y-auto p-3 border border-light-border dark:border-dark-border rounded-lg bg-light-bg/30 dark:bg-dark-bg/20">
                                <template x-for="(perms, groupName) in groupedPermissions" :key="groupName">
                                    <div class="space-y-2">
                                        <h4 class="text-xs font-bold text-accent uppercase tracking-wider border-b border-light-border/60 dark:border-dark-border/40 pb-1" x-text="groupName || 'General'"></h4>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                            <template x-for="permission in perms" :key="permission.id">
                                                <label class="flex items-center gap-2 cursor-pointer text-sm">
                                                    <input type="checkbox" :value="permission.id" x-model="form.permissions" class="w-3 h-3 rounded border-gray-300 text-accent">
                                                    <span class="text-text-primary dark:text-text-dark-primary text-xs" x-text="permission.name"></span>
                                                </label>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                        <div>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" x-model="form.is_default" class="w-4 h-4 rounded border-gray-300 text-accent">
                                <span class="text-sm font-semibold text-text-primary dark:text-text-dark-primary">Default Role</span>
                            </label>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-light-border dark:border-dark-border">
                        <button type="button" @click="closeCreateModal" class="btn btn-secondary">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function roleManagement() {
    return {
        roles: [],
        permissions: @json($permissions ?? []),
        allPermissions: @json($allPermissions ?? []),
        groupedPermissions: @json($permissions), // Grouped permissions mapped from backend
        loading: false,
        stats: {
            total: 0,
            system: 0,
            custom: 0,
            permissions: 0
        },
        filters: {
            search: '',
            type: '',
            permission: ''
        },
        searchTimeout: null,
        showCreateModal: false,
        form: {
            name: '',
            slug: '',
            description: '',
            permissions: [],
            is_default: false,
            slugAuto: true
        },

        init() {
            this.loadRoles();

            // Watch for role name changes and auto-generate slug dynamically
            this.$watch('form.name', value => {
                if (this.form.slugAuto) {
                    this.form.slug = value.toLowerCase()
                        .replace(/[^a-z0-9]+/g, '-')
                        .replace(/^-+|-+$/g, '');
                }
            });
            this.$watch('form.slug', value => {
                const autoGenerated = this.form.name.toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '');
                if (value !== autoGenerated) {
                    this.form.slugAuto = false;
                }
            });
        },

        async loadRoles() {
            this.loading = true;
            const params = new URLSearchParams({
                search: this.filters.search,
                type: this.filters.type,
                permission: this.filters.permission
            });

            try {
                const response = await axios.get(`/developer/roles/data?${params}`);
                if (response.data.success) {
                    this.roles = response.data.data;
                    this.stats = response.data.stats || this.stats;
                }
            } catch (error) {
                console.error('Failed to load roles:', error);
                window.showToast('Gagal memuat roles', 'error');
            }
            this.loading = false;
        },

        debounceSearch() {
            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(() => {
                this.loadRoles();
            }, 300);
        },

        openCreateModal() {
            this.form = {
                name: '',
                slug: '',
                description: '',
                permissions: [],
                is_default: false,
                slugAuto: true
            };
            this.showCreateModal = true;
        },

        closeCreateModal() {
            this.showCreateModal = false;
        },

        async saveRole() {
            try {
                const response = await axios.post('/developer/roles', this.form);
                if (response.data.success) {
                    this.closeCreateModal();
                    this.loadRoles();
                    window.showToast('Role berhasil ditambahkan', 'success');
                }
            } catch (error) {
                window.showToast(error.response?.data?.message || 'Gagal menyimpan role', 'error');
            }
        },

        async deleteRole(role) {
            if (!confirm(`Hapus role "${role.name}"?`)) return;

            try {
                const response = await axios.delete(`/developer/roles/${role.id}`);
                if (response.data.success) {
                    this.loadRoles();
                    window.showToast('Role berhasil dihapus', 'success');
                }
            } catch (error) {
                window.showToast(error.response?.data?.message || 'Gagal menghapus role', 'error');
            }
        },

        toggleSelectAllPermissions(e) {
            if (e.target.checked) {
                this.form.permissions = this.allPermissions.map(p => p.id);
            } else {
                this.form.permissions = [];
            }
        },

        get isAllPermissionsSelected() {
            return this.allPermissions.length > 0 && this.form.permissions.length === this.allPermissions.length;
        },

        formatDate(date) {
            if (!date) return '-';
            return new Date(date).toLocaleDateString('id-ID', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
        }
    }
}
</script>
@endpush
@endsection