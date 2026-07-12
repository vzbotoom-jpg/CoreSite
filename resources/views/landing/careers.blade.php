{{-- resources/views/landing/careers.blade.php --}}
@extends('layouts.guest')

@section('title', 'Karir - CoreSite')
@section('description', 'Bergabung dengan tim CoreSite dan bangun karir Anda.')

@section('content')
<section class="py-20">
    <div class="container mx-auto px-4 max-w-4xl">
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-bold text-text-primary dark:text-text-dark-primary mb-4">
                Bergabung dengan <span class="text-accent">CoreSite</span>
            </h1>
            <p class="text-text-secondary dark:text-text-dark-secondary">
                Bangun karir Anda bersama tim yang memberdayakan UMKM Indonesia
            </p>
        </div>

        <!-- Why Join -->
        <div class="grid md:grid-cols-3 gap-6 mb-12">
            <div class="card text-center">
                <div class="card-body">
                    <span class="text-4xl mb-3 block">💻</span>
                    <h4 class="font-bold text-text-primary dark:text-text-dark-primary">Remote Work</h4>
                    <p class="text-sm text-text-secondary">Bekerja dari mana saja dengan tim yang tersebar</p>
                </div>
            </div>
            <div class="card text-center">
                <div class="card-body">
                    <span class="text-4xl mb-3 block">🚀</span>
                    <h4 class="font-bold text-text-primary dark:text-text-dark-primary">Growth</h4>
                    <p class="text-sm text-text-secondary">Peluang berkembang dan belajar teknologi terbaru</p>
                </div>
            </div>
            <div class="card text-center">
                <div class="card-body">
                    <span class="text-4xl mb-3 block">🌍</span>
                    <h4 class="font-bold text-text-primary dark:text-text-dark-primary">Impact</h4>
                    <p class="text-sm text-text-secondary">Memberdayakan ribuan UMKM di Indonesia</p>
                </div>
            </div>
        </div>

        <!-- Open Positions -->
        <h2 class="text-2xl font-bold text-text-primary dark:text-text-dark-primary mb-6">Lowongan Terbuka</h2>
        
        <div class="space-y-4">
            <div class="card hover:shadow-lg transition">
                <div class="card-body">
                    <div class="flex flex-wrap justify-between items-start gap-4">
                        <div>
                            <h4 class="font-bold text-text-primary dark:text-text-dark-primary">Full Stack Developer</h4>
                            <p class="text-sm text-text-secondary">Engineering • Remote • Full-time</p>
                        </div>
                        <a href="#" class="btn-secondary text-sm">Lamar Sekarang</a>
                    </div>
                </div>
            </div>

            <div class="card hover:shadow-lg transition">
                <div class="card-body">
                    <div class="flex flex-wrap justify-between items-start gap-4">
                        <div>
                            <h4 class="font-bold text-text-primary dark:text-text-dark-primary">UI/UX Designer</h4>
                            <p class="text-sm text-text-secondary">Design • Remote • Full-time</p>
                        </div>
                        <a href="#" class="btn-secondary text-sm">Lamar Sekarang</a>
                    </div>
                </div>
            </div>

            <div class="card hover:shadow-lg transition">
                <div class="card-body">
                    <div class="flex flex-wrap justify-between items-start gap-4">
                        <div>
                            <h4 class="font-bold text-text-primary dark:text-text-dark-primary">Customer Success Manager</h4>
                            <p class="text-sm text-text-secondary">Support • Remote • Full-time</p>
                        </div>
                        <a href="#" class="btn-secondary text-sm">Lamar Sekarang</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA -->
        <div class="card bg-accent/5 border-accent/20 mt-8">
            <div class="card-body text-center">
                <p class="text-text-secondary">Tidak menemukan posisi yang cocok? Kirimkan lamaran spontan Anda.</p>
                <a href="mailto:careers@coresite.com" class="text-accent hover:underline font-medium">
                    careers@coresite.com →
                </a>
            </div>
        </div>
    </div>
</section>
@endsection