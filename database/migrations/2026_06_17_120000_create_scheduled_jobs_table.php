<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scheduled_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->string('command');
            $table->string('expression')->default('* * * * *'); // Cron expression
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_run_at')->nullable();
            $table->enum('last_run_status', ['pending', 'success', 'failed'])->default('pending');
            $table->integer('runs_count')->default(0);
            $table->integer('fails_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scheduled_jobs');
    }
};
