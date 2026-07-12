{{-- resources/views/auth/verify-email.blade.php --}}
@extends('layouts.guest')

@section('title', 'Verifikasi Email')

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
            <h2 class="mt-6 text-2xl font-bold text-text-primary dark:text-text-dark-primary">Verifikasi Email Anda</h2>
            <p class="mt-2 text-text-secondary dark:text-text-dark-secondary">
                Kami telah mengirimkan link verifikasi ke email Anda
            </p>
        </div>
        
        <div class="card">
            <div class="card-body text-center">
                <!-- Icon -->
                <div class="mb-6">
                    <div class="w-20 h-20 bg-accent/10 rounded-full flex items-center justify-center mx-auto">
                        <svg class="w-10 h-10 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
                
                @if (session('resent'))
                    <div class="mb-4 p-4 bg-success/10 border border-success/20 text-success rounded-lg text-sm">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Link verifikasi baru telah dikirim ke email Anda.</span>
                        </div>
                    </div>
                @endif
                
                <p class="text-text-secondary dark:text-text-dark-secondary text-sm mb-6">
                    Sebelum melanjutkan, silakan cek email Anda untuk link verifikasi.
                    Jika Anda tidak menerima email, klik tombol di bawah.
                </p>
                
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary w-full">
                        Kirim Ulang Email Verifikasi
                    </button>
                </form>
                
                <div class="mt-6 pt-6 border-t border-light-border dark:border-dark-border">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-text-secondary dark:text-text-dark-secondary hover:text-accent transition-colors">
                            Logout
                        </button>
                    </form>
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
@endsection