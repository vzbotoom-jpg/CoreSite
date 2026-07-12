 {{-- resources/views/developer/permissions/show.blade.php --}}
@extends('layouts.developer')

@section('title', 'Detail Permission')
@section('page-title', 'Detail Permission')

@section('content')
<div x-data="permissionDetail()" x-init="init()" class="max-w-4xl mx-auto">
    <!-- Loading -->
    <div x-show="loading" class="text-center py-12">
        <div class="spinner mx-auto"></div>
        <p class="text-text-secondary mt-4">Memuat data permission...</p>
    </div>

    <!-- Permission Detail -->
    <div x-show="!loading && permission" x-cloak>
        <!-- Header -->
        <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
            <div class="flex items-center gap-4">
                <a href="{{ route('developer.permissions.index') }}" class="text-text-secondary hover:text-accent transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h1 class="text-2xl font-bold text-text-primary dark:text-text-dark-primary" x-text="permission.name"></h1>
                <span class="badge badge-secondary" x-text="permission.group || 'Uncategorized'"></span>
            </div>
            <div class="flex gap-3">
                <a :href="`/developer/permissions/${permission.id}/edit`" class="btn btn-primary text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Permission
                </a>
            </div>
        </div>

        <!-- Permission Info -->
        <div class="grid md:grid-cols-3 gap-6">
            <!-- Info Card -->
            <div class="card md:col-span-1">
                <div class="card-body">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-accent/10 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl font-bold text-accent" x-text="getInitials(permission.name)"></span>
                        </div>
                        <h3 class="text-xl font-bold text-text-primary dark:text-text-dark-primary" x-text="permission.name"></h3>
                        <p class="text-sm text-text-secondary dark:text-text-dark-secondary" x-text="permission.slug"></p>
                        <div class="mt-3 flex justify-center gap-2">
                            <span class="badge badge-secondary" x-text="permission.group || 'Uncategorized'"></span>
                            <span class="badge badge-secondary" x-text="'ID: ' + permission.id"></span>
                        </div>
                        <div class="mt-4 pt-4 border-t border-light-border dark:border-dark-border">
                            <p class="text-sm text-text-secondary">Dibuat</p>
                            <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="formatDate(permission.created_at)"></p>
                        </div>
                        <div class="mt-2 pt-2 border-t border-light-border dark:border-dark-border">
                            <p class="text-sm text-text-secondary">Terakhir Update</p>
                            <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="formatDate(permission.updated_at)"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Details Card -->
            <div class="card md:col-span-2">
                <div class="card-header">
                    <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Informasi Permission</h3>
                </div>
                <div class="card-body space-y-4">
                    <div>
                        <label class="text-sm text-text-secondary">Deskripsi</label>
                        <p class="text-text-primary dark:text-text-dark-primary" x-text="permission.description || 'Tidak ada deskripsi'"></p>
                    </div>
                    <div>
                        <label class="text-sm text-text-secondary">Roles dengan Permission Ini</label>
                        <div class="flex flex-wrap gap-2 mt-2">
                            <template x-for="role in permission.roles" :key="role.id">
                                <span class="badge badge-primary" x-text="role.name"></span>
                            </template>
                            <span x-show="!permission.roles || permission.roles.length === 0" 
                                  class="text-text-secondary">Tidak ada role dengan permission ini</span>
                        </div>
                    </div>
                    <div>
                        <label class="text-sm text-text-secondary">Group</label>
                        <p class="text-text-primary dark:text-text-dark-primary" x-text="permission.group || 'Tidak ada group'"></p>
                    </div>
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
                            Permission <span class="font-medium text-text-primary dark:text-text-dark-primary" x-text="permission?.name"></span> akan dihapus permanen.
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
    <div x-show="!loading && !permission" class="text-center py-12">
        <svg class="w-16 h-16 mx-auto text-text-secondary/50 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        <p class="text-text-secondary">Permission tidak ditemukan</p>
        <a href="{{ route('developer.permissions.index') }}" class="btn btn-ghost btn-sm">
            Kembali ke daftar permission
        </a>
    </div>
</div>

@push('scripts')
<script>
function permissionDetail() {
    return {
        permission: null,
        loading: true,
        showDeleteModal: false,
        permissionId: {{ $id ?? 0 }},

        init() {
            this.loadPermission();
        },

        async loadPermission() {
            this.loading = true;
            try {
                const response = await axios.get(`/api/developer/permissions/${this.permissionId}`);
                if (response.data.success) {
                    this.permission = response.data.data;
                }
            } catch (error) {
                console.error('Failed to load permission:', error);
                window.showToast('Gagal memuat data permission', 'error');
            }
            this.loading = false;
        },

        async deletePermission() {
            this.showDeleteModal = true;
        },

        async confirmDelete() {
            try {
                const response = await axios.delete(`/api/developer/permissions/${this.permissionId}`);
                if (response.data.success) {
                    this.showDeleteModal = false;
                    window.showToast('Permission berhasil dihapus', 'success');
                    setTimeout(() => {
                        window.location.href = '{{ route("developer.permissions.index") }}';
                    }, 1500);
                }
            } catch (error) {
                window.showToast('Gagal menghapus permission', 'error');
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