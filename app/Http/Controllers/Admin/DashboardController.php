<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function index()
    {
        $storeId = auth()->user()->store_id;
        
        // Get cached dashboard data (cache for 5 minutes)
        $cacheKey = "dashboard_data_{$storeId}";
        $data = Cache::remember($cacheKey, 300, function () use ($storeId) {
            return $this->getDashboardData($storeId);
        });
        
        return view('admin.dashboard.index', $data);
    }
    
    /**
     * Get all dashboard data
     */
    private function getDashboardData($storeId)
    {
        // Get current month stats
        $currentMonthStart = now()->startOfMonth();
        $currentMonthEnd = now()->endOfMonth();
        
        // Previous month stats
        $previousMonthStart = now()->subMonth()->startOfMonth();
        $previousMonthEnd = now()->subMonth()->endOfMonth();
        
        // Current month revenue
        $currentRevenue = Transaction::where('store_id', $storeId)
            ->whereBetween('transaction_date', [$currentMonthStart, $currentMonthEnd])
            ->where('status', 'completed')
            ->sum('total_amount');
        
        // Previous month revenue
        $previousRevenue = Transaction::where('store_id', $storeId)
            ->whereBetween('transaction_date', [$previousMonthStart, $previousMonthEnd])
            ->where('status', 'completed')
            ->sum('total_amount');
        
        // Revenue growth percentage
        $revenueGrowth = $previousRevenue > 0 
            ? (($currentRevenue - $previousRevenue) / $previousRevenue) * 100 
            : ($currentRevenue > 0 ? 100 : 0);
        
        // Total products sold this month
        $totalSold = Transaction::where('store_id', $storeId)
            ->whereBetween('transaction_date', [$currentMonthStart, $currentMonthEnd])
            ->where('status', 'completed')
            ->with('items')
            ->get()
            ->sum(function ($transaction) {
                return $transaction->items->sum('quantity');
            });
        
        // Previous month products sold
        $previousSold = Transaction::where('store_id', $storeId)
            ->whereBetween('transaction_date', [$previousMonthStart, $previousMonthEnd])
            ->where('status', 'completed')
            ->with('items')
            ->get()
            ->sum(function ($transaction) {
                return $transaction->items->sum('quantity');
            });
        
        // Products sold growth
        $productsGrowth = $previousSold > 0 
            ? (($totalSold - $previousSold) / $previousSold) * 100 
            : ($totalSold > 0 ? 100 : 0);
        
        // Total transactions
        $totalTransactions = Transaction::where('store_id', $storeId)
            ->where('status', 'completed')
            ->count();
        
        // Previous month transactions
        $previousTransactions = Transaction::where('store_id', $storeId)
            ->whereBetween('transaction_date', [$previousMonthStart, $previousMonthEnd])
            ->where('status', 'completed')
            ->count();
        
        // Transactions growth
        $transactionsGrowth = $previousTransactions > 0 
            ? (($totalTransactions - $previousTransactions) / $previousTransactions) * 100 
            : ($totalTransactions > 0 ? 100 : 0);
        
        // Average transaction value
        $averageTransaction = Transaction::where('store_id', $storeId)
            ->where('status', 'completed')
            ->avg('total_amount') ?? 0;
        
        // Previous month average
        $previousAverage = Transaction::where('store_id', $storeId)
            ->whereBetween('transaction_date', [$previousMonthStart, $previousMonthEnd])
            ->where('status', 'completed')
            ->avg('total_amount') ?? 0;
        
        // Average growth
        $averageGrowth = $previousAverage > 0 
            ? (($averageTransaction - $previousAverage) / $previousAverage) * 100 
            : ($averageTransaction > 0 ? 100 : 0);
        
        // Low stock products
        $lowStockProducts = Product::where('store_id', $storeId)
            ->whereRaw('stock <= min_stock_alert')
            ->where('stock', '>', 0)
            ->count();
        
        // Out of stock products
        $outOfStockProducts = Product::where('store_id', $storeId)
            ->where('stock', 0)
            ->count();

        // Low stock products list
        try {
            $lowStockProductsList = Product::where('store_id', $storeId)
                ->where(function($query) {
                    $query->whereRaw('stock <= min_stock_alert')
                          ->orWhere('stock', 0);
                })
                ->orderBy('stock', 'asc')
                ->limit(5)
                ->get();

            
            // Ensure all items are Product models, not strings
            $lowStockProductsList = $lowStockProductsList->filter(function($item) {
                return $item instanceof Product && $item->name;
            });
        } catch (\Exception $e) {
            Log::warning('Failed to load low stock products list: ' . $e->getMessage());
            $lowStockProductsList = collect([]);
        }
        
        // Recent transactions - AMAN dengan pengecekan
        try {
            $recentTransactions = Transaction::where('store_id', $storeId)
                ->with('items.product')
                ->orderBy('transaction_date', 'desc')
                ->limit(10)
                ->get();
            
            // Jika hasilnya kosong atau tidak valid, gunakan koleksi kosong
            if (!$recentTransactions || $recentTransactions->isEmpty()) {
                $recentTransactions = collect([]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to load recent transactions: ' . $e->getMessage());
            $recentTransactions = collect([]);
        }
        
        // Top products by sales
        try {
            $topProducts = DB::table('transaction_items')
                ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
                ->join('products', 'transaction_items.product_id', '=', 'products.id')
                ->where('transactions.store_id', $storeId)
                ->where('transactions.status', 'completed')
                ->whereBetween('transactions.transaction_date', [$currentMonthStart, $currentMonthEnd])
                ->select(
                    'products.id',
                    'products.name',
                    DB::raw('SUM(transaction_items.quantity) as total_sold'),
                    DB::raw('SUM(transaction_items.subtotal) as total_revenue')
                )
                ->groupBy('products.id', 'products.name')
                ->orderByDesc('total_sold')
                ->limit(5)
                ->get();
        } catch (\Exception $e) {
            Log::warning('Failed to load top products: ' . $e->getMessage());
            $topProducts = collect([]);
        }
        
        // Daily sales for chart (last 7 days)
        try {
            $dailySales = Transaction::where('store_id', $storeId)
                ->where('status', 'completed')
                ->where('transaction_date', '>=', now()->subDays(7))
                ->select(
                    DB::raw('DATE(transaction_date) as date'),
                    DB::raw('SUM(total_amount) as total')
                )
                ->groupBy(DB::raw('DATE(transaction_date)'))
                ->orderBy('date')
                ->get()
                ->pluck('total', 'date')
                ->toArray();
        } catch (\Exception $e) {
            Log::warning('Failed to load daily sales: ' . $e->getMessage());
            $dailySales = [];
        }
        
        // Prepare chart data (last 7 days)
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartLabels[] = now()->subDays($i)->format('d/m');
            $chartData[] = $dailySales[$date] ?? 0;
        }
        
        // Monthly revenue trend (last 6 months)
        $monthlyRevenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $revenue = Transaction::where('store_id', $storeId)
                ->whereYear('transaction_date', $month->year)
                ->whereMonth('transaction_date', $month->month)
                ->where('status', 'completed')
                ->sum('total_amount');
            
            $monthlyRevenue[] = [
                'month' => $month->format('M Y'),
                'revenue' => $revenue
            ];
        }
        
        // Payment method breakdown
        try {
            $paymentBreakdown = Transaction::where('store_id', $storeId)
                ->whereBetween('transaction_date', [$currentMonthStart, $currentMonthEnd])
                ->where('status', 'completed')
                ->select('payment_method', DB::raw('COUNT(*) as count'), DB::raw('SUM(total_amount) as total'))
                ->groupBy('payment_method')
                ->get()
                ->toArray();
        } catch (\Exception $e) {
            Log::warning('Failed to load payment breakdown: ' . $e->getMessage());
            $paymentBreakdown = [];
        }
        
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
        
        // Prepare stats array
        $stats = [
            'total_revenue' => $currentRevenue,
            'revenue_trend' => $revenueGrowth,
            'total_products_sold' => $totalSold,
            'products_trend' => $productsGrowth,
            'total_transactions' => $totalTransactions,
            'transactions_trend' => $transactionsGrowth,
            'average_transaction' => $averageTransaction,
            'average_trend' => $averageGrowth,
            'low_stock_count' => $lowStockProducts,
            'out_of_stock_count' => $outOfStockProducts,
            'today_revenue' => $todayRevenue,
            'today_transactions' => $todayTransactions,
        ];
        
        return [
            'stats' => $stats,
            'recentTransactions' => $recentTransactions,
            'topProducts' => $topProducts,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'monthlyRevenue' => $monthlyRevenue,
            'paymentBreakdown' => $paymentBreakdown,
            'lowStockProductsList' => $lowStockProductsList,
        ];
    }
    
    /**
     * Get dashboard stats via AJAX
     */
    public function getStats(Request $request)
    {
        $storeId = auth()->user()->store_id;
        $period = $request->get('period', 'month');
        
        switch ($period) {
            case 'week':
                $startDate = now()->startOfWeek();
                $endDate = now()->endOfWeek();
                break;
            case 'year':
                $startDate = now()->startOfYear();
                $endDate = now()->endOfYear();
                break;
            default:
                $startDate = now()->startOfMonth();
                $endDate = now()->endOfMonth();
        }
        
        $stats = [
            'revenue' => Transaction::where('store_id', $storeId)
                ->whereBetween('transaction_date', [$startDate, $endDate])
                ->where('status', 'completed')
                ->sum('total_amount'),
            
            'transactions' => Transaction::where('store_id', $storeId)
                ->whereBetween('transaction_date', [$startDate, $endDate])
                ->where('status', 'completed')
                ->count(),
            
            'products_sold' => Transaction::where('store_id', $storeId)
                ->whereBetween('transaction_date', [$startDate, $endDate])
                ->where('status', 'completed')
                ->with('items')
                ->get()
                ->sum(fn($t) => $t->items->sum('quantity')),
            
            'average' => Transaction::where('store_id', $storeId)
                ->whereBetween('transaction_date', [$startDate, $endDate])
                ->where('status', 'completed')
                ->avg('total_amount') ?? 0,
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
     * Get chart data for dashboard
     */
    public function getChartData(Request $request)
    {
        $storeId = auth()->user()->store_id;
        $period = $request->get('period', '7days');
        $chartType = $request->get('type', 'revenue');
        
        $days = match($period) {
            '30days' => 30,
            '90days' => 90,
            '180days' => 180,
            default => 7,
        };
        
        $labels = [];
        $values = [];
        
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i);
            
            try {
                if ($chartType === 'transactions') {
                    $data = Transaction::where('store_id', $storeId)
                        ->whereDate('transaction_date', $date->format('Y-m-d'))
                        ->where('status', 'completed')
                        ->count();
                } else {
                    $data = Transaction::where('store_id', $storeId)
                        ->whereDate('transaction_date', $date->format('Y-m-d'))
                        ->where('status', 'completed')
                        ->sum('total_amount');
                }
            } catch (\Exception $e) {
                $data = 0;
            }
            
            $labels[] = $date->format('d/m');
            $values[] = $data;
        }
        
        return response()->json([
            'success' => true,
            'data' => [
                'labels' => $labels,
                'values' => $values,
                'type' => $chartType,
                'period' => $period,
            ]
        ]);
    }
    
    /**
     * Get dashboard summary for widget
     */
    public function getSummary(Request $request)
    {
        $storeId = auth()->user()->store_id;
        
        try {
            $summary = [
                'total_stores' => User::where('store_id', $storeId)->count(),
                'total_products' => Product::where('store_id', $storeId)->count(),
                'total_transactions' => Transaction::where('store_id', $storeId)
                    ->where('status', 'completed')
                    ->count(),
                'total_revenue' => Transaction::where('store_id', $storeId)
                    ->where('status', 'completed')
                    ->sum('total_amount'),
                'recent_activity' => Transaction::where('store_id', $storeId)
                    ->where('created_at', '>=', now()->subHours(24))
                    ->count(),
            ];
        } catch (\Exception $e) {
            Log::error('Failed to load summary: ' . $e->getMessage());
            $summary = [
                'total_stores' => 0,
                'total_products' => 0,
                'total_transactions' => 0,
                'total_revenue' => 0,
                'recent_activity' => 0,
            ];
        }
        
        return response()->json([
            'success' => true,
            'data' => $summary
        ]);
    }
    
    /**
     * Clear dashboard cache
     */
    public function clearCache(Request $request)
    {
        $storeId = auth()->user()->store_id;
        $cacheKey = "dashboard_data_{$storeId}";
        Cache::forget($cacheKey);
        
        return response()->json([
            'success' => true,
            'message' => 'Dashboard cache cleared successfully'
        ]);
    }
}