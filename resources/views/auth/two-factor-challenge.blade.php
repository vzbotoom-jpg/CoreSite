{{-- resources/views/auth/two-factor-challenge.blade.php --}}
@extends('layouts.guest')

@section('title', 'Verifikasi Dua Langkah')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <div class="text-center mb-8">
            <a href="{{ route('landing') }}" class="inline-flex items-center gap-2">
                <div class="w-10 h-10 bg-accent rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold text-xl">C</span>
                </div>
                <span class="text-2xl font-bold text-text-primary dark:text-text-dark-primary">CoreSite</span>
            </a>
            <h2 class="mt-6 text-2xl font-bold text-text-primary dark:text-text-dark-primary">Verifikasi Dua Langkah</h2>
            <p class="mt-2 text-text-secondary dark:text-text-dark-secondary">
                Masukkan kode verifikasi dari aplikasi authenticator Anda
            </p>
        </div>
        
        <div class="card">
            <div class="card-body">
                <!-- Icon -->
                <div class="mb-6 text-center">
                    <div class="w-16 h-16 bg-accent/10 rounded-full flex items-center justify-center mx-auto">
                        <svg class="w-8 h-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary mt-3">
                        Buka aplikasi authenticator seperti Google Authenticator atau Authy
                    </p>
                </div>
                
                <form method="POST" action="{{ route('two-factor.login') }}">
                    @csrf
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">
                            Kode Verifikasi
                        </label>
                        <div class="relative">
                            <input type="text" name="code" required autofocus 
                                   class="input text-center text-2xl tracking-[0.5em] font-mono"
                                   placeholder="000000"
                                   maxlength="6"
                                   autocomplete="one-time-code">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                        </div>
                        @error('code')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-full">
                        Verifikasi
                    </button>
                </form>
                
                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-light-border dark:border-dark-border"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-light-bg dark:bg-dark-bg text-text-secondary dark:text-text-dark-secondary">
                                Atau gunakan kode recovery
                            </span>
                        </div>
                    </div>
                    
                    <form method="POST" action="{{ route('two-factor.login') }}" class="mt-6">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">
                                Kode Recovery
                            </label>
                            <input type="text" name="recovery_code" 
                                   class="input text-center font-mono"
                                   placeholder="xxxx-xxxx-xxxx-xxxx"
                                   autocomplete="off">
                            @error('recovery_code')
                                <p class="text-error text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-secondary w-full">
                            Gunakan Kode Recovery
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Help Text -->
        <div class="mt-6 text-center">
            <p class="text-sm text-text-secondary dark:text-text-dark-secondary">
                Kehilangan akses ke authenticator? 
                <a href="{{ route('login') }}" class="text-accent hover:text-accent-hover transition-colors">
                    Login dengan password
                </a>
            </p>
        </div>
    </div>
</div>
@endsection