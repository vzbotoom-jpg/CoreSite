{{-- resources/views/developer/roles/show.blade.php --}}
@extends('layouts.developer')

@section('title', 'Detail Role')
@section('page-title', 'Detail Role')

@section('content')
<div x-data="roleDetail()" x-init="init()" class="max-w-4xl mx-auto space-y-6">
    <!-- Loading -->
    <div x-show="loading" class="text-center py-12">
        <div class="spinner mx-auto animate-spin h-8 w-8 text-accent border-2 border-accent/20 border-t-accent rounded-full"></div>
        <p class="text-text-secondary mt-4">Memuat data role...</p>
    </div>

    <!-- Role Detail -->
    <div x-show="!loading && role" x-cloak class="space-y-6">
        <!-- Header -->
        <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
            <div class="flex items-center gap-4">
                <a href="{{ route('developer.roles.index') }}" class="text-text-secondary hover:text-accent transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h1 class="text-2xl font-bold text-text-primary dark:text-text-dark-primary" x-text="role.name"></h1>
                <span class="badge badge-primary" x-text="role.is_default ? 'Default' : 'Custom'"></span>
                <span x-show="role.slug === 'developer' || role.slug === 'super-admin' || role.slug === 'store-owner'" class="badge badge-error">System</span>
            </div>
            <div class="flex gap-3">
                <a :href="`/developer/roles/${role.id}/edit`" class="btn btn-primary text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Role
                </a>
            </div>
        </div>

        <!-- Role Info -->
        <div class="grid md:grid-cols-3 gap-6">
            <!-- Info Card -->
            <div class="card md:col-span-1 bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border">
                <div class="card-body p-6 text-center">
                    <div class="w-20 h-20 bg-accent/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-3xl font-bold text-accent" x-text="getInitials(role.name)"></span>
                    </div>
                    <h3 class="text-xl font-bold text-text-primary dark:text-text-dark-primary" x-text="role.name"></h3>
                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary font-mono mt-0.5" x-text="role.slug"></p>
                    <div class="mt-3 flex justify-center gap-2">
                        <span class="badge badge-primary" x-text="role.is_default ? 'Default' : 'Custom'"></span>
                        <span class="badge badge-secondary" x-text="'ID: ' + role.id"></span>
                    </div>
                    <div class="mt-4 pt-4 border-t border-light-border dark:border-dark-border text-left">
                        <p class="text-xs text-text-secondary">Dibuat</p>
                        <p class="text-xs font-semibold text-text-primary dark:text-text-dark-primary mt-1" x-text="formatDate(role.created_at)"></p>
                    </div>
                    <div class="mt-2 pt-2 border-t border-light-border dark:border-dark-border text-left">
                        <p class="text-xs text-text-secondary">Terakhir Update</p>
                        <p class="text-xs font-semibold text-text-primary dark:text-text-dark-primary mt-1" x-text="formatDate(role.updated_at)"></p>
                    </div>
                </div>
            </div>

            <!-- Details Card -->
            <div class="card md:col-span-2 bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border">
                <div class="card-header border-b border-light-border dark:border-dark-border pb-4">
                    <h3 class="font-bold text-text-primary dark:text-text-dark-primary text-sm uppercase tracking-wider">Informasi Role</h3>
                </div>
                <div class="card-body p-6 space-y-5">
                    <div>
                        <label class="text-xs font-bold text-text-secondary uppercase tracking-wider">Deskripsi</label>
                        <p class="text-text-primary dark:text-text-dark-primary text-sm mt-1" x-text="role.description || 'Tidak ada deskripsi'"></p>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-text-secondary uppercase tracking-wider">Users dengan Role Ini</label>
                        <p class="text-text-primary dark:text-text-dark-primary text-sm mt-1">
                            <span class="font-bold text-accent" x-text="role.users_count || 0"></span> user(s)
                        </p>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-text-secondary uppercase tracking-wider">Permissions (<span x-text="role.permissions?.length || 0"></span>)</label>
                        <div class="flex flex-wrap gap-1.5 mt-2">
                            <template x-for="permission in role.permissions" :key="permission.id">
                                <span class="badge badge-secondary text-xs" x-text="permission.name"></span>
                            </template>
                            <span x-show="!role.permissions || role.permissions.length === 0" class="text-text-secondary italic text-xs">Tidak ada permission</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users with this Role -->
        <div class="card bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border">
            <div class="card-header border-b border-light-border dark:border-dark-border p-4 flex justify-between items-center">
                <h3 class="font-bold text-text-primary dark:text-text-dark-primary text-sm uppercase tracking-wider">Users dengan Role Ini</h3>
                <span class="badge badge-secondary text-xs" x-text="(role.users?.length || 0) + ' user(s)'"></span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-light-border dark:border-dark-border bg-light-bg/40 dark:bg-dark-bg/40 text-left">
                            <th class="px-6 py-3 text-xs font-bold text-text-secondary uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-xs font-bold text-text-secondary uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-xs font-bold text-text-secondary uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-xs font-bold text-text-secondary uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="user in role.users" :key="user.id">
                            <tr class="border-b border-light-border dark:border-dark-border hover:bg-light-surface/30 dark:hover:bg-dark-bg/20 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-accent/10 rounded-full flex items-center justify-center shrink-0">
                                            <span class="text-accent font-bold text-xs" x-text="getInitials(user.name)"></span>
                                        </div>
                                        <span class="font-semibold text-text-primary dark:text-text-dark-primary text-xs" x-text="user.name"></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-text-primary dark:text-text-dark-primary text-xs" x-text="user.email"></td>
                                <td class="px-6 py-4">
                                    <span :class="user.is_active ? 'badge-success' : 'badge-error'" class="badge text-[10px] font-bold py-0.5 px-1.5">
                                        <span x-text="user.is_active ? 'Aktif' : 'Nonaktif'"></span>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a :href="`/developer/users/${user.id}`" class="btn btn-ghost btn-xs text-accent hover:underline">
                                        Detail User
                                    </a>
                                </td>
                            </tr>
                        </template>
                        <tr x-show="!role.users || role.users.length === 0">
                            <td colspan="4" class="px-6 py-10 text-center text-text-secondary dark:text-text-dark-secondary italic text-xs">
                                Belum ada user dengan role ini
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Not Found -->
    <div x-show="!loading && !role" class="text-center py-12">
        <svg class="w-16 h-16 mx-auto text-text-secondary/50 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        <p class="text-text-secondary text-sm">Role tidak ditemukan</p>
        <a href="{{ route('developer.roles.index') }}" class="btn btn-ghost btn-sm mt-4 text-accent">Kembali ke daftar role</a>
    </div>
</div>

@push('scripts')
<script>
function roleDetail() {
    return {
        role: null,
        loading: true,
        roleId: {{ $role->id ?? $id ?? 0 }},

        init() {
            this.loadRole();
        },

        async loadRole() {
            this.loading = true;
            try {
                const response = await axios.get(`/developer/roles/${this.roleId}`);
                if (response.data.success) {
                    this.role = response.data.data;
                }
            } catch (error) {
                console.error('Failed to load role:', error);
                window.showToast('Gagal memuat data role', 'error');
            }
            this.loading = false;
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