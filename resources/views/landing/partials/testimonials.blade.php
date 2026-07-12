{{-- resources/views/landing/partials/testimonials.blade.php --}}
<section class="py-20 bg-light-surface dark:bg-dark-surface">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-heading-2 mb-4">Apa Kata Mereka?</h2>
            <p class="text-body-lg text-text-secondary max-w-2xl mx-auto">
                Ribuan UMKM telah mempercayakan bisnisnya kepada CoreSite
            </p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <div class="card">
                <div class="card-body">
                    <div class="flex items-center gap-1 mb-4">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 text-warning" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                    <p class="text-text-secondary mb-4">
                        "Platform yang sangat membantu bisnis saya. Dashboardnya mudah digunakan, 
                        stok otomatis terupdate setiap ada penjualan. Rekomendasi banget!"
                    </p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-accent/10 rounded-full flex items-center justify-center">
                            <span class="text-accent font-semibold">BD</span>
                        </div>
                        <div>
                            <p class="font-semibold">Budi Santoso</p>
                            <p class="text-xs text-text-secondary">Pemilik Toko Kopi</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <div class="flex items-center gap-1 mb-4">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 text-warning" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                    <p class="text-text-secondary mb-4">
                        "Fitur laporan keuangannya sangat membantu saya memantau pendapatan 
                        bulanan. Sekarang bisnis saya lebih terorganisir."
                    </p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-accent/10 rounded-full flex items-center justify-center">
                            <span class="text-accent font-semibold">SW</span>
                        </div>
                        <div>
                            <p class="font-semibold">Siti Wardah</p>
                            <p class="text-xs text-text-secondary">Pemilik Butik Fashion</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <div class="flex items-center gap-1 mb-4">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 text-warning" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                    <p class="text-text-secondary mb-4">
                        "Dari offline ke online jadi mudah dengan CoreSite. Pelanggan sekarang 
                        bisa lihat produk kami online, pesan via WhatsApp."
                    </p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-accent/10 rounded-full flex items-center justify-center">
                            <span class="text-accent font-semibold">AR</span>
                        </div>
                        <div>
                            <p class="font-semibold">Ahmad Rizki</p>
                            <p class="text-xs text-text-secondary">Pemilik Toko Elektronik</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>