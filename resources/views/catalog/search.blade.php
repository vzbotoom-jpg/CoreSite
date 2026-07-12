{{-- resources/views/catalog/search.blade.php --}}
@extends('layouts.catalog')

@section('title', 'Hasil Pencarian: ' . ($query ?? ''))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Search Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold mb-2">Hasil Pencarian</h1>
        <p class="text-text-secondary">
            Menampilkan hasil untuk: <span class="font-medium">"{{ $query ?? '' }}"</span>
        </p>
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
                        <svg class="w-24 h-24 mx-auto text-text-secondary/50 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <h3 class="text-lg font-semibold mb-2">Produk tidak ditemukan</h3>
                        <p class="text-text-secondary mb-6">
                            Tidak ada produk yang sesuai dengan kata kunci "{{ $query }}"
                        </p>
                        <a href="{{ route('catalog.index') }}" class="btn btn-primary">
                            Lihat Semua Produk
                        </a>
                    </div>
                @endforelse
            </div>
            
            <div class="mt-8">
                {{ $products->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Apply filters from URL parameters
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    
    // Set search input value
    const searchInput = document.getElementById('searchInput');
    if (searchInput && urlParams.get('q')) {
        searchInput.value = urlParams.get('q');
    }
    
    // Set category filter
    const categoryFilter = document.querySelector('input[name="category"][value="' + urlParams.get('category') + '"]');
    if (categoryFilter) {
        categoryFilter.checked = true;
    }
    
    // Set price filters
    const minPrice = document.getElementById('minPrice');
    const maxPrice = document.getElementById('maxPrice');
    if (minPrice && urlParams.get('min_price')) {
        minPrice.value = urlParams.get('min_price');
    }
    if (maxPrice && urlParams.get('max_price')) {
        maxPrice.value = urlParams.get('max_price');
    }
});
</script>
@endpush
@endsection