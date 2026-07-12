{{-- resources/views/landing/terms.blade.php --}}
@extends('layouts.landing')

@section('title', 'Syarat & Ketentuan - CoreSite')
@section('description', 'Syarat dan ketentuan penggunaan CoreSite.')

@section('content')
<section class="py-16">
    <div class="container mx-auto px-4 max-w-4xl">
        <h1 class="text-4xl font-bold text-text-primary dark:text-text-dark-primary mb-4">
            Syarat & <span class="text-accent">Ketentuan</span>
        </h1>
        <p class="text-text-secondary dark:text-text-dark-secondary mb-8">Terakhir diperbarui: 17 Juni 2026</p>

        <div class="prose prose-lg dark:prose-invert max-w-none">
            <h2>1. Penerimaan Syarat</h2>
            <p>Dengan menggunakan layanan CoreSite, Anda menyetujui untuk terikat dengan syarat dan ketentuan ini. Jika Anda tidak setuju, jangan gunakan layanan kami.</p>

            <h2>2. Deskripsi Layanan</h2>
            <p>CoreSite menyediakan platform toko online dan sistem kasir otomatis untuk UMKM. Layanan ini mencakup:</p>
            <ul>
                <li>Website toko online profesional</li>
                <li>Sistem kasir terintegrasi</li>
                <li>Manajemen produk dan stok</li>
                <li>Laporan penjualan dan keuangan</li>
                <li>Multi-user dan multi-store management</li>
            </ul>

            <h2>3. Akun Pengguna</h2>
            <p>Anda bertanggung jawab penuh atas keamanan akun dan password Anda. Beritahu kami segera jika terjadi akses tidak sah.</p>

            <h2>4. Hak Kekayaan Intelektual</h2>
            <p>Semua konten, desain, dan kode di CoreSite adalah hak milik CoreSite dan dilindungi oleh hukum hak cipta.</p>

            <h2>5. Pembayaran dan Pengembalian Dana</h2>
            <p>Biaya langganan dibayarkan di muka. Pengembalian dana dapat diproses sesuai dengan kebijakan pengembalian kami.</p>

            <h2>6. Batasan Tanggung Jawab</h2>
            <p>CoreSite tidak bertanggung jawab atas kerugian tidak langsung yang timbul dari penggunaan layanan kami.</p>

            <h2>7. Perubahan Syarat</h2>
            <p>Kami dapat mengubah syarat dan ketentuan ini sewaktu-waktu. Perubahan akan diumumkan melalui email atau notifikasi di dashboard.</p>

            <h2>8. Kontak</h2>
            <p>Jika Anda memiliki pertanyaan tentang syarat dan ketentuan ini, silakan hubungi kami di <a href="mailto:support@coresite.com" class="text-accent hover:underline">support@coresite.com</a>.</p>
        </div>
    </div>
</section>
@endsection