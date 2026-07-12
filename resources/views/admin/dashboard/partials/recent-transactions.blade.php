{{-- resources/views/admin/dashboard/partials/recent-transactions.blade.php --}}
<div class="card">
    <div class="card-header flex flex-wrap justify-between items-center gap-3">
        <div>
            <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Transaksi Terbaru</h3>
            <p class="text-sm text-text-secondary dark:text-text-dark-secondary">10 transaksi terakhir</p>
        </div>
        <a href="{{ route('admin.transactions.index') }}" class="text-accent hover:text-accent-hover text-sm flex items-center gap-1 transition-colors">
            Lihat Semua
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-light-border dark:border-dark-border">
                    <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Invoice</th>
                    <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Tanggal</th>
                    <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Total</th>
                    <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Metode</th>
                    <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Status</th>
                    <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse(($recentTransactions ?? collect()) as $transaction)
                    @php
                        // Skip jika data bukan objek yang valid
                        if (!is_object($transaction) || !method_exists($transaction, 'getAttributes')) {
                            continue;
                        }
                    @endphp
                    <tr class="border-b border-light-border dark:border-dark-border hover:bg-light-surface dark:hover:bg-dark-surface/50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-mono text-sm text-text-primary dark:text-text-dark-primary">
                                {{ $transaction->invoice_number ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-text-secondary dark:text-text-dark-secondary">
                            {{ isset($transaction->transaction_date) && $transaction->transaction_date instanceof \Carbon\Carbon ? $transaction->transaction_date->format('d/m/Y H:i') : '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-semibold text-text-primary dark:text-text-dark-primary">
                                Rp {{ number_format($transaction->total_amount ?? 0, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $paymentMethod = $transaction->payment_method ?? '';
                                $methodLabels = ['cash' => 'Tunai', 'transfer' => 'Transfer', 'qris' => 'QRIS'];
                                $methodColors = ['cash' => 'badge-primary', 'transfer' => 'badge-info', 'qris' => 'badge-success'];
                            @endphp
                            <span class="badge {{ $methodColors[$paymentMethod] ?? 'badge-secondary' }}">
                                {{ $methodLabels[$paymentMethod] ?? ($paymentMethod ?: '-') }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $status = $transaction->status ?? '';
                                $statusLabels = ['completed' => 'Selesai', 'pending' => 'Pending', 'cancelled' => 'Dibatalkan'];
                                $statusColors = ['completed' => 'badge-success', 'pending' => 'badge-warning', 'cancelled' => 'badge-error'];
                            @endphp
                            <span class="badge {{ $statusColors[$status] ?? 'badge-secondary' }}">
                                {{ $statusLabels[$status] ?? ($status ?: '-') }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.transactions.show', $transaction->id ?? 0) }}" 
                               class="text-accent hover:text-accent-hover text-sm transition-colors">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-text-secondary dark:text-text-dark-secondary">
                            <svg class="w-12 h-12 mx-auto mb-3 text-text-secondary/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <p>Belum ada transaksi</p>
                            <a href="{{ route('admin.transactions.create') }}" class="btn btn-ghost btn-sm">
                                Buat transaksi pertama →
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Footer with link to all transactions -->
    @php
        $transactionCount = $recentTransactions instanceof \Illuminate\Database\Eloquent\Collection ? $recentTransactions->count() : (is_countable($recentTransactions) ? count($recentTransactions) : 0);
    @endphp
    @if($transactionCount >= 10)
        <div class="card-footer">
            <a href="{{ route('admin.transactions.index') }}" class="text-accent hover:text-accent-hover text-sm flex items-center justify-center gap-1 transition-colors">
                Lihat semua transaksi
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    @endif
</div>