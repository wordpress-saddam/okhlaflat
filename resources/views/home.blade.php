<x-public-layout>
    <x-slot name="title">Home - Jamia Nagar Rental Flats</x-slot>

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-tr from-slate-900 via-indigo-950 to-slate-900 text-white py-24 md:py-32 overflow-hidden">
        <!-- Abstract glowing backgrounds -->
        <div class="absolute top-0 right-0 -mt-24 -mr-24 w-96 h-96 bg-indigo-500 rounded-full blur-3xl opacity-20 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 -mb-24 -ml-24 w-96 h-96 bg-violet-500 rounded-full blur-3xl opacity-20 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight">
                Discover Verified Rental Flats in <span class="bg-gradient-to-r from-indigo-400 to-violet-400 bg-clip-text text-transparent">Jamia Nagar</span>
            </h1>
            <p class="mt-6 text-lg sm:text-xl text-slate-300 max-w-3xl mx-auto leading-relaxed">
                Find flats online, book a physical office visit, and let our agents handle the search and documentation. Save thousands with our flat {{ $globalBrokerageFee }}% service fee.
            </p>

            <!-- Search Form Bar -->
            <div class="mt-12 max-w-4xl mx-auto bg-white/10 backdrop-blur-md p-4 rounded-2xl sm:rounded-3xl border border-white/10 shadow-2xl">
                <form action="{{ route('properties.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-left">
                    <!-- Locality select -->
                    <div class="bg-white/5 p-3 rounded-xl border border-white/5">
                        <label for="locality_id" class="block text-[10px] font-bold text-indigo-300 uppercase tracking-widest mb-1">Locality</label>
                        <select name="locality_id" id="locality_id" class="block w-full bg-transparent border-0 p-0 text-white focus:ring-0 text-sm focus:outline-none">
                            <option value="" class="bg-slate-900">All Localities</option>
                            <option value="1" class="bg-slate-900">Batla House</option>
                            <option value="2" class="bg-slate-900">Zakir Nagar</option>
                            <option value="3" class="bg-slate-900">Abul Fazal Enclave</option>
                            <option value="4" class="bg-slate-900">Shaheen Bagh</option>
                        </select>
                    </div>

                    <!-- BHK select -->
                    <div class="bg-white/5 p-3 rounded-xl border border-white/5">
                        <label for="bhk" class="block text-[10px] font-bold text-indigo-300 uppercase tracking-widest mb-1">BHK Size</label>
                        <select name="bhk" id="bhk" class="block w-full bg-transparent border-0 p-0 text-white focus:ring-0 text-sm focus:outline-none">
                            <option value="" class="bg-slate-900">Any Size</option>
                            <option value="1" class="bg-slate-900">1 BHK</option>
                            <option value="2" class="bg-slate-900">2 BHK</option>
                            <option value="3" class="bg-slate-900">3 BHK</option>
                        </select>
                    </div>

                    <!-- Search Button -->
                    <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-4 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition-all shadow-md shadow-indigo-500/25 hover:shadow-lg duration-200">
                        Search Properties
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Value Proposition Section -->
    <section class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-xs font-bold text-indigo-600 uppercase tracking-widest">Our Model</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-950 mt-2 tracking-tight">The Hybrid Real Estate Experience</h2>
                <p class="text-slate-500 mt-4 text-sm sm:text-base leading-relaxed">We merge convenient online discovery with secure offline office assistance to ensure transparency and safety for both renters and owners.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white p-8 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
                    <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-950">1. Online Discovery</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Browse verified flat specifications, amenities, and rent details on our premium portal. Save your favorites.</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white p-8 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
                    <div class="w-12 h-12 bg-violet-50 rounded-xl flex items-center justify-center text-violet-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-950">2. Address Privacy</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Exact street addresses and owner details are kept offline to protect owner privacy. Book an office visit to see the flat.</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white p-8 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
                    <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-950">3. Office-Assisted Closing</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Our agents guide you physically to multiple matching flats, handle the rent agreement, and assist you in moving in.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Brokerage Model Comparison -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Info text -->
                <div class="space-y-6">
                    <span class="text-xs font-bold text-indigo-600 uppercase tracking-widest">Pricing Structure</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-950 tracking-tight">The {{ $globalBrokerageFee }}% Service Fee Model</h2>
                    <p class="text-slate-500 text-sm sm:text-base leading-relaxed">
                        Traditional real estate brokers in Jamia Nagar demand **one full month's rent** as brokerage commission. We think that is unfair.
                    </p>
                    <p class="text-slate-500 text-sm sm:text-base leading-relaxed">
                        At OkhlaFlat, we charge **only {{ $globalBrokerageFee }}% of one month's rent** as a flat service fee for our search, physical tours, documentation, and rental agreements.
                    </p>
                </div>

                <!-- Savings Comparison Card -->
                <div class="bg-indigo-950 rounded-3xl p-8 text-white border border-indigo-900 shadow-xl space-y-6">
                    <h3 class="text-lg font-bold">Calculate Your Savings:</h3>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between border-b border-indigo-900 pb-3">
                            <span class="text-slate-400 text-xs">Assumed Monthly Rent</span>
                            <span class="font-extrabold text-slate-200">₹16,000</span>
                        </div>
                        <div class="flex justify-between border-b border-indigo-900 pb-3">
                            <span class="text-slate-400 text-xs">Traditional Brokerage (1 Month)</span>
                            <span class="font-extrabold text-rose-400">₹16,000</span>
                        </div>
                        <div class="flex justify-between border-b border-indigo-900/50 pb-3">
                            <span class="text-slate-400 text-xs">OkhlaFlat Service Fee ({{ $globalBrokerageFee }}%)</span>
                            <span class="font-extrabold text-emerald-400">₹{{ number_format(16000 * ($globalBrokerageFee / 100)) }}</span>
                        </div>
                    </div>

                    <div class="bg-indigo-900/50 p-4 rounded-2xl text-center border border-indigo-850">
                        <span class="text-xs text-indigo-300 font-semibold block">Total Savings on Renting</span>
                        <span class="text-3xl font-black text-emerald-400 mt-1 block">₹{{ number_format(16000 - (16000 * ($globalBrokerageFee / 100))) }} Saved!</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-public-layout>
