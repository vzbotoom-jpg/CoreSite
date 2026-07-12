{{-- resources/views/developer/permissions/edit.blade.php --}}
@extends('layouts.developer')

@section('title', 'Edit Permission')
@section('page-title', 'Edit Permission')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card">
        <div class="card-header flex justify-between items-center">
            <div>
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Edit Permission</h3>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary mt-1">Update permission: {{ $permission->name }}</p>
            </div>
            <a href="{{ route('developer.permissions.index') }}" class="btn btn-outline text-sm">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('developer.permissions.update', $permission->id) }}">
                @csrf
                @method('PUT')
                
                <!-- Permission Info -->
                <div class="flex items-center gap-4 p-4 bg-light-surface dark:bg-dark-surface rounded-lg mb-6">
                    <div class="w-12 h-12 bg-accent/10 rounded-full flex items-center justify-center">
                        <span class="text-xl font-bold text-accent">{{ strtoupper(substr($permission->name, 0, 2)) }}</span>
                    </div>
                    <div>
                        <p class="font-medium text-text-primary dark:text-text-dark-primary">{{ $permission->name }}</p>
                        <p class="text-sm text-text-secondary dark:text-text-dark-secondary">{{ $permission->slug }}</p>
                        <span class="badge badge-secondary">{{ $permission->group || 'Uncategorized' }}</span>
                    </div>
                </div>

                <div class="space-y-4">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Nama Permission *</label>
                        <input type="text" name="name" value="{{ old('name', $permission->name) }}" required 
                               class="input @error('name') input-error @enderror" placeholder="Nama permission">
                        @error('name')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slug (Readonly) -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Slug</label>
                        <input type="text" value="{{ $permission->slug }}" readonly 
                               class="input bg-light-surface dark:bg-dark-surface cursor-not-allowed opacity-75">
                        <p class="text-xs text-text-secondary mt-1">Slug tidak dapat diubah</p>
                    </div>

                    <!-- Group -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Group</label>
                        <input type="text" name="group" value="{{ old('group', $permission->group) }}" 
                               class="input @error('group') input-error @enderror" placeholder="Nama group (contoh: users, products)">
                        <p class="text-xs text-text-secondary mt-1">Kelompok untuk mengorganisir permissions</p>
                        @error('group')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Deskripsi</label>
                        <textarea name="description" rows="3" class="input" placeholder="Deskripsi permission">{{ old('description', $permission->description) }}</textarea>
                    </div>

                    <!-- Roles with this permission -->
                    <div class="p-4 bg-light-surface dark:bg-dark-surface rounded-lg">
                        <h4 class="font-medium text-text-primary dark:text-text-dark-primary mb-2">Roles dengan Permission Ini</h4>
                        <div class="flex flex-wrap gap-2">
                            @forelse($permission->roles as $role)
                                <span class="badge badge-primary">{{ $role->name }}</span>
                            @empty
                                <span class="text-sm text-text-secondary">Belum ada role dengan permission ini</span>
                            @endforelse
                        </div>
                        <p class="text-xs text-text-secondary mt-2">
                            Permission ini digunakan oleh <span class="font-medium">{{ $permission->roles->count() }}</span> role(s)
                        </p>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-light-border dark:border-dark-border">
                    <a href="{{ route('developer.permissions.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Update Permission
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Danger Zone -->
    <div class="card border-error/20 mt-6">
        <div class="card-header bg-error/5">
            <h3 class="font-semibold text-error">Danger Zone</h3>
        </div>
        <div class="card-body">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Hapus Permission</h4>
                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary">
                        Tindakan ini tidak dapat dibatalkan
                    </p>
                    @if($permission->roles->count() > 0)
                        <p class="text-xs text-error mt-1">
                            ⚠️ Permission ini digunakan oleh {{ $permission->roles->count() }} role(s)
                        </p>
                    @endif
                </div>
                <form method="POST" action="{{ route('developer.permissions.delete', $permission->id) }}" 
                      onsubmit="return confirm('Yakin ingin menghapus permission ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" {{ $permission->roles->count() > 0 ? 'disabled' : '' }}>
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus Permission
                    </button>
                </form>
            </div>
            @if($permission->roles->count() > 0)
                <p class="text-xs text-text-secondary mt-2">
                    Permission tidak dapat dihapus karena masih digunakan oleh role. 
                    Hapus permission dari role terlebih dahulu.
                </p>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show warning if permission is used by roles
    const roleCount = {{ $permission->roles->count() }};
    if (roleCount > 0) {
        console.log('This permission is used by ' + roleCount + ' role(s)');
    }
});
</script>
@endpush
@endsection