<?php
// app/Http/Controllers/Admin/ProductController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\InventoryLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display list of products
     */
    public function index(Request $request)
    {
        $storeId = auth()->user()->store_id;
        
        $query = Product::where('store_id', $storeId);
        
        // Apply filters
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }
        
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
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
        
        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        
        $products = $query->paginate($request->get('per_page', 15));
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $products
            ]);
        }
        
        $categories = Category::where('store_id', $storeId)->get();
        
        return view('admin.products.index', compact('products', 'categories'));
    }
    
    /**
     * Show form to create new product
     */
    public function create()
    {
        $storeId = auth()->user()->store_id;
        $categories = Category::where('store_id', $storeId)->get();
        
        return view('admin.products.create', compact('categories'));
    }
    
    /**
     * Store new product
     */
    public function store(Request $request)
    {
        $storeId = auth()->user()->store_id;
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock_alert' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:2048'
        ]);
        
        try {
            DB::beginTransaction();
            
            // Generate unique slug
            $slug = Str::slug($validated['name']);
            $originalSlug = $slug;
            $counter = 1;
            while (Product::where('store_id', $storeId)->where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            
            // Handle image upload
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store("stores/{$storeId}/products", 'public');
            }
            
            // Create product
            $product = Product::create([
                'store_id' => $storeId,
                'name' => $validated['name'],
                'slug' => $slug,
                'description' => $validated['description'] ?? null,
                'price' => $validated['price'],
                'stock' => $validated['stock'],
                'min_stock_alert' => $validated['min_stock_alert'],
                'category_id' => $validated['category_id'] ?? null,
                'is_active' => $validated['is_active'] ?? true,
                'image' => $imagePath
            ]);
            
            // Create inventory log for initial stock
            if ($validated['stock'] > 0) {
                InventoryLog::create([
                    'store_id' => $storeId,
                    'product_id' => $product->id,
                    'type' => 'restock',
                    'quantity' => $validated['stock'],
                    'old_stock' => 0,
                    'new_stock' => $validated['stock'],
                    'notes' => 'Initial stock on product creation'
                ]);
            }
            
            DB::commit();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product created successfully',
                    'data' => $product
                ], 201);
            }
            
            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil ditambahkan');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'error' => $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Gagal menambahkan produk: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    /**
     * Show product details
     */
    public function show($id)
    {
        $storeId = auth()->user()->store_id;
        
        $product = Product::where('store_id', $storeId)
            ->with(['category', 'inventoryLogs' => function($query) {
                $query->latest()->limit(20);
            }])
            ->findOrFail($id);
        
        return view('admin.products.show', compact('product'));
    }
    
    /**
     * Show form to edit product
     */
    public function edit($id)
    {
        $storeId = auth()->user()->store_id;
        
        $product = Product::where('store_id', $storeId)->findOrFail($id);
        $categories = Category::where('store_id', $storeId)->get();
        
        return view('admin.products.edit', compact('product', 'categories'));
    }
    
    /**
     * Update product
     */
    public function update(Request $request, $id)
    {
        $storeId = auth()->user()->store_id;
        
        $product = Product::where('store_id', $storeId)->findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'min_stock_alert' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:2048'
        ]);
        
        try {
            DB::beginTransaction();
            
            // Update slug if name changed
            if ($product->name !== $validated['name']) {
                $slug = Str::slug($validated['name']);
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
            
            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($product->image) {
                    \Storage::disk('public')->delete($product->image);
                }
                $product->image = $request->file('image')->store("stores/{$storeId}/products", 'public');
            }
            
            // Update product
            $product->update([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'price' => $validated['price'],
                'min_stock_alert' => $validated['min_stock_alert'],
                'category_id' => $validated['category_id'] ?? null,
                'is_active' => $validated['is_active'] ?? true,
            ]);
            
            DB::commit();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product updated successfully',
                    'data' => $product
                ]);
            }
            
            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil diupdate');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'error' => $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Gagal mengupdate produk: ' . $e->getMessage());
        }
    }
    
    /**
     * Adjust stock manually
     */
    public function adjustStock(Request $request, $id)
    {
        $storeId = auth()->user()->store_id;
        
        $request->validate([
            'quantity' => 'required|integer|not_in:0',
            'notes' => 'nullable|string'
        ]);
        
        $product = Product::where('store_id', $storeId)->findOrFail($id);
        
        try {
            DB::beginTransaction();
            
            $oldStock = $product->stock;
            $newStock = $oldStock + $request->quantity;
            
            if ($newStock < 0) {
                throw new \Exception('Stok tidak boleh negatif');
            }
            
            $product->stock = $newStock;
            $product->save();
            
            InventoryLog::create([
                'store_id' => $storeId,
                'product_id' => $product->id,
                'type' => $request->quantity > 0 ? 'restock' : 'adjustment',
                'quantity' => $request->quantity,
                'old_stock' => $oldStock,
                'new_stock' => $newStock,
                'notes' => $request->notes ?? 'Manual stock adjustment'
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Stock adjusted successfully',
                'data' => [
                    'old_stock' => $oldStock,
                    'new_stock' => $newStock
                ]
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 422);
        }
    }
    
    /**
     * Delete product
     */
    public function destroy($id)
    {
        $storeId = auth()->user()->store_id;
        
        $product = Product::where('store_id', $storeId)->findOrFail($id);
        
        try {
            // Check if product has transactions
            if ($product->transactionItems()->exists()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Produk tidak dapat dihapus karena sudah memiliki transaksi'
                ], 422);
            }
            
            // Delete image if exists
            if ($product->image) {
                \Storage::disk('public')->delete($product->image);
            }
            
            $product->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Import products from Excel/CSV
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv,xls'
        ]);
        
        // Implementation for Excel import
        // You'll need to add Maatwebsite/Excel package
        
        return back()->with('success', 'Products imported successfully');
    }
    
    /**
     * Export products to Excel
     */
    public function export(Request $request)
    {
        $storeId = auth()->user()->store_id;
        
        $products = Product::where('store_id', $storeId)->get();
        
        // Implementation for Excel export
        // You'll need to add Maatwebsite/Excel package
        
        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }
}