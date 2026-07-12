{{-- resources/views/admin/settings/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan')

@section('content')
<div x-data="settingsManager()" x-init="init()" class="space-y-6">
    <!-- Settings Navigation -->
    <div class="flex flex-wrap gap-2 border-b">
        <button @click="activeTab = 'profile'" 
                :class="activeTab === 'profile' ? 'tab-active' : ''"
                class="tab">
            Profil Toko
        </button>
        <button @click="activeTab = 'users'" 
                :class="activeTab === 'users' ? 'tab-active' : ''"
                class="tab">
            Manajemen User
        </button>
        <button @click="activeTab = 'payment'" 
                :class="activeTab === 'payment' ? 'tab-active' : ''"
                class="tab">
            Pembayaran
        </button>
        <button @click="activeTab = 'preferences'" 
                :class="activeTab === 'preferences' ? 'tab-active' : ''"
                class="tab">
            Preferensi
        </button>
    </div>
    
    <!-- Profile Settings -->
    <div x-show="activeTab === 'profile'">
        @include('admin.settings.partials.store-form')
    </div>
    
    <!-- User Management -->
    <div x-show="activeTab === 'users'">
        @include('admin.settings.partials.user-table')
    </div>
    
    <!-- Payment Settings -->
    <div x-show="activeTab === 'payment'">
        @include('admin.settings.partials.payment-settings')
    </div>
    
    <!-- Preferences -->
    <div x-show="activeTab === 'preferences'">
        @include('admin.settings.partials.preference-form')
    </div>
    
    <!-- User Form Modal -->
    <div x-show="showUserModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" 
         @click.away="closeUserModal">
        <div class="card w-full max-w-md mx-4" @click.stop>
            <div class="card-header flex justify-between items-center">
                <h3 class="text-xl font-bold" x-text="userModalTitle"></h3>
                <button @click="closeUserModal" class="text-text-secondary hover:text-text-primary">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="card-body">
                <form @submit.prevent="saveUser">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">Nama Lengkap</label>
                            <input type="text" x-model="userForm.name" required class="input">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Email</label>
                            <input type="email" x-model="userForm.email" required 
                                   :readonly="userForm.id" class="input">
                        </div>
                        <div x-show="!userForm.id">
                            <label class="block text-sm font-medium mb-2">Password</label>
                            <input type="password" x-model="userForm.password" required 
                                   placeholder="Minimal 8 karakter" class="input">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Role</label>
                            <select x-model="userForm.role" class="input">
                                <option value="admin">Admin</option>
                                <option value="staff">Staff</option>
                            </select>
                        </div>
                        <div>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" x-model="userForm.is_active" class="rounded">
                                <span class="text-sm">Aktif</span>
                            </label>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" @click="closeUserModal" class="btn btn-secondary">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function settingsManager() {
    return {
        activeTab: 'profile',
        showUserModal: false,
        userModalTitle: '',
        userForm: {
            id: null,
            name: '',
            email: '',
            password: '',
            role: 'staff',
            is_active: true
        },
        
        init() {
            // Get tab from URL hash if exists
            const hash = window.location.hash.substring(1);
            if (['profile', 'users', 'payment', 'preferences'].includes(hash)) {
                this.activeTab = hash;
            }
        },
        
        openUserModal(user = null) {
            if (user) {
                this.userModalTitle = 'Edit User';
                this.userForm = { ...user, password: '' };
            } else {
                this.userModalTitle = 'Tambah User Baru';
                this.userForm = {
                    id: null,
                    name: '',
                    email: '',
                    password: '',
                    role: 'staff',
                    is_active: true
                };
            }
            this.showUserModal = true;
        },
        
        closeUserModal() {
            this.showUserModal = false;
            this.userForm = {
                id: null,
                name: '',
                email: '',
                password: '',
                role: 'staff',
                is_active: true
            };
        },
        
        async saveUser() {
            try {
                const url = this.userForm.id ? `/api/v1/admin/users/${this.userForm.id}` : '/api/v1/admin/users';
                const method = this.userForm.id ? 'PUT' : 'POST';
                
                const response = await axios({
                    method: method,
                    url: url,
                    data: this.userForm
                });
                
                if (response.data.success) {
                    this.closeUserModal();
                    // Refresh user table
                    if (window.userTable) {
                        window.userTable.loadUsers();
                    }
                    window.showToast(this.userForm.id ? 'User berhasil diupdate' : 'User berhasil ditambahkan', 'success');
                }
            } catch (error) {
                window.showToast(error.response?.data?.message || 'Gagal menyimpan user', 'error');
            }
        }
    }
}
</script>
@endpush
@endsection