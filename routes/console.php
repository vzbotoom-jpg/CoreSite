<?php
// routes/console.php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
*/

Artisan::command('inspire', function () {
    $this->comment('CoreSite - Platform SaaS untuk UMKM');
})->purpose('Display an inspiring quote');

Artisan::command('app:info', function () {
    $this->table(
        ['Setting', 'Value'],
        [
            ['App Name', config('app.name')],
            ['Environment', app()->environment()],
            ['Debug Mode', config('app.debug') ? 'ON' : 'OFF'],
            ['URL', config('app.url')],
            ['Timezone', config('app.timezone')],
            ['Locale', app()->getLocale()],
            ['Version', '1.0.0'],
        ]
    );
})->purpose('Display application information');

Artisan::command('db:setup', function () {
    if ($this->confirm('This will wipe all data. Are you sure?')) {
        $this->call('migrate:fresh');
        $this->call('db:seed');
        $this->info('✓ Database setup completed successfully!');
    }
})->purpose('Setup database with fresh migrations and seeders');

Artisan::command('app:clear', function () {
    $this->call('optimize:clear');
    $this->call('config:clear');
    $this->call('cache:clear');
    $this->call('view:clear');
    $this->call('route:clear');
    $this->info('✓ All caches cleared successfully!');
})->purpose('Clear all application caches');

Artisan::command('app:deploy', function () {
    $this->info('🚀 Starting deployment...');
    
    $this->call('down', ['--retry' => 60]);
    $this->info('✓ Application is down for maintenance');
    
    $this->call('optimize:clear');
    $this->info('✓ Caches cleared');
    
    $this->call('migrate', ['--force' => true]);
    $this->info('✓ Migrations executed');
    
    $this->call('config:cache');
    $this->info('✓ Config cached');
    
    $this->call('route:cache');
    $this->info('✓ Routes cached');
    
    $this->call('view:cache');
    $this->info('✓ Views cached');
    
    $this->call('event:cache');
    $this->info('✓ Events cached');
    
    $this->call('up');
    $this->info('✓ Application is back online');
    
    $this->info('✅ Deployment completed successfully!');
})->purpose('Deploy application with maintenance mode');

// ==================== SCHEDULED COMMANDS ====================
// Generate monthly report on the 1st of each month at 1 AM
Schedule::command('report:generate-monthly')->monthlyOn(1, '01:00');

// Send low stock alerts daily at 9 AM
Schedule::command('stock:low-alert')->dailyAt('09:00');

// Cleanup inactive stores weekly on Monday at 2 AM
Schedule::command('store:cleanup-inactive')->weekly()->mondays()->at('02:00');

// Backup database daily at 3 AM
Schedule::command('db:backup')->dailyAt('03:00');

// Generate daily sales report at 11:59 PM
Schedule::command('report:daily-sales')->dailyAt('23:59');

// Cleanup expired sessions every hour
Schedule::command('session:gc')->hourly();

// Calculate store analytics daily at 1:30 AM
Schedule::command('analytics:calculate')->dailyAt('01:30');

// Send weekly summary every Monday at 8 AM
Schedule::command('report:weekly-summary')->weekly()->mondays()->at('08:00');

// Check for system updates weekly
Schedule::command('system:check-updates')->weekly()->sundays()->at('03:00');

// Cleanup old logs (keep 30 days)
Schedule::command('log:cleanup --days=30')->dailyAt('04:00');