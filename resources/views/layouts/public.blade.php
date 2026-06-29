<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'OkhlaFlat') }} - Hybrid Real Estate</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Alpine JS (Already compiled in app.js, but fallback for Blade) -->

        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
            }
            h1, h2, h3, h4, h5, h6 {
                font-family: 'Outfit', sans-serif;
            }
            .glassmorphism {
                background: rgba(255, 255, 255, 0.85);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
            }
        </style>
    </head>
    <body class="antialiased bg-slate-50 text-slate-900 selection:bg-indigo-600 selection:text-white min-h-screen flex flex-col">
        <!-- Header / Navbar -->
        <header x-data="{ mobileMenuOpen: false }" class="sticky top-0 z-50 glassmorphism border-b border-slate-200/80 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20 items-center">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-violet-600 flex items-center justify-center text-white font-extrabold text-xl shadow-md shadow-indigo-200 group-hover:scale-105 transition-transform duration-300">
                                OF
                            </div>
                            <span class="text-2xl font-bold tracking-tight bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent group-hover:opacity-90 transition-opacity">
                                Okhla<span class="font-extrabold text-slate-800">Flat</span>
                            </span>
                        </a>
                    </div>

                    <!-- Desktop Menu -->
                    <nav class="hidden md:flex space-x-8">
                        <a href="{{ route('home') }}" class="text-sm font-semibold {{ Route::currentRouteName() === 'home' ? 'text-indigo-600' : 'text-slate-600 hover:text-indigo-600' }} transition-colors">Home</a>
                        <a href="{{ route('properties.index') }}" class="text-sm font-semibold {{ Route::currentRouteName() === 'properties.index' ? 'text-indigo-600' : 'text-slate-600 hover:text-indigo-600' }} transition-colors">Search Flats</a>
                        <a href="{{ route('customer.properties.create') }}" class="text-sm font-semibold {{ Route::currentRouteName() === 'customer.properties.create' ? 'text-indigo-600' : 'text-slate-600 hover:text-indigo-600' }} transition-colors">List Your Flat</a>
                        <a href="{{ route('about') }}" class="text-sm font-semibold {{ Route::currentRouteName() === 'about' ? 'text-indigo-600' : 'text-slate-600 hover:text-indigo-600' }} transition-colors">About</a>
                        <a href="{{ route('contact') }}" class="text-sm font-semibold {{ Route::currentRouteName() === 'contact' ? 'text-indigo-600' : 'text-slate-600 hover:text-indigo-600' }} transition-colors">Contact</a>
                    </nav>

                    <!-- CTAs / User Auth -->
                    <div class="hidden md:flex items-center space-x-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-slate-700 hover:text-indigo-600 transition-colors">Portal Dashboard</a>
                            <a href="{{ route('profile.edit') }}" class="text-sm font-semibold text-slate-700 hover:text-indigo-600 transition-colors">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition-all shadow-md shadow-indigo-100 hover:shadow-lg hover:-translate-y-0.5 duration-200">
                                    Sign Out
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-700 hover:text-indigo-600 transition-colors">Log in</a>
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 rounded-xl transition-all shadow-md shadow-indigo-100 hover:shadow-lg hover:-translate-y-0.5 duration-200">
                                Register
                            </a>
                        @endauth
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="flex items-center md:hidden">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="inline-flex items-center justify-center p-2 rounded-lg text-slate-500 hover:text-slate-800 hover:bg-slate-100 focus:outline-none transition-colors" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" x-show="!mobileMenuOpen">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" x-show="mobileMenuOpen" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen" x-transition class="md:hidden border-t border-slate-200 bg-white" style="display: none;">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg text-base font-semibold {{ Route::currentRouteName() === 'home' ? 'text-indigo-600 bg-indigo-50' : 'text-slate-700 hover:text-indigo-600 hover:bg-slate-50' }}">Home</a>
                    <a href="{{ route('properties.index') }}" class="block px-3 py-2 rounded-lg text-base font-semibold {{ Route::currentRouteName() === 'properties.index' ? 'text-indigo-600 bg-indigo-50' : 'text-slate-700 hover:text-indigo-600 hover:bg-slate-50' }}">Search Flats</a>
                    <a href="{{ route('customer.properties.create') }}" class="block px-3 py-2 rounded-lg text-base font-semibold {{ Route::currentRouteName() === 'customer.properties.create' ? 'text-indigo-600 bg-indigo-50' : 'text-slate-700 hover:text-indigo-600 hover:bg-slate-50' }}">List Your Flat</a>
                    <a href="{{ route('about') }}" class="block px-3 py-2 rounded-lg text-base font-semibold {{ Route::currentRouteName() === 'about' ? 'text-indigo-600 bg-indigo-50' : 'text-slate-700 hover:text-indigo-600 hover:bg-slate-50' }}">About</a>
                    <a href="{{ route('contact') }}" class="block px-3 py-2 rounded-lg text-base font-semibold {{ Route::currentRouteName() === 'contact' ? 'text-indigo-600 bg-indigo-50' : 'text-slate-700 hover:text-indigo-600 hover:bg-slate-50' }}">Contact</a>
                </div>
                <div class="pt-4 pb-4 border-t border-slate-200 px-4 space-y-2">
                    @auth
                        <a href="{{ route('dashboard') }}" class="block text-center w-full px-4 py-2.5 text-base font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">Portal Dashboard</a>
                        <a href="{{ route('profile.edit') }}" class="block text-center w-full px-4 py-2.5 text-base font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full px-4 py-2.5 text-center text-base font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition-colors">
                                Sign Out
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block text-center w-full px-4 py-2.5 text-base font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">Log in</a>
                        <a href="{{ route('register') }}" class="block text-center w-full px-4 py-2.5 text-base font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition-colors">Register</a>
                    @endauth
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-slate-900 text-slate-300 border-t border-slate-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <!-- About Brand -->
                    <div class="space-y-4 col-span-1 md:col-span-2">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center text-white font-extrabold text-lg">
                                OF
                            </div>
                            <span class="text-xl font-bold tracking-tight text-white">
                                Okhla<span class="font-extrabold text-indigo-400">Flat</span>
                            </span>
                        </div>
                        <p class="text-sm text-slate-400 max-w-sm leading-relaxed">
                            A premium hybrid real estate platform simplifying rental apartment discovery in Jamia Nagar. Find verified properties online, book an office visit, and let our agents help you move in with only a {{ $globalBrokerageFee }}% service fee.
                        </p>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h3 class="text-sm font-semibold text-slate-200 uppercase tracking-wider mb-4">Navigation</h3>
                        <ul class="space-y-2 text-sm">
                            <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a></li>
                            <li><a href="{{ route('properties.index') }}" class="hover:text-white transition-colors">Browse Flats</a></li>
                            <li><a href="{{ route('about') }}" class="hover:text-white transition-colors">About Us</a></li>
                            <li><a href="{{ route('contact') }}" class="hover:text-white transition-colors">Contact</a></li>
                        </ul>
                    </div>

                    <!-- Contact & Info -->
                    <div>
                        <h3 class="text-sm font-semibold text-slate-200 uppercase tracking-wider mb-4">Office Address</h3>
                        <ul class="space-y-2 text-sm text-slate-400">
                            <li>Jamia Nagar, Okhla</li>
                            <li>New Delhi - 110025</li>
                            <li class="pt-2 text-slate-300">Email: info@okhlaflat.com</li>
                            <li>Phone: +91 98765 43210</li>
                        </ul>
                    </div>
                </div>

                <div class="mt-12 pt-8 border-t border-slate-800 text-center text-xs text-slate-500 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <p>&copy; {{ date('Y') }} OkhlaFlat Real Estate Platform. All rights reserved.</p>
                    <p class="text-indigo-400/80">Affordable. Verified. Premium.</p>
                </div>
            </div>
        </footer>
    </body>
</html>
