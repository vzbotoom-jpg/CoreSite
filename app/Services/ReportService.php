<?php
// app/Services/ReportService.php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ReportService
{
    /**
     * Generate monthly financial report.
     */
    public function generateMonthlyReport(int $storeId, string $month): array
    {
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
        
        // Daily breakdown
        $dailyBreakdown = $this->getDailyBreakdown($storeId, $startDate, $endDate);
        
        // Weekly trend
        $weeklyTrend = $this->getWeeklyTrend($storeId, $startDate, $endDate);
        
        // Top products
        $topProducts = $this->getTopProducts($storeId, $startDate, $endDate);
        
        // Payment method breakdown
        $paymentBreakdown = Transaction::where('store_id', $storeId)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->select('payment_method', DB::raw('SUM(total_amount) as total'), DB::raw('COUNT(*) as count'))
            ->groupBy('payment_method')
            ->get();
        
        return [
            'period' => [
                'start' => $startDate,
                'end' => $endDate,
                'month' => $month
            ],
            'summary' => [
                'total_revenue' => $totalRevenue,
                'total_products_sold' => $totalProductsSold,
                'total_transactions' => $totalTransactions,
                'average_transaction' => $totalTransactions > 0 ? $totalRevenue / $totalTransactions : 0
            ],
            'daily_breakdown' => $dailyBreakdown,
            'weekly_trend' => $weeklyTrend,
            'top_products' => $topProducts,
            'payment_breakdown' => $paymentBreakdown
        ];
    }

    /**
     * Get daily breakdown for date range.
     */
    public function getDailyBreakdown(int $storeId, string $startDate, string $endDate): \Illuminate\Support\Collection
    {
        return Transaction::where('store_id', $storeId)
            ->whereBetween('transaction_date', [$startDate, $endDate])
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
    }

    /**
     * Get weekly trend for date range.
     */
    public function getWeeklyTrend(int $storeId, string $startDate, string $endDate): array
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
     * Get top products for date range.
     */
    public function getTopProducts(int $storeId, string $startDate, string $endDate, int $limit = 10): \Illuminate\Support\Collection
    {
        return DB::table('transaction_items')
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
            ->limit($limit)
            ->get();
    }

    /**
     * Get inventory report.
     */
    public function getInventoryReport(int $storeId): array
    {
        return [
            'summary' => [
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
            ],
            'low_stock_products' => Product::where('store_id', $storeId)
                ->whereRaw('stock <= min_stock_alert')
                ->where('stock', '>', 0)
                ->orderBy('stock')
                ->limit(20)
                ->get(),
            'out_of_stock_products' => Product::where('store_id', $storeId)
                ->where('stock', 0)
                ->orderBy('name')
                ->limit(20)
                ->get()
        ];
    }
}