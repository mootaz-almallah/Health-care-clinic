<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - E-Pharmacy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        
        .cart-container {
            background-color: #ffffff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            margin-top: 30px;
            margin-bottom: 30px;
        }
        
        .cart-header {
            color: #4CAF50;
            font-weight: 600;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }
        
        .btn-quantity {
            width: 32px;
            height: 32px;
            padding: 0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .btn-quantity:hover {
            transform: scale(1.1);
        }
        
        .quantity-control {
            background-color: #f8f9fa;
            border-radius: 20px;
            padding: 5px 10px;
        }
        
        .product-img {
            border-radius: 10px;
            transition: transform 0.3s ease;
            object-fit: cover;
        }
        
        .product-img:hover {
            transform: scale(1.05);
        }
        
        .product-name {
            font-weight: 500;
            color: #343a40;
        }
        
        .price {
            color: #4CAF50;
            font-weight: 600;
        }
        
        .total-row {
            font-size: 1.2rem;
            font-weight: 600;
            background-color: #e8f5e9;
        }
        
        .empty-cart {
            padding: 50px 20px;
            text-align: center;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
        
        .empty-cart i {
            font-size: 70px;
            color: #bdbdbd;
            margin-bottom: 20px;
        }
        
        .btn-primary {
            background-color: #4CAF50;
            border-color: #4CAF50;
            border-radius: 6px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background-color: #388E3C;
            border-color: #388E3C;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
        }
        
        .btn-danger {
            border-radius: 6px;
            transition: all 0.3s;
        }
        
        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
        }
        
        .payment-option .card {
            border-radius: 15px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .payment-option .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .payment-option .card.active {
            border: 2px solid #4CAF50;
        }
        
        /* Fix for navbar dropdown positioning */
        .dropdown-menu {
            left: auto !important;
            right: 0 !important;
        }
        
        @media (max-width: 767px) {
            .dropdown-menu {
                width: 100%;
                position: absolute !important;
            }
        }
    </style>
</head>

<body>
    <x-app-layout>

    <div class="container">
        <div class="cart-container">
            <div class="d-flex align-items-center mb-4">
                <i class="fas fa-shopping-cart text-success me-3" style="font-size: 28px;"></i>
                <h1 class="mb-0 cart-header">Shopping Cart</h1>
            </div>

        @if(count($cart) > 0)
            <div class="table-responsive">
                <table class="table table-borderless align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="text-start">Product</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-end">Total</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach($cart as $id => $item)
                            <tr class="item-row">
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if(!empty($item['image']))
                                            <img src="{{ asset('img/' . $item['image']) }}" alt="{{ $item['name'] }}" class="product-img me-3" style="width: 60px; height: 60px;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; border-radius: 10px;">
                                                <i class="fas fa-pills text-secondary"></i>
                                            </div>
                                        @endif
                                        <span class="product-name">{{ $item['name'] }}</span>
                                    </div>
                                </td>
                                <td class="text-center price item-price" data-price="{{ $item['price'] }}">${{ number_format($item['price'], 2) }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center align-items-center quantity-control">
                                        <button type="button" class="btn btn-outline-secondary btn-quantity decrease-qty" data-id="{{ $id }}">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        
                                        <span class="mx-3 fw-bold item-quantity">{{ $item['quantity'] }}</span>
                                        
                                        <button type="button" class="btn btn-outline-success btn-quantity increase-qty" data-id="{{ $id }}">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="text-end price item-total">${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-danger btn-sm remove-item" data-id="{{ $id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            @php $total += $item['price'] * $item['quantity']; @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal:</span>
                                <span id="subtotal-price">${{ number_format($total, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Shipping:</span>
                                <span>$5.00</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-4">
                                <span class="fw-bold">Total:</span>
                                <span class="fw-bold fs-5" id="total-price">${{ number_format($total + 5, 2) }}</span>
                            </div>
                            <button type="button" class="btn btn-primary w-100" id="place-order-btn">
                                <i class="fas fa-credit-card me-2"></i> Proceed to Checkout
                            </button>
                            <form id="order-form" method="POST" action="{{ route('pharma.placeOrder') }}" style="display: none;">
                                @csrf
                                <input type="hidden" name="payment_method" id="payment_method" value="">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        @else
        <div class="empty-cart">
            <i class="fas fa-shopping-cart" style="font-size: 40px;"></i>
            <h4>Your cart is empty</h4>
            <p class="text-muted">Looks like you haven't added any products to your cart yet.</p>
            <a href="{{ route('pharma.index') }}" class="btn btn-primary mt-3 d-inline-flex align-items-center">
                <i class="fas fa-shopping-basket me-2" style="font-size: 18px; padding-top: 14px;"></i> <span class="d-none d-md-inline">Continue Shopping</span>
            </a>
        </div>
        
        @endif
        </div>
    </div>

    </x-app-layout>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Check authentication
            function checkAuth(callback) {
                @if(Auth::check())
                    callback(true);
                @else
                    Swal.fire({
                        title: 'Authentication Required',
                        text: 'Please login to continue shopping',
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonText: 'Login',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('login') }}";
                        }
                    });
                    callback(false);
                @endif
            }
            
            // Update cart totals
            function updateCartTotals() {
                let subtotal = 0;
                $('.item-row').each(function() {
                    const price = parseFloat($(this).find('.item-price').data('price'));
                    const quantity = parseInt($(this).find('.item-quantity').text());
                    const itemTotal = price * quantity;
                    subtotal += itemTotal;
                    $(this).find('.item-total').text('$' + itemTotal.toFixed(2));
                });
                
                $('#subtotal-price').text('$' + subtotal.toFixed(2));
                $('#total-price').text('$' + (subtotal + 5).toFixed(2));
                
                // If cart is empty, reload to show empty cart message
                if ($('.item-row').length === 0) {
                    location.reload();
                }
            }
            
            // Remove item from cart
            $('.remove-item').click(function() {
                const itemId = $(this).data('id');
                const itemRow = $(this).closest('tr');
                const url = "{{ route('pharma.removeFromCart', ':id') }}".replace(':id', itemId);
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to remove this item from your cart?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, remove it',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send delete request
                        $.ajax({
                            url: url,
                            type: 'GET',
                            success: function(response) {
                                if(response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Item Removed',
                                        text: response.message,
                                        confirmButtonText: 'OK',
                                        timer: 1500,
                                        confirmButtonColor: '#4CAF50'
                                    });
                                    
                                    // Remove the item row and update totals
                                    itemRow.fadeOut('slow', function() {
                                        $(this).remove();
                                        updateCartTotals();
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'An error occurred while removing the product',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#4CAF50'
                                });
                            }
                        });
                    }
                });
            });

            // Increase quantity
            $('.increase-qty').click(function() {
                const itemId = $(this).data('id');
                const quantityElement = $(this).siblings('span.fw-bold');
                const currentQty = parseInt(quantityElement.text());
                const url = "{{ route('pharma.increaseQuantity', ':id') }}".replace(':id', itemId);
                
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        // Update quantity display
                        quantityElement.text(currentQty + 1);
                        updateCartTotals();
                    }
                });
            });

            // Decrease quantity
            $('.decrease-qty').click(function() {
                const itemId = $(this).data('id');
                const quantityElement = $(this).siblings('span.fw-bold');
                const currentQty = parseInt(quantityElement.text());
                
                if (currentQty <= 1) {
                    // If quantity is 1, remove the item
                    $(this).closest('tr').find('.remove-item').click();
                    return;
                }
                
                const url = "{{ route('pharma.decreaseQuantity', ':id') }}".replace(':id', itemId);
                
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        // Update quantity display
                        quantityElement.text(currentQty - 1);
                        updateCartTotals();
                    }
                });
            });

            // Handle checkout process
            $('#place-order-btn').click(function() {
                checkAuth(function(isAuthenticated) {
                    if (!isAuthenticated) {
                        return;
                    }
                    
                    // Payment methods modal
                    Swal.fire({
                        title: '<h4 class="text-success"><i class="fas fa-credit-card me-2"></i>Select Payment Method</h4>',
                        html: `
                            <div class="payment-methods">
                                <div class="row mt-4">
                                    <div class="col-md-6 mb-4">
                                        <div class="payment-option" data-method="credit_card">
                                            <div class="card h-100 border-0 shadow-sm">
                                                <div class="card-body p-4 text-center">
                                                    <div class="bg-primary bg-gradient text-white mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; border-radius: 50%;">
                                                        <i class="fab fa-cc-visa fa-2x"></i>
                                                    </div>
                                                    <h5 class="card-title">Credit Card</h5>
                                                    <p class="card-text text-muted small mb-2">Visa, Mastercard, American Express</p>
                                                    <div class="mt-2">
                                                        <div class="payment-icons d-flex justify-content-center gap-2">
                                                            <i class="fab fa-cc-visa fa-2x text-primary"></i>
                                                            <i class="fab fa-cc-mastercard fa-2x text-danger"></i>
                                                            <i class="fab fa-cc-amex fa-2x text-info"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="payment-option" data-method="cash">
                                            <div class="card h-100 border-0 shadow-sm">
                                                <div class="card-body p-4 text-center">
                                                    <div class="bg-success bg-gradient text-white mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; border-radius: 50%;">
                                                        <i class="fas fa-money-bill-wave fa-2x"></i>
                                                    </div>
                                                    <h5 class="card-title">Cash on Delivery</h5>
                                                    <p class="card-text text-muted small mb-2">Pay cash when you receive your order</p>
                                                    <div class="mt-2">
                                                        <span class="badge bg-light text-success p-2 border border-success">Most Popular</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="payment-details" class="mt-4 d-none">
                            </div>
                        `,
                        background: '#ffffff',
                        width: 700,
                        padding: '2rem',
                        showCancelButton: true,
                        showConfirmButton: true,
                        confirmButtonText: '<i class="fas fa-check me-1"></i> Confirm Payment',
                        cancelButtonText: '<i class="fas fa-times me-1"></i> Cancel',
                        confirmButtonColor: '#4CAF50',
                        cancelButtonColor: '#dc3545',
                        focusConfirm: false,
                        customClass: {
                            confirmButton: 'btn btn-success px-4 py-2',
                            cancelButton: 'btn btn-danger px-4 py-2',
                            title: 'text-center mb-3',
                            popup: 'border-0 shadow'
                        },
                        buttonsStyling: false,
                        didOpen: () => {
                            // Handle payment method selection
                            $('.payment-option').on('click', function() {
                                $('.payment-option .card').removeClass('active').css('transform', '');
                                $(this).find('.card').addClass('active').css('transform', 'translateY(-10px)');
                                
                                const method = $(this).data('method');
                                $('#payment_method').val(method);
                                
                                // Show details based on payment method
                                $('#payment-details').removeClass('d-none');
                                
                                if (method === 'credit_card') {
                                    $('#payment-details').html(`
                                        <div class="card border-0 shadow-sm mt-4" style="border-radius: 12px; overflow: hidden;">
                                            <div class="card-header bg-primary text-white py-3">
                                                <h5 class="mb-0"><i class="fas fa-credit-card me-2"></i> Enter Card Details</h5>
                                            </div>
                                            <div class="card-body p-4">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Cardholder Name</label>
                                                    <input type="text" class="form-control" placeholder="Name as shown on card">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Card Number</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" placeholder="0000 0000 0000 0000">
                                                        <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label fw-bold">Expiration Date</label>
                                                        <input type="text" class="form-control" placeholder="MM/YY">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label fw-bold">Security Code (CVV)</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="123">
                                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-check mt-2">
                                                    <input class="form-check-input" type="checkbox" id="saveCardInfo">
                                                    <label class="form-check-label" for="saveCardInfo">
                                                        Save card information for future purchases
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    `);
                                } else if (method === 'cash') {
                                    $('#payment-details').html(`
                                        <div class="card border-0 shadow-sm mt-4" style="border-radius: 12px; overflow: hidden;">
                                            <div class="card-header bg-success text-white py-3">
                                                <h5 class="mb-0"><i class="fas fa-money-bill-wave me-2"></i> Cash on Delivery</h5>
                                            </div>
                                            <div class="card-body p-4">
                                                <div class="alert alert-success mb-4" role="alert">
                                                    <div class="d-flex">
                                                        <div class="pe-3">
                                                            <i class="fas fa-check-circle fa-2x"></i>
                                                        </div>
                                                        <div class="text-start">
                                                            <h5 class="alert-heading">Ready to confirm!</h5>
                                                            <p class="mb-0">You'll pay cash when your order is delivered. Please ensure you have the exact amount ready.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between bg-light p-3 rounded mb-3">
                                                    <span>Order Value:</span>
                                                    <span class="fw-bold">${{ number_format(array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cart)), 2) }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between bg-light p-3 rounded mb-3">
                                                    <span>Delivery Fee:</span>
                                                    <span class="fw-bold">$5.00</span>
                                                </div>
                                                <div class="d-flex justify-content-between bg-success bg-opacity-10 p-3 rounded">
                                                    <span class="fw-bold">Total Payment:</span>
                                                    <span class="fw-bold fs-5">${{ number_format(array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cart)) + 5, 2) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    `);
                                }
                            });

                            // Set default payment method (Cash on Delivery)
                            $('.payment-option[data-method="cash"]').click();
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const method = $('#payment_method').val();
                            if (!method) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Warning',
                                    text: 'Please select a payment method',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#4CAF50'
                                });
                                return;
                            }
                            
                            // Show loading screen
                            let timerInterval;
                            Swal.fire({
                                title: '<span class="text-success">Processing your order</span>',
                                html: `
                                    <div class="text-center">
                                        <div class="my-4">
                                            <div class="spinner-grow text-success" role="status" style="width: 3rem; height: 3rem;">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                        <p>We're processing your order, please wait...</p>
                                        <div class="progress mt-3" style="height: 10px;">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" style="width: 0%"></div>
                                        </div>
                                    </div>
                                `,
                                allowOutsideClick: false,
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    const progressBar = Swal.getHtmlContainer().querySelector('.progress-bar');
                                    timerInterval = setInterval(() => {
                                        const progressPercentage = Swal.getTimerLeft() ? (1 - Swal.getTimerLeft() / 3000) * 100 : 100;
                                        progressBar.style.width = progressPercentage + '%';
                                    }, 50);
                                },
                                willClose: () => {
                                    clearInterval(timerInterval);
                                }
                            }).then(() => {
                                // Show success message
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Order Confirmed!',
                                    text: 'Order details will be sent to your email',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#4CAF50'
                                }).then(() => {
                                    // Submit the form and redirect to orders page
                                    $.ajax({
                                        url: $('#order-form').attr('action'),
                                        type: 'POST',
                                        data: $('#order-form').serialize(),
                                        success: function(response) {
                                            // Redirect to orders page
                                            window.location.href = "{{ route('order.items') }}";
                                        },
                                        error: function(xhr) {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Error',
                                                text: 'An error occurred while processing your order',
                                                confirmButtonText: 'OK',
                                                confirmButtonColor: '#4CAF50'
                                            });
                                        }
                                    });
                                });
                            });
                        }
                    });
                });
            });
        });
    </script>

    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK',
                confirmButtonColor: '#4CAF50'
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK',
                confirmButtonColor: '#4CAF50'
            });
        </script>
    @endif
</body>
</html>
