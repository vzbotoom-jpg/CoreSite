<?php
// app/Http/Controllers/Admin/ReportController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\InventoryLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Show reports dashboard
     */
    public function index()
    {
        return view('admin.reports.index');
    }
    
    /**
     * Generate monthly financial report
     */
    public function monthlyReport(Request $request)
    {
        $storeId = auth()->user()->store_id;
        $month = $request->get('month', now()->format('Y-m'));
        
        $startDate = date('Y-m-01 00:00:00', strtotime($month));
        $endDate = date('Y-m-t 23:59:59', strtotime($month));
        
        // Total revenue
        $totalRevenue = Transaction::where('store_id', $storeId)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->sum('total_amount');
        
        // Total products sold
        $totalProductsSold = DB::table('transaction_items')
            ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->where('transactions.store_id', $storeId)
            ->whereBetween('transactions.transaction_date', [$startDate, $endDate])
            ->where('transactions.status', 'completed')
            ->sum('transaction_items.quantity');
        
        // Total transactions
        $totalTransactions = Transaction::where('store_id', $storeId)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->count();
        
        // Average transaction value
        $averageTransaction = $totalTransactions > 0 
            ? $totalRevenue / $totalTransactions 
            : 0;
        
        // Payment method breakdown
        $paymentBreakdown = Transaction::where('store_id', $storeId)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->select('payment_method', DB::raw('SUM(total_amount) as total'), DB::raw('COUNT(*) as count'))
            ->groupBy('payment_method')
            ->get();
        
        // Daily breakdown for chart
        $dailyBreakdown = Transaction::where('store_id', $storeId)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->select(
                DB::raw('DATE(transaction_date) as date'),
                DB::raw('SUM(total_amount) as daily_revenue'),
                DB::raw('COUNT(*) as transaction_count'),
                DB::raw('SUM(paid_amount) as total_paid'),
                DB::raw('SUM(change_amount) as total_change')
            )
            ->groupBy(DB::raw('DATE(transaction_date)'))
            ->orderBy('date')
            ->get();
        
        // Weekly trend
        $weeklyTrend = $this->getWeeklyTrend($storeId, $startDate, $endDate);
        
        // Top products
        $topProducts = DB::table('transaction_items')
            ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->join('products', 'transaction_items.product_id', '=', 'products.id')
            ->where('transactions.store_id', $storeId)
            ->whereBetween('transactions.transaction_date', [$startDate, $endDate])
            ->where('transactions.status', 'completed')
            ->select(
                'products.id',
                'products.name',
                DB::raw('SUM(transaction_items.quantity) as total_sold'),
                DB::raw('SUM(transaction_items.subtotal) as total_revenue')
            )
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();
        
        // Hourly sales pattern
        $hourlySales = Transaction::where('store_id', $storeId)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->select(
                DB::raw('HOUR(transaction_date) as hour'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(total_amount) as total')
            )
            ->groupBy(DB::raw('HOUR(transaction_date)'))
            ->orderBy('hour')
            ->get();
        
        $report = [
            'period' => [
                'start' => $startDate,
                'end' => $endDate,
                'month' => $month
            ],
            'summary' => [
                'total_revenue' => $totalRevenue,
                'total_products_sold' => $totalProductsSold,
                'total_transactions' => $totalTransactions,
                'average_transaction' => $averageTransaction
            ],
            'payment_breakdown' => $paymentBreakdown,
            'daily_breakdown' => $dailyBreakdown,
            'weekly_trend' => $weeklyTrend,
            'top_products' => $topProducts,
            'hourly_sales' => $hourlySales
        ];
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $report
            ]);
        }
        
        return view('admin.reports.financial', compact('report'));
    }
    
    /**
     * Generate inventory report
     */
    public function inventoryReport(Request $request)
    {
        $storeId = auth()->user()->store_id;
        
        // Stock summary
        $stockSummary = [
            'total_products' => Product::where('store_id', $storeId)->count(),
            'total_stock' => Product::where('store_id', $storeId)->sum('stock'),
            'total_value' => Product::where('store_id', $storeId)->sum(DB::raw('price * stock')),
            'low_stock' => Product::where('store_id', $storeId)
                ->whereRaw('stock <= min_stock_alert')
                ->where('stock', '>', 0)
                ->count(),
            'out_of_stock' => Product::where('store_id', $storeId)
                ->where('stock', 0)
                ->count()
        ];
        
        // Stock movement last 30 days
        $stockMovements = InventoryLog::where('store_id', $storeId)
            ->with('product')
            ->where('created_at', '>=', now()->subDays(30))
            ->orderBy('created_at', 'desc')
            ->limit(100)
            ->get();
        
        // Products with most movements
        $activeProducts = DB::table('inventory_logs')
            ->join('products', 'inventory_logs.product_id', '=', 'products.id')
            ->where('inventory_logs.store_id', $storeId)
            ->where('inventory_logs.created_at', '>=', now()->subDays(30))
            ->select(
                'products.id',
                'products.name',
                DB::raw('COUNT(*) as movement_count'),
                DB::raw('SUM(CASE WHEN inventory_logs.type = "sale" THEN inventory_logs.quantity ELSE 0 END) as total_sold'),
                DB::raw('SUM(CASE WHEN inventory_logs.type = "restock" THEN inventory_logs.quantity ELSE 0 END) as total_restocked')
            )
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('movement_count')
            ->limit(20)
            ->get();
        
        $report = [
            'stock_summary' => $stockSummary,
            'stock_movements' => $stockMovements,
            'active_products' => $activeProducts
        ];
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $report
            ]);
        }
        
        return view('admin.reports.inventory', compact('report'));
    }
    
    /**
     * Generate sales report
     */
    public function salesReport(Request $request)
    {
        $storeId = auth()->user()->store_id;
        
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));
        
        $sales = Transaction::where('store_id', $storeId)
            ->whereBetween('transaction_date', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('status', 'completed')
            ->with('items.product')
            ->orderBy('transaction_date', 'desc')
            ->paginate($request->get('per_page', 20));
        
        // Sales summary
        $summary = [
            'total_revenue' => Transaction::where('store_id', $storeId)
                ->whereBetween('transaction_date', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->where('status', 'completed')
                ->sum('total_amount'),
            
            'total_transactions' => Transaction::where('store_id', $storeId)
                ->whereBetween('transaction_date', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->where('status', 'completed')
                ->count(),
            
            'total_products_sold' => DB::table('transaction_items')
                ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
                ->where('transactions.store_id', $storeId)
                ->whereBetween('transactions.transaction_date', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->where('transactions.status', 'completed')
                ->sum('transaction_items.quantity')
        ];
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'sales' => $sales,
                    'summary' => $summary
                ]
            ]);
        }
        
        return view('admin.reports.sales', compact('sales', 'summary', 'startDate', 'endDate'));
    }
    
    /**
     * Get weekly trend data
     */
    private function getWeeklyTrend($storeId, $startDate, $endDate)
    {
        $weeks = [];
        $currentDate = strtotime($startDate);
        $endTimestamp = strtotime($endDate);
        
        while ($currentDate <= $endTimestamp) {
            $weekStart = date('Y-m-d', $currentDate);
            $weekEnd = date('Y-m-d', min($currentDate + (6 * 86400), $endTimestamp));
            
            $revenue = Transaction::where('store_id', $storeId)
                ->whereBetween('transaction_date', [$weekStart . ' 00:00:00', $weekEnd . ' 23:59:59'])
                ->where('status', 'completed')
                ->sum('total_amount');
            
            $count = Transaction::where('store_id', $storeId)
                ->whereBetween('transaction_date', [$weekStart . ' 00:00:00', $weekEnd . ' 23:59:59'])
                ->where('status', 'completed')
                ->count();
            
            $weeks[] = [
                'week_number' => ceil((strtotime($weekStart) - strtotime($startDate)) / (7 * 86400) + 1),
                'start_date' => $weekStart,
                'end_date' => $weekEnd,
                'revenue' => $revenue,
                'transaction_count' => $count
            ];
            
            $currentDate += (7 * 86400);
        }
        
        return $weeks;
    }
    
    /**
     * Export report to CSV
     */
    public function export(Request $request)
    {
        $storeId = auth()->user()->store_id;
        $type = $request->get('type', 'sales');
        $format = $request->get('format', 'csv');
        
        // Implementation for CSV/Excel export
        // You can use Laravel Excel package
        
        return response()->json([
            'success' => true,
            'message' => 'Export started. You will receive an email when ready.'
        ]);
    }
}