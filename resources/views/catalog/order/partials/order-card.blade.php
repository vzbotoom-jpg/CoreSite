{{-- resources/views/catalog/order/partials/order-card.blade.php --}}
@props(['order'])

<div class="card hover:shadow-xl transition-all duration-300 group" x-data="{ expanded: false }">
    <div class="card-body p-6">
        <!-- Order Header -->
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center"
                     :class="{
                         'bg-accent/10': '{{ $order['status'] }}' === 'completed',
                         'bg-warning/10': '{{ $order['status'] }}' === 'pending' || '{{ $order['status'] }}' === 'processing',
                         'bg-error/10': '{{ $order['status'] }}' === 'cancelled',
                         'bg-info/10': '{{ $order['status'] }}' === 'shipped'
                     }">
                    <span class="text-2xl">
                        @if($order['status'] === 'completed') ✅
                        @elseif($order['status'] === 'pending') ⏳
                        @elseif($order['status'] === 'processing') 📦
                        @elseif($order['status'] === 'shipped') 🚚
                        @elseif($order['status'] === 'cancelled') ❌
                        @else 📌
                        @endif
                    </span>
                </div>
                <div>
                    <p class="font-semibold text-text-primary dark:text-text-dark-primary">
                        <span class="font-mono">{{ $order['invoice_number'] }}</span>
                    </p>
                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary">
                        {{ \Carbon\Carbon::parse($order['created_at'])->format('d M Y, H:i') }}
                    </p>
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <span class="badge
                    @if($order['status'] === 'completed') badge-success
                    @elseif($order['status'] === 'pending' || $order['status'] === 'processing') badge-warning
                    @elseif($order['status'] === 'shipped') badge-primary
                    @elseif($order['status'] === 'cancelled') badge-error
                    @else badge-secondary
                    @endif">
                    @if($order['status'] === 'completed') ✅ Selesai
                    @elseif($order['status'] === 'pending') ⏳ Menunggu
                    @elseif($order['status'] === 'processing') 📦 Diproses
                    @elseif($order['status'] === 'shipped') 🚚 Dikirim
                    @elseif($order['status'] === 'cancelled') ❌ Dibatalkan
                    @else {{ $order['status'] }}
                    @endif
                </span>
                <span class="font-bold text-accent text-lg">
                    Rp {{ number_format($order['total'], 0, ',', '.') }}
                </span>
                <span class="text-sm text-text-secondary">{{ count($order['items']) }} item</span>
            </div>
        </div>

        <!-- Order Items Preview -->
        <div class="mt-4 pt-4 border-t border-light-border/40 dark:border-dark-border/40">
            <div class="flex flex-wrap items-center gap-4">
                <div class="flex -space-x-2">
                    @foreach(array_slice($order['items'], 0, 3) as $item)
                        <div class="w-10 h-10 bg-light-surface dark:bg-dark-surface rounded-lg border-2 border-light-bg dark:border-dark-bg flex items-center justify-center text-xs font-medium text-text-secondary">
                            {{ strtoupper(substr($item['name'], 0, 1)) }}
                        </div>
                    @endforeach
                    @if(count($order['items']) > 3)
                        <div class="w-10 h-10 bg-light-surface dark:bg-dark-surface rounded-lg border-2 border-light-bg dark:border-dark-bg flex items-center justify-center text-xs font-medium text-text-secondary">
                            +{{ count($order['items']) - 3 }}
                        </div>
                    @endif
                </div>
                <div class="flex-1">
                    <p class="text-sm text-text-secondary">
                        {{ implode(', ', array_slice(array_column($order['items'], 'name'), 0, 3)) }}
                        @if(count($order['items']) > 3)
                            <span class="text-text-secondary/60">... dan {{ count($order['items']) - 3 }} lainnya</span>
                        @endif
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('catalog.order.show', $order['id']) }}" class="btn btn-ghost btn-sm text-accent hover:text-accent-hover">
                        Detail →
                    </a>
                    @if($order['status'] === 'pending')
                        <button class="btn btn-ghost btn-sm text-error hover:text-error/80" 
                                onclick="if(confirm('Batalkan pesanan ini?')) { window.showToast('Pesanan dibatalkan', 'success') }">
                            Batalkan
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Expandable Details -->
        <button @click="expanded = !expanded" class="mt-3 pt-3 border-t border-light-border/40 dark:border-dark-border/40 text-sm text-text-secondary hover:text-accent transition flex items-center gap-1 w-full justify-center">
            <span x-text="expanded ? 'Sembunyikan detail' : 'Lihat detail lengkap'"></span>
            <svg class="w-4 h-4 transition-transform" :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
        
        <div x-show="expanded" x-collapse class="mt-4 space-y-4">
            <!-- Order Items Detail -->
            <div class="space-y-2">
                <h4 class="font-medium text-text-primary dark:text-text-dark-primary">Item Pesanan</h4>
                @foreach($order['items'] as $item)
                    <div class="flex items-center gap-4 p-3 bg-light-surface/50 dark:bg-dark-surface/50 rounded-lg">
                        <div class="w-12 h-12 bg-light-surface dark:bg-dark-surface rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-text-primary dark:text-text-dark-primary">{{ $item['name'] }}</p>
                            <p class="text-sm text-text-secondary">Qty: {{ $item['quantity'] }}</p>
                        </div>
                        <p class="font-medium text-accent">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>
            
            <!-- Shipping Info -->
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <h4 class="font-medium text-text-primary dark:text-text-dark-primary mb-2">Alamat Pengiriman</h4>
                    <div class="p-3 bg-light-surface/50 dark:bg-dark-surface/50 rounded-lg">
                        <p class="font-medium">{{ $order['shipping']['name'] }}</p>
                        <p class="text-sm text-text-secondary">{{ $order['shipping']['address'] }}</p>
                        <p class="text-sm text-text-secondary">{{ $order['shipping']['phone'] }}</p>
                    </div>
                </div>
                <div>
                    <h4 class="font-medium text-text-primary dark:text-text-dark-primary mb-2">Metode Pembayaran</h4>
                    <div class="p-3 bg-light-surface/50 dark:bg-dark-surface/50 rounded-lg">
                        <p class="font-medium">{{ $order['payment_method'] }}</p>
                        <p class="text-sm text-text-secondary">{{ $order['payment_status'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>