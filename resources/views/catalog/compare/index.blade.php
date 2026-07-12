{{-- resources/views/catalog/compare/index.blade.php --}}
@extends('layouts.catalog')

@section('title', 'Bandingkan Produk')

@section('content')
<div x-data="compareProducts()" x-init="init()" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-text-primary dark:text-text-dark-primary tracking-tight">
                Bandingkan Produk
            </h1>
            <p class="text-text-secondary dark:text-text-dark-secondary mt-1">
                Bandingkan spesifikasi dan harga produk untuk membantu keputusan pembelian Anda
            </p>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-sm text-text-secondary">
                <span x-text="products.length"></span> produk dibandingkan
            </span>
            <button @click="clearAll" class="btn btn-outline text-sm" x-show="products.length > 0">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Hapus Semua
            </button>
        </div>
    </div>

    <!-- Product Comparison Grid -->
    <div x-show="products.length > 0" class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full compare-table">
                <thead>
                    <tr class="border-b border-light-border/40 dark:border-dark-border/40">
                        <th class="p-4 text-left text-sm font-medium text-text-secondary dark:text-text-dark-secondary bg-light-surface/50 dark:bg-dark-surface/50 sticky left-0 z-10 min-w-[180px]">
                            Spesifikasi
                        </th>
                        <template x-for="(product, index) in products" :key="product.id">
                            <th class="p-4 text-center min-w-[220px] relative group">
                                <!-- Remove Button -->
                                <button @click="removeProduct(index)" 
                                        class="absolute top-2 right-2 p-1 rounded-full hover:bg-error/10 text-text-secondary hover:text-error transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                                
                                <!-- Product Image -->
                                <div class="w-32 h-32 mx-auto bg-light-surface dark:bg-dark-surface rounded-lg flex items-center justify-center mb-3">
                                    <svg class="w-16 h-16 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                
                                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary line-clamp-2" x-text="product.name"></h3>
                                <p class="text-sm text-text-secondary" x-text="product.category"></p>
                                
                                <!-- Rating -->
                                <div class="flex items-center justify-center gap-1 mt-2">
                                    <div class="flex">
                                        <template x-for="i in 5">
                                            <svg class="w-4 h-4" :class="i <= product.rating ? 'text-warning' : 'text-gray-300'" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        </template>
                                    </div>
                                    <span class="text-xs text-text-secondary" x-text="'(' + product.reviews + ')'"></span>
                                </div>
                            </th>
                        </template>
                        <th x-show="products.length < 4" class="p-4 text-center min-w-[160px] bg-accent/5 border-2 border-dashed border-accent/30 rounded-lg">
                            <div class="flex flex-col items-center justify-center py-8">
                                <svg class="w-12 h-12 text-accent/50 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                <p class="text-sm text-text-secondary">Tambah Produk</p>
                                <p class="text-xs text-text-secondary/60">Maksimal 4 produk</p>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Price -->
                    <tr class="border-b border-light-border/40 dark:border-dark-border/40 hover:bg-light-surface/30 dark:hover:bg-dark-surface/30 transition">
                        <td class="p-4 text-sm font-medium text-text-primary dark:text-text-dark-primary sticky left-0 z-10 bg-light-bg dark:bg-dark-bg">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Harga
                            </div>
                        </td>
                        <template x-for="product in products" :key="product.id">
                            <td class="p-4 text-center">
                                <span class="text-xl font-bold text-accent" x-text="formatRupiah(product.price)"></span>
                                <p x-show="product.original_price" class="text-sm text-text-secondary line-through" x-text="formatRupiah(product.original_price)"></p>
                                <span x-show="product.discount" class="inline-block mt-1 px-2 py-0.5 text-xs font-medium text-success bg-success/10 rounded-full" x-text="'-' + product.discount + '%'"></span>
                            </td>
                        </template>
                        <td x-show="products.length < 4" class="p-4 text-center text-text-secondary/50">-</td>
                    </tr>

                    <!-- Stock Status -->
                    <tr class="border-b border-light-border/40 dark:border-dark-border/40 hover:bg-light-surface/30 dark:hover:bg-dark-surface/30 transition">
                        <td class="p-4 text-sm font-medium text-text-primary dark:text-text-dark-primary sticky left-0 z-10 bg-light-bg dark:bg-dark-bg">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                                </svg>
                                Ketersediaan
                            </div>
                        </td>
                        <template x-for="product in products" :key="product.id">
                            <td class="p-4 text-center">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm"
                                      :class="product.in_stock ? 'bg-success/10 text-success' : 'bg-error/10 text-error'">
                                    <span class="w-1.5 h-1.5 rounded-full" :class="product.in_stock ? 'bg-success' : 'bg-error'"></span>
                                    <span x-text="product.in_stock ? 'Tersedia' : 'Habis'"></span>
                                </span>
                                <p class="text-xs text-text-secondary mt-1" x-text="product.in_stock ? 'Stok: ' + product.stock : 'Stok habis'"></p>
                            </td>
                        </template>
                        <td x-show="products.length < 4" class="p-4 text-center text-text-secondary/50">-</td>
                    </tr>

                    <!-- Brand -->
                    <tr class="border-b border-light-border/40 dark:border-dark-border/40 hover:bg-light-surface/30 dark:hover:bg-dark-surface/30 transition">
                        <td class="p-4 text-sm font-medium text-text-primary dark:text-text-dark-primary sticky left-0 z-10 bg-light-bg dark:bg-dark-bg">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                Brand
                            </div>
                        </td>
                        <template x-for="product in products" :key="product.id">
                            <td class="p-4 text-center font-medium text-text-primary dark:text-text-dark-primary" x-text="product.brand"></td>
                        </template>
                        <td x-show="products.length < 4" class="p-4 text-center text-text-secondary/50">-</td>
                    </tr>

                    <!-- Category -->
                    <tr class="border-b border-light-border/40 dark:border-dark-border/40 hover:bg-light-surface/30 dark:hover:bg-dark-surface/30 transition">
                        <td class="p-4 text-sm font-medium text-text-primary dark:text-text-dark-primary sticky left-0 z-10 bg-light-bg dark:bg-dark-bg">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                                Kategori
                            </div>
                        </td>
                        <template x-for="product in products" :key="product.id">
                            <td class="p-4 text-center">
                                <span class="badge badge-secondary" x-text="product.category"></span>
                            </td>
                        </template>
                        <td x-show="products.length < 4" class="p-4 text-center text-text-secondary/50">-</td>
                    </tr>

                    <!-- Rating -->
                    <tr class="border-b border-light-border/40 dark:border-dark-border/40 hover:bg-light-surface/30 dark:hover:bg-dark-surface/30 transition">
                        <td class="p-4 text-sm font-medium text-text-primary dark:text-text-dark-primary sticky left-0 z-10 bg-light-bg dark:bg-dark-bg">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                                Rating
                            </div>
                        </td>
                        <template x-for="product in products" :key="product.id">
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <span class="font-bold text-text-primary dark:text-text-dark-primary" x-text="product.rating.toFixed(1)"></span>
                                    <div class="flex">
                                        <template x-for="i in 5">
                                            <svg class="w-4 h-4" :class="i <= Math.round(product.rating) ? 'text-warning' : 'text-gray-300'" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        </template>
                                    </div>
                                    <span class="text-xs text-text-secondary" x-text="'(' + product.reviews + ')'"></span>
                                </div>
                            </td>
                        </template>
                        <td x-show="products.length < 4" class="p-4 text-center text-text-secondary/50">-</td>
                    </tr>

                    <!-- Description -->
                    <tr class="border-b border-light-border/40 dark:border-dark-border/40 hover:bg-light-surface/30 dark:hover:bg-dark-surface/30 transition">
                        <td class="p-4 text-sm font-medium text-text-primary dark:text-text-dark-primary sticky left-0 z-10 bg-light-bg dark:bg-dark-bg">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                                Deskripsi
                            </div>
                        </td>
                        <template x-for="product in products" :key="product.id">
                            <td class="p-4 text-center">
                                <p class="text-sm text-text-secondary line-clamp-4 max-w-[200px] mx-auto" x-text="product.description"></p>
                            </td>
                        </template>
                        <td x-show="products.length < 4" class="p-4 text-center text-text-secondary/50">-</td>
                    </tr>

                    <!-- Specifications -->
                    <tr class="border-b border-light-border/40 dark:border-dark-border/40 hover:bg-light-surface/30 dark:hover:bg-dark-surface/30 transition">
                        <td class="p-4 text-sm font-medium text-text-primary dark:text-text-dark-primary sticky left-0 z-10 bg-light-bg dark:bg-dark-bg">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                </svg>
                                Spesifikasi
                            </div>
                        </td>
                        <template x-for="product in products" :key="product.id">
                            <td class="p-4">
                                <div class="space-y-2 text-sm text-center max-w-[200px] mx-auto">
                                    <template x-for="(spec, key) in product.specs" :key="key">
                                        <div class="flex justify-between border-b border-light-border/20 dark:border-dark-border/20 pb-1">
                                            <span class="text-text-secondary" x-text="key"></span>
                                            <span class="font-medium text-text-primary dark:text-text-dark-primary" x-text="spec"></span>
                                        </div>
                                    </template>
                                </div>
                            </td>
                        </template>
                        <td x-show="products.length < 4" class="p-4 text-center text-text-secondary/50">-</td>
                    </tr>

                    <!-- Actions -->
                    <tr class="hover:bg-light-surface/30 dark:hover:bg-dark-surface/30 transition">
                        <td class="p-4 text-sm font-medium text-text-primary dark:text-text-dark-primary sticky left-0 z-10 bg-light-bg dark:bg-dark-bg">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Aksi
                            </div>
                        </td>
                        <template x-for="product in products" :key="product.id">
                            <td class="p-4 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <a :href="`/product/${product.slug}`" class="btn btn-primary text-sm w-full">
                                        Lihat Detail
                                    </a>
                                    <button @click="addToCart(product)" class="btn btn-secondary text-sm w-full">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6M17 13l1.5 6M9 21h6"/>
                                        </svg>
                                        Tambah ke Keranjang
                                    </button>
                                </div>
                            </td>
                        </template>
                        <td x-show="products.length < 4" class="p-4 text-center text-text-secondary/50">-</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Empty State -->
    <div x-show="products.length === 0" class="text-center py-16">
        <div class="w-32 h-32 mx-auto bg-accent/10 rounded-full flex items-center justify-center mb-6">
            <svg class="w-16 h-16 text-accent/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-text-primary dark:text-text-dark-primary mb-3">
            Belum Ada Produk untuk Dibandingkan
        </h2>
        <p class="text-text-secondary dark:text-text-dark-secondary mb-8 max-w-md mx-auto">
            Tambahkan produk ke halaman perbandingan untuk melihat perbedaan spesifikasi dan harga secara berdampingan.
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('catalog.store') }}" class="btn btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6M17 13l1.5 6M9 21h6"/>
                </svg>
                Mulai Belanja
            </a>
            <a href="{{ route('catalog.store') }}?category=featured" class="btn btn-secondary">
                Lihat Produk Unggulan
            </a>
        </div>
    </div>

    <!-- Recommended Products -->
    <div x-show="products.length > 0 && products.length < 4" class="mt-8">
        <div class="flex items-center gap-3 mb-6">
            <h2 class="text-xl font-bold text-text-primary dark:text-text-dark-primary">Produk Lain yang Mungkin Anda Suka</h2>
            <span class="text-sm text-text-secondary">Tambahkan untuk perbandingan</span>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <template x-for="recommended in recommendedProducts" :key="recommended.id">
                <div class="card hover:shadow-lg transition-all duration-300">
                    <div class="card-body">
                        <div class="w-full h-32 bg-light-surface dark:bg-dark-surface rounded-lg flex items-center justify-center mb-3">
                            <svg class="w-12 h-12 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-text-primary dark:text-text-dark-primary line-clamp-1" x-text="recommended.name"></h4>
                        <p class="text-accent font-bold text-sm" x-text="formatRupiah(recommended.price)"></p>
                        <button @click="addRecommendedProduct(recommended)" class="btn btn-primary text-sm w-full mt-3">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambahkan
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Share Comparison -->
    <div x-show="products.length > 0" class="mt-8 flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <span class="text-sm text-text-secondary">Bagikan perbandingan:</span>
            <button @click="shareComparison" class="p-2 rounded-lg hover:bg-light-surface/50 dark:hover:bg-dark-surface/50 transition">
                <svg class="w-5 h-5 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                </svg>
            </button>
        </div>
        <div class="flex items-center gap-2 text-sm text-text-secondary">
            <span>Maksimal 4 produk dapat dibandingkan</span>
            <span class="w-1 h-1 rounded-full bg-text-secondary/30"></span>
            <span x-text="products.length + ' dari 4'"></span>
        </div>
    </div>
</div>

@push('scripts')
<script>
function compareProducts() {
    return {
        products: [],
        recommendedProducts: [],
        
        init() {
            // Load products from localStorage or session
            const saved = localStorage.getItem('compare_products');
            if (saved) {
                try {
                    this.products = JSON.parse(saved);
                } catch {
                    this.products = [];
                }
            }
            
            // If no products, load sample data
            if (this.products.length === 0) {
                this.loadSampleProducts();
            }
            
            this.loadRecommended();
            this.saveToStorage();
        },
        
        loadSampleProducts() {
            this.products = [
                {
                    id: 1,
                    name: 'Smartphone Pro Max',
                    slug: 'smartphone-pro-max',
                    category: 'Elektronik',
                    brand: 'TechBrand',
                    price: 2500000,
                    original_price: 2800000,
                    discount: 15,
                    rating: 4.8,
                    reviews: 120,
                    in_stock: true,
                    stock: 45,
                    description: 'Smartphone flagship dengan performa terbaik, kamera 108MP, dan baterai tahan lama.',
                    specs: {
                        'Prosesor': 'Octa-core 3.2GHz',
                        'RAM': '8GB',
                        'Storage': '256GB',
                        'Kamera': '108MP + 12MP + 8MP',
                        'Baterai': '5000mAh',
                        'Display': '6.8" AMOLED 120Hz'
                    }
                },
                {
                    id: 2,
                    name: 'Kemeja Casual Premium',
                    slug: 'kemeja-casual-premium',
                    category: 'Fashion',
                    brand: 'FashionHouse',
                    price: 150000,
                    original_price: 200000,
                    discount: 25,
                    rating: 4.5,
                    reviews: 85,
                    in_stock: true,
                    stock: 30,
                    description: 'Kemeja casual premium dengan bahan katun berkualitas tinggi, nyaman dipakai sehari-hari.',
                    specs: {
                        'Bahan': 'Katun 100%',
                        'Ukuran': 'S, M, L, XL',
                        'Warna': 'Putih, Biru, Hitam',
                        'Jenis': 'Casual',
                        'Lengan': 'Pendek'
                    }
                },
                {
                    id: 3,
                    name: 'Kopi Arabika 250gr',
                    slug: 'kopi-arabika-250gr',
                    category: 'Makanan',
                    brand: 'CoffeeRoast',
                    price: 75000,
                    original_price: null,
                    discount: 0,
                    rating: 4.9,
                    reviews: 200,
                    in_stock: false,
                    stock: 0,
                    description: 'Kopi Arabika premium dengan rasa yang kaya dan aroma yang menggoda. Sangrai medium.',
                    specs: {
                        'Jenis': 'Arabika',
                        'Berat': '250gr',
                        'Tingkat Sangrai': 'Medium',
                        'Asal': 'Sumatra',
                        'Rasa': 'Cokelat, Kacang'
                    }
                }
            ];
        },
        
        loadRecommended() {
            this.recommendedProducts = [
                {
                    id: 4,
                    name: 'Headphone Bluetooth Pro',
                    slug: 'headphone-bluetooth-pro',
                    category: 'Elektronik',
                    price: 350000,
                    original_price: 450000,
                    discount: 22,
                    rating: 4.7,
                    reviews: 92,
                    in_stock: true,
                    stock: 20
                },
                {
                    id: 5,
                    name: 'Dress Casual Wanita',
                    slug: 'dress-casual-wanita',
                    category: 'Fashion',
                    price: 200000,
                    original_price: 250000,
                    discount: 20,
                    rating: 4.4,
                    reviews: 68,
                    in_stock: true,
                    stock: 15
                },
                {
                    id: 6,
                    name: 'Teh Tarik Instan',
                    slug: 'teh-tarik-instan',
                    category: 'Makanan',
                    price: 25000,
                    original_price: null,
                    discount: 0,
                    rating: 4.6,
                    reviews: 45,
                    in_stock: true,
                    stock: 100
                },
                {
                    id: 7,
                    name: 'Yoga Mat Premium',
                    slug: 'yoga-mat-premium',
                    category: 'Olahraga',
                    price: 180000,
                    original_price: 220000,
                    discount: 18,
                    rating: 4.8,
                    reviews: 56,
                    in_stock: true,
                    stock: 12
                }
            ];
        },
        
        saveToStorage() {
            localStorage.setItem('compare_products', JSON.stringify(this.products));
        },
        
        addProduct(product) {
            if (this.products.length >= 4) {
                window.showToast('Maksimal 4 produk dapat dibandingkan', 'warning');
                return;
            }
            
            if (this.products.some(p => p.id === product.id)) {
                window.showToast('Produk sudah ada di perbandingan', 'info');
                return;
            }
            
            this.products.push(product);
            this.saveToStorage();
            window.showToast('Produk ditambahkan ke perbandingan', 'success');
        },
        
        addRecommendedProduct(product) {
            this.addProduct(product);
        },
        
        removeProduct(index) {
            this.products.splice(index, 1);
            this.saveToStorage();
            window.showToast('Produk dihapus dari perbandingan', 'info');
        },
        
        clearAll() {
            if (this.products.length === 0) return;
            if (confirm('Hapus semua produk dari perbandingan?')) {
                this.products = [];
                this.saveToStorage();
                window.showToast('Semua produk dihapus', 'info');
            }
        },
        
        addToCart(product) {
            window.showToast(`${product.name} ditambahkan ke keranjang!`, 'success');
        },
        
        shareComparison() {
            if (this.products.length === 0) return;
            const url = window.location.href;
            if (navigator.share) {
                navigator.share({
                    title: 'Bandingkan Produk',
                    text: `Lihat perbandingan ${this.products.map(p => p.name).join(', ')}`,
                    url: url
                }).catch(() => {});
            } else {
                navigator.clipboard.writeText(url).then(() => {
                    window.showToast('Link perbandingan disalin!', 'success');
                });
            }
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

@push('styles')
<style>
.compare-table th,
.compare-table td {
    border-right: 1px solid rgba(var(--color-light-border), 0.1);
}
.compare-table th:last-child,
.compare-table td:last-child {
    border-right: none;
}
.dark .compare-table th,
.dark .compare-table td {
    border-right-color: rgba(var(--color-dark-border), 0.1);
}
.sticky {
    position: sticky;
}
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.line-clamp-4 {
    display: -webkit-box;
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endpush
@endsection