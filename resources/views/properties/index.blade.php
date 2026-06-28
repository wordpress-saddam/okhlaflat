<x-public-layout>
    <x-slot name="title">Verified Properties in Jamia Nagar</x-slot>

    <!-- Header Hero Section -->
    <section class="bg-gradient-to-r from-indigo-950 via-slate-900 to-indigo-905 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center md:text-left">
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight">
                Search Rental Flats in Jamia Nagar
            </h1>
            <p class="mt-4 text-lg text-slate-300 max-w-2xl leading-relaxed">
                Browse our curated collection of verified apartments. To protect owner privacy, building numbers and exact addresses are kept offline.
            </p>
        </div>
    </section>

    <!-- Filter & Listings Grid -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <!-- Filters Sidebar -->
            <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm p-6 h-fit sticky top-24">
                <h3 class="text-lg font-bold text-slate-950 mb-6">Search Filters</h3>
                
                <form action="{{ route('properties.index') }}" method="GET" class="space-y-6">
                    <!-- Locality Filter -->
                    <div>
                        <label for="locality_id" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Locality</label>
                        <select name="locality_id" id="locality_id" class="block w-full rounded-xl border-slate-200/85 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5">
                            <option value="">All Localities</option>
                            @foreach($localities as $locality)
                                <option value="{{ $locality->id }}" {{ request('locality_id') == $locality->id ? 'selected' : '' }}>{{ $locality->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- BHK Filter -->
                    <div>
                        <label for="bhk" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">BHK Size</label>
                        <select name="bhk" id="bhk" class="block w-full rounded-xl border-slate-200/85 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5">
                            <option value="">Any Size</option>
                            <option value="1" {{ request('bhk') == '1' ? 'selected' : '' }}>1 BHK</option>
                            <option value="2" {{ request('bhk') == '2' ? 'selected' : '' }}>2 BHK</option>
                            <option value="3" {{ request('bhk') == '3' ? 'selected' : '' }}>3 BHK</option>
                            <option value="4" {{ request('bhk') == '4' ? 'selected' : '' }}>4 BHK</option>
                        </select>
                    </div>

                    <!-- Max Rent Filter -->
                    <div>
                        <label for="max_rent" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Max Rent (INR/mo)</label>
                        <input type="number" name="max_rent" id="max_rent" value="{{ request('max_rent') }}" placeholder="e.g. 20000" class="block w-full rounded-xl border-slate-200/85 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5">
                    </div>

                    <!-- Furnishing Filter -->
                    <div>
                        <label for="furnishing" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Furnishing</label>
                        <select name="furnishing" id="furnishing" class="block w-full rounded-xl border-slate-200/85 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5">
                            <option value="">Any Status</option>
                            <option value="unfurnished" {{ request('furnishing') == 'unfurnished' ? 'selected' : '' }}>Unfurnished</option>
                            <option value="semi-furnished" {{ request('furnishing') == 'semi-furnished' ? 'selected' : '' }}>Semi-Furnished</option>
                            <option value="furnished" {{ request('furnishing') == 'furnished' ? 'selected' : '' }}>Fully Furnished</option>
                        </select>
                    </div>

                    <!-- Buttons -->
                    <div class="space-y-3">
                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-3 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition-all shadow-md shadow-indigo-100 hover:shadow-lg duration-200">
                            Apply Filters
                        </button>
                        <a href="{{ route('properties.index') }}" class="w-full inline-flex items-center justify-center px-4 py-3 text-sm font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all duration-200 text-center">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Listings Grid -->
            <div class="lg:col-span-3 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse($properties as $property)
                        <!-- Property Card -->
                        <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col h-full group">
                            <!-- Image / Thumbnail -->
                            <div class="relative aspect-[4/3] bg-slate-100 overflow-hidden">
                                @if($property->images->count() > 0)
                                    <img src="{{ asset('storage/' . $property->images->first()->file_path) }}" alt="{{ $property->title }}" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center text-slate-400">
                                        <svg class="h-10 w-10 text-slate-300 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                        </svg>
                                        <span class="text-xs font-semibold">Image pending</span>
                                    </div>
                                @endif
                                <div class="absolute top-3 left-3 bg-indigo-600/90 backdrop-blur-md text-white text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider shadow-sm">
                                    {{ $property->property_code }}
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-5 flex-grow flex flex-col">
                                <div class="flex items-center justify-between gap-2 mb-2">
                                    <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded capitalize">{{ $property->bhk }} BHK {{ $property->property_type }}</span>
                                    <span class="text-xs font-semibold text-slate-400 capitalize">{{ $property->furnishing }}</span>
                                </div>

                                <h4 class="font-extrabold text-slate-900 leading-snug group-hover:text-indigo-600 transition-colors">
                                    <a href="{{ route('properties.show', $property) }}">{{ $property->title }}</a>
                                </h4>

                                <p class="text-xs text-slate-500 mt-2 font-medium flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $property->locality->name }}
                                </p>

                                <div class="border-t border-slate-100 pt-4 mt-4 flex items-end justify-between">
                                    <div>
                                        <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider leading-none">Monthly Rent</span>
                                        <span class="text-xl font-black text-slate-950 mt-1 block">₹{{ number_format($property->rent) }}<span class="text-xs font-normal text-slate-400">/mo</span></span>
                                    </div>
                                    <a href="{{ route('properties.show', $property) }}" class="inline-flex items-center justify-center px-4 py-2 text-xs font-bold text-white bg-slate-900 hover:bg-indigo-600 rounded-xl transition-all shadow-sm">
                                        View Flat
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 py-16 text-center text-slate-400 bg-white border border-slate-150 rounded-2xl">
                            <svg class="mx-auto h-12 w-12 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-sm font-semibold">No flats matched your search.</p>
                            <p class="text-xs text-slate-400 mt-1">Try resetting filters or checking other localities.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($properties->hasPages())
                    <div class="pt-6 border-t border-slate-200">
                        {{ $properties->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>

        </div>
    </section>
</x-public-layout>
