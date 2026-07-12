<?php
// app/Console/Kernel.php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\CreateStore::class,
        Commands\GenerateMonthlyReport::class,
        Commands\CleanupInactiveStores::class,
        Commands\SendLowStockAlert::class,
        Commands\BackupDatabase::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Generate monthly report every 1st day of month at 01:00 AM
        $schedule->command('report:generate-monthly')
            ->monthlyOn(1, '01:00')
            ->emailOutputOnFailure(config('mail.admin_email'));

        // Send low stock alerts every day at 09:00 AM
        $schedule->command('stock:low-alert')
            ->dailyAt('09:00')
            ->emailOutputOnFailure(config('mail.admin_email'));

        // Clean up inactive stores (soft delete stores inactive for > 6 months)
        $schedule->command('store:cleanup-inactive')
            ->weekly()
            ->mondays()
            ->at('02:00');

        // Backup database daily at 03:00 AM
        $schedule->command('db:backup')
            ->dailyAt('03:00')
            ->appendOutputTo(storage_path('logs/backup.log'));

        // Generate daily sales report
        $schedule->command('report:daily-sales')
            ->dailyAt('23:59')
            ->emailOutputTo(config('mail.admin_email'));

        // Cleanup expired sessions every hour
        $schedule->command('session:gc')
            ->hourly();

        // Prune telescope entries (if using telescope)
        $schedule->command('telescope:prune')
            ->daily();

        // Calculate store analytics daily
        $schedule->command('analytics:calculate')
            ->dailyAt('01:30');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}