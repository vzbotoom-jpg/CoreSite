{{-- resources/views/layouts/partials/catalog-nav.blade.php --}}
<nav class="bg-light-bg dark:bg-dark-bg border-b border-light-border dark:border-dark-border sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <a href="{{ isset($store) ? route('catalog.store', $store->slug) : '#' }}" class="flex items-center gap-2">
                <div class="w-8 h-8 bg-accent rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold text-lg">C</span>
                </div>
                <span class="font-bold text-xl text-text-primary dark:text-text-dark-primary">
                    {{ $store->name ?? 'Catalog' }}
                </span>
            </a>

            <div class="flex items-center gap-4">
                <!-- Cart Link -->
                <a href="/cart" class="text-text-secondary hover:text-accent transition-colors flex items-center gap-1">
                    <span class="text-sm font-semibold">Keranjang</span>
                </a>
            </div>
        </div>
    </div>
</nav>
