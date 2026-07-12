{{-- resources/views/auth/reset-password.blade.php --}}
@extends('layouts.guest')

@section('title', 'Reset Password')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <div class="text-center mb-8">
            <a href="{{ route('landing') }}" class="inline-flex items-center gap-2">
                <div class="w-10 h-10 bg-accent rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold text-xl">C</span>
                </div>
                <span class="text-2xl font-bold">CoreSite</span>
            </a>
            <h2 class="mt-6 text-2xl font-bold">Reset Password</h2>
            <p class="mt-2 text-text-secondary">Buat password baru untuk akun Anda</p>
        </div>
        
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    
                    <input type="hidden" name="token" value="{{ $token }}">
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Email</label>
                        <input type="email" name="email" value="{{ $email ?? old('email') }}" required 
                               class="input @error('email') input-error @enderror"
                               readonly>
                        @error('email')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Password Baru</label>
                        <input type="password" name="password" required 
                               class="input @error('password') input-error @enderror"
                               placeholder="Minimal 8 karakter">
                        @error('password')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-2">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" required 
                               class="input">
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-full">
                        Reset Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection