<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\SalesOrder;
use App\Models\SalesOrderItem;
use App\Models\WarehouseStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Add product to cart
     */
    public function add(Request $request)
    {
        // Check if request is AJAX
        if ($request->expectsJson()) {
            return $this->addAjax($request);
        }
        
        // Handle form submission
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        
        // Check if product is active
        if (!$product->is_active) {
            return redirect()->back()->with('error', 'Produk tidak tersedia');
        }

        // Check stock
        $totalStock = $product->warehouseStocks->sum('quantity') ?? 0;
        if ($totalStock < $validated['quantity']) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi');
        }

        $unitPrice = $product->selling_price;
        $subtotal = $unitPrice * $validated['quantity'];

        // Check if product already in cart
        $existingCart = Cart::forUser(Auth::id())
            ->where('product_id', $validated['product_id'])
            ->first();

        if ($existingCart) {
            // Update quantity
            $newQuantity = $existingCart->quantity + $validated['quantity'];
            
            // Check stock again
            if ($totalStock < $newQuantity) {
                return redirect()->back()->with('error', 'Stok tidak mencukupi untuk menambah quantity');
            }

            $existingCart->update([
                'quantity' => $newQuantity,
                'subtotal' => $unitPrice * $newQuantity,
            ]);

            return redirect()->back()->with('success', 'Quantity keranjang diperbarui');
        }

        // Add new item to cart
        Cart::create([
            'user_id' => Auth::id(),
            'product_id' => $validated['product_id'],
            'quantity' => $validated['quantity'],
            'unit_price' => $unitPrice,
            'subtotal' => $subtotal,
        ]);

        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang');
    }
    
    /**
     * Add product to cart (AJAX)
     */
    private function addAjax(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        
        // Check if product is active
        if (!$product->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak tersedia'
            ], 400);
        }

        // Check stock
        $totalStock = $product->warehouseStocks->sum('quantity') ?? 0;
        if ($totalStock < $validated['quantity']) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi'
            ], 400);
        }

        $unitPrice = $product->selling_price;
        $subtotal = $unitPrice * $validated['quantity'];

        // Check if product already in cart
        $existingCart = Cart::forUser(Auth::id())
            ->where('product_id', $validated['product_id'])
            ->first();

        if ($existingCart) {
            // Update quantity
            $newQuantity = $existingCart->quantity + $validated['quantity'];
            
            // Check stock again
            if ($totalStock < $newQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak mencukupi untuk menambah quantity'
                ], 400);
            }

            $existingCart->update([
                'quantity' => $newQuantity,
                'subtotal' => $unitPrice * $newQuantity,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Quantity keranjang diperbarui',
                'cart_count' => Cart::forUser(Auth::id())->count(),
                'cart_total' => Cart::forUser(Auth::id())->sum('subtotal'),
            ]);
        }

        // Add new item to cart
        Cart::create([
            'user_id' => Auth::id(),
            'product_id' => $validated['product_id'],
            'quantity' => $validated['quantity'],
            'unit_price' => $unitPrice,
            'subtotal' => $subtotal,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Produk ditambahkan ke keranjang',
            'cart_count' => Cart::forUser(Auth::id())->count(),
            'cart_total' => Cart::forUser(Auth::id())->sum('subtotal'),
        ]);
    }

    /**
     * Get cart items
     */
    public function index()
    {
        $cartItems = Cart::forUser(Auth::id())
            ->with(['product.category', 'product.brand'])
            ->get();

        $totalQuantity = $cartItems->sum('quantity');
        $totalAmount = $cartItems->sum('subtotal');

        return response()->json([
            'success' => true,
            'cart_items' => $cartItems,
            'total_quantity' => $totalQuantity,
            'total_amount' => $totalAmount,
        ]);
    }

    /**
     * View cart page
     */
    public function view()
    {
        $cartItems = Cart::forUser(Auth::id())
            ->with(['product.category', 'product.brand'])
            ->get();

        $totalQuantity = $cartItems->sum('quantity');
        $totalAmount = $cartItems->sum('subtotal');

        return view('cart.index', compact('cartItems', 'totalQuantity', 'totalAmount'));
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        $product = $cart->product;
        $totalStock = $product->warehouseStocks->sum('quantity') ?? 0;

        if ($totalStock < $validated['quantity']) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi'
            ], 400);
        }

        $cart->update([
            'quantity' => $validated['quantity'],
            'subtotal' => $cart->unit_price * $validated['quantity'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Keranjang diperbarui',
            'cart_count' => Cart::forUser(Auth::id())->count(),
            'cart_total' => Cart::forUser(Auth::id())->sum('subtotal'),
        ]);
    }

    /**
     * Remove item from cart
     */
    public function destroy(Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $cart->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk dihapus dari keranjang',
            'cart_count' => Cart::forUser(Auth::id())->count(),
            'cart_total' => Cart::forUser(Auth::id())->sum('subtotal'),
        ]);
    }

    /**
     * Clear cart
     */
    public function clear()
    {
        Cart::forUser(Auth::id())->delete();

        return response()->json([
            'success' => true,
            'message' => 'Keranjang dikosongkan',
            'cart_count' => 0,
            'cart_total' => 0,
        ]);
    }

    /**
     * Show checkout page
     */
    public function checkout()
    {
        $cartItems = Cart::forUser(Auth::id())
            ->with(['product.category', 'product.brand'])
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('customer.catalog')
                ->with('error', 'Keranjang Anda kosong. Silakan tambahkan produk terlebih dahulu.');
        }

        $totalQuantity = $cartItems->sum('quantity');
        $totalAmount = $cartItems->sum('subtotal');

        return view('cart.checkout', compact('cartItems', 'totalQuantity', 'totalAmount'));
    }

    /**
     * Process checkout
     */
    public function processCheckout(Request $request)
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:cash,transfer,credit_card,ewallet',
            'shipping_address' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $cartItems = Cart::forUser(Auth::id())
            ->with(['product'])
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Keranjang Anda kosong'
            ], 400);
        }

        // Create sales order
        $salesOrder = SalesOrder::create([
            'customer_id' => Auth::id(),
            'order_date' => now(),
            'status' => 'pending',
            'total_amount' => $cartItems->sum('subtotal'),
            'notes' => $validated['notes'] ?? null,
            'payment_method' => $validated['payment_method'],
            'shipping_address' => $validated['shipping_address'],
        ]);

        // Add items to sales order
        foreach ($cartItems as $cartItem) {
            SalesOrderItem::create([
                'sales_order_id' => $salesOrder->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'unit_price' => $cartItem->unit_price,
                'subtotal' => $cartItem->subtotal,
            ]);

            // Update stock
            $warehouseStock = WarehouseStock::where('product_id', $cartItem->product_id)->first();
            if ($warehouseStock && $warehouseStock->quantity >= $cartItem->quantity) {
                $warehouseStock->decrement('quantity', $cartItem->quantity);
            }
        }

        // Clear cart
        Cart::forUser(Auth::id())->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil dibuat',
            'order_id' => $salesOrder->id,
        ]);
    }
}
