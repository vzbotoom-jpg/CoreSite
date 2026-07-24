{{-- resources/views/admin/transactions/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Transaksi Baru')
@section('page-title', 'Transaksi Baru')

@section('content')
<div x-data="transactionForm()" x-init="init()" class="max-w-4xl mx-auto">
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Form Transaksi Penjualan</h3>
            <p class="text-sm text-text-secondary dark:text-text-dark-secondary mt-1">Tambahkan produk dan proses pembayaran</p>
        </div>
        <div class="card-body">
            <!-- Product Search -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Cari Produk</label>
                <div class="flex gap-2 relative">
                    <input type="text" x-model="searchQuery" @input="searchProducts" 
                           placeholder="Ketik nama produk..." class="input flex-1">
                    <button @click="searchProducts" class="btn btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </div>
                
                <!-- Search Results -->
                <div x-show="searchResults.length > 0" class="absolute z-10 mt-1 w-full max-w-md bg-light-bg dark:bg-dark-bg border border-light-border dark:border-dark-border rounded-lg shadow-lg max-h-60 overflow-y-auto">
                    <template x-for="product in searchResults" :key="product.id">
                        <div @click="addProduct(product)" 
                             class="p-3 hover:bg-light-surface dark:hover:bg-dark-surface cursor-pointer border-b border-light-border dark:border-dark-border last:border-0 flex justify-between items-center transition-colors">
                            <div>
                                <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="product.name"></p>
                                <p class="text-sm text-text-secondary dark:text-text-dark-secondary" x-text="formatRupiah(product.price)"></p>
                            </div>
                            <div>
                                <span class="text-xs text-text-secondary dark:text-text-dark-secondary">Stok: <span x-text="product.stock"></span></span>
                                <span class="ml-2 text-xs text-accent" x-show="product.stock > 0">Tersedia</span>
                                <span class="ml-2 text-xs text-error" x-show="product.stock === 0">Habis</span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
            
            <!-- Cart Items -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-3">
                    <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Keranjang</h4>
                    <span class="text-sm text-text-secondary dark:text-text-dark-secondary" x-text="cart.length + ' item'"></span>
                </div>
                <div class="overflow-x-auto border border-light-border dark:border-dark-border rounded-lg">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-light-surface dark:bg-dark-surface border-b border-light-border dark:border-dark-border">
                                <th class="text-left py-3 px-4 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Produk</th>
                                <th class="text-center py-3 px-4 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Qty</th>
                                <th class="text-right py-3 px-4 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Harga</th>
                                <th class="text-right py-3 px-4 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Subtotal</th>
                                <th class="text-center py-3 px-4 text-sm font-medium text-text-secondary dark:text-text-dark-secondary"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(item, index) in cart" :key="item.product_id">
                                <tr class="border-b border-light-border dark:border-dark-border hover:bg-light-surface/50 dark:hover:bg-dark-surface/50 transition-colors">
                                    <td class="py-3 px-4">
                                        <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="item.name"></p>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <button @click="updateQuantity(index, -1)" class="w-7 h-7 rounded border border-light-border dark:border-dark-border hover:bg-light-surface dark:hover:bg-dark-surface transition-colors">
                                                <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                                </svg>
                                            </button>
                                            <input type="number" x-model="item.quantity" @change="updateItemQuantity(index)" 
                                                   class="w-14 text-center border border-light-border dark:border-dark-border rounded-lg bg-transparent py-1">
                                            <button @click="updateQuantity(index, 1)" class="w-7 h-7 rounded border border-light-border dark:border-dark-border hover:bg-light-surface dark:hover:bg-dark-surface transition-colors">
                                                <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-right text-text-primary dark:text-text-dark-primary" x-text="formatRupiah(item.price)"></td>
                                    <td class="py-3 px-4 text-right font-medium text-accent" x-text="formatRupiah(item.price * item.quantity)"></td>
                                    <td class="py-3 px-4 text-center">
                                        <button @click="removeProduct(index)" class="text-error hover:text-error/80 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                            <tr x-show="cart.length === 0">
                                <td colspan="5" class="py-8 text-center text-text-secondary dark:text-text-dark-secondary">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-text-secondary/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6M17 13l1.5 6M9 21h6"/>
                                    </svg>
                                    <p>Belum ada produk. Silakan cari dan tambahkan produk.</p>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot x-show="cart.length > 0">
                            <tr class="border-t border-light-border dark:border-dark-border bg-light-surface/50 dark:bg-dark-surface/50">
                                <td colspan="3" class="pt-3 px-4 text-right font-semibold text-text-primary dark:text-text-dark-primary">Total:</td>
                                <td class="pt-3 px-4 text-right font-bold text-accent text-lg" x-text="formatRupiah(total)"></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            
            <!-- Payment Section -->
            <div x-show="cart.length > 0" class="border-t border-light-border dark:border-dark-border pt-6">
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-3">Metode Pembayaran</label>
                        <div class="grid grid-cols-3 gap-2">
                            <label class="flex items-center gap-2 p-3 border rounded-lg cursor-pointer hover:border-accent transition-colors"
                                   :class="paymentMethod === 'cash' ? 'border-accent bg-accent/5' : 'border-light-border'">
                                <input type="radio" x-model="paymentMethod" value="cash" class="w-4 h-4 text-accent">
                                <span class="text-sm text-text-primary dark:text-text-dark-primary">Tunai</span>
                            </label>
                            <label class="flex items-center gap-2 p-3 border rounded-lg cursor-pointer hover:border-accent transition-colors"
                                   :class="paymentMethod === 'transfer' ? 'border-accent bg-accent/5' : 'border-light-border'">
                                <input type="radio" x-model="paymentMethod" value="transfer" class="w-4 h-4 text-accent">
                                <span class="text-sm text-text-primary dark:text-text-dark-primary">Transfer</span>
                            </label>
                            <label class="flex items-center gap-2 p-3 border rounded-lg cursor-pointer hover:border-accent transition-colors"
                                   :class="paymentMethod === 'qris' ? 'border-accent bg-accent/5' : 'border-light-border'">
                                <input type="radio" x-model="paymentMethod" value="qris" class="w-4 h-4 text-accent">
                                <span class="text-sm text-text-primary dark:text-text-dark-primary">QRIS</span>
                            </label>
                        </div>
                    </div>
                    
                    <div x-show="paymentMethod === 'cash'">
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Jumlah Dibayar</label>
                        <div class="flex gap-2">
                            <input type="number" x-model="paidAmount" @input="calculateChange" 
                                   class="input" placeholder="Masukkan jumlah uang">
                            <button @click="setQuickAmount(total)" class="btn btn-outline btn-sm whitespace-nowrap">Tepat</button>
                        </div>
                        <div class="mt-2">
                            <p x-show="changeAmount >= 0" class="text-sm">
                                Kembalian: <span class="font-semibold text-success" x-text="formatRupiah(changeAmount)"></span>
                            </p>
                            <p x-show="changeAmount < 0" class="text-sm text-error">
                                Kurang: <span class="font-semibold" x-text="formatRupiah(Math.abs(changeAmount))"></span>
                            </p>
                        </div>
                    </div>
                    
                    <div x-show="paymentMethod === 'transfer'" class="md:col-span-2">
                        <div class="p-4 bg-light-surface dark:bg-dark-surface rounded-lg text-sm">
                            <p class="font-medium text-text-primary dark:text-text-dark-primary mb-2">Rekening Tujuan:</p>
                            <div class="space-y-1">
                                <p class="text-text-secondary dark:text-text-dark-secondary">BCA: <span class="font-mono text-text-primary dark:text-text-dark-primary">1234567890</span> a.n CoreSite</p>
                                <p class="text-text-secondary dark:text-text-dark-secondary">Mandiri: <span class="font-mono text-text-primary dark:text-text-dark-primary">0987654321</span> a.n CoreSite</p>
                            </div>
                        </div>
                    </div>
                    
                    <div x-show="paymentMethod === 'qris'" class="md:col-span-2">
                        <div class="p-4 bg-light-surface dark:bg-dark-surface rounded-lg text-center">
                            <div class="inline-block bg-white p-4 rounded-lg">
                                <svg class="w-40 h-40 mx-auto" viewBox="0 0 100 100">
                                    <rect width="100" height="100" fill="black"/>
                                    <rect x="10" y="10" width="80" height="80" fill="white"/>
                                    <g fill="black">
                                        @for($i = 0; $i < 10; $i++)
                                            @for($j = 0; $j < 10; $j++)
                                                @if(rand(0, 1))
                                                    <rect x="{{ 15 + $i * 7 }}" y="{{ 15 + $j * 7 }}" width="4" height="4"/>
                                                @endif
                                            @endfor
                                        @endfor
                                    </g>
                                </svg>
                            </div>
                            <p class="text-sm text-text-secondary dark:text-text-dark-secondary mt-2">Scan QRIS untuk pembayaran</p>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-light-border dark:border-dark-border">
                    <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">Batal</a>
                    <button @click="processTransaction" 
                            :disabled="cart.length === 0 || (paymentMethod === 'cash' && paidAmount < total)"
                            class="btn btn-primary gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Proses Transaksi
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function transactionForm() {
    return {
        cart: [],
        searchQuery: '',
        searchResults: [],
        paymentMethod: 'cash',
        paidAmount: 0,
        changeAmount: 0,
        total: 0,
        searchTimeout: null,
        loading: false,
        
        init() {
            this.loadProducts();
        },
        
        async searchProducts() {
            if (!this.searchQuery.trim()) {
                this.searchResults = [];
                return;
            }
            
            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(async () => {
                try {
                    const response = await axios.get(`/admin/products?search=${this.searchQuery}&per_page=10`);
                    if (response.data.success) {
                        this.searchResults = response.data.data.data.filter(p => p.stock > 0);
                    }
                } catch (error) {
                    console.error('Failed to search products:', error);
                }
            }, 300);
        },
        
        addProduct(product) {
            const existing = this.cart.find(item => item.product_id === product.id);
            if (existing) {
                if (existing.quantity + 1 <= product.stock) {
                    existing.quantity++;
                } else {
                    window.showToast('Stok tidak mencukupi', 'warning');
                }
            } else {
                this.cart.push({
                    product_id: product.id,
                    name: product.name,
                    price: product.price,
                    quantity: 1,
                    max_stock: product.stock
                });
            }
            this.searchQuery = '';
            this.searchResults = [];
            this.calculateTotal();
        },
        
        updateQuantity(index, delta) {
            const item = this.cart[index];
            const newQuantity = item.quantity + delta;
            if (newQuantity >= 1 && newQuantity <= item.max_stock) {
                item.quantity = newQuantity;
                this.calculateTotal();
            } else if (newQuantity > item.max_stock) {
                window.showToast('Stok tidak mencukupi', 'warning');
            }
        },
        
        updateItemQuantity(index) {
            const item = this.cart[index];
            if (item.quantity < 1) {
                item.quantity = 1;
            }
            if (item.quantity > item.max_stock) {
                item.quantity = item.max_stock;
                window.showToast('Stok tidak mencukupi', 'warning');
            }
            this.calculateTotal();
        },
        
        removeProduct(index) {
            this.cart.splice(index, 1);
            this.calculateTotal();
        },
        
        calculateTotal() {
            this.total = this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            this.calculateChange();
        },
        
        calculateChange() {
            this.changeAmount = this.paidAmount - this.total;
        },
        
        setQuickAmount(amount) {
            this.paidAmount = amount;
            this.calculateChange();
        },
        
        async processTransaction() {
            if (this.cart.length === 0) {
                window.showToast('Keranjang kosong', 'warning');
                return;
            }
            
            if (this.paymentMethod === 'cash' && this.paidAmount < this.total) {
                window.showToast('Pembayaran kurang', 'warning');
                return;
            }
            
            this.loading = true;
            
            const items = this.cart.map(item => ({
                product_id: item.product_id,
                quantity: item.quantity
            }));
            
            try {
                const response = await axios.post('/admin/transactions', {
                    items: items,
                    payment_method: this.paymentMethod,
                    paid_amount: this.paymentMethod === 'cash' ? this.paidAmount : this.total
                });
                
                if (response.data.success) {
                    window.showToast('Transaksi berhasil!', 'success');
                    window.location.href = `/admin/transactions/${response.data.data.id}`;
                }
            } catch (error) {
                window.showToast(error.response?.data?.message || 'Gagal memproses transaksi', 'error');
                this.loading = false;
            }
        },
        
        formatRupiah(value) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(value);
        },
        
        loadProducts() {
            // Initial load if needed
        }
    }
}
</script>
@endpush
@endsection