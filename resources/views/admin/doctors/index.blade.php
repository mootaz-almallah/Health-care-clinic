
{{-- DoctorController --}}

@extends('layouts.admin.app')

@section('header')
Doctors Management
@endsection

@section('content')
<div class="container">
    <!-- Doctors Table -->
    <table class="table table-striped dashboard-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Specialization</th>
                <th>Governorate</th>
                <th>Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($doctors as $doctor)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            @if(isset($doctor->image) && $doctor->image)
                                <img src="{{ asset('storage/' . $doctor->image) }}" alt="{{ $doctor->name }}" class="rounded-circle me-2" width="40" height="40">
                            @else
                                <div class="avatar-placeholder rounded-circle me-2" style="width: 40px; height: 40px; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-user-md text-muted"></i>
                                </div>
                            @endif
                            <div>
                                <strong>{{ $doctor->name }}</strong>
                                <div class="text-muted small">{{ $doctor->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $doctor->specialization->name ?? 'N/A' }}</td>
                    <td>{{ $doctor->governorate ?? 'N/A' }}</td>
                    <td>{{ number_format($doctor->price_per_appointment ?? 0, 2) }} JOD</td>
                    <td>
                        <span class="badge
                            @if($doctor->status == 'approved') bg-success
                            @elseif($doctor->status == 'pending') bg-warning text-dark
                            @else bg-danger
                            @endif">
                            {{ ucfirst($doctor->status) }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <!-- View Details Button -->
                            <button type="button" class="btn btn-sm btn-info p-2" data-bs-toggle="modal" data-bs-target="#viewDoctorModal-{{ $doctor->id }}" title="View Details">
                                <i class="fas fa-eye"></i>
                            </button>

                            <!-- Edit Button -->
                            <button type="button" class="btn btn-sm btn-primary p-2" data-bs-toggle="modal" data-bs-target="#editDoctorModal-{{ $doctor->id }}" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>

                            <!-- Status Buttons -->
                            @if($doctor->status == 'pending')


                                <form action="{{ route('doctors.update-status', $doctor->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="btn btn-sm btn-success p-2" title="Approve">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                <form action="{{ route('doctors.update-status', $doctor->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="btn btn-sm btn-danger p-2" title="Reject">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            @elseif($doctor->status == 'approved')
                                <form action="{{ route('doctors.update-status', $doctor->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="btn btn-sm btn-danger p-2" title="Reject">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('doctors.update-status', $doctor->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="btn btn-sm btn-success p-2" title="Approve">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>

                <!-- View Doctor Modal -->
                <div class="modal fade" id="viewDoctorModal-{{ $doctor->id }}" tabindex="-1" aria-labelledby="viewDoctorModalLabel-{{ $doctor->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewDoctorModalLabel-{{ $doctor->id }}">Doctor Details: {{ $doctor->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-4 text-center">
                                        @if(isset($doctor->image) && $doctor->image)
                                            <img src="{{ asset('storage/' . $doctor->image) }}" alt="{{ $doctor->name }}" class="img-fluid rounded mb-3" style="max-height: 200px;">
                                        @else
                                            <div class="avatar-placeholder rounded mb-3" style="width: 200px; height: 200px; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                                <i class="fas fa-user-md fa-4x text-muted"></i>
                                            </div>
                                        @endif
                                        <h5>{{ $doctor->name }}</h5>
                                        <p class="text-muted">{{ $doctor->specialization->name ?? 'N/A' }}</p>
                                        <span class="badge
                                            @if($doctor->status == 'approved') bg-success
                                            @elseif($doctor->status == 'pending') bg-warning text-dark
                                            @else bg-danger
                                            @endif">
                                            {{ ucfirst($doctor->status) }}
                                        </span>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <p><strong>Email:</strong> {{ $doctor->email }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Phone:</strong> {{ $doctor->phone ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <p><strong>Governorate:</strong> {{ $doctor->governorate ?? 'N/A' }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Address:</strong> {{ $doctor->address ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <p><strong>Experience:</strong> {{ $doctor->experience_years ?? '0' }} years</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Price:</strong> ${{ number_format($doctor->price_per_appointment ?? 0, 2) }}</p>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <p><strong>Bio:</strong></p>
                                            <p>{{ $doctor->bio ?? 'No bio provided' }}</p>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <p><strong>Working Hours:</strong>
                                                    @isset($doctor->working_hours_start)
                                                        {{ \Carbon\Carbon::parse($doctor->working_hours_start)->format('h:i A') }} -
                                                        {{ \Carbon\Carbon::parse($doctor->working_hours_end)->format('h:i A') }}
                                                    @else
                                                        N/A
                                                    @endisset
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Available Days:</strong></p>
                                                <div class="d-flex flex-wrap gap-2">
                                                    @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                                                        @if($doctor->$day)
                                                            <span class="badge bg-primary">{{ ucfirst($day) }}</span>
                                                        @endif
                                                    @endforeach
                                                    @if(!$doctor->monday && !$doctor->tuesday && !$doctor->wednesday && !$doctor->thursday && !$doctor->friday && !$doctor->saturday && !$doctor->sunday)
                                                        <span class="text-muted">No days selected</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @if(isset($doctor->doctor_document) && $doctor->doctor_document)
                                        <div class="mb-3">
                                            <p><strong>Doctor Document:</strong></p>
                                            <div class="d-flex gap-2 document-actions">
                                                <a href="{{ asset('storage/' . $doctor->doctor_document) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> View PDF
                                                </a>
                                                <a href="{{ asset('storage/' . $doctor->doctor_document) }}" download class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-download"></i> Download
                                                </a>

                                            </div>
                                            <div class="mt-2">
                                                <small class="text-muted">Document last updated: {{ $doctor->updated_at->format('M d, Y H:i') }}</small>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Doctor Modal -->
                <div class="modal fade" id="editDoctorModal-{{ $doctor->id }}" tabindex="-1" aria-labelledby="editDoctorModalLabel-{{ $doctor->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editDoctorModalLabel-{{ $doctor->id }}">Edit Doctor: {{ $doctor->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('doctors.update', $doctor->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="name-{{ $doctor->id }}" class="form-label">Name *</label>
                                                <input type="text" class="form-control" id="name-{{ $doctor->id }}" name="name" value="{{ old('name', $doctor->name) }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="email-{{ $doctor->id }}" class="form-label">Email *</label>
                                                <input type="email" class="form-control" id="email-{{ $doctor->id }}" name="email" value="{{ old('email', $doctor->email) }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="phone-{{ $doctor->id }}" class="form-label">Phone</label>
                                                <input type="text" class="form-control" id="phone-{{ $doctor->id }}" name="phone" value="{{ old('phone', $doctor->phone) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="specialization_id-{{ $doctor->id }}" class="form-label">Specialization *</label>
                                                <select class="form-select" id="specialization_id-{{ $doctor->id }}" name="specialization_id" required>
                                                    <option value="">Select Specialization</option>
                                                    @foreach ($specializations as $specialization)
                                                        <option value="{{ $specialization->id }}" {{ old('specialization_id', $doctor->specialization_id) == $specialization->id ? 'selected' : '' }}>
                                                            {{ $specialization->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="governorate-{{ $doctor->id }}" class="form-label">Governorate</label>
                                                <select class="form-select" id="governorate-{{ $doctor->id }}" name="governorate">
                                                    <option value="">Select Governorate</option>
                                                    @foreach(['Amman', 'Irbid', 'Ajloun', 'Aqaba', 'Balqa', 'Zarqa', 'Mafraq', 'Maan', 'Tafilah', 'Karak', 'Jerash'] as $gov)
                                                        <option value="{{ $gov }}" {{ old('governorate', $doctor->governorate) == $gov ? 'selected' : '' }}>{{ $gov }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="address-{{ $doctor->id }}" class="form-label">Address</label>
                                                <input type="text" class="form-control" id="address-{{ $doctor->id }}" name="address" value="{{ old('address', $doctor->address) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="experience_years-{{ $doctor->id }}" class="form-label">Experience (Years)</label>
                                                <input type="number" class="form-control" id="experience_years-{{ $doctor->id }}" name="experience_years" value="{{ old('experience_years', $doctor->experience_years) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="price_per_appointment-{{ $doctor->id }}" class="form-label">Price Per Appointment (JOD)</label>
                                                <input type="number" step="0.01" class="form-control" id="price_per_appointment-{{ $doctor->id }}" name="price_per_appointment" value="{{ old('price_per_appointment', $doctor->price_per_appointment) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="bio-{{ $doctor->id }}" class="form-label">Bio</label>
                                                <textarea class="form-control" id="bio-{{ $doctor->id }}" name="bio" rows="3">{{ old('bio', $doctor->bio) }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="image-{{ $doctor->id }}" class="form-label">Profile Image</label>
                                                <input type="file" class="form-control" id="image-{{ $doctor->id }}" name="image">
                                                @if(isset($doctor->image) && $doctor->image)
                                                    <small class="text-muted">Current: {{ basename($doctor->image) }}</small>
                                                    <div class="mt-2">
                                                        <img src="{{ asset('storage/' . $doctor->image) }}" alt="Current Image" width="100">
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label for="doctor_document-{{ $doctor->id }}" class="form-label">Doctor Document (PDF)</label>
                                                <input type="file" class="form-control" id="doctor_document-{{ $doctor->id }}" name="doctor_document" accept=".pdf">
                                                @if(isset($doctor->doctor_document) && $doctor->doctor_document)
                                                    <small class="text-muted">Current: {{ basename($doctor->doctor_document) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Available Days</label>
                                                <div class="d-flex flex-wrap gap-3">
                                                    @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="{{ $day }}-{{ $doctor->id }}" name="{{ $day }}" {{ old($day, $doctor->$day) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="{{ $day }}-{{ $doctor->id }}">{{ ucfirst($day) }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="working_hours_start-{{ $doctor->id }}" class="form-label">Working Hours Start</label>
                                                        <input type="time" class="form-control" id="working_hours_start-{{ $doctor->id }}" name="working_hours_start" value="{{ old('working_hours_start', $doctor->working_hours_start ? \Carbon\Carbon::parse($doctor->working_hours_start)->format('H:i') : '09:00') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="working_hours_end-{{ $doctor->id }}" class="form-label">Working Hours End</label>
                                                        <input type="time" class="form-control" id="working_hours_end-{{ $doctor->id }}" name="working_hours_end" value="{{ old('working_hours_end', $doctor->working_hours_end ? \Carbon\Carbon::parse($doctor->working_hours_end)->format('H:i') : '17:00') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="status-{{ $doctor->id }}" class="form-label">Status</label>
                                                <select class="form-select" id="status-{{ $doctor->id }}" name="status">
                                                    <option value="pending" {{ old('status', $doctor->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="approved" {{ old('status', $doctor->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                                    <option value="rejected" {{ old('status', $doctor->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                </select>
                                            </div>
                                        </div>
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
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-4 d-flex justify-content-center">
        {{ $doctors->links() }}
    </div>
</div>
@endsection

@section('styles')
<style>
    .avatar-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f0f0f0;
    }
    .badge {
        font-size: 0.85em;
    }
    .document-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: center;
    }
    .form-check {
        min-width: 100px;
    }
</style>
@endsection

@section('scripts')
@if(session('success'))
<script>
    Toast.fire({
        icon: 'success',
        title: '{{ session('success') }}'
    });
</script>
@endif
@if(session('error'))
<script>
    Toast.fire({
        icon: 'error',
        title: '{{ session('error') }}'
    });
</script>
@endif
@endsection
