{{-- resources/views/landing/terms.blade.php --}}
@extends('layouts.landing')

@section('title', 'Syarat & Ketentuan - CoreSite')
@section('description', 'Syarat dan ketentuan penggunaan platform CoreSite.')

@section('content')
<section class="py-16 bg-light-bg dark:bg-dark-bg text-text-primary dark:text-text-dark-primary">
    <div class="container mx-auto px-4 max-w-4xl">
        <h1 class="text-4xl font-bold text-text-primary dark:text-text-dark-primary mb-2">
            Syarat & <span class="text-accent">Ketentuan</span>
        </h1>
        <p class="text-text-secondary dark:text-text-dark-secondary mb-8">Terakhir diperbarui: 25 Juli 2026</p>

        <div class="prose prose-lg dark:prose-invert max-w-none">
            <p>Selamat datang di CoreSite. Sebelum menggunakan layanan kami, harap membaca Syarat & Ketentuan ini secara saksama. Dengan mengakses dan menggunakan platform CoreSite, Anda dianggap menyetujui semua klausul di bawah ini.</p>

            <h2>1. Penerimaan Syarat</h2>
            <p>Penggunaan platform CoreSite tunduk pada kepatuhan Anda terhadap semua ketentuan, kebijakan, dan prosedur yang diterbitkan di sini. Jika Anda tidak menyetujui bagian mana pun dari ketentuan ini, Anda tidak diperkenankan menggunakan layanan kami.</p>

            <h2>2. Pendaftaran Akun & Keamanan</h2>
            <p>Anda diwajibkan mendaftar dengan data yang valid dan benar untuk membuat akun toko di CoreSite. Anda bertanggung jawab penuh untuk menjaga kerahasiaan kata sandi akun Anda, serta semua aktivitas operasional kasir (POS) yang terjadi di bawah kredensial akun Anda.</p>

            <h2>3. Tanggung Jawab Konten Pengguna (Legalitas Produk)</h2>
            <ul>
                <li>Sebagai pemilik toko, Anda memiliki tanggung jawab penuh atas semua informasi, deskripsi, gambar produk, katalog, harga, serta legalitas produk yang Anda pajang di e-catalog publik CoreSite.</li>
                <li>Anda dilarang keras menjual, memajang, atau mengiklankan barang-barang ilegal, berbahaya, melanggar hak cipta kekayaan intelektual orang lain, atau melanggar peraturan perundang-undangan Republik Indonesia.</li>
                <li>CoreSite berhak menghapus konten produk atau menonaktifkan toko Anda secara sepihak jika ditemukan indikasi pelanggaran konten atau legalitas produk.</li>
            </ul>

            <h2>4. Ketentuan Masa Percobaan & Langganan (Subscription & Billing)</h2>
            <ul>
                <li><strong>Masa Percobaan Gratis (Free Trial):</strong> Pendaftaran awal mendapatkan akses uji coba gratis tanpa kewajiban memasukkan data kartu kredit atau info pembayaran.</li>
                <li><strong>Billing & Perpanjangan Langganan:</strong> Setelah masa uji coba selesai, Anda dapat memilih paket langganan berbayar (Bulanan atau Tahunan). Pembayaran dilakukan di awal periode billing dan tidak dapat dikembalikan (*Non-Refundable*), kecuali dinyatakan lain secara tertulis oleh CoreSite.</li>
                <li><strong>Keterlambatan Pembayaran:</strong> Kegagalan melakukan pembayaran perpanjangan langganan tepat waktu akan menyebabkan penangguhan sementara terhadap akses dashboard admin dan katalog publik toko Anda.</li>
            </ul>

            <h2>5. Batasan Tanggung Jawab</h2>
            <p>Layanan kami disediakan secara "apa adanya" (as-is). CoreSite tidak bertanggung jawab atas kerugian operasional bisnis, kehilangan data transaksi, atau kegagalan teknis di luar kendali infrastruktur utama kami.</p>

            <h2>6. Kontak Kontak Legal</h2>
            <p>Untuk pertanyaan hukum atau informasi lisensi legal, silakan hubungi tim legalitas kami:</p>
            <p>Email: <a href="mailto:legal@coresite.com" class="text-accent hover:underline">legal@coresite.com</a></p>
        </div>

        <!-- Quick Navigation -->
        <div class="mt-12 pt-6 border-t border-light-border dark:border-dark-border flex flex-wrap gap-4 justify-between items-center text-sm font-semibold">
            <span class="text-text-secondary dark:text-text-dark-secondary">Navigasi Legal:</span>
            <div class="flex flex-wrap gap-x-4 gap-y-2">
                <a href="{{ route('privacy') }}" class="text-accent hover:underline">Kebijakan Privasi</a>
                <a href="{{ route('terms') }}" class="text-accent hover:underline">Syarat & Ketentuan</a>
                <a href="{{ route('cookie-policy') }}" class="text-accent hover:underline">Kebijakan Cookie</a>
                <a href="{{ route('gdpr') }}" class="text-accent hover:underline">Kepatuhan GDPR</a>
            </div>
        </div>
    </div>
</section>
@endsection