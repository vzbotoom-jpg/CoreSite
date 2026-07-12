<?php
// app/Http/Controllers/Api/V1/TransactionApiController.php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Services\SaleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionApiController extends Controller
{
    protected $saleService;
    
    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }
    
    /**
     * Get all transactions
     */
    public function index(Request $request)
    {
        $storeId = $request->user()->store_id;
        
        $query = Transaction::where('store_id', $storeId);
        
        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('transaction_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('transaction_date', '<=', $request->date_to);
        }
        
        if ($request->filled('search')) {
            $query->where('invoice_number', 'like', '%' . $request->search . '%');
        }
        
        $transactions = $query->with('items.product')
            ->orderBy('transaction_date', 'desc')
            ->paginate($request->get('per_page', 15));
        
        return response()->json([
            'success' => true,
            'data' => $transactions
        ]);
    }
    
    /**
     * Get single transaction
     */
    public function show(Request $request, $id)
    {
        $storeId = $request->user()->store_id;
        
        $transaction = Transaction::where('store_id', $storeId)
            ->with(['items.product', 'items.product.category'])
            ->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $transaction
        ]);
    }
    
    /**
     * Create new transaction (sale)
     */
    public function store(Request $request)
    {
        $storeId = $request->user()->store_id;
        
        $validator = Validator::make($request->all(), [
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,transfer,qris',
            'paid_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        $result = $this->saleService->processSale(
            $storeId,
            $request->items,
            $request->payment_method,
            $request->paid_amount,
            $request->notes
        );
        
        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Transaction completed successfully',
                'data' => $result['transaction']
            ], 201);
        }
        
        return response()->json([
            'success' => false,
            'message' => $result['error']
        ], 422);
    }
    
    /**
     * Cancel transaction
     */
    public function cancel(Request $request, $id)
    {
        $storeId = $request->user()->store_id;
        
        $transaction = Transaction::where('store_id', $storeId)
            ->where('status', 'completed')
            ->findOrFail($id);
        
        $result = $this->saleService->cancelSale($transaction->id);
        
        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Transaction cancelled successfully',
                'data' => $result['transaction']
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => $result['error']
        ], 422);
    }
    
    /**
     * Get transaction summary
     */
    public function summary(Request $request)
    {
        $storeId = $request->user()->store_id;
        
        $period = $request->get('period', 'today');
        
        switch ($period) {
            case 'today':
                $startDate = now()->startOfDay();
                $endDate = now()->endOfDay();
                break;
            case 'week':
                $startDate = now()->startOfWeek();
                $endDate = now()->endOfWeek();
                break;
            case 'month':
                $startDate = now()->startOfMonth();
                $endDate = now()->endOfMonth();
                break;
            case 'year':
                $startDate = now()->startOfYear();
                $endDate = now()->endOfYear();
                break;
            default:
                $startDate = now()->startOfDay();
                $endDate = now()->endOfDay();
        }
        
        $stats = [
            'total_revenue' => Transaction::where('store_id', $storeId)
                ->whereBetween('transaction_date', [$startDate, $endDate])
                ->where('status', 'completed')
                ->sum('total_amount'),
            
            'total_transactions' => Transaction::where('store_id', $storeId)
                ->whereBetween('transaction_date', [$startDate, $endDate])
                ->where('status', 'completed')
                ->count(),
            
            'average_transaction' => Transaction::where('store_id', $storeId)
                ->whereBetween('transaction_date', [$startDate, $endDate])
                ->where('status', 'completed')
                ->avg('total_amount') ?? 0,
            
            'by_payment_method' => Transaction::where('store_id', $storeId)
                ->whereBetween('transaction_date', [$startDate, $endDate])
                ->where('status', 'completed')
                ->select('payment_method')
                ->selectRaw('SUM(total_amount) as total')
                ->selectRaw('COUNT(*) as count')
                ->groupBy('payment_method')
                ->get(),
            
            'by_hour' => Transaction::where('store_id', $storeId)
                ->whereBetween('transaction_date', [$startDate, $endDate])
                ->where('status', 'completed')
                ->selectRaw('HOUR(transaction_date) as hour')
                ->selectRaw('COUNT(*) as count')
                ->selectRaw('SUM(total_amount) as total')
                ->groupByRaw('HOUR(transaction_date)')
                ->orderBy('hour')
                ->get()
        ];
        
        return response()->json([
            'success' => true,
            'data' => $stats,
            'period' => $period,
            'range' => [
                'start' => $startDate->toISOString(),
                'end' => $endDate->toISOString()
            ]
        ]);
    }
    
    /**
     * Generate invoice for transaction
     */
    public function invoice(Request $request, $id)
    {
        $storeId = $request->user()->store_id;
        
        $transaction = Transaction::where('store_id', $storeId)
            ->with(['items.product', 'store'])
            ->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => [
                'transaction' => $transaction,
                'invoice_url' => route('admin.transactions.invoice', $transaction->id),
                'download_url' => route('api.v1.transactions.download-invoice', $transaction->id)
            ]
        ]);
    }
}