{{-- resources/views/auth/register.blade.php --}}
@extends('layouts.guest')

@section('title', 'Daftar - CoreSite')

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
            <h2 class="mt-6 text-2xl font-bold">Daftar Sekarang</h2>
            <p class="mt-2 text-text-secondary">Mulai toko online Anda dalam hitungan menit</p>
        </div>
        
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Nama Toko</label>
                        <input type="text" name="store_name" value="{{ old('store_name') }}" required 
                               class="input @error('store_name') input-error @enderror"
                               placeholder="Toko Anda">
                        @error('store_name')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Nama Admin</label>
                        <input type="text" name="name" value="{{ old('name') }}" 
                               class="input @error('name') input-error @enderror"
                               placeholder="Nama Anda">
                        @error('name')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required 
                               class="input @error('email') input-error @enderror"
                               placeholder="email@example.com">
                        @error('email')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Nomor Telepon</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" 
                               class="input @error('phone') input-error @enderror"
                               placeholder="08123456789">
                        @error('phone')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Password</label>
                        <input type="password" name="password" required 
                               class="input @error('password') input-error @enderror"
                               placeholder="Minimal 8 karakter">
                        @error('password')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-2">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" required 
                               class="input">
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-full">Daftar Sekarang</button>
                </form>
                
                <div class="mt-6 text-center">
                    <p class="text-sm text-text-secondary">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="text-accent hover:text-accent-hover font-medium">
                            Login
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection