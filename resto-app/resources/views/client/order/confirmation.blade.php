@extends('layouts.app')

@section('title', 'Order Confirmation - Restaurant App')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-success text-white text-center">
                    <i class="fas fa-check-circle" style="font-size: 3rem;"></i>
                    <h3 class="mb-0 mt-2">Order Confirmed!</h3>
                    <p class="mb-0">Thank you for your order</p>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h5 class="text-success">Order #{{ $order->order_number }}</h5>
                        <p class="text-muted">Your order has been successfully placed and is being processed.</p>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="fas fa-user me-2"></i>Customer Information</h6>
                            <p><strong>Name:</strong> {{ $order->customer_name }}</p>
                            <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
                            <p><strong>Address:</strong> {{ $order->customer_address }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-info-circle me-2"></i>Order Information</h6>
                            <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y h:i A') }}</p>
                            <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
                            <p><strong>Status:</strong> 
                                <span class="badge bg-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'processing' ? 'info' : ($order->status == 'completed' ? 'success' : 'danger')) }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                    
                    @if($order->notes)
                        <div class="mt-3">
                            <h6><i class="fas fa-sticky-note me-2"></i>Special Instructions</h6>
                            <p class="text-muted">{{ $order->notes }}</p>
                        </div>
                    @endif
                    
                    <hr>
                    
                    <h6><i class="fas fa-list me-2"></i>Order Items</h6>
                    @foreach($order->orderItems as $item)
                        <div class="row align-items-center border-bottom py-2">
                            <div class="col-md-2">
                                @if($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" class="img-fluid rounded" alt="{{ $item->product->name }}">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 50px;">
                                        <i class="fas fa-{{ $item->product->type == 'drink' ? 'glass-martini' : 'utensils' }}" style="font-size: 1.5rem; color: #ccc;"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-1">{{ $item->product->name }}</h6>
                                <small class="text-muted">{{ $item->product->category->name }}</small>
                            </div>
                            <div class="col-md-2 text-center">
                                <span class="text-muted">Qty: {{ $item->quantity }}</span>
                            </div>
                            <div class="col-md-2 text-end">
                                <span class="fw-bold">${{ number_format($item->subtotal, 2) }}</span>
                            </div>
                        </div>
                    @endforeach
                    
                    <div class="text-end mt-3">
                        <h5><strong>Total: ${{ number_format($order->total_amount, 2) }}</strong></h5>
                    </div>
                    
                    <div class="alert alert-info mt-4">
                        <h6><i class="fas fa-clock me-2"></i>What's Next?</h6>
                        <ul class="mb-0">
                            <li>We'll start preparing your order immediately</li>
                            <li>Estimated delivery time: 30-45 minutes</li>
                            <li>You'll receive updates on your order status</li>
                            <li>Payment will be collected upon delivery</li>
                        </ul>
                    </div>
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('home') }}" class="btn btn-primary me-2">
                            <i class="fas fa-home me-1"></i>Back to Home
                        </a>
                        <a href="{{ route('client.menu') }}" class="btn btn-outline-primary">
                            <i class="fas fa-utensils me-1"></i>Order More
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 