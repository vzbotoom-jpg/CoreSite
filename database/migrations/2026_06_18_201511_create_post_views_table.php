<?php
// database/migrations/xxxx_xx_xx_create_post_views_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->string('referer')->nullable();
            $table->string('session_id')->nullable();
            $table->timestamp('viewed_at')->useCurrent();
            $table->timestamps();

            // Indexes
            $table->index('post_id');
            $table->index('viewed_at');
            $table->index('ip_address');
            $table->index('session_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_views');
    }
};