{{-- resources/views/developer/roles/edit.blade.php --}}
@extends('layouts.developer')

@section('title', 'Edit Role')
@section('page-title', 'Edit Role')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card">
        <div class="card-header flex justify-between items-center">
            <div>
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Edit Role</h3>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary mt-1">Update role: {{ $role->name }}</p>
            </div>
            <a href="{{ route('developer.roles.index') }}" class="btn btn-outline text-sm">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('developer.roles.update', $role->id) }}">
                @csrf
                @method('PUT')
                
                <!-- Role Info -->
                <div class="flex items-center gap-4 p-4 bg-light-surface dark:bg-dark-surface rounded-lg mb-6">
                    <div class="w-12 h-12 bg-accent/10 rounded-full flex items-center justify-center">
                        <span class="text-xl font-bold text-accent">{{ strtoupper(substr($role->name, 0, 2)) }}</span>
                    </div>
                    <div>
                        <p class="font-medium text-text-primary dark:text-text-dark-primary">{{ $role->name }}</p>
                        <p class="text-sm text-text-secondary dark:text-text-dark-secondary">{{ $role->slug }}</p>
                        <span class="badge badge-primary">{{ $role->is_default ? 'Default' : 'Custom' }}</span>
                    </div>
                </div>

                <div class="space-y-4">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Nama Role *</label>
                        <input type="text" name="name" value="{{ old('name', $role->name) }}" required 
                               class="input @error('name') input-error @enderror" placeholder="Nama role">
                        @error('name')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slug (Readonly) -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Slug</label>
                        <input type="text" value="{{ $role->slug }}" readonly 
                               class="input bg-light-surface dark:bg-dark-surface cursor-not-allowed opacity-75">
                        <p class="text-xs text-text-secondary mt-1">Slug tidak dapat diubah</p>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Deskripsi</label>
                        <textarea name="description" rows="2" class="input" placeholder="Deskripsi role">{{ old('description', $role->description) }}</textarea>
                    </div>

                    <!-- Permissions -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Permissions</label>
                        <div class="grid grid-cols-2 gap-2 max-h-60 overflow-y-auto p-3 border border-light-border dark:border-dark-border rounded-lg">
                            @foreach($permissions ?? [] as $permission)
                                @php
                                    $hasPermission = $role->permissions->contains($permission->id);
                                @endphp
                                <label class="flex items-center gap-2 cursor-pointer text-sm">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                                           {{ old('permissions', $hasPermission) ? 'checked' : '' }}
                                           class="w-3 h-3 rounded border-gray-300 text-accent focus:ring-accent">
                                    <span class="text-text-primary dark:text-text-dark-primary">{{ $permission->name }}</span>
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
                            <span class="text-sm text-text-primary dark:text-text-dark-primary">Default Role</span>
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
    @if($role->slug !== 'developer')
    <div class="card border-error/20 mt-6">
        <div class="card-header bg-error/5">
            <h3 class="font-semibold text-error">Danger Zone</h3>
        </div>
        <div class="card-body">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Hapus Role</h4>
                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Tindakan ini tidak dapat dibatalkan</p>
                </div>
                <form method="POST" action="{{ route('developer.roles.delete', $role->id) }}" 
                      onsubmit="return confirm('Yakin ingin menghapus role ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
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
    // Toggle permission select all
    const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
    const selectAll = document.createElement('label');
    selectAll.className = 'flex items-center gap-2 cursor-pointer text-sm col-span-2 mb-2';
    selectAll.innerHTML = `
        <input type="checkbox" id="select-all-permissions" class="w-3 h-3 rounded border-gray-300 text-accent">
        <span class="font-medium">Pilih Semua</span>
    `;
    
    const container = document.querySelector('.grid.grid-cols-2');
    if (container && checkboxes.length > 0) {
        container.parentNode.insertBefore(selectAll, container);
        
        document.getElementById('select-all-permissions').addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
        
        // Update select all state when individual checkboxes change
        checkboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                const allChecked = Array.from(checkboxes).every(c => c.checked);
                document.getElementById('select-all-permissions').checked = allChecked;
            });
        });
    }
});
</script>
@endpush
@endsection