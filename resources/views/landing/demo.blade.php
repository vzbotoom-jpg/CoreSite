{{-- resources/views/landing/demo.blade.php --}}
@extends('layouts.landing')

@section('title', 'Demo Langsung - CoreSite')
@section('description', 'Lihat dan coba langsung demo dashboard kasir otomatis dan website toko online CoreSite secara interaktif.')

@section('content')
<section class="py-20 bg-light-bg dark:bg-dark-bg text-text-primary dark:text-text-dark-primary" x-data="demoWalkthrough()">
    <div class="container mx-auto px-4">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="inline-flex items-center gap-2 px-3 py-1 bg-accent/10 text-accent text-sm font-medium rounded-full">
                🚀 Uji Coba Instan
            </span>
            <h1 class="text-4xl md:text-5xl font-bold tracking-tight mt-4">
                Lihat & Coba <span class="text-accent text-emerald-400">Demo Langsung</span>
            </h1>
            <p class="text-text-secondary dark:text-text-dark-secondary mt-4">
                Tonton video panduan cepat kami atau masuk langsung ke dashboard kasir demo interaktif menggunakan akun sandbox gratis.
            </p>
        </div>

        <!-- Video Demo Section -->
        <div class="card p-0 overflow-hidden max-w-4xl mx-auto mb-16 border border-light-border dark:border-dark-border bg-black relative shadow-2xl rounded-2xl">
            <div class="aspect-w-16 aspect-h-9 relative" style="min-height: 400px;">
                <!-- Thumbnail Placeholder / Play Overlay -->
                <div x-show="!playing" class="absolute inset-0 flex flex-col items-center justify-center bg-dark-surface/90 text-center z-20">
                    <button @click="playVideo" class="w-20 h-20 bg-accent rounded-full flex items-center justify-center hover:bg-accent-hover transition shadow-lg shadow-accent/30 mx-auto transform hover:scale-105">
                        <svg class="w-10 h-10 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                    </button>
                    <p class="text-white font-bold mt-4 text-sm">Tonton Video Tour Fitur CoreSite (2 Menit)</p>
                    <p class="text-text-secondary text-xs mt-1">Lihat ringkasan workflow kasir dan catalog</p>
                </div>

                <!-- YouTube Video Embed (When clicked) -->
                <template x-if="playing">
                    <iframe class="w-full h-full absolute inset-0" src="https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1" title="CoreSite Demo Video" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </template>
            </div>
        </div>

        <!-- Interactive Sandbox Section (NEW) -->
        <div class="max-w-3xl mx-auto text-center space-y-6 bg-accent/5 border border-accent/20 rounded-2xl p-8 shadow-sm">
            <div class="w-12 h-12 bg-accent/10 text-accent rounded-full flex items-center justify-center mx-auto shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                </svg>
            </div>
            <div>
                <h3 class="text-xl font-bold text-text-primary dark:text-text-dark-primary">Coba Interactive Sandbox Dashboard</h3>
                <p class="text-xs text-text-secondary max-w-md mx-auto leading-relaxed mt-2">
                    Masuk langsung ke dashboard demo interaktif kami tanpa mendaftar. Anda bisa mencoba simulasi input kasir (POS), menambah stok produk, dan menguji e-catalog.
                </p>
            </div>

            <div class="bg-white dark:bg-dark-surface p-4 rounded-xl border border-light-border dark:border-dark-border max-w-sm mx-auto space-y-2 text-xs">
                <p class="font-bold text-text-primary dark:text-text-dark-primary text-center">Kredensial Login Demo:</p>
                <div class="flex justify-between items-center border-b border-light-border dark:border-dark-border/40 pb-2">
                    <span class="text-text-secondary">Email:</span>
                    <span class="font-mono font-bold text-accent">demo@coresite.com</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-text-secondary">Password:</span>
                    <span class="font-mono font-bold text-accent">demo123</span>
                </div>
            </div>

            <div class="flex justify-center pt-2">
                <a href="{{ route('login') }}" class="btn btn-primary text-xs font-bold py-2.5 px-6 rounded-xl shadow-lg shadow-accent/20">
                    Masuk ke Demo Dashboard →
                </a>
            </div>
        </div>

        <!-- Walkthrough Steps Cards -->
        <div class="mt-20">
            <h3 class="text-xl font-bold text-center text-text-primary dark:text-text-dark-primary mb-10">Tiga Langkah Mudah Menggunakan CoreSite</h3>
            <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <div class="card text-center bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border p-6 hover:shadow-md transition">
                    <div class="w-14 h-14 bg-accent/10 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <span class="text-accent font-extrabold text-lg">1</span>
                    </div>
                    <h3 class="font-bold text-text-primary dark:text-text-dark-primary mb-2 text-sm">Buat Akun & Toko</h3>
                    <p class="text-xs text-text-secondary leading-relaxed">Daftarkan akun dan nama toko Anda dalam 1 menit. Sistem akan langsung mengaktifkan URL e-catalog publik untuk Anda.</p>
                </div>

                <div class="card text-center bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border p-6 hover:shadow-md transition">
                    <div class="w-14 h-14 bg-accent/10 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <span class="text-accent font-extrabold text-lg">2</span>
                    </div>
                    <h3 class="font-bold text-text-primary dark:text-text-dark-primary mb-2 text-sm">Input Produk & Stok</h3>
                    <p class="text-xs text-text-secondary leading-relaxed">Tambahkan katalog foto produk Anda, kategori, dan sisa stok. Produk Anda akan otomatis terpajang di e-catalog.</p>
                </div>

                <div class="card text-center bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border p-6 hover:shadow-md transition">
                    <div class="w-14 h-14 bg-accent/10 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <span class="text-accent font-extrabold text-lg">3</span>
                    </div>
                    <h3 class="font-bold text-text-primary dark:text-text-dark-primary mb-2 text-sm">Mulai Catat Transaksi</h3>
                    <p class="text-xs text-text-secondary leading-relaxed">Gunakan menu kasir (POS) untuk memproses pesanan. Laporan untung rugi dan grafik penjualan akan terisi otomatis!</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function demoWalkthrough() {
    return {
        playing: false,
        playVideo() {
            this.playing = true;
        }
    }
}
</script>
@endsection