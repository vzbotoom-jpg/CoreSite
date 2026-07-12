{{-- resources/views/admin/transactions/partials/transaction-details.blade.php --}}
<div class="space-y-6">
    <!-- Transaction Header -->
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="text-xs text-text-secondary dark:text-text-dark-secondary">Invoice Number</label>
            <p class="font-mono font-semibold text-text-primary dark:text-text-dark-primary" x-text="selectedTransaction?.invoice_number"></p>
        </div>
        <div>
            <label class="text-xs text-text-secondary dark:text-text-dark-secondary">Tanggal Transaksi</label>
            <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="formatDate(selectedTransaction?.transaction_date)"></p>
        </div>
        <div>
            <label class="text-xs text-text-secondary dark:text-text-dark-secondary">Status</label>
            <div>
                <span :class="getStatusBadge(selectedTransaction?.status)" class="badge" x-text="getStatusText(selectedTransaction?.status)"></span>
            </div>
        </div>
        <div>
            <label class="text-xs text-text-secondary dark:text-text-dark-secondary">Metode Pembayaran</label>
            <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="getPaymentMethodText(selectedTransaction?.payment_method)"></p>
        </div>
    </div>
    
    <!-- Items Table -->
    <div>
        <h4 class="font-semibold text-text-primary dark:text-text-dark-primary mb-3">Item Transaksi</h4>
        <div class="overflow-x-auto border border-light-border dark:border-dark-border rounded-lg">
            <table class="w-full">
                <thead>
                    <tr class="bg-light-surface dark:bg-dark-surface border-b border-light-border dark:border-dark-border">
                        <th class="text-left py-2 px-4 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Produk</th>
                        <th class="text-right py-2 px-4 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Qty</th>
                        <th class="text-right py-2 px-4 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Harga</th>
                        <th class="text-right py-2 px-4 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="item in selectedTransaction?.items" :key="item.id">
                        <tr class="border-b border-light-border dark:border-dark-border hover:bg-light-surface/50 dark:hover:bg-dark-surface/50 transition-colors">
                            <td class="py-2 px-4">
                                <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="item.product?.name"></p>
                            </td>
                            <td class="text-right py-2 px-4 text-text-primary dark:text-text-dark-primary" x-text="item.quantity"></td>
                            <td class="text-right py-2 px-4 text-text-primary dark:text-text-dark-primary" x-text="formatRupiah(item.price)"></td>
                            <td class="text-right py-2 px-4 font-medium text-accent" x-text="formatRupiah(item.subtotal)"></td>
                        </tr>
                    </template>
                </tbody>
                <tfoot>
                    <tr class="bg-light-surface/50 dark:bg-dark-surface/50 border-t border-light-border dark:border-dark-border">
                        <td colspan="3" class="pt-3 px-4 text-right font-semibold text-text-primary dark:text-text-dark-primary">Total:</td>
                        <td class="pt-3 px-4 text-right font-bold text-accent text-lg" x-text="formatRupiah(selectedTransaction?.total_amount)"></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="pt-1 px-4 text-right text-sm text-text-secondary dark:text-text-dark-secondary">Dibayar:</td>
                        <td class="pt-1 px-4 text-right text-sm text-text-primary dark:text-text-dark-primary" x-text="formatRupiah(selectedTransaction?.paid_amount)"></td>
                    </tr>
                    <tr x-show="selectedTransaction?.change_amount > 0">
                        <td colspan="3" class="pt-1 px-4 text-right text-sm text-text-secondary dark:text-text-dark-secondary">Kembalian:</td>
                        <td class="pt-1 px-4 text-right text-sm text-success" x-text="formatRupiah(selectedTransaction?.change_amount)"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    
    <!-- Notes -->
    <div x-show="selectedTransaction?.notes">
        <label class="text-xs text-text-secondary dark:text-text-dark-secondary">Catatan</label>
        <p class="text-sm text-text-primary dark:text-text-dark-primary mt-1" x-text="selectedTransaction?.notes"></p>
    </div>
</div>