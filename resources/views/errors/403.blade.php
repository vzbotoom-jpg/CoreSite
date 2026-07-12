{{-- resources/views/errors/403.blade.php --}}
@extends('errors.layout.error-layout')

@section('title', 'Forbidden')

@section('illustration')
<svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="100" cy="100" r="80" fill="#DC3545" opacity="0.1"/>
    <path d="M100 60C93.4 60 88 65.4 88 72V96C88 102.6 93.4 108 100 108C106.6 108 112 102.6 112 96V72C112 65.4 106.6 60 100 60Z" fill="#DC3545"/>
    <path d="M88 124H112V148H88V124Z" fill="#DC3545"/>
    <rect x="88" y="124" width="24" height="24" rx="4" fill="#DC3545"/>
    <circle cx="100" cy="136" r="6" fill="white"/>
</svg>
@endsection

@section('code', '403')
@section('message', 'Forbidden')
@section('description', 'Maaf, Anda tidak memiliki akses ke halaman ini. Hubungi administrator jika Anda memerlukan akses.')

@section('actions')
@auth
    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Kembali ke Dashboard</a>
    <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali ke Halaman Sebelumnya</a>
@else
    <a href="{{ route('login') }}" class="btn btn-primary">Login ke Akun</a>
    <a href="{{ route('landing') }}" class="btn btn-secondary">Kembali ke Beranda</a>
@endauth
@endsection