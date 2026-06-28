<x-admin-layout>
    <x-slot name="title">Admin Dashboard</x-slot>

    <!-- Header Section -->
    <div class="md:flex md:items-center md:justify-between mb-8">
        <div class="flex-1 min-w-0">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight sm:truncate">
                Welcome back, Admin!
            </h1>
            <p class="mt-2 text-sm text-slate-500">
                Here's what is happening across your hybrid rental portal today.
            </p>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <!-- Stat Card 1 -->
        <div class="bg-white overflow-hidden rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-indigo-50 rounded-xl text-indigo-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-semibold text-slate-500 truncate">Total Flats</dt>
                            <dd class="text-2xl font-bold text-slate-950 mt-1">24</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="bg-white overflow-hidden rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-emerald-50 rounded-xl text-emerald-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-semibold text-slate-500 truncate">Verified Online</dt>
                            <dd class="text-2xl font-bold text-slate-950 mt-1">18</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="bg-white overflow-hidden rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-amber-50 rounded-xl text-amber-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-semibold text-slate-500 truncate">Active Leads</dt>
                            <dd class="text-2xl font-bold text-slate-950 mt-1">12</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stat Card 4 -->
        <div class="bg-white overflow-hidden rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-violet-50 rounded-xl text-violet-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-semibold text-slate-500 truncate">Scheduled Visits</dt>
                            <dd class="text-2xl font-bold text-slate-950 mt-1">4</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Section: Two Column Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: Recent Bookings & Listings (Span 2) -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Recent Listings Card -->
            <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-slate-900">Recent Listings</h3>
                    <a href="{{ route('admin.properties.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">View all</a>
                </div>
                <div class="divide-y divide-slate-100">
                    <div class="p-6 flex items-center justify-between hover:bg-slate-50 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="w-12 x-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400 font-bold">1BHK</div>
                            <div>
                                <h4 class="font-bold text-slate-800">Cozy 1 BHK near Batla House Metro</h4>
                                <p class="text-xs text-slate-400 mt-1">Added 2 hours ago • By Saddam</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-800 border border-amber-200">Pending Verification</span>
                    </div>

                    <div class="p-6 flex items-center justify-between hover:bg-slate-50 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="w-12 x-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 font-bold">2BHK</div>
                            <div>
                                <h4 class="font-bold text-slate-800">Spacious 2 BHK in Zakir Nagar</h4>
                                <p class="text-xs text-slate-400 mt-1">Added 1 day ago • By Saddam</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">Verified & Live</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Actions & Agents -->
        <div class="space-y-8">
            <!-- Quick Actions -->
            <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm p-6">
                <h3 class="text-lg font-bold text-slate-900 mb-4">Quick Management Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.properties.create') }}" class="w-full flex items-center justify-between p-4 bg-indigo-50 hover:bg-indigo-100/80 rounded-xl text-indigo-900 font-bold transition-all group">
                        <span>Create Property Listing</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Agent Performance List -->
            <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm p-6">
                <h3 class="text-lg font-bold text-slate-900 mb-4">Office Agents</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-slate-800 text-white flex items-center justify-center text-xs font-bold uppercase">AS</div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-800">Agent Saddam</h4>
                                <p class="text-xs text-slate-400">10 Assigned Leads</p>
                            </div>
                        </div>
                        <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded">Active</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>
