<?php
// app/Services/SaleService.php

namespace App\Services;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\InventoryLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class SaleService
{
    /**
     * Process a sale transaction.
     */
    public function processSale(int $storeId, array $items, string $paymentMethod, float $paidAmount, ?string $notes = null): array
    {
        DB::beginTransaction();
        
        try {
            $totalAmount = 0;
            $soldItems = [];
            
            // Process each item
            foreach ($items as $item) {
                $product = Product::where('id', $item['product_id'])
                    ->where('store_id', $storeId)
                    ->lockForUpdate()
                    ->first();
                
                if (!$product) {
                    throw new Exception("Product not found: {$item['product_id']}");
                }
                
                if ($product->stock < $item['quantity']) {
                    throw new Exception("Insufficient stock for product: {$product->name}. Available: {$product->stock}");
                }
                
                // Record old stock
                $oldStock = $product->stock;
                
                // Reduce stock
                $product->stock -= $item['quantity'];
                $product->save();
                
                $subtotal = $product->price * $item['quantity'];
                $totalAmount += $subtotal;
                
                $soldItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $subtotal,
                    'old_stock' => $oldStock
                ];
            }
            
            // Validate payment
            if ($paidAmount < $totalAmount) {
                throw new Exception("Insufficient payment. Total: {$totalAmount}, Paid: {$paidAmount}");
            }
            
            // Create transaction
            $transaction = Transaction::create([
                'store_id' => $storeId,
                'invoice_number' => $this->generateInvoiceNumber($storeId),
                'total_amount' => $totalAmount,
                'paid_amount' => $paidAmount,
                'change_amount' => $paidAmount - $totalAmount,
                'payment_method' => $paymentMethod,
                'status' => 'completed',
                'notes' => $notes,
                'transaction_date' => now()
            ]);
            
            // Create transaction items and inventory logs
            foreach ($soldItems as $soldItem) {
                // Create transaction item
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $soldItem['product']->id,
                    'quantity' => $soldItem['quantity'],
                    'price' => $soldItem['price'],
                    'subtotal' => $soldItem['subtotal']
                ]);
                
                // Create inventory log
                InventoryLog::create([
                    'store_id' => $storeId,
                    'product_id' => $soldItem['product']->id,
                    'type' => 'sale',
                    'quantity' => $soldItem['quantity'],
                    'old_stock' => $soldItem['old_stock'],
                    'new_stock' => $soldItem['product']->stock,
                    'transaction_id' => $transaction->id,
                    'notes' => "Sale transaction #{$transaction->invoice_number}"
                ]);
            }
            
            DB::commit();
            
            return [
                'success' => true,
                'transaction' => $transaction->load('items.product'),
                'message' => 'Sale completed successfully'
            ];
            
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Sale processing failed: ' . $e->getMessage(), [
                'store_id' => $storeId,
                'items' => $items,
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Cancel a sale transaction.
     */
    public function cancelSale(int $transactionId): array
    {
        DB::beginTransaction();
        
        try {
            $transaction = Transaction::with('items.product')->findOrFail($transactionId);
            
            if ($transaction->status !== 'completed') {
                throw new Exception('Only completed transactions can be cancelled');
            }
            
            // Restore stock for each item
            foreach ($transaction->items as $item) {
                $product = $item->product;
                $oldStock = $product->stock;
                $product->stock += $item->quantity;
                $product->save();
                
                InventoryLog::create([
                    'store_id' => $transaction->store_id,
                    'product_id' => $product->id,
                    'type' => 'return',
                    'quantity' => $item->quantity,
                    'old_stock' => $oldStock,
                    'new_stock' => $product->stock,
                    'transaction_id' => $transaction->id,
                    'notes' => "Transaction cancelled, stock restored from #{$transaction->invoice_number}"
                ]);
            }
            
            // Update transaction status
            $transaction->status = 'cancelled';
            $transaction->save();
            
            DB::commit();
            
            return [
                'success' => true,
                'transaction' => $transaction->fresh(),
                'message' => 'Transaction cancelled successfully'
            ];
            
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Sale cancellation failed: ' . $e->getMessage(), [
                'transaction_id' => $transactionId,
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Generate unique invoice number.
     */
    private function generateInvoiceNumber(int $storeId): string
    {
        $store = \App\Models\Store::find($storeId);
        $prefix = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $store->name), 0, 3));
        $date = now()->format('Ymd');
        $random = strtoupper(substr(uniqid(), -6));
        
        $invoiceNumber = "INV/{$prefix}/{$date}/{$random}";
        
        // Ensure uniqueness
        while (Transaction::where('invoice_number', $invoiceNumber)->exists()) {
            $random = strtoupper(substr(uniqid(), -6));
            $invoiceNumber = "INV/{$prefix}/{$date}/{$random}";
        }
        
        return $invoiceNumber;
    }

    /**
     * Get daily sales summary.
     */
    public function getDailySummary(int $storeId, ?string $date = null): array
    {
        $date = $date ?? now()->format('Y-m-d');
        
        $transactions = Transaction::where('store_id', $storeId)
            ->whereDate('transaction_date', $date)
            ->where('status', 'completed')
            ->get();
        
        return [
            'date' => $date,
            'total_revenue' => $transactions->sum('total_amount'),
            'total_transactions' => $transactions->count(),
            'average_transaction' => $transactions->avg('total_amount') ?? 0,
            'by_payment_method' => $transactions->groupBy('payment_method')->map(function ($group) {
                return [
                    'count' => $group->count(),
                    'total' => $group->sum('total_amount')
                ];
            })
        ];
    }
}