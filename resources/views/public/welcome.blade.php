<x-app-layout>
    <!-- Slider Start -->
    <section class="banner position-relative">
        <!-- Image Slider -->
        <div class="banner-slider">
            <div id="bannerCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                <!-- Indicators -->
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
                    <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="4" aria-label="Slide 5"></button>
                </div>
                
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="/images/bg/slider-bg-3.jpg" class="d-block w-100" alt="Healthcare Slider">
                        <div class="carousel-caption">
                            <h2 class="animate__animated animate__fadeInDown">Modern Healthcare</h2>
                            <p class="animate__animated animate__fadeInUp animate__delay-1s">Advanced medical services at your fingertips</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="/images/bg/22.jpg" class="d-block w-100" alt="Healthcare Slider">
                        <div class="carousel-caption">
                            <h2 class="animate__animated animate__fadeInDown">Expert Physicians</h2>
                            <p class="animate__animated animate__fadeInUp animate__delay-1s">Connect with top specialists in Jordan</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="/images/bg/blog-2.jpg" class="d-block w-100" alt="Healthcare Slider">
                        <div class="carousel-caption">
                            <h2 class="animate__animated animate__fadeInDown">Easy Appointment Booking</h2>
                            <p class="animate__animated animate__fadeInUp animate__delay-1s">Schedule your visit in minutes</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="/images/bg/111.jpg" class="d-block w-100" alt="Healthcare Slider">
                        <div class="carousel-caption">
                            <h2 class="animate__animated animate__fadeInDown">Family Care</h2>
                            <p class="animate__animated animate__fadeInUp animate__delay-1s">Comprehensive healthcare for all ages</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="/images/bg/bg-2.jpg" class="d-block w-100" alt="Healthcare Slider">
                        <div class="carousel-caption">
                            <h2 class="animate__animated animate__fadeInDown">Pharmacy Services</h2>
                            <p class="animate__animated animate__fadeInUp animate__delay-1s">Medications delivered to your doorstep</p>
                        </div>
                    </div>
                </div>
                
                <!-- Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>
    
    <style>
        .banner {
            height: 480px;
            position: relative;
            overflow: hidden;
            background-color: rgba(0, 0, 0, 0.5);
            margin-bottom: 30px;
        }
        
        .banner-slider {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        
        .banner-slider .carousel,
        .banner-slider .carousel-inner,
        .banner-slider .carousel-item {
            height: 100%;
        }
        
        .banner-slider img {
            object-fit: cover;
            height: 100%;
            filter: brightness(0.6);
        }
        
        .carousel-caption {
            bottom: 25%;
            text-align: center;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .carousel-caption h2 {
            font-size: 2.8rem;
            font-weight: 700;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.6);
            margin-bottom: 1rem;
        }
        
        .carousel-caption p {
            font-size: 1.2rem;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.8);
            margin-bottom: 2rem;
        }
        
        .carousel-indicators {
            margin-bottom: 2rem;
        }
        
        .carousel-indicators button {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.5);
            margin: 0 5px;
        }
        
        .carousel-indicators button.active {
            background-color: #fff;
        }
        
        .carousel-control-prev,
        .carousel-control-next {
            width: 10%;
            opacity: 0.7;
            transition: all 0.3s ease;
        }
        
        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            opacity: 1;
            background: rgba(0, 0, 0, 0.2);
        }
        
        /* Add animate.css classes */
        .animate__animated {
            animation-duration: 1s;
        }
        
        .animate__delay-1s {
            animation-delay: 0.5s;
        }
        
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translate3d(0, -50px, 0);
            }
            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translate3d(0, 50px, 0);
            }
            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }
        
        .animate__fadeInDown {
            animation-name: fadeInDown;
        }
        
        .animate__fadeInUp {
            animation-name: fadeInUp;
        }
        
        @media (max-width: 992px) {
            .banner {
                height: 400px;
            }
            
            .carousel-caption h2 {
                font-size: 2.2rem;
            }
            
            .carousel-caption p {
                font-size: 1rem;
            }
        }
        
        @media (max-width: 768px) {
            .banner {
                height: 350px;
            }
            
            .carousel-caption {
                bottom: 20%;
            }
            
            .carousel-caption h2 {
                font-size: 1.8rem;
            }
            
            .carousel-caption p {
                font-size: 0.9rem;
                margin-bottom: 1rem;
            }
        }
        
        @media (max-width: 576px) {
            .banner {
                height: 300px;
            }
            
            .carousel-caption h2 {
                font-size: 1.5rem;
                margin-bottom: 0.5rem;
            }
            
            .carousel-caption p {
                font-size: 0.8rem;
                margin-bottom: 0.5rem;
            }
            
            .carousel-indicators {
                margin-bottom: 1rem;
            }
            
            .carousel-indicators button {
                width: 8px;
                height: 8px;
            }
        }
        
        .search-section {
            background-color: #f8f9fa;
            padding: 50px 0;
            box-shadow: 0 -5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 60px;
        }
        
        .search-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            max-width: 800px;
            margin: 0 auto;
        }
        
        .search-header {
            text-align: center;
            margin-bottom: 25px;
        }
        
        .appointment-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
        }
        
        .select-group {
            flex: 1;
            min-width: 200px;
        }
        
        .appointment-select {
            width: 100%;
            padding: 10px 15px;
            border-radius: 5px;
            border: 1px solid #e0e0e0;
            font-size: 0.9rem;
        }
        
        .btn-container {
            flex: 1;
            min-width: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        @media (max-width: 768px) {
            .appointment-container {
                flex-direction: column;
            }
            
            .select-group, .btn-container {
                width: 100%;
            }
        }
    </style>

    <!-- Featured Doctors Section -->
    <section class="recommended-doctors">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row justify-center">
                        <div class="col-lg-7 text-center">
                            <h2 class="section-title">Featured Doctors</h2>
                            <div class="divider mx-auto my-4"></div>
                        </div>
                    </div>

                    <div class="splide" id="doctors-slider">
                        <div class="splide__track">
                            <ul class="splide__list">
                               @foreach($featuredDoctors as $doctor)
    <li class="splide__slide">
        <div class="doctor-card">
            <img 
                src="{{ $doctor->image ? asset('storage/' . $doctor->image) : asset('images/team/default.jpg') }}"
                alt="{{ $doctor->name }}" 
                class="doctor-image"
                onerror="this.onerror=null;this.src='{{ asset('images/team/avatar-doctor.png') }}';"
            />
            <div class="doctor-info">
                <h3 class="doctor-name">Dr. {{ $doctor->name }}</h3>
                <span class="doctor-specialty">{{ $doctor->specialization->name ?? 'General' }}</span>
                <div class="btn-container">
                    <a href="{{ route('doctor', $doctor->id) }}" class="btn btn-main">
                        Book <i class="icofont-simple-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </li>
@endforeach

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Search Doctor Section -->
    <section class="search-section">
        <div class="container">
            <div class="search-container">
                <div class="search-header">
                    <h3>Find Your Doctor</h3>
                    <div class="divider mx-auto my-3" style="width: 60px; height: 3px; background-color: #0d6efd;"></div>
                    <p class="text-muted mb-4">Search for specialists by location or specialty</p>
                </div>
                <form class="appointment-form" action="{{ route('doctors') }}" method="GET">
                    <div class="appointment-container">
                        <div class="select-group">
                            <select name="governorate" class="appointment-select" id="governorate">
                                <option value="" disabled selected>Select Governorate</option>
                                @foreach(['Ajloun', 'Amman', 'Aqaba', 'Balqa', 'Irbid', 'Jerash', 'Karak', 'Maan', 'Madaba', 'Mafraq', 'Tafilah', 'Zarqa'] as $gov)
                                    <option value="{{ strtolower($gov) }}">{{ $gov }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="select-group">
                            <select name="specializations[]" class="appointment-select" id="specialty">
                                <option value="" disabled selected>Select Specialty</option>
                                @foreach($specializations as $specialty)
                                    <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="btn-container">
                            <button type="submit" class="btn btn-primary btn-icon btn-round-full">
                                Search <i class="icofont-simple-right ml-2"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="steps-section pt-5 pb-5">
        <div class="container">
            <div class="row justify-center">
                <div class="col-lg-7 text-center">
                    <h2 class="section-title">How To Book An Appointment</h2>
                    <div class="divider mx-auto my-4"></div>
                    <p class="text-muted">Simple steps to get the care you need</p>
                </div>
            </div>
            <div class="row justify-center gap-5">
                <div class="col-lg-3 col-md-6">
                    <div class="step-card text-center p-4 bg-white rounded shadow-sm">
                        <div class="step-icon mb-4 bg-soft-primary rounded-circle d-inline-flex align-items-center justify-content-center">
                            <i class="icofont-doctor-alt text-primary" style="font-size: 2rem;"></i>
                            <span class="step-number bg-primary text-white rounded-circle">1</span>
                        </div>
                        <h4 class="text-dark">Find Your Doctor</h4>
                        <p class="text-muted">Search by specialty, location, or doctor name</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="step-card text-center p-4 bg-white rounded shadow-sm">
                        <div class="step-icon mb-4 bg-soft-primary rounded-circle d-inline-flex align-items-center justify-content-center">
                            <i class="icofont-ui-calendar text-primary" style="font-size: 2rem;"></i>
                            <span class="step-number bg-primary text-white rounded-circle">2</span>
                        </div>
                        <h4 class="text-dark">Select Time Slot</h4>
                        <p class="text-muted">Choose from available dates and times</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="step-card text-center p-4 bg-white rounded shadow-sm">
                        <div class="step-icon mb-4 bg-soft-primary rounded-circle d-inline-flex align-items-center justify-content-center">
                            <i class="icofont-check-alt text-primary" style="font-size: 2rem;"></i>
                            <span class="step-number bg-primary text-white rounded-circle">3</span>
                        </div>
                        <h4 class="text-dark">Confirm Booking</h4>
                        <p class="text-muted">Receive instant confirmation via SMS/Email</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Specialties Grid Section -->
    <section class="specialties-section pt-5 pb-5 bg-gray">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 text-center">
                    <h2 class="section-title">Our Medical Specialties</h2>
                    <div class="divider mx-auto my-4"></div>
                    <p class="text-muted">Book appointments across 10+ medical specialties</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <a href="#" class="specialty-card d-block p-4 bg-white rounded text-center h-100">
                        <i class="icofont-heart-beat-alt text-primary mb-3" style="font-size: 2.5rem;"></i>
                        <h5 class="text-dark">Cardiology</h5>
                        <p class="text-muted mb-0">Heart health specialists</p>
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <a href="#" class="specialty-card d-block p-4 bg-white rounded text-center h-100">
                        <i class="icofont-brain-alt text-primary mb-3" style="font-size: 2.5rem;"></i>
                        <h5 class="text-dark">Neurology</h5>
                        <p class="text-muted mb-0">Brain & nervous system</p>
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <a href="#" class="specialty-card d-block p-4 bg-white rounded text-center h-100">
                        <i class="icofont-baby text-primary mb-3" style="font-size: 2.5rem;"></i>
                        <h5 class="text-dark">Pediatrics</h5>
                        <p class="text-muted mb-0">Child healthcare</p>
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <a href="#" class="specialty-card d-block p-4 bg-white rounded text-center h-100">
                        <i class="icofont-tooth text-primary mb-3" style="font-size: 2.5rem;"></i>
                        <h5 class="text-dark">Dentistry</h5>
                        <p class="text-muted mb-0">Oral health care</p>
                    </a>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="#" class="btn btn-main">View All Specialties</a>
            </div>
        </div>
    </section>

    <!-- Stats Counter Section -->
    <section class="stats-section pt-5 pb-5 bg-primary-darker text-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <div class="stat-card text-center">
                        <i class="icofont-doctor mb-3" style="font-size: 3rem;"></i>
                        <h3 class="mt-2"><span class="counter">{{ $stats['doctors_count'] }}</span>+</h3>
                        <p class="mb-0">Qualified Doctors</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <div class="stat-card text-center">
                        <i class="icofont-google-map mb-3" style="font-size: 3rem;"></i>
                        <h3 class="mt-2"><span class="counter">{{ $stats['governorates'] }}</span></h3>
                        <p class="mb-0">Governorates Covered</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4 mb-sm-0">
                    <div class="stat-card text-center">
                        <i class="icofont-laughing mb-3" style="font-size: 3rem;"></i>
                        <h3 class="mt-2"><span class="counter">{{ $stats['happy_patients'] }}</span>+</h3>
                        <p class="mb-0">Happy Patients</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="stat-card text-center">
                        <i class="icofont-clock-time mb-3" style="font-size: 3rem;"></i>
                        <h3 class="mt-2" style="color: #e12454;">{{ $stats['support_available'] }}</h3>
                        <p class="mb-0">Support Available</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials-section pt-5 pb-5 bg-gray">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 text-center">
                    <h2 class="section-title">What Patients Say</h2>
                    <div class="divider mx-auto my-4"></div>
                    <p class="text-muted">Hear from our satisfied patients</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="splide" id="testimonials-slider">
                        <div class="splide__track p-1">
                            <ul class="splide__list">
                                <!-- Testimonial 1 -->
                                <li class="splide__slide">
                                    <div class="testimonial-item bg-white p-4 rounded shadow-sm h-100">
                                        <div class="testimonial-content mb-4">
                                            <i class="icofont-quote-left text-primary mb-3" style="font-size: 1.5rem;"></i>
                                            <p class="font-italic">"Found the perfect cardiologist through this platform. The booking process was seamless and the doctor was excellent."</p>
                                        </div>
                                        <div class="patient-info d-flex align-items-center">
                                            <img src="/images/bg-2.jpg" alt="Patient" class="rounded-circle me-3" width="50">
                                            <div>
                                                <h5 class="mb-1">Mohammad Ali</h5>
                                                <span class="text-muted small">Amman</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <!-- Additional testimonials (omitted for brevity)... -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section pt-5 pb-5 bg-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 text-center">
                    <h2 class="section-title">Frequently Asked Questions</h2>
                    <div class="divider mx-auto my-4"></div>
                    <p class="text-muted">Find answers to common questions about our services</p>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-lg-6 mb-4">
                    <div class="faq-item bg-gray p-4 rounded">
                        <h5 class="text-dark mb-3">How do I book an appointment?</h5>
                        <p class="text-muted">Use our search tool to find doctors by specialty or location, select your preferred time slot, and complete the booking form.</p>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="faq-item bg-gray p-4 rounded">
                        <h5 class="text-dark mb-3">Can I reschedule my appointment?</h5>
                        <p class="text-muted">Yes, you can reschedule up to 24 hours before your appointment time through the link in your confirmation email.</p>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="faq-item bg-gray p-4 rounded">
                        <h5 class="text-dark mb-3">What payment methods do you accept?</h5>
                        <p class="text-muted">We accept cash payments at the clinic. Some clinics may accept credit cards - this will be specified during booking.</p>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="faq-item bg-gray p-4 rounded">
                        <h5 class="text-dark mb-3">Is my personal information secure?</h5>
                        <p class="text-muted">Yes, we use industry-standard encryption to protect all patient data and comply with medical privacy regulations.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Space between content and footer -->
    <div class="content-footer-spacer" style="padding: 1rem 0; background-color: white;"></div>
    
    <!-- Footer -->
 

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Banner carousel auto-slide
            new bootstrap.Carousel(document.getElementById('bannerCarousel'), {
                interval: 5000,
                ride: 'carousel',
                touch: true
            });
            
            // Doctors slider
            new Splide('#doctors-slider', {
                type: 'loop',
                perPage: 4,
                perMove: 2,
                autoplay: true,
                interval: 3000,
                gap: '20px',
                padding: '50px',
                pagination: false,
                breakpoints: {
                    1200: { perPage: 3, gap: '50px', padding: '40px' },
                    1024: { perPage: 2, gap: '40px', padding: '30px' },
                    768: { perPage: 2, perMove: 1, gap: '30px', padding: '20px' },
                    568: { perPage: 1, perMove: 1, gap: '40px', padding: '80px' },
                    400: { perPage: 1, perMove: 1, gap: '40px', padding: '60px' }
                }
            }).mount();

            // Testimonials slider
            new Splide('#testimonials-slider', {
                type: 'loop',
                perPage: 3,
                perMove: 1,
                autoplay: true,
                interval: 3000,
                gap: '20px',
                padding: '50px',
                pagination: false,
                breakpoints: {
                    1200: { perPage: 3, gap: '20px', padding: '40px' },
                    1024: { perPage: 2, gap: '20px', padding: '30px' },
                    768: { perPage: 1, gap: '20px', padding: '20px' },
                    568: { perPage: 1, gap: '20px', padding: '10px' },
                    400: { perPage: 1, gap: '20px', padding: '10px' }
                }
            }).mount();

            // Counter animation with improved settings
            $('.counter').each(function() {
                var $this = $(this);
                var countTo = $this.text();
                
                $({ countNum: 0 }).animate({
                    countNum: countTo
                }, {
                    duration: 2000,
                    easing: 'swing',
                    step: function() {
                        $this.text(Math.floor(this.countNum));
                    },
                    complete: function() {
                        $this.text(this.countNum);
                    }
                });
            });
        });
    </script>
</x-app-layout>
