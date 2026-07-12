<?php
// app/Http/Controllers/Public/CatalogController.php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CatalogController extends Controller
{
    /**
     * Show store homepage / catalog
     */
    public function showStore($slug)
    {
        $store = Store::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
        
        // Get featured products (in stock, active)
        $featuredProducts = Product::where('store_id', $store->id)
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();
        
        // Get categories with product counts
        $categories = Category::where('store_id', $store->id)
            ->withCount(['products' => function($query) {
                $query->where('is_active', true)->where('stock', '>', 0);
            }])
            ->having('products_count', '>', 0)
            ->get();
        
        // Get store settings
        $settings = json_decode($store->settings, true) ?? [];
        
        return view('catalog.store', compact(
            'store', 
            'featuredProducts', 
            'categories',
            'settings'
        ));
    }
    
    /**
     * Show product detail
     */
    public function showProduct($slug, $productSlug)
    {
        $store = Store::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
        
        $product = Product::where('store_id', $store->id)
            ->where('slug', $productSlug)
            ->where('is_active', true)
            ->firstOrFail();
        
        // Get related products (same category)
        $relatedProducts = Product::where('store_id', $store->id)
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->where('id', '!=', $product->id)
            ->when($product->category_id, function($query) use ($product) {
                return $query->where('category_id', $product->category_id);
            })
            ->limit(4)
            ->get();
        
        // Increment view count (optional)
        $product->increment('views_count');
        
        return view('catalog.product', compact('store', 'product', 'relatedProducts'));
    }
    
    /**
     * Show products by category
     */
    public function showCategory($slug, $categorySlug)
    {
        $store = Store::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
        
        $category = Category::where('store_id', $store->id)
            ->where('slug', $categorySlug)
            ->firstOrFail();
        
        $products = Product::where('store_id', $store->id)
            ->where('category_id', $category->id)
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->orderBy('name')
            ->paginate(12);
        
        $categories = Category::where('store_id', $store->id)
            ->withCount('products')
            ->get();
        
        return view('catalog.category', compact('store', 'category', 'products', 'categories'));
    }
    
    /**
     * Search products in store
     */
    public function search(Request $request, $slug)
    {
        $store = Store::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
        
        $query = $request->get('q');
        $categoryId = $request->get('category');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');
        $sortBy = $request->get('sort', 'name');
        
        $products = Product::where('store_id', $store->id)
            ->where('is_active', true)
            ->when($query, function($q) use ($query) {
                return $q->where('name', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            })
            ->when($categoryId, function($q) use ($categoryId) {
                return $q->where('category_id', $categoryId);
            })
            ->when($minPrice, function($q) use ($minPrice) {
                return $q->where('price', '>=', $minPrice);
            })
            ->when($maxPrice, function($q) use ($maxPrice) {
                return $q->where('price', '<=', $maxPrice);
            })
            ->when($sortBy == 'price_asc', function($q) {
                return $q->orderBy('price', 'asc');
            })
            ->when($sortBy == 'price_desc', function($q) {
                return $q->orderBy('price', 'desc');
            })
            ->when($sortBy == 'name', function($q) {
                return $q->orderBy('name', 'asc');
            })
            ->when($sortBy == 'newest', function($q) {
                return $q->orderBy('created_at', 'desc');
            })
            ->paginate(12);
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $products
            ]);
        }
        
        $categories = Category::where('store_id', $store->id)
            ->withCount('products')
            ->get();
        
        return view('catalog.search', compact('store', 'products', 'categories', 'query'));
    }
    
    /**
     * Get products via API (AJAX)
     */
    public function getProducts(Request $request, $slug)
    {
        $store = Store::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
        
        $products = Product::where('store_id', $store->id)
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->when($request->search, function($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->when($request->min_price, function($query, $minPrice) {
                return $query->where('price', '>=', $minPrice);
            })
            ->when($request->max_price, function($query, $maxPrice) {
                return $query->where('price', '<=', $maxPrice);
            })
            ->when($request->category_id, function($query, $categoryId) {
                return $query->where('category_id', $categoryId);
            })
            ->orderBy($request->sort_by ?? 'name', $request->sort_order ?? 'asc')
            ->paginate($request->per_page ?? 12);
        
        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }
}