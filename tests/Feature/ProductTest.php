<?php
// tests/Feature/ProductTest.php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
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
    public function test_admin_can_view_products_list()
    {
        Product::factory(5)->create(['store_id' => $this->store->id]);
        
        $response = $this->actingAs($this->user)
            ->get(route('admin.products.index'));
        
        $response->assertStatus(200);
        $response->assertViewHas('products');
    }
    
    /** @test */
    public function test_admin_can_create_product()
    {
        $category = Category::factory()->create(['store_id' => $this->store->id]);
        
        $productData = [
            'name' => 'Product Test',
            'category_id' => $category->id,
            'description' => 'This is a test product',
            'price' => 100000,
            'stock' => 50,
            'min_stock_alert' => 10,
            'is_active' => true,
        ];
        
        $response = $this->actingAs($this->user)
            ->post(route('admin.products.store'), $productData);
        
        $response->assertRedirect(route('admin.products.index'));
        
        $this->assertDatabaseHas('products', [
            'name' => 'Product Test',
            'store_id' => $this->store->id,
            'price' => 100000,
        ]);
    }
    
    /** @test */
    public function test_product_requires_name_and_price()
    {
        $response = $this->actingAs($this->user)
            ->post(route('admin.products.store'), [
                'name' => '',
                'price' => '',
            ]);
        
        $response->assertSessionHasErrors(['name', 'price']);
    }
    
    /** @test */
    public function test_admin_can_view_product_detail()
    {
        $product = Product::factory()->create(['store_id' => $this->store->id]);
        
        $response = $this->actingAs($this->user)
            ->get(route('admin.products.show', $product));
        
        $response->assertStatus(200);
        $response->assertViewHas('product', $product);
    }
    
    /** @test */
    public function test_admin_can_update_product()
    {
        $product = Product::factory()->create([
            'store_id' => $this->store->id,
            'name' => 'Old Name',
        ]);
        
        $response = $this->actingAs($this->user)
            ->put(route('admin.products.update', $product), [
                'name' => 'Updated Name',
                'price' => 200000,
                'min_stock_alert' => 5,
                'is_active' => true,
            ]);
        
        $response->assertRedirect(route('admin.products.index'));
        
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Name',
            'price' => 200000,
        ]);
    }
    
    /** @test */
    public function test_admin_can_delete_product()
    {
        $product = Product::factory()->create(['store_id' => $this->store->id]);
        
        $response = $this->actingAs($this->user)
            ->delete(route('admin.products.destroy', $product));
        
        $response->assertStatus(200);
        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }
    
    /** @test */
    public function test_admin_can_adjust_product_stock()
    {
        $product = Product::factory()->create([
            'store_id' => $this->store->id,
            'stock' => 10,
        ]);
        
        $response = $this->actingAs($this->user)
            ->post(route('admin.products.adjust-stock', $product), [
                'quantity' => 5,
                'notes' => 'Restock product',
            ]);
        
        $response->assertStatus(200);
        
        $product->refresh();
        $this->assertEquals(15, $product->stock);
        
        $this->assertDatabaseHas('inventory_logs', [
            'product_id' => $product->id,
            'quantity' => 5,
            'type' => 'restock',
        ]);
    }
    
    /** @test */
    public function test_cannot_reduce_stock_below_zero()
    {
        $product = Product::factory()->create([
            'store_id' => $this->store->id,
            'stock' => 5,
        ]);
        
        $response = $this->actingAs($this->user)
            ->post(route('admin.products.adjust-stock', $product), [
                'quantity' => -10,
                'notes' => 'Reduce stock',
            ]);
        
        $response->assertStatus(422);
        
        $product->refresh();
        $this->assertEquals(5, $product->stock);
    }
    
    /** @test */
    public function test_products_are_scoped_by_store()
    {
        // Create product for current store
        Product::factory()->create(['store_id' => $this->store->id]);
        
        // Create another store
        $otherSetup = $this->createStoreWithAdmin();
        Product::factory()->create(['store_id' => $otherSetup['store']->id]);
        
        $products = Product::where('store_id', $this->store->id)->get();
        
        $this->assertEquals(1, $products->count());
        $this->assertNotEquals($otherSetup['store']->id, $products->first()->store_id);
    }
}