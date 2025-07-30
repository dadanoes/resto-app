@extends('layouts.app')

@section('title', 'Search Results - Restaurant App')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h2><i class="fas fa-search me-2"></i>Search Results</h2>
            <p class="text-muted">Showing results for: "<strong>{{ $query }}</strong>"</p>
        </div>
    </div>

    <!-- Search Form -->
    <div class="row mb-4">
        <div class="col-md-8 mx-auto">
            <form action="{{ route('client.menu.search') }}" method="GET" class="d-flex">
                <input type="text" name="q" class="form-control form-control-lg me-3" 
                       placeholder="Search for food or drinks..." value="{{ $query }}">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Results -->
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
                        @foreach($categories as $category)
                            <a href="{{ route('client.menu') }}?category={{ $category->id }}" 
                               class="list-group-item list-group-item-action">
                                <i class="fas fa-{{ $category->name == 'Drinks' ? 'glass-martini' : 'utensils' }} me-2"></i>
                                {{ $category->name }}
                                <span class="badge bg-secondary float-end">{{ $category->products->count() }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Results -->
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
                
                <div class="text-center mt-4">
                    <p class="text-muted">Found {{ $products->count() }} result(s) for "{{ $query }}"</p>
                    <a href="{{ route('client.menu') }}" class="btn btn-outline-primary">
                        <i class="fas fa-utensils me-1"></i>View All Menu
                    </a>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-search" style="font-size: 4rem; color: #ccc;"></i>
                    <h4 class="mt-3">No results found</h4>
                    <p class="text-muted">No products match your search for "{{ $query }}".</p>
                    <div class="mt-3">
                        <a href="{{ route('client.menu') }}" class="btn btn-primary me-2">
                            <i class="fas fa-utensils me-1"></i>Browse All Menu
                        </a>
                        <a href="{{ route('client.menu.search') }}" class="btn btn-outline-primary">
                            <i class="fas fa-search me-1"></i>Try Different Search
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 