<?php
// tests/Unit/SaleServiceTest.php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Transaction;
use App\Services\SaleService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SaleServiceTest extends TestCase
{
    use RefreshDatabase;
    
    protected $saleService;
    protected $store;
    
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->saleService = app(SaleService::class);
        
        $setup = $this->createStoreWithAdmin();
        $this->store = $setup['store'];
    }
    
    /** @test */
    public function test_process_sale_successfully()
    {
        $product = Product::factory()->create([
            'store_id' => $this->store->id,
            'price' => 50000,
            'stock' => 10,
        ]);
        
        $result = $this->saleService->processSale(
            $this->store->id,
            [['product_id' => $product->id, 'quantity' => 2]],
            'cash',
            100000
        );
        
        $this->assertTrue($result['success']);
        $this->assertInstanceOf(Transaction::class, $result['transaction']);
        $this->assertEquals(100000, $result['transaction']->total_amount);
        
        $product->refresh();
        $this->assertEquals(8, $product->stock);
    }
    
    /** @test */
    public function test_process_sale_fails_with_insufficient_stock()
    {
        $product = Product::factory()->create([
            'store_id' => $this->store->id,
            'stock' => 3,
        ]);
        
        $result = $this->saleService->processSale(
            $this->store->id,
            [['product_id' => $product->id, 'quantity' => 5]],
            'cash',
            100000
        );
        
        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Insufficient stock', $result['error']);
        
        $product->refresh();
        $this->assertEquals(3, $product->stock);
    }
    
    /** @test */
    public function test_process_sale_fails_with_insufficient_payment()
    {
        $product = Product::factory()->create([
            'store_id' => $this->store->id,
            'price' => 100000,
        ]);
        
        $result = $this->saleService->processSale(
            $this->store->id,
            [['product_id' => $product->id, 'quantity' => 1]],
            'cash',
            50000
        );
        
        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Insufficient payment', $result['error']);
    }
    
    /** @test */
    public function test_cancel_sale_successfully()
    {
        $product = Product::factory()->create([
            'store_id' => $this->store->id,
            'price' => 50000,
            'stock' => 10,
        ]);
        
        $result = $this->saleService->processSale(
            $this->store->id,
            [['product_id' => $product->id, 'quantity' => 3]],
            'cash',
            150000
        );
        
        $transaction = $result['transaction'];
        $product->refresh();
        $this->assertEquals(7, $product->stock);
        
        $cancelResult = $this->saleService->cancelSale($transaction->id);
        
        $this->assertTrue($cancelResult['success']);
        
        $product->refresh();
        $this->assertEquals(10, $product->stock);
        
        $transaction->refresh();
        $this->assertEquals('cancelled', $transaction->status);
    }
    
    /** @test */
    public function test_cancel_sale_fails_for_already_cancelled_transaction()
    {
        $product = Product::factory()->create([
            'store_id' => $this->store->id,
            'price' => 50000,
        ]);
        
        $result = $this->saleService->processSale(
            $this->store->id,
            [['product_id' => $product->id, 'quantity' => 1]],
            'cash',
            50000
        );
        
        $transaction = $result['transaction'];
        
        // Cancel first time
        $this->saleService->cancelSale($transaction->id);
        
        // Cancel second time
        $cancelResult = $this->saleService->cancelSale($transaction->id);
        
        $this->assertFalse($cancelResult['success']);
        $this->assertStringContainsString('Only completed transactions', $cancelResult['error']);
    }
    
    /** @test */
    public function test_generate_unique_invoice_number()
    {
        $method = new \ReflectionMethod($this->saleService, 'generateInvoiceNumber');
        $method->setAccessible(true);
        
        $invoiceNumber = $method->invoke($this->saleService, $this->store->id);
        
        $this->assertStringStartsWith('INV/', $invoiceNumber);
        $this->assertStringContainsString(date('Ymd'), $invoiceNumber);
    }
    
    /** @test */
    public function test_process_sale_creates_transaction_items()
    {
        $product = Product::factory()->create([
            'store_id' => $this->store->id,
            'price' => 50000,
        ]);
        
        $result = $this->saleService->processSale(
            $this->store->id,
            [['product_id' => $product->id, 'quantity' => 2]],
            'cash',
            100000
        );
        
        $this->assertDatabaseHas('transaction_items', [
            'transaction_id' => $result['transaction']->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'price' => 50000,
            'subtotal' => 100000,
        ]);
    }
}