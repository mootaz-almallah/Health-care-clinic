{{-- AdminController --}}


@extends('layouts.admin.app')

@section('header')
Appointments
@endsection

@section('content')


<link rel="stylesheet" href="{{ asset('css/dashboard.style.css') }}">

<div class="container">
    <table class="dashboard-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Patient Name</th>
                <th>Doctor Name</th>
                <th>Date</th>
                <th>Status</th>
                <th>Payment Status</th>
                <th>Actions</th> <!-- ✅ فعلنا العمود -->
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appointment)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $appointment->patient?->name ?? 'Walk-in' }}</td>
                    <td>{{ $appointment->doctor->name }}</td>
                    <td>{{ $appointment->appointment_date }}</td>
                    <td>{{ $appointment->status }}</td>
                    <td>{{ $appointment->payment_status }}</td>
                    <td>
                        <!-- ✅ زر تعديل -->
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal-{{ $appointment->id }}">
                            Edit
                        </button>
                        <!-- ✅ زر حذف -->
                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $appointment->id }}">
                            Delete
                        </button>
                    </td>
                </tr>

                <!-- ✅ Edit Modal -->
<!-- Edit Appointment Modal -->
<!-- Edit Appointment Modal -->
<div class="modal fade" id="editModal-{{ $appointment->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $appointment->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editModalLabel-{{ $appointment->id }}">Edit Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status-{{ $appointment->id }}" class="form-label">Appointment Status</label>
                        <select name="status" id="status-{{ $appointment->id }}" class="form-select" required>
                            <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $appointment->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="canceled" {{ $appointment->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="payment_status-{{ $appointment->id }}" class="form-label">Payment Status</label>
                        <select name="payment_status" id="payment_status-{{ $appointment->id }}" class="form-select" required>
                            <option value="paid" {{ $appointment->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="unpaid" {{ $appointment->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>



                <!-- ✅ Delete Modal -->
            <!-- Modal حذف موعد -->
<div class="modal fade" id="deleteModal-{{ $appointment->id }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $appointment->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST">
                @csrf
                @method('DELETE')

                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel-{{ $appointment->id }}">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    Are you sure you want to delete this appointment? This action cannot be undone.
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>


            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-4 d-flex justify-content-center">
        {{ $appointments->links() }}
    </div>
</div>

<!-- ✅ تأكد أن Bootstrap JS مفعّل -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection
