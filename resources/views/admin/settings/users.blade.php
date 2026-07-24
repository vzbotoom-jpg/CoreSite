{{-- resources/views/admin/settings/users.blade.php --}}
@extends('layouts.app')

@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')

@section('content')
<div class="max-w-6xl mx-auto" x-data="userManager()" x-init="init()">
    <!-- Header -->
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <div>
            <p class="text-text-secondary dark:text-text-dark-secondary">Kelola user yang memiliki akses ke toko Anda</p>
        </div>
        <button @click="openUserModal()" class="btn btn-primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
            Tambah User
        </button>
    </div>
    
    <!-- Users Table -->
    <div class="card">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-light-border dark:border-dark-border">
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">User</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Email</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Role</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Status</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Terdaftar</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="user in users" :key="user.id">
                        <tr class="border-b border-light-border dark:border-dark-border hover:bg-light-surface dark:hover:bg-dark-surface/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-accent/10 rounded-full flex items-center justify-center">
                                        <span class="text-accent font-semibold text-sm" x-text="getInitials(user.name)"></span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="user.name"></p>
                                        <p class="text-xs text-text-secondary dark:text-text-dark-secondary" x-show="user.id === {{ auth()->id() }}">(Anda)</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-text-primary dark:text-text-dark-primary" x-text="user.email"></td>
                            <td class="px-6 py-4">
                                <span :class="user.role === 'admin' ? 'badge-primary' : 'badge-secondary'" class="badge">
                                    <span x-text="user.role === 'admin' ? 'Admin' : 'Staff'"></span>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span :class="user.is_active ? 'badge-success' : 'badge-error'" class="badge">
                                    <span x-text="user.is_active ? 'Aktif' : 'Nonaktif'"></span>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-text-secondary dark:text-text-dark-secondary" x-text="formatDate(user.created_at)"></td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <button @click="openUserModal(user)" class="text-info hover:text-info/80 transition-colors" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <button @click="toggleUserStatus(user)" class="text-warning hover:text-warning/80 transition-colors" title="Toggle Status" x-show="user.id !== {{ auth()->id() }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                        </svg>
                                    </button>
                                    <button @click="deleteUser(user)" class="text-error hover:text-error/80 transition-colors" title="Hapus" x-show="user.id !== {{ auth()->id() }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="users.length === 0 && !loading">
                        <td colspan="6" class="px-6 py-12 text-center text-text-secondary dark:text-text-dark-secondary">
                            <svg class="w-12 h-12 mx-auto mb-3 text-text-secondary/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <p>Belum ada user. Klik "Tambah User" untuk menambahkan.</p>
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
    </div>
    
    <!-- User Modal -->
    <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" @click.away="closeModal">
        <div class="card w-full max-w-md mx-4 max-h-[90vh] overflow-y-auto" @click.stop>
            <div class="card-header flex justify-between items-center">
                <h3 class="text-xl font-bold text-text-primary dark:text-text-dark-primary" x-text="modalTitle"></h3>
                <button @click="closeModal" class="text-text-secondary hover:text-text-primary transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="card-body">
                <form @submit.prevent="saveUser">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Nama Lengkap *</label>
                            <input type="text" x-model="form.name" required class="input" placeholder="Nama user">
                            <p x-show="formErrors.name" class="text-error text-sm mt-1" x-text="formErrors.name"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Email *</label>
                            <input type="email" x-model="form.email" required :readonly="form.id" class="input" placeholder="email@example.com">
                            <p x-show="formErrors.email" class="text-error text-sm mt-1" x-text="formErrors.email"></p>
                        </div>
                        <div x-show="!form.id">
                            <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Password *</label>
                            <input type="password" x-model="form.password" required minlength="8" class="input" placeholder="Minimal 8 karakter">
                            <p class="text-xs text-text-secondary dark:text-text-dark-secondary mt-1">Minimal 8 karakter</p>
                            <p x-show="formErrors.password" class="text-error text-sm mt-1" x-text="formErrors.password"></p>
                        </div>
                        <div x-show="form.id">
                            <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Password Baru (opsional)</label>
                            <input type="password" x-model="form.new_password" minlength="8" class="input" placeholder="Kosongkan jika tidak ingin mengubah">
                            <p class="text-xs text-text-secondary dark:text-text-dark-secondary mt-1">Minimal 8 karakter</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Role *</label>
                            <select x-model="form.role" class="input">
                                <option value="admin">Admin</option>
                                <option value="staff">Staff</option>
                            </select>
                        </div>
                        <div>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" x-model="form.is_active" class="w-4 h-4 rounded border-gray-300 text-accent focus:ring-accent">
                                <span class="text-sm text-text-primary dark:text-text-dark-primary">User Aktif</span>
                            </label>
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
</div>

@push('scripts')
<script>
function userManager() {
    return {
        users: [],
        loading: false,
        showModal: false,
        modalTitle: '',
        form: {
            id: null,
            name: '',
            email: '',
            password: '',
            new_password: '',
            role: 'staff',
            is_active: true
        },
        formErrors: {},
        
        init() {
            this.loadUsers();
        },
        
        async loadUsers() {
            this.loading = true;
            try {
                const response = await axios.get('/admin/settings/users-data');
                if (response.data.success) {
                    this.users = response.data.data;
                }
            } catch (error) {
                console.error('Failed to load users:', error);
                window.showToast('Gagal memuat user', 'error');
            }
            this.loading = false;
        },
        
        openUserModal(user = null) {
            this.formErrors = {};
            if (user) {
                this.modalTitle = 'Edit User';
                this.form = {
                    id: user.id,
                    name: user.name,
                    email: user.email,
                    password: '',
                    new_password: '',
                    role: user.role,
                    is_active: user.is_active
                };
            } else {
                this.modalTitle = 'Tambah User Baru';
                this.form = {
                    id: null,
                    name: '',
                    email: '',
                    password: '',
                    new_password: '',
                    role: 'staff',
                    is_active: true
                };
            }
            this.showModal = true;
        },
        
        closeModal() {
            this.showModal = false;
            this.formErrors = {};
        },
        
        async saveUser() {
            this.formErrors = {};
            
            try {
                const url = this.form.id ? `/admin/settings/users/${this.form.id}` : '/admin/settings/users';
                const method = this.form.id ? 'PUT' : 'POST';
                
                const data = {
                    name: this.form.name,
                    email: this.form.email,
                    role: this.form.role,
                    is_active: this.form.is_active
                };
                
                if (this.form.id && this.form.new_password) {
                    data.password = this.form.new_password;
                }
                
                if (!this.form.id) {
                    data.password = this.form.password;
                }
                
                const response = await axios({
                    method: method,
                    url: url,
                    data: data
                });
                
                if (response.data.success) {
                    this.closeModal();
                    this.loadUsers();
                    window.showToast(this.form.id ? 'User berhasil diupdate' : 'User berhasil ditambahkan', 'success');
                }
            } catch (error) {
                if (error.response?.data?.errors) {
                    this.formErrors = error.response.data.errors;
                } else {
                    window.showToast(error.response?.data?.message || 'Gagal menyimpan user', 'error');
                }
            }
        },
        
        async toggleUserStatus(user) {
            const action = user.is_active ? 'nonaktifkan' : 'aktifkan';
            if (!confirm(`Yakin ingin ${action} user "${user.name}"?`)) return;
            
            try {
                const response = await axios.post(`/admin/settings/users/${user.id}/toggle-status`);
                if (response.data.success) {
                    this.loadUsers();
                    window.showToast(`User berhasil ${action}`, 'success');
                }
            } catch (error) {
                window.showToast(error.response?.data?.message || 'Gagal mengubah status user', 'error');
            }
        },
        
        async deleteUser(user) {
            if (!confirm(`Hapus user "${user.name}"?`)) return;
            
            try {
                const response = await axios.delete(`/admin/settings/users/${user.id}`);
                if (response.data.success) {
                    this.loadUsers();
                    window.showToast('User berhasil dihapus', 'success');
                }
            } catch (error) {
                window.showToast(error.response?.data?.message || 'Gagal menghapus user', 'error');
            }
        },
        
        getInitials(name) {
            if (!name) return '?';
            return name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
        },
        
        formatDate(date) {
            const d = new Date(date);
            return d.toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' });
        }
    }
}
</script>
@endpush
@endsection