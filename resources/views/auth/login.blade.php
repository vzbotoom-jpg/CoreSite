{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.guest')

@section('title', 'Login')

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
            <h2 class="mt-6 text-2xl font-bold">Login ke Akun Anda</h2>
            <p class="mt-2 text-text-secondary">Masukkan email dan password untuk melanjutkan</p>
        </div>
        
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required 
                               class="input @error('email') input-error @enderror"
                               placeholder="admin@coresite.com">
                        @error('email')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Password</label>
                        <input type="password" name="password" required 
                               class="input @error('password') input-error @enderror"
                               placeholder="********">
                        @error('password')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex items-center justify-between mb-6">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="remember" class="rounded border-gray-300">
                            <span class="text-sm text-text-secondary">Ingat Saya</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="text-sm text-accent hover:text-accent-hover">
                            Lupa Password?
                        </a>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-full">Login</button>
                </form>
                
                <div class="mt-6 text-center">
                    <p class="text-sm text-text-secondary">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="text-accent hover:text-accent-hover font-medium">
                            Daftar Sekarang
                        </a>
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Demo Credentials -->
        <div class="mt-6 text-center text-sm text-text-secondary">
            <p>Demo: admin@coresite.com / password</p>
        </div>
    </div>
</div>
@endsection