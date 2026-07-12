{{-- resources/views/developer/stores/create.blade.php --}}
@extends('layouts.developer')

@section('title', 'Tambah Toko')
@section('page-title', 'Tambah Toko Baru')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card">
        <div class="card-header flex justify-between items-center">
            <div>
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Tambah Toko Baru</h3>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary mt-1">Buat toko baru di platform CoreSite</p>
            </div>
            <a href="{{ route('developer.stores.index') }}" class="btn btn-outline text-sm">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('developer.stores.store') }}">
                @csrf
                <div class="space-y-4">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Nama Toko *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required 
                               class="input @error('name') input-error @enderror" placeholder="Nama toko">
                        @error('name')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Slug *</label>
                        <input type="text" name="slug" value="{{ old('slug') }}" required 
                               class="input @error('slug') input-error @enderror" placeholder="slug-toko">
                        <p class="text-xs text-text-secondary mt-1">URL unik: coresite.com/[slug]</p>
                        @error('slug')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required 
                               class="input @error('email') input-error @enderror" placeholder="email@example.com">
                        @error('email')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Telepon</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" 
                               class="input @error('phone') input-error @enderror" placeholder="08123456789">
                        @error('phone')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Alamat</label>
                        <textarea name="address" rows="2" class="input" placeholder="Alamat lengkap toko">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" 
                                   {{ old('is_active', true) ? 'checked' : '' }}
                                   class="w-4 h-4 rounded border-gray-300 text-accent focus:ring-accent">
                            <span class="text-sm text-text-primary dark:text-text-dark-primary">Toko Aktif</span>
                        </label>
                    </div>

                    <!-- Info -->
                    <div class="p-4 bg-light-surface dark:bg-dark-surface rounded-lg">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-accent flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="text-sm text-text-secondary">Toko akan memiliki:</p>
                                <ul class="text-sm text-text-secondary mt-1 list-disc list-inside">
                                    <li>User admin default</li>
                                    <li>Dashboard akses penuh</li>
                                    <li>E-catalog publik</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-light-border dark:border-dark-border">
                    <a href="{{ route('developer.stores.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Toko
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