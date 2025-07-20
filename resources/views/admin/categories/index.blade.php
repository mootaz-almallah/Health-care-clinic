{{-- CategoryController --}}


@extends('layouts.admin.app')
@section('header')
Categories Management
@endsection

@section('content')
<div class="container">
    <!-- Categories Table -->
      <div class="text-end mt-3">
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Category
        </a>
    </div>

    <table class="table table-striped dashboard-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
               
                <th>Description</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="avatar-placeholder rounded-circle me-2" style="width: 40px; height: 40px; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-tags text-muted"></i>
                            </div>
                            <div>
                                <strong>{{ $category->name }}</strong>
                            </div>
                        </div>
                    </td>
                   
                    <td>{{ Str::limit($category->description, 50) }}</td>
                    <td>{{ $category->created_at ? $category->created_at->format('Y-m-d H:i') : 'N/A' }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <!-- Edit Button -->
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-primary p-2" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>

                            <!-- Delete Button -->
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger p-2" title="Delete" onclick="return confirm('Are you sure you want to delete this category?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Add New Category Button -->
  
    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $categories->links() }}
    </div>
</div>
@endsection 