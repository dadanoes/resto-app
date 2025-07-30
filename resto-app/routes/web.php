<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Client\MenuController;
use App\Http\Controllers\Client\OrderController as ClientOrderController;

// Client Routes
Route::get('/', [MenuController::class, 'index'])->name('home');
Route::get('/menu', [MenuController::class, 'index'])->name('client.menu');
Route::get('/menu/category/{id}', [MenuController::class, 'category'])->name('client.menu.category');
Route::get('/menu/product/{id}', [MenuController::class, 'show'])->name('client.menu.show');
Route::get('/menu/search', [MenuController::class, 'search'])->name('client.menu.search');

// Cart and Order Routes
Route::get('/cart', [ClientOrderController::class, 'cart'])->name('client.cart');
Route::post('/cart/add', [ClientOrderController::class, 'addToCart'])->name('client.cart.add');
Route::put('/cart/update', [ClientOrderController::class, 'updateCart'])->name('client.cart.update');
Route::delete('/cart/remove/{id}', [ClientOrderController::class, 'removeFromCart'])->name('client.cart.remove');
Route::delete('/cart/clear', [ClientOrderController::class, 'clearCart'])->name('client.cart.clear');
Route::get('/checkout', [ClientOrderController::class, 'checkout'])->name('client.checkout');
Route::post('/order/process', [ClientOrderController::class, 'processOrder'])->name('client.order.process');
Route::get('/order/confirmation/{id}', [ClientOrderController::class, 'confirmation'])->name('client.order.confirmation');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Categories
    Route::resource('categories', CategoryController::class);
    
    // Products
    Route::resource('products', ProductController::class);
    
    // Orders
    Route::resource('orders', AdminOrderController::class);
    Route::put('orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::put('orders/{id}/payment-status', [AdminOrderController::class, 'updatePaymentStatus'])->name('orders.updatePaymentStatus');
    
    // Dashboard
    Route::get('/dashboard', function () {
        $totalOrders = \App\Models\Order::count();
        $totalProducts = \App\Models\Product::count();
        $totalCategories = \App\Models\Category::count();
        $recentOrders = \App\Models\Order::with('orderItems.product')->latest()->limit(5)->get();
        
        return view('admin.dashboard', compact('totalOrders', 'totalProducts', 'totalCategories', 'recentOrders'));
    })->name('dashboard');
});
