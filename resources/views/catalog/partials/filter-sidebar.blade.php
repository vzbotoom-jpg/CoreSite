{{-- resources/views/catalog/partials/filter-sidebar.blade.php --}}
@props(['categories' => []])

<div class="sticky top-6 space-y-6">
    <!-- Search Filter -->
    <div class="card">
        <div class="card-body">
            <h3 class="font-semibold mb-4">Cari Produk</h3>
            <div class="relative">
                <input type="text" id="searchInput" placeholder="Nama produk..." 
                       class="input pl-10">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-text-secondary" 
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
        </div>
    </div>
    
    <!-- Category Filter -->
    @if(count($categories) > 0)
    <div class="card">
        <div class="card-body">
            <h3 class="font-semibold mb-4">Kategori</h3>
            <div class="space-y-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="category" value="" class="radio" checked>
                    <span class="text-sm">Semua Produk</span>
                </label>
                @foreach($categories as $category)
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="category" value="{{ $category->id }}" class="radio">
                        <span class="text-sm">{{ $category->name }}</span>
                        <span class="text-xs text-text-secondary">({{ $category->products_count ?? 0 }})</span>
                    </label>
                @endforeach
            </div>
        </div>
    </div>
    @endif
    
    <!-- Price Filter -->
    <div class="card">
        <div class="card-body">
            <h3 class="font-semibold mb-4">Harga</h3>
            <div class="space-y-3">
                <div>
                    <label class="text-sm text-text-secondary">Minimal</label>
                    <input type="number" id="minPrice" placeholder="0" class="input mt-1">
                </div>
                <div>
                    <label class="text-sm text-text-secondary">Maksimal</label>
                    <input type="number" id="maxPrice" placeholder="1000000" class="input mt-1">
                </div>
                <button id="applyPriceFilter" class="btn btn-primary w-full text-sm">
                    Terapkan
                </button>
            </div>
        </div>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search filter
        const searchInput = document.getElementById('searchInput');
        if (searchInput && window.catalogStore) {
            searchInput.addEventListener('input', function() {
                window.catalogStore.filters.search = this.value;
                window.catalogStore.applyFilters();
            });
        }
        
        // Category filter
        const categoryRadios = document.querySelectorAll('input[name="category"]');
        categoryRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (window.catalogStore) {
                    window.catalogStore.filters.category = this.value;
                    window.catalogStore.applyFilters();
                } else {
                    const url = new URL(window.location.href);
                    if (this.value) {
                        url.searchParams.set('category', this.value);
                    } else {
                        url.searchParams.delete('category');
                    }
                    window.location.href = url.toString();
                }
            });
        });
        
        // Price filter
        const applyBtn = document.getElementById('applyPriceFilter');
        if (applyBtn && window.catalogStore) {
            applyBtn.addEventListener('click', function() {
                const minPrice = document.getElementById('minPrice')?.value;
                const maxPrice = document.getElementById('maxPrice')?.value;
                window.catalogStore.filters.min_price = minPrice;
                window.catalogStore.filters.max_price = maxPrice;
                window.catalogStore.applyFilters();
            });
        }
    });
    </script>
</div>