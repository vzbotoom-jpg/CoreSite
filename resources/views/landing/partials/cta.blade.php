{{-- resources/views/landing/partials/cta.blade.php --}}
<section class="py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="card bg-accent/5 border-accent/20">
            <div class="card-body py-12">
                <h2 class="text-heading-2 mb-4">Siap Mengembangkan Bisnis Anda?</h2>
                <p class="text-body-lg text-text-secondary mb-8 max-w-2xl mx-auto">
                    Bergabunglah dengan ribuan UMKM yang telah menggunakan CoreSite 
                    untuk mengelola toko online mereka.
                </p>
                <div class="flex flex-wrap gap-4 justify-center">
                    <a href="{{ route('register') }}" class="btn btn-primary">
                        Daftar Sekarang Gratis
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-secondary">
                        Konsultasi Gratis
                    </a>
                </div>
                <p class="text-caption text-text-secondary mt-6">
                    *Tidak memerlukan kartu kredit. Batal kapan saja.
                </p>
            </div>
        </div>
    </div>
</section>