@extends('layouts.app')

@section('title', $category->name . ' - Restaurant App')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('client.menu') }}">Menu</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
                </ol>
            </nav>
            
            <h2><i class="fas fa-{{ $category->name == 'Drinks' ? 'glass-martini' : 'utensils' }} me-2"></i>{{ $category->name }}</h2>
            <p class="text-muted">{{ $category->description }}</p>
        </div>
    </div>

    <div class="row">
        <!-- Categories Sidebar -->
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-list me-2"></i>Categories</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('client.menu') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-th-large me-2"></i>All Items
                        </a>
                        @foreach(\App\Models\Category::where('is_active', true)->get() as $cat)
                            <a href="{{ route('client.menu.category', $cat->id) }}" 
                               class="list-group-item list-group-item-action {{ $cat->id == $category->id ? 'active' : '' }}">
                                <i class="fas fa-{{ $cat->name == 'Drinks' ? 'glass-martini' : 'utensils' }} me-2"></i>
                                {{ $cat->name }}
                                <span class="badge bg-secondary float-end">{{ $cat->products->count() }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-lg-9">
            @if($products->count() > 0)
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <i class="fas fa-{{ $product->type == 'drink' ? 'glass-martini' : 'utensils' }}" style="font-size: 3rem; color: #ccc;"></i>
                                    </div>
                                @endif
                                
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title mb-0">{{ $product->name }}</h5>
                                        <span class="badge bg-{{ $product->type == 'drink' ? 'info' : 'success' }}">{{ ucfirst($product->type) }}</span>
                                    </div>
                                    
                                    <p class="card-text text-muted small">{{ Str::limit($product->description, 100) }}</p>
                                    
                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="text-primary fw-bold">${{ number_format($product->price, 2) }}</span>
                                            <small class="text-muted">{{ $product->category->name }}</small>
                                        </div>
                                        
                                        <div class="d-grid gap-2">
                                            <a href="{{ route('client.menu.show', $product->id) }}" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-eye me-1"></i>View Details
                                            </a>
                                            
                                            @if($product->is_available)
                                                <form action="{{ route('client.cart.add') }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
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
                
                <div class="text-center mt-4">
                    <p class="text-muted">Found {{ $products->count() }} product(s) in {{ $category->name }}</p>
                    <a href="{{ route('client.menu') }}" class="btn btn-outline-primary">
                        <i class="fas fa-utensils me-1"></i>View All Menu
                    </a>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-utensils" style="font-size: 4rem; color: #ccc;"></i>
                    <h4 class="mt-3">No products in this category</h4>
                    <p class="text-muted">There are no products available in {{ $category->name }} at the moment.</p>
                    <a href="{{ route('client.menu') }}" class="btn btn-primary">
                        <i class="fas fa-utensils me-1"></i>Browse Other Categories
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 