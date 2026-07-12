{{-- resources/views/errors/419.blade.php --}}
@extends('errors.layout.error-layout')

@section('title', 'Session Expired')

@section('illustration')
<svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="100" cy="100" r="80" fill="#FFC107" opacity="0.1"/>
    <path d="M100 60C96 60 92.8 63.2 92.8 67.2V100C92.8 104 96 107.2 100 107.2C104 107.2 107.2 104 107.2 100V67.2C107.2 63.2 104 60 100 60Z" fill="#FFC107"/>
    <circle cx="100" cy="132" r="10" fill="#FFC107"/>
</svg>
@endsection

@section('code', '419')
@section('message', 'Session Expired')
@section('description', 'Maaf, sesi Anda telah berakhir. Silakan refresh halaman dan coba lagi.')

@section('actions')
<button onclick="window.location.reload()" class="btn btn-primary">Refresh Halaman</button>
<a href="{{ route('login') }}" class="btn btn-secondary">Login Ulang</a>
@endsection