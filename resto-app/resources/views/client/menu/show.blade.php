@extends('layouts.app')

@section('title', $product->name . ' - Restaurant App')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded" alt="{{ $product->name }}">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 300px;">
                                    <i class="fas fa-{{ $product->type == 'drink' ? 'glass-martini' : 'utensils' }}" style="font-size: 4rem; color: #ccc;"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h2 class="mb-2">{{ $product->name }}</h2>
                                <span class="badge bg-{{ $product->type == 'drink' ? 'info' : 'success' }} fs-6">{{ ucfirst($product->type) }}</span>
                            </div>
                            
                            <p class="text-muted mb-3">{{ $product->description }}</p>
                            
                            <div class="mb-3">
                                <span class="text-primary fw-bold fs-3">${{ number_format($product->price, 2) }}</span>
                            </div>
                            
                            <div class="mb-3">
                                <p><strong>Category:</strong> {{ $product->category->name }}</p>
                                <p><strong>Availability:</strong> 
                                    <span class="badge bg-{{ $product->is_available ? 'success' : 'danger' }}">
                                        {{ $product->is_available ? 'Available' : 'Unavailable' }}
                                    </span>
                                </p>
                            </div>
                            
                            @if($product->is_available)
                                <form action="{{ route('client.cart.add') }}" method="POST" class="mb-3">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="quantity" class="form-label">Quantity</label>
                                            <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" max="10">
                                        </div>
                                        <div class="col-md-8">
                                            <label class="form-label">&nbsp;</label>
                                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                                <i class="fas fa-cart-plus me-2"></i>Add to Cart
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            @else
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    This item is currently unavailable.
                                </div>
                            @endif
                            
                            <div class="d-flex gap-2">
                                <a href="{{ route('client.menu') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Menu
                                </a>
                                <a href="{{ route('client.cart') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-shopping-cart me-2"></i>View Cart
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Product Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6><i class="fas fa-tag me-2"></i>Category</h6>
                        <p class="mb-0">{{ $product->category->name }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <h6><i class="fas fa-utensils me-2"></i>Type</h6>
                        <p class="mb-0">{{ ucfirst($product->type) }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <h6><i class="fas fa-dollar-sign me-2"></i>Price</h6>
                        <p class="mb-0 text-primary fw-bold">${{ number_format($product->price, 2) }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <h6><i class="fas fa-clock me-2"></i>Added</h6>
                        <p class="mb-0">{{ $product->created_at->format('M d, Y') }}</p>
                    </div>
                    
                    @if($product->is_available)
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            This item is available for order.
                        </div>
                    @else
                        <div class="alert alert-danger">
                            <i class="fas fa-times-circle me-2"></i>
                            This item is currently unavailable.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <h3><i class="fas fa-star me-2"></i>You might also like</h3>
                <p class="text-muted">Other items from {{ $product->category->name }}</p>
            </div>
        </div>
        
        <div class="row">
            @foreach($relatedProducts as $relatedProduct)
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card h-100">
                        @if($relatedProduct->image)
                            <img src="{{ asset('storage/' . $relatedProduct->image) }}" class="card-img-top" alt="{{ $relatedProduct->name }}" style="height: 150px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 150px;">
                                <i class="fas fa-{{ $relatedProduct->type == 'drink' ? 'glass-martini' : 'utensils' }}" style="font-size: 2rem; color: #ccc;"></i>
                            </div>
                        @endif
                        
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title">{{ $relatedProduct->name }}</h6>
                            <p class="card-text text-muted small">{{ Str::limit($relatedProduct->description, 80) }}</p>
                            
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-primary fw-bold">${{ number_format($relatedProduct->price, 2) }}</span>
                                    <span class="badge bg-{{ $relatedProduct->type == 'drink' ? 'info' : 'success' }}">{{ ucfirst($relatedProduct->type) }}</span>
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <a href="{{ route('client.menu.show', $relatedProduct->id) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye me-1"></i>View
                                    </a>
                                    
                                    @if($relatedProduct->is_available)
                                        <form action="{{ route('client.cart.add') }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $relatedProduct->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-primary btn-sm w-100">
                                                <i class="fas fa-cart-plus me-1"></i>Add to Cart
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-secondary btn-sm w-100" disabled>
                                            <i class="fas fa-times me-1"></i>Unavailable
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection 