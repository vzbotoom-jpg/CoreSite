<?php
// tests/Unit/ReportServiceTest.php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Transaction;
use App\Services\ReportService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReportServiceTest extends TestCase
{
    use RefreshDatabase;
    
    protected $reportService;
    protected $store;
    
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->reportService = app(ReportService::class);
        
        $setup = $this->createStoreWithAdmin();
        $this->store = $setup['store'];
    }
    
    /** @test */
    public function test_generate_monthly_report()
    {
        // Create products
        $product1 = Product::factory()->create(['store_id' => $this->store->id, 'price' => 50000, 'stock' => 100]);
        $product2 = Product::factory()->create(['store_id' => $this->store->id, 'price' => 75000, 'stock' => 100]);
        
        // Create transactions for current month
        $saleService = app(\App\Services\SaleService::class);
        $saleService->processSale($this->store->id, [['product_id' => $product1->id, 'quantity' => 2]], 'cash', 100000);
        $saleService->processSale($this->store->id, [['product_id' => $product2->id, 'quantity' => 1]], 'transfer', 75000);
        
        $report = $this->reportService->generateMonthlyReport($this->store->id, now()->format('Y-m'));
        
        $this->assertEquals(175000, $report['summary']['total_revenue']);
        $this->assertEquals(3, $report['summary']['total_products_sold']);
        $this->assertEquals(2, $report['summary']['total_transactions']);
        $this->assertEquals(87500, $report['summary']['average_transaction']);
    }
    
    /** @test */
    public function test_get_daily_breakdown()
    {
        $product = Product::factory()->create(['store_id' => $this->store->id, 'price' => 50000, 'stock' => 100]);
        
        $saleService = app(\App\Services\SaleService::class);
        $saleService->processSale($this->store->id, [['product_id' => $product->id, 'quantity' => 1]], 'cash', 50000);
        
        $breakdown = $this->reportService->getDailyBreakdown(
            $this->store->id,
            now()->startOfMonth()->format('Y-m-d H:i:s'),
            now()->endOfMonth()->format('Y-m-d H:i:s')
        );
        
        $this->assertNotEmpty($breakdown);
        $this->assertEquals(1, $breakdown->first()->count);
        $this->assertEquals(50000, $breakdown->first()->revenue);
    }
    
    /** @test */
    public function test_get_weekly_trend()
    {
        $product = Product::factory()->create(['store_id' => $this->store->id, 'price' => 50000, 'stock' => 100]);
        
        $saleService = app(\App\Services\SaleService::class);
        $saleService->processSale($this->store->id, [['product_id' => $product->id, 'quantity' => 1]], 'cash', 50000);
        
        $trend = $this->reportService->getWeeklyTrend(
            $this->store->id,
            now()->startOfMonth()->format('Y-m-d H:i:s'),
            now()->endOfMonth()->format('Y-m-d H:i:s')
        );
        
        $this->assertNotEmpty($trend);
        $this->assertArrayHasKey('week_number', $trend[0]);
        $this->assertArrayHasKey('revenue', $trend[0]);
        $this->assertArrayHasKey('transaction_count', $trend[0]);
    }
    
    /** @test */
    public function test_get_top_products()
    {
        $product1 = Product::factory()->create(['store_id' => $this->store->id, 'name' => 'Product A', 'price' => 50000, 'stock' => 100]);
        $product2 = Product::factory()->create(['store_id' => $this->store->id, 'name' => 'Product B', 'price' => 50000, 'stock' => 100]);
        
        $saleService = app(\App\Services\SaleService::class);
        $saleService->processSale($this->store->id, [['product_id' => $product1->id, 'quantity' => 5]], 'cash', 250000);
        $saleService->processSale($this->store->id, [['product_id' => $product2->id, 'quantity' => 2]], 'cash', 100000);
        
        $topProducts = $this->reportService->getTopProducts(
            $this->store->id,
            now()->startOfMonth()->format('Y-m-d H:i:s'),
            now()->endOfMonth()->format('Y-m-d H:i:s')
        );
        
        $this->assertEquals(2, $topProducts->count());
        $this->assertEquals('Product A', $topProducts->first()->name);
        $this->assertEquals(5, $topProducts->first()->total_sold);
    }
    
    /** @test */
    public function test_get_inventory_report()
    {
        // Create products with various stock levels
        Product::factory()->create(['store_id' => $this->store->id, 'stock' => 0, 'min_stock_alert' => 5]);
        Product::factory()->create(['store_id' => $this->store->id, 'stock' => 2, 'min_stock_alert' => 5]);
        Product::factory()->create(['store_id' => $this->store->id, 'stock' => 10, 'min_stock_alert' => 5]);
        Product::factory()->create(['store_id' => $this->store->id, 'stock' => 20, 'min_stock_alert' => 5]);
        
        $report = $this->reportService->getInventoryReport($this->store->id);
        
        $this->assertEquals(4, $report['summary']['total_products']);
        $this->assertEquals(32, $report['summary']['total_stock_quantity']);
        $this->assertEquals(1, $report['summary']['low_stock_count']);
        $this->assertEquals(1, $report['summary']['out_of_stock_count']);
        $this->assertCount(1, $report['low_stock_products']);
        $this->assertCount(1, $report['out_of_stock_products']);
    }
    
    /** @test */
    public function test_monthly_report_only_includes_completed_transactions()
    {
        $product = Product::factory()->create(['store_id' => $this->store->id, 'price' => 50000, 'stock' => 100]);
        
        $saleService = app(\App\Services\SaleService::class);
        $saleService->processSale($this->store->id, [['product_id' => $product->id, 'quantity' => 1]], 'cash', 50000);
        
        // Create pending transaction (should not be included)
        Transaction::create([
            'store_id' => $this->store->id,
            'invoice_number' => 'PENDING-001',
            'total_amount' => 100000,
            'paid_amount' => 0,
            'payment_method' => 'transfer',
            'status' => 'pending',
            'transaction_date' => now(),
        ]);
        
        $report = $this->reportService->generateMonthlyReport($this->store->id, now()->format('Y-m'));
        
        $this->assertEquals(50000, $report['summary']['total_revenue']);
        $this->assertEquals(1, $report['summary']['total_transactions']);
    }
}