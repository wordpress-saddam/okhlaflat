<x-admin-layout>
    <x-slot name="title">Admin Dashboard - OkhlaFlat</x-slot>

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
                            <dd class="text-2xl font-bold text-slate-950 mt-1">{{ $totalFlats }}</dd>
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
                            <dd class="text-2xl font-bold text-slate-950 mt-1">{{ $verifiedFlats }}</dd>
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
                            <dd class="text-2xl font-bold text-slate-950 mt-1">{{ $activeLeads }}</dd>
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
                            <dd class="text-2xl font-bold text-slate-950 mt-1">{{ $scheduledVisits }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue & Conversion Stats Grid -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <!-- Revenue Card -->
        <div class="bg-gradient-to-br from-indigo-900 to-indigo-950 text-white overflow-hidden rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-white/10 rounded-xl text-white">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-semibold text-indigo-200 truncate">Total Collected Revenue</dt>
                            <dd class="text-2xl font-black mt-1">₹{{ number_format($totalRevenue) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Fees Card -->
        <div class="bg-white overflow-hidden rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-rose-50 rounded-xl text-rose-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-semibold text-slate-500 truncate">Pending Invoiced Fees</dt>
                            <dd class="text-2xl font-bold text-slate-950 mt-1">₹{{ number_format($pendingRevenue) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Conversion Rate Card -->
        <div class="bg-white overflow-hidden rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-teal-50 rounded-xl text-teal-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-semibold text-slate-500 truncate">Deal Conversion Rate</dt>
                            <dd class="text-2xl font-bold text-slate-950 mt-1">{{ $conversionRate }}%</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Platform Rating Card -->
        <div class="bg-white overflow-hidden rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-amber-50 rounded-xl text-amber-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.837-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-semibold text-slate-500 truncate">Platform Rating</dt>
                            <dd class="text-2xl font-bold text-slate-950 mt-1">{{ $averagePlatformRating }} / 5</dd>
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
                    <h3 class="text-lg font-bold text-slate-900">Recent Property Submissions</h3>
                    <a href="{{ route('admin.properties.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">View all</a>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse($recentListings as $listing)
                        <div class="p-6 flex items-center justify-between hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 font-extrabold text-sm shrink-0">
                                    {{ $listing->bhk }} BHK
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800 text-sm hover:text-indigo-600 transition-colors">
                                        <a href="{{ route('admin.properties.show', $listing) }}">{{ $listing->title }}</a>
                                    </h4>
                                    <p class="text-xs text-slate-400 mt-1">
                                        Rent: ₹{{ number_format($listing->rent) }}/mo • By: {{ $listing->creator->name }} • {{ $listing->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            <div>
                                @if($listing->verification_status === 'verified' && $listing->publication_status === 'published')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">Verified & Live</span>
                                @elseif($listing->verification_status === 'verified')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-800 border border-indigo-200">Verified (Draft)</span>
                                @elseif($listing->verification_status === 'rejected')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-800 border border-rose-200">Rejected</span>
                                @elseif($listing->publication_status === 'archived')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-50 text-slate-800 border border-slate-200">Archived/Rented</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-800 border border-amber-200">Pending Verification</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-slate-400 text-sm">
                            No properties submitted yet.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Visit Bookings Card -->
            <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-slate-900">Recent Visit Bookings</h3>
                    <a href="{{ route('admin.visits.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">View all</a>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse($recentVisits as $visit)
                        <div class="p-6 flex items-center justify-between hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-700 flex items-center justify-center font-bold text-xs uppercase">
                                    {{ substr($visit->customer->name, 0, 2) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800 text-sm">{{ $visit->customer->name }}</h4>
                                    <p class="text-xs text-slate-400 mt-1">
                                        Property: <span class="font-semibold text-slate-600">{{ $visit->property ? $visit->property->title : 'General Consultation' }}</span> • {{ $visit->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                @if($visit->agent)
                                    <span class="text-xs text-slate-400 font-medium">Agent: <span class="font-bold text-slate-700">{{ $visit->agent->name }}</span></span>
                                @else
                                    <span class="text-xs text-rose-500 font-semibold bg-rose-50 px-2 py-0.5 rounded border border-rose-100">Unassigned</span>
                                @endif
                                
                                @if($visit->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-800 border border-amber-200">Pending</span>
                                @elseif($visit->status === 'assigned')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-800 border border-indigo-200">Assigned</span>
                                @elseif($visit->status === 'scheduled')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-teal-50 text-teal-800 border border-teal-200">Scheduled</span>
                                @elseif($visit->status === 'completed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">Completed</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-800 border border-rose-200">Cancelled</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-slate-400 text-sm">
                            No visit bookings requested yet.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right: Actions & Performance -->
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
                    <a href="{{ route('admin.settings.index') }}" class="w-full flex items-center justify-between p-4 bg-slate-50 hover:bg-slate-100/80 rounded-xl text-slate-900 font-bold transition-all group">
                        <span>Platform Settings</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Agent Performance List -->
            <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm p-6">
                <h3 class="text-lg font-bold text-slate-900 mb-4">Office Agents Performance</h3>
                <div class="space-y-4">
                    @forelse($agents as $agent)
                        <div class="flex items-center justify-between hover:bg-slate-50/50 p-2 rounded-xl transition-all">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-800 text-white flex items-center justify-center text-xs font-bold uppercase shrink-0">
                                    {{ substr($agent->name, 0, 2) }}
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-800 leading-snug flex items-center gap-1.5">
                                        {{ $agent->name }}
                                        @if($agent->average_rating > 0)
                                            <span class="inline-flex items-center gap-0.5 text-[9px] font-bold text-amber-600 bg-amber-50 px-1 rounded border border-amber-100">
                                                ★ {{ $agent->average_rating }}
                                            </span>
                                        @endif
                                    </h4>
                                    <p class="text-[10px] text-slate-400 font-semibold mt-0.5">
                                        {{ $agent->closed_deals }} / {{ $agent->total_leads }} Deals ({{ $agent->conversion_rate }}%)
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-xs font-bold text-indigo-600 block">₹{{ number_format($agent->revenue_generated) }}</span>
                                <span class="text-[9px] text-slate-400 uppercase tracking-wide font-bold">Revenue</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 text-center py-4">No agents registered.</p>
                    @endforelse
                </div>
            </div>

            <!-- Locality Performance List -->
            <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm p-6">
                <h3 class="text-lg font-bold text-slate-900 mb-4">Locality Activity</h3>
                <div class="space-y-3.5">
                    @forelse($localities as $locality)
                        <div class="flex items-center justify-between text-xs">
                            <div class="font-bold text-slate-700">{{ $locality->name }}</div>
                            <div class="flex items-center gap-2">
                                <span class="text-slate-400 font-semibold">{{ $locality->properties_count }} listings</span>
                                <span class="bg-indigo-50 text-indigo-600 font-bold px-2 py-0.5 rounded-full">{{ $locality->deals_count }} rented</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 text-center py-4">No locality statistics available.</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>
