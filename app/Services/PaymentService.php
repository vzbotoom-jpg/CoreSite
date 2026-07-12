<?php
// app/Services/PaymentService.php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    /**
     * Process payment for transaction.
     */
    public function processPayment(Transaction $transaction, string $paymentMethod, array $paymentData = []): array
    {
        try {
            switch ($paymentMethod) {
                case 'cash':
                    return $this->processCashPayment($transaction, $paymentData);
                case 'transfer':
                    return $this->processBankTransferPayment($transaction, $paymentData);
                case 'qris':
                    return $this->processQRISPayment($transaction, $paymentData);
                default:
                    throw new \Exception('Unsupported payment method');
            }
        } catch (\Exception $e) {
            Log::error('Payment processing failed', [
                'transaction_id' => $transaction->id,
                'method' => $paymentMethod,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Process cash payment.
     */
    private function processCashPayment(Transaction $transaction, array $data): array
    {
        $paidAmount = $data['paid_amount'] ?? $transaction->total_amount;
        
        if ($paidAmount < $transaction->total_amount) {
            return [
                'success' => false,
                'error' => 'Insufficient payment amount'
            ];
        }
        
        $transaction->update([
            'paid_amount' => $paidAmount,
            'change_amount' => $paidAmount - $transaction->total_amount,
            'payment_method' => 'cash',
            'status' => 'completed'
        ]);
        
        return [
            'success' => true,
            'message' => 'Cash payment processed successfully',
            'change_amount' => $transaction->change_amount
        ];
    }

    /**
     * Process bank transfer payment.
     */
    private function processBankTransferPayment(Transaction $transaction, array $data): array
    {
        // This would integrate with payment gateway API
        // Example for Midtrans, Xendit, etc.
        
        $paymentGateway = config('payment.default_gateway', 'midtrans');
        
        // Simulate API call
        $paymentResult = $this->callPaymentGateway($paymentGateway, $transaction, $data);
        
        if ($paymentResult['success']) {
            $transaction->update([
                'payment_method' => 'transfer',
                'payment_reference' => $paymentResult['reference_id'],
                'status' => 'pending' // Will be updated by webhook
            ]);
        }
        
        return $paymentResult;
    }

    /**
     * Process QRIS payment.
     */
    private function processQRISPayment(Transaction $transaction, array $data): array
    {
        // Generate QRIS code
        $qrisData = $this->generateQRIS($transaction);
        
        $transaction->update([
            'payment_method' => 'qris',
            'payment_reference' => $qrisData['reference_id'],
            'status' => 'pending'
        ]);
        
        return [
            'success' => true,
            'message' => 'QRIS payment initiated',
            'qris_code' => $qrisData['qr_code'],
            'qris_string' => $qrisData['qr_string']
        ];
    }

    /**
     * Call payment gateway API.
     */
    private function callPaymentGateway(string $gateway, Transaction $transaction, array $data): array
    {
        // This is a mock implementation
        // Replace with actual API integration
        
        Log::info('Calling payment gateway', [
            'gateway' => $gateway,
            'transaction_id' => $transaction->id,
            'amount' => $transaction->total_amount
        ]);
        
        // Simulate successful payment
        return [
            'success' => true,
            'reference_id' => 'REF_' . uniqid(),
            'message' => 'Payment processed via ' . $gateway
        ];
    }

    /**
     * Generate QRIS code.
     */
    private function generateQRIS(Transaction $transaction): array
    {
        // This would integrate with QRIS provider API
        // For now, return mock data
        
        return [
            'reference_id' => 'QRIS_' . $transaction->id . '_' . time(),
            'qr_code' => 'https://api.qris.com/generate/' . $transaction->id,
            'qr_string' => 'QRIS|' . $transaction->id . '|' . $transaction->total_amount
        ];
    }

    /**
     * Handle payment webhook.
     */
    public function handleWebhook(string $provider, array $payload): array
    {
        Log::info('Payment webhook received', [
            'provider' => $provider,
            'payload' => $payload
        ]);
        
        // Find transaction by reference
        $referenceId = $payload['reference_id'] ?? null;
        
        if (!$referenceId) {
            return ['success' => false, 'error' => 'No reference ID found'];
        }
        
        $transaction = Transaction::where('payment_reference', $referenceId)->first();
        
        if (!$transaction) {
            return ['success' => false, 'error' => 'Transaction not found'];
        }
        
        // Update transaction status based on webhook data
        $status = $payload['status'] ?? null;
        
        if ($status === 'success' || $status === 'settlement') {
            $transaction->update([
                'status' => 'completed',
                'paid_amount' => $transaction->total_amount,
                'change_amount' => 0
            ]);
        } elseif ($status === 'failed' || $status === 'expired') {
            $transaction->update(['status' => 'cancelled']);
        }
        
        return [
            'success' => true,
            'transaction_id' => $transaction->id,
            'status' => $transaction->status
        ];
    }

    /**
     * Generate payment invoice.
     */
    public function generateInvoice(Transaction $transaction): array
    {
        $store = $transaction->store;
        
        return [
            'invoice_number' => $transaction->invoice_number,
            'date' => $transaction->transaction_date->format('d/m/Y H:i'),
            'store' => [
                'name' => $store->name,
                'email' => $store->email,
                'phone' => $store->phone
            ],
            'items' => $transaction->items->map(function ($item) {
                return [
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->subtotal
                ];
            }),
            'subtotal' => $transaction->total_amount,
            'paid_amount' => $transaction->paid_amount,
            'change_amount' => $transaction->change_amount,
            'payment_method' => $transaction->payment_method_label,
            'status' => $transaction->status_label
        ];
    }
}