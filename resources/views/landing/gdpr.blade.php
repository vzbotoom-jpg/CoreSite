{{-- resources/views/landing/gdpr.blade.php --}}
@extends('layouts.guest')

@section('title', 'GDPR - CoreSite')
@section('description', 'Kepatuhan GDPR CoreSite.')

@section('content')
<section class="py-16">
    <div class="container mx-auto px-4 max-w-4xl">
        <h1 class="text-4xl font-bold text-text-primary dark:text-text-dark-primary mb-4">
            <span class="text-accent">GDPR</span> Compliance
        </h1>
        <p class="text-text-secondary dark:text-text-dark-secondary mb-8">Terakhir diperbarui: 17 Juni 2026</p>

        <div class="prose prose-lg dark:prose-invert max-w-none">
            <h2>Kepatuhan GDPR</h2>
            <p>CoreSite berkomitmen untuk melindungi data pribadi pengguna sesuai dengan regulasi GDPR (General Data Protection Regulation).</p>

            <h2>Hak Pengguna</h2>
            <ul>
                <li><strong>Hak Akses:</strong> Anda dapat meminta salinan data Anda</li>
                <li><strong>Hak Perbaikan:</strong> Anda dapat memperbaiki data yang tidak akurat</li>
                <li><strong>Hak Hapus:</strong> Anda dapat meminta penghapusan data</li>
                <li><strong>Hak Batasi:</strong> Anda dapat membatasi pemrosesan data</li>
                <li><strong>Hak Portabilitas:</strong> Anda dapat memindahkan data ke penyedia lain</li>
            </ul>

            <h2>Dasar Hukum Pemrosesan</h2>
            <p>Kami memproses data berdasarkan:</p>
            <ul>
                <li>Kinerja kontrak (layanan yang Anda gunakan)</li>
                <li>Kepatuhan hukum (kewajiban perpajakan)</li>
                <li>Kepentingan sah (peningkatan layanan)</li>
                <li>Persetujuan (marketing)</li>
            </ul>

            <h2>Data Protection Officer</h2>
            <p>Untuk pertanyaan GDPR, hubungi DPO kami di <a href="mailto:dpo@coresite.com" class="text-accent hover:underline">dpo@coresite.com</a>.</p>
        </div>
    </div>
</section>
@endsection