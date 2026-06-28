<x-admin-layout>
    <x-slot name="title">Close Deal - OkhlaFlat</x-slot>

    <!-- Back Navigation -->
    <div class="mb-6">
        <a href="{{ route('agent.visits.index') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-slate-500 hover:text-slate-900 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Assigned Visits
        </a>
    </div>

    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
            Close Property Rent Deal
        </h1>
        <p class="mt-2 text-sm text-slate-500">
            Confirm rent details and upload tenant documentation to finalize this rental deal. This will mark the visit as completed and archive the property listing.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Close Deal Form Card -->
        <div class="lg:col-span-2 bg-white border border-slate-200/80 rounded-2xl shadow-sm overflow-hidden">
            <div class="p-8">
                <form action="{{ route('agent.deals.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <input type="hidden" name="visit_request_id" value="{{ $visit->id }}">

                    <!-- Property Section -->
                    @if($visit->property_id)
                        <input type="hidden" name="property_id" value="{{ $visit->property_id }}">
                        <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-between">
                            <div>
                                <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider">Property Being Rented</span>
                                <h4 class="font-bold text-slate-900 mt-0.5">{{ $visit->property->title }}</h4>
                                <p class="text-xs text-slate-500 mt-1">Code: {{ $visit->property->property_code }} • {{ $visit->property->locality->name }}</p>
                            </div>
                            <div class="text-right">
                                <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider">Listed Rent</span>
                                <span class="text-lg font-black text-slate-950 block mt-0.5">₹{{ number_format($visit->property->rent) }}<span class="text-xs font-normal text-slate-500">/mo</span></span>
                            </div>
                        </div>
                    @else
                        <!-- Property Selection (General Consultation fallback) -->
                        <div>
                            <label for="property_id" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Select Rented Property</label>
                            <select name="property_id" id="property_id" required class="block w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 text-sm py-2.5">
                                <option value="">-- Choose Verified Property --</option>
                                @foreach($properties as $property)
                                    <option value="{{ $property->id }}" {{ old('property_id') == $property->id ? 'selected' : '' }}>
                                        {{ $property->title }} ({{ $property->property_code }}) - ₹{{ number_format($property->rent) }}/mo
                                    </option>
                                @endforeach
                            </select>
                            @error('property_id')
                                <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    <!-- Rent Details -->
                    <div>
                        <label for="rent_amount" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Agreed Monthly Rent (INR)</label>
                        <div class="relative rounded-xl shadow-sm max-w-xs">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 font-bold text-sm">
                                ₹
                            </div>
                            <input type="number" name="rent_amount" id="rent_amount" value="{{ old('rent_amount', $visit->property ? $visit->property->rent : '') }}" required class="block w-full pl-8 rounded-xl border-slate-200 focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 text-sm py-2.5" placeholder="e.g. 15000">
                        </div>
                        <p class="mt-1 text-xs text-slate-400">OkhlaFlat will calculate 25% of this amount as the platform service fee.</p>
                        @error('rent_amount')
                            <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <hr class="border-slate-100">

                    <!-- Document Uploads -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- ID Proof -->
                        <div>
                            <label for="id_proof" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tenant ID Proof (PDF/Image)</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-2xl hover:border-indigo-500 transition-colors cursor-pointer group relative">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-10 w-10 text-slate-400 group-hover:text-indigo-500 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-xs text-slate-600 justify-center">
                                        <span class="relative font-bold text-indigo-600 hover:text-indigo-700">Upload a file</span>
                                    </div>
                                    <p class="text-[10px] text-slate-400">PDF, PNG, JPG up to 10MB</p>
                                    <span id="id_proof_filename" class="text-xs text-indigo-600 font-bold block truncate max-w-[200px] mt-2"></span>
                                </div>
                                <input type="file" name="id_proof" id="id_proof" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="document.getElementById('id_proof_filename').innerText = this.files[0] ? this.files[0].name : '';">
                            </div>
                            @error('id_proof')
                                <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Rent Agreement -->
                        <div>
                            <label for="agreement_doc" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Signed Rent Agreement (PDF/Image)</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-2xl hover:border-indigo-500 transition-colors cursor-pointer group relative">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-10 w-10 text-slate-400 group-hover:text-indigo-500 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-xs text-slate-600 justify-center">
                                        <span class="relative font-bold text-indigo-600 hover:text-indigo-700">Upload a file</span>
                                    </div>
                                    <p class="text-[10px] text-slate-400">PDF, PNG, JPG up to 10MB</p>
                                    <span id="agreement_doc_filename" class="text-xs text-indigo-600 font-bold block truncate max-w-[200px] mt-2"></span>
                                </div>
                                <input type="file" name="agreement_doc" id="agreement_doc" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="document.getElementById('agreement_doc_filename').innerText = this.files[0] ? this.files[0].name : '';">
                            </div>
                            @error('agreement_doc')
                                <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="pt-4 flex items-center justify-end gap-3">
                        <a href="{{ route('agent.visits.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-5 py-2.5 border border-transparent text-sm font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 transition-all shadow-md shadow-indigo-100 hover:shadow-lg">
                            Close Deal & Generate Invoice
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Customer Summary Side Card -->
        <div class="space-y-6">
            <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm p-6">
                <h3 class="text-lg font-bold text-slate-900 mb-4">Customer Details</h3>
                <div class="space-y-4">
                    <div>
                        <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider">Tenant Name</span>
                        <span class="text-sm font-bold text-slate-800 mt-1 block">{{ $visit->customer->name }}</span>
                    </div>
                    <div>
                        <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider">Mobile Number</span>
                        <span class="text-sm font-semibold text-slate-800 mt-1 block">{{ $visit->customer->mobile }}</span>
                    </div>
                    <div>
                        <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider">Email Address</span>
                        <span class="text-sm text-slate-500 mt-1 block break-all">{{ $visit->customer->email }}</span>
                    </div>
                    @if($visit->customer_notes)
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">Visit Request Notes</span>
                            <span class="text-xs text-slate-600 italic">"{{ $visit->customer_notes }}"</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
