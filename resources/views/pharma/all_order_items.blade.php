<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History - Health Pulse</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/all-css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all-css/orders.css') }}">
</head>
<body>
    <x-app-layout>
   
    <header class="page-header text-center">
        <div class="container">
            <h1>My Orders</h1>
            <p>View and manage all your previous orders</p>
        </div>
    </header>

    <div class="container">
        <div class="order-container">
            <div class="d-flex align-items-center mb-4">
                <i class="fas fa-clipboard-list text-primary me-3" style="font-size: 28px;"></i>
                <h2 class="mb-0 order-header">Order History</h2>
            </div>

            @if(count($orders) > 0)
                <div class="row">
                    @foreach($orders as $order)
                        <div class="col-lg-12">
                            <div class="card order-card shadow-sm">
                                <div class="card-header bg-white border-0 py-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="mb-0 d-flex align-items-center">
                                                <i class="fas fa-shopping-bag me-2 text-primary"></i>
                                                <span>Order #{{ $order->id }}</span>
                                                @if($order->status == 'completed')
                                                    <span class="badge bg-success rounded-pill ms-2">
                                                        <i class="fas fa-check-circle"></i> Completed
                                                    </span>
                                                @elseif($order->status == 'cancelled')
                                                    <span class="badge bg-danger rounded-pill ms-2">
                                                        <i class="fas fa-times-circle"></i> Cancelled
                                                    </span>
                                                @else
                                                    <span class="badge bg-info rounded-pill ms-2">
                                                        <i class="fas fa-clock"></i> Processing
                                                    </span>
                                                @endif
                                            </h5>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="text-muted me-3 fs-6">
                                                <i class="far fa-calendar-alt"></i>
                                                {{ $order->created_at->format('Y-m-d') }}
                                            </span>
                                            <span class="text-muted me-3 fs-6">
                                                <i class="far fa-clock"></i>
                                                {{ $order->created_at->format('h:i A') }}
                                            </span>
                                            <span class="border rounded-pill py-2 px-3 text-primary fw-bold">
                                                ${{ number_format($order->total_amount, 2) }}
                                            </span>
                                            <button class="btn btn-light border-0 ms-2 order-toggle-btn" id="order-toggle-btn-{{ $order->id }}" onclick="toggleOrderDetails({{ $order->id }})">
                                                <i class="fas fa-chevron-down"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="order-details" id="order-details-{{ $order->id }}">
                                    <div class="card-body">
                                        <h6 class="mb-3 text-primary">
                                            <i class="fas fa-box-open me-2"></i> Order Details
                                        </h6>

                                        <div class="table-responsive">
                                            <table class="table table-borderless table-hover">
                                                <thead class="bg-light text-muted">
                                                    <tr>
                                                        <th width="80" class="rounded-start">Image</th>
                                                        <th>Product</th>
                                                        <th width="100">Price</th>
                                                        <th width="100">Quantity</th>
                                                        <th width="120" class="rounded-end">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($order->items as $item)
                                                        <tr class="align-middle">
                                                            <td>
                                                                <div class="d-flex justify-content-center">
                                                                    @if($item->pharma && $item->pharma->image)
                                                                        <img src="{{ asset('img/' . $item->pharma->image) }}" alt="{{ $item->pharma->name ?? 'Medicine' }}" class="product-img" style="width: 50px; height: 50px; object-fit: cover;">
                                                                    @else
                                                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                                            <i class="fas fa-prescription-bottle-alt fa-lg text-muted"></i>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <h6 class="mb-0">{{ $item->pharma->name ?? 'Product not available' }}</h6>
                                                                @if($item->pharma && $item->pharma->category)
                                                                    <small class="text-muted">{{ $item->pharma->category->name ?? '' }}</small>
                                                                @endif
                                                            </td>
                                                            <td class="text-muted">${{ number_format($item->price, 2) }}</td>
                                                            <td>
                                                                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">{{ $item->quantity }}</span>
                                                            </td>
                                                            <td class="fw-bold">${{ number_format($item->total, 2) }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <div class="card bg-light border-0">
                                                    <div class="card-body p-3">
                                                        <h6 class="mb-3">
                                                            <i class="fas fa-truck me-2"></i> Shipping Information
                                                        </h6>
                                                        <p class="mb-2">
                                                            <span class="text-muted">Address:</span> 
                                                            <span>{{ Auth::user()->address ?? 'Address saved in your account' }}</span>
                                                        </p>
                                                        <p class="mb-2">
                                                            <span class="text-muted">Shipping Method:</span> 
                                                            <span>Standard Shipping (1-3 days)</span>
                                                        </p>
                                                        <p class="mb-0">
                                                            <span class="text-muted">Status:</span> 
                                                            @if($order->status == 'completed')
                                                                <span class="text-success">Delivered</span>
                                                            @elseif($order->status == 'cancelled')
                                                                <span class="text-danger">Cancelled</span>
                                                            @else
                                                                <span class="text-primary">Processing</span>
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card bg-light border-0">
                                                    <div class="card-body p-3">
                                                        <h6 class="mb-3">
                                                            <i class="fas fa-credit-card me-2"></i> Payment Information
                                                        </h6>
                                                        <p class="mb-2">
                                                            <span class="text-muted">Payment Method:</span> 
                                                            <span>{{ $order->payment_method ?? 'Cash on Delivery' }}</span>
                                                        </p>
                                                        <p class="mb-2">
                                                            <span class="text-muted">Subtotal:</span> 
                                                            <span>${{ number_format($order->total_amount - 5, 2) }}</span>
                                                        </p>
                                                        <p class="mb-2">
                                                            <span class="text-muted">Shipping Fee:</span> 
                                                            <span>$5.00</span>
                                                        </p>
                                                        <p class="mb-0 fw-bold">
                                                            <span class="text-muted">Total:</span> 
                                                            <span>${{ number_format($order->total_amount, 2) }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @if($order->status != 'cancelled')
                                            <div class="text-end mt-4">
                                                <a href="{{ route('order.invoice', $order->id) }}" class="btn btn-outline-primary">
                                                    <i class="far fa-file-alt me-1"></i> Print Invoice
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-orders">
                    <i class="fas fa-shopping-basket"></i>
                    <h4 class="mt-3">No orders found</h4>
                    <p class="text-muted mb-4">You haven't placed any orders yet. Start shopping now!</p>
                    <a href="{{ route('pharma.index') }}" class="btn btn-primary px-4">
                        <i class="fas fa-shopping-basket me-2" style="font-size: 18px; padding-top: 14px;"></i> <span class="d-none d-md-inline">Shop Now</span>

                    </a>
                </div>
            @endif
        </div>
    </div>
    
    </x-app-layout>

    <!-- Bootstrap, jQuery and other scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function toggleOrderDetails(orderId) {
            const detailsElement = document.getElementById(`order-details-${orderId}`);
            const buttonElement = document.getElementById(`order-toggle-btn-${orderId}`);
            
            if (detailsElement.style.display === 'block') {
                detailsElement.style.display = 'none';
                buttonElement.innerHTML = '<i class="fas fa-chevron-down"></i>';
            } else {
                detailsElement.style.display = 'block';
                buttonElement.innerHTML = '<i class="fas fa-chevron-up"></i>';
            }
        }
        
        $(document).ready(function() {
            // Show first order details automatically if orders exist
            @if(count($orders) > 0)
                toggleOrderDetails({{ $orders->first()->id }});
            @endif
        });
    </script>
</body>
</html>
