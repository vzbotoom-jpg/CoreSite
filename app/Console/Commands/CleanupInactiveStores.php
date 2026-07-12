<?php
// app/Console/Commands/CleanupInactiveStores.php

namespace App\Console\Commands;

use App\Models\Store;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CleanupInactiveStores extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store:cleanup-inactive 
                            {--days=180 : Number of days of inactivity before cleanup}
                            {--force : Force deletion without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Soft delete or permanently remove inactive stores';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $daysInactive = (int) $this->option('days');
        $cutoffDate = Carbon::now()->subDays($daysInactive);

        // Find stores with no transactions in the cutoff period
        $inactiveStores = Store::whereDoesntHave('transactions', function($query) use ($cutoffDate) {
                $query->where('created_at', '>=', $cutoffDate);
            })
            ->where('created_at', '<', $cutoffDate)
            ->where('is_active', true)
            ->get();

        if ($inactiveStores->isEmpty()) {
            $this->info('No inactive stores found.');
            return Command::SUCCESS;
        }

        $this->warn("Found {$inactiveStores->count()} inactive stores (no activity for {$daysInactive} days):");
        
        foreach ($inactiveStores as $store) {
            $this->line("  - {$store->name} (ID: {$store->id}, Created: {$store->created_at->format('Y-m-d')})");
        }

        if (!$this->option('force')) {
            if (!$this->confirm('Do you want to mark these stores as inactive? They will be soft-deleted.')) {
                $this->info('Operation cancelled.');
                return Command::SUCCESS;
            }
        }

        $bar = $this->output->createProgressBar(count($inactiveStores));
        $bar->start();

        $processed = 0;
        $errors = 0;

        foreach ($inactiveStores as $store) {
            try {
                DB::beginTransaction();

                // Soft delete the store
                $store->update([
                    'is_active' => false,
                    'deactivated_at' => now(),
                    'deactivation_reason' => "No activity for {$daysInactive} days"
                ]);

                // Deactivate all users for this store
                User::where('store_id', $store->id)->update([
                    'is_active' => false
                ]);

                // Archive store data (optional)
                $this->archiveStoreData($store);

                DB::commit();
                $processed++;

            } catch (\Exception $e) {
                DB::rollBack();
                $errors++;
                $this->error("\nFailed to process store {$store->id}: {$e->getMessage()}");
                \Log::error('Store cleanup failed', [
                    'store_id' => $store->id,
                    'error' => $e->getMessage()
                ]);
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Cleanup completed: {$processed} stores deactivated, {$errors} errors.");

        return Command::SUCCESS;
    }

    private function archiveStoreData($store)
    {
        // Create archive directory
        $archivePath = storage_path("app/archives/store_{$store->id}_{$store->slug}");
        
        if (!is_dir($archivePath)) {
            mkdir($archivePath, 0755, true);
        }

        // Export store data to JSON
        $data = [
            'store' => $store->toArray(),
            'products' => $store->products()->get()->toArray(),
            'transactions' => $store->transactions()->take(100)->get()->toArray(),
            'archived_at' => now()->toDateTimeString()
        ];

        file_put_contents(
            "{$archivePath}/store_data.json",
            json_encode($data, JSON_PRETTY_PRINT)
        );

        $this->line("Archived data to: {$archivePath}");
    }
}