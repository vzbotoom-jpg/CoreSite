{{-- resources/views/developer/permissions/index.blade.php --}}
@extends('layouts.developer')

@section('title', 'Permission Management')
@section('page-title', 'Permission Management')

@section('content')
<div x-data="permissionManagement()" x-init="init()" class="space-y-6">
    <!-- Header -->
    <div class="flex flex-wrap justify-between items-center gap-4">
        <div>
            <p class="text-text-secondary dark:text-text-dark-secondary">Kelola permissions untuk akses kontrol sistem</p>
        </div>
        <div class="flex gap-3">
            <button @click="openGroupModal" class="btn btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                Buat Group
            </button>
            <button @click="openCreateModal" class="btn btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Permission
            </button>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="card">
            <div class="card-body py-3">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-text-secondary">Total Permissions</p>
                        <p class="text-xl font-bold text-text-primary dark:text-text-dark-primary" x-text="stats.total"></p>
                    </div>
                    <div class="w-10 h-10 bg-warning/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body py-3">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-text-secondary">Total Groups</p>
                        <p class="text-xl font-bold text-info" x-text="stats.groups"></p>
                    </div>
                    <div class="w-10 h-10 bg-info/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-info" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body py-3">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-text-secondary">Assigned to Roles</p>
                        <p class="text-xl font-bold text-success" x-text="stats.assigned"></p>
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
                        <p class="text-xs text-text-secondary">Unassigned</p>
                        <p class="text-xl font-bold text-error" x-text="stats.unassigned"></p>
                    </div>
                    <div class="w-10 h-10 bg-error/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-error" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card">
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <input type="text" x-model="filters.search" @input="debounceSearch" 
                           placeholder="Cari permission..." class="input">
                </div>
                <div>
                    <select x-model="filters.group" @change="loadPermissions" class="input">
                        <option value="">Semua Group</option>
                        <template x-for="group in groups" :key="group">
                            <option :value="group" x-text="group"></option>
                        </template>
                    </select>
                </div>
                <div>
                    <select x-model="filters.status" @change="loadPermissions" class="input">
                        <option value="">Semua Status</option>
                        <option value="assigned">Assigned ke Role</option>
                        <option value="unassigned">Unassigned</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Permissions Grid by Group -->
    <div class="space-y-6">
        <template x-for="group in filteredGroups" :key="group">
            <div class="card">
                <div class="card-header bg-light-surface/50 dark:bg-dark-surface/50">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="font-semibold text-text-primary dark:text-text-dark-primary" x-text="group || 'Uncategorized'"></h3>
                            <p class="text-xs text-text-secondary" x-text="getGroupPermissionCount(group) + ' permissions'"></p>
                        </div>
                        <span class="text-xs text-text-secondary">
                            <span x-text="getGroupAssignedCount(group)"></span> assigned
                        </span>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-light-border dark:border-dark-border">
                                <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Permission</th>
                                <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Slug</th>
                                <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Description</th>
                                <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Roles</th>
                                <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="permission in getGroupPermissions(group)" :key="permission.id">
                                <tr class="border-b border-light-border dark:border-dark-border hover:bg-light-surface/50 transition">
                                    <td class="px-6 py-4">
                                        <span class="font-medium text-text-primary dark:text-text-dark-primary" x-text="permission.name"></span>
                                    </td>
                                    <td class="px-6 py-4 text-text-secondary dark:text-text-dark-secondary" x-text="permission.slug"></td>
                                    <td class="px-6 py-4 text-text-secondary dark:text-text-dark-secondary" x-text="permission.description || '-'"></td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-1">
                                            <template x-for="role in permission.roles" :key="role.id">
                                                <span class="badge badge-primary text-xs" x-text="role.name"></span>
                                            </template>
                                            <span x-show="!permission.roles || permission.roles.length === 0" 
                                                  class="text-xs text-text-secondary">Tidak ada role</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <a :href="`/developer/permissions/${permission.id}`" 
                                               class="text-info hover:text-info/80 transition" title="Detail">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                            <a :href="`/developer/permissions/${permission.id}/edit`" 
                                               class="text-info hover:text-info/80 transition" title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                            <button @click="deletePermission(permission)" 
                                                    class="text-error hover:text-error/80 transition" title="Hapus">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                            <tr x-show="getGroupPermissions(group).length === 0">
                                <td colspan="5" class="px-6 py-8 text-center text-text-secondary dark:text-text-dark-secondary">
                                    Tidak ada permission dalam group ini
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </template>
    </div>

    <!-- Empty State -->
    <div x-show="permissions.length === 0 && !loading" class="text-center py-12">
        <svg class="w-16 h-16 mx-auto text-text-secondary/50 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
        </svg>
        <p class="text-text-secondary dark:text-text-dark-secondary">Belum ada permission</p>
        <button @click="openCreateModal" class="btn btn-ghost btn-sm">
            Tambah permission pertama →
        </button>
    </div>

    <!-- Loading State -->
    <div x-show="loading" class="text-center py-12">
        <div class="spinner mx-auto"></div>
        <p class="text-text-secondary mt-4">Memuat data...</p>
    </div>

    <!-- Create/Edit Permission Modal -->
    <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" @click.away="closeModal">
        <div class="card w-full max-w-md mx-4 max-h-[90vh] overflow-y-auto" @click.stop>
            <div class="card-header flex justify-between items-center">
                <h3 class="text-xl font-bold text-text-primary dark:text-text-dark-primary" x-text="modalTitle"></h3>
                <button @click="closeModal" class="text-text-secondary hover:text-text-primary">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="card-body">
                <form @submit.prevent="savePermission">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Nama Permission *</label>
                            <input type="text" x-model="form.name" required class="input" placeholder="Nama permission">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Slug *</label>
                            <input type="text" x-model="form.slug" required class="input" placeholder="permission-slug" :readonly="form.id">
                            <p class="text-xs text-text-secondary mt-1">Identifier unik untuk permission</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Group</label>
                            <input type="text" x-model="form.group" class="input" placeholder="Nama group (contoh: users, products)">
                            <p class="text-xs text-text-secondary mt-1">Kelompok untuk mengorganisir permissions</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Deskripsi</label>
                            <textarea x-model="form.description" rows="2" class="input" placeholder="Deskripsi permission"></textarea>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-light-border dark:border-dark-border">
                        <button type="button" @click="closeModal" class="btn btn-secondary">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Create Group Modal -->
    <div x-show="showGroupModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" @click.away="closeGroupModal">
        <div class="card w-full max-w-md mx-4" @click.stop>
            <div class="card-header flex justify-between items-center">
                <h3 class="text-xl font-bold text-text-primary dark:text-text-dark-primary">Buat Group Permission</h3>
                <button @click="closeGroupModal" class="text-text-secondary hover:text-text-primary">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="card-body">
                <form @submit.prevent="saveGroup">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Nama Group *</label>
                            <input type="text" x-model="groupForm.name" required class="input" placeholder="Nama group">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Permissions dalam Group</label>
                            <div class="space-y-2 max-h-40 overflow-y-auto border border-light-border dark:border-dark-border rounded-lg p-3">
                                <template x-for="permission in allPermissions" :key="permission.id">
                                    <label class="flex items-center gap-2 cursor-pointer text-sm">
                                        <input type="checkbox" :value="permission.id" x-model="groupForm.permissions" 
                                               class="w-3 h-3 rounded border-gray-300 text-accent">
                                        <span x-text="permission.name"></span>
                                    </label>
                                </template>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-light-border dark:border-dark-border">
                        <button type="button" @click="closeGroupModal" class="btn btn-secondary">Batal</button>
                        <button type="submit" class="btn btn-primary">Buat Group</button>
                    </div>
                </form>
            </div>
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
                        Permission <span class="font-medium text-text-primary dark:text-text-dark-primary" x-text="deleteData?.name"></span> akan dihapus permanen.
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
function permissionManagement() {
    return {
        permissions: [],
        allPermissions: [],
        groups: [],
        loading: false,
        stats: {
            total: 0,
            groups: 0,
            assigned: 0,
            unassigned: 0
        },
        filters: {
            search: '',
            group: '',
            status: ''
        },
        searchTimeout: null,
        showModal: false,
        showGroupModal: false,
        showDeleteModal: false,
        modalTitle: '',
        deleteData: null,
        form: {
            id: null,
            name: '',
            slug: '',
            group: '',
            description: ''
        },
        groupForm: {
            name: '',
            permissions: []
        },

        init() {
            this.loadPermissions();
        },

        async loadPermissions() {
            this.loading = true;
            const params = new URLSearchParams({
                search: this.filters.search,
                group: this.filters.group,
                status: this.filters.status
            });

            try {
                const response = await axios.get(`/api/developer/permissions?${params}`);
                if (response.data.success) {
                    this.permissions = response.data.data;
                    this.allPermissions = response.data.all || response.data.data;
                    this.groups = response.data.groups || [];
                    this.stats = response.data.stats || this.stats;
                }
            } catch (error) {
                console.error('Failed to load permissions:', error);
                window.showToast('Gagal memuat permissions', 'error');
            }
            this.loading = false;
        },

        get filteredGroups() {
            return this.groups.length > 0 ? this.groups : ['Uncategorized'];
        },

        getGroupPermissions(group) {
            return this.permissions.filter(p => (p.group || 'Uncategorized') === group);
        },

        getGroupPermissionCount(group) {
            return this.getGroupPermissions(group).length;
        },

        getGroupAssignedCount(group) {
            return this.getGroupPermissions(group).filter(p => p.roles && p.roles.length > 0).length;
        },

        debounceSearch() {
            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(() => {
                this.loadPermissions();
            }, 300);
        },

        openCreateModal() {
            this.modalTitle = 'Tambah Permission Baru';
            this.form = {
                id: null,
                name: '',
                slug: '',
                group: '',
                description: ''
            };
            this.showModal = true;
        },

        openEditModal(permission) {
            this.modalTitle = 'Edit Permission';
            this.form = {
                id: permission.id,
                name: permission.name,
                slug: permission.slug,
                group: permission.group || '',
                description: permission.description || ''
            };
            this.showModal = true;
        },

        openGroupModal() {
            this.groupForm = {
                name: '',
                permissions: []
            };
            this.showGroupModal = true;
        },

        closeModal() {
            this.showModal = false;
        },

        closeGroupModal() {
            this.showGroupModal = false;
        },

        async savePermission() {
            try {
                const url = this.form.id ? `/api/developer/permissions/${this.form.id}` : '/api/developer/permissions';
                const method = this.form.id ? 'PUT' : 'POST';
                
                const response = await axios({
                    method: method,
                    url: url,
                    data: this.form
                });

                if (response.data.success) {
                    this.closeModal();
                    this.loadPermissions();
                    window.showToast(this.form.id ? 'Permission berhasil diupdate' : 'Permission berhasil ditambahkan', 'success');
                }
            } catch (error) {
                window.showToast(error.response?.data?.message || 'Gagal menyimpan permission', 'error');
            }
        },

        async saveGroup() {
            try {
                const response = await axios.post('/api/developer/permissions/groups', this.groupForm);
                if (response.data.success) {
                    this.closeGroupModal();
                    this.loadPermissions();
                    window.showToast('Group berhasil dibuat', 'success');
                }
            } catch (error) {
                window.showToast(error.response?.data?.message || 'Gagal membuat group', 'error');
            }
        },

        deletePermission(permission) {
            this.deleteData = permission;
            this.showDeleteModal = true;
        },

        async confirmDelete() {
            if (!this.deleteData) return;

            try {
                const response = await axios.delete(`/api/developer/permissions/${this.deleteData.id}`);
                if (response.data.success) {
                    this.showDeleteModal = false;
                    this.deleteData = null;
                    this.loadPermissions();
                    window.showToast('Permission berhasil dihapus', 'success');
                }
            } catch (error) {
                window.showToast('Gagal menghapus permission', 'error');
            }
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