<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Health Pulse') }}</title>

    <!-- Tailwind CSS via Vite -->
    @vite(['resources/css/app.css'])
</head>
<body class="antialiased bg-gray-100">

    <nav x-data="{ open: false }" class="bg-sky-100 border-b border-sky-200 sticky-top">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 container">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('home') }}">
                            <img src="/images/icon.png" class="h-10" alt="Logo">
                        </a>
                    </div>

                    <!-- Desktop Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                            {{ __('Home') }}
                        </x-nav-link>
                        <x-nav-link :href="route('about')" :active="request()->routeIs('about')">
                            {{ __('About') }}
                        </x-nav-link>
                        <x-nav-link :href="route('contact')" :active="request()->routeIs('contact')">
                            {{ __('Contact') }}
                        </x-nav-link>
                        <x-nav-link :href="route('doctors')" :active="request()->routeIs('doctors')">
                            {{ __('Doctors') }}
                        </x-nav-link>
                        <x-nav-link :href="route('pharma.index')" :active="request()->routeIs('pharma*')">
                            {{ __('Pharmacy') }}
                        </x-nav-link>
                        <x-nav-link :href="route('diagnosis')" :active="request()->routeIs('diagnosis')">
                            {{ __('Diagnosis') }}
                        </x-nav-link>
                    </div>
                </div>

                <!-- User Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    @auth
                        <div class="dropdown">
                            <button class="btn btn-link dropdown-toggle text-sky-700 hover:text-sky-900" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="fas fa-user-edit me-2"></i> {{ __('Profile') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('my.appointments') }}">
                                        <i class="fas fa-calendar-check me-2"></i> {{ __('My Appointments') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('order.items') }}">
                                        <i class="fas fa-shopping-basket me-2"></i> {{ __('My Orders') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('cart.index') }}">
                                        <i class="fas fa-shopping-cart me-2"></i> {{ __('Cart') }}
                                        <span class="badge bg-danger rounded-pill">{{ count(session('cart', [])) }}</span>
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                        @csrf
                                        <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt me-2"></i> {{ __('Log Out') }}
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endauth

                    @guest
                        <div class="space-x-4">
                            <x-nav-link :href="route('login')" class="text-sm text-sky-700 hover:text-sky-900">
                                {{ __('Login') }}
                            </x-nav-link>
                            <x-nav-link :href="route('register')" class="text-sm text-sky-700 hover:text-sky-900">
                                {{ __('Register') }}
                            </x-nav-link>
                        </div>
                    @endguest
                </div>

                <!-- Mobile Hamburger Button -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-sky-600 hover:text-sky-800 hover:bg-sky-200 focus:outline-none focus:bg-sky-200 focus:text-sky-800 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                    {{ __('Home') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('about')" :active="request()->routeIs('about')">
                    {{ __('About') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('contact')" :active="request()->routeIs('contact')">
                    {{ __('Contact') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('doctors')" :active="request()->routeIs('doctors')">
                    {{ __('Doctors') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('pharma.index')" :active="request()->routeIs('pharma*')">
                    {{ __('Pharmacy') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('diagnosis')" :active="request()->routeIs('diagnosis')">
                    {{ __('Diagnosis') }}
                </x-responsive-nav-link>
            </div>

            <div class="pt-4 pb-1 border-t border-sky-200">
                @auth
                    <div class="px-4">
                        <div class="font-medium text-base text-sky-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-sky-600">{{ Auth::user()->email }}</div>
                    </div>
                    <div class="mt-3 space-y-1">
                        <x-responsive-nav-link :href="route('profile.edit')">{{ __('Profile') }}</x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('my.appointments')">{{ __('My Appointments') }}</x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('order.items')">{{ __('My Orders') }}</x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('cart.index')">
                            {{ __('Cart') }} ({{ count(session('cart', [])) }})
                        </x-responsive-nav-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-responsive-nav-link>
                        </form>
                    </div>
                @endauth

                @guest
                    <div class="px-4">
                        <div class="font-medium text-sm text-sky-700">{{ __('You are not logged in.') }}</div>
                        <div class="mt-3 space-y-1">
                            <x-responsive-nav-link :href="route('login')">{{ __('Login') }}</x-responsive-nav-link>
                            <x-responsive-nav-link :href="route('register')">{{ __('Register') }}</x-responsive-nav-link>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="py-6">
        @yield('content')
    </main>

    <style>
    .sticky-top {
        position: sticky;
        top: 0;
        z-index: 1030;
        transition: all 0.3s ease;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    }
    </style>

    <!-- Alpine.js (via CDN) -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Vite scripts -->
    @vite(['resources/js/app.js'])
</body>
</html>
