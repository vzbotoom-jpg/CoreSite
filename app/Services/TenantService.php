<?php
// app/Services/TenantService.php

namespace App\Services;

use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TenantService
{
    /**
     * Get store by slug with caching.
     */
    public function getStoreBySlug(string $slug): ?Store
    {
        return Cache::remember("store_slug_{$slug}", 3600, function () use ($slug) {
            return Store::where('slug', $slug)
                ->where('is_active', true)
                ->first();
        });
    }

    /**
     * Generate unique slug for store.
     */
    public function generateUniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;
        
        while (Store::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }

    /**
     * Create new tenant (store).
     */
    public function createTenant(array $data): Store
    {
        DB::beginTransaction();
        
        try {
            // Create store
            $store = Store::create([
                'name' => $data['store_name'],
                'slug' => $this->generateUniqueSlug($data['store_name']),
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'is_active' => true,
                'settings' => [
                    'currency' => 'IDR',
                    'timezone' => 'Asia/Jakarta',
                    'date_format' => 'd-m-Y',
                    'notification_email' => $data['email'],
                    'low_stock_alert_enabled' => true,
                    'send_monthly_report' => true,
                ]
            ]);
            
            // Create admin user
            $user = User::create([
                'store_id' => $store->id,
                'name' => $data['name'] ?? $data['store_name'] . ' Admin',
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now()
            ]);
            
            DB::commit();
            
            return $store;
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Switch tenant context.
     */
    public function switchTenant(Store $store): void
    {
        // Clear previous tenant cache
        if (config('tenant.id')) {
            Cache::forget("store_slug_{$store->slug}");
        }
        
        // Set new tenant context
        config(['tenant.id' => $store->id]);
        config(['tenant.name' => $store->name]);
        config(['tenant.slug' => $store->slug]);
        
        // Set database connection for multi-database setup (optional)
        // config(['database.connections.tenant.database' => "store_{$store->id}"]);
    }

    /**
     * Get current tenant.
     */
    public function getCurrentTenant(): ?Store
    {
        $storeId = config('tenant.id');
        
        if (!$storeId) {
            return null;
        }
        
        return Cache::remember("store_{$storeId}", 3600, function () use ($storeId) {
            return Store::find($storeId);
        });
    }

    /**
     * Clear tenant cache.
     */
    public function clearCache(Store $store): void
    {
        Cache::forget("store_slug_{$store->slug}");
        Cache::forget("store_{$store->id}");
    }
}