{{-- resources/views/admin/transactions/partials/payment-modal.blade.php --}}
<div x-show="showPaymentModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="card w-full max-w-md mx-4" @click.stop>
        <div class="card-header">
            <h3 class="text-xl font-bold">Proses Pembayaran</h3>
        </div>
        <div class="card-body">
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Total Belanja</label>
                <p class="text-2xl font-bold text-accent" x-text="formatRupiah(totalAmount)"></p>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Metode Pembayaran</label>
                <div class="grid grid-cols-3 gap-2">
                    <button type="button" @click="paymentMethod = 'cash'" 
                            :class="paymentMethod === 'cash' ? 'btn-primary' : 'btn-outline'"
                            class="py-2">
                        Tunai
                    </button>
                    <button type="button" @click="paymentMethod = 'transfer'" 
                            :class="paymentMethod === 'transfer' ? 'btn-primary' : 'btn-outline'"
                            class="py-2">
                        Transfer
                    </button>
                    <button type="button" @click="paymentMethod = 'qris'" 
                            :class="paymentMethod === 'qris' ? 'btn-primary' : 'btn-outline'"
                            class="py-2">
                        QRIS
                    </button>
                </div>
            </div>
            
            <div x-show="paymentMethod === 'cash'" class="mb-4">
                <label class="block text-sm font-medium mb-2">Jumlah Dibayar</label>
                <input type="number" x-model="paidAmount" @input="calculateChange" 
                       class="input" placeholder="Masukkan jumlah uang">
                <p x-show="changeAmount >= 0" class="text-sm mt-2">
                    Kembalian: <span class="font-semibold text-success" x-text="formatRupiah(changeAmount)"></span>
                </p>
                <p x-show="changeAmount < 0" class="text-sm text-error mt-2">
                    Kurang: <span class="font-semibold" x-text="formatRupiah(Math.abs(changeAmount))"></span>
                </p>
            </div>
            
            <div x-show="paymentMethod === 'transfer'" class="mb-4">
                <div class="alert alert-info text-sm">
                    Silakan transfer ke rekening:
                    <p class="font-mono mt-2">BCA: 1234567890 a.n CoreSite</p>
                    <p class="font-mono">Mandiri: 0987654321 a.n CoreSite</p>
                </div>
            </div>
            
            <div x-show="paymentMethod === 'qris'" class="mb-4 text-center">
                <div class="bg-white p-4 rounded-lg inline-block">
                    <svg class="w-48 h-48 mx-auto" viewBox="0 0 100 100">
                        <rect width="100" height="100" fill="black"/>
                        <rect x="10" y="10" width="80" height="80" fill="white"/>
                        <!-- QR Code simulation -->
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
                <p class="text-sm text-text-secondary mt-2">Scan QRIS untuk membayar</p>
            </div>
        </div>
        <div class="card-footer flex justify-end gap-3">
            <button @click="showPaymentModal = false" class="btn btn-secondary">Batal</button>
            <button @click="processPayment" 
                    :disabled="paymentMethod === 'cash' && (paidAmount < totalAmount || !paidAmount)"
                    class="btn btn-primary">
                Proses Pembayaran
            </button>
        </div>
    </div>
</div>