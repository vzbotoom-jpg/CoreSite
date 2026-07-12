@extends('layouts.docs')

@section('title', 'Penagihan & Invoice')

@section('content')
<div class="prose prose-slate dark:prose-invert max-w-none">
    <p class="text-lg text-text-secondary dark:text-text-dark-secondary leading-relaxed">
        Kelola tagihan, pembayaran, dan invoice akun CoreSite Anda.
    </p>

    <h2>Metode Pembayaran</h2>
    <p>
        Kami menerima berbagai metode pembayaran:
    </p>
    <ul>
        <li>Kartu Kredit (Visa, Mastercard, Amex)</li>
        <li>Transfer Bank (BCA, Mandiri, BNI)</li>
        <li>E-Wallet (OVO, GoPay, DANA)</li>
        <li>QRIS</li>
    </ul>

    <div class="bg-light-surface dark:bg-dark-surface/50 rounded-xl p-6 my-6">
        <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Invoice Bulanan</h4>
        <p class="text-sm text-text-secondary dark:text-text-dark-secondary">
            Invoice akan dikirimkan secara otomatis setiap awal bulan. 
            Anda dapat melihat dan mengunduh invoice dari dashboard.
        </p>
        <div class="mt-4 p-4 bg-light-bg dark:bg-dark-bg rounded-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-text-secondary/60">Invoice #INV-2026-001</p>
                    <p class="text-sm font-medium text-text-primary dark:text-text-dark-primary">Rp 149.000</p>
                </div>
                <span class="px-3 py-1 text-xs font-medium text-green-600 bg-green-100 dark:bg-green-900/30 rounded-full">
                    Lunas
                </span>
            </div>
        </div>
    </div>

    <h2>Mengelola Tagihan</h2>
    <ul>
        <li><strong>Lihat Riwayat</strong> - Cek semua transaksi dan invoice</li>
        <li><strong>Update Metode Pembayaran</strong> - Tambah atau ubah kartu kredit</li>
        <li><strong>Download Invoice</strong> - Unduh invoice dalam format PDF</li>
        <li><strong>Atur Auto-payment</strong> - Aktifkan pembayaran otomatis</li>
    </ul>

    <div class="bg-green-50 dark:bg-green-950/30 border border-green-200 dark:border-green-800/30 rounded-xl p-6 my-8">
        <div class="flex items-start gap-4">
            <svg class="w-6 h-6 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Diskon Annual</h4>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">
                    Berlangganan tahunan dan dapatkan diskon hingga 20%! 
                    <a href="{{ route('docs.show', 'subscription') }}" class="text-accent hover:underline">Lihat paket</a>
                </p>
            </div>
        </div>
    </div>

    <h2>Pertanyaan tentang Penagihan?</h2>
    <p>
        Tim dukungan kami siap membantu:
    </p>
    <ul>
        <li>Email: <a href="mailto:billing@coresite.com" class="text-accent">billing@coresite.com</a></li>
        <li>WhatsApp: <a href="https://wa.me/628123456789" class="text-accent">+62 812-3456-789</a></li>
    </ul>
</div>
@endsection