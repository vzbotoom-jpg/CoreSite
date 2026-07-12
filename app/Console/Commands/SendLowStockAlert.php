<?php
// app/Console/Commands/SendLowStockAlert.php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\LowStockAlertMail;

class SendLowStockAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:low-alert 
                            {--store= : Specific store ID}
                            {--threshold=5 : Stock threshold for alert}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send alerts for products with low stock';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $threshold = $this->option('threshold');
        
        $query = Product::whereRaw('stock <= min_stock_alert')
            ->where('stock', '>', 0)
            ->where('is_active', true);

        if ($this->option('store')) {
            $query->where('store_id', $this->option('store'));
        }

        $lowStockProducts = $query->with('store')->get();

        if ($lowStockProducts->isEmpty()) {
            $this->info('No products with low stock found.');
            return Command::SUCCESS;
        }

        $groupedByStore = $lowStockProducts->groupBy('store_id');
        $alertsSent = 0;

        foreach ($groupedByStore as $storeId => $products) {
            $store = $products->first()->store;
            
            if (!$store->settings->low_stock_alert_enabled ?? true) {
                continue;
            }

            try {
                Mail::to($store->email)->send(new LowStockAlertMail($store, $products));
                $alertsSent++;
                
                $this->info("Alert sent to {$store->email} for " . $products->count() . " products");
                
                // Log the alert
                \Log::info('Low stock alert sent', [
                    'store_id' => $store->id,
                    'store_email' => $store->email,
                    'products_count' => $products->count(),
                    'products' => $products->pluck('id', 'name')
                ]);
                
            } catch (\Exception $e) {
                $this->error("Failed to send alert to {$store->email}: {$e->getMessage()}");
                \Log::error('Low stock alert failed', [
                    'store_id' => $store->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        $this->info("Low stock alerts sent to {$alertsSent} stores.");
        
        return Command::SUCCESS;
    }
}