<?php
// app/Console/Commands/GenerateMonthlyReport.php

namespace App\Console\Commands;

use App\Models\Store;
use App\Models\Transaction;
use App\Services\ReportService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\MonthlyReportMail;

class GenerateMonthlyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:generate-monthly 
                            {--store= : Specific store ID (optional)}
                            {--month= : Month in YYYY-MM format (default: previous month)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate monthly financial reports for stores';

    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        parent::__construct();
        $this->reportService = $reportService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $month = $this->option('month') ?? now()->subMonth()->format('Y-m');
        $startDate = date('Y-m-01 00:00:00', strtotime($month));
        $endDate = date('Y-m-t 23:59:59', strtotime($month));

        $this->info("Generating reports for period: {$startDate} to {$endDate}");

        $stores = $this->option('store') 
            ? Store::where('id', $this->option('store'))->get()
            : Store::where('is_active', true)->get();

        $bar = $this->output->createProgressBar(count($stores));
        $bar->start();

        $generated = 0;
        $failed = 0;

        foreach ($stores as $store) {
            try {
                DB::beginTransaction();

                // Generate report data
                $report = $this->generateStoreReport($store, $startDate, $endDate);
                
                // Store report in database
                $storeReport = $store->reports()->create([
                    'period_start' => $startDate,
                    'period_end' => $endDate,
                    'data' => json_encode($report),
                    'generated_at' => now()
                ]);

                // Send email to store owner
                if ($store->settings->send_monthly_report ?? true) {
                    Mail::to($store->email)->send(new MonthlyReportMail($store, $report));
                }

                DB::commit();
                $generated++;

            } catch (\Exception $e) {
                DB::rollBack();
                $failed++;
                $this->error("\nFailed for store {$store->id}: {$e->getMessage()}");
                \Log::error('Monthly report generation failed', [
                    'store_id' => $store->id,
                    'error' => $e->getMessage()
                ]);
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Reports generated: {$generated}, Failed: {$failed}");

        return $failed === 0 ? Command::SUCCESS : Command::FAILURE;
    }

    private function generateStoreReport($store, $startDate, $endDate)
    {
        return [
            'store_name' => $store->name,
            'period' => [
                'start' => $startDate,
                'end' => $endDate
            ],
            'summary' => [
                'total_revenue' => Transaction::where('store_id', $store->id)
                    ->whereBetween('transaction_date', [$startDate, $endDate])
                    ->where('status', 'completed')
                    ->sum('total_amount'),
                
                'total_transactions' => Transaction::where('store_id', $store->id)
                    ->whereBetween('transaction_date', [$startDate, $endDate])
                    ->where('status', 'completed')
                    ->count(),
                
                'average_transaction' => Transaction::where('store_id', $store->id)
                    ->whereBetween('transaction_date', [$startDate, $endDate])
                    ->where('status', 'completed')
                    ->avg('total_amount') ?? 0,
                
                'top_products' => DB::table('transaction_items')
                    ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
                    ->join('products', 'transaction_items.product_id', '=', 'products.id')
                    ->where('transactions.store_id', $store->id)
                    ->whereBetween('transactions.transaction_date', [$startDate, $endDate])
                    ->select('products.name', DB::raw('SUM(transaction_items.quantity) as total_sold'))
                    ->groupBy('products.id', 'products.name')
                    ->orderByDesc('total_sold')
                    ->limit(5)
                    ->get()
            ],
            'charts' => $this->reportService->getDailyBreakdown($store->id, $startDate, $endDate)
        ];
    }
}