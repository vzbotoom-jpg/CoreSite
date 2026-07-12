{{-- resources/views/errors/429.blade.php --}}
@extends('errors.layout.error-layout')

@section('title', 'Too Many Requests')

@section('illustration')
<svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="100" cy="100" r="80" fill="#FFC107" opacity="0.1"/>
    <path d="M100 70C80.9 70 65.6 85.3 65.6 104.4V117.8C65.6 136.9 80.9 152.2 100 152.2C119.1 152.2 134.4 136.9 134.4 117.8V104.4C134.4 85.3 119.1 70 100 70Z" fill="#FFC107"/>
    <path d="M100 85V105M100 125V127" stroke="white" stroke-width="4" stroke-linecap="round"/>
</svg>
@endsection

@section('code', '429')
@section('message', 'Too Many Requests')
@section('description', 'Maaf, Anda telah terlalu banyak melakukan permintaan. Silakan tunggu beberapa saat sebelum mencoba lagi.')

@section('actions')
<button onclick="setTimeout(() => window.location.reload(), 30000)" class="btn btn-primary">Coba Lagi (30 detik)</button>
<a href="{{ route('landing') }}" class="btn btn-secondary">Kembali ke Beranda</a>
@endsection