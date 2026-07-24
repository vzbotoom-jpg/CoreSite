{{-- resources/views/admin/products/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Manajemen Produk')
@section('page-title', 'Manajemen Produk')

@section('content')
<div x-data="productManager()" x-init="init()" class="space-y-6">
    <!-- Header -->
    <div class="flex flex-wrap justify-between items-center gap-4">
        <div>
            <p class="text-text-secondary">Kelola stok dan informasi produk toko Anda</p>
        </div>
        <div class="flex gap-3">
            <button @click="openImportModal" class="btn btn-outline gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                Import
            </button>
            <button @click="openCreateModal" class="btn btn-primary gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Produk
            </button>
        </div>
    </div>
    
    <!-- Filters -->
    <div class="card">
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <input type="text" x-model="filters.search" @input="debounceSearch" 
                           placeholder="Cari produk..." class="input">
                </div>
                <div>
                    <select x-model="filters.category" @change="loadProducts" class="input">
                        <option value="">Semua Kategori</option>
                        <template x-for="category in categories" :key="category.id">
                            <option :value="category.id" x-text="category.name"></option>
                        </template>
                    </select>
                </div>
                <div>
                    <select x-model="filters.status" @change="loadProducts" class="input">
                        <option value="">Semua Status</option>
                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div>
                <div>
                    <select x-model="filters.stock_status" @change="loadProducts" class="input">
                        <option value="">Semua Stok</option>
                        <option value="low">Stok Menipis</option>
                        <option value="out">Stok Habis</option>
                        <option value="safe">Stok Aman</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end mt-4">
                <button @click="resetFilters" class="text-sm text-text-secondary hover:text-accent">
                    Reset Filter
                </button>
            </div>
        </div>
    </div>
    
    <!-- Products Table -->
    @include('admin.products.partials.product-table')
    
    <!-- Product Modal -->
    <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" 
         @click.away="closeModal">
        <div class="card w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto" @click.stop>
            <div class="card-header flex justify-between items-center">
                <h3 class="text-xl font-bold" x-text="modalTitle"></h3>
                <button @click="closeModal" class="text-text-secondary hover:text-text-primary">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="card-body">
                <form @submit.prevent="saveProduct">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">Nama Produk *</label>
                            <input type="text" x-model="form.name" required class="input">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium mb-2">Kategori</label>
                            <select x-model="form.category_id" class="input">
                                <option value="">Pilih Kategori</option>
                                <template x-for="category in categories" :key="category.id">
                                    <option :value="category.id" x-text="category.name"></option>
                                </template>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium mb-2">Deskripsi</label>
                            <textarea x-model="form.description" rows="3" class="input"></textarea>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-2">Harga *</label>
                                <input type="number" x-model="form.price" required min="0" class="input">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">Stok Awal *</label>
                                <input type="number" x-model="form.stock" required min="0" class="input">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium mb-2">Minimal Stok Peringatan</label>
                            <input type="number" x-model="form.min_stock_alert" required min="0" class="input">
                        </div>
                        
                        <div>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" x-model="form.is_active" class="rounded border-gray-300">
                                <span class="text-sm">Produk Aktif</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="flex justify-end gap-3 mt-6 pt-4 border-t">
                        <button type="button" @click="closeModal" class="btn btn-secondary">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Stock Adjust Modal -->
    <div x-show="showStockModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div class="card w-full max-w-md mx-4" @click.stop>
            <div class="card-header">
                <h3 class="text-xl font-bold">Atur Stok: <span x-text="selectedProduct?.name"></span></h3>
            </div>
            <div class="card-body">
                <form @submit.prevent="adjustStock">
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Jumlah</label>
                        <input type="number" x-model="stockQuantity" required class="input">
                        <p class="text-xs text-text-secondary mt-1">Masukkan angka positif untuk menambah, negatif untuk mengurangi</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Catatan</label>
                        <textarea x-model="stockNotes" rows="2" class="input" placeholder="Catatan penyesuaian stok"></textarea>
                    </div>
                    <div class="flex justify-end gap-3 mt-4">
                        <button type="button" @click="showStockModal = false" class="btn btn-secondary">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function productManager() {
    return {
        products: [],
        categories: @json($categories ?? []),
        loading: false,
        currentPage: 1,
        lastPage: 1,
        total: 0,
        from: 0,
        to: 0,
        
        filters: {
            search: '',
            category: '',
            status: '',
            stock_status: ''
        },
        
        showModal: false,
        modalTitle: '',
        isEditing: false,
        form: {
            id: null,
            name: '',
            category_id: '',
            description: '',
            price: 0,
            stock: 0,
            min_stock_alert: 5,
            is_active: true
        },
        
        showStockModal: false,
        selectedProduct: null,
        stockQuantity: 0,
        stockNotes: '',
        
        searchTimeout: null,
        
        init() {
            this.loadProducts();
        },
        
        async loadProducts() {
            this.loading = true;
            const params = new URLSearchParams({
                page: this.currentPage,
                search: this.filters.search,
                category_id: this.filters.category,
                status: this.filters.status,
                stock_status: this.filters.stock_status
            });
            
            try {
                const response = await axios.get(`/admin/products?${params}`);
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
                window.showToast('Gagal memuat produk', 'error');
            }
            this.loading = false;
        },
        
        debounceSearch() {
            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(() => {
                this.currentPage = 1;
                this.loadProducts();
            }, 300);
        },
        
        resetFilters() {
            this.filters = {
                search: '',
                category: '',
                status: '',
                stock_status: ''
            };
            this.currentPage = 1;
            this.loadProducts();
        },
        
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
                this.loadProducts();
            }
        },
        
        nextPage() {
            if (this.currentPage < this.lastPage) {
                this.currentPage++;
                this.loadProducts();
            }
        },
        
        openCreateModal() {
            this.isEditing = false;
            this.modalTitle = 'Tambah Produk Baru';
            this.form = {
                id: null,
                name: '',
                category_id: '',
                description: '',
                price: 0,
                stock: 0,
                min_stock_alert: 5,
                is_active: true
            };
            this.showModal = true;
        },
        
        editProduct(product) {
            this.isEditing = true;
            this.modalTitle = 'Edit Produk';
            this.form = { ...product };
            this.showModal = true;
        },
        
        async saveProduct() {
            const url = this.isEditing ? `/admin/products/${this.form.id}` : '/admin/products';
            const method = this.isEditing ? 'PUT' : 'POST';
            
            try {
                const response = await axios({
                    method: method,
                    url: url,
                    data: this.form
                });
                
                if (response.data.success) {
                    this.closeModal();
                    this.loadProducts();
                    window.showToast(this.isEditing ? 'Produk berhasil diupdate' : 'Produk berhasil ditambahkan', 'success');
                }
            } catch (error) {
                window.showToast(error.response?.data?.message || 'Gagal menyimpan produk', 'error');
            }
        },
        
        openStockModal(product) {
            this.selectedProduct = product;
            this.stockQuantity = 0;
            this.stockNotes = '';
            this.showStockModal = true;
        },
        
        async adjustStock() {
            if (!this.stockQuantity) {
                window.showToast('Masukkan jumlah stok', 'warning');
                return;
            }
            
            try {
                const response = await axios.post(`/admin/products/${this.selectedProduct.id}/adjust-stock`, {
                    quantity: parseInt(this.stockQuantity),
                    notes: this.stockNotes
                });
                
                if (response.data.success) {
                    this.showStockModal = false;
                    this.loadProducts();
                    window.showToast('Stok berhasil disesuaikan', 'success');
                }
            } catch (error) {
                window.showToast(error.response?.data?.message || 'Gagal menyesuaikan stok', 'error');
            }
        },
        
        async deleteProduct(product) {
            if (!confirm(`Hapus produk "${product.name}"?`)) return;
            
            try {
                const response = await axios.delete(`/admin/products/${product.id}`);
                if (response.data.success) {
                    this.loadProducts();
                    window.showToast('Produk berhasil dihapus', 'success');
                }
            } catch (error) {
                window.showToast(error.response?.data?.message || 'Gagal menghapus produk', 'error');
            }
        },
        
        openImportModal() {
            window.showToast('Fitur import akan segera tersedia', 'info');
        },
        
        closeModal() {
            this.showModal = false;
        },
        
        formatRupiah(value) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(value);
        },
        
        getStockStatus(product) {
            if (product.stock <= 0) return 'out';
            if (product.stock <= product.min_stock_alert) return 'low';
            return 'safe';
        },
        
        getStockStatusText(product) {
            const status = this.getStockStatus(product);
            if (status === 'out') return 'Stok Habis';
            if (status === 'low') return 'Stok Menipis';
            return 'Stok Aman';
        },
        
        getStockStatusClass(product) {
            const status = this.getStockStatus(product);
            if (status === 'out') return 'badge-error';
            if (status === 'low') return 'badge-warning';
            return 'badge-success';
        }
    }
}
</script>
@endpush
@endsection