<?php
// app/Http/Controllers/Public/CartController.php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Show cart page
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('catalog.cart', compact('cart', 'total'));
    }
    
    /**
     * Add item to cart
     */
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $product = Product::find($request->product_id);
        
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }
        
        if ($product->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi. Stok tersedia: ' . $product->stock
            ], 422);
        }
        
        $cart = session()->get('cart', []);
        $productId = $request->product_id;
        
        if (isset($cart[$productId])) {
            $newQuantity = $cart[$productId]['quantity'] + $request->quantity;
            if ($newQuantity > $product->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak mencukupi. Stok tersedia: ' . $product->stock
                ], 422);
            }
            $cart[$productId]['quantity'] = $newQuantity;
        } else {
            $cart[$productId] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->quantity,
                'max_stock' => $product->stock,
                'image' => $product->image
            ];
        }
        
        session()->put('cart', $cart);
        
        return response()->json([
            'success' => true,
            'message' => 'Produk ditambahkan ke keranjang',
            'data' => [
                'count' => $this->getCartCount(),
                'cart' => $cart
            ]
        ]);
    }
    
    /**
     * Update cart item quantity
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $cart = session()->get('cart', []);
        
        if (!isset($cart[$id])) {
            return response()->json([
                'success' => false,
                'message' => 'Item tidak ditemukan di keranjang'
            ], 404);
        }
        
        $product = Product::find($id);
        if ($product && $request->quantity > $product->stock) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi. Stok tersedia: ' . $product->stock
            ], 422);
        }
        
        $cart[$id]['quantity'] = $request->quantity;
        session()->put('cart', $cart);
        
        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil diupdate',
            'data' => [
                'count' => $this->getCartCount(),
                'cart' => $cart
            ]
        ]);
    }
    
    /**
     * Remove item from cart
     */
    public function remove($id)
    {
        $cart = session()->get('cart', []);
        
        if (!isset($cart[$id])) {
            return response()->json([
                'success' => false,
                'message' => 'Item tidak ditemukan di keranjang'
            ], 404);
        }
        
        unset($cart[$id]);
        session()->put('cart', $cart);
        
        return response()->json([
            'success' => true,
            'message' => 'Item berhasil dihapus dari keranjang',
            'data' => [
                'count' => $this->getCartCount()
            ]
        ]);
    }
    
    /**
     * Checkout - process cart
     */
    public function checkout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'payment_method' => 'required|in:cash,transfer,qris'
        ]);
        
        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Keranjang kosong'
                ], 422);
            }
            return redirect()->route('catalog.cart')->with('error', 'Keranjang kosong');
        }
        
        // Calculate total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        // Here you can create order in database
        // $order = Order::create([...]);
        
        // Clear cart after checkout
        session()->forget('cart');
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat!',
                'data' => [
                    'order_id' => 'ORD-' . uniqid(),
                    'total' => $total
                ]
            ]);
        }
        
        return redirect()->route('landing')->with('success', 'Pesanan berhasil dibuat!');
    }
    
    /**
     * Get cart count
     */
    public function getCount()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'count' => $this->getCartCount()
            ]
        ]);
    }
    
    /**
     * Get cart items (for API)
     */
    public function getCart()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        $items = [];
        
        foreach ($cart as $id => $item) {
            $subtotal = $item['price'] * $item['quantity'];
            $total += $subtotal;
            $items[] = [
                'product_id' => $id,
                'name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'subtotal' => $subtotal,
                'max_stock' => $item['max_stock'] ?? 999
            ];
        }
        
        return response()->json([
            'success' => true,
            'data' => [
                'items' => $items,
                'total' => $total,
                'count' => count($cart),
                'total_items' => $this->getCartCount()
            ]
        ]);
    }
    
    /**
     * Clear cart
     */
    public function clearCart()
    {
        session()->forget('cart');
        
        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil dikosongkan'
        ]);
    }
    
    /**
     * Get cart count helper
     */
    private function getCartCount()
    {
        $cart = session()->get('cart', []);
        return array_sum(array_column($cart, 'quantity'));
    }
    
    /**
     * Add to cart via AJAX (API)
     */
    public function addToCart(Request $request)
    {
        return $this->add($request);
    }
    
    /**
     * Update cart item (API)
     */
    public function updateCartItem(Request $request, $id)
    {
        return $this->update($request, $id);
    }
    
    /**
     * Remove from cart (API)
     */
    public function removeFromCart($id)
    {
        return $this->remove($id);
    }
}