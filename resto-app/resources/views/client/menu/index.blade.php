@extends('layouts.app')

@section('title', 'Menu - Restaurant App')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Delicious Menu</h1>
                <p class="lead mb-4">Discover our amazing selection of food and drinks, prepared with the finest ingredients and love.</p>
                <a href="#menu" class="btn btn-light btn-lg">Explore Menu</a>
            </div>
            <div class="col-lg-6 text-center">
                <i class="fas fa-utensils" style="font-size: 8rem; opacity: 0.3;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Search Section -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="{{ route('client.menu.search') }}" method="GET" class="d-flex">
                    <input type="text" name="q" class="form-control form-control-lg me-3" placeholder="Search for food or drinks..." value="{{ request('q') }}">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Menu Section -->
<section id="menu" class="py-5">
    <div class="container">
        <div class="row">
            <!-- Categories Sidebar -->
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Categories</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <a href="{{ route('client.menu') }}" class="list-group-item list-group-item-action {{ !$selectedCategory ? 'active' : '' }}">
                                <i class="fas fa-th-large me-2"></i>All Items
                            </a>
                            @foreach($categories as $category)
                                <a href="{{ route('client.menu') }}?category={{ $category->id }}" 
                                   class="list-group-item list-group-item-action {{ $selectedCategory == $category->id ? 'active' : '' }}">
                                    <i class="fas fa-{{ $category->name == 'Drinks' ? 'glass-martini' : 'utensils' }} me-2"></i>
                                    {{ $category->name }}
                                    <span class="badge bg-secondary float-end">{{ $category->products->count() }}</span>
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
                                                
                                                <form action="{{ route('client.cart.add') }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <input type="hidden" name="quantity" value="1">
                                                    <button type="submit" class="btn btn-primary btn-sm w-100">
                                                        <i class="fas fa-cart-plus me-1"></i>Add to Cart
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-search" style="font-size: 4rem; color: #ccc;"></i>
                        <h4 class="mt-3">No products found</h4>
                        <p class="text-muted">Try adjusting your search or browse all categories.</p>
                        <a href="{{ route('client.menu') }}" class="btn btn-primary">View All Products</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection 