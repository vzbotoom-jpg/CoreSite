{{-- resources/views/admin/settings/partials/user-table.blade.php --}}
<div x-data="userTable()" x-init="init()" class="space-y-4">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h3 class="font-semibold">Manajemen User</h3>
        <button @click="$parent.openUserModal()" class="btn btn-primary text-sm">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                    <tr class="border-b">
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary">Nama</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary">Email</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary">Role</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary">Status</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary">Terdaftar</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="user in users" :key="user.id">
                        <tr class="border-b hover:bg-light-surface/50">
                            <td class="px-6 py-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-accent/10 rounded-full flex items-center justify-center">
                                        <span class="text-accent text-sm font-semibold" x-text="getInitials(user.name)"></span>
                                    </div>
                                    <span x-text="user.name"></span>
                                </div>
                            </td>
                            <td class="px-6 py-3" x-text="user.email"></td>
                            <td class="px-6 py-3">
                                <span :class="user.role === 'admin' ? 'badge-primary' : 'badge-secondary'" class="badge">
                                    <span x-text="user.role === 'admin' ? 'Admin' : 'Staff'"></span>
                                </span>
                            </td>
                            <td class="px-6 py-3">
                                <span :class="user.is_active ? 'badge-success' : 'badge-error'" class="badge">
                                    <span x-text="user.is_active ? 'Aktif' : 'Nonaktif'"></span>
                                </span>
                            </td>
                            <td class="px-6 py-3 text-sm" x-text="formatDate(user.created_at)"></td>
                            <td class="px-6 py-3">
                                <div class="flex items-center gap-2">
                                    <button @click="$parent.openUserModal(user)" class="text-info hover:text-info/80" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <button @click="deleteUser(user)" x-show="user.role !== 'admin' || users.length > 1" 
                                            class="text-error hover:text-error/80" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="users.length === 0 && !loading">
                        <td colspan="6" class="px-6 py-12 text-center text-text-secondary">
                            Belum ada user. Klik "Tambah User" untuk menambahkan.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
function userTable() {
    return {
        users: [],
        loading: false,
        
        init() {
            this.loadUsers();
            // Register for refresh
            window.userTable = this;
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
            }
            this.loading = false;
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