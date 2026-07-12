<?php
// database/migrations/xxxx_xx_xx_create_newsletter_logs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('newsletter_logs', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->text('content');
            $table->integer('recipients_count')->default(0);
            $table->integer('sent_count')->default(0);
            $table->integer('open_count')->default(0);
            $table->integer('click_count')->default(0);
            $table->string('status')->default('pending'); // pending, sending, sent, failed
            $table->timestamp('sent_at')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('status');
            $table->index('sent_at');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('newsletter_logs');
    }
};