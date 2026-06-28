<x-public-layout>
    <x-slot name="title">{{ $property->title }}</x-slot>

    <!-- Details Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Breadcrumb / Header -->
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('properties.index') }}" class="text-xs font-semibold text-slate-500 hover:text-indigo-600 transition-colors">Search Flats</a>
                    <span class="text-slate-300 text-xs">/</span>
                    <span class="text-xs font-semibold text-indigo-600 uppercase">{{ $property->property_code }}</span>
                </div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-slate-950 mt-3 tracking-tight">
                    {{ $property->title }}
                </h1>
                @if($property->reviews->count() > 0)
                    <div class="flex items-center gap-2 mt-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 border border-amber-200 text-xs font-bold text-amber-800 rounded-lg shadow-sm">
                            <svg class="w-3.5 h-3.5 fill-current text-amber-500" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            {{ number_format($property->averageRating(), 1) }} ({{ $property->reviews->count() }} {{ $property->reviews->count() === 1 ? 'review' : 'reviews' }})
                        </span>
                    </div>
                @endif
            </div>
            
            <div class="flex flex-col items-end">
                <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">Monthly Rent</span>
                <span class="text-3xl font-black text-indigo-600 mt-1">₹{{ number_format($property->rent) }}<span class="text-xs font-normal text-slate-400">/mo</span></span>
            </div>
        </div>

        <!-- Layout Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left: Photos, Specs, Description (Span 2) -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Photo Gallery -->
                <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Flat Gallery</h3>
                    @if($property->images->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($property->images as $img)
                                <div class="rounded-xl overflow-hidden aspect-video bg-slate-50 border border-slate-100 shadow-sm">
                                    <img src="{{ asset('storage/' . $img->file_path) }}" alt="Flat Interior" class="object-cover w-full h-full hover:scale-102 transition-transform duration-300">
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="py-16 text-center text-slate-400 bg-slate-50 rounded-xl border border-slate-200 border-dashed">
                            <svg class="mx-auto h-12 w-12 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-sm font-semibold">Images pending upload by agent.</p>
                        </div>
                    @endif
                </div>

                <!-- Flat Specifications -->
                <div class="bg-white border border-slate-200/80 rounded-2xl p-6 lg:p-8 shadow-sm space-y-6">
                    <h3 class="text-lg font-bold text-slate-950 border-b border-slate-100 pb-3">Flat Specifications</h3>
                    
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-6 text-sm font-medium text-slate-800">
                        <div>
                            <span class="block text-slate-400 font-bold text-xs uppercase tracking-wider mb-1">Locality</span>
                            <span class="text-slate-900 font-bold">{{ $property->locality->name }}</span>
                        </div>

                        <div>
                            <span class="block text-slate-400 font-bold text-xs uppercase tracking-wider mb-1">BHK size</span>
                            <span class="text-slate-900 font-bold">{{ $property->bhk }} BHK</span>
                        </div>

                        <div>
                            <span class="block text-slate-400 font-bold text-xs uppercase tracking-wider mb-1">Super Area</span>
                            <span class="text-slate-900 font-bold">{{ $property->area }} Sq Ft</span>
                        </div>

                        <div>
                            <span class="block text-slate-400 font-bold text-xs uppercase tracking-wider mb-1">Deposit</span>
                            <span class="text-slate-900 font-bold">₹{{ number_format($property->deposit) }}</span>
                        </div>

                        <div>
                            <span class="block text-slate-400 font-bold text-xs uppercase tracking-wider mb-1">Furnishing</span>
                            <span class="text-slate-900 font-bold capitalize">{{ $property->furnishing }}</span>
                        </div>

                        <div>
                            <span class="block text-slate-400 font-bold text-xs uppercase tracking-wider mb-1">Floor</span>
                            <span class="text-slate-900 font-bold">{{ $property->floor }}</span>
                        </div>

                        <div>
                            <span class="block text-slate-400 font-bold text-xs uppercase tracking-wider mb-1">Availability</span>
                            <span class="text-slate-900 font-bold capitalize">{{ $property->availability }}</span>
                        </div>

                        <div>
                            <span class="block text-slate-400 font-bold text-xs uppercase tracking-wider mb-1">Nearest Metro</span>
                            <span class="text-slate-900 font-bold">{{ $property->nearest_metro ?? 'N/A' }}</span>
                        </div>

                        <div>
                            <span class="block text-slate-400 font-bold text-xs uppercase tracking-wider mb-1">Landmark</span>
                            <span class="text-slate-900 font-bold">{{ $property->landmark ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <div class="border-t border-slate-100 pt-6">
                        <span class="block text-slate-400 font-bold text-xs uppercase tracking-wider mb-2">Description</span>
                        <p class="text-slate-600 leading-relaxed whitespace-pre-line">{{ $property->description }}</p>
                    </div>
                </div>

                <!-- Amenities -->
                <div class="bg-white border border-slate-200/80 rounded-2xl p-6 lg:p-8 shadow-sm space-y-4">
                    <h3 class="text-lg font-bold text-slate-950 border-b border-slate-100 pb-3">Flat Amenities</h3>
                    <div class="flex flex-wrap gap-2.5">
                        @forelse($property->amenities as $amenity)
                            <span class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-slate-50 text-slate-800 text-xs font-bold border border-slate-200/80">
                                {{ $amenity->name }}
                            </span>
                        @empty
                            <span class="text-sm text-slate-400 font-semibold">No amenities listed.</span>
                        @endforelse
                    </div>
                </div>

                <!-- Reviews & Ratings -->
                <div class="bg-white border border-slate-200/80 rounded-2xl p-6 lg:p-8 shadow-sm space-y-6">
                    <h3 class="text-lg font-bold text-slate-950 border-b border-slate-100 pb-3">Reviews & Ratings</h3>
                    
                    @if($property->reviews->isEmpty())
                        <div class="py-8 text-center text-slate-400">
                            <svg class="mx-auto h-10 w-10 text-slate-300 mb-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.837-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                            <p class="text-xs font-semibold">No reviews submitted for this flat yet.</p>
                            <p class="text-[10px] text-slate-400 mt-0.5">Book an office visit and share your experience after completion!</p>
                        </div>
                    @else
                        <!-- Overall summary and stats -->
                        <div class="flex items-center gap-6 p-5 bg-slate-50 border border-slate-100 rounded-xl mb-6">
                            <div class="text-center">
                                <span class="text-3xl font-extrabold text-slate-900 block leading-tight">{{ number_format($property->averageRating(), 1) }}</span>
                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wide">Out of 5 Stars</span>
                            </div>
                            <div class="h-10 w-px bg-slate-200"></div>
                            <div>
                                <p class="text-xs font-bold text-slate-700">Verified User Feedback</p>
                                <p class="text-[10px] text-slate-400 mt-0.5">{{ $property->reviews->count() }} {{ $property->reviews->count() === 1 ? 'rating' : 'ratings' }} submitted by visited customers.</p>
                            </div>
                        </div>

                        <!-- Review list -->
                        <div class="divide-y divide-slate-100 space-y-5">
                            @foreach($property->reviews as $review)
                                <div class="pt-5 @if($loop->first) pt-0 @endif">
                                    <div class="flex items-center justify-between gap-4">
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs font-extrabold text-slate-800">
                                                {{ substr($review->customer->name, 0, 1) }}***{{ substr($review->customer->name, -1) }}
                                            </span>
                                            
                                            @if($property->deals()->where('customer_id', $review->customer_id)->exists())
                                                <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 bg-emerald-50 border border-emerald-200 text-[9px] font-bold text-emerald-800 rounded">
                                                    Verified Tenant
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 bg-indigo-50 border border-indigo-200 text-[9px] font-bold text-indigo-800 rounded">
                                                    Verified Visitor
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <div class="flex items-center gap-0.5">
                                            @foreach(range(1, 5) as $star)
                                                <svg class="w-3.5 h-3.5 @if($star <= $review->property_rating) text-amber-400 @else text-slate-200 @endif fill-current" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @endforeach
                                        </div>
                                    </div>

                                    @if($review->comment)
                                        <p class="text-xs text-slate-600 mt-2.5 leading-relaxed bg-slate-50/50 p-3 rounded-xl border border-slate-100">
                                            "{{ $review->comment }}"
                                        </p>
                                    @endif

                                    <div class="text-[10px] text-slate-400 mt-2 font-medium">
                                        Reviewed {{ $review->created_at->format('M d, Y') }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right: Office Visit CTA (Privacy Protection) -->
            <div>
                <div class="bg-slate-900 text-white rounded-2xl shadow-lg p-6 lg:p-8 space-y-6 sticky top-24 border border-slate-800">
                    <div class="border-b border-slate-800 pb-4">
                        <span class="text-xs font-bold text-indigo-400 uppercase tracking-widest leading-none">Security Protocol</span>
                        <h3 class="text-xl font-extrabold text-white mt-1.5 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Address Privacy Enabled
                        </h3>
                    </div>

                    <p class="text-xs text-slate-400 leading-relaxed">
                        To maintain secure property owner records and prevent direct client-owner brokering, the exact street address, flat number, and owner details are strictly hidden online.
                    </p>

                    <div class="p-4 bg-slate-800/80 rounded-xl space-y-3 border border-slate-800">
                        <h4 class="text-sm font-bold text-white">How it works:</h4>
                        <ol class="list-decimal list-inside text-xs space-y-2 text-slate-300">
                            <li>Book a physical visit to our Jamia Nagar office.</li>
                            <li>An assigned agent reviews your requirements.</li>
                            <li>We take you on physical visits to this flat and multiple other matching options.</li>
                        </ol>
                    </div>

                    <div class="p-4 bg-indigo-950/80 rounded-xl border border-indigo-900/60 text-center">
                        <span class="text-[10px] text-indigo-300 font-extrabold uppercase tracking-wider block">Flat Brokerage Service Fee</span>
                        <span class="text-xl font-black text-indigo-400 mt-1 block">Only 25% of 1 Month's Rent</span>
                        <span class="text-[10px] text-indigo-300 mt-1 block leading-tight">Pay only a fraction instead of a full month's rent!</span>
                    </div>

                    @auth
                        @php
                            $hasRequested = auth()->user()->visitRequests()->where('property_id', $property->id)->first();
                        @endphp

                        @if($hasRequested)
                            <div class="p-4 bg-indigo-950/80 rounded-xl border border-indigo-900/60 text-center">
                                <span class="text-xs text-indigo-400 font-bold block">Visit Already Requested</span>
                                <span class="text-[10px] text-slate-400 mt-1 block">Status: <span class="uppercase font-extrabold text-white">{{ $hasRequested->status }}</span></span>
                                <a href="{{ route('customer.dashboard') }}" class="text-xs text-indigo-300 hover:text-white mt-2 block underline">View Dashboard</a>
                            </div>
                        @else
                            <form action="{{ route('customer.visits.store') }}" method="POST" class="space-y-4">
                                @csrf
                                <input type="hidden" name="property_id" value="{{ $property->id }}">
                                
                                <div>
                                    <label for="customer_notes" class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Optional Notes</label>
                                    <textarea name="customer_notes" id="customer_notes" rows="2" 
                                              class="block w-full rounded-lg bg-slate-800 border-slate-700 text-xs font-semibold text-white focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 py-2 px-3 transition-all"
                                              placeholder="E.g., preferred time, BHK needs..."></textarea>
                                </div>

                                <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-3.5 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition-all shadow-md shadow-indigo-900/40 hover:shadow-lg hover:-translate-y-0.5 duration-200">
                                    Request Office Visit
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="w-full inline-flex items-center justify-center px-4 py-4 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition-all shadow-md shadow-indigo-900/40 hover:shadow-lg hover:-translate-y-0.5 duration-200">
                            Log In to Book Visit
                        </a>
                    @endauth
                </div>
            </div>

        </div>
    </section>
</x-public-layout>
