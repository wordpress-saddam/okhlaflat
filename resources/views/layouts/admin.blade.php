<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Admin Panel' }} - OkhlaFlat</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Alpine JS (compiled in app.js, but fallback for Blade) -->
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
            }
            h1, h2, h3, h4, h5, h6 {
                font-family: 'Outfit', sans-serif;
            }
        </style>
    </head>
    <body class="h-full antialiased text-slate-900">
        <div x-data="{ sidebarOpen: false }" class="min-h-full">
            
            <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
            <div x-show="sidebarOpen" class="relative z-50 lg:hidden" role="dialog" aria-modal="true" style="display: none;">
                <div x-show="sidebarOpen" 
                     x-transition:enter="transition-opacity ease-linear duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition-opacity ease-linear duration-300"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-slate-900/80"></div>

                <div class="fixed inset-0 flex">
                    <div x-show="sidebarOpen" 
                         x-transition:enter="transition ease-in-out duration-300 transform"
                         x-transition:enter-start="-translate-x-full"
                         x-transition:enter-end="translate-x-0"
                         x-transition:leave="transition ease-in-out duration-300 transform"
                         x-transition:leave-start="translate-x-0"
                         x-transition:leave-end="-translate-x-full"
                         class="relative mr-16 flex w-full max-w-xs flex-1"
                         @click.away="sidebarOpen = false">
                        
                        <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                            <button @click="sidebarOpen = false" type="button" class="-m-2.5 p-2.5 text-white">
                                <span class="sr-only">Close sidebar</span>
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Sidebar component for mobile -->
                        <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-slate-900 px-6 pb-4 ring-1 ring-white/10">
                            <div class="flex h-16 shrink-0 items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-indigo-500 flex items-center justify-center text-white font-extrabold text-lg">OF</div>
                                <span class="text-xl font-bold tracking-tight text-white">Okhla<span class="font-extrabold text-indigo-400">Flat</span></span>
                            </div>
                            <nav class="flex flex-1 flex-col">
                                <ul role="list" class="flex flex-1 flex-col gap-y-7">
                                    <li>
                                        <ul role="list" class="-mx-2 space-y-1">
                                            @include('layouts.admin-nav-links')
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Static sidebar for desktop -->
            <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
                <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-slate-900 px-6 pb-4">
                    <div class="flex h-20 shrink-0 items-center gap-2 border-b border-slate-800">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-500 to-violet-500 flex items-center justify-center text-white font-extrabold text-xl shadow-lg shadow-indigo-900/30">
                            OF
                        </div>
                        <span class="text-2xl font-bold tracking-tight text-white">
                            Okhla<span class="font-extrabold text-indigo-400">Flat</span>
                        </span>
                    </div>
                    <nav class="flex flex-1 flex-col mt-4">
                        <ul role="list" class="flex flex-1 flex-col gap-y-7">
                            <li>
                                <ul role="list" class="-mx-2 space-y-1.5">
                                    @include('layouts.admin-nav-links')
                                </ul>
                            </li>
                            
                            <!-- User info at bottom of sidebar -->
                            <li class="mt-auto -mx-6 border-t border-slate-800 px-6 pt-4">
                                <div class="flex items-center gap-x-4">
                                    <div class="h-10 w-10 rounded-full bg-slate-800 flex items-center justify-center text-indigo-400 font-bold uppercase ring-2 ring-indigo-500/20">
                                        {{ substr(auth()->user()->name, 0, 2) }}
                                    </div>
                                    <div class="text-sm font-semibold leading-6 text-white overflow-hidden">
                                        <p class="truncate">{{ auth()->user()->name }}</p>
                                        <span class="text-xs text-indigo-400 capitalize">{{ auth()->user()->roles->first()?->name ?? 'User' }}</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Main layout area -->
            <div class="lg:pl-72 flex flex-col min-h-screen">
                
                <!-- Navbar / Header -->
                <div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-slate-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
                    <button @click="sidebarOpen = true" type="button" class="-m-2.5 p-2.5 text-slate-700 lg:hidden">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>

                    <!-- Separator -->
                    <div class="h-6 w-px bg-slate-900/10 lg:hidden" aria-hidden="true"></div>

                    <div class="flex flex-1 justify-between items-center gap-x-4 self-stretch lg:gap-x-6">
                        <!-- Left header section -->
                        <div>
                            <h2 class="text-lg font-bold text-slate-800 capitalize">
                                {{ auth()->user()->roles->first()?->name ?? 'User' }} Portal
                            </h2>
                        </div>

                        <!-- Right header actions -->
                        <div class="flex items-center gap-x-4 lg:gap-x-6">
                            
                            <!-- Profile dropdown -->
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" type="button" class="-m-1.5 flex items-center p-1.5 focus:outline-none" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="sr-only">Open user menu</span>
                                    <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold uppercase">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                    <span class="hidden lg:flex lg:items-center">
                                        <span class="ml-4 text-sm font-semibold leading-6 text-slate-700" aria-hidden="true">{{ auth()->user()->name }}</span>
                                        <svg class="ml-2 h-5 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </button>

                                <div x-show="open" 
                                     @click.away="open = false"
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     class="absolute right-0 z-10 mt-2.5 w-48 origin-top-right rounded-xl bg-white py-2 shadow-lg ring-1 ring-slate-900/5 focus:outline-none" 
                                     role="menu" 
                                     aria-orientation="vertical" 
                                     aria-labelledby="user-menu-button" 
                                     tabindex="-1"
                                     style="display: none;">
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition-colors" role="menuitem" tabindex="-1">Your Profile</a>
                                    <a href="{{ route('home') }}" class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition-colors" role="menuitem" tabindex="-1">View Website</a>
                                    <div class="h-px bg-slate-100 my-1"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors" role="menuitem" tabindex="-1">
                                            Sign out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content Area -->
                <main class="py-10 flex-grow">
                    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        
                        <!-- Notifications Alert Block (for Flash messaging) -->
                        @if(session('success'))
                            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center gap-3 shadow-sm animate-fade-in">
                                <svg class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-sm font-semibold">{{ session('success') }}</span>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl flex items-center gap-3 shadow-sm animate-fade-in">
                                <svg class="h-5 w-5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-sm font-semibold">{{ session('error') }}</span>
                            </div>
                        @endif

                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
