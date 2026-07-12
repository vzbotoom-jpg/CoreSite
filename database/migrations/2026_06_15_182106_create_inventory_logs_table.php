<?php
// database/migrations/2024_01_01_000007_create_inventory_logs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('transaction_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('type', ['sale', 'restock', 'adjustment', 'return']);
            $table->integer('quantity');
            $table->integer('old_stock');
            $table->integer('new_stock');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['store_id', 'product_id', 'type']);
            $table->index(['store_id', 'created_at']);
            $table->index('type');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_logs');
    }
};