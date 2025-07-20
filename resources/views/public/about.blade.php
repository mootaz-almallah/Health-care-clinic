
<x-app-layout>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Health Pulse</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #7c3aed;
            --accent-color: #06b6d4;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --bg-light: #f8fafc;
            --white: #ffffff;
            --gradient-primary: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            --gradient-secondary: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
            line-height: 1.7;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* Hero Section with Advanced Effects */
        .page-title {
            height: 100vh;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #4baed1 0%, #2c7a95 100%);
            overflow: hidden;
        }

        .page-title::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="20" height="20" patternUnits="userSpaceOnUse"><path d="M 20 0 L 0 0 0 20" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            animation: gridMove 20s linear infinite;
        }

        .floating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .floating-shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            animation: float 6s ease-in-out infinite;
        }

        .floating-shape:nth-child(1) {
            width: 150px;
            height: 150px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-shape:nth-child(2) {
            width: 100px;
            height: 100px;
            top: 60%;
            right: 15%;
            animation-delay: -2s;
        }

        .floating-shape:nth-child(3) {
            width: 120px;
            height: 120px;
            bottom: 20%;
            left: 20%;
            animation-delay: -4s;
        }

        .floating-shape:nth-child(4) {
            width: 180px;
            height: 180px;
            top: 30%;
            right: 30%;
            animation-delay: -3s;
        }

        @keyframes float {
            0%, 100% { 
                transform: translateY(0px) rotate(0deg); 
                opacity: 0.7;
            }
            50% { 
                transform: translateY(-30px) rotate(180deg); 
                opacity: 1;
            }
        }

        @keyframes gridMove {
            0% { transform: translateX(0); }
            100% { transform: translateX(20px); }
        }

        .hero-content {
            text-align: center;
            color: white;
            z-index: 10;
            position: relative;
            padding: 2rem;
        }

        .hero-content span {
            font-size: 1.6rem;
            font-weight: 500;
            letter-spacing: 6px;
            text-transform: uppercase;
            opacity: 0;
            animation: slideUp 1s ease-out 0.5s forwards;
            display: block;
            margin-bottom: 2rem;
            color: rgba(255, 255, 255, 0.9);
        }

        .hero-content h1 {
            font-size: 5.5rem;
            font-weight: 800;
            margin: 1.5rem 0;
            background: linear-gradient(45deg, #ffffff, #e0e7ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            opacity: 0;
            animation: slideUp 1s ease-out 1s forwards;
            text-shadow: 0 2px 15px rgba(0,0,0,0.1);
            letter-spacing: 8px;
            position: relative;
            display: inline-block;
            line-height: 1.2;
            padding: 0 20px;
        }

        .hero-content h1::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 60%;
            height: 3px;
            background: linear-gradient(90deg, transparent, #ffffff, transparent);
            border-radius: 2px;
        }

        .hero-description {
            font-size: 1.8rem;
            font-weight: 400;
            opacity: 0;
            animation: slideUp 1s ease-out 1.5s forwards;
            margin: 2.5rem 0;
            color: rgba(255, 255, 255, 0.95);
            text-shadow: 0 2px 10px rgba(0,0,0,0.1);
            letter-spacing: 1px;
        }

        .hero-stats {
            opacity: 0;
            animation: slideUp 1s ease-out 2s forwards;
        }

        .stat-item {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 1.5rem;
            border-radius: 15px;
            margin: 0.5rem;
            transition: transform 0.3s ease;
        }

        .stat-item:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.2);
        }

        .stat-item h3 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #ffffff;
        }

        .stat-item p {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.9);
            margin: 0;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Enhanced About Section */
        .about-page {
            padding: 120px 0;
            background: linear-gradient(135deg, #f8fafc 0%, #ffffff 50%, #f1f5f9 100%);
            position: relative;
        }

        .about-page::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--primary-color), transparent);
        }

        .title-color {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 2.5rem;
            line-height: 1.3;
            position: relative;
            margin-bottom: 2rem;
        }

        .title-color::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 0;
            width: 60px;
            height: 4px;
            background: var(--gradient-secondary);
            border-radius: 2px;
        }

        .about-page p {
            font-size: 1.2rem;
            line-height: 1.8;
            color: var(--text-light);
            margin-bottom: 0;
        }

        /* Premium Feature Cards */
        .feature-page {
            padding: 120px 0;
            background: var(--white);
        }

        .about-block-item {
            background: var(--white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            height: 100%;
        }

        .about-block-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .about-block-item:hover {
            transform: translateY(-15px);
            box-shadow: var(--shadow-xl);
        }

        .about-block-item:hover::before {
            transform: scaleX(1);
        }

        .about-block-item img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .about-block-item:hover img {
            transform: scale(1.1);
        }

        .about-block-item h4 {
            color: var(--text-dark);
            font-weight: 600;
            font-size: 1.4rem;
            margin: 1.5rem 0 1rem;
            padding: 0 1.5rem;
        }

        .about-block-item p {
            color: var(--text-light);
            padding: 0 1.5rem 2rem;
            margin: 0;
        }

        /* Animated Awards Section */
        .awards {
            padding: 120px 0;
            background: linear-gradient(135deg, #4baed1 0%, #2c7a95 100%);
            position: relative;
            overflow: hidden;
        }

        .awards::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" width="10" height="10" patternUnits="userSpaceOnUse"><circle cx="5" cy="5" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23dots)"/></svg>');
        }

        .awards .container {
            position: relative;
            z-index: 2;
        }

        .awards h2 {
            color: white;
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 2rem;
        }

        .awards .title-color {
            color: white;
        }

        .awards .divider {
            width: 60px;
            height: 4px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 2px;
        }

        .award-img {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            text-align: center;
            height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .award-img:hover {
            transform: translateY(-10px) scale(1.05);
            background: rgba(255, 255, 255, 0.2);
        }

        .award-img img {
            max-width: 80px;
            max-height: 80px;
            filter: brightness(0) invert(1);
            transition: all 0.3s ease;
        }

        .award-img:hover img {
            transform: scale(1.1) rotate(5deg);
        }

        /* Premium Team Section */
        .team {
            padding: 120px 0;
            background: linear-gradient(135deg, var(--bg-light) 0%, var(--white) 100%);
        }

        .section-title h2 {
            font-size: 3rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1rem;
        }

        .section-title .divider {
            width: 80px;
            height: 4px;
            background: var(--gradient-primary);
            margin: 0 auto;
            border-radius: 2px;
        }

        .section-title p {
            font-size: 1.1rem;
            color: var(--text-light);
            max-width: 600px;
            margin: 2rem auto 0;
        }

        .team-block {
            background: var(--white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            height: 100%;
        }

        .team-block::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--gradient-primary);
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 1;
        }

        .team-block:hover {
            transform: translateY(-15px);
            box-shadow: var(--shadow-xl);
        }

        .team-block:hover::before {
            opacity: 0.1;
        }

        .team-block img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .team-block:hover img {
            transform: scale(1.1);
        }

        .team-block .content {
            padding: 2rem 1.5rem;
            position: relative;
            z-index: 2;
        }

        .team-block h4 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .team-block h4 a {
            color: var(--text-dark);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .team-block h4 a:hover {
            color: var(--primary-color);
        }

        .team-block p {
            color: var(--primary-color);
            font-weight: 500;
            margin: 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 3.5rem;
                letter-spacing: 4px;
                padding: 0 10px;
            }
            
            .hero-content span {
                font-size: 1.2rem;
                letter-spacing: 3px;
            }
            
            .hero-description {
                font-size: 1.3rem;
            }
            
            .stat-item h3 {
                font-size: 1.8rem;
            }
            
            .stat-item p {
                font-size: 0.9rem;
            }

            .title-color {
                font-size: 2rem;
            }

            .section-title h2 {
                font-size: 2rem;
            }

            .about-page, .feature-page, .awards, .team {
                padding: 80px 0;
            }
        }

        /* Custom Animations */
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .animate-on-scroll.animated {
            opacity: 1;
            transform: translateY(0);
        }

        /* Loading Animation */
        .loading-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--gradient-primary);
            transform: translateX(-100%);
            animation: loadingBar 2s ease-out;
            z-index: 9999;
        }

        @keyframes loadingBar {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(0); }
        }
    </style>
</head>
<body>
    <div class="loading-bar"></div>

    <!-- Enhanced Hero Section -->
    <section class="page-title bg-1">
        <div class="floating-elements">
            <div class="floating-shape"></div>
            <div class="floating-shape"></div>
            <div class="floating-shape"></div>
            <div class="floating-shape"></div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="hero-content">
                        <span class="text-white">Welcome to</span>
                        <h1 class="text-capitalize mb-5 text-lg">Health Pulse</h1>
                        <p class="hero-description">Your Trusted Healthcare Partner</p>
                        <div class="hero-stats mt-5">
                            <div class="row justify-content-center">
                                <div class="col-md-3 col-6">
                                    <div class="stat-item">
                                        <h3>1000+</h3>
                                        <p>Happy Patients</p>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="stat-item">
                                        <h3>50+</h3>
                                        <p>Expert Doctors</p>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="stat-item">
                                        <h3>15+</h3>
                                        <p>Specialties</p>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="stat-item">
                                        <h3>24/7</h3>
                                        <p>Support</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced About Section -->
    <section class="section about-page">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4" data-aos="fade-right" data-aos-duration="1000">
                    <h2 class="title-color">Health Pulse Your Trusted Path to Better Health</h2>
                </div>
                <div class="col-lg-8" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                    <p>Health Pulse is a seamless online platform designed to connect patients with highly qualified doctors across various medical specialties. Our mission is to provide exceptional healthcare by making the appointment booking process effortless and efficient. Patients can easily find the right specialist, choose a suitable time, and coordinate with their doctor—all in just a few clicks. With a focus on quality care and convenience, we ensure that healthcare is always within reach.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Premium Feature Section -->
    <section class="feature-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-5" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                    <div class="about-block-item">
                        <img src="images/about/about-1.jpg" alt="Easy Appointment Booking" class="img-fluid w-100">
                        <h4 class="mt-3">Easy Appointment Booking</h4>
                        <p>Schedule your medical appointments effortlessly with top specialists.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-5" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                    <div class="about-block-item">
                        <img src="images/about/about-2.jpg" alt="Expert Medical Consultations" class="img-fluid w-100">
                        <h4 class="mt-3">Expert Medical Consultations</h4>
                        <p>Connect with qualified doctors who provide trusted medical advice.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-5" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
                    <div class="about-block-item">
                        <img src="images/about/about-3.jpg" alt="Accessible Healthcare Services" class="img-fluid w-100">
                        <h4 class="mt-3">Accessible Healthcare Services</h4>
                        <p>Find the right doctor at the right time, tailored to your needs.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-5 mb-lg-0" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
                    <div class="about-block-item">
                        <img src="images/about/about-4.jpg" alt="Reliable Medical Support" class="img-fluid w-100">
                        <h4 class="mt-3">Reliable Medical Support</h4>
                        <p>Access trusted healthcare services anytime, anywhere.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Animated Awards Section -->
    <section class="section awards">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4" data-aos="fade-right" data-aos-duration="1000">
                    <h2 class="title-color">Our Doctors Achievements</h2>
                    <div class="divider mt-4 mb-5 mb-lg-0"></div>
                </div>
                <div class="col-lg-8" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-6 mb-4" data-aos="zoom-in" data-aos-duration="600" data-aos-delay="100">
                            <div class="award-img">
                                <img src="images/about/3.png" alt="Award 3" class="img-fluid">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 mb-4" data-aos="zoom-in" data-aos-duration="600" data-aos-delay="200">
                            <div class="award-img">
                                <img src="images/about/4.png" alt="Award 4" class="img-fluid">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 mb-4" data-aos="zoom-in" data-aos-duration="600" data-aos-delay="300">
                            <div class="award-img">
                                <img src="images/about/1.png" alt="Award 1" class="img-fluid">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 mb-4" data-aos="zoom-in" data-aos-duration="600" data-aos-delay="400">
                            <div class="award-img">
                                <img src="images/about/2.png" alt="Award 2" class="img-fluid">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 mb-4" data-aos="zoom-in" data-aos-duration="600" data-aos-delay="500">
                            <div class="award-img">
                                <img src="images/about/5.png" alt="Award 5" class="img-fluid">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 mb-4" data-aos="zoom-in" data-aos-duration="600" data-aos-delay="600">
                            <div class="award-img">
                                <img src="images/about/6.png" alt="Award 6" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Premium Team Section -->
    <section class="section team">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8" data-aos="fade-up" data-aos-duration="1000">
                    <div class="section-title text-center">
                        <h2 class="mb-4">Meet Our Specialist</h2>
                        <div class="divider mx-auto my-4"></div>
                        <p>Today's users expect effortless experiences. Don't let essential people and processes stay stuck in the past. Speed it up, skip the hassles</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 col-sm-6 mb-5" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                    <div class="team-block">
                        <img src="images/team/1.jpg" alt="John Marshal" class="img-fluid w-100">
                        <div class="content">
                            <h4 class="mt-4 mb-0"><a href="doctor-single.html">John Marshal</a></h4>
                            <p>Internist, Emergency Physician</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6 mb-5" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                    <div class="team-block">
                        <img src="images/team/2.jpg" alt="Marshal Root" class="img-fluid w-100">
                        <div class="content">
                            <h4 class="mt-4 mb-0"><a href="doctor-single.html">Marshal Root</a></h4>
                            <p>Surgeon, Сardiologist</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6 mb-5" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
                    <div class="team-block">
                        <img src="images/team/3.jpg" alt="Siamon john" class="img-fluid w-100">
                        <div class="content">
                            <h4 class="mt-4 mb-0"><a href="doctor-single.html">Siamon John</a></h4>
                            <p>Internist, General Practitioner</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6 mb-5" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
                    <div class="team-block">
                        <img src="images/team/4.jpg" alt="Rishat Ahmed" class="img-fluid w-100">
                        <div class="content">
                            <h4 class="mt-4 mb-0"><a href="doctor-single.html">Rishat Ahmed</a></h4>
                            <p>Orthopedic Surgeon</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6 mb-5" data-aos="fade-up" data-aos-duration="800" data-aos-delay="500">
                    <div class="team-block">
                        <img src="images/team/15.jpg" alt="Sarah Johnson" class="img-fluid w-100">
                        <div class="content">
                            <h4 class="mt-4 mb-0"><a href="doctor-single.html">Sarah Johnson</a></h4>
                            <p>Pediatrician, Family Medicine</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });

        // Custom scroll animations
        window.addEventListener('scroll', () => {
            const scrollTop = window.pageYOffset;
            
            // Parallax effect for hero section
            const hero = document.querySelector('.page-title');
            if (hero) {
                hero.style.transform = `translateY(${scrollTop * 0.5}px)`;
            }

            // Animate elements on scroll
            const animateElements = document.querySelectorAll('.animate-on-scroll');
            animateElements.forEach(el => {
                const elementTop = el.offsetTop;
                const elementVisible = 150;
                
                if (scrollTop > (elementTop - window.innerHeight + elementVisible)) {
                    el.classList.add('animated');
                }
            });
        });

        // Enhanced hover effects
        document.querySelectorAll('.about-block-item, .team-block').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-15px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Award items animation
        document.querySelectorAll('.award-img').forEach(award => {
            award.addEventListener('mouseenter', function() {
                const img = this.querySelector('img');
                if (img) {
                    img.style.transform = 'scale(1.2) rotate(5deg)';
                }
            });
            
            award.addEventListener('mouseleave', function() {
                const img = this.querySelector('img');
                if (img) {
                    img.style.transform = 'scale(1) rotate(0deg)';
                }
            });
        });

        // Smooth scrolling for internal links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Page load animation
        window.addEventListener('load', () => {
            const loadingBar = document.querySelector('.loading-bar');
            if (loadingBar) {
                setTimeout(() => {
                    loadingBar.style.display = 'none';
                }, 2000);
            }
        });
    </script>
</body>
</html>
</x-app-layout>