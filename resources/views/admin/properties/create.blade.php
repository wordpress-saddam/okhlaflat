<x-admin-layout>
    <x-slot name="title">Add Flat Listing</x-slot>

    <!-- Header Section -->
    <div class="md:flex md:items-center md:justify-between mb-8">
        <div class="flex-1 min-w-0">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                Add New Flat Listing
            </h1>
            <p class="mt-2 text-sm text-slate-500">
                Register a new flat listing in the database. Ensure sensitive details are captured accurately.
            </p>
        </div>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl">
            <div class="text-sm font-semibold mb-2">Please correct the errors below:</div>
            <ul class="list-disc list-inside text-xs space-y-1 text-rose-700">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.properties.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <!-- Section 1: Public Information -->
        <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm p-6 lg:p-8 space-y-6">
            <h3 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-3">Public Listing Details</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Title -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Listing Title</label>
                    <input type="text" name="title" id="title" required value="{{ old('title') }}" placeholder="e.g. Spacious 2 BHK Flat with Balcony near Jamia Metro" class="block w-full rounded-xl border-slate-200/85 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3">
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Description</label>
                    <textarea name="description" id="description" rows="4" placeholder="Highlight key features, spacing, layout..." class="block w-full rounded-xl border-slate-200/85 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3">{{ old('description') }}</textarea>
                </div>

                <!-- Rent -->
                <div>
                    <label for="rent" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Monthly Rent (INR)</label>
                    <input type="number" name="rent" id="rent" required value="{{ old('rent') }}" placeholder="e.g. 15000" class="block w-full rounded-xl border-slate-200/85 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3">
                </div>

                <!-- Deposit -->
                <div>
                    <label for="deposit" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Security Deposit (INR)</label>
                    <input type="number" name="deposit" id="deposit" required value="{{ old('deposit') }}" placeholder="e.g. 30000" class="block w-full rounded-xl border-slate-200/85 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3">
                </div>

                <!-- Property Type -->
                <div>
                    <label for="property_type" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Property Type</label>
                    <select name="property_type" id="property_type" required class="block w-full rounded-xl border-slate-200/85 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3">
                        <option value="flat" {{ old('property_type') === 'flat' ? 'selected' : '' }}>Flat / Apartment</option>
                        <option value="pg" {{ old('property_type') === 'pg' ? 'selected' : '' }}>PG / Hostel Room</option>
                        <option value="room" {{ old('property_type') === 'room' ? 'selected' : '' }}>Single Room</option>
                        <option value="house" {{ old('property_type') === 'house' ? 'selected' : '' }}>Independent House</option>
                        <option value="studio" {{ old('property_type') === 'studio' ? 'selected' : '' }}>Studio Apartment</option>
                    </select>
                </div>

                <!-- BHK -->
                <div>
                    <label for="bhk" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">BHK Size</label>
                    <input type="number" name="bhk" id="bhk" required value="{{ old('bhk', 1) }}" min="1" max="10" class="block w-full rounded-xl border-slate-200/85 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3">
                </div>

                <!-- Area -->
                <div>
                    <label for="area" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Super Area (Sq Ft)</label>
                    <input type="number" name="area" id="area" required value="{{ old('area') }}" placeholder="e.g. 950" class="block w-full rounded-xl border-slate-200/85 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3">
                </div>

                <!-- Floor -->
                <div>
                    <label for="floor" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Floor</label>
                    <input type="text" name="floor" id="floor" required value="{{ old('floor') }}" placeholder="e.g. 2nd Floor, G-1, Ground" class="block w-full rounded-xl border-slate-200/85 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3">
                </div>

                <!-- Furnishing -->
                <div>
                    <label for="furnishing" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Furnishing Status</label>
                    <select name="furnishing" id="furnishing" required class="block w-full rounded-xl border-slate-200/85 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3">
                        <option value="unfurnished" {{ old('furnishing') === 'unfurnished' ? 'selected' : '' }}>Unfurnished</option>
                        <option value="semi-furnished" {{ old('furnishing') === 'semi-furnished' ? 'selected' : '' }}>Semi-Furnished</option>
                        <option value="furnished" {{ old('furnishing') === 'furnished' ? 'selected' : '' }}>Fully Furnished</option>
                    </select>
                </div>

                <!-- Availability -->
                <div>
                    <label for="availability" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Availability</label>
                    <select name="availability" id="availability" required class="block w-full rounded-xl border-slate-200/85 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3">
                        <option value="immediate" {{ old('availability') === 'immediate' ? 'selected' : '' }}>Immediate / Ready to Move</option>
                        <option value="specific_date" {{ old('availability') === 'specific_date' ? 'selected' : '' }}>Specific Date</option>
                    </select>
                </div>

                <!-- Locality -->
                <div>
                    <label for="locality_id" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Locality / Sector</label>
                    <select name="locality_id" id="locality_id" required class="block w-full rounded-xl border-slate-200/85 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3">
                        @foreach($localities as $locality)
                            <option value="{{ $locality->id }}" {{ old('locality_id') == $locality->id ? 'selected' : '' }}>{{ $locality->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Approximate Location -->
                <div>
                    <label for="approximate_location" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Approximate Public Location</label>
                    <input type="text" name="approximate_location" id="approximate_location" required value="{{ old('approximate_location') }}" placeholder="e.g. Near Batla House Metro, Jamia Nagar" class="block w-full rounded-xl border-slate-200/85 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3">
                </div>

                <!-- Nearest Metro -->
                <div>
                    <label for="nearest_metro" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Nearest Metro Station</label>
                    <input type="text" name="nearest_metro" id="nearest_metro" value="{{ old('nearest_metro') }}" placeholder="e.g. Okhla Vihar" class="block w-full rounded-xl border-slate-200/85 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3">
                </div>

                <!-- Landmark -->
                <div>
                    <label for="landmark" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Landmark</label>
                    <input type="text" name="landmark" id="landmark" value="{{ old('landmark') }}" placeholder="e.g. Behind Khalilullah Mosque" class="block w-full rounded-xl border-slate-200/85 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3">
                </div>
            </div>
        </div>

        <!-- Section 2: Amenities (Public) -->
        <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm p-6 lg:p-8 space-y-6">
            <h3 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-3">Flat Amenities</h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($amenities as $amenity)
                    <div class="flex items-center">
                        <input id="amenity_{{ $amenity->id }}" name="amenities[]" type="checkbox" value="{{ $amenity->id }}" class="h-4.5 w-4.5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" {{ is_array(old('amenities')) && in_array($amenity->id, old('amenities')) ? 'checked' : '' }}>
                        <label for="amenity_{{ $amenity->id }}" class="ml-2.5 text-sm font-semibold text-slate-700 capitalize">{{ $amenity->name }}</label>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Section 3: Private / Owner Information (HIDDEN FROM FRONTEND) -->
        <div class="bg-indigo-950 text-white rounded-2xl shadow-md p-6 lg:p-8 space-y-6 border border-indigo-900">
            <div>
                <h3 class="text-lg font-bold text-white border-b border-indigo-900 pb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Private Property Details (Office-only View)
                </h3>
                <p class="text-xs text-indigo-300 mt-1">This information will never be shown to public or customer roles online. It is restricted to Agents and Administrators.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Owner Name -->
                <div>
                    <label for="owner_name" class="block text-xs font-semibold text-indigo-200 uppercase tracking-wider mb-2">Owner Full Name</label>
                    <input type="text" name="owner_name" id="owner_name" required value="{{ old('owner_name') }}" placeholder="e.g. Mohammad Asif" class="block w-full rounded-xl bg-indigo-900/40 border-indigo-800 text-white placeholder-indigo-400 focus:border-indigo-400 focus:ring-indigo-400 text-sm py-3">
                </div>

                <!-- Owner Contact -->
                <div>
                    <label for="owner_contact" class="block text-xs font-semibold text-indigo-200 uppercase tracking-wider mb-2">Owner Contact Phone</label>
                    <input type="text" name="owner_contact" id="owner_contact" required value="{{ old('owner_contact') }}" placeholder="e.g. +91 99999 88888" class="block w-full rounded-xl bg-indigo-900/40 border-indigo-800 text-white placeholder-indigo-400 focus:border-indigo-400 focus:ring-indigo-400 text-sm py-3">
                </div>

                <!-- Building Number -->
                <div>
                    <label for="building_number" class="block text-xs font-semibold text-indigo-200 uppercase tracking-wider mb-2">Building / Flat Number</label>
                    <input type="text" name="building_number" id="building_number" required value="{{ old('building_number') }}" placeholder="e.g. House No. 42B, Flat No. 3" class="block w-full rounded-xl bg-indigo-900/40 border-indigo-800 text-white placeholder-indigo-400 focus:border-indigo-400 focus:ring-indigo-400 text-sm py-3">
                </div>

                <!-- Exact Address -->
                <div class="md:col-span-2">
                    <label for="exact_address" class="block text-xs font-semibold text-indigo-200 uppercase tracking-wider mb-2">Exact Street Address</label>
                    <textarea name="exact_address" id="exact_address" rows="3" required placeholder="e.g. Lane No. 4, Johri Farm, Jamia Nagar, New Delhi - 110025" class="block w-full rounded-xl bg-indigo-900/40 border-indigo-800 text-white placeholder-indigo-400 focus:border-indigo-400 focus:ring-indigo-400 text-sm py-3">{{ old('exact_address') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Section 4: Media & Operational Assignments -->
        <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm p-6 lg:p-8 space-y-6">
            <h3 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-3">Operational Details & Media</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Media Upload -->
                <div>
                    <label for="images" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Upload Flat Photos (Multiple)</label>
                    <input type="file" name="images[]" id="images" multiple class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-colors">
                </div>

                <!-- Assigned Agent -->
                <div>
                    <label for="assigned_agent_id" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Assigned Agent</label>
                    <select name="assigned_agent_id" id="assigned_agent_id" class="block w-full rounded-xl border-slate-200/85 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3">
                        <option value="">Select Agent to Handle Visits</option>
                        @foreach($agents as $agent)
                            <option value="{{ $agent->id }}" {{ old('assigned_agent_id') == $agent->id ? 'selected' : '' }}>{{ $agent->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Settings (Admin-only) -->
                @if(auth()->user()->hasRole('admin'))
                    <div>
                        <label for="verification_status" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Verification Status</label>
                        <select name="verification_status" id="verification_status" class="block w-full rounded-xl border-slate-200/85 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3">
                            <option value="pending" {{ old('verification_status') === 'pending' ? 'selected' : '' }}>Pending Approval</option>
                            <option value="verified" {{ old('verification_status') === 'verified' ? 'selected' : '' }}>Verified (Safe for Public Listing)</option>
                            <option value="rejected" {{ old('verification_status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>

                    <div>
                        <label for="publication_status" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Publication Visibility</label>
                        <select name="publication_status" id="publication_status" class="block w-full rounded-xl border-slate-200/85 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3">
                            <option value="draft" {{ old('publication_status') === 'draft' ? 'selected' : '' }}>Draft (Offline)</option>
                            <option value="published" {{ old('publication_status') === 'published' ? 'selected' : '' }}>Published (Live on Site)</option>
                            <option value="archived" {{ old('publication_status') === 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                    </div>
                @endif
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end gap-4">
            <a href="{{ route('admin.properties.index') }}" class="px-6 py-3.5 text-sm font-semibold bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors text-slate-700">
                Cancel
            </a>
            <button type="submit" class="inline-flex items-center justify-center px-8 py-3.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition-all shadow-md shadow-indigo-100 hover:shadow-lg hover:-translate-y-0.5 duration-200">
                Save Property
            </button>
        </div>
    </form>
</x-admin-layout>
