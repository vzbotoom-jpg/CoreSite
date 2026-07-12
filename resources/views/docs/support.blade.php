@extends('layouts.docs')

@section('title', 'Hubungi Dukungan')

@section('content')
<div class="prose prose-slate dark:prose-invert max-w-none">
    <p class="text-lg text-text-secondary dark:text-text-dark-secondary leading-relaxed">
        Tim dukungan CoreSite siap membantu Anda 24/7.
    </p>

    <div class="grid md:grid-cols-2 gap-4 my-8">
        <div class="bg-light-surface dark:bg-dark-surface/50 rounded-xl p-6 border border-light-border/40 dark:border-dark-border/40">
            <div class="flex items-center gap-3 mb-3">
                <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Email</h4>
            </div>
            <a href="mailto:support@coresite.com" class="text-accent hover:underline">
                support@coresite.com
            </a>
            <p class="text-sm text-text-secondary/60 mt-1">Balasan dalam 24 jam</p>
        </div>
        
        <div class="bg-light-surface dark:bg-dark-surface/50 rounded-xl p-6 border border-light-border/40 dark:border-dark-border/40">
            <div class="flex items-center gap-3 mb-3">
                <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">WhatsApp</h4>
            </div>
            <a href="https://wa.me/628123456789" class="text-accent hover:underline">
                +62 812-3456-789
            </a>
            <p class="text-sm text-text-secondary/60 mt-1">Respons cepat</p>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-4 my-8">
        <div class="bg-light-surface dark:bg-dark-surface/50 rounded-xl p-6 border border-light-border/40 dark:border-dark-border/40">
            <div class="flex items-center gap-3 mb-3">
                <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">FAQ</h4>
            </div>
            <a href="{{ route('docs.show', 'faq') }}" class="text-accent hover:underline">
                Lihat Pertanyaan Umum
            </a>
            <p class="text-sm text-text-secondary/60 mt-1">Temukan jawaban cepat</p>
        </div>
        
        <div class="bg-light-surface dark:bg-dark-surface/50 rounded-xl p-6 border border-light-border/40 dark:border-dark-border/40">
            <div class="flex items-center gap-3 mb-3">
                <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Dokumentasi</h4>
            </div>
            <a href="{{ route('docs.show', 'introduction') }}" class="text-accent hover:underline">
                Baca Dokumentasi
            </a>
            <p class="text-sm text-text-secondary/60 mt-1">Panduan lengkap</p>
        </div>
    </div>

    <div class="bg-light-surface dark:bg-dark-surface/50 rounded-xl p-6 my-8 border border-light-border/40 dark:border-dark-border/40">
        <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Jam Operasional Dukungan</h4>
        <ul class="mt-2 space-y-1 text-sm text-text-secondary">
            <li>Senin - Jumat: 08:00 - 21:00 WIB</li>
            <li>Sabtu: 09:00 - 17:00 WIB</li>
            <li>Minggu: Tutup</li>
        </ul>
        <p class="text-sm text-text-secondary/60 mt-3">
            *Dukungan prioritas untuk pengguna Enterprise tersedia 24/7
        </p>
    </div>

    <h2>Kirim Pertanyaan</h2>
    <p>
        Anda juga dapat mengirimkan pertanyaan melalui form kontak di bawah ini:
    </p>
    
    <div class="bg-light-surface dark:bg-dark-surface/50 rounded-xl p-6 my-4 border border-light-border/40 dark:border-dark-border/40">
        <form action="#" method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-1">
                    Nama
                </label>
                <input type="text" class="w-full px-4 py-2 bg-light-bg dark:bg-dark-bg border border-light-border dark:border-dark-border rounded-lg text-text-primary dark:text-text-dark-primary focus:ring-1 focus:ring-accent transition outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-1">
                    Email
                </label>
                <input type="email" class="w-full px-4 py-2 bg-light-bg dark:bg-dark-bg border border-light-border dark:border-dark-border rounded-lg text-text-primary dark:text-text-dark-primary focus:ring-1 focus:ring-accent transition outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-1">
                    Pesan
                </label>
                <textarea rows="4" class="w-full px-4 py-2 bg-light-bg dark:bg-dark-bg border border-light-border dark:border-dark-border rounded-lg text-text-primary dark:text-text-dark-primary focus:ring-1 focus:ring-accent transition outline-none"></textarea>
            </div>
            <button type="submit" class="px-6 py-2.5 bg-accent text-white font-medium rounded-lg hover:opacity-80 transition">
                Kirim Pesan
            </button>
        </form>
    </div>
</div>
@endsection