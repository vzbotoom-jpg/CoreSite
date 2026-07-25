{{-- resources/views/developer/roles/edit.blade.php --}}
@extends('layouts.developer')

@section('title', 'Edit Role')
@section('page-title', 'Edit Role')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border">
        <div class="card-header flex justify-between items-center border-b border-light-border dark:border-dark-border pb-4">
            <div>
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Edit Role</h3>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary mt-1">Update role: {{ $role->name }}</p>
            </div>
            <a href="{{ route('developer.roles.index') }}" class="btn btn-outline text-sm border border-light-border dark:border-dark-border hover:bg-light-bg dark:hover:bg-dark-bg">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
        <div class="card-body p-6">
            <form method="POST" action="{{ route('developer.roles.update', $role->id) }}">
                @csrf
                @method('PUT')
                
                <!-- Role Info -->
                <div class="flex items-center gap-4 p-4 bg-light-surface/40 dark:bg-dark-surface/40 border border-light-border dark:border-dark-border rounded-lg mb-6">
                    <div class="w-12 h-12 bg-accent/10 rounded-full flex items-center justify-center">
                        <span class="text-xl font-bold text-accent">{{ strtoupper(substr($role->name, 0, 2)) }}</span>
                    </div>
                    <div>
                        <p class="font-bold text-text-primary dark:text-text-dark-primary text-sm">{{ $role->name }}</p>
                        <p class="text-xs text-text-secondary dark:text-text-dark-secondary font-mono">{{ $role->slug }}</p>
                        <span class="badge badge-primary text-[10px] font-bold mt-1">{{ $role->is_default ? 'Default' : 'Custom' }}</span>
                    </div>
                </div>

                <div class="space-y-4">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-semibold text-text-primary dark:text-text-dark-primary mb-2">Nama Role *</label>
                        <input type="text" name="name" value="{{ old('name', $role->name) }}" required 
                               class="input @error('name') input-error @enderror" placeholder="Nama role">
                        @error('name')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slug (Readonly) -->
                    <div>
                        <label class="block text-sm font-semibold text-text-primary dark:text-text-dark-primary mb-2">Slug</label>
                        <input type="text" value="{{ $role->slug }}" readonly 
                               class="input bg-light-surface/60 dark:bg-dark-bg/60 cursor-not-allowed opacity-75">
                        <p class="text-xs text-text-secondary mt-1">Slug tidak dapat diubah</p>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-semibold text-text-primary dark:text-text-dark-primary mb-2">Deskripsi</label>
                        <textarea name="description" rows="2" class="input" placeholder="Deskripsi role">{{ old('description', $role->description) }}</textarea>
                    </div>

                    <!-- Permissions -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-sm font-semibold text-text-primary dark:text-text-dark-primary">Permissions</label>
                            <label class="flex items-center gap-1.5 cursor-pointer text-xs font-bold text-accent hover:underline">
                                <input type="checkbox" id="select-all-permissions" class="w-3.5 h-3.5 rounded border-gray-300 text-accent">
                                Pilih Semua
                            </label>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 max-h-60 overflow-y-auto p-3 border border-light-border dark:border-dark-border rounded-lg bg-light-bg/30 dark:bg-dark-bg/20">
                            @foreach($permissions ?? [] as $permission)
                                @php
                                    $hasPermission = $role->permissions->contains($permission->id);
                                @endphp
                                <label class="flex items-center gap-2 cursor-pointer text-sm">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                                           {{ old('permissions', $hasPermission) ? 'checked' : '' }}
                                           class="w-3 h-3 rounded border-gray-300 text-accent focus:ring-accent">
                                    <span class="text-text-primary dark:text-text-dark-primary text-xs">{{ $permission->name }}</span>
                                    @if($permission->group)
                                        <span class="text-xs text-text-secondary">({{ $permission->group }})</span>
                                    @endif
                                </label>
                            @endforeach
                        </div>
                        @error('permissions')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Default -->
                    <div>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_default" value="1" 
                                   {{ old('is_default', $role->is_default) ? 'checked' : '' }}
                                   class="w-4 h-4 rounded border-gray-300 text-accent focus:ring-accent">
                            <span class="text-sm font-semibold text-text-primary dark:text-text-dark-primary">Default Role</span>
                        </label>
                        <p class="text-xs text-text-secondary mt-1">Role default akan diberikan ke user baru</p>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-light-border dark:border-dark-border">
                    <a href="{{ route('developer.roles.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Update Role
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Danger Zone -->
    @if($role->slug !== 'developer' && $role->slug !== 'super-admin' && $role->slug !== 'store-owner')
    <div class="card border-error/20 mt-6 bg-white dark:bg-dark-surface">
        <div class="card-header bg-error/5 border-b border-error/10 pb-4">
            <h3 class="font-bold text-error text-base">Danger Zone</h3>
        </div>
        <div class="card-body p-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h4 class="font-bold text-text-primary dark:text-text-dark-primary text-sm">Hapus Role</h4>
                    <p class="text-xs text-text-secondary dark:text-text-dark-secondary">Tindakan ini tidak dapat dibatalkan</p>
                </div>
                <form method="POST" action="{{ route('developer.roles.delete', $role->id) }}" 
                      onsubmit="return confirm('Yakin ingin menghapus role ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger text-xs py-2 px-4">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus Role
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select All Permissions
    const selectAllCheckbox = document.getElementById('select-all-permissions');
    const checkboxes = document.querySelectorAll('input[name="permissions[]"]');

    if (selectAllCheckbox && checkboxes.length > 0) {
        selectAllCheckbox.addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = this.checked);
        });

        checkboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                const allChecked = Array.from(checkboxes).every(c => c.checked);
                selectAllCheckbox.checked = allChecked;
            });
        });

        // Set initial state of Select All
        const allChecked = Array.from(checkboxes).every(c => c.checked);
        selectAllCheckbox.checked = allChecked && checkboxes.length > 0;
    }
});
</script>
@endpush
@endsection