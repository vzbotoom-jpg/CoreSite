{{-- resources/views/landing/faq.blade.php --}}
@extends('layouts.landing')

@section('title', 'FAQ - CoreSite')
@section('description', 'Pertanyaan yang sering diajukan tentang platform e-catalog dan kasir otomatis CoreSite.')

@section('content')
<section class="py-20 bg-light-bg dark:bg-dark-bg text-text-primary dark:text-text-dark-primary" x-data="faqTabs()">
    <div class="container mx-auto px-4 max-w-4xl">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="inline-flex items-center gap-2 px-3 py-1 bg-accent/10 text-accent text-sm font-medium rounded-full">
                💡 FAQ
            </span>
            <h1 class="text-4xl md:text-5xl font-bold tracking-tight mt-4">
                Pertanyaan yang <span class="text-accent">Sering Diajukan</span>
            </h1>
            <p class="text-text-secondary dark:text-text-dark-secondary mt-4">
                Temukan jawaban cepat seputar fungsionalitas, keamanan data, dan cara penggunaan sistem CoreSite.
            </p>
        </div>

        <!-- FAQ Categories/Tabs (Alpine) -->
        <div class="flex flex-wrap items-center justify-center gap-2 mb-10">
            <button @click="activeTab = 'umum'" :class="activeTab === 'umum' ? 'bg-accent text-white' : 'bg-light-surface dark:bg-dark-surface hover:bg-accent/10 text-text-secondary dark:text-text-dark-secondary'" class="px-5 py-2 rounded-xl text-xs font-bold transition-all">
                Umum
            </button>
            <button @click="activeTab = 'kasir'" :class="activeTab === 'kasir' ? 'bg-accent text-white' : 'bg-light-surface dark:bg-dark-surface hover:bg-accent/10 text-text-secondary dark:text-text-dark-secondary'" class="px-5 py-2 rounded-xl text-xs font-bold transition-all">
                Fitur & Kasir
            </button>
            <button @click="activeTab = 'pembayaran'" :class="activeTab === 'pembayaran' ? 'bg-accent text-white' : 'bg-light-surface dark:bg-dark-surface hover:bg-accent/10 text-text-secondary dark:text-text-dark-secondary'" class="px-5 py-2 rounded-xl text-xs font-bold transition-all">
                Pembayaran
            </button>
            <button @click="activeTab = 'keamanan'" :class="activeTab === 'keamanan' ? 'bg-accent text-white' : 'bg-light-surface dark:bg-dark-surface hover:bg-accent/10 text-text-secondary dark:text-text-dark-secondary'" class="px-5 py-2 rounded-xl text-xs font-bold transition-all">
                Keamanan Data
            </button>
        </div>

        <!-- FAQ List -->
        <div class="space-y-4">
            <!-- TAB: UMUM -->
            <div x-show="activeTab === 'umum'" class="space-y-4">
                <div x-data="{ open: false }" class="card bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border">
                    <button @click="open = !open" class="w-full text-left card-body p-5">
                        <div class="flex justify-between items-center gap-4">
                            <h3 class="font-bold text-text-primary dark:text-text-dark-primary text-sm">Apa itu CoreSite?</h3>
                            <svg class="w-5 h-5 text-text-secondary transition-transform shrink-0" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                        <div x-show="open" x-collapse class="mt-4 text-xs text-text-secondary leading-relaxed border-t border-light-border dark:border-dark-border/40 pt-4">
                            CoreSite adalah platform toko online dan kasir otomatis yang dirancang khusus untuk UMKM Indonesia. Kami membantu Anda memiliki website toko profesional dan sistem kasir terintegrasi dalam hitungan menit tanpa keahlian coding.
                        </div>
                    </button>
                </div>

                <div x-data="{ open: false }" class="card bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border">
                    <button @click="open = !open" class="w-full text-left card-body p-5">
                        <div class="flex justify-between items-center gap-4">
                            <h3 class="font-bold text-text-primary dark:text-text-dark-primary text-sm">Apakah saya harus mendaftar pakai kartu kredit?</h3>
                            <svg class="w-5 h-5 text-text-secondary transition-transform shrink-0" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                        <div x-show="open" x-collapse class="mt-4 text-xs text-text-secondary leading-relaxed border-t border-light-border dark:border-dark-border/40 pt-4">
                            Sama sekali tidak! Anda dapat mendaftar dan menggunakan paket gratis kami selamanya tanpa harus memasukkan data kartu kredit atau detail perbankan apa pun.
                        </div>
                    </button>
                </div>
            </div>

            <!-- TAB: FITUR & KASIR -->
            <div x-show="activeTab === 'kasir'" class="space-y-4">
                <div x-data="{ open: false }" class="card bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border">
                    <button @click="open = !open" class="w-full text-left card-body p-5">
                        <div class="flex justify-between items-center gap-4">
                            <h3 class="font-bold text-text-primary dark:text-text-dark-primary text-sm">Bagaimana cara kerja kasir (POS) offline?</h3>
                            <svg class="w-5 h-5 text-text-secondary transition-transform shrink-0" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                        <div x-show="open" x-collapse class="mt-4 text-xs text-text-secondary leading-relaxed border-t border-light-border dark:border-dark-border/40 pt-4">
                            Sistem kasir CoreSite dirancang tangguh dengan local cache. Apabila koneksi internet terputus, kasir Anda tetap dapat menginput belanjaan dan memproses antrean. Begitu koneksi internet kembali pulih, seluruh log transaksi akan otomatis disinkronisasikan ke database server utama kami.
                        </div>
                    </button>
                </div>

                <div x-data="{ open: false }" class="card bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border">
                    <button @click="open = !open" class="w-full text-left card-body p-5">
                        <div class="flex justify-between items-center gap-4">
                            <h3 class="font-bold text-text-primary dark:text-text-dark-primary text-sm">Apakah CoreSite mendukung cetak struk thermal?</h3>
                            <svg class="w-5 h-5 text-text-secondary transition-transform shrink-0" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                        <div x-show="open" x-collapse class="mt-4 text-xs text-text-secondary leading-relaxed border-t border-light-border dark:border-dark-border/40 pt-4">
                            Ya, kasir CoreSite mendukung pencetakan struk belanja fisik secara instan. Platform kami kompatibel dengan mayoritas printer thermal bluetooth berukuran 58mm maupun 80mm langsung dari web browser.
                        </div>
                    </button>
                </div>
            </div>

            <!-- TAB: PEMBAYARAN -->
            <div x-show="activeTab === 'pembayaran'" class="space-y-4">
                <div x-data="{ open: false }" class="card bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border">
                    <button @click="open = !open" class="w-full text-left card-body p-5">
                        <div class="flex justify-between items-center gap-4">
                            <h3 class="font-bold text-text-primary dark:text-text-dark-primary text-sm">Metode pembayaran apa saja yang didukung oleh CoreSite?</h3>
                            <svg class="w-5 h-5 text-text-secondary transition-transform shrink-0" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                        <div x-show="open" x-collapse class="mt-4 text-xs text-text-secondary leading-relaxed border-t border-light-border dark:border-dark-border/40 pt-4">
                            CoreSite secara bawaan mendukung tiga metode pencatatan kasir utama: Tunai (Cash), Transfer Bank (Virtual Account), dan QRIS dinamis. Pencatatan ini memudahkan Anda melacak dan memisahkan aliran kas masuk sesuai jenis pembayaran.
                        </div>
                    </button>
                </div>

                <div x-data="{ open: false }" class="card bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border">
                    <button @click="open = !open" class="w-full text-left card-body p-5">
                        <div class="flex justify-between items-center gap-4">
                            <h3 class="font-bold text-text-primary dark:text-text-dark-primary text-sm">Apakah uang hasil penjualan dipotong oleh CoreSite?</h3>
                            <svg class="w-5 h-5 text-text-secondary transition-transform shrink-0" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                        <div x-show="open" x-collapse class="mt-4 text-xs text-text-secondary leading-relaxed border-t border-light-border dark:border-dark-border/40 pt-4">
                            Sama sekali tidak. CoreSite murni berperan sebagai platform pencatatan digital (SaaS). Semua uang hasil penjualan pelanggan langsung masuk ke rekening bank pribadi Anda atau dompet digital Anda tanpa potongan sepeser pun dari pihak kami.
                        </div>
                    </button>
                </div>
            </div>

            <!-- TAB: KEAMANAN DATA -->
            <div x-show="activeTab === 'keamanan'" class="space-y-4">
                <div x-data="{ open: false }" class="card bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border">
                    <button @click="open = !open" class="w-full text-left card-body p-5">
                        <div class="flex justify-between items-center gap-4">
                            <h3 class="font-bold text-text-primary dark:text-text-dark-primary text-sm">Seberapa aman data toko dan laporan keuangan saya?</h3>
                            <svg class="w-5 h-5 text-text-secondary transition-transform shrink-0" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                        <div x-show="open" x-collapse class="mt-4 text-xs text-text-secondary leading-relaxed border-t border-light-border dark:border-dark-border/40 pt-4">
                            Sangat aman. Seluruh data transaksi, data modal, dan laba rugi dilindungi dengan standar keamanan tinggi menggunakan SSL 256-bit. Server kami juga secara otomatis melakukan pencadangan data (backup) harian secara terenkripsi untuk mencegah risiko kehilangan akibat kerusakan fisik.
                        </div>
                    </button>
                </div>

                <div x-data="{ open: false }" class="card bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border">
                    <button @click="open = !open" class="w-full text-left card-body p-5">
                        <div class="flex justify-between items-center gap-4">
                            <h3 class="font-bold text-text-primary dark:text-text-dark-primary text-sm">Apakah staf kasir saya bisa melihat laporan untung rugi?</h3>
                            <svg class="w-5 h-5 text-text-secondary transition-transform shrink-0" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                        <div x-show="open" x-collapse class="mt-4 text-xs text-text-secondary leading-relaxed border-t border-light-border dark:border-dark-border/40 pt-4">
                            Tidak bisa, kecuali Anda mengizinkannya. Melalui menu manajemen role dan akses di CoreSite, Anda memiliki hak penuh untuk membatasi staf kasir agar hanya dapat mengakses form penginputan transaksi kasir, tanpa bisa melihat atau mengakses laporan laba rugi dan keuangan toko utama Anda.
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <!-- WhatsApp Support Widget / Hubungi Kami -->
        <div class="mt-16 p-8 bg-accent/5 border border-accent/20 rounded-2xl text-center max-w-2xl mx-auto space-y-4 hover:shadow-md transition">
            <div class="w-12 h-12 bg-emerald-500/10 text-emerald-500 rounded-full flex items-center justify-center mx-auto shadow-sm">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12.012 2c-5.506 0-9.988 4.471-9.988 9.967 0 2.157.674 4.154 1.819 5.807L2.125 22l4.385-1.674c1.611.977 3.491 1.545 5.502 1.545 5.506 0 10.012-4.471 10.012-9.967S17.518 2 12.012 2zm5.72 13.916c-.237.665-1.185 1.222-1.854 1.3-1.636.19-3.714-.526-5.836-2.585-2.122-2.059-3.153-4.225-3.344-5.864-.092-.669.349-1.674 1.014-1.911.233-.083.473-.131.706-.131.171 0 .324.036.425.048.243.012.392.06.564.44.209.476.719 1.751.779 1.87.06.12.1.25.02.41-.08.16-.18.31-.32.48-.14.17-.3.35-.43.47-.15.13-.3.27-.13.52.17.25.75 1.23 1.62 1.99.78.68 1.44.89 1.76.99.16.05.32.06.45-.1.17-.2.72-.83.91-1.12.15-.24.35-.2.58-.11.23.09 1.47.69 1.73.81.25.13.43.19.49.25.07.05.07.35-.16 1.01z"/>
                </svg>
            </div>
            <h3 class="font-bold text-text-primary dark:text-text-dark-primary text-base">Masih Punya Pertanyaan Lain?</h3>
            <p class="text-xs text-text-secondary max-w-md mx-auto leading-relaxed">
                Tim support dan pendamping UMKM CoreSite siap melayani dan mendampingi proses setup toko Anda kapan saja via WhatsApp.
            </p>
            <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-xs rounded-xl shadow-lg shadow-emerald-500/20 hover:scale-[1.02] transition-transform">
                Chat Support WhatsApp (24/7)
            </a>
        </div>
    </div>
</section>

<script>
function faqTabs() {
    return {
        activeTab: 'umum'
    }
}
</script>
@endsection