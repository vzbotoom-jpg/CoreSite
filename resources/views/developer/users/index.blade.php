{{-- resources/views/developer/users/index.blade.php --}}
@extends('layouts.developer')

@section('title', 'User Management')
@section('page-title', 'User Management')

@section('content')
<div x-data="userManagement()" x-init="init()" class="space-y-6">
    <!-- Header -->
    <div class="flex flex-wrap justify-between items-center gap-4">
        <div>
            <p class="text-text-secondary dark:text-text-dark-secondary">Kelola semua user di sistem CoreSite</p>
        </div>
        <div class="flex gap-3">
            <button @click="exportUsers" class="btn btn-secondary gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Export
            </button>
            <button @click="openCreateModal" class="btn btn-primary gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah User
            </button>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="card">
            <div class="card-body py-3">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-text-secondary">Total Users</p>
                        <p class="text-xl font-bold text-text-primary dark:text-text-dark-primary" x-text="stats.total"></p>
                    </div>
                    <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body py-3">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-text-secondary">Active Users</p>
                        <p class="text-xl font-bold text-success" x-text="stats.active"></p>
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
                        <p class="text-xs text-text-secondary">Inactive Users</p>
                        <p class="text-xl font-bold text-error" x-text="stats.inactive"></p>
                    </div>
                    <div class="w-10 h-10 bg-error/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-error" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body py-3">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-text-secondary">Admins</p>
                        <p class="text-xl font-bold text-accent" x-text="stats.admins"></p>
                    </div>
                    <div class="w-10 h-10 bg-accent/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
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
            <div class="flex justify-between items-center mt-4">
                <button @click="resetFilters" class="text-sm text-text-secondary hover:text-accent transition-colors">
                    Reset Filter
                </button>
                <span class="text-sm text-text-secondary" x-text="`${filteredCount} user ditemukan`"></span>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-light-border dark:border-dark-border">
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">
                            <button @click="sortBy('name')" class="flex items-center gap-1 hover:text-accent">
                                User
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                </svg>
                            </button>
                        </th>
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
                                    <button @click="viewUser(user)" class="btn btn-ghost btn-sm" title="Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                    <button @click="editUser(user)" class="btn btn-ghost btn-sm" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <button @click="toggleUserStatus(user)" class="btn btn-ghost btn-sm" title="Toggle Status">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                        </svg>
                                    </button>
                                    <button @click="deleteUser(user)" class="btn btn-ghost btn-sm" title="Hapus" x-show="user.id !== {{ auth()->id() }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="users.length === 0 && !loading">
                        <td colspan="8" class="px-6 py-12 text-center text-text-secondary dark:text-text-dark-secondary">
                            <svg class="w-12 h-12 mx-auto mb-3 text-text-secondary/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <p>Belum ada user</p>
                            <button @click="openCreateModal" class="btn btn-ghost btn-sm">
                                Tambah user pertama →
                            </button>
                        </td>
                    </tr>
                    <tr x-show="loading">
                        <td colspan="8" class="px-6 py-12 text-center">
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
                    Menampilkan <span x-text="from"></span> - <span x-text="to"></span> dari <span x-text="total"></span> user
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

    <!-- User Detail Modal -->
    <div x-show="showDetailModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" @click.away="closeDetailModal">
        <div class="card w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto" @click.stop>
            <div class="card-header flex justify-between items-center">
                <h3 class="text-xl font-bold text-text-primary dark:text-text-dark-primary">Detail User</h3>
                <button @click="closeDetailModal" class="text-text-secondary hover:text-text-primary">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="card-body">
                <div x-show="selectedUser">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-20 h-20 bg-accent/10 rounded-full flex items-center justify-center">
                            <span class="text-3xl font-bold text-accent" x-text="getInitials(selectedUser?.name)"></span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-text-primary dark:text-text-dark-primary" x-text="selectedUser?.name"></h3>
                            <p class="text-text-secondary dark:text-text-dark-secondary" x-text="selectedUser?.email"></p>
                            <div class="flex gap-2 mt-1">
                                <span :class="selectedUser?.is_active ? 'badge-success' : 'badge-error'" class="badge">
                                    <span x-text="selectedUser?.is_active ? 'Aktif' : 'Nonaktif'"></span>
                                </span>
                                <span class="badge badge-primary" x-text="selectedUser?.role"></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="border rounded-lg p-4">
                            <p class="text-sm text-text-secondary">Store</p>
                            <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="selectedUser?.store?.name || '-'"></p>
                        </div>
                        <div class="border rounded-lg p-4">
                            <p class="text-sm text-text-secondary">Last Login</p>
                            <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="formatDate(selectedUser?.last_login_at)"></p>
                        </div>
                        <div class="border rounded-lg p-4">
                            <p class="text-sm text-text-secondary">Email Verified</p>
                            <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="selectedUser?.email_verified_at ? 'Yes' : 'No'"></p>
                        </div>
                        <div class="border rounded-lg p-4">
                            <p class="text-sm text-text-secondary">Member Since</p>
                            <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="formatDate(selectedUser?.created_at)"></p>
                        </div>
                    </div>
                    
                    <div class="mt-4 border rounded-lg p-4">
                        <p class="text-sm text-text-secondary mb-2">Roles</p>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="role in (selectedUser?.roles || [])" :key="role.id">
                                <span class="badge badge-primary" x-text="role.name"></span>
                            </template>
                            <span x-show="!selectedUser?.roles || selectedUser?.roles.length === 0" class="text-text-secondary">No roles assigned</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer flex justify-end gap-3">
                <button @click="closeDetailModal" class="btn btn-secondary">Tutup</button>
                <button @click="selectedUser && (editUser(selectedUser), closeDetailModal())" class="btn btn-primary">Edit User</button>
            </div>
        </div>
    </div>

    <!-- User Modal (Create/Edit) -->
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
                            <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Nama Lengkap *</label>
                            <input type="text" x-model="form.name" required class="input" placeholder="Nama user">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Email *</label>
                            <input type="email" x-model="form.email" required :readonly="form.id" class="input" placeholder="email@example.com">
                        </div>
                        <div x-show="!form.id">
                            <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Password *</label>
                            <input type="password" x-model="form.password" required minlength="8" class="input" placeholder="Minimal 8 karakter">
                        </div>
                        <div x-show="form.id">
                            <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Password Baru (opsional)</label>
                            <input type="password" x-model="form.new_password" minlength="8" class="input" placeholder="Kosongkan jika tidak ingin mengubah">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Toko *</label>
                            <select x-model="form.store_id" required class="input">
                                <option value="">Pilih Toko</option>
                                <template x-for="store in stores" :key="store.id">
                                    <option :value="store.id" x-text="store.name"></option>
                                </template>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Roles</label>
                            <div class="space-y-2 max-h-40 overflow-y-auto border rounded-lg p-3">
                                <template x-for="role in roles" :key="role.id">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" :value="role.id" x-model="form.roles" class="w-4 h-4 rounded border-gray-300 text-accent">
                                        <span class="text-sm text-text-primary dark:text-text-dark-primary" x-text="role.name"></span>
                                    </label>
                                </template>
                            </div>
                        </div>
                        <div>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" x-model="form.is_active" class="w-4 h-4 rounded border-gray-300 text-accent">
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
                        User <span class="font-medium text-text-primary dark:text-text-dark-primary" x-text="deleteUserData?.name"></span> akan dihapus permanen.
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
        filteredCount: 0,
        stats: {
            total: 0,
            active: 0,
            inactive: 0,
            admins: 0
        },
        filters: {
            search: '',
            role: '',
            status: '',
            store: ''
        },
        showModal: false,
        showDetailModal: false,
        showDeleteModal: false,
        modalTitle: '',
        selectedUser: null,
        deleteUserData: null,
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
                    this.filteredCount = response.data.data.total;
                    this.stats = response.data.stats || this.stats;
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

        resetFilters() {
            this.filters = {
                search: '',
                role: '',
                status: '',
                store: ''
            };
            this.currentPage = 1;
            this.loadUsers();
        },

        sortBy(field) {
            // Implement sorting logic
            this.loadUsers();
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

        viewUser(user) {
            this.selectedUser = user;
            this.showDetailModal = true;
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
                
                const data = {
                    name: this.form.name,
                    email: this.form.email,
                    store_id: this.form.store_id,
                    roles: this.form.roles,
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

        deleteUser(user) {
            this.deleteUserData = user;
            this.showDeleteModal = true;
        },

        async confirmDelete() {
            if (!this.deleteUserData) return;
            
            try {
                const response = await axios.delete(`/api/developer/users/${this.deleteUserData.id}`);
                if (response.data.success) {
                    this.showDeleteModal = false;
                    this.deleteUserData = null;
                    this.loadUsers();
                    window.showToast('User berhasil dihapus', 'success');
                }
            } catch (error) {
                window.showToast('Gagal menghapus user', 'error');
            }
        },

        closeDetailModal() {
            this.showDetailModal = false;
            this.selectedUser = null;
        },

        closeModal() {
            this.showModal = false;
        },

        exportUsers() {
            window.showToast('Export akan segera tersedia', 'info');
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