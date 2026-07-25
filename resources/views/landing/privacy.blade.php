{{-- resources/views/landing/privacy.blade.php --}}
@extends('layouts.landing')

@section('title', 'Kebijakan Privasi - CoreSite')
@section('description', 'Kebijakan privasi platform toko online dan kasir otomatis CoreSite.')

@section('content')
<section class="py-16 bg-light-bg dark:bg-dark-bg text-text-primary dark:text-text-dark-primary">
    <div class="container mx-auto px-4 max-w-4xl">
        <h1 class="text-4xl font-bold text-text-primary dark:text-text-dark-primary mb-2">
            Kebijakan <span class="text-accent">Privasi</span>
        </h1>
        <p class="text-text-secondary dark:text-text-dark-secondary mb-8">Terakhir diperbarui: 25 Juli 2026</p>

        <div class="prose prose-lg dark:prose-invert max-w-none">
            <p>Selamat datang di CoreSite. Kami berkomitmen penuh untuk melindungi privasi Anda dan menjaga keamanan data operasional bisnis Anda. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, menyimpan, dan melindungi data Anda.</p>

            <h2>1. Data yang Kami Kumpulkan</h2>
            <p>Untuk menyediakan sistem e-catalog dan kasir POS otomatis, kami mengumpulkan jenis data berikut:</p>
            <ul>
                <li><strong>Data Pemilik & Staf:</strong> Informasi identitas dasar seperti nama lengkap, alamat email aktif, nomor WhatsApp/telepon, dan kata sandi yang terenkripsi untuk kebutuhan autentikasi dan komunikasi.</li>
                <li><strong>Data Katalog & Stok:</strong> Informasi produk mencakup nama produk, deskripsi, harga jual, harga modal, gambar produk, kategori, dan jumlah stok inventaris Anda.</li>
                <li><strong>Riwayat Transaksi & Laporan Keuangan:</strong> Semua log transaksi penjualan, detail item yang terjual, tanggal transaksi, nominal pembayaran, metode pembayaran (Tunai, QRIS, Transfer), serta akumulasi perhitungan pendapatan bisnis Anda.</li>
            </ul>

            <h2>2. Jaminan Keamanan Data</h2>
            <p>Kepercayaan Anda adalah prioritas utama kami. Kami menjamin bahwa:</p>
            <ul>
                <li><strong>100% Keamanan Data:</strong> Kami tidak akan pernah menjual, menyewakan, membagikan, atau menyebarluaskan data toko, katalog, maupun laporan keuangan Anda kepada pihak ketiga mana pun tanpa persetujuan eksplisit Anda.</li>
                <li><strong>Isolasi Multi-Store:</strong> Data toko Anda diisolasi secara ketat dan aman sehingga tidak dapat diakses atau diintip oleh toko lain yang terdaftar di platform kami.</li>
            </ul>

            <h2>3. Penggunaan Informasi</h2>
            <p>Kami menggunakan data yang dikumpulkan semata-mata untuk kebutuhan operasional:</p>
            <ul>
                <li>Menyediakan layanan dashboard kasir otomatis, manajemen produk, dan e-catalog publik toko Anda.</li>
                <li>Menyusun laporan analitik penjualan, laba rugi, dan statistik performa toko secara akurat untuk Anda.</li>
                <li>Mengirimkan notifikasi keamanan akun, pembaruan fitur, dan panduan edukasi UMKM.</li>
            </ul>

            <h2>4. Penyimpanan & Enkripsi Data</h2>
            <p>Semua data disimpan di server yang aman dengan standar industri tinggi, menggunakan protokol enkripsi SSL 256-bit untuk proses transfer data, serta backup data berkala setiap hari untuk mencegah kehilangan data akibat kendala teknis.</p>

            <h2>5. Kontak & Pengaduan</h2>
            <p>Jika Anda memiliki pertanyaan, kekhawatiran, atau permintaan penghapusan data, silakan hubungi tim perlindungan data kami secara langsung di:</p>
            <p>Email: <a href="mailto:privacy@coresite.com" class="text-accent hover:underline">privacy@coresite.com</a></p>
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