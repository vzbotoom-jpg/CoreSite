{{-- resources/views/developer/stores/edit.blade.php --}}
@extends('layouts.developer')

@section('title', 'Edit Toko')
@section('page-title', 'Edit Toko')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card">
        <div class="card-header flex justify-between items-center">
            <div>
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Edit Toko</h3>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary mt-1">Update data toko: {{ $store->name }}</p>
            </div>
            <a href="{{ route('developer.stores.index') }}" class="btn btn-outline text-sm">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('developer.stores.update', $store->id) }}">
                @csrf
                @method('PUT')
                
                <!-- Store Info -->
                <div class="flex items-center gap-4 p-4 bg-light-surface dark:bg-dark-surface rounded-lg mb-6">
                    <div class="w-12 h-12 bg-accent/10 rounded-full flex items-center justify-center">
                        <span class="text-xl font-bold text-accent">{{ strtoupper(substr($store->name, 0, 2)) }}</span>
                    </div>
                    <div>
                        <p class="font-medium text-text-primary dark:text-text-dark-primary">{{ $store->name }}</p>
                        <p class="text-sm text-text-secondary dark:text-text-dark-secondary">{{ $store->slug }}</p>
                        <span :class="'{{ $store->is_active }}' ? 'badge-success' : 'badge-error'" class="badge">
                            {{ $store->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                </div>

                <div class="space-y-4">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Nama Toko *</label>
                        <input type="text" name="name" value="{{ old('name', $store->name) }}" required 
                               class="input @error('name') input-error @enderror" placeholder="Nama toko">
                        @error('name')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slug (Readonly) -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Slug</label>
                        <input type="text" value="{{ $store->slug }}" readonly 
                               class="input bg-light-surface dark:bg-dark-surface cursor-not-allowed opacity-75">
                        <p class="text-xs text-text-secondary mt-1">Slug tidak dapat diubah</p>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Email *</label>
                        <input type="email" name="email" value="{{ old('email', $store->email) }}" required 
                               class="input @error('email') input-error @enderror" placeholder="email@example.com">
                        @error('email')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Telepon</label>
                        <input type="tel" name="phone" value="{{ old('phone', $store->phone) }}" 
                               class="input @error('phone') input-error @enderror" placeholder="08123456789">
                        @error('phone')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Alamat</label>
                        <textarea name="address" rows="2" class="input" placeholder="Alamat lengkap toko">{{ old('address', $store->address) }}</textarea>
                        @error('address')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" 
                                   {{ old('is_active', $store->is_active) ? 'checked' : '' }}
                                   class="w-4 h-4 rounded border-gray-300 text-accent focus:ring-accent">
                            <span class="text-sm text-text-primary dark:text-text-dark-primary">Toko Aktif</span>
                        </label>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-4 p-4 bg-light-surface dark:bg-dark-surface rounded-lg">
                        <div class="text-center">
                            <p class="text-xs text-text-secondary">Users</p>
                            <p class="text-lg font-bold text-text-primary dark:text-text-dark-primary">{{ $store->users_count ?? 0 }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-xs text-text-secondary">Products</p>
                            <p class="text-lg font-bold text-text-primary dark:text-text-dark-primary">{{ $store->products_count ?? 0 }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-xs text-text-secondary">Transactions</p>
                            <p class="text-lg font-bold text-text-primary dark:text-text-dark-primary">{{ $store->transactions_count ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-light-border dark:border-dark-border">
                    <a href="{{ route('developer.stores.show', $store->id) }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Update Toko
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
                    <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Hapus Toko</h4>
                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary">
                        Tindakan ini tidak dapat dibatalkan. Semua data toko akan hilang.
                    </p>
                    @if(($store->users_count ?? 0) > 0 || ($store->products_count ?? 0) > 0)
                        <p class="text-xs text-error mt-1">
                            ⚠️ Toko memiliki {{ $store->users_count ?? 0 }} user(s) dan {{ $store->products_count ?? 0 }} produk(s)
                        </p>
                    @endif
                </div>
                <form method="POST" action="{{ route('developer.stores.delete', $store->id) }}" 
                      onsubmit="return confirm('Yakin ingin menghapus toko ini? Semua data akan hilang permanen.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus Toko
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show warning if store has data
    const hasData = {{ ($store->users_count ?? 0) > 0 || ($store->products_count ?? 0) > 0 ? 'true' : 'false' }};
    if (hasData) {
        console.log('Store has existing data. Delete with caution.');
    }
});
</script>
@endpush
@endsection