{{-- resources/views/developer/roles/create.blade.php --}}
@extends('layouts.developer')

@section('title', 'Tambah Role')
@section('page-title', 'Tambah Role Baru')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card">
        <div class="card-header flex justify-between items-center">
            <div>
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Tambah Role Baru</h3>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary mt-1">Buat role baru dengan permissions</p>
            </div>
            <a href="{{ route('developer.roles.index') }}" class="btn btn-outline text-sm">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('developer.roles.store') }}">
                @csrf
                <div class="space-y-4">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Nama Role *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required 
                               class="input @error('name') input-error @enderror" placeholder="Nama role">
                        @error('name')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Slug *</label>
                        <input type="text" name="slug" value="{{ old('slug') }}" required 
                               class="input @error('slug') input-error @enderror" placeholder="role-slug">
                        <p class="text-xs text-text-secondary mt-1">Identifier unik untuk role. Contoh: admin, staff, manager</p>
                        @error('slug')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Deskripsi</label>
                        <textarea name="description" rows="2" class="input" placeholder="Deskripsi role">{{ old('description') }}</textarea>
                    </div>

                    <!-- Permissions -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Permissions</label>
                        <div class="grid grid-cols-2 gap-2 max-h-60 overflow-y-auto p-3 border border-light-border dark:border-dark-border rounded-lg">
                            @foreach($permissions ?? [] as $permission)
                                <label class="flex items-center gap-2 cursor-pointer text-sm">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                                           {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}
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
                                   {{ old('is_default') ? 'checked' : '' }}
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Role
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate slug from name
    const nameInput = document.querySelector('input[name="name"]');
    const slugInput = document.querySelector('input[name="slug"]');
    
    if (nameInput && slugInput) {
        nameInput.addEventListener('input', function() {
            if (!slugInput.value || slugInput.dataset.auto === 'true') {
                slugInput.value = this.value.toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '');
                slugInput.dataset.auto = 'true';
            }
        });
        
        slugInput.addEventListener('input', function() {
            this.dataset.auto = 'false';
        });
    }
});
</script>
@endpush
@endsection