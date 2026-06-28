<x-admin-layout>
    <x-slot name="title">Property Details - {{ $property->property_code }}</x-slot>

    <!-- Header Section -->
    <div class="md:flex md:items-center md:justify-between mb-8 pb-6 border-b border-slate-200">
        <div class="flex-grow min-w-0">
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                    {{ $property->property_code }}
                </span>
                <span class="text-sm font-semibold text-slate-400 capitalize">{{ $property->bhk }} BHK {{ $property->property_type }}</span>
            </div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight sm:truncate mt-3">
                {{ $property->title }}
            </h1>
            <p class="mt-2 text-sm text-slate-500">
                Created on {{ $property->created_at->format('M d, Y') }} • Located in <span class="font-semibold text-slate-700">{{ $property->locality->name }}</span>
            </p>
        </div>
        <div class="mt-4 flex md:ml-4 md:mt-0 gap-3">
            <a href="{{ route('admin.properties.edit', $property) }}" class="inline-flex items-center px-4 py-2.5 border border-slate-200 rounded-xl shadow-sm text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 transition-all duration-200">
                Edit Listing
            </a>
        </div>
    </div>

    <!-- Admin/Agent Actions Box (Verification & Publication) -->
    @if(auth()->user()->hasRole('admin'))
        <div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-6 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h4 class="font-bold text-indigo-900">Verification & Visibility Control</h4>
                <p class="text-xs text-indigo-700/80 mt-1">Review the flat listing details and set verification/publication status for the public frontend.</p>
            </div>
            
            <div class="flex flex-wrap items-center gap-4">
                <!-- Verify Actions Form -->
                <form action="{{ route('admin.properties.verify', $property) }}" method="POST" class="flex gap-2">
                    @csrf
                    <input type="hidden" name="status" value="verified">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl transition-all shadow-sm shadow-emerald-200">
                        Approve & Verify
                    </button>
                </form>

                <form action="{{ route('admin.properties.verify', $property) }}" method="POST" class="flex gap-2">
                    @csrf
                    <input type="hidden" name="status" value="rejected">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold rounded-xl transition-all shadow-sm shadow-rose-200">
                        Reject
                    </button>
                </form>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: Listing Details & Images (Span 2) -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Image Gallery -->
            @if($property->images->count() > 0)
                <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm overflow-hidden p-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Property Media</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($property->images as $img)
                            <div class="relative rounded-xl overflow-hidden aspect-video border border-slate-100 bg-slate-50 shadow-sm">
                                <img src="{{ asset('storage/' . $img->file_path) }}" alt="Property Photo" class="object-cover w-full h-full">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Flat Specifications Card -->
            <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm p-6 lg:p-8 space-y-6">
                <h3 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-3">Flat Specifications</h3>
                
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-6 text-sm">
                    <div>
                        <span class="block text-slate-400 font-semibold text-xs uppercase tracking-wider mb-1">Rent</span>
                        <span class="font-extrabold text-slate-900 text-lg">₹{{ number_format($property->rent) }}<span class="text-xs font-normal text-slate-400">/mo</span></span>
                    </div>

                    <div>
                        <span class="block text-slate-400 font-semibold text-xs uppercase tracking-wider mb-1">Deposit</span>
                        <span class="font-bold text-slate-900 text-lg">₹{{ number_format($property->deposit) }}</span>
                    </div>

                    <div>
                        <span class="block text-slate-400 font-semibold text-xs uppercase tracking-wider mb-1">Locality</span>
                        <span class="font-bold text-slate-900">{{ $property->locality->name }}</span>
                    </div>

                    <div>
                        <span class="block text-slate-400 font-semibold text-xs uppercase tracking-wider mb-1">BHK size</span>
                        <span class="font-bold text-slate-900">{{ $property->bhk }} BHK</span>
                    </div>

                    <div>
                        <span class="block text-slate-400 font-semibold text-xs uppercase tracking-wider mb-1">Super Area</span>
                        <span class="font-bold text-slate-900">{{ $property->area }} Sq Ft</span>
                    </div>

                    <div>
                        <span class="block text-slate-400 font-semibold text-xs uppercase tracking-wider mb-1">Floor</span>
                        <span class="font-bold text-slate-900">{{ $property->floor }}</span>
                    </div>

                    <div>
                        <span class="block text-slate-400 font-semibold text-xs uppercase tracking-wider mb-1">Furnishing</span>
                        <span class="font-bold text-slate-900 capitalize">{{ $property->furnishing }}</span>
                    </div>

                    <div>
                        <span class="block text-slate-400 font-semibold text-xs uppercase tracking-wider mb-1">Availability</span>
                        <span class="font-bold text-slate-900 capitalize">{{ $property->availability }}</span>
                    </div>

                    <div>
                        <span class="block text-slate-400 font-semibold text-xs uppercase tracking-wider mb-1">Nearest Metro</span>
                        <span class="font-bold text-slate-900">{{ $property->nearest_metro ?? 'N/A' }}</span>
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-6">
                    <span class="block text-slate-400 font-semibold text-xs uppercase tracking-wider mb-2">Description</span>
                    <p class="text-slate-600 leading-relaxed whitespace-pre-line">{{ $property->description }}</p>
                </div>
            </div>

            <!-- Amenities -->
            <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm p-6 lg:p-8 space-y-4">
                <h3 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-3">Amenities Included</h3>
                <div class="flex flex-wrap gap-2.5">
                    @forelse($property->amenities as $amenity)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-50 text-slate-800 text-xs font-bold border border-slate-200/80">
                            {{ $amenity->name }}
                        </span>
                    @empty
                        <span class="text-sm text-slate-400 font-semibold">No amenities selected.</span>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right: Private Details & Agent details -->
        <div class="space-y-8">
            <!-- Private Info Box (INTERNAL OFFICE USE ONLY) -->
            <div class="bg-indigo-950 text-white rounded-2xl shadow-sm p-6 space-y-6 border border-indigo-900">
                <div class="border-b border-indigo-900 pb-3">
                    <h3 class="text-base font-bold text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Private Details (Office Only)
                    </h3>
                    <p class="text-[10px] text-indigo-300 mt-1 uppercase tracking-wider font-semibold">Security Level: Admin & Agent</p>
                </div>

                <div class="space-y-4 text-sm font-semibold">
                    <div>
                        <span class="block text-[10px] text-indigo-300 uppercase tracking-wider mb-0.5">Owner Name</span>
                        <span class="text-white text-base font-bold">{{ $property->owner_name }}</span>
                    </div>

                    <div>
                        <span class="block text-[10px] text-indigo-300 uppercase tracking-wider mb-0.5">Owner Phone</span>
                        <span class="text-white text-base font-bold">{{ $property->owner_contact }}</span>
                    </div>

                    <div>
                        <span class="block text-[10px] text-indigo-300 uppercase tracking-wider mb-0.5">Building / Flat Number</span>
                        <span class="text-white text-base font-bold">{{ $property->building_number }}</span>
                    </div>

                    <div>
                        <span class="block text-[10px] text-indigo-300 uppercase tracking-wider mb-0.5">Exact Address</span>
                        <p class="text-indigo-100 font-normal leading-relaxed text-xs">{{ $property->exact_address }}</p>
                    </div>
                </div>
            </div>

            <!-- Agent Assigned Box -->
            <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm p-6">
                <h3 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-3 mb-4">Assigned Agent</h3>
                @if($property->agent)
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-full bg-slate-800 text-white flex items-center justify-center font-bold text-sm uppercase">
                            {{ substr($property->agent->name, 0, 2) }}
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800 text-sm">{{ $property->agent->name }}</h4>
                            <p class="text-xs text-slate-400">{{ $property->agent->email }}</p>
                        </div>
                    </div>
                @else
                    <p class="text-sm text-slate-400 font-semibold">No agent assigned yet.</p>
                @endif
            </div>
        </div>

    </div>
</x-admin-layout>
