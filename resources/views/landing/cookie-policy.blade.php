{{-- resources/views/landing/cookie-policy.blade.php --}}
@extends('layouts.guest')

@section('title', 'Cookie Policy - CoreSite')
@section('description', 'Kebijakan cookie CoreSite.')

@section('content')
<section class="py-16">
    <div class="container mx-auto px-4 max-w-4xl">
        <h1 class="text-4xl font-bold text-text-primary dark:text-text-dark-primary mb-4">
            Cookie <span class="text-accent">Policy</span>
        </h1>
        <p class="text-text-secondary dark:text-text-dark-secondary mb-8">Terakhir diperbarui: 17 Juni 2026</p>

        <div class="prose prose-lg dark:prose-invert max-w-none">
            <h2>Apa itu Cookie?</h2>
            <p>Cookie adalah file kecil yang disimpan di perangkat Anda saat mengunjungi website. Cookie membantu kami mengenali Anda dan meningkatkan pengalaman penggunaan.</p>

            <h2>Cookie yang Kami Gunakan</h2>
            <h3>1. Cookie Esensial</h3>
            <p>Diperlukan untuk fungsi dasar website seperti login dan keamanan.</p>

            <h3>2. Cookie Preferensi</h3>
            <p>Menyimpan preferensi Anda seperti bahasa dan tema.</p>

            <h3>3. Cookie Analitik</h3>
            <p>Membantu kami memahami bagaimana pengguna berinteraksi dengan website.</p>

            <h2>Mengelola Cookie</h2>
            <p>Anda dapat mengelola cookie melalui pengaturan browser Anda. Namun, menonaktifkan cookie dapat mempengaruhi fungsionalitas website.</p>

            <h2>Kontak</h2>
            <p>Untuk pertanyaan tentang cookie policy, hubungi <a href="mailto:privacy@coresite.com" class="text-accent hover:underline">privacy@coresite.com</a>.</p>
        </div>
    </div>
</section>
@endsection