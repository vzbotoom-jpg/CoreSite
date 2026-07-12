@extends('layouts.docs')

@section('title', 'Pengaturan Akun')

@section('content')
<div class="prose prose-slate dark:prose-invert max-w-none">
    <p class="text-lg text-text-secondary dark:text-text-dark-secondary leading-relaxed">
        Kelola profil, keamanan, dan preferensi akun CoreSite Anda.
    </p>

    <h2>Profil</h2>
    <p>
        Update informasi profil Anda:
    </p>
    <ul>
        <li>Foto profil</li>
        <li>Nama lengkap</li>
        <li>Nomor telepon</li>
        <li>Alamat</li>
    </ul>

    <h2>Keamanan</h2>
    <p>
        Jaga keamanan akun dengan:
    </p>
    <ul>
        <li>Mengganti kata sandi secara berkala</li>
        <li>Mengaktifkan autentikasi dua faktor (2FA)</li>
        <li>Memeriksa riwayat login</li>
    </ul>

    <div class="bg-yellow-50 dark:bg-yellow-950/30 border-l-4 border-yellow-500 rounded-r-lg p-6 my-8">
        <div class="flex items-start gap-4">
            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div>
                <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Gunakan Kata Sandi yang Kuat</h4>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">
                    Gunakan kombinasi huruf besar, huruf kecil, angka, dan simbol untuk kata sandi yang aman.
                </p>
            </div>
        </div>
    </div>

    <h2>Preferensi</h2>
    <ul>
        <li><strong>Bahasa</strong> - Pilih bahasa yang Anda inginkan (Indonesia/English)</li>
        <li><strong>Notifikasi</strong> - Atur notifikasi email dan di aplikasi</li>
        <li><strong>Tampilan</strong> - Pilih mode terang/gelap sesuai preferensi</li>
    </ul>

    <h2>Manajemen Tim</h2>
    <p>
        Untuk pengguna Business dan Enterprise:
    </p>
    <ul>
        <li>Kelola anggota tim</li>
        <li>Atur hak akses per pengguna</li>
        <li>Pantau aktivitas tim</li>
    </ul>
</div>
@endsection