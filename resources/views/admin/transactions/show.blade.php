{{-- resources/views/admin/transactions/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Transaksi')
@section('page-title', 'Detail Transaksi')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="card">
        <div class="card-header flex flex-wrap justify-between items-center gap-3">
            <div>
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Transaksi #{{ $transaction->invoice_number }}</h3>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary mt-1">Detail lengkap transaksi</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.transactions.invoice', $transaction) }}" target="_blank" class="btn btn-secondary text-sm">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Cetak Invoice
                </a>
                <a href="{{ route('admin.transactions.index') }}" class="btn btn-outline text-sm">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
        
        <div class="card-body">
            <!-- Status Banner -->
            <div class="mb-6 p-4 rounded-lg border {{ $transaction->status === 'completed' ? 'bg-success/5 border-success/20' : ($transaction->status === 'cancelled' ? 'bg-error/5 border-error/20' : 'bg-warning/5 border-warning/20') }}">
                <div class="flex items-center gap-3">
                    <span class="badge {{ $transaction->status === 'completed' ? 'badge-success' : ($transaction->status === 'cancelled' ? 'badge-error' : 'badge-warning') }} text-base py-1.5 px-4">
                        {{ $transaction->status === 'completed' ? '✅ Selesai' : ($transaction->status === 'cancelled' ? '❌ Dibatalkan' : '⏳ Pending') }}
                    </span>
                    <span class="text-sm text-text-secondary dark:text-text-dark-secondary">
                        {{ $transaction->transaction_date->format('d/m/Y H:i:s') }}
                    </span>
                </div>
            </div>
            
            <!-- Transaction Info -->
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h4 class="font-semibold text-text-primary dark:text-text-dark-primary mb-3">Informasi Transaksi</h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between py-1 border-b border-light-border dark:border-dark-border">
                            <span class="text-text-secondary dark:text-text-dark-secondary">Invoice</span>
                            <span class="font-mono text-text-primary dark:text-text-dark-primary">{{ $transaction->invoice_number }}</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-light-border dark:border-dark-border">
                            <span class="text-text-secondary dark:text-text-dark-secondary">Tanggal</span>
                            <span class="text-text-primary dark:text-text-dark-primary">{{ $transaction->transaction_date->format('d/m/Y H:i:s') }}</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-light-border dark:border-dark-border">
                            <span class="text-text-secondary dark:text-text-dark-secondary">Status</span>
                            <span class="badge {{ $transaction->status === 'completed' ? 'badge-success' : ($transaction->status === 'cancelled' ? 'badge-error' : 'badge-warning') }}">
                                {{ $transaction->status === 'completed' ? 'Selesai' : ($transaction->status === 'cancelled' ? 'Dibatalkan' : 'Pending') }}
                            </span>
                        </div>
                        @if($transaction->notes)
                        <div class="flex justify-between py-1 border-b border-light-border dark:border-dark-border">
                            <span class="text-text-secondary dark:text-text-dark-secondary">Catatan</span>
                            <span class="text-text-primary dark:text-text-dark-primary">{{ $transaction->notes }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                
                <div>
                    <h4 class="font-semibold text-text-primary dark:text-text-dark-primary mb-3">Informasi Pembayaran</h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between py-1 border-b border-light-border dark:border-dark-border">
                            <span class="text-text-secondary dark:text-text-dark-secondary">Metode Pembayaran</span>
                            <span class="text-text-primary dark:text-text-dark-primary">
                                @if($transaction->payment_method === 'cash')
                                    Tunai
                                @elseif($transaction->payment_method === 'transfer')
                                    Transfer Bank
                                @elseif($transaction->payment_method === 'qris')
                                    QRIS
                                @else
                                    {{ $transaction->payment_method }}
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-light-border dark:border-dark-border">
                            <span class="text-text-secondary dark:text-text-dark-secondary">Total</span>
                            <span class="font-bold text-accent">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-light-border dark:border-dark-border">
                            <span class="text-text-secondary dark:text-text-dark-secondary">Dibayar</span>
                            <span class="text-text-primary dark:text-text-dark-primary">Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</span>
                        </div>
                        @if($transaction->change_amount > 0)
                        <div class="flex justify-between py-1 border-b border-light-border dark:border-dark-border">
                            <span class="text-text-secondary dark:text-text-dark-secondary">Kembalian</span>
                            <span class="text-success font-medium">Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Items Table -->
            <h4 class="font-semibold text-text-primary dark:text-text-dark-primary mb-3">Item Transaksi</h4>
            <div class="overflow-x-auto border border-light-border dark:border-dark-border rounded-lg">
                <table class="w-full">
                    <thead>
                        <tr class="bg-light-surface dark:bg-dark-surface border-b border-light-border dark:border-dark-border">
                            <th class="text-left py-3 px-4 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">#</th>
                            <th class="text-left py-3 px-4 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Produk</th>
                            <th class="text-right py-3 px-4 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Qty</th>
                            <th class="text-right py-3 px-4 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Harga</th>
                            <th class="text-right py-3 px-4 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaction->items as $index => $item)
                            <tr class="border-b border-light-border dark:border-dark-border hover:bg-light-surface/50 dark:hover:bg-dark-surface/50 transition-colors">
                                <td class="py-3 px-4 text-sm text-text-secondary dark:text-text-dark-secondary">{{ $loop->iteration }}</td>
                                <td class="py-3 px-4">
                                    <p class="font-medium text-text-primary dark:text-text-dark-primary">{{ $item->product->name }}</p>
                                    <p class="text-xs text-text-secondary dark:text-text-dark-secondary">SKU: {{ $item->product->id }}</p>
                                </td>
                                <td class="py-3 px-4 text-right text-text-primary dark:text-text-dark-primary">{{ $item->quantity }}</td>
                                <td class="py-3 px-4 text-right text-text-primary dark:text-text-dark-primary">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="py-3 px-4 text-right font-medium text-accent">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-light-surface/50 dark:bg-dark-surface/50 border-t border-light-border dark:border-dark-border">
                            <td colspan="4" class="py-3 px-4 text-right font-semibold text-text-primary dark:text-text-dark-primary">Total:</td>
                            <td class="py-3 px-4 text-right font-bold text-accent text-lg">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <!-- Action Buttons -->
            @if($transaction->status === 'completed')
                <div class="mt-6 pt-4 border-t border-light-border dark:border-dark-border flex flex-wrap gap-3">
                    <button onclick="cancelTransaction({{ $transaction->id }})" class="btn btn-danger">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Batalkan Transaksi
                    </button>
                    <a href="{{ route('admin.transactions.invoice', $transaction) }}" target="_blank" class="btn btn-secondary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Cetak Ulang Invoice
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
async function cancelTransaction(id) {
    if (!confirm('Batalkan transaksi ini? Stok akan dikembalikan.')) return;
    
    try {
        const response = await axios.post(`/api/v1/transactions/${id}/cancel`);
        if (response.data.success) {
            window.showToast('Transaksi berhasil dibatalkan', 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        }
    } catch (error) {
        window.showToast(error.response?.data?.message || 'Gagal membatalkan transaksi', 'error');
    }
}
</script>
@endpush
@endsection