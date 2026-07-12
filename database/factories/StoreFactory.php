<?php
// database/factories/StoreFactory.php

namespace Database\Factories;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StoreFactory extends Factory
{
    protected $model = Store::class;
    
    public function definition(): array
    {
        $name = $this->faker->company();
        
        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . $this->faker->unique()->numberBetween(1, 9999),
            'email' => $this->faker->unique()->companyEmail(),
            'phone' => $this->faker->phoneNumber(),
            'logo' => null,
            'is_active' => true,
            'settings' => json_encode([
                'currency' => 'IDR',
                'timezone' => 'Asia/Jakarta',
                'date_format' => 'd-m-Y',
                'notification_email' => $this->faker->email(),
                'low_stock_alert_enabled' => true,
                'send_monthly_report' => true,
            ]),
        ];
    }
    
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
            'deactivated_at' => now(),
            'deactivation_reason' => 'Inactive store',
        ]);
    }
}