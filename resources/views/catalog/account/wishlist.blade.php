{{-- resources/views/catalog/account/wishlist.blade.php --}}
@extends('layouts.catalog')

@section('title', 'Wishlist')

@section('content')
<div x-data="wishlistManager()" x-init="init()" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid md:grid-cols-4 gap-8">
        <div class="md:col-span-1">
            @include('catalog.account.partials.sidebar')
        </div>
        
        <div class="md:col-span-3">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-text-primary dark:text-text-dark-primary">Wishlist</h1>
                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Koleksi produk favorit Anda</p>
                </div>
                <div class="text-sm text-text-secondary">
                    <span x-text="wishlistItems.length"></span> produk
                </div>
            </div>
            
            <!-- Wishlist Items -->
            <div x-show="wishlistItems.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <template x-for="(item, index) in wishlistItems" :key="item.id">
                    <div class="card hover:shadow-lg transition-all duration-300 group relative">
                        <!-- Remove Button -->
                        <button @click="removeItem(index)" class="absolute top-3 right-3 z-10 p-1.5 bg-white/90 dark:bg-dark-bg/90 rounded-full shadow-sm hover:bg-error/10 transition-colors">
                            <svg class="w-5 h-5 text-error" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </button>
                        
                        <!-- Product Image -->
                        <div class="aspect-square bg-light-surface dark:bg-dark-surface rounded-t-xl flex items-center justify-center p-4 group-hover:scale-105 transition-transform">
                            <svg class="w-20 h-20 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        
                        <div class="p-4">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="badge badge-secondary text-xs" x-text="item.category"></span>
                                <span class="text-xs text-text-secondary" x-text="item.in_stock ? '🟢 Tersedia' : '🔴 Habis'"></span>
                            </div>
                            <h4 class="font-semibold text-text-primary dark:text-text-dark-primary line-clamp-1" x-text="item.name"></h4>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-accent font-bold" x-text="formatRupiah(item.price)"></span>
                                <span x-show="item.original_price" class="text-sm text-text-secondary line-through" x-text="formatRupiah(item.original_price)"></span>
                            </div>
                            
                            <!-- Rating -->
                            <div class="flex items-center gap-1 mt-1">
                                <div class="flex">
                                    <template x-for="i in 5">
                                        <svg class="w-4 h-4" :class="i <= item.rating ? 'text-warning' : 'text-gray-300'" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    </template>
                                </div>
                                <span class="text-xs text-text-secondary" x-text="item.review_count + ' ulasan'"></span>
                            </div>
                            
                            <button @click="addToCart(item)" class="btn btn-primary w-full mt-3 text-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6M17 13l1.5 6M9 21h6"/>
                                </svg>
                                Tambah ke Keranjang
                            </button>
                        </div>
                    </div>
                </template>
            </div>
            
            <!-- Empty State -->
            <div x-show="wishlistItems.length === 0" class="text-center py-16">
                <div class="w-24 h-24 bg-accent/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-accent/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-text-primary dark:text-text-dark-primary mb-2">Wishlist Kosong</h3>
                <p class="text-text-secondary dark:text-text-dark-secondary mb-6">Belum ada produk yang ditambahkan ke wishlist</p>
                <a href="{{ route('catalog.store') }}" class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6M17 13l1.5 6M9 21h6"/>
                    </svg>
                    Mulai Belanja
                </a>
            </div>
            
            <!-- Pagination -->
            <div x-show="wishlistItems.length > 0" class="mt-8 flex justify-center">
                <div class="flex gap-2">
                    <button class="px-3 py-1 border border-light-border/40 dark:border-dark-border/40 rounded-lg text-sm hover:bg-light-surface/50 dark:hover:bg-dark-surface/50 transition">1</button>
                    <button class="px-3 py-1 border border-light-border/40 dark:border-dark-border/40 rounded-lg text-sm hover:bg-light-surface/50 dark:hover:bg-dark-surface/50 transition">2</button>
                    <button class="px-3 py-1 border border-light-border/40 dark:border-dark-border/40 rounded-lg text-sm hover:bg-light-surface/50 dark:hover:bg-dark-surface/50 transition">3</button>
                    <button class="px-3 py-1 border border-light-border/40 dark:border-dark-border/40 rounded-lg text-sm hover:bg-light-surface/50 dark:hover:bg-dark-surface/50 transition">Selanjutnya</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function wishlistManager() {
    return {
        wishlistItems: [
            { id: 1, name: 'Smartphone Pro Max', category: 'Elektronik', price: 2500000, original_price: 2800000, rating: 4.8, review_count: 120, in_stock: true },
            { id: 2, name: 'Kemeja Casual Premium', category: 'Fashion', price: 150000, original_price: 200000, rating: 4.5, review_count: 85, in_stock: true },
            { id: 3, name: 'Kopi Arabika 250gr', category: 'Makanan', price: 75000, original_price: null, rating: 4.9, review_count: 200, in_stock: false },
            { id: 4, name: 'Yoga Mat Premium', category: 'Olahraga', price: 180000, original_price: 220000, rating: 4.6, review_count: 45, in_stock: true },
            { id: 5, name: 'Headphone Bluetooth', category: 'Elektronik', price: 350000, original_price: 400000, rating: 4.7, review_count: 92, in_stock: true },
            { id: 6, name: 'Dress Casual Wanita', category: 'Fashion', price: 200000, original_price: 250000, rating: 4.4, review_count: 68, in_stock: true }
        ],
        
        init() {
            // Load wishlist data
        },
        
        removeItem(index) {
            if (confirm('Hapus produk dari wishlist?')) {
                this.wishlistItems.splice(index, 1);
                window.showToast('Produk dihapus dari wishlist', 'info');
            }
        },
        
        addToCart(item) {
            window.showToast(`${item.name} ditambahkan ke keranjang!`, 'success');
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