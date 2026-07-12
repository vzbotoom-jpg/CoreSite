{{-- resources/views/developer/users/create.blade.php --}}
@extends('layouts.developer')

@section('title', 'Tambah User')
@section('page-title', 'Tambah User Baru')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card">
        <div class="card-header flex justify-between items-center">
            <div>
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Tambah User Baru</h3>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary mt-1">Lengkapi data user baru</p>
            </div>
            <a href="{{ route('developer.users.index') }}" class="btn btn-outline text-sm">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('developer.users.store') }}">
                @csrf
                <div class="space-y-4">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Nama Lengkap *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required 
                               class="input @error('name') input-error @enderror" placeholder="Nama user">
                        @error('name')
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

                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Password *</label>
                        <input type="password" name="password" required 
                               class="input @error('password') input-error @enderror" placeholder="Minimal 8 karakter">
                        @error('password')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Confirmation -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Konfirmasi Password *</label>
                        <input type="password" name="password_confirmation" required class="input" placeholder="Ulangi password">
                    </div>

                    <!-- Store -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Toko *</label>
                        <select name="store_id" required class="input @error('store_id') input-error @enderror">
                            <option value="">Pilih Toko</option>
                            @foreach($stores ?? [] as $store)
                                <option value="{{ $store->id }}" {{ old('store_id') == $store->id ? 'selected' : '' }}>
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
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="roles[]" value="{{ $role->id }}" 
                                           {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}
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
                                   {{ old('is_active', true) ? 'checked' : '' }}
                                   class="w-4 h-4 rounded border-gray-300 text-accent focus:ring-accent">
                            <span class="text-sm text-text-primary dark:text-text-dark-primary">User Aktif</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-light-border dark:border-dark-border">
                    <a href="{{ route('developer.users.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection