{{-- resources/views/auth/forgot-password.blade.php --}}
@extends('layouts.guest')

@section('title', 'Lupa Password')

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
            <h2 class="mt-6 text-2xl font-bold">Lupa Password?</h2>
            <p class="mt-2 text-text-secondary">
                Masukkan email Anda dan kami akan mengirimkan link reset password
            </p>
        </div>
        
        <div class="card">
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success mb-4">
                        {{ session('status') }}
                    </div>
                @endif
                
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required 
                               class="input @error('email') input-error @enderror"
                               placeholder="email@example.com">
                        @error('email')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-full">
                        Kirim Link Reset Password
                    </button>
                </form>
                
                <div class="mt-6 text-center">
                    <a href="{{ route('login') }}" class="text-sm text-accent hover:text-accent-hover">
                        Kembali ke Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection