@extends('layouts.app')

@section('title', 'Admin Dashboard - Restaurant App')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h2><i class="fas fa-tachometer-alt me-2"></i>Admin Dashboard</h2>
            <p class="text-muted">Welcome to the restaurant management system</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $totalOrders }}</h4>
                            <p class="mb-0">Total Orders</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-shopping-bag" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $totalProducts }}</h4>
                            <p class="mb-0">Total Products</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-utensils" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $totalCategories }}</h4>
                            <p class="mb-0">Categories</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-list" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $recentOrders->where('status', 'pending')->count() }}</h4>
                            <p class="mb-0">Pending Orders</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-clock" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-plus me-2"></i>Add Category
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.products.create') }}" class="btn btn-outline-success w-100">
                                <i class="fas fa-plus me-2"></i>Add Product
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.orders.create') }}" class="btn btn-outline-info w-100">
                                <i class="fas fa-plus me-2"></i>Create Order
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-warning w-100">
                                <i class="fas fa-list me-2"></i>View Orders
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Recent Orders</h5>
                </div>
                <div class="card-body">
                    @if($recentOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Order #</th>
                                        <th>Customer</th>
                                        <th>Items</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentOrders as $order)
                                        <tr>
                                            <td>
                                                <strong>{{ $order->order_number }}</strong>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong>{{ $order->customer_name }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $order->customer_phone }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $order->orderItems->count() }} items</span>
                                            </td>
                                            <td>
                                                <strong>${{ number_format($order->total_amount, 2) }}</strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'processing' ? 'info' : ($order->status == 'completed' ? 'success' : 'danger')) }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <small>{{ $order->created_at->format('M d, Y h:i A') }}</small>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-primary">
                                <i class="fas fa-list me-1"></i>View All Orders
                            </a>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-inbox" style="font-size: 3rem; color: #ccc;"></i>
                            <h5 class="mt-3">No orders yet</h5>
                            <p class="text-muted">Orders will appear here once customers start placing them.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Management Links -->
    <div class="row mt-4">
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-list-alt text-primary" style="font-size: 3rem;"></i>
                    <h5 class="mt-3">Categories</h5>
                    <p class="text-muted">Manage food and drink categories</p>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">
                        <i class="fas fa-cog me-1"></i>Manage Categories
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-utensils text-success" style="font-size: 3rem;"></i>
                    <h5 class="mt-3">Products</h5>
                    <p class="text-muted">Manage menu items and prices</p>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-success">
                        <i class="fas fa-cog me-1"></i>Manage Products
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-shopping-cart text-info" style="font-size: 3rem;"></i>
                    <h5 class="mt-3">Orders</h5>
                    <p class="text-muted">View and manage customer orders</p>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-info">
                        <i class="fas fa-cog me-1"></i>Manage Orders
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 