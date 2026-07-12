<?php
// app/Http/Controllers/Api/WebhookController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    /**
     * Handle payment gateway webhooks
     */
    public function handlePaymentWebhook(Request $request, $provider)
    {
        Log::info('Payment webhook received', [
            'provider' => $provider,
            'payload' => $request->all()
        ]);
        
        try {
            switch ($provider) {
                case 'midtrans':
                    return $this->handleMidtransWebhook($request);
                case 'xendit':
                    return $this->handleXenditWebhook($request);
                case 'tripay':
                    return $this->handleTripayWebhook($request);
                default:
                    return response()->json(['error' => 'Unknown provider'], 400);
            }
        } catch (\Exception $e) {
            Log::error('Webhook processing failed', [
                'provider' => $provider,
                'error' => $e->getMessage()
            ]);
            
            return response()->json(['error' => 'Webhook processing failed'], 500);
        }
    }
    
    /**
     * Handle Midtrans webhook
     */
    private function handleMidtransWebhook(Request $request)
    {
        $payload = $request->all();
        
        // Verify signature (implement based on Midtrans docs)
        
        $orderId = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        
        if ($orderId && $transactionStatus) {
            // Update transaction status in database
            // Transaction::where('invoice_number', $orderId)->update(['status' => $transactionStatus]);
        }
        
        return response()->json(['status' => 'ok']);
    }
    
    /**
     * Handle Xendit webhook
     */
    private function handleXenditWebhook(Request $request)
    {
        $payload = $request->all();
        
        // Process Xendit webhook
        Log::info('Xendit webhook', ['payload' => $payload]);
        
        return response()->json(['status' => 'ok']);
    }
    
    /**
     * Handle Tripay webhook
     */
    private function handleTripayWebhook(Request $request)
    {
        $payload = $request->all();
        
        // Process Tripay webhook
        Log::info('Tripay webhook', ['payload' => $payload]);
        
        return response()->json(['status' => 'ok']);
    }
}