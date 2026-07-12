{{-- resources/views/landing/faq.blade.php --}}
@extends('layouts.landing')

@section('title', 'FAQ - CoreSite')
@section('description', 'Pertanyaan yang sering diajukan tentang CoreSite.')

@section('content')
<section class="py-20">
    <div class="container mx-auto px-4">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h1 class="text-4xl md:text-5xl font-bold text-text-primary dark:text-text-dark-primary mb-4">
                Pertanyaan yang <span class="text-accent">Sering Diajukan</span>
            </h1>
            <p class="text-text-secondary dark:text-text-dark-secondary">
                Temukan jawaban untuk pertanyaan paling umum tentang CoreSite
            </p>
        </div>

        <div class="max-w-3xl mx-auto space-y-4">
            <div x-data="{ open: false }" class="card">
                <button @click="open = !open" class="w-full text-left card-body">
                    <div class="flex justify-between items-center">
                        <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Apa itu CoreSite?</h3>
                        <svg class="w-5 h-5 text-text-secondary transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                    <div x-show="open" x-collapse class="mt-4">
                        <p class="text-text-secondary">CoreSite adalah platform toko online dan kasir otomatis yang dirancang khusus untuk UMKM Indonesia. Kami membantu Anda memiliki website toko profesional dan sistem kasir terintegrasi dalam hitungan menit.</p>
                    </div>
                </button>
            </div>

            <div x-data="{ open: false }" class="card">
                <button @click="open = !open" class="w-full text-left card-body">
                    <div class="flex justify-between items-center">
                        <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Apakah ada biaya pendaftaran?</h3>
                        <svg class="w-5 h-5 text-text-secondary transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                    <div x-show="open" x-collapse class="mt-4">
                        <p class="text-text-secondary">Tidak ada biaya pendaftaran. Anda bisa memulai dengan paket gratis (Starter) dan upgrade kapan saja sesuai kebutuhan bisnis Anda.</p>
                    </div>
                </button>
            </div>

            <div x-data="{ open: false }" class="card">
                <button @click="open = !open" class="w-full text-left card-body">
                    <div class="flex justify-between items-center">
                        <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Bagaimana cara membuat toko online?</h3>
                        <svg class="w-5 h-5 text-text-secondary transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                    <div x-show="open" x-collapse class="mt-4">
                        <p class="text-text-secondary">Setelah mendaftar, Anda akan dipandu melalui proses setup toko. Anda bisa menambahkan produk, mengatur tampilan toko, dan mulai berjualan dalam hitungan menit. Tidak perlu keahlian teknis!</p>
                    </div>
                </button>
            </div>

            <div x-data="{ open: false }" class="card">
                <button @click="open = !open" class="w-full text-left card-body">
                    <div class="flex justify-between items-center">
                        <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Apakah bisa digunakan untuk beberapa toko?</h3>
                        <svg class="w-5 h-5 text-text-secondary transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                    <div x-show="open" x-collapse class="mt-4">
                        <p class="text-text-secondary">Ya! Dengan paket Pro dan Enterprise, Anda bisa mengelola beberapa toko sekaligus dalam satu akun. Sangat cocok untuk pebisnis dengan multiple outlet atau cabang.</p>
                    </div>
                </button>
            </div>

            <div x-data="{ open: false }" class="card">
                <button @click="open = !open" class="w-full text-left card-body">
                    <div class="flex justify-between items-center">
                        <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Apa saja metode pembayaran yang tersedia?</h3>
                        <svg class="w-5 h-5 text-text-secondary transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                    <div x-show="open" x-collapse class="mt-4">
                        <p class="text-text-secondary">CoreSite mendukung berbagai metode pembayaran termasuk QRIS, transfer bank, dan pembayaran tunai. Kami terus menambahkan integrasi pembayaran baru untuk memudahkan pelanggan Anda.</p>
                    </div>
                </button>
            </div>

            <div x-data="{ open: false }" class="card">
                <button @click="open = !open" class="w-full text-left card-body">
                    <div class="flex justify-between items-center">
                        <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Apakah ada dukungan jika saya mengalami masalah?</h3>
                        <svg class="w-5 h-5 text-text-secondary transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                    <div x-show="open" x-collapse class="mt-4">
                        <p class="text-text-secondary">Tentu saja! Kami menyediakan dukungan melalui email, chat, dan dokumentasi lengkap. Untuk pelanggan Pro dan Enterprise, kami menyediakan dukungan prioritas dengan respon lebih cepat.</p>
                    </div>
                </button>
            </div>

            <div x-data="{ open: false }" class="card">
                <button @click="open = !open" class="w-full text-left card-body">
                    <div class="flex justify-between items-center">
                        <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Bagaimana cara upgrade paket?</h3>
                        <svg class="w-5 h-5 text-text-secondary transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                    <div x-show="open" x-collapse class="mt-4">
                        <p class="text-text-secondary">Anda bisa upgrade paket kapan saja melalui dashboard. Proses upgrade instan dan semua data toko Anda akan tetap tersimpan. Tidak ada risiko kehilangan data.</p>
                    </div>
                </button>
            </div>
        </div>
    </div>
</section>
@endsection