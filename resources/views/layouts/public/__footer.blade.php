<footer style="background-color: #212529; color: rgba(255, 255, 255, 0.7); padding: 1.5rem 0; font-size: 0.85rem;">
    <div class="container">
        <div class="footer-content" style="display: grid; grid-template-columns: 2fr 1fr 1fr 2fr; gap: 1.5rem;">
            <!-- Company Info -->
            <div>
                <h5 style="color: white; font-weight: 600; margin-bottom: 0.75rem; position: relative; font-size: 0.95rem;">Health Pulse</h5>
                <p class="mb-2" style="font-size: 0.8rem;">We provide comprehensive healthcare services and electronic pharmacy solutions.</p>
                <div class="social-links" style="display: flex; gap: 10px; margin-top: 10px;">
                    <a href="{{ route('welcome') }}" style="display: flex; align-items: center; justify-content: center; width: 30px; height: 30px; border-radius: 50%; background-color: rgba(255, 255, 255, 0.1); color: white; transition: all 0.3s ease; font-size: 0.8rem;"><i class="fab fa-facebook-f"></i></a>
                    <a href="{{ route('welcome') }}" style="display: flex; align-items: center; justify-content: center; width: 30px; height: 30px; border-radius: 50%; background-color: rgba(255, 255, 255, 0.1); color: white; transition: all 0.3s ease; font-size: 0.8rem;"><i class="fab fa-twitter"></i></a>
                    <a href="{{ route('welcome') }}" style="display: flex; align-items: center; justify-content: center; width: 30px; height: 30px; border-radius: 50%; background-color: rgba(255, 255, 255, 0.1); color: white; transition: all 0.3s ease; font-size: 0.8rem;"><i class="fab fa-instagram"></i></a>
                    <a href="{{ route('welcome') }}" style="display: flex; align-items: center; justify-content: center; width: 30px; height: 30px; border-radius: 50%; background-color: rgba(255, 255, 255, 0.1); color: white; transition: all 0.3s ease; font-size: 0.8rem;"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div>
                <h5 style="color: white; font-weight: 600; margin-bottom: 0.75rem; position: relative; font-size: 0.95rem;">Quick Links</h5>
                <ul class="footer-links" style="list-style: none; padding-left: 0; margin-bottom: 0;">
                    <li style="margin-bottom: 5px;"><a href="{{ route('welcome') }}" style="color: rgba(255, 255, 255, 0.7); text-decoration: none; transition: all 0.3s ease;">Home</a></li>
                    <li style="margin-bottom: 5px;"><a href="{{ route('about') }}" style="color: rgba(255, 255, 255, 0.7); text-decoration: none; transition: all 0.3s ease;">About Us</a></li>
                    <li style="margin-bottom: 5px;"><a href="{{ route('doctors') }}" style="color: rgba(255, 255, 255, 0.7); text-decoration: none; transition: all 0.3s ease;">Doctors</a></li>
                </ul>
            </div>
            
            <!-- Services -->
            <div>
                <h5 style="color: white; font-weight: 600; margin-bottom: 0.75rem; position: relative; font-size: 0.95rem;">Services</h5>
                <ul class="footer-links" style="list-style: none; padding-left: 0; margin-bottom: 0;">
                    <li style="margin-bottom: 5px;"><a href="{{ route('pharma.index') }}" style="color: rgba(255, 255, 255, 0.7); text-decoration: none; transition: all 0.3s ease;">Pharmacy</a></li>
                    <li style="margin-bottom: 5px;"><a href="{{ route('doctors') }}" style="color: rgba(255, 255, 255, 0.7); text-decoration: none; transition: all 0.3s ease;">Consultations</a></li>
                    <li style="margin-bottom: 5px;"><a href="{{ route('contact') }}" style="color: rgba(255, 255, 255, 0.7); text-decoration: none; transition: all 0.3s ease;">Support</a></li>
                </ul>
            </div>
            
            <!-- Contact Info -->
            <div>
                <h5 style="color: white; font-weight: 600; margin-bottom: 0.75rem; position: relative; font-size: 0.95rem;">Contact Us</h5>
                <div class="contact-items" style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                    <div class="contact-item" style="display: flex; align-items: center;">
                        <div class="contact-icon" style="width: 25px; height: 25px; display: flex; align-items: center; justify-content: center; background-color: rgba(255, 255, 255, 0.1); border-radius: 50%; margin-right: 8px; font-size: 0.7rem;">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-text" style="font-size: 0.8rem;">Amman, Jordan</div>
                    </div>
                    <div class="contact-item" style="display: flex; align-items: center;">
                        <div class="contact-icon" style="width: 25px; height: 25px; display: flex; align-items: center; justify-content: center; background-color: rgba(255, 255, 255, 0.1); border-radius: 50%; margin-right: 8px; font-size: 0.7rem;">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-text" style="font-size: 0.8rem;">+962 79 123 4567</div>
                    </div>
                    <div class="contact-item" style="display: flex; align-items: center;">
                        <div class="contact-icon" style="width: 25px; height: 25px; display: flex; align-items: center; justify-content: center; background-color: rgba(255, 255, 255, 0.1); border-radius: 50%; margin-right: 8px; font-size: 0.7rem;">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-text" style="font-size: 0.8rem;">info@healthpulse.com</div>
                    </div>
                    <div class="contact-item" style="display: flex; align-items: center;">
                        <div class="contact-icon" style="width: 25px; height: 25px; display: flex; align-items: center; justify-content: center; background-color: rgba(255, 255, 255, 0.1); border-radius: 50%; margin-right: 8px; font-size: 0.7rem;">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="contact-text" style="font-size: 0.8rem;">Sun-Thu: 9am-6pm</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="copyright" style="text-align: center; padding-top: 0.75rem; margin-top: 0.75rem; border-top: 1px solid rgba(255, 255, 255, 0.1); font-size: 0.75rem;">
            <p class="mb-0">&copy; {{ date('Y') }} Health Pulse. All Rights Reserved.</p>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mobile Navigation Toggle
        const navbarToggler = document.querySelector('.navbar-toggler');
        const navbarCollapse = document.querySelector('.navbar-collapse');
        
        if (navbarToggler && navbarCollapse) {
            navbarToggler.addEventListener('click', function() {
                navbarCollapse.classList.toggle('show');
                this.classList.toggle('active');
            });

            // Close menu when clicking outside
            document.addEventListener('click', function(event) {
                const isClickInside = navbarCollapse.contains(event.target) || navbarToggler.contains(event.target);
                
                if (!isClickInside && navbarCollapse.classList.contains('show')) {
                    navbarCollapse.classList.remove('show');
                    navbarToggler.classList.remove('active');
                }
            });

            // Close menu when clicking on a nav link
            const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (navbarCollapse.classList.contains('show')) {
                        navbarCollapse.classList.remove('show');
                        navbarToggler.classList.remove('active');
                    }
                });
            });
        }

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

        // Counter animation
        $('.counter').counterUp({
            delay: 10,
            time: 1000
        });
    });
</script>

<style>
    /* Mobile Navigation Styles */
    @media (max-width: 991px) {
        .navbar-collapse {
            position: fixed;
            top: 0;
            left: -100%;
            width: 80%;
            height: 100vh;
            background: white;
            padding: 2rem;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        .navbar-collapse.show {
            left: 0;
        }

        .navbar-nav {
            margin-top: 2rem;
        }

        .nav-item {
            margin: 1rem 0;
        }

        .navbar-toggler {
            z-index: 1001;
            border: none;
            padding: 0.5rem;
            background: transparent;
        }

        .navbar-toggler:focus {
            outline: none;
            box-shadow: none;
        }

        .navbar-toggler-icon {
            width: 25px;
            height: 2px;
            background: var(--primary-color);
            position: relative;
            transition: all 0.3s ease;
        }

        .navbar-toggler-icon::before,
        .navbar-toggler-icon::after {
            content: '';
            position: absolute;
            width: 25px;
            height: 2px;
            background: var(--primary-color);
            transition: all 0.3s ease;
        }

        .navbar-toggler-icon::before {
            transform: translateY(-8px);
        }

        .navbar-toggler-icon::after {
            transform: translateY(8px);
        }

        .navbar-toggler.active .navbar-toggler-icon {
            background: transparent;
        }

        .navbar-toggler.active .navbar-toggler-icon::before {
            transform: rotate(45deg);
        }

        .navbar-toggler.active .navbar-toggler-icon::after {
            transform: rotate(-45deg);
        }

        /* Overlay when menu is open */
        .navbar-collapse::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: -1;
        }

        .navbar-collapse.show::before {
            opacity: 1;
            visibility: visible;
        }
    }
</style>