@extends('layouts.admin.app')

@section('header')
    Pharmacy Management
@endsection

@section('content')
<div class="container">

    <!-- Add New Pharmacy Button -->
    <div class="text-end mb-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPharmaModal">
            <i class="fas fa-plus"></i> Add New Pharmacy
        </button>
    </div>

    <!-- Pharmacies Table -->
    <table class="table table-striped dashboard-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Description</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pharmacies as $pharmacy)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    @if($pharmacy->image)
                        <img src="{{ asset('img/' . $pharmacy->image) }}" alt="{{ $pharmacy->name }}" width="50" height="50" class="rounded-circle">
                    @else
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="fas fa-pills text-muted"></i>
                        </div>
                    @endif
                </td>
                <td>{{ $pharmacy->name }}</td>
                <td>{{ $pharmacy->category->name ?? 'Uncategorized' }}</td>
                <td>{{ Str::limit($pharmacy->description, 50) }}</td>
                <td>${{ $pharmacy->price ? number_format($pharmacy->price, 2) : '0.00' }}</td>
                <td>
                    <span class="badge {{ $pharmacy->quantity > 10 ? 'bg-success' : ($pharmacy->quantity > 0 ? 'bg-warning text-dark' : 'bg-danger') }}">
                        {{ $pharmacy->quantity ?? 0 }}
                    </span>
                </td>
                <td>
                    <div class="d-flex gap-2">
                        <!-- View Details -->
                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewPharmaModal-{{ $pharmacy->id }}">
                            <i class="fas fa-eye"></i>
                        </button>

                        <!-- Edit -->
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editPharmaModal-{{ $pharmacy->id }}">
                            <i class="fas fa-edit"></i>
                        </button>

                        <!-- Delete -->
                        <form action="{{ route('pharmacies.destroy', $pharmacy->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>

            <!-- View Pharmacy Modal -->
            <div class="modal fade" id="viewPharmaModal-{{ $pharmacy->id }}" tabindex="-1" aria-labelledby="viewPharmaModalLabel-{{ $pharmacy->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Pharmacy Details: {{ $pharmacy->name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4 text-center">
                                    @if($pharmacy->image)
                                        <img src="{{ asset('img/' . $pharmacy->image) }}" class="img-fluid rounded mb-3" style="max-height: 200px;">
                                    @else
                                        <div class="avatar-placeholder" style="width: 200px; height: 200px; background-color: #eee; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-pills fa-4x text-muted"></i>
                                        </div>
                                    @endif
                                    <h5 class="mt-2">{{ $pharmacy->name }}</h5>
                                    <p class="text-muted">{{ $pharmacy->category->name ?? 'Uncategorized' }}</p>
                                </div>
                                <div class="col-md-8">
                                    <p><strong>Price:</strong> ${{ $pharmacy->price ? number_format($pharmacy->price, 2) : '0.00' }}</p>
                                    <p><strong>Quantity:</strong> {{ $pharmacy->quantity ?? 0 }}</p>
                                    <p><strong>Description:</strong> {{ $pharmacy->description ?? 'No description available' }}</p>
                                    <p><strong>Created At:</strong> {{ $pharmacy->created_at ? $pharmacy->created_at->format('Y-m-d H:i') : 'N/A' }}</p>
                                    <p><strong>Updated At:</strong> {{ $pharmacy->updated_at ? $pharmacy->updated_at->format('Y-m-d H:i') : 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Pharmacy Modal -->
            <div class="modal fade" id="editPharmaModal-{{ $pharmacy->id }}" tabindex="-1" aria-labelledby="editPharmaModalLabel-{{ $pharmacy->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Pharmacy: {{ $pharmacy->name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('pharmacies.update', $pharmacy->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Name *</label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name', $pharmacy->name) }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Category *</label>
                                        <select class="form-select" name="category_id" required>
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id', $pharmacy->category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Price *</label>
                                        <input type="number" step="0.01" class="form-control" name="price" value="{{ old('price', $pharmacy->price) }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Quantity *</label>
                                        <input type="number" class="form-control" name="quantity" value="{{ old('quantity', $pharmacy->quantity) }}" required>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" name="description" rows="3">{{ old('description', $pharmacy->description) }}</textarea>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Product Image</label>
                                        <input type="text" class="form-control" name="image">
                                        @if($pharmacy->image)
                                            <small class="d-block mt-2">Current Image:</small>
                                            <img src="{{ asset('img/' . $pharmacy->image) }}" alt="Current Image" width="100">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-primary" type="submit">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @endforeach
        </tbody>
    </table>

    <!-- Create New Pharmacy Modal -->
    <div class="modal fade" id="createPharmaModal" tabindex="-1" aria-labelledby="createPharmaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Pharmacy</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('pharmacies.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Name *</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category *</label>
                                <select class="form-select" name="category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Price *</label>
                                <input type="number" step="0.01" class="form-control" name="price" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Quantity *</label>
                                <input type="number" class="form-control" name="quantity" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="3"></textarea>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Product Image</label>
                                <input type="text" class="form-control" name="image">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-success" type="submit">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
