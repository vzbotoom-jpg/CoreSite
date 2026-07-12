<?php
// tests/Feature/TenantTest.php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TenantTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function store_can_be_accessed_via_slug()
    {
        $store = Store::factory()->create([
            'slug' => 'toko-test',
            'is_active' => true,
        ]);
        
        $product = Product::factory()->create([
            'store_id' => $store->id,
            'is_active' => true,
        ]);
        
        $response = $this->get('/toko-test');
        
        $response->assertStatus(200);
        $response->assertSee($store->name);
    }
    
    /** @test */
    public function inactive_store_returns_404()
    {
        $store = Store::factory()->create([
            'slug' => 'toko-test',
            'is_active' => false,
        ]);
        
        $response = $this->get('/toko-test');
        
        $response->assertStatus(404);
    }
    
    /** @test */
    public function non_existent_store_returns_404()
    {
        $response = $this->get('/non-existent-store');
        
        $response->assertStatus(404);
    }
    
    /** @test */
    public function product_can_be_accessed_via_store_slug_and_product_slug()
    {
        $store = Store::factory()->create([
            'slug' => 'toko-test',
            'is_active' => true,
        ]);
        
        $product = Product::factory()->create([
            'store_id' => $store->id,
            'slug' => 'produk-test',
            'is_active' => true,
        ]);
        
        $response = $this->get('/toko-test/product/produk-test');
        
        $response->assertStatus(200);
        $response->assertSee($product->name);
    }
    
    /** @test */
    public function category_can_be_accessed_via_store_slug_and_category_slug()
    {
        $store = Store::factory()->create([
            'slug' => 'toko-test',
            'is_active' => true,
        ]);
        
        $category = \App\Models\Category::factory()->create([
            'store_id' => $store->id,
            'slug' => 'kategori-test',
            'is_active' => true,
        ]);
        
        $response = $this->get('/toko-test/category/kategori-test');
        
        $response->assertStatus(200);
        $response->assertSee($category->name);
    }
    
    /** @test */
    public function user_can_only_access_own_store_data()
    {
        // Create two stores
        $store1 = Store::factory()->create();
        $user1 = \App\Models\User::factory()->admin()->create(['store_id' => $store1->id]);
        
        $store2 = Store::factory()->create();
        $user2 = \App\Models\User::factory()->admin()->create(['store_id' => $store2->id]);
        
        // Create products for each store
        Product::factory()->create(['store_id' => $store1->id]);
        Product::factory()->create(['store_id' => $store2->id]);
        
        // User1 tries to access products
        $response = $this->actingAs($user1)
            ->get(route('admin.products.index'));
        
        $products = $response->viewData('products');
        $this->assertEquals(1, $products->total());
        $this->assertEquals($store1->id, $products->first()->store_id);
    }
    
    /** @test */
    public function tenant_middleware_sets_store_context()
    {
        $store = Store::factory()->create([
            'slug' => 'toko-test',
            'is_active' => true,
        ]);
        
        $response = $this->get('/toko-test');
        
        $response->assertViewHas('tenant_store', function ($viewStore) use ($store) {
            return $viewStore->id === $store->id;
        });
    }
}