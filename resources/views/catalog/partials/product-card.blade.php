{{-- resources/views/catalog/partials/product-card.blade.php --}}
@props(['product'])

<div class="card hover:shadow-lg transition-all duration-300 group">
    <a href="{{ route('catalog.product', ['slug' => $product->store->slug ?? request()->segment(1), 'productSlug' => $product->slug]) }}" 
       class="block">
        <div class="aspect-square bg-light-surface dark:bg-dark-surface rounded-t-xl flex items-center justify-center p-4 group-hover:scale-105 transition-transform">
            @if($product->image)
                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain">
            @else
                <svg class="w-16 h-16 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            @endif
        </div>
        <div class="p-4">
            @if($product->category)
                <p class="text-xs text-text-secondary mb-1">{{ $product->category->name }}</p>
            @endif
            <h3 class="font-semibold mb-1 line-clamp-2">{{ $product->name }}</h3>
            <div class="flex justify-between items-center mt-2">
                <span class="text-lg font-bold text-accent">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </span>
                @if($product->stock > 0)
                    <span class="text-xs text-success">Tersedia</span>
                @else
                    <span class="text-xs text-error">Habis</span>
                @endif
            </div>
        </div>
    </a>
</div>