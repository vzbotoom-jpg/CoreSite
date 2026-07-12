<?php
// database/migrations/xxxx_xx_xx_add_type_to_categories_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // Cek apakah kolom type sudah ada
            if (!Schema::hasColumn('categories', 'type')) {
                $table->enum('type', ['product', 'blog'])->default('product')->after('id');
            }
            
            // Cek apakah kolom meta_title sudah ada
            if (!Schema::hasColumn('categories', 'meta_title')) {
                $table->string('meta_title')->nullable()->after('type');
            }
            
            // Cek apakah kolom meta_description sudah ada
            if (!Schema::hasColumn('categories', 'meta_description')) {
                $table->text('meta_description')->nullable()->after('meta_title');
            }
            
            // Cek apakah kolom sort_order sudah ada
            if (!Schema::hasColumn('categories', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('meta_description');
            }
        });

        // Tambahkan index jika belum ada
        try {
            Schema::table('categories', function (Blueprint $table) {
                $table->index('type');
            });
        } catch (\Exception $e) {
            // Index mungkin sudah ada
        }
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $columns = ['type', 'meta_title', 'meta_description', 'sort_order'];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('categories', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};