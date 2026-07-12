{{-- resources/views/admin/reports/partials/inventory-report.blade.php --}}
<div x-data="inventoryReport()" x-init="init()" class="space-y-6">
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="card">
            <div class="card-body">
                <p class="text-sm text-text-secondary">Total Produk</p>
                <p class="text-2xl font-bold" x-text="formatNumber(summary?.total_products || 0)"></p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <p class="text-sm text-text-secondary">Total Stok</p>
                <p class="text-2xl font-bold" x-text="formatNumber(summary?.total_stock_quantity || 0)"></p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <p class="text-sm text-text-secondary">Nilai Stok</p>
                <p class="text-2xl font-bold" x-text="formatRupiah(summary?.total_stock_value || 0)"></p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <p class="text-sm text-text-secondary">Stok Menipis</p>
                <p class="text-2xl font-bold text-warning" x-text="formatNumber(summary?.low_stock_count || 0)"></p>
            </div>
        </div>
    </div>
    
    <!-- Low Stock Products -->
    <div class="card" x-show="lowStockProducts.length > 0">
        <div class="card-header bg-warning/10">
            <h3 class="font-semibold flex items-center gap-2">
                <svg class="w-5 h-5 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                Produk Stok Menipis
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b">
                        <th class="text-left px-6 py-3">Produk</th>
                        <th class="text-right px-6 py-3">Stok</th>
                        <th class="text-right px-6 py-3">Minimal</th>
                        <th class="text-right px-6 py-3">Harga</th>
                        <th class="text-left px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="product in lowStockProducts" :key="product.id">
                        <tr class="border-b">
                            <td class="px-6 py-3">
                                <div>
                                    <p class="font-medium" x-text="product.name"></p>
                                    <p class="text-xs text-text-secondary" x-text="product.category?.name || 'Tanpa Kategori'"></p>
                                </div>
                            </td>
                            <td class="px-6 py-3 text-right font-medium text-warning" x-text="formatNumber(product.stock)"></td>
                            <td class="px-6 py-3 text-right" x-text="formatNumber(product.min_stock_alert)"></td>
                            <td class="px-6 py-3 text-right" x-text="formatRupiah(product.price)"></td>
                            <td class="px-6 py-3">
                                <a :href="`/admin/products/${product.id}/edit`" class="btn btn-ghost btn-sm">
                                    Restok →
                                </a>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Out of Stock Products -->
    <div class="card" x-show="outOfStockProducts.length > 0">
        <div class="card-header bg-error/10">
            <h3 class="font-semibold flex items-center gap-2">
                <svg class="w-5 h-5 text-error" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Produk Habis
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b">
                        <th class="text-left px-6 py-3">Produk</th>
                        <th class="text-right px-6 py-3">Stok</th>
                        <th class="text-right px-6 py-3">Harga</th>
                        <th class="text-left px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="product in outOfStockProducts" :key="product.id">
                        <tr class="border-b">
                            <td class="px-6 py-3">
                                <div>
                                    <p class="font-medium" x-text="product.name"></p>
                                    <p class="text-xs text-text-secondary" x-text="product.category?.name || 'Tanpa Kategori'"></p>
                                </div>
                            </td>
                            <td class="px-6 py-3 text-right font-medium text-error" x-text="formatNumber(product.stock)"></td>
                            <td class="px-6 py-3 text-right" x-text="formatRupiah(product.price)"></td>
                            <td class="px-6 py-3">
                                <a :href="`/admin/products/${product.id}/edit`" class="btn btn-ghost btn-sm">
                                    Restok →
                                </a>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- All Products -->
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold">Semua Produk</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b">
                        <th class="text-left px-6 py-3">Produk</th>
                        <th class="text-right px-6 py-3">Stok</th>
                        <th class="text-right px-6 py-3">Minimal</th>
                        <th class="text-right px-6 py-3">Harga</th>
                        <th class="text-left px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="product in allProducts" :key="product.id">
                        <tr class="border-b">
                            <td class="px-6 py-3">
                                <div>
                                    <p class="font-medium" x-text="product.name"></p>
                                    <p class="text-xs text-text-secondary" x-text="product.category?.name || 'Tanpa Kategori'"></p>
                                </div>
                            </td>
                            <td class="px-6 py-3 text-right" :class="product.stock === 0 ? 'text-error' : (product.stock <= product.min_stock_alert ? 'text-warning' : '')" 
                                x-text="formatNumber(product.stock)"></td>
                            <td class="px-6 py-3 text-right" x-text="formatNumber(product.min_stock_alert)"></td>
                            <td class="px-6 py-3 text-right" x-text="formatRupiah(product.price)"></td>
                            <td class="px-6 py-3">
                                <span :class="product.is_active ? 'badge-success' : 'badge-error'" class="badge">
                                    <span x-text="product.is_active ? 'Aktif' : 'Nonaktif'"></span>
                                </span>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div x-show="allProductsLastPage > 1" class="card-footer">
            <div class="flex justify-between items-center">
                <div class="text-sm text-text-secondary">
                    Menampilkan <span x-text="allProductsFrom"></span> - <span x-text="allProductsTo"></span> dari <span x-text="allProductsTotal"></span> produk
                </div>
                <div class="flex gap-2">
                    <button @click="productsPrevPage" :disabled="allProductsPage === 1" 
                            class="px-3 py-1 border rounded hover:bg-light-surface disabled:opacity-50">
                        Sebelumnya
                    </button>
                    <button @click="productsNextPage" :disabled="allProductsPage === allProductsLastPage" 
                            class="px-3 py-1 border rounded hover:bg-light-surface disabled:opacity-50">
                        Selanjutnya
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function inventoryReport() {
    return {
        summary: null,
        lowStockProducts: [],
        outOfStockProducts: [],
        allProducts: [],
        allProductsPage: 1,
        allProductsLastPage: 1,
        allProductsTotal: 0,
        allProductsFrom: 0,
        allProductsTo: 0,
        loading: false,
        
        init() {
            this.loadReport();
        },
        
        async loadReport() {
            this.loading = true;
            
            try {
                // Load summary and alerts
                const response = await axios.get('/api/v1/reports/inventory');
                if (response.data.success) {
                    this.summary = response.data.data.stock_summary;
                    this.lowStockProducts = response.data.data.low_stock_products;
                    this.outOfStockProducts = response.data.data.out_of_stock_products;
                }
                
                // Load all products
                await this.loadAllProducts();
            } catch (error) {
                console.error('Failed to load inventory report:', error);
                window.showToast('Gagal memuat laporan inventori', 'error');
            }
            this.loading = false;
        },
        
        async loadAllProducts() {
            try {
                const response = await axios.get(`/api/v1/products?page=${this.allProductsPage}&per_page=20`);
                if (response.data.success) {
                    this.allProducts = response.data.data.data;
                    this.allProductsPage = response.data.data.current_page;
                    this.allProductsLastPage = response.data.data.last_page;
                    this.allProductsTotal = response.data.data.total;
                    this.allProductsFrom = response.data.data.from;
                    this.allProductsTo = response.data.data.to;
                }
            } catch (error) {
                console.error('Failed to load products:', error);
            }
        },
        
        productsPrevPage() {
            if (this.allProductsPage > 1) {
                this.allProductsPage--;
                this.loadAllProducts();
            }
        },
        
        productsNextPage() {
            if (this.allProductsPage < this.allProductsLastPage) {
                this.allProductsPage++;
                this.loadAllProducts();
            }
        },
        
        formatRupiah(value) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(value);
        },
        
        formatNumber(value) {
            return new Intl.NumberFormat('id-ID').format(value);
        }
    }
}
</script>
@endpush