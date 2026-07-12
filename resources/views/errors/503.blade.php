{{-- resources/views/errors/503.blade.php --}}
@extends('errors.layout.error-layout')

@section('title', 'Maintenance')

@section('illustration')
<svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="100" cy="100" r="80" fill="#00D27A" opacity="0.1"/>
    <!-- Gear Icon -->
    <path d="M100 60C92.4 60 85.6 64.8 82.8 71.6L74.8 68.4C72.8 60.4 63.2 56 55.6 59.6L48.4 63.2C41.2 66.8 39.2 76.8 43.6 83.2L49.2 91.6C47.6 96 47.6 100.8 49.2 105.2L43.6 113.6C39.2 120 41.2 130 48.4 133.6L55.6 137.2C63.2 140.8 72.8 136.4 74.8 128.4L82.8 125.2C85.6 132 92.4 136.8 100 136.8C107.6 136.8 114.4 132 117.2 125.2L125.2 128.4C127.2 136.4 136.8 140.8 144.4 137.2L151.6 133.6C158.8 130 160.8 120 156.4 113.6L150.8 105.2C152.4 100.8 152.4 96 150.8 91.6L156.4 83.2C160.8 76.8 158.8 66.8 151.6 63.2L144.4 59.6C136.8 56 127.2 60.4 125.2 68.4L117.2 71.6C114.4 64.8 107.6 60 100 60Z" stroke="#00D27A" stroke-width="6"/>
    <circle cx="100" cy="98" r="12" fill="#00D27A"/>
</svg>
@endsection

@section('code', '503')
@section('message', 'Service Unavailable')
@section('description', 'Maaf, situs sedang dalam pemeliharaan. Kami akan segera kembali.')

@section('actions')
<button onclick="setTimeout(() => window.location.reload(), 60000)" class="btn btn-primary">Cek Status (1 menit)</button>
<a href="mailto:support@coresite.com" class="btn btn-secondary">Hubungi Support</a>
@endsection