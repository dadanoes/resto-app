@extends('layouts.app')

@section('title', 'Category Details - Admin')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-list me-2"></i>Category Details</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            @if($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" class="img-fluid rounded" alt="{{ $category->name }}">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="fas fa-list" style="font-size: 3rem; color: #ccc;"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h3>{{ $category->name }}</h3>
                            <p class="text-muted">{{ $category->description }}</p>
                            
                            <div class="row">
                                <div class="col-6">
                                    <p><strong>Status:</strong> 
                                        <span class="badge bg-{{ $category->is_active ? 'success' : 'danger' }}">
                                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </p>
                                </div>
                                <div class="col-6">
                                    <p><strong>Products:</strong> {{ $category->products->count() }}</p>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-6">
                                    <p><strong>Created:</strong> {{ $category->created_at->format('M d, Y') }}</p>
                                </div>
                                <div class="col-6">
                                    <p><strong>Updated:</strong> {{ $category->updated_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning">
                                    <i class="fas fa-edit me-2"></i>Edit Category
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" 
                                            onclick="return confirm('Are you sure you want to delete this category?')">
                                        <i class="fas fa-trash me-2"></i>Delete Category
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-utensils me-2"></i>Products in this Category</h5>
                </div>
                <div class="card-body">
                    @if($category->products->count() > 0)
                        @foreach($category->products as $product)
                            <div class="border-bottom py-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $product->name }}</h6>
                                        <small class="text-muted">${{ number_format($product->price, 2) }}</small>
                                    </div>
                                    <span class="badge bg-{{ $product->is_available ? 'success' : 'danger' }}">
                                        {{ $product->is_available ? 'Available' : 'Unavailable' }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted text-center">No products in this category yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-utensils me-2"></i>Products in {{ $category->name }}</h5>
                </div>
                <div class="card-body">
                    @if($category->products->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($category->products as $product)
                                        <tr>
                                            <td>
                                                @if($product->image)
                                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 50px; height: 50px; object-fit: cover;" class="rounded">
                                                @else
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                        <i class="fas fa-{{ $product->type == 'drink' ? 'glass-martini' : 'utensils' }}" style="font-size: 1.5rem; color: #ccc;"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <strong>{{ $product->name }}</strong>
                                                <br>
                                                <small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $product->type == 'drink' ? 'info' : 'success' }}">
                                                    {{ ucfirst($product->type) }}
                                                </span>
                                            </td>
                                            <td>
                                                <strong>${{ number_format($product->price, 2) }}</strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $product->is_available ? 'success' : 'danger' }}">
                                                    {{ $product->is_available ? 'Available' : 'Unavailable' }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-utensils" style="font-size: 3rem; color: #ccc;"></i>
                            <h5 class="mt-3">No products yet</h5>
                            <p class="text-muted">Add some products to this category to get started.</p>
                            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>Add Product
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="text-center mt-4">
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Categories
        </a>
    </div>
</div>
@endsection 