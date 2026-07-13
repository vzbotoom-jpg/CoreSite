<?php
// tests/Feature/TransactionTest.php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;
    
    protected $store;
    protected $user;
    
    protected function setUp(): void
    {
        parent::setUp();
        
        $setup = $this->createStoreWithAdmin();
        $this->store = $setup['store'];
        $this->user = $setup['user'];
    }
    
    /** @test */
    public function test_admin_can_view_transactions_list()
    {
        $product = Product::factory()->create(['store_id' => $this->store->id]);
        
        // Create transaction
        $this->createTransaction($this->store->id, [
            ['product_id' => $product->id, 'quantity' => 2]
        ]);
        
        $response = $this->actingAs($this->user)
            ->get(route('admin.transactions.index'));
        
        $response->assertStatus(200);
        $response->assertViewHas('transactions');
    }
    
    /** @test */
    public function test_admin_can_create_sale_transaction()
    {
        $product = Product::factory()->create([
            'store_id' => $this->store->id,
            'price' => 50000,
            'stock' => 10,
        ]);
        
        $response = $this->actingAs($this->user)
            ->postJson(route('admin.transactions.store'), [
                'items' => [
                    ['product_id' => $product->id, 'quantity' => 2]
                ],
                'payment_method' => 'cash',
                'paid_amount' => 100000,
            ]);
        
        $response->assertStatus(201);
        
        $this->assertDatabaseHas('transactions', [
            'store_id' => $this->store->id,
            'total_amount' => 100000,
            'paid_amount' => 100000,
            'payment_method' => 'cash',
        ]);
        
        $product->refresh();
        $this->assertEquals(8, $product->stock);
    }
    
    /** @test */
    public function test_transaction_fails_when_stock_insufficient()
    {
        $product = Product::factory()->create([
            'store_id' => $this->store->id,
            'stock' => 3,
        ]);
        
        $response = $this->actingAs($this->user)
            ->postJson(route('admin.transactions.store'), [
                'items' => [
                    ['product_id' => $product->id, 'quantity' => 5]
                ],
                'payment_method' => 'cash',
                'paid_amount' => 100000,
            ]);
        
        $response->assertStatus(422);
        
        $product->refresh();
        $this->assertEquals(3, $product->stock);
    }
    
    /** @test */
    public function test_transaction_fails_when_payment_insufficient()
    {
        $product = Product::factory()->create([
            'store_id' => $this->store->id,
            'price' => 100000,
        ]);
        
        $response = $this->actingAs($this->user)
            ->postJson(route('admin.transactions.store'), [
                'items' => [
                    ['product_id' => $product->id, 'quantity' => 1]
                ],
                'payment_method' => 'cash',
                'paid_amount' => 50000,
            ]);
        
        $response->assertStatus(422);
    }
    
    /** @test */
    public function test_admin_can_view_transaction_detail()
    {
        $result = $this->createTransaction($this->store->id);
        $transaction = $result['transaction'];
        
        $response = $this->actingAs($this->user)
            ->get(route('admin.transactions.show', $transaction));
        
        $response->assertStatus(200);
        $response->assertViewHas('transaction');
    }
    
    /** @test */
    public function test_admin_can_cancel_transaction()
    {
        $product = Product::factory()->create([
            'store_id' => $this->store->id,
            'stock' => 10,
        ]);
        
        $result = $this->createTransaction($this->store->id, [
            ['product_id' => $product->id, 'quantity' => 2]
        ]);
        $transaction = $result['transaction'];
        
        // Check stock after sale
        $product->refresh();
        $this->assertEquals(8, $product->stock);
        
        $response = $this->actingAs($this->user)
            ->post(route('admin.transactions.cancel', $transaction));
        
        $response->assertStatus(200);
        
        // Check stock restored
        $product->refresh();
        $this->assertEquals(10, $product->stock);
        
        // Check transaction status updated
        $transaction->refresh();
        $this->assertEquals('cancelled', $transaction->status);
    }
    
    /** @test */
    public function test_transaction_creates_inventory_log()
    {
        $product = Product::factory()->create([
            'store_id' => $this->store->id,
            'stock' => 10,
        ]);
        
        $result = $this->createTransaction($this->store->id, [
            ['product_id' => $product->id, 'quantity' => 3]
        ]);
        
        $this->assertDatabaseHas('inventory_logs', [
            'product_id' => $product->id,
            'type' => 'sale',
            'quantity' => 3,
            'old_stock' => 10,
            'new_stock' => 7,
        ]);
    }
}