{{-- resources/views/errors/404.blade.php --}}
@extends('errors.layout.error-layout')

@section('title', 'Page Not Found')

@section('illustration')
<svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="100" cy="100" r="80" fill="#00D27A" opacity="0.1"/>
    <path d="M60 80L80 60M80 60L100 40M80 60L100 80M100 40L120 60M120 60L140 80M120 60L100 80M60 120L80 140M80 140L100 160M80 140L100 120M100 160L120 140M120 140L140 120M120 140L100 120" stroke="#00D27A" stroke-width="4" stroke-linecap="round"/>
    <circle cx="100" cy="100" r="20" fill="none" stroke="#00D27A" stroke-width="4"/>
</svg>
@endsection

@section('code', '404')
@section('message', 'Page Not Found')
@section('description', 'Maaf, halaman yang Anda cari tidak dapat ditemukan. Mungkin halaman telah dipindahkan atau dihapus.')

@section('actions')
<a href="{{ url()->previous() ?? route('landing') }}" class="btn btn-primary">Kembali ke Halaman Sebelumnya</a>
<a href="{{ route('landing') }}" class="btn btn-secondary">Kembali ke Beranda</a>
@endsection