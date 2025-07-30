<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display the cart page
     */
    public function cart()
    {
        $cart = session()->get('cart', []);
        $products = [];
        $total = 0;

        if (!empty($cart)) {
            $productIds = array_keys($cart);
            $products = Product::whereIn('id', $productIds)->get();
            
            foreach ($products as $product) {
                $quantity = $cart[$product->id]['quantity'];
                $product->cart_quantity = $quantity;
                $product->cart_subtotal = $product->price * $quantity;
                $total += $product->cart_subtotal;
            }
        }

        return view('client.order.cart', compact('products', 'total'));
    }

    /**
     * Add item to cart
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::where('is_available', true)->findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] += $request->quantity;
        } else {
            $cart[$request->product_id] = [
                'quantity' => $request->quantity,
                'name' => $product->name,
                'price' => $product->price
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Item added to cart successfully.');
    }

    /**
     * Update cart item quantity
     */
    public function updateCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return redirect()->route('client.cart')->with('success', 'Cart updated successfully.');
    }

    /**
     * Remove item from cart
     */
    public function removeFromCart($productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return redirect()->route('client.cart')->with('success', 'Item removed from cart.');
    }

    /**
     * Clear cart
     */
    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->route('client.cart')->with('success', 'Cart cleared successfully.');
    }

    /**
     * Show checkout form
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('client.cart')->with('error', 'Your cart is empty.');
        }

        $products = [];
        $total = 0;

        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get();
        
        foreach ($products as $product) {
            $quantity = $cart[$product->id]['quantity'];
            $product->cart_quantity = $quantity;
            $product->cart_subtotal = $product->price * $quantity;
            $total += $product->cart_subtotal;
        }

        return view('client.order.checkout', compact('products', 'total'));
    }

    /**
     * Process order
     */
    public function processOrder(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'payment_method' => 'required|in:cash,card,online',
            'notes' => 'nullable|string'
        ]);

        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('client.cart')->with('error', 'Your cart is empty.');
        }

        $order = Order::create([
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->customer_address,
            'payment_method' => $request->payment_method,
            'notes' => $request->notes,
            'total_amount' => 0,
            'status' => 'pending',
            'payment_status' => 'pending'
        ]);

        $totalAmount = 0;

        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            $subtotal = $product->price * $item['quantity'];
            $totalAmount += $subtotal;

            $order->orderItems()->create([
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $product->price,
                'subtotal' => $subtotal
            ]);
        }

        $order->update(['total_amount' => $totalAmount]);

        // Clear cart after successful order
        session()->forget('cart');

        return redirect()->route('client.order.confirmation', $order->id)
            ->with('success', 'Order placed successfully!');
    }

    /**
     * Order confirmation
     */
    public function confirmation($id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);
        return view('client.order.confirmation', compact('order'));
    }
}
