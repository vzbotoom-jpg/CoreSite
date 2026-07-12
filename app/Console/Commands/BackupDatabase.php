<?php
// app/Console/Commands/BackupDatabase.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup 
                            {--filename= : Custom backup filename}
                            {--compress : Compress the backup}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup the database to storage';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting database backup...');

        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host');

        $filename = $this->option('filename') ?? 'backup_' . date('Y-m-d_H-i-s') . '.sql';
        
        if ($this->option('compress')) {
            $filename .= '.gz';
        }

        $backupPath = storage_path("app/backups/{$filename}");
        $backupDir = dirname($backupPath);

        if (!is_dir($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        try {
            // Create backup command
            $command = sprintf(
                'mysqldump --user=%s --password=%s --host=%s %s > %s',
                escapeshellarg($username),
                escapeshellarg($password),
                escapeshellarg($host),
                escapeshellarg($database),
                escapeshellarg($backupPath)
            );

            // Add compression if requested
            if ($this->option('compress')) {
                $command = sprintf(
                    'mysqldump --user=%s --password=%s --host=%s %s | gzip > %s',
                    escapeshellarg($username),
                    escapeshellarg($password),
                    escapeshellarg($host),
                    escapeshellarg($database),
                    escapeshellarg($backupPath)
                );
            }

            // Execute backup
            $returnVar = null;
            $output = null;
            exec($command, $output, $returnVar);

            if ($returnVar !== 0) {
                throw new \Exception("Backup failed with code: {$returnVar}");
            }

            $fileSize = filesize($backupPath);
            $sizeInMB = round($fileSize / 1024 / 1024, 2);

            $this->info("✓ Database backup completed successfully!");
            $this->info("  File: {$filename}");
            $this->info("  Size: {$sizeInMB} MB");
            $this->info("  Path: {$backupPath}");

            // Clean old backups (keep only last 30 days)
            $this->cleanOldBackups();

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error("Backup failed: " . $e->getMessage());
            \Log::error('Database backup failed', ['error' => $e->getMessage()]);
            return Command::FAILURE;
        }
    }

    private function cleanOldBackups()
    {
        $backupDir = storage_path('app/backups');
        
        if (!is_dir($backupDir)) {
            return;
        }

        $files = glob($backupDir . '/*.{sql,sql.gz}', GLOB_BRACE);
        $now = time();
        $keepDays = 30;

        foreach ($files as $file) {
            if (is_file($file)) {
                $fileAge = $now - filemtime($file);
                if ($fileAge > $keepDays * 86400) {
                    unlink($file);
                    $this->line("  Removed old backup: " . basename($file));
                }
            }
        }
    }
}