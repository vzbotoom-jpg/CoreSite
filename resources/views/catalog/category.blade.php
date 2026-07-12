{{-- resources/views/catalog/category.blade.php --}}
@extends('layouts.catalog')

@section('title', $category->name . ' - ' . $store->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Category Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-2">{{ $category->name }}</h1>
        @if($category->description)
            <p class="text-text-secondary">{{ $category->description }}</p>
        @endif
    </div>
    
    <div class="grid lg:grid-cols-4 gap-8">
        <!-- Filters Sidebar -->
        <div class="lg:col-span-1">
            @include('catalog.partials.filter-sidebar', ['categories' => $categories ?? []])
        </div>
        
        <!-- Products Grid -->
        <div class="lg:col-span-3">
            <div class="flex justify-between items-center mb-6">
                <p class="text-sm text-text-secondary">
                    Menampilkan {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} 
                    dari {{ $products->total() }} produk
                </p>
                <div class="flex gap-2">
                    <select id="sortBy" class="input w-48" onchange="window.location.href=this.value">
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'name']) }}">Nama A-Z</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => '-name']) }}">Nama Z-A</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'price']) }}">Harga Terendah</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => '-price']) }}">Harga Tertinggi</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => '-created_at']) }}">Terbaru</option>
                    </select>
                </div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($products as $product)
                    @include('catalog.partials.product-card', ['product' => $product])
                @empty
                    <div class="col-span-full text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-text-secondary/50 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <p class="text-text-secondary">Tidak ada produk dalam kategori ini</p>
                    </div>
                @endforelse
            </div>
            
            <div class="mt-8">
                {{ $products->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection