{{-- resources/views/landing/index.blade.php --}}
@extends('layouts.guest')

@section('title', 'CoreSite')

@section('content')
    <!-- Hero Section -->
    @include('landing.partials.hero')
    
    <!-- Features Section -->
    @include('landing.partials.features')
    
    <!-- Stats Section -->
    @include('landing.partials.stats')
    
    <!-- Pricing Section -->
    @include('landing.partials.pricing')
    
    <!-- Testimonials Section -->
    @include('landing.partials.testimonials')
    
    <!-- CTA Section -->
    @include('landing.partials.cta')
@endsection