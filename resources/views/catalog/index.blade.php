{{-- resources/views/catalog/index.blade.php --}}
@extends('layouts.catalog')

@section('title', 'Temukan Produk Terbaik')

@section('content')
<div class="bg-gradient-to-b from-accent/5 to-transparent">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                Temukan Produk <span class="text-accent">Terbaik</span>
            </h1>
            <p class="text-lg text-text-secondary max-w-2xl mx-auto mb-8">
                Jelajahi ribuan produk dari berbagai toko terpercaya di Indonesia
            </p>
            <div class="max-w-xl mx-auto">
                <div class="relative">
                    <input type="text" id="searchStores" placeholder="Cari toko atau produk..." 
                           class="input pl-12 py-3">
                    <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-text-secondary" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Featured Stores -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h2 class="text-2xl font-bold mb-6">Toko Populer</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
        @foreach($featuredStores ?? [] as $store)
            <a href="{{ route('catalog.store', $store->slug) }}" class="card hover:shadow-lg transition-all text-center">
                <div class="p-4">
                    <div class="w-16 h-16 mx-auto bg-accent/10 rounded-full flex items-center justify-center mb-3">
                        @if($store->logo)
                            <img src="{{ Storage::url($store->logo) }}" alt="{{ $store->name }}" class="w-12 h-12 rounded-full object-cover">
                        @else
                            <span class="text-2xl font-bold text-accent">{{ strtoupper(substr($store->name, 0, 2)) }}</span>
                        @endif
                    </div>
                    <h3 class="font-semibold text-sm truncate">{{ $store->name }}</h3>
                    <p class="text-xs text-text-secondary">{{ $store->products_count ?? 0 }} produk</p>
                </div>
            </a>
        @endforeach
    </div>
</div>

<!-- Categories -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h2 class="text-2xl font-bold mb-6">Kategori Populer</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($categories ?? [] as $category)
            <div class="card hover:shadow-lg transition-all cursor-pointer" 
                 onclick="window.location.href='{{ route('catalog.category', ['slug' => $category->store->slug ?? '#', 'categorySlug' => $category->slug]) }}'">
                <div class="p-4 flex items-center gap-3">
                    <div class="w-12 h-12 bg-accent/10 rounded-lg flex items-center justify-center">
                        @if($category->icon)
                            <img src="{{ Storage::url($category->icon) }}" alt="{{ $category->name }}" class="w-8 h-8">
                        @else
                            <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        @endif
                    </div>
                    <div>
                        <h3 class="font-semibold">{{ $category->name }}</h3>
                        <p class="text-xs text-text-secondary">{{ $category->products_count ?? 0 }} produk</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Featured Products -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h2 class="text-2xl font-bold mb-6">Produk Unggulan</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($featuredProducts ?? [] as $product)
            @include('catalog.partials.product-card', ['product' => $product])
        @endforeach
    </div>
</div>
@endsection