<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicine List - Health Pulse</title>

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
    <link rel="stylesheet" href="{{ asset('css/all-css/pharmacy.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all-css/modal.css') }}">
</head>
<body dir="ltr">
<x-app-layout>
<!-- Page Header -->
<header class="page-header text-center">
    <div class="container">
        <h1>E-Pharmacy</h1>
        <p>Browse a wide range of medicines and order easily from your home</p>
    </div>
</header>

<!-- Quick Action Buttons -->
<div class="container mb-4">
    <div class="d-flex justify-content-end">
        <a href="{{ route('cart.index') }}" class="btn btn-outline-primary position-relative me-2" style="padding: 0.5rem 1rem;">
            <i class="fas fa-shopping-cart me-1"></i> Cart
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ count(session('cart', [])) }}
            </span>
        </a>
        <a href="{{ route('order.items') }}" class="btn btn-outline-success" style="padding: 0.5rem 1rem;">
            <i class="fas fa-history me-1"></i> Order History
        </a>
    </div>
</div>

<div class="container">
    <div class="row">
        <!-- Sidebar Panel -->
        <div class="col-md-3 splitter-col">
            <div class="sidebar-panel">
                <h5 class="mb-3">Search Medicines</h5>
                <form method="GET" action="{{ route('pharma.index') }}" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search medicine name..." value="{{ request('q') }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
                <h5 class="mb-3">Categories</h5>
                <div class="category-buttons">
                    <a href="{{ route('pharma.index') }}" class="btn btn-outline-primary {{ request('category') == '' ? 'active' : '' }}">
                        <i class="fas fa-th-large me-1"></i> All
                    </a>
                    @foreach ($categories as $cat)
                        <a href="{{ route('pharma.index', ['category' => $cat->id]) }}"
                           class="btn btn-outline-primary {{ request('category') == $cat->id ? 'active' : '' }}">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <h2 class="text-center pharma-header">Medicine List</h2>
            
            @if(count($medicines) > 0)
                <div class="medicine-grid">
                    @php $cart = session('cart', []); @endphp
                    @foreach ($medicines as $med)
                        <div class="medicine-item">
                            <div class="card medicine-card h-100">
                                <img src="{{ $med->image ? asset('img/' . $med->image) : 'https://via.placeholder.com/150' }}"
                                             class="card-img-top" alt="{{ $med->name }}"
                                             style="cursor: pointer;"
                                             onclick="showMedicineDetails({{ $med->id }}, '{{ $med->name }}', '{{ $med->description }}', '{{ $med->price }}', '{{ $med->image ? asset('img/' . $med->image) : 'https://via.placeholder.com/150' }}', '{{ $med->category->name ?? 'No Category' }}')">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $med->name }}</h5>
                                    <p class="card-text">{{ Str::limit($med->description, 60) }}</p>
                                    <div class="price">${{ $med->price }}</div>
                                    <div class="cart-actions" id="cart-actions-{{ $med->id }}">
                                        @if(array_key_exists($med->id, $cart))
                                            <a href="{{ route('pharma.removeFromCart', $med->id) }}"
                                               class="btn btn-danger btn-cart btn-remove-cart remove-from-cart-btn" data-id="{{ $med->id }}">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                            <span class="btn btn-secondary btn-cart flex-grow-1 disabled">
                                                <i class="fas fa-check me-1"></i> In Cart
                                            </span>
                                        @else
                                            <a href="{{ route('pharma.addToCart', $med->id) }}"
                                               class="btn btn-success btn-cart btn-add-cart add-to-cart-btn" data-id="{{ $med->id }}">
                                                <i class="fas fa-cart-plus me-1"></i> Add to Cart
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-result">
                    <i class="fas fa-search mb-3"></i>
                    <h4>No matching medicines found</h4>
                    <p class="text-muted">Try searching with different keywords or browse all medicines.</p>
                    <a href="{{ route('pharma.index') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-th-large me-1"></i> View All Medicines
                    </a>
                </div>
            @endif
            
                    <!-- Pagination -->
            @if($medicines->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    {{ $medicines->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

        <!-- Toast Container -->
        <div aria-live="polite" aria-atomic="true" class="position-relative">
            <div id="cart-toast-container" class="bootstrap-toast" style="display:none;"></div>
        </div>

        <!-- Medicine Details Modal -->
        <div class="modal fade" id="medicineDetailsModal" tabindex="-1" aria-labelledby="medicineDetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="medicineDetailsModalLabel">Medicine Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <img id="modalMedicineImage" src="" alt="Medicine Image" class="img-fluid rounded">
                            </div>
                            <div class="col-md-8">
                                <h4 id="modalMedicineName" class="mb-3"></h4>
                                <p class="text-muted mb-2">Category: <span id="modalMedicineCategory"></span></p>
                                <p class="text-primary mb-3">Price: $<span id="modalMedicinePrice"></span></p>
                                <div class="mb-3">
                                    <h6>Description:</h6>
                                    <p id="modalMedicineDescription" class="text-muted"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="modalAddToCartBtn">
                            <i class="fas fa-cart-plus me-1"></i> Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function () {
            function updateCartCount() {
                $.get("{{ route('cart.count') }}", function(data) {
                    $("#cart-count-navbar").text(data.count);
                });
            }
            
            function showToast(message) {
                const toastHtml = `
                    <div class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">${message}</div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>`;
                $('#cart-toast-container').html(toastHtml).fadeIn(200);
                setTimeout(function(){ $('#cart-toast-container').fadeOut(500); }, 1800);
            }
            
            function checkAuth(callback) {
                @auth
                    callback(true);
                @else
                    Swal.fire({
                        title: 'Login Required',
                        text: 'Please login to add items to your cart',
                        icon: 'warning',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Login Now',
                        showCancelButton: true,
                        cancelButtonText: 'Cancel',
                        cancelButtonColor: '#d33'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('login') }}";
                        }
                    });
                    callback(false);
                @endauth
            }
            
            $(document).on('click', '.add-to-cart-btn', function (e) {
                e.preventDefault();
                const $btn = $(this);
                const productId = $btn.data('id');
                const actionsContainer = $(`#cart-actions-${productId}`);
                
                checkAuth(function (isAuthenticated) {
                    if (isAuthenticated) {
                        const url = "{{ route('pharma.addToCart', ':id') }}".replace(':id', productId);
                        $.get(url, function (response) {
                            if (response.success) {
                                showToast('Added to cart successfully!');
                                updateCartCount();
                                 location.reload();
                            }
                        }).fail(function () {
                            showToast('Error adding product to cart.');
                        });
                    }
                });
            });
            
            $(document).on('click', '.remove-from-cart-btn', function (e) {
                e.preventDefault();
                const $btn = $(this);
                const productId = $btn.data('id');
                const actionsContainer = $(`#cart-actions-${productId}`);
                const url = $btn.attr('href');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to remove this medicine from the cart?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, remove it',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.get(url, function (response) {
                            if (response.success) {
                                showToast('Removed from cart.');
                                updateCartCount();
                                 location.reload();
                            }
                        }).fail(function () {
                            showToast('Error removing product.');
                        });
                    }
                });
            });
        });

        function showMedicineDetails(id, name, description, price, image, category) {
            document.getElementById('modalMedicineName').textContent = name;
            document.getElementById('modalMedicineDescription').textContent = description;
            document.getElementById('modalMedicinePrice').textContent = price;
            document.getElementById('modalMedicineImage').src = image;
            document.getElementById('modalMedicineCategory').textContent = category;
            
            const addToCartBtn = document.getElementById('modalAddToCartBtn');
            const cartActions = document.getElementById(`cart-actions-${id}`);
            
            if (cartActions.querySelector('.remove-from-cart-btn')) {
                addToCartBtn.innerHTML = '<i class="fas fa-check me-1"></i> In Cart';
                addToCartBtn.disabled = true;
                addToCartBtn.classList.remove('btn-primary');
                addToCartBtn.classList.add('btn-secondary');
            } else {
                addToCartBtn.innerHTML = '<i class="fas fa-cart-plus me-1"></i> Add to Cart';
                addToCartBtn.disabled = false;
                addToCartBtn.classList.remove('btn-secondary');
                addToCartBtn.classList.add('btn-primary');
                addToCartBtn.onclick = function() {
                    const addToCartLink = cartActions.querySelector('.add-to-cart-btn');
                    if (addToCartLink) {
                        addToCartLink.click();
                    }
                };
            }
            
            const modal = new bootstrap.Modal(document.getElementById('medicineDetailsModal'));
            modal.show();
        }
    </script>
</body>
</html>