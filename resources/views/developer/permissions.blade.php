{{-- resources/views/developer/permissions.blade.php --}}
@extends('layouts.app')

@section('title', 'Permission Management')
@section('page-title', 'Permission Management')

@section('content')
<div x-data="permissionManagement()" x-init="init()" class="space-y-6">
    <!-- Header -->
    <div class="flex flex-wrap justify-between items-center gap-4">
        <div>
            <p class="text-text-secondary dark:text-text-dark-secondary">Kelola permissions untuk akses kontrol</p>
        </div>
        <button @click="openCreateModal" class="btn btn-primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Permission
        </button>
    </div>

    <!-- Permissions Table -->
    <div class="card">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-light-border dark:border-dark-border">
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Permission</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Slug</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Group</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Roles</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="permission in permissions" :key="permission.id">
                        <tr class="border-b border-light-border dark:border-dark-border hover:bg-light-surface/50 transition">
                            <td class="px-6 py-4">
                                <span class="font-medium text-text-primary dark:text-text-dark-primary" x-text="permission.name"></span>
                            </td>
                            <td class="px-6 py-4 text-text-secondary dark:text-text-dark-secondary" x-text="permission.slug"></td>
                            <td class="px-6 py-4">
                                <span class="badge badge-secondary" x-text="permission.group || 'Uncategorized'"></span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    <template x-for="role in permission.roles" :key="role.id">
                                        <span class="badge badge-primary text-xs" x-text="role.name"></span>
                                    </template>
                                    <span x-show="!permission.roles || permission.roles.length === 0" class="text-xs text-text-secondary">-</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <button @click="editPermission(permission)" class="text-info hover:text-info/80 transition" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <button @click="deletePermission(permission)" class="text-error hover:text-error/80 transition" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="permissions.length === 0 && !loading">
                        <td colspan="5" class="px-6 py-12 text-center text-text-secondary dark:text-text-dark-secondary">
                            <svg class="w-12 h-12 mx-auto mb-3 text-text-secondary/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <p>Belum ada permission</p>
                        </td>
                    </tr>
                    <tr x-show="loading">
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="spinner mx-auto"></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div x-show="lastPage > 1" class="card-footer">
            <div class="flex justify-between items-center">
                <div class="text-sm text-text-secondary dark:text-text-dark-secondary">
                    Menampilkan <span x-text="from"></span> - <span x-text="to"></span> dari <span x-text="total"></span> permission
                </div>
                <div class="flex gap-2">
                    <button @click="prevPage" :disabled="currentPage === 1" class="px-3 py-1 border rounded hover:bg-light-surface disabled:opacity-50">Sebelumnya</button>
                    <span class="px-3 py-1 text-text-secondary">Halaman <span x-text="currentPage"></span> dari <span x-text="lastPage"></span></span>
                    <button @click="nextPage" :disabled="currentPage === lastPage" class="px-3 py-1 border rounded hover:bg-light-surface disabled:opacity-50">Selanjutnya</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Permission Modal -->
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
                            <label class="block text-sm font-medium mb-2">Nama Permission *</label>
                            <input type="text" x-model="form.name" required class="input" placeholder="Nama permission">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Slug *</label>
                            <input type="text" x-model="form.slug" required class="input" placeholder="permission-slug" :readonly="form.id">
                            <p class="text-xs text-text-secondary mt-1">Identifier unik untuk permission</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Group</label>
                            <input type="text" x-model="form.group" class="input" placeholder="Nama group (contoh: users, products, etc)">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Deskripsi</label>
                            <textarea x-model="form.description" rows="2" class="input" placeholder="Deskripsi permission"></textarea>
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
function permissionManagement() {
    return {
        permissions: [],
        loading: false,
        currentPage: 1,
        lastPage: 1,
        total: 0,
        from: 0,
        to: 0,
        showModal: false,
        modalTitle: '',
        form: {
            id: null,
            name: '',
            slug: '',
            group: '',
            description: ''
        },

        init() {
            this.loadPermissions();
        },

        async loadPermissions() {
            this.loading = true;
            const params = new URLSearchParams({
                page: this.currentPage
            });

            try {
                const response = await axios.get(`/developer/permissions/data?${params}`);
                if (response.data.success) {
                    this.permissions = response.data.data.data;
                    this.currentPage = response.data.data.current_page;
                    this.lastPage = response.data.data.last_page;
                    this.total = response.data.data.total;
                    this.from = response.data.data.from;
                    this.to = response.data.data.to;
                }
            } catch (error) {
                console.error('Failed to load permissions:', error);
                window.showToast('Gagal memuat permissions', 'error');
            }
            this.loading = false;
        },

        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
                this.loadPermissions();
            }
        },

        nextPage() {
            if (this.currentPage < this.lastPage) {
                this.currentPage++;
                this.loadPermissions();
            }
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

        editPermission(permission) {
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

        async savePermission() {
            try {
                const url = this.form.id ? `/developer/permissions/${this.form.id}` : '/developer/permissions';
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

        async deletePermission(permission) {
            if (!confirm(`Hapus permission "${permission.name}"?`)) return;

            try {
                const response = await axios.delete(`/developer/permissions/${permission.id}`);
                if (response.data.success) {
                    this.loadPermissions();
                    window.showToast('Permission berhasil dihapus', 'success');
                }
            } catch (error) {
                window.showToast('Gagal menghapus permission', 'error');
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