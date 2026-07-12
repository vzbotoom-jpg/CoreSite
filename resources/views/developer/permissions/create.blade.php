{{-- resources/views/developer/permissions/create.blade.php --}}
@extends('layouts.developer')

@section('title', 'Tambah Permission')
@section('page-title', 'Tambah Permission Baru')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card">
        <div class="card-header flex justify-between items-center">
            <div>
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Tambah Permission Baru</h3>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary mt-1">Buat permission baru untuk akses kontrol</p>
            </div>
            <a href="{{ route('developer.permissions.index') }}" class="btn btn-outline text-sm">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('developer.permissions.store') }}">
                @csrf
                <div class="space-y-4">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Nama Permission *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required 
                               class="input @error('name') input-error @enderror" placeholder="Nama permission">
                        @error('name')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Slug *</label>
                        <input type="text" name="slug" value="{{ old('slug') }}" required 
                               class="input @error('slug') input-error @enderror" placeholder="permission-slug">
                        <p class="text-xs text-text-secondary mt-1">Identifier unik untuk permission. Contoh: view-users, create-products</p>
                        @error('slug')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Group -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Group</label>
                        <input type="text" name="group" value="{{ old('group') }}" 
                               class="input @error('group') input-error @enderror" placeholder="Nama group (contoh: users, products)">
                        <p class="text-xs text-text-secondary mt-1">Kelompok untuk mengorganisir permissions</p>
                        @error('group')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Deskripsi</label>
                        <textarea name="description" rows="3" class="input" placeholder="Deskripsi permission">{{ old('description') }}</textarea>
                    </div>

                    <!-- Info -->
                    <div class="p-4 bg-light-surface dark:bg-dark-surface rounded-lg">
                        <p class="text-sm text-text-secondary">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Permission akan tersedia untuk di-assign ke role setelah dibuat.
                        </p>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-light-border dark:border-dark-border">
                    <a href="{{ route('developer.permissions.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Permission
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