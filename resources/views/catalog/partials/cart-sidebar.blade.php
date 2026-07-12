{{-- resources/views/catalog/partials/cart-sidebar.blade.php --}}
<div x-show="cartOpen" x-cloak class="fixed inset-0 z-50">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/50" @click="cartOpen = false"></div>
    
    <!-- Sidebar -->
    <div class="absolute right-0 top-0 h-full w-full max-w-md bg-light-bg dark:bg-dark-bg shadow-xl">
        <div class="flex flex-col h-full">
            <!-- Header -->
            <div class="p-4 border-b flex justify-between items-center">
                <h2 class="text-xl font-bold">Keranjang Belanja</h2>
                <button @click="cartOpen = false" class="text-text-secondary hover:text-text-primary">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Cart Items -->
            <div class="flex-1 overflow-y-auto p-4 space-y-4">
                <template x-for="(item, index) in cart" :key="item.product_id">
                    <div class="flex gap-3">
                        <div class="w-20 h-20 bg-light-surface rounded-lg flex items-center justify-center">
                            <svg class="w-8 h-8 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-medium" x-text="item.name"></h4>
                            <p class="text-accent font-semibold" x-text="formatRupiah(item.price)"></p>
                            <div class="flex items-center gap-2 mt-1">
                                <button @click="updateQuantity(index, -1)" class="w-6 h-6 border rounded">-</button>
                                <span x-text="item.quantity" class="w-8 text-center"></span>
                                <button @click="updateQuantity(index, 1)" class="w-6 h-6 border rounded">+</button>
                                <button @click="removeFromCart(index)" class="ml-2 text-error">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
                <div x-show="cart.length === 0" class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-text-secondary/50 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6M17 13l1.5 6M9 21h6"/>
                    </svg>
                    <p class="text-text-secondary">Keranjang kosong</p>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="border-t p-4 space-y-3">
                <div class="flex justify-between font-semibold">
                    <span>Total</span>
                    <span x-text="formatRupiah(cartTotal)"></span>
                </div>
                <button @click="checkout" class="btn btn-primary w-full">
                    Checkout via WhatsApp
                </button>
            </div>
        </div>
    </div>
</div>