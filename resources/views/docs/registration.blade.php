@extends('layouts.docs')

@section('title', 'Cara Registrasi - Dokumentasi CoreSite')

@section('content')
<div class="prose prose-slate dark:prose-invert max-w-none">
    <p class="text-lg text-text-secondary dark:text-text-dark-secondary leading-relaxed">
        Daftar akun CoreSite dengan mudah dan mulai gunakan semua fitur yang tersedia.
    </p>

    <div class="bg-accent/5 border-l-4 border-accent rounded-r-lg p-4 my-6">
        <strong class="text-accent">✨ Registrasi Gratis!</strong><br>
        <span class="text-text-secondary dark:text-text-dark-secondary">Pendaftaran awal gratis! Anda bisa mencoba semua fitur CoreSite sebelum memilih paket berlangganan.</span>
    </div>

    <h2>Langkah-langkah Registrasi</h2>
    
    <div class="space-y-6 my-8">
        <!-- Step 1 -->
        <div class="flex gap-4 items-start">
            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-accent text-white flex items-center justify-center font-bold text-sm">1</div>
            <div>
                <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Kunjungi Halaman Registrasi</h4>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">
                    Buka halaman <a href="{{ route('register') }}" class="text-accent hover:underline">Daftar Akun</a> di website CoreSite.
                </p>
            </div>
        </div>
        
        <!-- Step 2 -->
        <div class="flex gap-4 items-start">
            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-accent text-white flex items-center justify-center font-bold text-sm">2</div>
            <div>
                <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Isi Formulir Pendaftaran</h4>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">
                    Lengkapi data berikut:
                </p>
                <ul class="text-sm text-text-secondary dark:text-text-dark-secondary mt-2">
                    <li>• Nama lengkap</li>
                    <li>• Alamat email aktif</li>
                    <li>• Nomor telepon</li>
                    <li>• Nama perusahaan (opsional)</li>
                    <li>• Kata sandi yang aman</li>
                </ul>
            </div>
        </div>
        
        <!-- Step 3 -->
        <div class="flex gap-4 items-start">
            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-accent text-white flex items-center justify-center font-bold text-sm">3</div>
            <div>
                <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Verifikasi Email</h4>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">
                    Buka email verifikasi yang kami kirimkan dan klik tautan untuk mengaktifkan akun Anda.
                </p>
            </div>
        </div>
        
        <!-- Step 4 -->
        <div class="flex gap-4 items-start">
            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-accent text-white flex items-center justify-center font-bold text-sm">4</div>
            <div>
                <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Pilih Paket</h4>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">
                    Pilih paket yang sesuai dengan kebutuhan bisnis Anda. 
                    <a href="{{ route('docs.show', 'subscription') }}" class="text-accent hover:underline">Lihat paket dan harga</a>.
                </p>
            </div>
        </div>
        
        <!-- Step 5 -->
        <div class="flex gap-4 items-start">
            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-accent text-white flex items-center justify-center font-bold text-sm">5</div>
            <div>
                <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Mulai Menggunakan CoreSite</h4>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">
                    Login ke dashboard dan mulai kelola bisnis Anda!
                </p>
            </div>
        </div>
    </div>

    <div class="bg-green-50 dark:bg-green-950/30 border-l-4 border-green-500 rounded-r-lg p-6 my-8">
        <div class="flex items-start gap-4">
            <svg class="w-6 h-6 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Registrasi Gratis</h4>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">
                    Pendaftaran awal gratis! Anda bisa mencoba semua fitur CoreSite sebelum memilih paket berlangganan.
                </p>
            </div>
        </div>
    </div>

    <h2>Butuh Bantuan?</h2>
    <p>
        Jika mengalami kendala saat registrasi, hubungi tim dukungan kami:
    </p>
    <ul>
        <li>Email: <a href="mailto:support@coresite.com" class="text-accent">support@coresite.com</a></li>
    </ul>
</div>
@endsection