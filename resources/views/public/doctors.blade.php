<x-app-layout>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/all-css/doctors.css') }}">

    <!-- Doctors Listing Section -->
    <section class="pt-4 pb-5 doctors-section">
        <div class="container">
            <!-- Search Section -->
            <div class="search-section mb-4">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-10">
                        <div class="search-card p-3 p-md-4 shadow-sm rounded-3">
                            <h3 class="text-center mb-3">Find the Right Specialist</h3>
                            <form class="appointment-form" action="{{ route('doctors') }}" method="GET">
                                <div class="row g-2 g-md-3 align-items-center">
                                    <div class="col-12 col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-search text-muted"></i>
                                            </span>
                                            <input type="text" name="search" class="form-control py-2" placeholder="Doctor name or specialty" value="{{ request('search') }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-map-marker-alt text-muted"></i>
                                            </span>
                                            <select name="governorate" class="form-select py-2">
                                                <option value="">All Locations</option>
                                                @foreach(['Ajloun', 'Amman', 'Aqaba', 'Balqa', 'Irbid', 'Jerash', 'Karak', 'Maan', 'Madaba', 'Mafraq', 'Tafilah', 'Zarqa'] as $gov)
                                                    <option value="{{ $gov }}" {{ request('governorate') == $gov ? 'selected' : '' }}>{{ $gov }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <button type="submit" class="btn btn-main w-100 py-2">
                                            <i class="fas fa-search me-1"></i> Search
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Filters Column -->
                <div class="col-lg-3 d-none d-lg-block">
                    <div class="sticky-container">
                        <div class="filter-section mb-4 p-3 bg-white rounded-3 shadow-sm">
                            <h4 class="mb-3 fw-bold">Filters</h4>
                            <div class="divider mb-3"></div>

                            <!-- Specialty Filter -->
                            <form action="{{ route('doctors') }}" method="GET" id="filter-form">
                                <input type="hidden" name="search" value="{{ request('search') }}">
                                <input type="hidden" name="governorate" value="{{ request('governorate') }}">

                                <div class="filter-group mb-3">
                                    <h5 class="mb-2 fw-semibold">
                                        <i class="fas fa-stethoscope me-1"></i> Specialty
                                    </h5>
                                    <div class="filter-options">
                                        @foreach($specializations as $specialization)
                                        <div class="form-check mb-1">
                                            <input class="form-check-input filter-checkbox" type="checkbox"
                                                name="specializations[]"
                                                value="{{ $specialization->id }}"
                                                id="spec-{{ $specialization->id }}"
                                                @if(request()->has('specializations') && in_array($specialization->id, request('specializations'))) checked @endif>
                                            <label class="form-check-label" for="spec-{{ $specialization->id }}">
                                                {{ $specialization->name }}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-main w-100 py-2">
                                    <i class="fas fa-filter me-1"></i> Apply Filters
                                </button>
                            </form>
                        </div>

                        <!-- Quick Stats -->
                        <div class="quick-stats p-3 bg-white rounded-3 shadow-sm mb-4">
                            <h5 class="mb-2 fw-semibold">
                                <i class="fas fa-chart-pie me-1"></i> Quick Stats
                            </h5>
                            <div class="stats-item d-flex justify-content-between mb-1">
                                <span class="text-muted">Total Doctors</span>
                                <span class="fw-bold">{{ $totalDoctors }}</span>
                            </div>
                            <div class="stats-item d-flex justify-content-between mb-1">
                                <span class="text-muted">Specialties</span>
                                <span class="fw-bold">{{ $specializations->count() }}</span>
                            </div>
                            <div class="stats-item d-flex justify-content-between">
                                <span class="text-muted">Locations</span>
                                <span class="fw-bold">11</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Doctors List -->
                <div class="col-12 col-lg-9">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3 p-3 bg-white rounded-3 shadow-sm">
                        <h4 class="mb-2 mb-md-0 fw-bold">
                            <i class="fas fa-user-md me-1"></i> Available Doctors
                            <span class="badge bg-main ms-2">{{ $doctors->total() }}</span>
                        </h4>
                        <div class="d-flex align-items-center mt-2 mt-md-0">
                            <span class="me-2 text-muted">Sort:</span>
                            <select class="form-select shadow-sm border-0 py-1" id="sort-select" name="sort">
                                <option value="recommended" {{ request('sort') == 'recommended' ? 'selected' : '' }}>Recommended</option>
                                <option value="experience" {{ request('sort') == 'experience' ? 'selected' : '' }}>Most Experienced</option>
                            </select>
                        </div>
                    </div>

                    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-3 justify-content-center">
                        @forelse($doctors as $doctor)
                        <!-- Doctor Card -->
                        <div class="col mb-3 fade-up">
                            <div class="doctor-card h-100 bg-white rounded-3 overflow-hidden shadow-sm border-0 mx-auto">
                                <div class="position-relative">
                                    <img src="{{ $doctor->image ? asset('storage/' . $doctor->image) : asset('images/team/default.jpg') }}"
                                         class="w-100 h-100"
                                         alt="{{ $doctor->name }}"
                                         onerror="this.onerror=null;this.src='{{ asset('images/team/avatar-doctor.png') }}';">
                                    <div class="position-absolute top-0 end-0 p-1">
                                        <span class="badge bg-main">
                                            <i class="fas fa-star me-1"></i> {{ $doctor->rating ?? '4.8' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="p-3">
                                    <h5 class="mb-1 fw-bold">Dr. {{ $doctor->name }}</h5>
                                    <p class="mb-2">
                                        {{ $doctor->specialization ? $doctor->specialization->name : 'General' }}
                                    </p>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        <small class="text-muted">{{ $doctor->governorate }}</small>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <i class="fas fa-briefcase me-1"></i>
                                            <small class="text-muted">{{ $doctor->experience_years ?? '5' }}y</small>
                                        </div>
                                        <div>
                                            <i class="fas fa-comments me-1"></i>
                                            <small class="text-muted">EN/AR</small>
                                        </div>
                                    </div>
                                    <a href="{{ route('doctor', $doctor->id) }}" class="btn btn-main-2 btn-sm w-100 py-1">
                                        <i class="fas fa-calendar-alt me-1"></i> Book
                                    </a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="alert alert-info d-flex align-items-center py-2" role="alert">
                                <i class="fas fa-info-circle me-2"></i>
                                <div>
                                    <h5 class="alert-heading mb-1">No doctors found</h5>
                                    <p class="mb-0">Try different search parameters</p>
                                </div>
                            </div>
                        </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4 d-flex justify-content-center">
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-sm">
                                {{ $doctors->withQueryString()->onEachSide(1)->links('pagination::bootstrap-5') }}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sortSelect = document.getElementById('sort-select');
            if(sortSelect) {
                sortSelect.addEventListener('change', function() {
                    const currentUrl = new URL(window.location);
                    currentUrl.searchParams.set('sort', this.value);
                    window.location.href = currentUrl.toString();
                });
            }
        });
    </script>
</x-app-layout>
