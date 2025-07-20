{{-- specializations.blade --}}




@extends('layouts.admin.app')

@section('header')
Specializations
@endsection

@section('content')

<!-- Add this line to include the CSS -->
<link rel="stylesheet" href="{{ asset('css/dashboard.style.css') }}">

<!-- Button to Trigger the Modal -->
<div class="d-flex justify-content-end mb-3">
    <button type="button" class="btn" style="background-color: #e12454; color: white;"data-bs-toggle="modal" data-bs-target="#addSpecializationModal">
        Add Specialization
    </button>
</div>

<!-- Add Specialization Modal -->
<div class="modal fade" id="addSpecializationModal" tabindex="-1" aria-labelledby="addSpecializationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSpecializationModalLabel">Add New Specialization</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('specializations.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter specialization name" required>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Specialization</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container">
    <table class="dashboard-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th>Created By</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($specializations as $specialization)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $specialization->name }}</td>
                    <td>{{ $specialization->description ?? 'No description' }}</td>
                    <td>{{ $specialization->createdBy->name }}</td>
                    <td>{{ $specialization->created_at }}</td>
                    <td>{{ $specialization->updated_at }}</td>
                    <td>
                        <div class="d-flex gap-2">
                          
                            <button type="button" class="btn btn-primary p-2" data-bs-toggle="modal" data-bs-target="#editModal-{{ $specialization->id }}">
                                Edit
                            </button>

                          
                            <button type="button" class="btn btn-danger p-2" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $specialization->id }}">
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>

          
                <div class="modal fade" id="editModal-{{ $specialization->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $specialization->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel-{{ $specialization->id }}">Edit Specialization: {{ $specialization->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('specializations.update', $specialization->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="name-{{ $specialization->id }}" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name-{{ $specialization->id }}" name="name" value="{{ $specialization->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description-{{ $specialization->id }}" class="form-label">Description</label>
                                        <textarea class="form-control" id="description-{{ $specialization->id }}" name="description">{{ $specialization->description }}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

           
                <div class="modal fade" id="deleteModal-{{ $specialization->id }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $specialization->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel-{{ $specialization->id }}">Confirm Deletion</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete specialization "{{ $specialization->name }}"? This action cannot be undone.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form action="{{ route('specializations.destroy', $specialization->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Confirm Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4 d-flex justify-content-center">
        {{ $specializations->links() }}
    </div>
</div>

@endsection