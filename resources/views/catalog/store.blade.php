{{-- resources/views/catalog/store.blade.php --}}
@extends('layouts.catalog')

@section('title', $store->name)

@section('content')
<div x-data="catalogStore()" x-init="init()">
    <!-- Store Header -->
    <div class="bg-gradient-to-r from-accent/10 to-transparent border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center gap-4">
                <div class="w-20 h-20 bg-white dark:bg-dark-bg rounded-2xl shadow-lg flex items-center justify-center overflow-hidden">
                    @if($store->logo)
                        <img src="{{ Storage::url($store->logo) }}" alt="{{ $store->name }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-3xl font-bold text-accent">{{ strtoupper(substr($store->name, 0, 2)) }}</span>
                    @endif
                </div>
                <div>
                    <h1 class="text-2xl font-bold mb-1">{{ $store->name }}</h1>
                    <p class="text-text-secondary text-sm">{{ $store->description ?? 'Toko online resmi ' . $store->name }}</p>
                    <div class="flex items-center gap-4 mt-2 text-sm">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span>Terdaftar {{ $store->created_at->format('M Y') }}</span>
                        </span>
                        <button onclick="window.location.href='mailto:{{ $store->email }}'" class="btn btn-ghost btn-sm">
                            Hubungi Toko
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Products Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid lg:grid-cols-4 gap-8">
            <!-- Filters Sidebar -->
            <div class="lg:col-span-1">
                @include('catalog.partials.filter-sidebar', ['categories' => $categories ?? []])
            </div>
            
            <!-- Products Grid -->
            <div class="lg:col-span-3">
                <div class="flex justify-between items-center mb-6">
                    <p class="text-sm text-text-secondary">
                        Menampilkan <span x-text="from"></span> - <span x-text="to"></span> dari <span x-text="total"></span> produk
                    </p>
                    <select x-model="sortBy" @change="loadProducts" class="input w-48">
                        <option value="name">Nama A-Z</option>
                        <option value="-name">Nama Z-A</option>
                        <option value="price">Harga Terendah</option>
                        <option value="-price">Harga Tertinggi</option>
                        <option value="-created_at">Terbaru</option>
                    </select>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <template x-for="product in products" :key="product.id">
                        @include('catalog.partials.product-card', ['product' => '{{ product }}'])
                    </template>
                </div>
                
                <div x-show="products.length === 0 && !loading" class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-text-secondary/50 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <p class="text-text-secondary">Tidak ada produk yang ditemukan</p>
                </div>
                
                <!-- Pagination -->
                <div x-show="lastPage > 1" class="mt-8">
                    @include('catalog.partials.pagination')
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function catalogStore() {
    return {
        products: [],
        loading: false,
        currentPage: 1,
        lastPage: 1,
        total: 0,
        from: 0,
        to: 0,
        sortBy: 'name',
        filters: {
            search: '',
            category: '',
            min_price: '',
            max_price: ''
        },
        searchTimeout: null,
        
        init() {
            this.loadProducts();
        },
        
        async loadProducts() {
            this.loading = true;
            const params = new URLSearchParams({
                page: this.currentPage,
                sort_by: this.sortBy,
                search: this.filters.search,
                category_id: this.filters.category,
                min_price: this.filters.min_price,
                max_price: this.filters.max_price
            });
            
            try {
                const response = await axios.get(`/api/catalog/{{ $store->slug }}/products?${params}`);
                if (response.data.success) {
                    this.products = response.data.data.data;
                    this.currentPage = response.data.data.current_page;
                    this.lastPage = response.data.data.last_page;
                    this.total = response.data.data.total;
                    this.from = response.data.data.from;
                    this.to = response.data.data.to;
                }
            } catch (error) {
                console.error('Failed to load products:', error);
            }
            this.loading = false;
        },
        
        goToPage(page) {
            this.currentPage = page;
            this.loadProducts();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        },
        
        applyFilters() {
            this.currentPage = 1;
            this.loadProducts();
        },
        
        formatRupiah(value) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(value);
        }
    }
}
</script>
@endpush
@endsection