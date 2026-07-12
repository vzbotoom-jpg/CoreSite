<?php
// database/migrations/xxxx_add_timestamps_to_role_user_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('role_user', function (Blueprint $table) {
            // Timestamps already exist from previous migration
            // This is just to ensure the table has proper structure
        });
        
        Schema::table('permission_role', function (Blueprint $table) {
            // Timestamps already exist from previous migration
        });
    }

    public function down(): void
    {
        // No need to rollback
    }
};