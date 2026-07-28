{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-light-surface dark:bg-dark-surface">
    <div class="max-w-md w-full">
        <div class="text-center mb-8">
            <a href="{{ route('landing') }}" class="inline-flex items-center gap-2">
                <div class="w-10 h-10 bg-accent rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold text-xl">C</span>
                </div>
                <span class="text-2xl font-bold">CoreSite</span>
            </a>
            <h2 class="mt-6 text-2xl font-bold">Selamat Datang Kembali</h2>
            <p class="mt-2 text-text-secondary">Masukkan email dan password untuk melanjutkan</p>
        </div>

        <div class="card shadow-lg">
            <div class="card-body">

                @if(session('status'))
                <div class="flex items-start gap-3 bg-success/10 border border-success/20 text-success rounded-lg px-4 py-3 text-sm mb-5">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium mb-2">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                                   class="input pl-10 @error('email') input-error @enderror"
                                   placeholder="admin@coresite.com">
                        </div>
                        @error('email')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div x-data="{ show: false }">
                        <label for="password" class="block text-sm font-medium mb-2">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input :type="show ? 'text' : 'password'" id="password" name="password" required
                                   class="input pl-10 pr-11 @error('password') input-error @enderror"
                                   placeholder="********">
                            <button type="button" @click="show = !show"
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-text-secondary hover:text-text-primary transition-colors">
                                <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="show" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" class="rounded border-gray-300 text-accent focus:ring-accent">
                            <span class="text-sm text-text-secondary">Ingat Saya</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="text-sm text-accent hover:text-accent-hover">
                            Lupa Password?
                        </a>
                    </div>

                    <button type="submit" class="btn btn-primary w-full flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        Login
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-text-secondary">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="text-accent hover:text-accent-hover font-medium">
                            Daftar Sekarang
                        </a>
                    </p>
                </div>

                {{-- Divider --}}
                <div class="flex items-center gap-4 my-6">
                    <div class="flex-1 h-px bg-light-border dark:bg-dark-border"></div>
                    <span class="text-xs text-text-secondary uppercase tracking-wide">atau</span>
                    <div class="flex-1 h-px bg-light-border dark:bg-dark-border"></div>
                </div>

                {{-- Social Login =====
                     CATATAN: tombol ini butuh backend Socialite (paket
                     laravel/socialite) untuk benar-benar berfungsi.
                     - Google: relatif mudah, tinggal daftar OAuth client
                       di Google Cloud Console.
                     - Apple ("Sign in with Apple"): butuh Apple Developer
                       Program (berbayar) + konfigurasi Services ID/Key,
                       jauh lebih rumit dari Google. Siapkan dulu backend-nya
                       (route + controller redirect/callback) sebelum tombol
                       ini benar-benar bisa dipakai.
                --}}
                <div class="space-y-3">
                    <a href="#"
                       class="w-full flex items-center justify-center gap-3 border border-light-border dark:border-dark-border rounded-lg py-2.5 px-4 text-sm font-medium text-text-primary dark:text-text-dark-primary hover:bg-light-surface dark:hover:bg-dark-surface transition-colors">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        Continue with Google
                    </a>
                    <a href="#"
                       class="w-full flex items-center justify-center gap-3 border border-light-border dark:border-dark-border rounded-lg py-2.5 px-4 text-sm font-medium text-text-primary dark:text-text-dark-primary hover:bg-light-surface dark:hover:bg-dark-surface transition-colors">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M16.365 1.43c0 1.14-.463 2.257-1.222 3.07-.803.86-2.104 1.516-3.24 1.516-.145 0-.29-.02-.397-.036-.017-.086-.036-.24-.036-.394 0-1.14.532-2.257 1.246-3.02.83-.9 2.187-1.51 3.246-1.55.017.14.035.276.035.414zm3.808 15.02c-.045.13-.7 2.394-2.316 4.715-1.4 2.01-2.855 4.017-5.148 4.06-2.253.042-2.98-1.335-5.556-1.335-2.575 0-3.38 1.293-5.512 1.377-2.214.083-3.904-2.176-5.318-4.18-2.89-4.115-5.096-11.63-2.132-16.7 1.472-2.51 4.106-4.1 6.968-4.14 2.172-.043 4.222 1.463 5.55 1.463 1.325 0 3.813-1.81 6.428-1.545 1.096.046 4.173.443 6.148 3.34-.16.1-3.673 2.14-3.637 6.395.04 5.086 4.463 6.78 4.525 6.807z"/>
                        </svg>
                        Continue with Apple
                    </a>
                </div>

                <!-- Demo Credentials -->
                <div class="mt-6 text-center text-sm text-text-secondary">
                    <p>Demo: admin@coresite.com / password</p>
                </div>
            </div>
        </div>

        <p class="text-center text-xs text-text-secondary mt-6">
            <a href="{{ route('landing') }}" class="hover:text-accent transition-colors inline-flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke beranda
            </a>
        </p>
    </div>
</div>
@endsection