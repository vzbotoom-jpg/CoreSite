{{-- resources/views/landing/partials/hero.blade.php --}}
<section class="relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="animate-slide-up">
                <h1 class="text-heading-1 font-bold mb-6">
                    Kelola Toko & Kasir 
                    <span class="text-accent">Otomatis</span> 
                    Dalam Satu Platform
                </h1>
                <p class="text-body-lg text-text-secondary mb-8">
                    Platform web toko dan kasir otomatis untuk UMKM. Dapatkan dashboard admin 
                    dan halaman e-catalog profesional dalam hitungan menit. Gratis selamanya!
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('register') }}" class="btn btn-primary">
                        Mulai Gratis
                    </a>
                    <a href="#features" class="btn btn-secondary">
                        Lihat Fitur
                    </a>
                </div>
                <div class="mt-8 flex flex-wrap items-center gap-6 text-caption text-text-secondary">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Tanpa kartu kredit
                    </span>
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Batal kapan saja
                    </span>
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Support 24/7
                    </span>
                    {{-- Trust marker keamanan data — penting untuk SaaS yang menyimpan
                         data transaksi & keuangan bisnis orang lain, sebelumnya sama
                         sekali tidak disinggung di halaman manapun --}}
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Data terenkripsi & di-backup otomatis
                    </span>
                </div>
            </div>
            
            <div class="relative">
                <div class="card p-0 overflow-hidden shadow-2xl">
                    <div class="bg-light-surface dark:bg-dark-surface border-b px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-error"></div>
                            <div class="w-3 h-3 rounded-full bg-warning"></div>
                            <div class="w-3 h-3 rounded-full bg-success"></div>
                            <div class="ml-4 text-sm text-text-secondary">Dashboard Admin</div>
                        </div>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="border rounded-lg p-4">
                                <div class="text-sm text-text-secondary">Total Pendapatan</div>
                                <div class="text-2xl font-bold mt-1">Rp 12.5 Jt</div>
                                <div class="text-xs text-success mt-1">↑ 12.5%</div>
                            </div>
                            <div class="border rounded-lg p-4">
                                <div class="text-sm text-text-secondary">Produk Terjual</div>
                                <div class="text-2xl font-bold mt-1">234</div>
                                <div class="text-xs text-text-secondary mt-1">Bulan ini</div>
                            </div>
                        </div>
                        <div class="border rounded-lg p-4">
                            <div class="text-sm text-text-secondary mb-3">Stok Terbaru</div>
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span>Kopi Arabika</span>
                                    <span class="text-success">Stok: 45</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span>Teh Tarik</span>
                                    <span class="text-warning">Stok: 8</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span>Gula Aren</span>
                                    <span class="text-error">Stok: 2</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="absolute -z-10 -top-10 -right-10 w-72 h-72 bg-accent/5 rounded-full blur-3xl"></div>
                <div class="absolute -z-10 -bottom-10 -left-10 w-72 h-72 bg-accent/5 rounded-full blur-3xl"></div>
            </div>
        </div>
    </div>
</section>