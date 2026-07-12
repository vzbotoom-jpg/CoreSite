{{-- resources/views/landing/about.blade.php --}}
@extends('layouts.guest')

@section('title', 'Tentang CoreSite')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <!-- Header -->
    <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-bold text-text-primary dark:text-text-dark-primary mb-4">
            Tentang <span class="text-accent">CoreSite</span>
        </h1>
        <p class="text-lg text-text-secondary dark:text-text-dark-secondary max-w-2xl mx-auto">
            Memberdayakan UMKM Indonesia dengan teknologi toko online dan sistem kasir modern
        </p>
    </div>
    
    <!-- Mission -->
    <div class="grid md:grid-cols-2 gap-12 items-center mb-16">
        <div>
            <h2 class="text-3xl font-bold text-text-primary dark:text-text-dark-primary mb-4">Misi Kami</h2>
            <p class="text-text-secondary dark:text-text-dark-secondary mb-4 leading-relaxed">
                CoreSite didirikan dengan misi untuk membantu UMKM Indonesia bertransformasi digital. 
                Kami percaya bahwa setiap bisnis, sekecil apapun, berhak memiliki toko online profesional 
                dengan sistem kasir yang mudah digunakan.
            </p>
            <p class="text-text-secondary dark:text-text-dark-secondary leading-relaxed">
                Dengan teknologi yang kami kembangkan, kami ingin menghilangkan kerumitan teknis 
                sehingga pemilik bisnis bisa fokus pada apa yang terbaik: mengembangkan usaha mereka.
            </p>
            <div class="mt-6 flex gap-4">
                <div class="bg-accent/10 rounded-lg px-4 py-3 text-center">
                    <div class="text-2xl font-bold text-accent">2024</div>
                    <div class="text-xs text-text-secondary">Tahun Berdiri</div>
                </div>
                <div class="bg-accent/10 rounded-lg px-4 py-3 text-center">
                    <div class="text-2xl font-bold text-accent">1000+</div>
                    <div class="text-xs text-text-secondary">UMKM Bergabung</div>
                </div>
                <div class="bg-accent/10 rounded-lg px-4 py-3 text-center">
                    <div class="text-2xl font-bold text-accent">4.9</div>
                    <div class="text-xs text-text-secondary">Rating Pengguna</div>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-accent/10 to-accent/5 rounded-2xl p-8">
            <div class="relative">
                <div class="absolute -top-4 -left-4 w-20 h-20 bg-accent/20 rounded-full blur-2xl"></div>
                <div class="relative bg-light-bg dark:bg-dark-bg rounded-xl p-6 shadow-lg">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 bg-accent/10 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-text-primary dark:text-text-dark-primary">CoreSite</p>
                            <p class="text-xs text-text-secondary">v1.0.0</p>
                        </div>
                    </div>
                    <p class="text-text-secondary dark:text-text-dark-secondary text-sm leading-relaxed">
                        "Kami percaya teknologi harus menjadi alat yang memudahkan, bukan mempersulit. 
                        CoreSite hadir untuk membantu UMKM naik kelas dengan solusi digital yang sederhana dan terjangkau."
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Values -->
    <div class="mb-16">
        <h2 class="text-3xl font-bold text-text-primary dark:text-text-dark-primary text-center mb-8">Nilai-Nilai Kami</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="text-center p-6 border border-light-border dark:border-dark-border rounded-xl hover:shadow-lg transition-shadow">
                <div class="w-16 h-16 bg-accent/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary mb-2">Terpercaya</h3>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Keamanan data adalah prioritas utama kami</p>
            </div>
            <div class="text-center p-6 border border-light-border dark:border-dark-border rounded-xl hover:shadow-lg transition-shadow">
                <div class="w-16 h-16 bg-accent/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary mb-2">Inovatif</h3>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Terus berinovasi untuk kebutuhan bisnis modern</p>
            </div>
            <div class="text-center p-6 border border-light-border dark:border-dark-border rounded-xl hover:shadow-lg transition-shadow">
                <div class="w-16 h-16 bg-accent/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary mb-2">Kolaboratif</h3>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Bekerja sama dengan mitra terbaik</p>
            </div>
        </div>
    </div>
    
    <!-- Team -->
    <div>
        <h2 class="text-3xl font-bold text-text-primary dark:text-text-dark-primary text-center mb-8">Tim Kami</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="text-center">
                <div class="w-24 h-24 bg-accent/10 rounded-full flex items-center justify-center mx-auto mb-3">
                    <span class="text-3xl font-bold text-accent">A</span>
                </div>
                <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Ahmad Rizki</h4>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">CEO & Founder</p>
            </div>
            <div class="text-center">
                <div class="w-24 h-24 bg-accent/10 rounded-full flex items-center justify-center mx-auto mb-3">
                    <span class="text-3xl font-bold text-accent">S</span>
                </div>
                <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Siti Wardah</h4>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">CTO</p>
            </div>
            <div class="text-center">
                <div class="w-24 h-24 bg-accent/10 rounded-full flex items-center justify-center mx-auto mb-3">
                    <span class="text-3xl font-bold text-accent">B</span>
                </div>
                <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Budi Santoso</h4>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Head of Product</p>
            </div>
            <div class="text-center">
                <div class="w-24 h-24 bg-accent/10 rounded-full flex items-center justify-center mx-auto mb-3">
                    <span class="text-3xl font-bold text-accent">D</span>
                </div>
                <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Dewi Lestari</h4>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Head of Marketing</p>
            </div>
        </div>
    </div>
</div>
@endsection