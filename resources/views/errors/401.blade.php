{{-- resources/views/errors/401.blade.php --}}
@extends('errors.layout.error-layout')

@section('title', 'Unauthorized Access')

@section('illustration')
<svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="100" cy="100" r="80" fill="#00D27A" opacity="0.1"/>
    <path d="M100 40C95.8 40 92.2 43.6 92.2 47.8V92.2C92.2 96.4 95.8 100 100 100C104.2 100 107.8 96.4 107.8 92.2V47.8C107.8 43.6 104.2 40 100 40Z" fill="#00D27A"/>
    <circle cx="100" cy="128" r="12" fill="#00D27A"/>
</svg>
@endsection

@section('code', '401')
@section('message', 'Unauthorized Access')
@section('description', 'Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.')

@section('actions')
@auth
    <a href="{{ url()->previous() ?? route('admin.dashboard') }}" class="btn btn-primary">Kembali ke Dashboard</a>
    <a href="{{ route('logout') }}" 
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
       class="btn btn-secondary">Logout</a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
@else
    <a href="{{ route('login') }}" class="btn btn-primary">Login ke Akun</a>
    <a href="{{ route('landing') }}" class="btn btn-secondary">Kembali ke Beranda</a>
@endauth
@endsection