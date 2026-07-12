<?php
// app/Http/Controllers/Api/V1/ProductApiController.php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\InventoryLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductApiController extends Controller
{
    /**
     * Get all products for authenticated store
     */
    public function index(Request $request)
    {
        $storeId = $request->user()->store_id;
        
        $query = Product::where('store_id', $storeId);
        
        // Apply filters
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        
        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }
        
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        
        if ($request->filled('stock_status')) {
            switch ($request->stock_status) {
                case 'low':
                    $query->whereRaw('stock <= min_stock_alert')->where('stock', '>', 0);
                    break;
                case 'out':
                    $query->where('stock', 0);
                    break;
                case 'safe':
                    $query->whereRaw('stock > min_stock_alert');
                    break;
            }
        }
        
        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        
        $products = $query->with('category')->paginate($request->get('per_page', 15));
        
        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }
    
    /**
     * Get single product
     */
    public function show(Request $request, $id)
    {
        $storeId = $request->user()->store_id;
        
        $product = Product::where('store_id', $storeId)
            ->with(['category', 'inventoryLogs' => function($query) {
                $query->latest()->limit(20);
            }])
            ->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }
    
    /**
     * Create new product
     */
    public function store(Request $request)
    {
        $storeId = $request->user()->store_id;
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock_alert' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'is_active' => 'boolean',
            'image' => 'nullable|string|url' // For API, accept URL or base64
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        try {
            DB::beginTransaction();
            
            // Generate unique slug
            $slug = Str::slug($request->name);
            $originalSlug = $slug;
            $counter = 1;
            while (Product::where('store_id', $storeId)->where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            
            $product = Product::create([
                'store_id' => $storeId,
                'name' => $request->name,
                'slug' => $slug,
                'description' => $request->description,
                'price' => $request->price,
                'stock' => $request->stock,
                'min_stock_alert' => $request->min_stock_alert,
                'category_id' => $request->category_id,
                'is_active' => $request->is_active ?? true,
                'image' => $request->image
            ]);
            
            // Create inventory log for initial stock
            if ($request->stock > 0) {
                InventoryLog::create([
                    'store_id' => $storeId,
                    'product_id' => $product->id,
                    'type' => 'restock',
                    'quantity' => $request->stock,
                    'old_stock' => 0,
                    'new_stock' => $request->stock,
                    'notes' => 'Initial stock via API'
                ]);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Product created successfully',
                'data' => $product
            ], 201);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create product: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Update product
     */
    public function update(Request $request, $id)
    {
        $storeId = $request->user()->store_id;
        
        $product = Product::where('store_id', $storeId)->findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric|min:0',
            'min_stock_alert' => 'sometimes|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'is_active' => 'boolean',
            'image' => 'nullable|string|url'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        try {
            // Update slug if name changed
            if ($request->has('name') && $product->name !== $request->name) {
                $slug = Str::slug($request->name);
                $originalSlug = $slug;
                $counter = 1;
                while (Product::where('store_id', $storeId)
                    ->where('slug', $slug)
                    ->where('id', '!=', $product->id)
                    ->exists()
                ) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
                $product->slug = $slug;
            }
            
            $product->update($request->only([
                'name', 'description', 'price', 'min_stock_alert', 
                'category_id', 'is_active', 'image'
            ]));
            
            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully',
                'data' => $product->fresh()
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Adjust product stock
     */
    public function adjustStock(Request $request, $id)
    {
        $storeId = $request->user()->store_id;
        
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|not_in:0',
            'type' => 'required|in:add,subtract,set',
            'notes' => 'nullable|string'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        $product = Product::where('store_id', $storeId)->findOrFail($id);
        
        try {
            DB::beginTransaction();
            
            $oldStock = $product->stock;
            
            switch ($request->type) {
                case 'add':
                    $newStock = $oldStock + $request->quantity;
                    $logType = 'restock';
                    break;
                case 'subtract':
                    $newStock = $oldStock - $request->quantity;
                    $logType = 'adjustment';
                    if ($newStock < 0) {
                        throw new \Exception('Stock cannot be negative');
                    }
                    break;
                case 'set':
                    $newStock = $request->quantity;
                    $logType = 'adjustment';
                    if ($newStock < 0) {
                        throw new \Exception('Stock cannot be negative');
                    }
                    break;
                default:
                    throw new \Exception('Invalid adjustment type');
            }
            
            $product->stock = $newStock;
            $product->save();
            
            InventoryLog::create([
                'store_id' => $storeId,
                'product_id' => $product->id,
                'type' => $logType,
                'quantity' => $request->quantity,
                'old_stock' => $oldStock,
                'new_stock' => $newStock,
                'notes' => $request->notes ?? 'Stock adjustment via API'
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Stock adjusted successfully',
                'data' => [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'old_stock' => $oldStock,
                    'new_stock' => $newStock,
                    'adjustment' => $request->quantity,
                    'adjustment_type' => $request->type
                ]
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
    
    /**
     * Delete product
     */
    public function destroy(Request $request, $id)
    {
        $storeId = $request->user()->store_id;
        
        $product = Product::where('store_id', $storeId)->findOrFail($id);
        
        // Check if product has transactions
        if ($product->transactionItems()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete product that has transaction records'
            ], 422);
        }
        
        $product->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully'
        ]);
    }
    
    /**
     * Get categories for store
     */
    public function getCategories(Request $request)
    {
        $storeId = $request->user()->store_id;
        
        $categories = Category::where('store_id', $storeId)
            ->withCount('products')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }
    
    /**
     * Create category
     */
    public function createCategory(Request $request)
    {
        $storeId = $request->user()->store_id;
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $counter = 1;
        while (Category::where('store_id', $storeId)->where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        $category = Category::create([
            'store_id' => $storeId,
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'parent_id' => $request->parent_id
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Category created successfully',
            'data' => $category
        ], 201);
    }
    
    /**
     * Get inventory logs
     */
    public function getInventoryLogs(Request $request)
    {
        $storeId = $request->user()->store_id;
        
        $logs = InventoryLog::where('store_id', $storeId)
            ->with('product')
            ->when($request->product_id, function($query, $productId) {
                return $query->where('product_id', $productId);
            })
            ->when($request->type, function($query, $type) {
                return $query->where('type', $type);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 30));
        
        return response()->json([
            'success' => true,
            'data' => $logs
        ]);
    }
}