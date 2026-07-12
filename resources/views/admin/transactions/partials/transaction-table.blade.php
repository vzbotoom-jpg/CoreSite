{{-- resources/views/admin/transactions/partials/transaction-table.blade.php --}}
<div class="card">
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
                <template x-for="transaction in transactions" :key="transaction.id">
                    <tr class="border-b border-light-border dark:border-dark-border hover:bg-light-surface dark:hover:bg-dark-surface/50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-mono text-sm text-text-primary dark:text-text-dark-primary" x-text="transaction.invoice_number"></span>
                        </td>
                        <td class="px-6 py-4 text-sm text-text-secondary dark:text-text-dark-secondary" x-text="formatDate(transaction.transaction_date)"></td>
                        <td class="px-6 py-4">
                            <span class="font-semibold text-text-primary dark:text-text-dark-primary" x-text="formatRupiah(transaction.total_amount)"></span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="badge badge-primary" x-text="getPaymentMethodText(transaction.payment_method)"></span>
                        </td>
                        <td class="px-6 py-4">
                            <span :class="getStatusBadge(transaction.status)" class="badge" x-text="getStatusText(transaction.status)"></span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <button @click="viewDetail(transaction)" class="btn btn-ghost btn-sm" title="Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                                <a :href="`/admin/transactions/${transaction.id}/invoice`" target="_blank" 
                                   class="btn btn-ghost btn-sm" title="Invoice">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                </template>
                <tr x-show="transactions.length === 0 && !loading">
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
                Menampilkan <span x-text="from"></span> - <span x-text="to"></span> dari <span x-text="total"></span> transaksi
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