{{-- resources/views/developer/roles.blade.php --}}
@extends('layouts.app')

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

    <!-- Roles Grid -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        <template x-for="role in roles" :key="role.id">
            <div class="card hover:shadow-lg transition group">
                <div class="card-body">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-bold text-text-primary dark:text-text-dark-primary" x-text="role.name"></h3>
                            <p class="text-xs text-text-secondary dark:text-text-dark-secondary" x-text="role.slug"></p>
                        </div>
                        <div class="flex gap-1">
                            <button @click="editRole(role)" class="text-info hover:text-info/80 transition p-1" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            <button @click="deleteRole(role)" class="text-error hover:text-error/80 transition p-1" title="Hapus" x-show="role.slug !== 'developer'">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary mb-4" x-text="role.description || 'Tidak ada deskripsi'"></p>

                    <div class="mb-4">
                        <p class="text-xs font-medium text-text-secondary mb-2">Permissions:</p>
                        <div class="flex flex-wrap gap-1">
                            <template x-for="permission in role.permissions" :key="permission.id">
                                <span class="badge badge-secondary text-xs" x-text="permission.name"></span>
                            </template>
                            <span x-show="!role.permissions || role.permissions.length === 0" class="text-xs text-text-secondary">Tidak ada permission</span>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-light-border dark:border-dark-border flex justify-between items-center">
                        <span class="text-xs text-text-secondary">
                            <span x-text="role.users_count || 0"></span> user(s) assigned
                        </span>
                        <span :class="role.is_default ? 'badge-primary' : 'badge-secondary'" class="badge text-xs">
                            <span x-text="role.is_default ? 'Default' : 'Custom'"></span>
                        </span>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- Role Modal -->
    <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" @click.away="closeModal">
        <div class="card w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto" @click.stop>
            <div class="card-header flex justify-between items-center">
                <h3 class="text-xl font-bold text-text-primary dark:text-text-dark-primary" x-text="modalTitle"></h3>
                <button @click="closeModal" class="text-text-secondary hover:text-text-primary">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="card-body">
                <form @submit.prevent="saveRole">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">Nama Role *</label>
                            <input type="text" x-model="form.name" required class="input" placeholder="Nama role">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Slug *</label>
                            <input type="text" x-model="form.slug" required class="input" placeholder="role-slug" :readonly="form.id">
                            <p class="text-xs text-text-secondary mt-1">Identifier unik untuk role</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Deskripsi</label>
                            <textarea x-model="form.description" rows="2" class="input" placeholder="Deskripsi role"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Permissions</label>
                            <div class="grid grid-cols-2 gap-2 max-h-60 overflow-y-auto p-2 border rounded-lg">
                                <template x-for="group in permissionGroups" :key="group">
                                    <div class="col-span-2">
                                        <p class="text-xs font-semibold text-text-secondary uppercase tracking-wider mb-1" x-text="group"></p>
                                        <div class="space-y-1 ml-2">
                                            <template x-for="permission in getPermissionsByGroup(group)" :key="permission.id">
                                                <label class="flex items-center gap-2 cursor-pointer text-sm">
                                                    <input type="checkbox" :value="permission.id" x-model="form.permissions" class="w-3 h-3 rounded border-gray-300 text-accent">
                                                    <span x-text="permission.name"></span>
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
                                <span class="text-sm">Default Role</span>
                            </label>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 mt-6 pt-4 border-t">
                        <button type="button" @click="closeModal" class="btn btn-secondary">Batal</button>
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
        permissionGroups: [],
        loading: false,
        showModal: false,
        modalTitle: '',
        form: {
            id: null,
            name: '',
            slug: '',
            description: '',
            permissions: [],
            is_default: false
        },

        init() {
            this.loadRoles();
            this.permissionGroups = [...new Set(this.permissions.map(p => p.group))];
        },

        async loadRoles() {
            this.loading = true;
            try {
                const response = await axios.get('/api/developer/roles');
                if (response.data.success) {
                    this.roles = response.data.data;
                }
            } catch (error) {
                console.error('Failed to load roles:', error);
                window.showToast('Gagal memuat roles', 'error');
            }
            this.loading = false;
        },

        getPermissionsByGroup(group) {
            return this.permissions.filter(p => p.group === group);
        },

        openCreateModal() {
            this.modalTitle = 'Tambah Role Baru';
            this.form = {
                id: null,
                name: '',
                slug: '',
                description: '',
                permissions: [],
                is_default: false
            };
            this.showModal = true;
        },

        editRole(role) {
            this.modalTitle = 'Edit Role';
            this.form = {
                id: role.id,
                name: role.name,
                slug: role.slug,
                description: role.description || '',
                permissions: role.permissions.map(p => p.id),
                is_default: role.is_default || false
            };
            this.showModal = true;
        },

        async saveRole() {
            try {
                const url = this.form.id ? `/api/developer/roles/${this.form.id}` : '/api/developer/roles';
                const method = this.form.id ? 'PUT' : 'POST';
                
                const response = await axios({
                    method: method,
                    url: url,
                    data: this.form
                });

                if (response.data.success) {
                    this.closeModal();
                    this.loadRoles();
                    window.showToast(this.form.id ? 'Role berhasil diupdate' : 'Role berhasil ditambahkan', 'success');
                }
            } catch (error) {
                window.showToast(error.response?.data?.message || 'Gagal menyimpan role', 'error');
            }
        },

        async deleteRole(role) {
            if (!confirm(`Hapus role "${role.name}"?`)) return;

            try {
                const response = await axios.delete(`/api/developer/roles/${role.id}`);
                if (response.data.success) {
                    this.loadRoles();
                    window.showToast('Role berhasil dihapus', 'success');
                }
            } catch (error) {
                window.showToast('Gagal menghapus role', 'error');
            }
        },

        closeModal() {
            this.showModal = false;
        }
    }
}
</script>
@endpush
@endsection