{{-- resources/views/landing/privacy.blade.php --}}
@extends('layouts.landing')

@section('title', 'Kebijakan Privasi - CoreSite')
@section('description', 'Kebijakan privasi CoreSite.')

@section('content')
<section class="py-16">
    <div class="container mx-auto px-4 max-w-4xl">
        <h1 class="text-4xl font-bold text-text-primary dark:text-text-dark-primary mb-4">
            Kebijakan <span class="text-accent">Privasi</span>
        </h1>
        <p class="text-text-secondary dark:text-text-dark-secondary mb-8">Terakhir diperbarui: 17 Juni 2026</p>

        <div class="prose prose-lg dark:prose-invert max-w-none">
            <h2>1. Informasi yang Kami Kumpulkan</h2>
            <p>Kami mengumpulkan informasi yang Anda berikan saat mendaftar, seperti nama, email, dan data toko. Kami juga mengumpulkan data penggunaan untuk meningkatkan layanan.</p>

            <h2>2. Penggunaan Informasi</h2>
            <p>Informasi Anda digunakan untuk:</p>
            <ul>
                <li>Menyediakan dan meningkatkan layanan</li>
                <li>Mengirim notifikasi dan pembaruan</li>
                <li>Menganalisis penggunaan platform</li>
                <li>Mendukung kebutuhan bisnis Anda</li>
            </ul>

            <h2>3. Perlindungan Data</h2>
            <p>Kami menggunakan enkripsi dan protokol keamanan untuk melindungi data Anda. Akses ke data Anda dibatasi hanya untuk tim yang berwenang.</p>

            <h2>4. Berbagi Data</h2>
            <p>Kami tidak menjual data Anda ke pihak ketiga. Data hanya dibagikan dengan mitra terpercaya untuk mendukung operasional layanan.</p>

            <h2>5. Cookie</h2>
            <p>Kami menggunakan cookie untuk meningkatkan pengalaman pengguna. Anda dapat mengatur browser untuk menolak cookie, tetapi ini mungkin mempengaruhi fungsionalitas.</p>

            <h2>6. Hak Anda</h2>
            <p>Anda memiliki hak untuk mengakses, memperbaiki, atau menghapus data Anda. Hubungi kami untuk permintaan terkait data.</p>

            <h2>7. Perubahan Kebijakan</h2>
            <p>Kebijakan privasi ini dapat diperbarui. Perubahan akan diinformasikan melalui email atau notifikasi.</p>

            <h2>8. Kontak</h2>
            <p>Untuk pertanyaan tentang privasi, hubungi <a href="mailto:privacy@coresite.com" class="text-accent hover:underline">privacy@coresite.com</a>.</p>
        </div>
    </div>
</section>
@endsection