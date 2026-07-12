<?php
// app/Http/Controllers/Admin/TransactionController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\TransactionItem;
use App\Models\InventoryLog;
use App\Services\SaleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    protected $saleService;
    
    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }
    
    /**
     * Display list of transactions
     */
    public function index(Request $request)
    {
        $storeId = auth()->user()->store_id;
        
        $query = Transaction::where('store_id', $storeId);
        
        // Apply filters
        if ($request->filled('search')) {
            $query->where('invoice_number', 'like', '%' . $request->search . '%');
        }
        
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
        
        $transactions = $query->with('items.product')
            ->orderBy('transaction_date', 'desc')
            ->paginate($request->get('per_page', 15));
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $transactions
            ]);
        }
        
        // Summary stats
        $stats = [
            'total_revenue' => Transaction::where('store_id', $storeId)
                ->where('status', 'completed')
                ->sum('total_amount'),
            
            'total_transactions' => Transaction::where('store_id', $storeId)
                ->where('status', 'completed')
                ->count(),
            
            'average_transaction' => Transaction::where('store_id', $storeId)
                ->where('status', 'completed')
                ->avg('total_amount') ?? 0,
            
            'today_revenue' => Transaction::where('store_id', $storeId)
                ->whereDate('transaction_date', today())
                ->where('status', 'completed')
                ->sum('total_amount')
        ];
        
        return view('admin.transactions.index', compact('transactions', 'stats'));
    }
    
    /**
     * Show form to create new transaction
     */
    public function create()
    {
        $storeId = auth()->user()->store_id;
        
        $products = Product::where('store_id', $storeId)
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->orderBy('name')
            ->get();
        
        return view('admin.transactions.create', compact('products'));
    }
    
    /**
     * Process sale transaction
     */
    public function store(Request $request)
    {
        $storeId = auth()->user()->store_id;
        
        $validator = Validator::make($request->all(), [
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,transfer,qris',
            'paid_amount' => 'required|numeric|min:0'
        ]);
        
        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }
        
        $result = $this->saleService->processSale(
            $storeId,
            $request->items,
            $request->payment_method,
            $request->paid_amount
        );
        
        if ($result['success']) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Transaction completed successfully',
                    'data' => $result['transaction']
                ], 201);
            }
            
            return redirect()->route('admin.transactions.show', $result['transaction']->id)
                ->with('success', 'Transaksi berhasil dicatat');
        }
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'error' => $result['error']
            ], 422);
        }
        
        return back()->with('error', $result['error'])->withInput();
    }
    
    /**
     * Show transaction details
     */
    public function show($id)
    {
        $storeId = auth()->user()->store_id;
        
        $transaction = Transaction::where('store_id', $storeId)
            ->with(['items.product', 'items.product.category'])
            ->findOrFail($id);
        
        return view('admin.transactions.show', compact('transaction'));
    }
    
    /**
     * Generate invoice for transaction
     */
    public function invoice($id)
    {
        $storeId = auth()->user()->store_id;
        
        $transaction = Transaction::where('store_id', $storeId)
            ->with(['items.product', 'store'])
            ->findOrFail($id);
        
        return view('admin.transactions.invoice', compact('transaction'));
    }
    
    /**
     * Cancel transaction
     */
    public function cancel($id)
    {
        $storeId = auth()->user()->store_id;
        
        try {
            DB::beginTransaction();
            
            $transaction = Transaction::where('store_id', $storeId)
                ->where('status', 'completed')
                ->findOrFail($id);
            
            // Restore stock for each item
            foreach ($transaction->items as $item) {
                $product = Product::find($item->product_id);
                $oldStock = $product->stock;
                $product->stock += $item->quantity;
                $product->save();
                
                InventoryLog::create([
                    'store_id' => $storeId,
                    'product_id' => $product->id,
                    'type' => 'return',
                    'quantity' => $item->quantity,
                    'old_stock' => $oldStock,
                    'new_stock' => $product->stock,
                    'transaction_id' => $transaction->id,
                    'notes' => 'Transaction cancelled, stock restored'
                ]);
            }
            
            $transaction->status = 'cancelled';
            $transaction->save();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Transaction cancelled successfully'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 422);
        }
    }
    
    /**
     * Get transaction summary for dashboard
     */
    public function summary(Request $request)
    {
        $storeId = auth()->user()->store_id;
        
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
            default:
                $startDate = now()->startOfDay();
                $endDate = now()->endOfDay();
        }
        
        $summary = [
            'revenue' => Transaction::where('store_id', $storeId)
                ->whereBetween('transaction_date', [$startDate, $endDate])
                ->where('status', 'completed')
                ->sum('total_amount'),
            
            'count' => Transaction::where('store_id', $storeId)
                ->whereBetween('transaction_date', [$startDate, $endDate])
                ->where('status', 'completed')
                ->count(),
            
            'by_payment_method' => Transaction::where('store_id', $storeId)
                ->whereBetween('transaction_date', [$startDate, $endDate])
                ->where('status', 'completed')
                ->select('payment_method', DB::raw('SUM(total_amount) as total'), DB::raw('COUNT(*) as count'))
                ->groupBy('payment_method')
                ->get()
        ];
        
        return response()->json([
            'success' => true,
            'data' => $summary,
            'period' => $period
        ]);
    }
}