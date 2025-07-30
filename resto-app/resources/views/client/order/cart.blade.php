@extends('layouts.app')

@section('title', 'Shopping Cart - Restaurant App')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Shopping Cart</h4>
                </div>
                <div class="card-body">
                    @if(count($products) > 0)
                        @foreach($products as $product)
                            <div class="row align-items-center border-bottom py-3">
                                <div class="col-md-2">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded" alt="{{ $product->name }}">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 80px;">
                                            <i class="fas fa-{{ $product->type == 'drink' ? 'glass-martini' : 'utensils' }}" style="font-size: 2rem; color: #ccc;"></i>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="col-md-4">
                                    <h6 class="mb-1">{{ $product->name }}</h6>
                                    <small class="text-muted">{{ $product->category->name }}</small>
                                    <br>
                                    <span class="badge bg-{{ $product->type == 'drink' ? 'info' : 'success' }}">{{ ucfirst($product->type) }}</span>
                                </div>
                                
                                <div class="col-md-2">
                                    <span class="text-primary fw-bold">${{ number_format($product->price, 2) }}</span>
                                </div>
                                
                                <div class="col-md-2">
                                    <form action="{{ route('client.cart.update') }}" method="POST" class="d-flex align-items-center">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="number" name="quantity" value="{{ $product->cart_quantity }}" min="1" class="form-control form-control-sm me-2" style="width: 60px;">
                                        <button type="submit" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </form>
                                </div>
                                
                                <div class="col-md-1">
                                    <span class="fw-bold">${{ number_format($product->cart_subtotal, 2) }}</span>
                                </div>
                                
                                <div class="col-md-1">
                                    <form action="{{ route('client.cart.remove', $product->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to remove this item?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                        
                        <div class="text-end mt-3">
                            <form action="{{ route('client.cart.clear') }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to clear your cart?')">
                                    <i class="fas fa-trash me-1"></i>Clear Cart
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-cart" style="font-size: 4rem; color: #ccc;"></i>
                            <h4 class="mt-3">Your cart is empty</h4>
                            <p class="text-muted">Add some delicious items to your cart to get started.</p>
                            <a href="{{ route('client.menu') }}" class="btn btn-primary">
                                <i class="fas fa-utensils me-1"></i>Browse Menu
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Order Summary</h5>
                </div>
                <div class="card-body">
                    @if(count($products) > 0)
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tax (10%):</span>
                            <span>${{ number_format($total * 0.1, 2) }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total:</strong>
                            <strong class="text-success">${{ number_format($total * 1.1, 2) }}</strong>
                        </div>
                        
                        <div class="d-grid">
                            <a href="{{ route('client.checkout') }}" class="btn btn-success btn-lg">
                                <i class="fas fa-credit-card me-2"></i>Proceed to Checkout
                            </a>
                        </div>
                        
                        <div class="text-center mt-3">
                            <a href="{{ route('client.menu') }}" class="btn btn-outline-primary">
                                <i class="fas fa-plus me-1"></i>Continue Shopping
                            </a>
                        </div>
                    @else
                        <p class="text-muted text-center">No items in cart</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 