{{-- resources/views/admin/settings/profile.blade.php --}}
@extends('layouts.app')

@section('title', 'Profil Toko')
@section('page-title', 'Profil Toko')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Informasi Profil Toko</h3>
            <p class="text-sm text-text-secondary dark:text-text-dark-secondary mt-1">Kelola informasi profil dan logo toko Anda</p>
        </div>
        <div class="card-body">
            <form id="profileForm" method="POST" action="{{ route('admin.settings.store') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Logo Upload -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Logo Toko</label>
                    <div class="flex items-center gap-6">
                        <div class="relative w-24 h-24 rounded-xl border-2 border-dashed border-light-border dark:border-dark-border overflow-hidden group">
                            @if(isset($store) && $store->logo)
                                <img src="{{ Storage::url($store->logo) }}" alt="Logo" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-light-surface dark:bg-dark-surface">
                                    <svg class="w-10 h-10 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                <button type="button" onclick="document.getElementById('logoInput').click()" class="text-white text-sm font-medium">
                                    <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                    </svg>
                                    Upload
                                </button>
                            </div>
                        </div>
                        <input type="file" id="logoInput" name="logo" accept="image/*" class="hidden" onchange="previewLogo(this)">
                        <div class="space-y-1">
                            <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Upload logo toko Anda</p>
                            <p class="text-xs text-text-secondary dark:text-text-dark-secondary">Format: JPG, PNG, SVG • Maks: 2MB</p>
                            @if(isset($store) && $store->logo)
                                <button type="button" onclick="removeLogo()" class="text-error text-sm hover:text-error/80 transition-colors">
                                    Hapus Logo
                                </button>
                            @endif
                        </div>
                    </div>
                    <div id="logoPreview" class="mt-3 hidden">
                        <img id="logoPreviewImage" src="#" alt="Preview" class="w-20 h-20 rounded-lg object-cover border border-light-border dark:border-dark-border">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Nama Toko *</label>
                        <input type="text" name="name" value="{{ old('name', $store->name ?? '') }}" required class="input">
                        @error('name')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Slug URL</label>
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-text-secondary dark:text-text-dark-secondary">coresite.com/</span>
                            <input type="text" name="slug" value="{{ old('slug', $store->slug ?? '') }}" class="input flex-1" readonly>
                        </div>
                        <p class="text-xs text-text-secondary dark:text-text-dark-secondary mt-1">Slug tidak dapat diubah</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Email Toko *</label>
                        <input type="email" name="email" value="{{ old('email', $store->email ?? '') }}" required class="input">
                        @error('email')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Nomor Telepon</label>
                        <input type="tel" name="phone" value="{{ old('phone', $store->phone ?? '') }}" class="input" placeholder="08123456789">
                        @error('phone')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Alamat</label>
                        <textarea name="address" rows="3" class="input" placeholder="Alamat lengkap toko Anda">{{ old('address', $store->address ?? '') }}</textarea>
                        @error('address')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Deskripsi Toko</label>
                        <textarea name="description" rows="3" class="input" placeholder="Deskripsi singkat tentang toko Anda">{{ old('description', $store->description ?? '') }}</textarea>
                        @error('description')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="resetForm()" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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
                    <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Hapus Toko</h4>
                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Tindakan ini tidak dapat dibatalkan. Semua data akan hilang permanen.</p>
                </div>
                <button onclick="confirmDeleteStore()" class="btn btn-danger">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Hapus Toko
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function previewLogo(input) {
    const preview = document.getElementById('logoPreview');
    const previewImage = document.getElementById('logoPreviewImage');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function removeLogo() {
    if (confirm('Hapus logo toko?')) {
        // Implement logo removal via AJAX
        window.showToast('Logo berhasil dihapus', 'success');
    }
}

function resetForm() {
    document.getElementById('profileForm').reset();
    document.getElementById('logoPreview').classList.add('hidden');
    window.showToast('Form telah direset', 'info');
}

function confirmDeleteStore() {
    if (confirm('Yakin ingin menghapus toko? Semua data akan hilang permanen!')) {
        if (confirm('Ini adalah tindakan permanen. Apakah Anda benar-benar yakin?')) {
            window.showToast('Fitur ini akan segera tersedia', 'info');
        }
    }
}
</script>
@endpush
@endsection