{{-- resources/views/developer/users/edit.blade.php --}}
@extends('layouts.developer')

@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card">
        <div class="card-header flex justify-between items-center">
            <div>
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Edit User</h3>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary mt-1">Update data user: {{ $user->name }}</p>
            </div>
            <a href="{{ route('developer.users.index') }}" class="btn btn-outline text-sm">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('developer.users.update', $user->id) }}">
                @csrf
                @method('PUT')
                
                <!-- User Info -->
                <div class="flex items-center gap-4 p-4 bg-light-surface dark:bg-dark-surface rounded-lg mb-6">
                    <div class="w-16 h-16 bg-accent/10 rounded-full flex items-center justify-center">
                        <span class="text-2xl font-bold text-accent">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                    </div>
                    <div>
                        <p class="font-medium text-text-primary dark:text-text-dark-primary">{{ $user->name }}</p>
                        <p class="text-sm text-text-secondary dark:text-text-dark-secondary">{{ $user->email }}</p>
                        <span :class="'{{ $user->is_active }}' ? 'badge-success' : 'badge-error'" class="badge">
                            {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                </div>

                <div class="space-y-4">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Nama Lengkap *</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                               class="input @error('name') input-error @enderror" placeholder="Nama user">
                        @error('name')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email (Readonly) -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Email</label>
                        <input type="email" value="{{ $user->email }}" readonly class="input bg-light-surface dark:bg-dark-surface cursor-not-allowed opacity-75">
                        <p class="text-xs text-text-secondary mt-1">Email tidak dapat diubah</p>
                    </div>

                    <!-- New Password -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Password Baru (opsional)</label>
                        <input type="password" name="password" 
                               class="input @error('password') input-error @enderror" placeholder="Kosongkan jika tidak ingin mengubah">
                        <p class="text-xs text-text-secondary mt-1">Minimal 8 karakter</p>
                        @error('password')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Store -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Toko *</label>
                        <select name="store_id" required class="input @error('store_id') input-error @enderror">
                            <option value="">Pilih Toko</option>
                            @foreach($stores ?? [] as $store)
                                <option value="{{ $store->id }}" {{ old('store_id', $user->store_id) == $store->id ? 'selected' : '' }}>
                                    {{ $store->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('store_id')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Roles -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Roles</label>
                        <div class="space-y-2 border border-light-border dark:border-dark-border rounded-lg p-3 max-h-48 overflow-y-auto">
                            @foreach($roles ?? [] as $role)
                                @php
                                    $hasRole = $user->roles->contains($role->id);
                                @endphp
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="roles[]" value="{{ $role->id }}" 
                                           {{ old('roles', $hasRole) ? 'checked' : '' }}
                                           class="w-4 h-4 rounded border-gray-300 text-accent focus:ring-accent">
                                    <span class="text-sm text-text-primary dark:text-text-dark-primary">{{ $role->name }}</span>
                                    <span class="text-xs text-text-secondary">({{ $role->slug }})</span>
                                </label>
                            @endforeach
                        </div>
                        @error('roles')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" 
                                   {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                                   class="w-4 h-4 rounded border-gray-300 text-accent focus:ring-accent">
                            <span class="text-sm text-text-primary dark:text-text-dark-primary">User Aktif</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-light-border dark:border-dark-border">
                    <a href="{{ route('developer.users.show', $user->id) }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Danger Zone -->
    @if(auth()->id() != $user->id)
    <div class="card border-error/20 mt-6">
        <div class="card-header bg-error/5">
            <h3 class="font-semibold text-error">Danger Zone</h3>
        </div>
        <div class="card-body">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Hapus User</h4>
                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Tindakan ini tidak dapat dibatalkan</p>
                </div>
                <form method="POST" action="{{ route('developer.users.delete', $user->id) }}" 
                      onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus User
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
    // Auto-generate slug from name if needed
    // Add any additional JS functionality
});
</script>
@endpush
@endsection