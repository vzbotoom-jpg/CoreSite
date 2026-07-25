{{-- resources/views/landing/gdpr.blade.php --}}
@extends('layouts.landing')

@section('title', 'Kepatuhan GDPR - CoreSite')
@section('description', 'Kepatuhan GDPR (General Data Protection Regulation) platform CoreSite.')

@section('content')
<section class="py-16 bg-light-bg dark:bg-dark-bg text-text-primary dark:text-text-dark-primary">
    <div class="container mx-auto px-4 max-w-4xl">
        <h1 class="text-4xl font-bold text-text-primary dark:text-text-dark-primary mb-2">
            <span class="text-accent">GDPR</span> Compliance
        </h1>
        <p class="text-text-secondary dark:text-text-dark-secondary mb-8">Terakhir diperbarui: 25 Juli 2026</p>

        <div class="prose prose-lg dark:prose-invert max-w-none">
            <p>Meskipun CoreSite difokuskan untuk mendukung UMKM di Indonesia, kami berkomitmen penuh untuk menjunjung tinggi standar perlindungan data global tertinggi, termasuk kepatuhan terhadap regulasi <strong>GDPR (General Data Protection Regulation)</strong> untuk seluruh pengguna kami.</p>

            <h2>1. Hak Perlindungan Data Anda</h2>
            <p>Di bawah regulasi GDPR, Anda memiliki hak-hak privasi komprehensif berikut:</p>
            <ul>
                <li><strong>Hak Akses (Right of Access):</strong> Anda berhak meminta konfirmasi apakah data pribadi Anda sedang diproses, serta meminta salinan lengkap dari seluruh data pribadi Anda yang kami simpan.</li>
                <li><strong>Hak Perbaikan (Right to Rectification):</strong> Anda memiliki hak penuh untuk merevisi, memperbarui, atau memperbaiki data profil, data toko, maupun katalog produk yang tidak akurat atau tidak lengkap secara langsung melalui dashboard admin Anda.</li>
                <li><strong>Hak Penghapusan (Right to Erasure / Right to be Forgotten):</strong> Anda berhak meminta agar kami menghapus seluruh data pribadi, riwayat login, serta data operasional toko Anda secara permanen dari server kami apabila akun Anda dinonaktifkan.</li>
                <li><strong>Hak Batasi Pemrosesan (Right to Restriction of Processing):</strong> Anda berhak membatasi pemrosesan data tertentu jika Anda merasa data Anda tidak akurat atau diproses secara tidak sah.</li>
                <li><strong>Hak Portabilitas Data (Right to Data Portability):</strong> Anda berhak meminta kami mengirimkan log transaksi keuangan, laporan penjualan, serta katalog produk Anda dalam format data yang terstruktur, umum digunakan, dan dapat dibaca oleh mesin (seperti file Excel / CSV).</li>
            </ul>

            <h2>2. Cara Mengajukan Hak GDPR & Ekspor Data</h2>
            <p>Kami telah menyediakan fitur bawaan di dashboard admin Anda untuk memudahkan pemenuhan hak-hak data Anda:</p>
            <ul>
                <li><strong>Ekspor Laporan & Katalog:</strong> Anda dapat mengunduh log transaksi penjualan, laporan laba rugi, serta katalog produk Anda kapan saja dalam bentuk dokumen resmi melalui menu <em>Laporan Penjualan</em> dan <em>Manajemen Produk</em>.</li>
                <li><strong>Pengajuan Hak Penghapusan Permanen:</strong> Jika Anda ingin menghapus seluruh akun dan data toko Anda secara permanen dari database produksi dan backup CoreSite, silakan ajukan permohonan tertulis resmi ke tim DPO (*Data Protection Officer*) kami.</li>
            </ul>

            <h2>3. Hubungi Data Protection Officer (DPO)</h2>
            <p>Seluruh permohonan hak GDPR dan klarifikasi perlindungan privasi data ditangani secara serius oleh Data Protection Officer kami melalui:</p>
            <p>Email: <a href="mailto:dpo@coresite.com" class="text-accent hover:underline">dpo@coresite.com</a></p>
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