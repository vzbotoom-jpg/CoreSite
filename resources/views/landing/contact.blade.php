{{-- resources/views/landing/contact.blade.php --}}
@extends('layouts.guest')

@section('title', 'Kontak - CoreSite')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <h1 class="text-heading-1 mb-4">Hubungi Kami</h1>
        <p class="text-body-lg text-text-secondary max-w-2xl mx-auto">
            Ada pertanyaan? Tim kami siap membantu Anda
        </p>
    </div>
    
    <div class="grid md:grid-cols-2 gap-12">
        <div>
            <form method="POST" action="{{ route('contact.submit') }}" class="card">
                @csrf
                <div class="card-body">
                    <h3 class="text-xl font-semibold mb-6">Kirim Pesan</h3>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Nama Lengkap</label>
                        <input type="text" name="name" required class="input">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Email</label>
                        <input type="email" name="email" required class="input">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Subjek</label>
                        <input type="text" name="subject" required class="input">
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-2">Pesan</label>
                        <textarea name="message" rows="5" required class="input"></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-full">Kirim Pesan</button>
                </div>
            </form>
        </div>
        
        <div>
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4">Informasi Kontak</h3>
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <div>
                            <p class="font-medium">Email</p>
                            <p class="text-text-secondary">hello@coresite.com</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <div>
                            <p class="font-medium">Telepon</p>
                            <p class="text-text-secondary">+62 21 1234 5678</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <div>
                            <p class="font-medium">Alamat</p>
                            <p class="text-text-secondary">Jakarta, Indonesia</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div>
                <h3 class="text-xl font-semibold mb-4">Jam Operasional</h3>
                <div class="space-y-2 text-text-secondary">
                    <p>Senin - Jumat: 09:00 - 18:00 WIB</p>
                    <p>Sabtu: 09:00 - 13:00 WIB</p>
                    <p>Minggu: Tutup</p>
                </div>
            </div>

            {{-- Komitmen respon — menghilangkan keraguan "apakah pesan saya
                 akan dibalas" sebelum orang mengirim form --}}
            <div class="mt-6 flex items-center gap-3 bg-accent/5 border border-accent/20 rounded-xl px-4 py-3">
                <svg class="w-5 h-5 text-accent flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm text-text-secondary">Kami biasanya membalas pesan dalam <strong class="text-text-primary">kurang dari 24 jam</strong> di jam kerja.</p>
            </div>
        </div>
    </div>
</div>
@endsection