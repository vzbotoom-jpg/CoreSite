{{-- resources/views/catalog/product.blade.php --}}
@extends('layouts.catalog')

@section('title', $product->name . ' - ' . $store->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumb -->
    @include('catalog.partials.breadcrumb', [
        'items' => [
            ['name' => $store->name, 'url' => route('catalog.store', $store->slug)],
            ['name' => $product->name, 'url' => null]
        ]
    ])
    
    <div class="grid md:grid-cols-2 gap-12">
        <!-- Product Image -->
        <div class="bg-light-surface dark:bg-dark-surface rounded-2xl p-8 flex items-center justify-center">
            @if($product->image)
                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full max-w-md object-contain">
            @else
                <svg class="w-64 h-64 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            @endif
        </div>
        
        <!-- Product Info -->
        <div>
            @if($product->category)
                <span class="badge badge-primary mb-4">{{ $product->category->name }}</span>
            @endif
            <h1 class="text-3xl font-bold mb-4">{{ $product->name }}</h1>
            <div class="text-3xl font-bold text-accent mb-4">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </div>
            <div class="flex items-center gap-4 mb-6">
                <div class="flex items-center gap-1">
                    <svg class="w-5 h-5 text-warning" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <span class="text-sm">4.9 (120 rating)</span>
                </div>
                <div class="text-sm text-text-secondary">
                    Stok: {{ $product->stock > 0 ? $product->stock . ' tersedia' : 'Habis' }}
                </div>
            </div>
            
            <div class="prose dark:prose-invert mb-6">
                <h3 class="font-semibold mb-2">Deskripsi Produk</h3>
                <p class="text-text-secondary">{{ $product->description ?? 'Tidak ada deskripsi untuk produk ini.' }}</p>
            </div>
            
            <div class="flex gap-4">
                <a href="https://wa.me/{{ $store->phone ?? '' }}?text=Halo%2C%20saya%20tertarik%20dengan%20produk%20{{ urlencode($product->name) }}" 
                   target="_blank" class="btn btn-primary flex-1">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    Pesan via WhatsApp
                </a>
                <button onclick="copyLink()" class="btn btn-outline">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Related Products -->
    @if(isset($relatedProducts) && count($relatedProducts) > 0)
    <div class="mt-16">
        <h2 class="text-2xl font-bold mb-6">Produk Terkait</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($relatedProducts as $relatedProduct)
                @include('catalog.partials.product-card', ['product' => $relatedProduct])
            @endforeach
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
function copyLink() {
    navigator.clipboard.writeText(window.location.href);
    alert('Link produk telah disalin!');
}
</script>
@endpush
@endsection