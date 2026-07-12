<?php
// database/seeders/ProductSeeder.php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Get the demo store
        $demoStore = Store::where('slug', 'demo')->first();
        
        if ($demoStore) {
            // Create categories for demo store
            $categories = [
                ['name' => 'Elektronik', 'description' => 'Produk elektronik berkualitas'],
                ['name' => 'Fashion', 'description' => 'Pakaian dan aksesoris fashion'],
                ['name' => 'Makanan', 'description' => 'Makanan dan minuman'],
                ['name' => 'Perlengkapan Rumah', 'description' => 'Perabotan rumah tangga'],
                ['name' => 'Olahraga', 'description' => 'Perlengkapan olahraga'],
            ];
            
            $createdCategories = [];
            foreach ($categories as $cat) {
                $createdCategories[] = Category::create([
                    'store_id' => $demoStore->id,
                    'name' => $cat['name'],
                    'slug' => \Illuminate\Support\Str::slug($cat['name']),
                    'description' => $cat['description'],
                    'is_active' => true,
                ]);
            }
            
            // Create products for demo store
            $products = [
                [
                    'name' => 'Smartphone Xiaomi',
                    'price' => 2500000,
                    'stock' => 15,
                    'min_stock_alert' => 5,
                    'category_index' => 0,
                ],
                [
                    'name' => 'Kemeja Pria Lengan Panjang',
                    'price' => 150000,
                    'stock' => 30,
                    'min_stock_alert' => 10,
                    'category_index' => 1,
                ],
                [
                    'name' => 'Keripik Singkong Pedas',
                    'price' => 15000,
                    'stock' => 100,
                    'min_stock_alert' => 20,
                    'category_index' => 2,
                ],
                [
                    'name' => 'Panci Set 3 pcs',
                    'price' => 250000,
                    'stock' => 8,
                    'min_stock_alert' => 3,
                    'category_index' => 3,
                ],
                [
                    'name' => 'Yoga Mat Premium',
                    'price' => 180000,
                    'stock' => 12,
                    'min_stock_alert' => 4,
                    'category_index' => 4,
                ],
                [
                    'name' => 'Headphone Bluetooth',
                    'price' => 350000,
                    'stock' => 20,
                    'min_stock_alert' => 5,
                    'category_index' => 0,
                ],
                [
                    'name' => 'Dress Wanita Casual',
                    'price' => 200000,
                    'stock' => 25,
                    'min_stock_alert' => 8,
                    'category_index' => 1,
                ],
                [
                    'name' => 'Kopi Arabika 250gr',
                    'price' => 75000,
                    'stock' => 50,
                    'min_stock_alert' => 10,
                    'category_index' => 2,
                ],
            ];
            
            foreach ($products as $product) {
                Product::create([
                    'store_id' => $demoStore->id,
                    'category_id' => $createdCategories[$product['category_index']]->id,
                    'name' => $product['name'],
                    'slug' => \Illuminate\Support\Str::slug($product['name']),
                    'description' => 'Deskripsi untuk produk ' . $product['name'],
                    'price' => $product['price'],
                    'stock' => $product['stock'],
                    'min_stock_alert' => $product['min_stock_alert'],
                    'is_active' => true,
                ]);
            }
        }
        
        // Create products for all stores using factory
        $stores = Store::where('is_active', true)->get();
        
        foreach ($stores as $store) {
            // Create categories for each store
            $categories = Category::factory(3)->create(['store_id' => $store->id]);
            
            // Create products for each category
            foreach ($categories as $category) {
                Product::factory(10)->create([
                    'store_id' => $store->id,
                    'category_id' => $category->id,
                ]);
            }
            
            // Create some low stock products
            Product::factory(2)->lowStock()->create([
                'store_id' => $store->id,
            ]);
            
            // Create some out of stock products
            Product::factory(2)->outOfStock()->create([
                'store_id' => $store->id,
            ]);
        }
    }
}