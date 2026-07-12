<?php
// database/migrations/xxxx_xx_xx_create_subscribers_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('email')->unique();
            $table->string('name')->nullable();
            $table->string('verification_token', 64)->unique();
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('unsubscribed_at')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('source')->nullable(); // 'website', 'admin', 'api', 'landing', etc.
            $table->json('preferences')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('email');
            $table->index(['is_active', 'is_verified']);
            $table->index('verification_token');
            $table->index('created_at');
            $table->index('store_id');
            $table->index('user_id');
            $table->index('source');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscribers');
    }
};