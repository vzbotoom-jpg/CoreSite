{{-- resources/views/landing/demo.blade.php --}}
@extends('layouts.guest')

@section('title', 'Demo - CoreSite')
@section('description', 'Lihat demo langsung platform CoreSite untuk toko online dan kasir otomatis.')

@section('content')
<section class="py-20">
    <div class="container mx-auto px-4">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h1 class="text-4xl md:text-5xl font-bold text-text-primary dark:text-text-dark-primary mb-4">
                Lihat <span class="text-accent">Demo</span> Langsung
            </h1>
            <p class="text-text-secondary dark:text-text-dark-secondary">
                Lihat bagaimana CoreSite bekerja secara langsung. Kami akan memandu Anda melalui semua fitur.
            </p>
        </div>

        <!-- Video Demo -->
        <div class="card p-0 overflow-hidden max-w-4xl mx-auto mb-12">
            <div class="aspect-w-16 aspect-h-9 bg-dark-surface">
                <div class="flex items-center justify-center">
                    <div class="text-center">
                        <button onclick="playDemo()" class="w-20 h-20 bg-accent rounded-full flex items-center justify-center hover:bg-accent-hover transition shadow-lg shadow-accent/30 mx-auto">
                            <svg class="w-10 h-10 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </button>
                        <p class="text-text-secondary mt-4">Klik tombol untuk memutar demo</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Feature Demo Cards -->
        <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            <div class="card text-center">
                <div class="card-body">
                    <div class="w-14 h-14 bg-accent/10 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9l7-7 7 7V5a2 2 0 00-2-2H5a2 2 0 00-2 2v4z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9v10a2 2 0 002 2h14a2 2 0 002-2V9"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-text-primary dark:text-text-dark-primary mb-2">Dashboard Admin</h3>
                    <p class="text-sm text-text-secondary">Kelola produk, transaksi, dan laporan dari satu dashboard</p>
                </div>
            </div>

            <div class="card text-center">
                <div class="card-body">
                    <div class="w-14 h-14 bg-accent/10 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-text-primary dark:text-text-dark-primary mb-2">Kasir Otomatis</h3>
                    <p class="text-sm text-text-secondary">Proses transaksi cepat dengan sistem kasir terintegrasi</p>
                </div>
            </div>

            <div class="card text-center">
                <div class="card-body">
                    <div class="w-14 h-14 bg-accent/10 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-text-primary dark:text-text-dark-primary mb-2">E-Catalog Publik</h3>
                    <p class="text-sm text-text-secondary">Tampilkan produk ke pelanggan dengan halaman toko profesional</p>
                </div>
            </div>
        </div>

        <!-- CTA -->
        <div class="text-center mt-12">
            <a href="{{ route('register') }}" class="btn-primary text-lg px-8 py-3">
                Mulai Gratis Sekarang
                <svg class="w-5 h-5 ml-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
        </div>
    </div>
</section>

@push('scripts')
<script>
function playDemo() {
    alert('Demo video akan diputar. (Fitur ini sedang dalam pengembangan)');
}
</script>
@endpush
@endsection