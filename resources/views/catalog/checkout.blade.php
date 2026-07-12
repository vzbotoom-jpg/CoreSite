{{-- resources/views/catalog/checkout.blade.php --}}
@extends('layouts.catalog')

@section('title', 'Checkout')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="checkoutPage()" x-init="init()">
    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex items-center gap-2 text-sm">
            <li><a href="{{ url('/') }}" class="text-text-secondary hover:text-accent transition-colors">Beranda</a></li>
            <li><svg class="w-4 h-4 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li><a href="{{ route('catalog.cart') }}" class="text-text-secondary hover:text-accent transition-colors">Keranjang</a></li>
            <li><svg class="w-4 h-4 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li><span class="text-text-primary dark:text-text-dark-primary font-medium">Checkout</span></li>
        </ol>
    </nav>
    
    <h1 class="text-3xl font-bold text-text-primary dark:text-text-dark-primary mb-8">Checkout</h1>
    
    <div x-show="cartItems.length > 0" class="grid lg:grid-cols-3 gap-8">
        <!-- Checkout Form -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Customer Info -->
            <div class="card">
                <div class="card-header">
                    <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Informasi Pelanggan</h3>
                </div>
                <div class="card-body">
                    <form @submit.prevent="placeOrder">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Nama Lengkap *</label>
                                <input type="text" x-model="form.name" required class="input" placeholder="Nama Anda">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Email *</label>
                                <input type="email" x-model="form.email" required class="input" placeholder="email@example.com">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Nomor Telepon *</label>
                                <input type="tel" x-model="form.phone" required class="input" placeholder="08123456789">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Alamat *</label>
                                <input type="text" x-model="form.address" required class="input" placeholder="Alamat lengkap">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Catatan (Opsional)</label>
                                <textarea x-model="form.notes" rows="2" class="input" placeholder="Catatan untuk toko"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Payment Method -->
            <div class="card">
                <div class="card-header">
                    <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Metode Pembayaran</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <label class="flex items-center gap-3 p-3 border rounded-lg cursor-pointer hover:border-accent transition-colors"
                               :class="form.payment_method === 'cash' ? 'border-accent bg-accent/5' : 'border-light-border'">
                            <input type="radio" x-model="form.payment_method" value="cash" class="w-4 h-4 text-accent">
                            <div>
                                <p class="font-medium text-text-primary dark:text-text-dark-primary">Tunai</p>
                                <p class="text-xs text-text-secondary dark:text-text-dark-secondary">Bayar langsung di toko</p>
                            </div>
                        </label>
                        
                        <label class="flex items-center gap-3 p-3 border rounded-lg cursor-pointer hover:border-accent transition-colors"
                               :class="form.payment_method === 'transfer' ? 'border-accent bg-accent/5' : 'border-light-border'">
                            <input type="radio" x-model="form.payment_method" value="transfer" class="w-4 h-4 text-accent">
                            <div>
                                <p class="font-medium text-text-primary dark:text-text-dark-primary">Transfer</p>
                                <p class="text-xs text-text-secondary dark:text-text-dark-secondary">Transfer ke rekening kami</p>
                            </div>
                        </label>
                        
                        <label class="flex items-center gap-3 p-3 border rounded-lg cursor-pointer hover:border-accent transition-colors"
                               :class="form.payment_method === 'qris' ? 'border-accent bg-accent/5' : 'border-light-border'">
                            <input type="radio" x-model="form.payment_method" value="qris" class="w-4 h-4 text-accent">
                            <div>
                                <p class="font-medium text-text-primary dark:text-text-dark-primary">QRIS</p>
                                <p class="text-xs text-text-secondary dark:text-text-dark-secondary">Scan QRIS untuk bayar</p>
                            </div>
                        </label>
                    </div>
                    
                    <!-- Bank Account Details (for transfer) -->
                    <div x-show="form.payment_method === 'transfer'" class="mt-4 p-4 bg-light-surface dark:bg-dark-surface rounded-lg">
                        <p class="font-medium text-text-primary dark:text-text-dark-primary mb-2">Rekening Tujuan:</p>
                        <div class="space-y-1 text-sm">
                            <p class="text-text-secondary dark:text-text-dark-secondary">BCA: <span class="font-mono text-text-primary dark:text-text-dark-primary">1234567890</span> a.n CoreSite</p>
                            <p class="text-text-secondary dark:text-text-dark-secondary">Mandiri: <span class="font-mono text-text-primary dark:text-text-dark-primary">0987654321</span> a.n CoreSite</p>
                        </div>
                    </div>
                    
                    <!-- QRIS Details -->
                    <div x-show="form.payment_method === 'qris'" class="mt-4 text-center p-4 bg-light-surface dark:bg-dark-surface rounded-lg">
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
        </div>
        
        <!-- Order Summary -->
        <div>
            <div class="card sticky top-6">
                <div class="card-header">
                    <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Ringkasan Pesanan</h3>
                </div>
                <div class="card-body">
                    <!-- Order Items -->
                    <div class="space-y-3 max-h-60 overflow-y-auto">
                        <template x-for="item in cartItems" :key="item.product_id">
                            <div class="flex justify-between items-center text-sm">
                                <div>
                                    <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="item.name"></p>
                                    <p class="text-xs text-text-secondary dark:text-text-dark-secondary" x-text="item.quantity + 'x'"></p>
                                </div>
                                <span class="font-medium text-text-primary dark:text-text-dark-primary" x-text="formatRupiah(item.price * item.quantity)"></span>
                            </div>
                        </template>
                    </div>
                    
                    <div class="border-t border-light-border dark:border-dark-border mt-4 pt-4 space-y-3">
                        <div class="flex justify-between">
                            <span class="text-text-secondary dark:text-text-dark-secondary">Subtotal</span>
                            <span class="font-medium text-text-primary dark:text-text-dark-primary" x-text="formatRupiah(subtotal)"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-text-secondary dark:text-text-dark-secondary">Pengiriman</span>
                            <span class="text-success" x-text="shipping === 0 ? 'Gratis' : formatRupiah(shipping)"></span>
                        </div>
                        <div class="flex justify-between border-t border-light-border dark:border-dark-border pt-3">
                            <span class="font-bold text-text-primary dark:text-text-dark-primary">Total</span>
                            <span class="font-bold text-accent text-xl" x-text="formatRupiah(total)"></span>
                        </div>
                    </div>
                    
                    <button @click="placeOrder" 
                            class="btn btn-primary w-full mt-6"
                            :disabled="!isFormValid">
                        <span x-show="processing">
                            <svg class="animate-spin h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                        <span x-show="!processing">Pesan Sekarang</span>
                    </button>
                    
                    <p class="text-xs text-text-secondary dark:text-text-dark-secondary text-center mt-4">
                        Dengan melanjutkan, Anda menyetujui 
                        <a href="#" class="btn btn-ghost btn-sm">Syarat & Ketentuan</a>
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
                <p class="text-text-secondary dark:text-text-dark-secondary mb-8">Tambahkan produk ke keranjang terlebih dahulu.</p>
                <a href="{{ url('/') }}" class="btn btn-primary">Mulai Belanja</a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function checkoutPage() {
    return {
        cartItems: [],
        subtotal: 0,
        shipping: 0,
        total: 0,
        processing: false,
        
        form: {
            name: '',
            email: '',
            phone: '',
            address: '',
            notes: '',
            payment_method: 'cash'
        },
        
        init() {
            this.loadCart();
        },
        
        loadCart() {
            const cart = JSON.parse(localStorage.getItem('cart') || '[]');
            
            if (cart.length === 0) {
                window.location.href = "{{ route('catalog.cart') }}";
                return;
            }
            
            this.cartItems = cart;
            this.calculateTotals();
        },
        
        calculateTotals() {
            this.subtotal = this.cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            this.shipping = this.subtotal > 100000 ? 0 : 15000;
            this.total = this.subtotal + this.shipping;
        },
        
        get isFormValid() {
            return this.form.name && 
                   this.form.email && 
                   this.form.phone && 
                   this.form.address && 
                   this.form.payment_method &&
                   !this.processing;
        },
        
        async placeOrder() {
            if (!this.isFormValid) {
                window.showToast('Silakan lengkapi semua data', 'warning');
                return;
            }
            
            this.processing = true;
            
            // Simulate order processing
            await new Promise(resolve => setTimeout(resolve, 2000));
            
            // Clear cart
            localStorage.removeItem('cart');
            
            // Show success
            window.showToast('Pesanan berhasil dibuat!', 'success');
            
            // Redirect to success page or home
            setTimeout(() => {
                window.location.href = "{{ url('/') }}";
            }, 1500);
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