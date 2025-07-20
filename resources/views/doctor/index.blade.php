@extends('layouts.public.doctorPortal')

@section('styles')
<style>
    :root {
        --primary: #3b82f6;
        --primary-dark: #2563eb;
        --secondary: #10b981;
        --accent: #8b5cf6;
        --warning: #f59e0b;
        --danger: #ef4444;
        --dark: #1e293b;
        --light: #f8fafc;
        --border: #e2e8f0;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
    }

    * {
        box-sizing: border-box;
    }

    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        box-shadow: var(--shadow-xl);
    }

    .sidebar-card {
        background: linear-gradient(145deg, #1e293b, #334155);
        border-radius: 24px;
        overflow: hidden;
        position: relative;
    }

    .sidebar-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, var(--primary), var(--secondary), var(--accent));
    }

    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2rem;
        text-align: center;
        position: relative;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 4px solid rgba(255, 255, 255, 0.3);
        object-fit: cover;
        margin: 0 auto;
        display: block;
        transition: transform 0.3s ease;
    }

    .profile-avatar:hover {
        transform: scale(1.05);
    }

    .avatar-fallback {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: 700;
        color: white;
        margin: 0 auto;
    }

    .status-indicator {
        position: absolute;
        bottom: 8px;
        right: 8px;
        width: 16px;
        height: 16px;
        background: var(--secondary);
        border: 3px solid white;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    .btn-modern {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        box-shadow: var(--shadow-md);
    }

    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
        background: linear-gradient(135deg, var(--primary-dark), var(--primary));
    }

    .btn-success {
        background: linear-gradient(135deg, var(--secondary), #059669);
    }

    .btn-danger {
        background: linear-gradient(135deg, var(--danger), #dc2626);
    }

    .btn-sm {
        padding: 8px 16px;
        font-size: 12px;
        border-radius: 8px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 16px;
        padding: 1.5rem;
        text-align: center;
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-size: 0.875rem;
        opacity: 0.8;
    }

    .info-section {
        padding: 2rem;
        color: white;
    }

    .info-item {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
        padding: 0.75rem;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.05);
        transition: background 0.3s ease;
    }

    .info-item:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .info-icon {
        width: 20px;
        height: 20px;
        margin-right: 12px;
        opacity: 0.8;
    }

    .day-badge {
        display: inline-block;
        background: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        margin: 2px;
        font-weight: 500;
    }

    .appointments-header {
        background: white;
        padding: 2rem;
        border-radius: 24px 24px 0 0;
        border-bottom: 1px solid var(--border);
    }

    .appointments-content {
        background: white;
        padding: 2rem;
        border-radius: 0 0 24px 24px;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 1.5rem;
        position: relative;
        padding-bottom: 0.5rem;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), var(--secondary));
        border-radius: 2px;
    }

    .table-modern {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }

    .table-modern th {
        background: var(--light);
        padding: 1.5rem 2rem;
        text-align: right;
        font-weight: 600;
        color: var(--dark);
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table-modern td {
        padding: 1.5rem 2rem;
        border-top: 1px solid var(--border);
        vertical-align: middle;
        text-align: right;
    }

    .table-modern tr:hover {
        background: var(--light);
    }

    /* إضافة مسافات بين الأعمدة */
    .table-modern th:not(:last-child),
    .table-modern td:not(:last-child) {
        border-right: 1px solid var(--border);
    }

    /* إضافة مسافات إضافية لأعمدة معينة */
    .table-modern th:nth-child(2),
    .table-modern td:nth-child(2) {
        padding-left: 3rem;
    }

    .table-modern th:nth-child(3),
    .table-modern td:nth-child(3) {
        padding-left: 3rem;
    }

    .table-modern th:nth-child(4),
    .table-modern td:nth-child(4) {
        padding-left: 3rem;
    }

    /* تعديل محاذاة النص في خلايا الجدول */
    .patient-info {
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }

    .patient-details {
        text-align: right;
    }

    .patient-details h4 {
        font-weight: 600;
        color: var(--dark);
        margin: 0 0 4px 0;
        font-size: 1rem;
    }

    .patient-details p {
        color: var(--text-muted);
        font-size: 0.875rem;
        margin: 0;
    }

    .actions-group {
        display: flex;
        gap: 8px;
        align-items: center;
        justify-content: flex-end;
    }

    .patient-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--border);
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-pending {
        background: rgba(245, 158, 11, 0.1);
        color: var(--warning);
        border: 1px solid rgba(245, 158, 11, 0.3);
    }

    .status-confirmed {
        background: rgba(16, 185, 129, 0.1);
        color: var(--secondary);
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .status-cancelled {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger);
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .status-completed {
        background: rgba(59, 130, 246, 0.1);
        color: var(--primary);
        border: 1px solid rgba(59, 130, 246, 0.3);
    }

    .action-link {
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
        font-size: 14px;
        padding: 6px 12px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .action-link:hover {
        background: rgba(59, 130, 246, 0.1);
        color: var(--primary-dark);
    }

    .modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(8px);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        animation: fadeIn 0.3s ease;
    }

    .modal-content {
        background: white;
        border-radius: 24px;
        width: 90%;
        max-width: 600px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: var(--shadow-xl);
        animation: slideUp 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from { transform: translateY(50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .modal-header {
        padding: 2rem 2rem 1rem 2rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        justify-content: between;
        align-items: center;
    }

    .modal-body {
        padding: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--dark);
    }

    .form-input {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid var(--border);
        border-radius: 12px;
        font-size: 16px;
        transition: all 0.3s ease;
        background: white;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .date-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }

    .date-card {
        border: 2px solid var(--border);
        border-radius: 12px;
        padding: 1rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
    }

    .date-card:hover {
        border-color: var(--primary);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .date-card.selected {
        border-color: var(--primary);
        background: rgba(59, 130, 246, 0.05);
    }

    .time-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 0.75rem;
        margin-top: 1rem;
    }

    .time-slot {
        padding: 10px 16px;
        border: 2px solid var(--border);
        border-radius: 8px;
        background: white;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        text-align: center;
        transition: all 0.3s ease;
    }

    .time-slot:hover:not(.disabled) {
        border-color: var(--primary);
        background: rgba(59, 130, 246, 0.05);
    }

    .time-slot.selected {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    .time-slot.disabled {
        background: var(--light);
        color: var(--text-muted);
        cursor: not-allowed;
        text-decoration: line-through;
    }

    .alert {
        padding: 1rem 1.5rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        color: var(--secondary);
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .alert-error {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger);
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .hidden {
        display: none !important;
    }

    .no-data {
        text-align: center;
        padding: 3rem;
        color: var(--text-muted);
    }

    .no-data-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto 1rem;
        opacity: 0.5;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .date-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .time-grid {
            grid-template-columns: repeat(3, 1fr);
        }
        
        .modal-content {
            width: 95%;
            margin: 1rem;
        }
        
        .table-modern {
            font-size: 14px;
        }
        
        .table-modern th,
        .table-modern td {
            padding: 0.75rem;
        }
    }

    /* Loading States */
    .loading {
        opacity: 0.6;
        pointer-events: none;
        position: relative;
    }

    .loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 20px;
        height: 20px;
        margin: -10px 0 0 -10px;
        border: 2px solid var(--primary);
        border-top: 2px solid transparent;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>
@endsection

@section('content')
<div class="min-h-screen py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Doctor Profile Sidebar -->
            <div class="lg:col-span-1">
                <div class="sidebar-card">
                    <!-- Profile Header -->
                    <div class="profile-header">
                        <div class="relative inline-block">
                            @isset($doctor->image)
                            <img 
                            src="{{ $doctor->image ? asset('storage/' . $doctor->image) : asset('images/team/default.jpg') }}"
                            alt="{{ $doctor->name }}" 
                            class="doctor-image"
                            onerror="this.onerror=null;this.src='{{ asset('images/team/avatar-doctor.png') }}';"
                        />                                                        @else
                            <div class="avatar-fallback">
                                {{ substr($doctor->name, 0, 1) }}
                            </div>
                            @endisset
                            <span class="status-indicator"></span>
                        </div>
                        <h2 class="text-xl font-bold mt-4 text-white">{{ $doctor->name ?? 'Doctor Name' }}</h2>
                        @isset($doctor->specialization)
                        <p class="text-blue-200 mb-4">{{ $doctor->specialization->name }}</p>
                        @endisset
                        <a href="{{ route('doctors.edit', $doctor->id) }}" class="btn-modern">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Profile
                        </a>
                    </div>

                    <!-- Contact Information -->
                    <div class="info-section">
                        <h3 class="text-lg font-semibold mb-4 text-white">Contact Information</h3>
                        <div class="space-y-2">
                            <div class="info-item">
                                <svg class="info-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span>{{ $doctor->email ?? 'N/A' }}</span>
                            </div>
                            <div class="info-item">
                                <svg class="info-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <span>{{ $doctor->phone ?? 'N/A' }}</span>
                            </div>
                            <div class="info-item">
                                <svg class="info-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>
                                    @isset($doctor->address){{ $doctor->address }}@endisset
                                    @isset($doctor->governorate), {{ $doctor->governorate }}@endisset
                                </span>
                            </div>
                        </div>

                        <!-- Professional Details -->
                        <div class="mt-6">
                            <h4 class="font-semibold text-white mb-3">Professional Details</h4>
                            <div class="space-y-2">
                                <div class="info-item">
                                    <span class="opacity-80">Experience:</span>
                                    <span class="ml-auto font-semibold">{{ $doctor->experience_years ?? '0' }} years</span>
                                </div>
                                <div class="info-item">
                                    <span class="opacity-80">Fee:</span>
                                    <span class="ml-auto font-semibold">{{ $doctor->price_per_appointment ?? '0' }} JOD</span>
                                </div>
                                <div class="info-item">
                                    <span class="opacity-80">Status:</span>
                                    <span class="ml-auto font-semibold capitalize">{{ $doctor->status ?? 'active' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Availability -->
                        <div class="mt-6">
                            <h4 class="font-semibold text-white mb-3">Availability</h4>
                            <div class="mb-3">
                                @php
                                    $days = [
                                        'monday' => 'Mon',
                                        'tuesday' => 'Tue',
                                        'wednesday' => 'Wed',
                                        'thursday' => 'Thu',
                                        'friday' => 'Fri',
                                        'saturday' => 'Sat',
                                        'sunday' => 'Sun'
                                    ];
                                    $hasAvailability = false;
                                @endphp

                                @foreach($days as $key => $day)
                                    @if($doctor->$key)
                                        <span class="day-badge">{{ $day }}</span>
                                        @php $hasAvailability = true; @endphp
                                    @endif
                                @endforeach

                                @if(!$hasAvailability)
                                    <p class="text-sm opacity-80">No availability set</p>
                                @endif
                            </div>
                            
                            @if($doctor->working_hours_start && $doctor->working_hours_end)
                                <div class="info-item">
                                    <svg class="info-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-sm">
                                        {{ \Carbon\Carbon::parse($doctor->working_hours_start)->format('h:i A') }} -
                                        {{ \Carbon\Carbon::parse($doctor->working_hours_end)->format('h:i A') }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="glass-card mt-6 p-6">
                    <h3 class="section-title">Quick Stats</h3>
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-number text-blue-600">{{ $total_appointments ?? 0 }}</div>
                            <div class="stat-label">Total</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number text-green-600">{{ $completed_appointments ?? 0 }}</div>
                            <div class="stat-label">Confirmed</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number text-yellow-600">{{ $pending_appointments ?? 0 }}</div>
                            <div class="stat-label">Pending</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number text-red-600">{{ $canceled_appointments ?? 0 }}</div>
                            <div class="stat-label">Canceled</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content - Appointments -->
            <div class="lg:col-span-3 space-y-8">
                <!-- Appointments Header -->
                <div class="glass-card">
                    <div class="appointments-header">
                        <div class="flex justify-between items-center">
                            <h2 class="section-title mb-0">Appointments</h2>
                            <button id="newAppointmentButton" class="btn-modern">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                New Appointment
                            </button>
                        </div>
                    </div>

                    <div class="appointments-content">
                        <!-- Upcoming Appointments -->
                        <div class="mb-12">
                            <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                                Upcoming Appointments
                            </h3>
                            
                            <div class="overflow-hidden rounded-16">
                                <table class="table-modern">
                                    <thead>
                                        <tr>
                                            <th>Patient</th>
                                            <th>Date & Time</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @isset($upcomingAppointments)
                                            @forelse($upcomingAppointments as $appointment)
                                            <tr>
                                                <td>
                                                    <div class="patient-info">
                                                        @isset($appointment->patient)
                                                        <div class="patient-details">
                                                            <h4>{{ $appointment->patient->name }}</h4>
                                                            <p>{{ $appointment->patient->email }}</p>
                                                        </div>
                                                        @endisset
                                                    </div>
                                                </td>
                                                <td>
                                                    @isset($appointment->appointment_date)
                                                    <div class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</div>
                                                    @endisset
                                                    @isset($appointment->appointment_time)
                                                    <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</div>
                                                    @endisset
                                                </td>

                                                <td>
                                                    @isset($appointment->status)
                                                    <span class="status-badge status-{{ $appointment->status }}">
                                                        {{ ucfirst($appointment->status) }}
                                                    </span>
                                                    @endisset
                                                </td>
                                                <td>
                                                    <div class="actions-group">
                                                        @if($appointment->status == 'pending')
                                                            <form method="POST" action="{{ route('doctor.appointments.update', ['appointmentId' => $appointment->id]) }}" class="inline-form">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="confirmed">
                                                                <button type="submit" class="btn-modern btn-success btn-sm">
                                                                    Confirm
                                                                </button>
                                                            </form>
                                                            <form method="POST" action="{{ route('doctor.appointments.update', ['appointmentId' => $appointment->id]) }}" class="inline-form">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="canceled">
                                                                <button type="submit" class="btn-modern btn-danger btn-sm">
                                                                    Cancel
                                                                </button>
                                                            </form>
                                                        @endif

                                                        @if($appointment->status == 'confirmed')
                                                            <form method="POST" action="{{ route('doctor.appointments.update', ['appointmentId' => $appointment->id]) }}" class="inline-form">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="canceled">
                                                                <button type="submit" class="btn-modern btn-danger btn-sm">
                                                                    Cancel
                                                                </button>
                                                            </form>
                                                        @endif

                                                        @if($appointment->status == 'canceled')
                                                            <form method="POST" action="{{ route('doctor.appointments.update', ['appointmentId' => $appointment->id]) }}" class="inline-form">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="confirmed">
                                                                <button type="submit" class="btn-modern btn-success btn-sm">
                                                                    Re-confirm
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="4">
                                                    <div class="no-data">
                                                        <svg class="no-data-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.405L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                                        </svg>
                                                        No upcoming appointments found.
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforelse
                                        @endisset
                                    </tbody>
                                </table>
                            </div>
                            @isset($upcomingAppointments)
                            <div class="mt-6">
                                {{ $upcomingAppointments->links() }}
                            </div>
                            @endisset
                        </div>

                        <!-- Recent Appointments -->
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                                Recent Appointments
                            </h3>

                            <div class="overflow-hidden rounded-16">
                                <table class="table-modern">
                                    <thead>
                                        <tr>
                                            <th>Patient</th>
                                            <th>Date & Time</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @isset($recentAppointments)
                                            @forelse($recentAppointments as $appointment)
                                            <tr>
                                                <td>
                                                    <div class="patient-info">
                                                        @isset($appointment->patient)
                                                        <div class="patient-details">
                                                            <h4>{{ $appointment->patient->name }}</h4>
                                                            <p>{{ $appointment->patient->email }}</p>
                                                        </div>
                                                        @endisset
                                                    </div>
                                                </td>
                                                <td>
                                                    @isset($appointment->appointment_date)
                                                    <div class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</div>
                                                    @endisset
                                                    @isset($appointment->appointment_time)
                                                    <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</div>
                                                    @endisset
                                                </td>
                                                <td>
                                                    @isset($appointment->status)
                                                    <span class="status-badge status-{{ $appointment->status }}">
                                                        {{ ucfirst($appointment->status) }}
                                                    </span>
                                                    @endisset
                                                </td>
                                                <td>
                                                    <div class="actions-group">
                                                        @if($appointment->status == 'pending')
                                                            <form method="POST" action="{{ route('doctor.appointments.update', ['appointmentId' => $appointment->id]) }}" class="inline-form">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="confirmed">
                                                                <button type="submit" class="btn-modern btn-success btn-sm">
                                                                    Confirm
                                                                </button>
                                                            </form>
                                                            <form method="POST" action="{{ route('doctor.appointments.update', ['appointmentId' => $appointment->id]) }}" class="inline-form">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="canceled">
                                                                <button type="submit" class="btn-modern btn-danger btn-sm">
                                                                    Cancel
                                                                </button>
                                                            </form>
                                                        @endif

                                                        @if($appointment->status == 'confirmed')
                                                            <form method="POST" action="{{ route('doctor.appointments.update', ['appointmentId' => $appointment->id]) }}" class="inline-form">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="canceled">
                                                                <button type="submit" class="btn-modern btn-danger btn-sm">
                                                                    Cancel
                                                                </button>
                                                            </form>
                                                        @endif

                                                        @if($appointment->status == 'canceled')
                                                            <form method="POST" action="{{ route('doctor.appointments.update', ['appointmentId' => $appointment->id]) }}" class="inline-form">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="confirmed">
                                                                <button type="submit" class="btn-modern btn-success btn-sm">
                                                                    Re-confirm
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="4">
                                                    <div class="no-data">
                                                         <svg class="no-data-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.405L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                                        </svg>
                                                        No recent appointments found.
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforelse
                                        @endisset
                                    </tbody>
                                </table>
                            </div>
                            @isset($recentAppointments)
                            <div class="mt-6">
                                {{ $recentAppointments->links() }}
                            </div>
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="newAppointmentModal" class="modal-backdrop hidden">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="text-xl font-bold text-gray-800">New Appointment</h3>
            <button id="closeModal" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="modal-body">
            <!-- Error Message Container -->
            <div id="errorMessage" class="alert alert-error hidden">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                <p id="errorText" class="text-sm"></p>
            </div>

            <!-- Patient Information Step -->
            <div id="patientInfoStep">
                <h4 class="text-lg font-semibold mb-4">Patient Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label for="patientName" class="form-label">Full Name</label>
                        <input type="text" id="patientName" class="form-input" placeholder="Enter patient's full name">
                    </div>
                    <div class="form-group">
                        <label for="patientPhone" class="form-label">Phone Number</label>
                        <input type="tel" id="patientPhone" class="form-input" placeholder="Enter patient's phone number">
                    </div>
                </div>
                <div class="mt-6 flex justify-end">
                    <button id="nextToDate" class="btn-modern">Next: Select Date & Time</button>
                </div>
            </div>

            <!-- Date & Time Selection Step -->
            <div id="dateTimeStep" class="hidden">
                <h4 class="text-lg font-semibold mb-4">Select Date & Time</h4>

                <div class="form-group">
                    <label class="form-label mb-2">Available Dates</label>
                    <div class="date-grid" id="availableDatesContainer">
                        <!-- Dates will be populated by JavaScript -->
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label mb-2">Available Time Slots</label>
                    <div class="time-grid time-slots-container">
                        <!-- Time slots will be populated by JavaScript -->
                    </div>
                </div>

                <div class="mt-6 flex justify-between">
                    <button id="backToPatient" class="btn-modern" style="background: var(--border); color: var(--dark);">Back to Patient Info</button>
                    <button id="confirmAppointment" class="btn-modern">Confirm Appointment</button>
                </div>
            </div>

            <!-- Confirmation Step -->
            <div id="confirmationStep" class="hidden">
                <div class="alert alert-success">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <div>
                        <h3 class="text-sm font-medium">Appointment Scheduled Successfully!</h3>
                        <div class="mt-2 text-sm" id="confirmationDetails"></div>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button id="closeModalAfterConfirm" class="btn-modern">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal elements
    // document.getElementById('newAppointmentModal').classList.add('hidden'); // Changed from hiddenM
    const modal = document.getElementById('newAppointmentModal');
    const closeModalBtn = document.getElementById('closeModal');
    const closeModalAfterConfirmBtn = document.getElementById('closeModalAfterConfirm');
    const newAppointmentBtn = document.getElementById('newAppointmentButton');

    // Error handling elements
    const errorMessage = document.getElementById('errorMessage');
    const errorText = document.getElementById('errorText');

    // Step elements
    const patientInfoStep = document.getElementById('patientInfoStep');
    const dateTimeStep = document.getElementById('dateTimeStep');
    const confirmationStep = document.getElementById('confirmationStep');

    // Navigation buttons
    const nextToDateBtn = document.getElementById('nextToDate');
    const backToPatientBtn = document.getElementById('backToPatient');
    const confirmAppointmentBtn = document.getElementById('confirmAppointment');

    // Form fields
    const patientName = document.getElementById('patientName');
    const patientPhone = document.getElementById('patientPhone');

    // Open modal when clicking the New Appointment button
    if (newAppointmentBtn) {
        newAppointmentBtn.addEventListener('click', function(e) {
            e.preventDefault();
            modal.classList.remove('hidden'); // Changed from hiddenM
            resetModal();
        });
    }

    // Close modal
    closeModalBtn.addEventListener('click', function() {
        modal.classList.add('hidden'); // Changed from hiddenM
    });

    closeModalAfterConfirmBtn.addEventListener('click', function() {
        modal.classList.add('hidden'); // Changed from hiddenM
        window.location.reload();
    });

    // Show error message
    function showError(message) {
        errorText.textContent = message;
        errorMessage.classList.remove('hidden'); // Changed from hiddenM
        setTimeout(() => {
            errorMessage.classList.add('hidden'); // Changed from hiddenM
        }, 5000);
    }

    // Next button - validate patient info and show date/time selection
    nextToDateBtn.addEventListener('click', function() {
        if (!patientName.value.trim()) {
            showError('Please enter patient name');
            patientName.focus();
            return;
        }

        if (!patientPhone.value.trim()) {
            showError('Please enter patient phone number');
            patientPhone.focus();
            return;
        }

        // Simple phone number validation
        if (!/^[0-9+]{8,15}$/.test(patientPhone.value.trim())) {
            showError('Please enter a valid phone number');
            patientPhone.focus();
            return;
        }

        patientInfoStep.classList.add('hidden'); // Changed from hiddenM
        dateTimeStep.classList.remove('hidden'); // Changed from hiddenM
        loadAvailableDates();
    });

    // Back button - return to patient info
    backToPatientBtn.addEventListener('click', function() {
        dateTimeStep.classList.add('hidden'); // Changed from hiddenM
        patientInfoStep.classList.remove('hidden'); // Changed from hiddenM
    });

    // Confirm appointment button
    confirmAppointmentBtn.addEventListener('click', function() {
        const selectedDate = document.querySelector('.date-card.selected');
        const selectedTime = document.querySelector('.time-slot.selected');

        if (!selectedDate || !selectedTime) {
            showError('Please select both date and time');
            return;
        }

        const appointmentData = {
            patient_name: patientName.value.trim(),
            patient_phone: patientPhone.value.trim(),
            appointment_date: selectedDate.dataset.date,
            appointment_time: selectedTime.dataset.time,
            doctor_id: {{ $doctor->id }},
            status: 'confirmed'
        };

        fetch('{{ route("doctor.appointments.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(appointmentData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                dateTimeStep.classList.add('hidden'); // Changed from hiddenM
                confirmationStep.classList.remove('hidden'); // Changed from hiddenM
                document.getElementById('confirmationDetails').innerHTML = `
                    <p><strong>Patient:</strong> ${appointmentData.patient_name}</p>
                    <p><strong>Date:</strong> ${formatDateForDisplay(appointmentData.appointment_date)}</p>
                    <p><strong>Time:</strong> ${formatTimeForDisplay(appointmentData.appointment_time)}</p>
                `;
            } else {
                showError(data.message || 'Failed to create appointment');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showError('An error occurred while creating the appointment');
        });
    });

    // Reset modal to initial state
    function resetModal() {
        patientInfoStep.classList.remove('hidden'); // Changed from hiddenM
        dateTimeStep.classList.add('hidden'); // Changed from hiddenM
        confirmationStep.classList.add('hidden'); // Changed from hiddenM
        errorMessage.classList.add('hidden'); // Changed from hiddenM
        patientName.value = '';
        patientPhone.value = '';
    }

    // Load available dates for the next 14 days
    function loadAvailableDates() {
        const datesContainer = document.getElementById('availableDatesContainer');
        datesContainer.innerHTML = '';

        const workingDays = [
            @if($doctor->monday) 'Monday', @endif
            @if($doctor->tuesday) 'Tuesday', @endif
            @if($doctor->wednesday) 'Wednesday', @endif
            @if($doctor->thursday) 'Thursday', @endif
            @if($doctor->friday) 'Friday', @endif
            @if($doctor->saturday) 'Saturday', @endif
            @if($doctor->sunday) 'Sunday', @endif
        ];

        const unavailableDates = {!! json_encode($doctor->unavailable->pluck('date')->map(function($date) {
            return \Carbon\Carbon::parse($date)->format('Y-m-d');
        })) !!};

        const unavailableTimes = {!! json_encode($doctor->unavailable->groupBy(function($item) {
            return \Carbon\Carbon::parse($item->date)->format('Y-m-d');
        })->map(function($group) {
            return $group->map(function($item) {
                return \Carbon\Carbon::parse($item->start_time)->format('H:i');
            });
        })) !!};

        const today = new Date();
        let hasAvailableDates = false;

        for (let i = 0; i < 14; i++) {
            const date = new Date(today);
            date.setDate(today.getDate() + i);

            const dayName = date.toLocaleDateString('en-US', { weekday: 'long' });
            if (!workingDays.includes(dayName)) continue;

            const dateKey = formatDate(date);
            const isDateUnavailable = unavailableDates.includes(dateKey) &&
                                     unavailableTimes[dateKey] &&
                                     unavailableTimes[dateKey].includes('00:00');

            const dateCard = document.createElement('div');
            dateCard.className = `date-card ${
                isDateUnavailable ? 'disabled' : 'cursor-pointer'
            }`;
            dateCard.dataset.date = dateKey;

            if (isDateUnavailable) {
                dateCard.innerHTML = `
                    <h4 class="font-medium text-gray-900 mb-2 text-center text-sm bg-gray-100 py-1 rounded">
                        ${i === 0 ? 'Today' : i === 1 ? 'Tomorrow' : dayName.substring(0, 3)}, ${formatDateForDisplay(dateKey)}
                    </h4>
                    <div class="text-center py-4 text-gray-500">
                        Unavailable all day
                    </div>
                `;
            } else {
                hasAvailableDates = true;
                dateCard.innerHTML = `
                    <h4 class="font-medium text-gray-900 mb-2 text-center text-sm bg-gray-50 py-1 rounded ${
                        i === 0 ? 'text-blue-600 font-bold' : i === 1 ? 'text-blue-600 font-bold' : '' // Updated color
                    }">
                        ${i === 0 ? 'Today' : i === 1 ? 'Tomorrow' : dayName.substring(0, 3)}, ${formatDateForDisplay(dateKey)}
                    </h4>
                    <div class="text-center py-2 text-sm text-gray-600">
                        Available
                    </div>
                `;

                dateCard.addEventListener('click', function() {
                    document.querySelectorAll('.date-card').forEach(card => {
                        card.classList.remove('selected', 'border-[#e12454]', 'bg-[#fef1f4]'); // Removed old styles
                        card.classList.remove('selected', 'border-primary', 'bg-blue-50'); // Removed old styles
                    });
                    this.classList.add('selected'); // Added selected class
                    loadAvailableTimes(dateKey, unavailableTimes[dateKey] || []);
                });
            }

            datesContainer.appendChild(dateCard);
        }

        if (!hasAvailableDates) {
            datesContainer.innerHTML = `
                <div class="col-span-full text-center py-6 text-gray-500 no-data">
                    <svg class="no-data-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    No available days in the next 14 days
                </div>
            `;
        }
    }

    // Load available time slots for a specific date
    function loadAvailableTimes(date, unavailableTimes) {
        const timeSlotsContainer = document.querySelector('.time-slots-container');
        timeSlotsContainer.innerHTML = '';

        const workingHoursStart = '{{ $doctor->working_hours_start }}';
        const workingHoursEnd = '{{ $doctor->working_hours_end }}';

        // Get already booked appointments for this date
        const bookedAppointments = {!! json_encode($doctor->appointments()
            ->where('status', 'confirmed')
            ->get()
            ->groupBy(function($item) {
                return \Carbon\Carbon::parse($item->appointment_date)->format('Y-m-d');
            })
            ->map(function($group) {
                return $group->map(function($item) {
                    return \Carbon\Carbon::parse($item->appointment_time)->format('H:i');
                });
            })) !!};

        const startTime = new Date(`2000-01-01T${workingHoursStart}`);
        const endTime = new Date(`2000-01-01T${workingHoursEnd}`);

        let currentTime = new Date(startTime);
        let hasAvailableTimes = false;

        while (currentTime < endTime) {
            const timeKey = formatTime(currentTime);
            const displayTime = formatTimeForDisplay(timeKey);
            const isUnavailable = unavailableTimes.includes(timeKey);
            const isBooked = bookedAppointments[date] && bookedAppointments[date].includes(timeKey);

            const timeSlot = document.createElement('button');
            timeSlot.className = `time-slot ${isUnavailable || isBooked ? 'disabled' : ''}`;
            timeSlot.dataset.time = timeKey;
            timeSlot.textContent = displayTime;

            if (!isUnavailable && !isBooked) {
                hasAvailableTimes = true;
                timeSlot.addEventListener('click', function() {
                    document.querySelectorAll('.time-slot').forEach(slot => {
                        slot.classList.remove('selected');
                    });
                    this.classList.add('selected');
                });
            } else if (isBooked) {
                timeSlot.title = 'This time slot is already booked';
            }

            timeSlotsContainer.appendChild(timeSlot);
            currentTime.setMinutes(currentTime.getMinutes() + 30);
        }

        if (!hasAvailableTimes) {
            timeSlotsContainer.innerHTML = `
                <div class="col-span-full text-center py-6 text-gray-500 no-data">
                    <svg class="no-data-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    No available time slots for this date.
                </div>
            `;
        }
    }

    // Helper functions
    function formatDate(date) {
        const d = new Date(date);
        let month = '' + (d.getMonth() + 1);
        let day = '' + d.getDate();
        const year = d.getFullYear();
        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;
        return [year, month, day].join('-');
    }

    function formatDateForDisplay(dateStr) {
        const options = { month: 'short', day: 'numeric' };
        return new Date(dateStr).toLocaleDateString('en-US', options);
    }

    function formatTime(date) {
        const d = new Date(date);
        let hours = '' + d.getHours();
        let minutes = '' + d.getMinutes();
        if (hours.length < 2) hours = '0' + hours;
        if (minutes.length < 2) minutes = '0' + minutes;
        return [hours, minutes].join(':');
    }

    function formatTimeForDisplay(timeStr) {
        const [hours, minutes] = timeStr.split(':');
        const hour = parseInt(hours, 10);
        const ampm = hour >= 12 ? 'PM' : 'AM';
        const hour12 = hour % 12 || 12;
        return `${hour12}:${minutes} ${ampm}`;
    }
});
</script>
@endsection
