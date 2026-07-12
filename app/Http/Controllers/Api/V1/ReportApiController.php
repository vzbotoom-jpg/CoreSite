<?php
// app/Http/Controllers/Api/V1/ReportApiController.php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportApiController extends Controller
{
    /**
     * Get monthly financial report
     */
    public function monthlyReport(Request $request)
    {
        $storeId = $request->user()->store_id;
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
        
        // Average transaction
        $averageTransaction = $totalTransactions > 0 ? $totalRevenue / $totalTransactions : 0;
        
        // Daily breakdown
        $dailyBreakdown = Transaction::where('store_id', $storeId)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->select(
                DB::raw('DATE(transaction_date) as date'),
                DB::raw('SUM(total_amount) as revenue'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy(DB::raw('DATE(transaction_date)'))
            ->orderBy('date')
            ->get();
        
        // Weekly trend
        $weeklyTrend = $this->getWeeklyTrend($storeId, $startDate, $endDate);
        
        // Payment method breakdown
        $paymentBreakdown = Transaction::where('store_id', $storeId)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->select('payment_method', DB::raw('SUM(total_amount) as total'), DB::raw('COUNT(*) as count'))
            ->groupBy('payment_method')
            ->get();
        
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
                DB::raw('SUM(transaction_items.quantity) as sold'),
                DB::raw('SUM(transaction_items.subtotal) as revenue')
            )
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('sold')
            ->limit(10)
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => [
                'period' => [
                    'start' => $startDate,
                    'end' => $endDate,
                    'month' => $month
                ],
                'summary' => [
                    'total_revenue' => $totalRevenue,
                    'total_products_sold' => $totalProductsSold,
                    'total_transactions' => $totalTransactions,
                    'average_transaction' => round($averageTransaction, 2)
                ],
                'daily_breakdown' => $dailyBreakdown,
                'weekly_trend' => $weeklyTrend,
                'payment_breakdown' => $paymentBreakdown,
                'top_products' => $topProducts
            ]
        ]);
    }
    
    /**
     * Get inventory report
     */
    public function inventoryReport(Request $request)
    {
        $storeId = $request->user()->store_id;
        
        // Stock summary
        $stockSummary = [
            'total_products' => Product::where('store_id', $storeId)->count(),
            'total_stock_value' => Product::where('store_id', $storeId)->sum(DB::raw('price * stock')),
            'total_stock_quantity' => Product::where('store_id', $storeId)->sum('stock'),
            'low_stock_count' => Product::where('store_id', $storeId)
                ->whereRaw('stock <= min_stock_alert')
                ->where('stock', '>', 0)
                ->count(),
            'out_of_stock_count' => Product::where('store_id', $storeId)
                ->where('stock', 0)
                ->count()
        ];
        
        // Low stock products
        $lowStockProducts = Product::where('store_id', $storeId)
            ->whereRaw('stock <= min_stock_alert')
            ->where('stock', '>', 0)
            ->orderByRaw('stock ASC')
            ->limit(20)
            ->get();
        
        // Out of stock products
        $outOfStockProducts = Product::where('store_id', $storeId)
            ->where('stock', 0)
            ->limit(20)
            ->get();
        
        // Stock movement summary
        $stockMovements = DB::table('inventory_logs')
            ->where('store_id', $storeId)
            ->where('created_at', '>=', now()->subDays(30))
            ->select(
                'type',
                DB::raw('SUM(quantity) as total_quantity'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('type')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => [
                'stock_summary' => $stockSummary,
                'low_stock_products' => $lowStockProducts,
                'out_of_stock_products' => $outOfStockProducts,
                'stock_movements' => $stockMovements
            ]
        ]);
    }
    
    /**
     * Get sales report
     */
    public function salesReport(Request $request)
    {
        $storeId = $request->user()->store_id;
        
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));
        
        $startDateTime = $startDate . ' 00:00:00';
        $endDateTime = $endDate . ' 23:59:59';
        
        // Sales by day
        $salesByDay = Transaction::where('store_id', $storeId)
            ->whereBetween('transaction_date', [$startDateTime, $endDateTime])
            ->where('status', 'completed')
            ->select(
                DB::raw('DATE(transaction_date) as date'),
                DB::raw('SUM(total_amount) as revenue'),
                DB::raw('COUNT(*) as count'),
                DB::raw('AVG(total_amount) as average')
            )
            ->groupBy(DB::raw('DATE(transaction_date)'))
            ->orderBy('date')
            ->get();
        
        // Sales by product
        $salesByProduct = DB::table('transaction_items')
            ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->join('products', 'transaction_items.product_id', '=', 'products.id')
            ->where('transactions.store_id', $storeId)
            ->whereBetween('transactions.transaction_date', [$startDateTime, $endDateTime])
            ->where('transactions.status', 'completed')
            ->select(
                'products.name',
                DB::raw('SUM(transaction_items.quantity) as quantity'),
                DB::raw('SUM(transaction_items.subtotal) as revenue')
            )
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('revenue')
            ->limit(20)
            ->get();
        
        // Summary
        $summary = [
            'total_revenue' => $salesByDay->sum('revenue'),
            'total_transactions' => $salesByDay->sum('count'),
            'total_products_sold' => $salesByProduct->sum('quantity'),
            'average_transaction' => $salesByDay->avg('average') ?? 0
        ];
        
        return response()->json([
            'success' => true,
            'data' => [
                'period' => [
                    'start' => $startDate,
                    'end' => $endDate
                ],
                'summary' => $summary,
                'daily_sales' => $salesByDay,
                'top_products' => $salesByProduct
            ]
        ]);
    }
    
    /**
     * Get dashboard stats
     */
    public function dashboardStats(Request $request)
    {
        $storeId = $request->user()->store_id;
        
        // Today's stats
        $todayStart = now()->startOfDay();
        $todayEnd = now()->endOfDay();
        
        $todayRevenue = Transaction::where('store_id', $storeId)
            ->whereBetween('transaction_date', [$todayStart, $todayEnd])
            ->where('status', 'completed')
            ->sum('total_amount');
        
        $todayTransactions = Transaction::where('store_id', $storeId)
            ->whereBetween('transaction_date', [$todayStart, $todayEnd])
            ->where('status', 'completed')
            ->count();
        
        // This week stats
        $weekStart = now()->startOfWeek();
        $weekEnd = now()->endOfWeek();
        
        $weekRevenue = Transaction::where('store_id', $storeId)
            ->whereBetween('transaction_date', [$weekStart, $weekEnd])
            ->where('status', 'completed')
            ->sum('total_amount');
        
        // This month stats
        $monthStart = now()->startOfMonth();
        $monthEnd = now()->endOfMonth();
        
        $monthRevenue = Transaction::where('store_id', $storeId)
            ->whereBetween('transaction_date', [$monthStart, $monthEnd])
            ->where('status', 'completed')
            ->sum('total_amount');
        
        $monthTransactions = Transaction::where('store_id', $storeId)
            ->whereBetween('transaction_date', [$monthStart, $monthEnd])
            ->where('status', 'completed')
            ->count();
        
        // Low stock count
        $lowStockCount = Product::where('store_id', $storeId)
            ->whereRaw('stock <= min_stock_alert')
            ->count();
        
        // Last 7 days revenue for chart
        $last7Days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $revenue = Transaction::where('store_id', $storeId)
                ->whereDate('transaction_date', $date->format('Y-m-d'))
                ->where('status', 'completed')
                ->sum('total_amount');
            
            $last7Days[] = [
                'date' => $date->format('Y-m-d'),
                'day' => $date->format('D'),
                'revenue' => $revenue
            ];
        }
        
        return response()->json([
            'success' => true,
            'data' => [
                'today' => [
                    'revenue' => $todayRevenue,
                    'transactions' => $todayTransactions
                ],
                'this_week' => [
                    'revenue' => $weekRevenue
                ],
                'this_month' => [
                    'revenue' => $monthRevenue,
                    'transactions' => $monthTransactions
                ],
                'alerts' => [
                    'low_stock' => $lowStockCount
                ],
                'chart' => [
                    'last_7_days' => $last7Days
                ]
            ]
        ]);
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
                'week' => 'Week ' . ceil((strtotime($weekStart) - strtotime($startDate)) / (7 * 86400) + 1),
                'start_date' => $weekStart,
                'end_date' => $weekEnd,
                'revenue' => $revenue,
                'transactions' => $count
            ];
            
            $currentDate += (7 * 86400);
        }
        
        return $weeks;
    }
    
    /**
     * Get daily report
     */
    public function dailyReport(Request $request)
    {
        $storeId = $request->user()->store_id;
        
        $date = $request->get('date', now()->format('Y-m-d'));
        $startDateTime = $date . ' 00:00:00';
        $endDateTime = $date . ' 23:59:59';
        
        $transactions = Transaction::where('store_id', $storeId)
            ->whereBetween('transaction_date', [$startDateTime, $endDateTime])
            ->where('status', 'completed')
            ->get();
        
        $totalRevenue = $transactions->sum('total_amount');
        $totalTransactions = $transactions->count();
        $averageTransaction = $totalTransactions > 0 ? $totalRevenue / $totalTransactions : 0;
        
        return response()->json([
            'success' => true,
            'data' => [
                'date' => $date,
                'summary' => [
                    'total_revenue' => $totalRevenue,
                    'total_transactions' => $totalTransactions,
                    'average_transaction' => round($averageTransaction, 2)
                ],
                'transactions' => $transactions
            ]
        ]);
    }
    
    /**
     * Get profit and loss report
     */
    public function profitLoss(Request $request)
    {
        $storeId = $request->user()->store_id;
        
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));
        
        $startDateTime = $startDate . ' 00:00:00';
        $endDateTime = $endDate . ' 23:59:59';
        
        $revenue = Transaction::where('store_id', $storeId)
            ->whereBetween('transaction_date', [$startDateTime, $endDateTime])
            ->where('status', 'completed')
            ->sum('total_amount');
        
        $cost = 0; // Calculate based on product costs if available
        $profit = $revenue - $cost;
        
        return response()->json([
            'success' => true,
            'data' => [
                'period' => [
                    'start' => $startDate,
                    'end' => $endDate
                ],
                'revenue' => $revenue,
                'cost' => $cost,
                'profit' => $profit,
                'profit_margin' => $revenue > 0 ? round(($profit / $revenue) * 100, 2) : 0
            ]
        ]);
    }
    
    /**
     * Export products
     */
    public function exportProducts(Request $request)
    {
        return response()->json(['success' => false, 'message' => 'Export not yet implemented']);
    }
    
    /**
     * Export transactions
     */
    public function exportTransactions(Request $request)
    {
        return response()->json(['success' => false, 'message' => 'Export not yet implemented']);
    }
    
    /**
     * Export report
     */
    public function exportReport(Request $request)
    {
        return response()->json(['success' => false, 'message' => 'Export not yet implemented']);
    }
    
    /**
     * Get chart data
     */
    public function chartData(Request $request)
    {
        $storeId = $request->user()->store_id;
        
        $last7Days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $revenue = Transaction::where('store_id', $storeId)
                ->whereDate('transaction_date', $date->format('Y-m-d'))
                ->where('status', 'completed')
                ->sum('total_amount');
            
            $last7Days[] = [
                'date' => $date->format('Y-m-d'),
                'day' => $date->format('D'),
                'revenue' => $revenue
            ];
        }
        
        return response()->json([
            'success' => true,
            'data' => [
                'last_7_days' => $last7Days
            ]
        ]);
    }
}