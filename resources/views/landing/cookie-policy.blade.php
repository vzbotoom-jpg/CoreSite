{{-- resources/views/landing/cookie-policy.blade.php --}}
@extends('layouts.landing')

@section('title', 'Kebijakan Cookie - CoreSite')
@section('description', 'Kebijakan penggunaan cookie pada platform CoreSite.')

@section('content')
<section class="py-16 bg-light-bg dark:bg-dark-bg text-text-primary dark:text-text-dark-primary">
    <div class="container mx-auto px-4 max-w-4xl">
        <h1 class="text-4xl font-bold text-text-primary dark:text-text-dark-primary mb-2">
            Kebijakan <span class="text-accent">Cookie</span>
        </h1>
        <p class="text-text-secondary dark:text-text-dark-secondary mb-8">Terakhir diperbarui: 25 Juli 2026</p>

        <div class="prose prose-lg dark:prose-invert max-w-none">
            <p>Platform CoreSite menggunakan cookie untuk memastikan seluruh fitur aplikasi berjalan secara lancar, responsif, dan aman. Halaman ini menjelaskan bagaimana kami memanfaatkan teknologi cookie ini untuk mengoptimalkan operasional bisnis kasir (POS) Anda.</p>

            <h2>1. Apa itu Cookie?</h2>
            <p>Cookie adalah file teks kecil berisi informasi yang diunduh dan disimpan di dalam penyimpanan browser perangkat Anda saat Anda mengunjungi situs atau aplikasi kami. Cookie memungkinkan kami mengingat pilihan dan aktivitas Anda selama jangka waktu tertentu.</p>

            <h2>2. Cookie yang Kami Gunakan</h2>
            <ul>
                <li><strong>Cookie Sesi & Autentikasi (Sangat Esensial):</strong>
                    Cookie ini mutlak diperlukan untuk menjaga agar status login Anda tetap aktif di dashboard CoreSite, mengamankan transaksi CSRF, serta memastikan bahwa data keranjang transaksi kasir (POS) Anda tersinkronisasi dengan aman tanpa terputus di tengah jalan.
                </li>
                <li><strong>Cookie Preferensi (Fungsionalitas):</strong>
                    Cookie ini digunakan untuk menyimpan preferensi personalisasi Anda, seperti pilihan skema warna (tema Dark Mode vs Light Mode) agar tidak kembali ke pengaturan awal setiap kali Anda menyegarkan halaman atau membuka tab baru.
                </li>
                <li><strong>Cookie Analitik (Kinerja):</strong>
                    Kami menggunakan cookie analitik anonim untuk mengukur performa pemuatan halaman dan mengidentifikasi bagian platform mana yang membutuhkan optimasi kecepatan, demi kelancaran operasional POS Anda.
                </li>
            </ul>

            <h2>3. Panduan Menghapus Cookie Browser</h2>
            <p>Anda memegang kendali penuh atas penggunaan cookie pada perangkat Anda. Jika Anda ingin membersihkan atau menghapus cookie CoreSite, ikuti langkah singkat berikut:</p>
            <ul>
                <li><strong>Google Chrome:</strong> Buka <em>Setelan (Settings)</em> &gt; <em>Privasi dan Keamanan</em> &gt; <em>Hapus data penjelajahan</em> &gt; Centang <em>Cookie dan data situs lainnya</em> &gt; Klik <em>Hapus data</em>.</li>
                <li><strong>Mozilla Firefox:</strong> Buka <em>Pengaturan</em> &gt; <em>Privasi & Keamanan</em> &gt; Gulir ke <em>Cookie dan Data Situs</em> &gt; Klik <em>Hapus Data</em>.</li>
                <li><strong>Safari:</strong> Buka <em>Preferences</em> &gt; <em>Privacy</em> &gt; Klik <em>Manage Website Data</em> &gt; Cari "coresite" &gt; Klik <em>Remove All</em>.</li>
            </ul>
            <p class="text-xs text-text-secondary font-semibold italic">Catatan: Menghapus atau memblokir cookie esensial dapat menyebabkan Anda otomatis keluar dari dashboard dan mereset keranjang belanja POS kasir Anda.</p>

            <h2>4. Kontak Hubungi Kami</h2>
            <p>Jika Anda membutuhkan penjelasan lebih detail mengenai Kebijakan Cookie ini, hubungi kami:</p>
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