<x-app-layout>


    <style>
        :root {
            --primary: #0d6efd;
            --primary-dark: #0b5ed7;
            --secondary: #6c757d;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #198754;
            --danger: #dc3545;
            --body-bg: #f5f8fb;
        }
       


        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--body-bg);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            padding: 2rem 0;
        }
        
        .auth-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 450px;
            margin: 0 auto;
            border: none;
        }
        
        .auth-header {
            background: var(--primary);
            color: white;
            padding: 1rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .auth-header h3 {
            font-weight: 600;
            position: relative;
            z-index: 1;
            margin-bottom: 0;
            font-size: 1.3rem;
        }
        
        .auth-header::before {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -100px;
            right: -100px;
        }
        
        .auth-header::after {
            content: '';
            position: absolute;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            bottom: -30px;
            left: -30px;
        }
        
        .auth-body {
            padding: 2rem;
        }
        
        .input-group {
            margin-bottom: 1.25rem;
            position: relative;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.04);
        }
        
        .input-group-text {
            background-color: white;
            border: none;
            border-right: 1px solid #eee;
            color: var(--primary);
            padding: 0.6rem 0.8rem;
            font-size: 0.9rem;
        }
        
        .form-control {
            border: none;
            padding: 0.6rem 0.8rem;
            font-size: 0.9rem;
            height: auto;
        }
        
        .form-control:focus {
            box-shadow: none;
        }
        
        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            background: none;
            border: none;
            color: var(--secondary);
            cursor: pointer;
            font-size: 0.9rem;
        }
        
        .btn-auth {
            background: var(--primary);
            border: none;
            color: white;
            padding: 0.7rem 1rem;
            font-weight: 500;
            border-radius: 6px;
            transition: all 0.3s ease;
            display: block;
            width: 100%;
            font-size: 0.95rem;
        }
        
        .btn-auth:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(13, 110, 253, 0.25);
        }
        
        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        .flag-wrapper {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.85rem;
        }
        
        .flag-img {
            width: 20px;
            height: 14px;
            object-fit: cover;
        }
        
        /* Space between content and footer */
        .content-footer-spacer {
            padding: 1rem 0;
            background-color: white;
        }
        
        footer {
            background-color: var(--dark);
            color: rgba(255, 255, 255, 0.7);
            padding: 1.5rem 0;
            font-size: 0.85rem;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 2fr;
            gap: 1.5rem;
        }
        
        footer h5 {
            color: white;
            font-weight: 600;
            margin-bottom: 0.75rem;
            position: relative;
            font-size: 0.95rem;
        }
        
        footer h5::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 30px;
            height: 2px;
            background-color: var(--primary);
        }
        
        .footer-links {
            list-style: none;
            padding-left: 0;
            margin-bottom: 0;
        }
        
        .footer-links li {
            margin-bottom: 5px;
        }
        
        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .footer-links a:hover {
            color: white;
        }
        
        .social-links {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }
        
        .social-links a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            transition: all 0.3s ease;
            font-size: 0.8rem;
        }
        
        .social-links a:hover {
            background-color: var(--primary);
        }
        
        .contact-items {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
        }
        
        .contact-icon {
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            margin-right: 8px;
            font-size: 0.7rem;
        }
        
        .contact-text {
            font-size: 0.8rem;
        }
        
        .copyright {
            text-align: center;
            padding-top: 0.75rem;
            margin-top: 0.75rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.75rem;
        }
        
        .text-danger {
            margin-top: -0.5rem;
            margin-bottom: 0.5rem;
            font-size: 0.75rem;
        }
        
        .form-check {
            margin-bottom: 0.75rem;
            margin-top: 0.25rem;
        }
        
        .form-check-label {
            font-size: 0.8rem;
        }
        
        @media (max-width: 991.98px) {
            .footer-content {
                grid-template-columns: 1fr 1fr;
                gap: 1rem;
            }
        }
        
        @media (max-width: 767.98px) {
            .auth-body {
                padding: 1.25rem;
            }
            
            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
            }
            
            footer h5::after {
                left: 50%;
                transform: translateX(-50%);
            }
            
            .contact-items {
                grid-template-columns: 1fr;
            }
            
            .contact-item {
                justify-content: center;
            }
            
            .social-links {
                justify-content: center;
            }
        }
        .navbar {
    transition: all 0.3s ease;
}

.navbar-nav .nav-link {
    position: relative;
    padding: 0.5rem 1rem;
    transition: color 0.3s ease;
}

.navbar-nav .nav-link.active, 
.navbar-nav .nav-link:hover {
    color: var(--bs-primary);
}

.navbar-nav .nav-link.active::after,
.navbar-nav .nav-link:hover::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0.75rem;
    right: 0.75rem;
    height: 2px;
    background-color: var(--bs-primary);
    transition: all 0.3s ease;
}

/* Make dropdown menus look nicer */
.dropdown-item {
    padding: 0.5rem 1rem;
    transition: all 0.2s ease;
}

.dropdown-item:hover {
    background-color: rgba(var(--bs-primary-rgb), 0.1);
}
    </style>
</head>
<body>
    <!-- Main Navigation -->



    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <!-- Alert Messages -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <!-- Registration Card -->
                    <div class="auth-card">
                        <div class="auth-header">
                            <h3><i class="fas fa-user-plus me-2"></i>Create Account</h3>
            </div>

                        <div class="auth-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                                <!-- Name Input -->
                        <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                            </span>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                        placeholder="Full Name" value="{{ old('name') }}" required autofocus>
                        </div>
                        @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                        @enderror

                                <!-- Email Input -->
                        <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                placeholder="Email Address" value="{{ old('email') }}" required>
                        </div>
                        @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                        @enderror

                                <!-- Phone Input with Jordan Flag -->
                        <div class="input-group">
                                    <span class="input-group-text">
                                        <div class="flag-wrapper">
                                            <img src="https://flagcdn.com/jo.svg" alt="Jordan Flag" class="flag-img">
                                            +962
                                        </div>
                            </span>
                            <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                        placeholder="7X XXX XXXX" value="{{ old('phone') }}" 
                                        pattern="[7][0-9]{8}" 
                                        title="Please enter a valid Jordan mobile number starting with 7" required>
                        </div>
                        @error('phone')
                                    <div class="text-danger">{{ $message }}</div>
                        @enderror

                                <!-- Password Input -->
                        <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                            </span>
                                    <input type="password" name="password" id="password" 
                                        class="form-control @error('password') is-invalid @enderror" 
                                placeholder="Password" required>
                                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                        </div>
                        @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                        @enderror

                                <!-- Confirm Password Input -->
                        <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                            </span>
                                    <input type="password" name="password_confirmation" id="password_confirmation" 
                                        class="form-control" placeholder="Confirm Password" required>
                                    <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                        </div>
                                
                                <!-- Terms and Conditions Checkbox -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="termsCheck" required>
                                    <label class="form-check-label" for="termsCheck">
                                        I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms & Conditions</a>
                                    </label>
                    </div>

                                <!-- Register Button -->
                                <button type="submit" class="btn-auth mb-3">
                        <i class="fas fa-user-plus me-2"></i>Create Account
                    </button>
                                
                                <!-- Login Link -->
                                <div class="text-center" style="font-size: 0.85rem;">
                        <a href="{{ route('login') }}" class="text-decoration-none">
                                        <i class="fas fa-sign-in-alt me-1"></i> Already have an account? Sign in
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
        </div>
    </div>
    
    <!-- Space between content and footer -->
    <div class="content-footer-spacer"></div>
    
    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <!-- Company Info -->
                <div>
                    <h5>Health Pulse</h5>
                    <p class="mb-2" style="font-size: 0.8rem;">We provide comprehensive healthcare services and electronic pharmacy solutions.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h5>Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('welcome') }}">Home</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="{{ route('doctors') }}">Doctors</a></li>
                    </ul>
                </div>
                
                <!-- Services -->
                <div>
                    <h5>Services</h5>
                    <ul class="footer-links">
                        <li><a href="#">Appointments</a></li>
                        <li><a href="#">Pharmacy</a></li>
                        <li><a href="#">Consultations</a></li>
                    </ul>
                </div>
                
                <!-- Contact Info -->
                <div>
                    <h5>Contact Us</h5>
                    <div class="contact-items">
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-text">Amman, Jordan</div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="contact-text">+962 79 123 4567</div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-text">info@healthpulse.com</div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="contact-text">Sun-Thu: 9am-6pm</div>
            </div>
        </div>
    </div>
</div>
            
            <!-- Copyright -->
            <div class="copyright">
                <p class="mb-0">&copy; {{ date('Y') }} Health Pulse. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

<!-- Terms Modal -->
    <div class="modal fade" id="termsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
                <div class="modal-header" style="background-color: var(--primary); color: white; padding: 0.75rem 1rem;">
                    <h5 class="modal-title" style="font-size: 1rem;"><i class="fas fa-file-contract me-2"></i>Terms & Conditions</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body" style="font-size: 0.8rem; padding: 1rem;">
                    <h6 style="font-size: 0.9rem;"><i class="fas fa-shield-alt me-2"></i>Privacy Policy:</h6>
                    <ul class="small mb-2" style="padding-left: 1.5rem;">
                    <li>We protect your personal medical information</li>
                    <li>Your data is encrypted and secure</li>
                    <li>We never share your information without consent</li>
                </ul>
                
                    <h6 style="font-size: 0.9rem;"><i class="fas fa-file-contract me-2"></i>Terms of Use:</h6>
                    <ul class="small" style="padding-left: 1.5rem;">
                    <li>Provide accurate personal information</li>
                    <li>Keep your login credentials secure</li>
                    <li>Respect appointment scheduling policies</li>
                </ul>
            </div>
                <div class="modal-footer" style="padding: 0.5rem 1rem;">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal">I Agree</button>
            </div>
        </div>
    </div>
</div>

    <!-- Bootstrap & Other Scripts -->
    <script src="/plugins/jquery/jquery.js"></script>
    <script src="/plugins/bootstrap/js/popper.js"></script>
    <script src="/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/plugins/counterup/jquery.easing.js"></script>
    <script src="/plugins/slick-carousel/slick/slick.min.js"></script>
    <script src="/plugins/counterup/jquery.waypoints.min.js"></script>
    <script src="/plugins/shuffle/shuffle.min.js"></script>
    <script src="/plugins/counterup/jquery.counterup.min.js"></script>
    <script src="/js/script.js"></script>
    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = input.nextElementSibling.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
}
    </script>
</body>
</html>
</x-app-layout>