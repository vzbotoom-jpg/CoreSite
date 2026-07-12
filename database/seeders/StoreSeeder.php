<?php
// database/seeders/StoreSeeder.php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        // Create demo store
        $demoStore = Store::create([
            'name' => 'Toko Demo CoreSite',
            'slug' => 'demo',
            'email' => 'demo@coresite.com',
            'phone' => '08123456789',
            'is_active' => true,
            'settings' => json_encode([
                'currency' => 'IDR',
                'timezone' => 'Asia/Jakarta',
                'date_format' => 'd-m-Y',
                'notification_email' => 'demo@coresite.com',
                'low_stock_alert_enabled' => true,
                'send_monthly_report' => true,
                'theme' => 'light',
            ]),
        ]);
        
        // Create admin user for demo store
        User::create([
            'store_id' => $demoStore->id,
            'name' => 'Admin Demo',
            'email' => 'admin@coresite.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        
        // Create additional stores using factory
        Store::factory(5)
            ->has(User::factory()->admin(), 'users')
            ->create();
        
        // Create stores with inactive status
        Store::factory(2)->inactive()->create();
    }
}