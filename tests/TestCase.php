<?php
// tests/TestCase.php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase, WithFaker;
    
    /**
     * Indicates whether the default seeder should run before each test.
     *
     * @var bool
     */
    protected $seed = false;
    
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
        
        // Set testing configuration
        config([
            'app.env' => 'testing',
            'mail.default' => 'array',
            'queue.default' => 'sync',
        ]);
    }
    
    /**
     * Create authenticated user for testing.
     */
    protected function actingAsUser($user = null)
    {
        if (!$user) {
            $user = \App\Models\User::factory()->admin()->create();
        }
        
        return $this->actingAs($user);
    }
    
    /**
     * Create store with admin user for testing.
     */
    protected function createStoreWithAdmin($storeData = [], $userData = [])
    {
        $store = \App\Models\Store::factory()->create($storeData);
        $user = \App\Models\User::factory()->admin()->create(array_merge([
            'store_id' => $store->id,
        ], $userData));
        
        return ['store' => $store, 'user' => $user];
    }
    
    /**
     * Create product for testing.
     */
    protected function createProduct($storeId, $productData = [])
    {
        return \App\Models\Product::factory()->create(array_merge([
            'store_id' => $storeId,
        ], $productData));
    }
    
    /**
     * Create transaction for testing.
     */
    protected function createTransaction($storeId, $items = [], $transactionData = [])
    {
        $saleService = app(\App\Services\SaleService::class);
        
        if (empty($items)) {
            $product = $this->createProduct($storeId, ['stock' => 10]);
            $items = [
                ['product_id' => $product->id, 'quantity' => 2]
            ];
        }
        
        return $saleService->processSale(
            $storeId,
            $items,
            $transactionData['payment_method'] ?? 'cash',
            $transactionData['paid_amount'] ?? 100000,
            $transactionData['notes'] ?? null
        );
    }
    
    /**
     * Generate test JWT token.
     */
    protected function getTestToken($user)
    {
        return $user->createToken('test-token')->plainTextToken;
    }
}