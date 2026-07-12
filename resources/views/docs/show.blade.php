{{-- resources/views/docs/show.blade.php --}}
@extends('layouts.docs')

@section('title', $title ?? 'Documentation')
@section('description', $description ?? '')

@section('content')
    <div class="prose dark:prose-invert max-w-none">
        @yield('doc-content')
    </div>
@endsection