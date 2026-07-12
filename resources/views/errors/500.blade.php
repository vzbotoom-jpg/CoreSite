{{-- resources/views/errors/500.blade.php --}}
@extends('errors.layout.error-layout')

@section('title', 'Server Error')

@section('illustration')
<svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="100" cy="100" r="80" fill="#DC3545" opacity="0.1"/>
    <path d="M100 60C79 60 62 77 62 98V112C62 133 79 150 100 150C121 150 138 133 138 112V98C138 77 121 60 100 60Z" fill="#DC3545"/>
    <rect x="88" y="88" width="24" height="24" rx="4" fill="white"/>
    <rect x="88" y="116" width="24" height="8" rx="4" fill="white"/>
</svg>
@endsection

@section('code', '500')
@section('message', 'Internal Server Error')
@section('description', 'Maaf, terjadi kesalahan pada server kami. Tim teknis sedang bekerja untuk memperbaikinya.')

@section('actions')
<button onclick="window.location.reload()" class="btn btn-primary">Coba Lagi</button>
<a href="{{ route('landing') }}" class="btn btn-secondary">Kembali ke Beranda</a>
@endsection