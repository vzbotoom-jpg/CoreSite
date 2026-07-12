{{-- resources/views/catalog/cart.blade.php --}}
@extends('layouts.catalog')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="cartPage()" x-init="init()">
    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex items-center gap-2 text-sm">
            <li><a href="{{ url('/') }}" class="text-text-secondary hover:text-accent transition-colors">Beranda</a></li>
            <li><svg class="w-4 h-4 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li><span class="text-text-primary dark:text-text-dark-primary font-medium">Keranjang Belanja</span></li>
        </ol>
    </nav>
    
    <div class="flex items-center gap-3 mb-8">
        <h1 class="text-3xl font-bold text-text-primary dark:text-text-dark-primary">Keranjang Belanja</h1>
        <span class="px-3 py-1 bg-accent/10 text-accent text-sm rounded-full" x-text="cartCount + ' item'"></span>
    </div>
    
    <!-- Cart Content -->
    <div x-show="cartItems.length > 0" class="grid lg:grid-cols-3 gap-8">
        <!-- Cart Items -->
        <div class="lg:col-span-2 space-y-4">
            <template x-for="(item, index) in cartItems" :key="item.product_id">
                <div class="card hover:shadow-lg transition-shadow">
                    <div class="card-body">
                        <div class="flex gap-4">
                            <!-- Product Image -->
                            <div class="w-24 h-24 bg-light-surface dark:bg-dark-surface rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-12 h-12 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            
                            <!-- Product Info -->
                            <div class="flex-1">
                                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary" x-text="item.name"></h3>
                                <p class="text-sm text-text-secondary dark:text-text-dark-secondary" x-show="item.store_name" x-text="item.store_name"></p>
                                <p class="text-accent font-bold mt-1" x-text="formatRupiah(item.price)"></p>
                                
                                <!-- Quantity Controls -->
                                <div class="flex items-center gap-3 mt-3">
                                    <div class="flex items-center gap-2 border border-light-border dark:border-dark-border rounded-lg">
                                        <button @click="updateQuantity(index, -1)" 
                                                class="w-8 h-8 flex items-center justify-center hover:bg-light-surface dark:hover:bg-dark-surface transition-colors rounded-l-lg">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                            </svg>
                                        </button>
                                        <span class="w-12 text-center font-medium" x-text="item.quantity"></span>
                                        <button @click="updateQuantity(index, 1)" 
                                                class="w-8 h-8 flex items-center justify-center hover:bg-light-surface dark:hover:bg-dark-surface transition-colors rounded-r-lg">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                        </button>
                                    </div>
                                    
                                    <button @click="removeItem(index)" 
                                            class="text-error hover:text-error/80 transition-colors text-sm">
                                        Hapus
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Subtotal -->
                            <div class="text-right">
                                <p class="font-bold text-text-primary dark:text-text-dark-primary" x-text="formatRupiah(item.price * item.quantity)"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            
            <!-- Continue Shopping -->
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-text-secondary hover:text-accent transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Lanjutkan Belanja
            </a>
        </div>
        
        <!-- Cart Summary -->
        <div>
            <div class="card sticky top-6">
                <div class="card-header">
                    <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Ringkasan Belanja</h3>
                </div>
                <div class="card-body space-y-4">
                    <div class="flex justify-between">
                        <span class="text-text-secondary dark:text-text-dark-secondary">Subtotal</span>
                        <span class="font-medium text-text-primary dark:text-text-dark-primary" x-text="formatRupiah(subtotal)"></span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-text-secondary dark:text-text-dark-secondary">Pengiriman</span>
                        <span class="text-success" x-text="shipping === 0 ? 'Gratis' : formatRupiah(shipping)"></span>
                    </div>
                    
                    <div class="flex justify-between" x-show="discount > 0">
                        <span class="text-text-secondary dark:text-text-dark-secondary">Diskon</span>
                        <span class="text-error" x-text="'-' + formatRupiah(discount)"></span>
                    </div>
                    
                    <div class="border-t border-light-border dark:border-dark-border pt-4">
                        <div class="flex justify-between font-bold">
                            <span class="text-text-primary dark:text-text-dark-primary">Total</span>
                            <span class="text-accent text-xl" x-text="formatRupiah(total)"></span>
                        </div>
                    </div>
                    
                    <button @click="proceedToCheckout" 
                            class="btn btn-primary w-full">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                        Lanjut ke Checkout
                    </button>
                    
                    <button @click="clearCart" 
                            class="btn btn-outline w-full text-sm">
                        Kosongkan Keranjang
                    </button>
                </div>
            </div>
            
            <!-- Payment Methods Info -->
            <div class="card mt-4">
                <div class="card-body">
                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary text-center">
                        Metode pembayaran:
                        <span class="inline-flex items-center gap-1 mx-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            Cash
                        </span>
                        <span class="inline-flex items-center gap-1 mx-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7"/>
                            </svg>
                            Transfer
                        </span>
                        <span class="inline-flex items-center gap-1 mx-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h.01M4.5 12h.01M4.5 4.5h.01M19.5 4.5h.01M19.5 12h.01M4.5 19.5h.01M19.5 19.5h.01"/>
                            </svg>
                            QRIS
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Empty Cart -->
    <div x-show="cartItems.length === 0" class="card text-center py-16">
        <div class="card-body">
            <div class="max-w-sm mx-auto">
                <svg class="w-32 h-32 mx-auto text-text-secondary/30 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6M17 13l1.5 6M9 21h6"/>
                </svg>
                <h2 class="text-2xl font-bold text-text-primary dark:text-text-dark-primary mb-2">Keranjang Kosong</h2>
                <p class="text-text-secondary dark:text-text-dark-secondary mb-8">Belum ada produk di keranjang Anda. Mulai belanja sekarang!</p>
                <a href="{{ url('/') }}" class="btn btn-primary">
                    Mulai Belanja
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function cartPage() {
    return {
        cartItems: [],
        cartCount: 0,
        subtotal: 0,
        shipping: 0,
        discount: 0,
        total: 0,
        
        init() {
            this.loadCart();
        },
        
        loadCart() {
            const cart = JSON.parse(localStorage.getItem('cart') || '[]');
            this.cartItems = cart;
            this.cartCount = cart.reduce((sum, item) => sum + item.quantity, 0);
            this.calculateTotals();
        },
        
        calculateTotals() {
            this.subtotal = this.cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            this.shipping = this.subtotal > 100000 ? 0 : 15000;
            this.discount = 0;
            this.total = this.subtotal + this.shipping - this.discount;
        },
        
        updateQuantity(index, delta) {
            const item = this.cartItems[index];
            const newQuantity = item.quantity + delta;
            
            if (newQuantity >= 1 && newQuantity <= (item.max_stock || 99)) {
                item.quantity = newQuantity;
                this.saveCart();
            } else if (newQuantity > (item.max_stock || 99)) {
                window.showToast('Stok tidak mencukupi', 'warning');
            }
        },
        
        removeItem(index) {
            if (confirm('Hapus produk ini dari keranjang?')) {
                this.cartItems.splice(index, 1);
                this.saveCart();
                window.showToast('Produk dihapus dari keranjang', 'info');
            }
        },
        
        clearCart() {
            if (confirm('Kosongkan semua item di keranjang?')) {
                this.cartItems = [];
                this.saveCart();
                window.showToast('Keranjang dikosongkan', 'info');
            }
        },
        
        saveCart() {
            localStorage.setItem('cart', JSON.stringify(this.cartItems));
            this.cartCount = this.cartItems.reduce((sum, item) => sum + item.quantity, 0);
            this.calculateTotals();
            
            // Update cart count in header
            const cartBadge = document.getElementById('cartCount');
            if (cartBadge) {
                cartBadge.textContent = this.cartCount;
                cartBadge.classList.toggle('hidden', this.cartCount === 0);
            }
        },
        
        proceedToCheckout() {
            if (this.cartItems.length === 0) {
                window.showToast('Keranjang kosong', 'warning');
                return;
            }
            
            // Redirect to checkout
            window.location.href = "{{ route('catalog.checkout') }}";
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