<?php
// database/migrations/xxxx_xx_xx_create_comments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('comments')->nullOnDelete();
            $table->text('content');
            $table->string('author_name')->nullable();
            $table->string('author_email')->nullable();
            $table->string('author_ip')->nullable();
            $table->boolean('is_approved')->default(true);
            $table->boolean('is_spam')->default(false);
            $table->integer('likes')->default(0);
            $table->timestamps();

            // Indexes
            $table->index(['post_id', 'is_approved']);
            $table->index('user_id');
            $table->index('parent_id');
            $table->index('created_at');
            $table->index('is_spam');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};