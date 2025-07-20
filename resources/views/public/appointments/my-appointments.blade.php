<x-app-layout>

    <div class="container my-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-lg border-0">
                    <div class="card-header  text-white d-flex justify-content-between align-items-center"style="background-color: #007bff;">
                        <h3 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>My Appointments</h3>
                        <a href="{{ route('doctors') }}" class="btn btn-light">
                            <i class="fas fa-plus-circle me-1"></i> Book New Appointment
                        </a>
                    </div>
                    <div class="card-body p-0">
                        @if(session('success'))
                            <div class="alert alert-primary m-3">
                                {{ session('success') }}
                            </div>
                        @endif
    
                        @if($appointments->isEmpty())
                            <div class="text-center py-5">
                                <img src="https://img.icons8.com/color/96/000000/calendar--v2.png" alt="No Appointments" class="mb-3 opacity-50" width="120">
                                <h4 class="text-muted">No appointments booked yet</h4>
                                <p class="text-muted">Book an appointment with a doctor by clicking the "Book New Appointment" button</p>
                                <a href="{{ route('doctors') }}" class="btn btn-primary mt-2">
                                    <i class="fas fa-calendar-plus me-1"></i> Book New Appointment
                                </a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-primary">
                                        <tr>
                                            <th class="fw-bold">Doctor</th>
                                            <th class="fw-bold">Specialization</th>
                                            <th class="fw-bold">Date</th>
                                            <th class="fw-bold">Time</th>
                                            <th class="fw-bold">Status</th>
                                            <th class="fw-bold">Payment Status</th>
                                            <th class="fw-bold">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($appointments as $appointment)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($appointment->doctor && $appointment->doctor->image)
                                                            <img src="{{ asset('storage/' . $appointment->doctor->image) }}" alt="{{ $appointment->doctor->name }}" class="rounded-circle me-2" width="40" height="40">
                                                        @else
                                                            <div class="bg-primary rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                                <i class="fas fa-user-md text-white"></i>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <p class="mb-0 fw-medium">{{ $appointment->doctor->name ?? 'Not Available' }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $appointment->doctor->specialization->name ?? 'Not Available' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</td>
                                                <td>
                                                    <span class="badge bg-primary">
                                                        {{
                                                            [
                                                                'pending' => 'Pending',
                                                                'confirmed' => 'Confirmed',
                                                                'canceled' => 'Canceled',
                                                                'completed' => 'Completed'
                                                            ][$appointment->status] ?? $appointment->status
                                                        }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge {{ $appointment->payment_status == 'paid' ? 'bg-primary' : 'bg-info' }}">
                                                        {{ $appointment->payment_status == 'paid' ? 'Paid' : 'Unpaid' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($appointment->status == 'pending')
                                                        <!-- Cancel Button -->
                                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#cancelModal{{ $appointment->id }}">
                                                            <i class="fas fa-times-circle"></i> Cancel
                                                        </button>
    
                                                        <!-- Cancel Confirmation Modal -->
                                                        <div class="modal fade" id="cancelModal{{ $appointment->id }}" tabindex="-1" aria-labelledby="cancelModalLabel{{ $appointment->id }}" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-primary text-white">
                                                                        <h5 class="modal-title" id="cancelModalLabel{{ $appointment->id }}">Cancel Confirmation</h5>
                                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Are you sure you want to cancel this appointment?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <form action="{{ route('appointments.cancel', $appointment->id) }}" method="POST">
                                                                            @csrf
                                                                            @method('PATCH')
                                                                            <button type="submit" class="btn btn-primary">Yes, Cancel</button>
                                                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Back</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span class="text-muted">No Action</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    </x-app-layout>