{{-- resources/views/auth/confirm-password.blade.php --}}
@extends('layouts.guest')

@section('title', 'Konfirmasi Password')

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
            <h2 class="mt-6 text-2xl font-bold text-text-primary dark:text-text-dark-primary">Konfirmasi Password</h2>
            <p class="mt-2 text-text-secondary dark:text-text-dark-secondary">
                Silakan konfirmasi password Anda untuk melanjutkan
            </p>
        </div>
        
        <div class="card">
            <div class="card-body">
                <!-- Icon -->
                <div class="mb-6 text-center">
                    <div class="w-16 h-16 bg-warning/10 rounded-full flex items-center justify-center mx-auto">
                        <svg class="w-8 h-8 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary mt-3">
                        Area ini membutuhkan verifikasi keamanan tambahan
                    </p>
                </div>
                
                @if (session('status'))
                    <div class="mb-4 p-4 bg-success/10 border border-success/20 text-success rounded-lg text-sm">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ session('status') }}</span>
                        </div>
                    </div>
                @endif
                
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-error/10 border border-error/20 text-error rounded-lg text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <input type="password" name="password" required autofocus 
                                   class="input" 
                                   placeholder="Masukkan password Anda"
                                   autocomplete="current-password">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <button type="button" onclick="togglePasswordVisibility(this)" 
                                        class="text-text-secondary hover:text-text-primary transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @error('password')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-full">
                        Konfirmasi Password
                    </button>
                </form>
                
                <div class="mt-6 pt-6 border-t border-light-border dark:border-dark-border">
                    <p class="text-center text-sm text-text-secondary dark:text-text-dark-secondary">
                        <a href="{{ route('password.request') }}" class="text-accent hover:text-accent-hover transition-colors">
                            Lupa password?
                        </a>
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Help Text -->
        <p class="mt-6 text-center text-sm text-text-secondary dark:text-text-dark-secondary">
            Butuh bantuan? 
            <a href="mailto:support@coresite.com" class="text-accent hover:text-accent-hover transition-colors">
                Hubungi Support
            </a>
        </p>
    </div>
</div>

@push('scripts')
<script>
    function togglePasswordVisibility(button) {
        const input = button.closest('.relative').querySelector('input');
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);
        
        // Toggle icon
        const svg = button.querySelector('svg');
        if (type === 'text') {
            svg.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
            `;
        } else {
            svg.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            `;
        }
    }
</script>
@endpush
@endsection