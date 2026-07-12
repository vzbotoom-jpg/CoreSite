<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scheduled_job_id')->constrained('scheduled_jobs')->onDelete('cascade');
            $table->enum('status', ['pending', 'running', 'success', 'failed'])->default('pending');
            $table->longText('output')->nullable();
            $table->longText('error_message')->nullable();
            $table->integer('duration')->nullable(); // in seconds
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_logs');
    }
};
