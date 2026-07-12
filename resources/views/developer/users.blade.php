{{-- resources/views/developer/users.blade.php --}}
@extends('layouts.app')

@section('title', 'User Management')
@section('page-title', 'User Management')

@section('content')
<div x-data="userManagement()" x-init="init()" class="space-y-6">
    <!-- Header -->
    <div class="flex flex-wrap justify-between items-center gap-4">
        <div>
            <p class="text-text-secondary dark:text-text-dark-secondary">Kelola semua user di sistem</p>
        </div>
        <button @click="openCreateModal" class="btn btn-primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah User
        </button>
    </div>

    <!-- Filters -->
    <div class="card">
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <input type="text" x-model="filters.search" @input="debounceSearch" 
                           placeholder="Cari user..." class="input">
                </div>
                <div>
                    <select x-model="filters.role" @change="loadUsers" class="input">
                        <option value="">Semua Role</option>
                        <template x-for="role in roles" :key="role.id">
                            <option :value="role.slug" x-text="role.name"></option>
                        </template>
                    </select>
                </div>
                <div>
                    <select x-model="filters.status" @change="loadUsers" class="input">
                        <option value="">Semua Status</option>
                        <option value="active">Aktif</option>
                        <option value="inactive">Nonaktif</option>
                    </select>
                </div>
                <div>
                    <select x-model="filters.store" @change="loadUsers" class="input">
                        <option value="">Semua Toko</option>
                        <template x-for="store in stores" :key="store.id">
                            <option :value="store.id" x-text="store.name"></option>
                        </template>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-light-border dark:border-dark-border">
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">User</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Email</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Toko</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Roles</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Status</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Last Login</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="user in users" :key="user.id">
                        <tr class="border-b border-light-border dark:border-dark-border hover:bg-light-surface/50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-accent/10 rounded-full flex items-center justify-center">
                                        <span class="text-accent font-semibold text-sm" x-text="getInitials(user.name)"></span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="user.name"></p>
                                        <p class="text-xs text-text-secondary dark:text-text-dark-secondary" x-text="user.id === {{ auth()->id() }} ? '(Anda)' : ''"></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-text-primary dark:text-text-dark-primary" x-text="user.email"></td>
                            <td class="px-6 py-4 text-text-primary dark:text-text-dark-primary" x-text="user.store?.name || '-'"></td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    <template x-for="role in user.roles" :key="role.id">
                                        <span class="badge badge-primary" x-text="role.name"></span>
                                    </template>
                                    <span x-show="!user.roles || user.roles.length === 0" class="text-xs text-text-secondary">-</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span :class="user.is_active ? 'badge-success' : 'badge-error'" class="badge">
                                    <span x-text="user.is_active ? 'Aktif' : 'Nonaktif'"></span>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-text-secondary dark:text-text-dark-secondary" x-text="formatDate(user.last_login_at)"></td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <button @click="editUser(user)" class="text-info hover:text-info/80 transition" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <button @click="toggleUserStatus(user)" class="text-warning hover:text-warning/80 transition" title="Toggle Status">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                        </svg>
                                    </button>
                                    <button @click="deleteUser(user)" class="text-error hover:text-error/80 transition" title="Hapus" x-show="user.id !== {{ auth()->id() }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="users.length === 0 && !loading">
                        <td colspan="7" class="px-6 py-12 text-center text-text-secondary dark:text-text-dark-secondary">
                            <svg class="w-12 h-12 mx-auto mb-3 text-text-secondary/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <p>Belum ada user</p>
                        </td>
                    </tr>
                    <tr x-show="loading">
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="spinner mx-auto"></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div x-show="lastPage > 1" class="card-footer">
            <div class="flex justify-between items-center">
                <div class="text-sm text-text-secondary dark:text-text-dark-secondary">
                    Menampilkan <span x-text="from"></span> - <span x-text="to"></span> dari <span x-text="total"></span> user
                </div>
                <div class="flex gap-2">
                    <button @click="prevPage" :disabled="currentPage === 1" class="px-3 py-1 border rounded hover:bg-light-surface disabled:opacity-50">Sebelumnya</button>
                    <span class="px-3 py-1 text-text-secondary">Halaman <span x-text="currentPage"></span> dari <span x-text="lastPage"></span></span>
                    <button @click="nextPage" :disabled="currentPage === lastPage" class="px-3 py-1 border rounded hover:bg-light-surface disabled:opacity-50">Selanjutnya</button>
                </div>
            </div>
        </div>
    </div>

    <!-- User Modal -->
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
                <form @submit.prevent="saveUser">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">Nama Lengkap *</label>
                            <input type="text" x-model="form.name" required class="input" placeholder="Nama user">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Email *</label>
                            <input type="email" x-model="form.email" required :readonly="form.id" class="input" placeholder="email@example.com">
                        </div>
                        <div x-show="!form.id">
                            <label class="block text-sm font-medium mb-2">Password *</label>
                            <input type="password" x-model="form.password" required minlength="8" class="input" placeholder="Minimal 8 karakter">
                        </div>
                        <div x-show="form.id">
                            <label class="block text-sm font-medium mb-2">Password Baru (opsional)</label>
                            <input type="password" x-model="form.new_password" minlength="8" class="input" placeholder="Kosongkan jika tidak ingin mengubah">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Toko *</label>
                            <select x-model="form.store_id" required class="input">
                                <option value="">Pilih Toko</option>
                                <template x-for="store in stores" :key="store.id">
                                    <option :value="store.id" x-text="store.name"></option>
                                </template>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Roles</label>
                            <div class="space-y-2">
                                <template x-for="role in roles" :key="role.id">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" :value="role.id" x-model="form.roles" class="w-4 h-4 rounded border-gray-300 text-accent">
                                        <span class="text-sm" x-text="role.name"></span>
                                    </label>
                                </template>
                            </div>
                        </div>
                        <div>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" x-model="form.is_active" class="w-4 h-4 rounded border-gray-300 text-accent">
                                <span class="text-sm">User Aktif</span>
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
function userManagement() {
    return {
        users: [],
        roles: @json($roles ?? []),
        stores: @json($stores ?? []),
        loading: false,
        currentPage: 1,
        lastPage: 1,
        total: 0,
        from: 0,
        to: 0,
        filters: {
            search: '',
            role: '',
            status: '',
            store: ''
        },
        showModal: false,
        modalTitle: '',
        form: {
            id: null,
            name: '',
            email: '',
            password: '',
            new_password: '',
            store_id: '',
            roles: [],
            is_active: true
        },
        searchTimeout: null,

        init() {
            this.loadUsers();
        },

        async loadUsers() {
            this.loading = true;
            const params = new URLSearchParams({
                page: this.currentPage,
                search: this.filters.search,
                role: this.filters.role,
                status: this.filters.status,
                store: this.filters.store
            });

            try {
                const response = await axios.get(`/api/developer/users?${params}`);
                if (response.data.success) {
                    this.users = response.data.data.data;
                    this.currentPage = response.data.data.current_page;
                    this.lastPage = response.data.data.last_page;
                    this.total = response.data.data.total;
                    this.from = response.data.data.from;
                    this.to = response.data.data.to;
                }
            } catch (error) {
                console.error('Failed to load users:', error);
                window.showToast('Gagal memuat user', 'error');
            }
            this.loading = false;
        },

        debounceSearch() {
            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(() => {
                this.currentPage = 1;
                this.loadUsers();
            }, 300);
        },

        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
                this.loadUsers();
            }
        },

        nextPage() {
            if (this.currentPage < this.lastPage) {
                this.currentPage++;
                this.loadUsers();
            }
        },

        openCreateModal() {
            this.modalTitle = 'Tambah User Baru';
            this.form = {
                id: null,
                name: '',
                email: '',
                password: '',
                new_password: '',
                store_id: '',
                roles: [],
                is_active: true
            };
            this.showModal = true;
        },

        editUser(user) {
            this.modalTitle = 'Edit User';
            this.form = {
                id: user.id,
                name: user.name,
                email: user.email,
                password: '',
                new_password: '',
                store_id: user.store_id,
                roles: user.roles.map(r => r.id),
                is_active: user.is_active
            };
            this.showModal = true;
        },

        async saveUser() {
            try {
                const url = this.form.id ? `/api/developer/users/${this.form.id}` : '/api/developer/users';
                const method = this.form.id ? 'PUT' : 'POST';
                
                const response = await axios({
                    method: method,
                    url: url,
                    data: this.form
                });

                if (response.data.success) {
                    this.closeModal();
                    this.loadUsers();
                    window.showToast(this.form.id ? 'User berhasil diupdate' : 'User berhasil ditambahkan', 'success');
                }
            } catch (error) {
                window.showToast(error.response?.data?.message || 'Gagal menyimpan user', 'error');
            }
        },

        async toggleUserStatus(user) {
            const action = user.is_active ? 'nonaktifkan' : 'aktifkan';
            if (!confirm(`Yakin ingin ${action} user "${user.name}"?`)) return;

            try {
                const response = await axios.post(`/api/developer/users/${user.id}/toggle-status`);
                if (response.data.success) {
                    this.loadUsers();
                    window.showToast(`User berhasil ${action}`, 'success');
                }
            } catch (error) {
                window.showToast('Gagal mengubah status user', 'error');
            }
        },

        async deleteUser(user) {
            if (!confirm(`Hapus user "${user.name}"?`)) return;

            try {
                const response = await axios.delete(`/api/developer/users/${user.id}`);
                if (response.data.success) {
                    this.loadUsers();
                    window.showToast('User berhasil dihapus', 'success');
                }
            } catch (error) {
                window.showToast('Gagal menghapus user', 'error');
            }
        },

        closeModal() {
            this.showModal = false;
        },

        getInitials(name) {
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