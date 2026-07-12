{{-- resources/views/admin/products/partials/product-table.blade.php --}}
<div class="card">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-light-border dark:border-dark-border">
                    <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Produk</th>
                    <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Kategori</th>
                    <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Harga</th>
                    <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Stok</th>
                    <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Status</th>
                    <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="product in products" :key="product.id">
                    <tr class="border-b border-light-border dark:border-dark-border hover:bg-light-surface dark:hover:bg-dark-surface/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-light-surface dark:bg-dark-surface rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="product.name"></p>
                                    <p class="text-xs text-text-secondary dark:text-text-dark-secondary" x-text="'SKU: ' + product.id"></p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-text-primary dark:text-text-dark-primary" x-text="product.category?.name || '-'"></span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-medium text-text-primary dark:text-text-dark-primary" x-text="formatRupiah(product.price)"></span>
                        </td>
                        <td class="px-6 py-4">
                            <span :class="product.stock <= product.min_stock_alert ? 'text-warning' : 'text-text-primary'" 
                                  class="font-medium">
                                <span x-text="product.stock"></span>
                            </span>
                            <span class="text-xs text-text-secondary dark:text-text-dark-secondary" 
                                  x-show="product.stock <= product.min_stock_alert && product.stock > 0">
                                (Min: <span x-text="product.min_stock_alert"></span>)
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span :class="getStockStatusClass(product)" class="badge" x-text="getStockStatusText(product)"></span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a :href="`/admin/products/${product.id}`" class="btn btn-ghost btn-sm" title="Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <button @click="openStockModal(product)" class="btn btn-ghost btn-sm" title="Atur Stok">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </button>
                                <button @click="editProduct(product)" class="btn btn-ghost btn-sm" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                <button @click="deleteProduct(product)" class="btn btn-ghost btn-sm" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </template>
                <tr x-show="products.length === 0 && !loading">
                    <td colspan="6" class="px-6 py-12 text-center">
                        <svg class="w-12 h-12 mx-auto mb-3 text-text-secondary/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <p class="text-text-secondary dark:text-text-dark-secondary">Belum ada produk</p>
                        <button @click="openCreateModal" class="btn btn-ghost btn-sm">
                            Tambah produk pertama →
                        </button>
                    </td>
                </tr>
                <tr x-show="loading">
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="spinner mx-auto"></div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div x-show="lastPage > 1" class="card-footer">
        <div class="flex justify-between items-center">
            <div class="text-sm text-text-secondary dark:text-text-dark-secondary">
                Menampilkan <span x-text="from"></span> - <span x-text="to"></span> dari <span x-text="total"></span> produk
            </div>
            <div class="flex gap-2">
                <button @click="prevPage" :disabled="currentPage === 1" class="btn btn-sm btn-outline">
                    Sebelumnya
                </button>
                <span class="px-3 py-1 text-text-secondary dark:text-text-dark-secondary">
                    Halaman <span x-text="currentPage"></span> dari <span x-text="lastPage"></span>
                </span>
                <button @click="nextPage" :disabled="currentPage === lastPage" class="btn btn-sm btn-outline">
                    Selanjutnya
                </button>
            </div>
        </div>
    </div>
</div>