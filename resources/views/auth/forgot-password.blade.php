<x-app-layout>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Health Pulse') }} - Reset Password</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

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

        .text-danger {
            margin-top: -0.5rem;
            margin-bottom: 0.5rem;
            font-size: 0.75rem;
        }

        footer {
            background-color: var(--dark);
            color: rgba(255, 255, 255, 0.7);
            padding: 1.5rem 0;
            font-size: 0.85rem;
        }

        .copyright {
            text-align: center;
            padding-top: 0.75rem;
            margin-top: 0.75rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.75rem;
        }
    </style>
</head>
<body>
    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <!-- Alert Messages -->
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <!-- Reset Password Card -->
                    <div class="auth-card">
                        <div class="auth-header">
                            <h3><i class="fas fa-key me-2"></i>Reset Password</h3>
                        </div>
                        
                        <div class="auth-body">
                            <div class="mb-4 text-muted" style="font-size: 0.9rem;">
                                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                            </div>
                            
                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                
                                <!-- Email Input -->
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                        placeholder="Email Address" value="{{ old('email') }}" required autofocus>
                                </div>
                                @error('email')
                                    <div class="text-danger mb-3">{{ $message }}</div>
                                @enderror
                                
                                <!-- Submit Button -->
                                <button type="submit" class="btn-auth mb-3">
                                    <i class="fas fa-paper-plane me-2"></i>Send Reset Link
                                </button>
                                
                                <!-- Back to Login -->
                                <div class="text-center" style="font-size: 0.85rem;">
                                    <a href="{{ route('login') }}" class="text-decoration-none" style="color: var(--primary);">
                                        <i class="fas fa-arrow-left me-1"></i>Back to Login
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="copyright">
                <p class="mb-0">&copy; {{ date('Y') }} Health Pulse. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap & Other Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
</x-app-layout>