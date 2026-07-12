{{-- resources/views/admin/products/partials/stock-alert.blade.php --}}
@props(['lowStockProducts' => [], 'outOfStockProducts' => []])

@if(count($lowStockProducts) > 0 || count($outOfStockProducts) > 0)
<div class="card border-warning/20 bg-warning/5 mb-6">
    <div class="card-body">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-warning flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div class="flex-1">
                <h4 class="font-semibold mb-2">Peringatan Stok</h4>
                @if(count($outOfStockProducts) > 0)
                    <p class="text-sm mb-2">
                        <span class="font-medium">{{ count($outOfStockProducts) }} produk habis:</span>
                        @foreach($outOfStockProducts as $product)
                            <span class="inline-block bg-error/10 text-error px-2 py-0.5 rounded text-xs mx-1">
                                {{ $product->name }}
                            </span>
                        @endforeach
                    </p>
                @endif
                @if(count($lowStockProducts) > 0)
                    <p class="text-sm">
                        <span class="font-medium">{{ count($lowStockProducts) }} produk stok menipis:</span>
                        @foreach($lowStockProducts as $product)
                            <span class="inline-block bg-warning/10 text-warning px-2 py-0.5 rounded text-xs mx-1">
                                {{ $product->name }} ({{ $product->stock }} left)
                            </span>
                        @endforeach
                    </p>
                @endif
                <a href="{{ route('admin.products.index', ['stock_status' => 'low']) }}" 
                   class="text-accent text-sm hover:underline mt-2 inline-block">
                    Kelola Stok →
                </a>
            </div>
        </div>
    </div>
</div>
@endif