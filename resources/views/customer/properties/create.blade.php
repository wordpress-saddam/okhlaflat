<x-public-layout>
    <x-slot name="title">List Your Property - OkhlaFlat</x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <a href="{{ route('customer.dashboard') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-slate-500 hover:text-slate-900 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Dashboard
                </a>
            </div>

            <div x-data="propertyListingForm()" class="bg-white border border-slate-200/80 rounded-3xl shadow-xl overflow-hidden">
                
                <!-- Header & Progress Bar -->
                <div class="bg-indigo-950 p-8 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-12 -mr-12 w-48 h-48 bg-indigo-500 rounded-full blur-3xl opacity-30 pointer-events-none"></div>
                    <h2 class="text-3xl font-extrabold relative z-10">List Your Flat</h2>
                    <p class="text-indigo-200 mt-2 text-sm relative z-10">Fill out the details below. We save your progress automatically.</p>
                    
                    <div class="mt-8 relative z-10 flex items-center justify-between">
                        <template x-for="i in totalSteps" :key="i">
                            <div class="flex-1 flex items-center relative">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm transition-colors duration-300 z-10"
                                     :class="currentStep >= i ? 'bg-indigo-500 text-white shadow-lg shadow-indigo-500/50' : 'bg-white/10 text-white/50'">
                                    <span x-text="i"></span>
                                </div>
                                <div x-show="i < totalSteps" class="flex-1 h-1 mx-2 rounded-full transition-colors duration-300"
                                     :class="currentStep > i ? 'bg-indigo-500' : 'bg-white/10'"></div>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="p-8">
                    <!-- Error / Success Messages -->
                    <div x-show="errorMessage" x-transition class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-xl text-sm font-semibold text-rose-800 flex items-start gap-3">
                        <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span x-text="errorMessage"></span>
                    </div>

                    <div x-show="isSaving" class="mb-6 flex items-center gap-2 text-sm font-bold text-indigo-600">
                        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Saving progress...
                    </div>

                    <!-- FORM -->
                    <form @submit.prevent="nextStep()">
                        
                        <!-- STEP 1: Basic Info -->
                        <div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" class="space-y-6">
                            <h3 class="text-xl font-bold text-slate-900 border-b border-slate-100 pb-4">Basic Information</h3>
                            
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Property Title <span class="text-rose-500">*</span></label>
                                <input type="text" x-model="formData.title" :required="currentStep === 1" class="block w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3" placeholder="e.g. Spacious 2BHK Near Jamia Millia">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Locality <span class="text-rose-500">*</span></label>
                                    <select x-model="formData.locality_id" :required="currentStep === 1" class="block w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3">
                                        <option value="">Select Locality</option>
                                        @foreach($localities as $locality)
                                            <option value="{{ $locality->id }}">{{ $locality->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Property Type <span class="text-rose-500">*</span></label>
                                    <select x-model="formData.property_type" :required="currentStep === 1" class="block w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3">
                                        <option value="">Select Type</option>
                                        <option value="flat">Flat / Apartment</option>
                                        <option value="pg">PG / Hostel</option>
                                        <option value="room">Independent Room</option>
                                        <option value="house">Independent House</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">BHK (Number of Bedrooms) <span class="text-rose-500">*</span></label>
                                <select x-model="formData.bhk" :required="currentStep === 1" class="block w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3">
                                    <option value="">Select BHK</option>
                                    <option value="1">1 BHK</option>
                                    <option value="2">2 BHK</option>
                                    <option value="3">3 BHK</option>
                                    <option value="4">4 BHK</option>
                                    <option value="5">5+ BHK</option>
                                </select>
                            </div>
                        </div>

                        <!-- STEP 2: Specs -->
                        <div x-show="currentStep === 2" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" class="space-y-6">
                            <h3 class="text-xl font-bold text-slate-900 border-b border-slate-100 pb-4">Financials & Specifications</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Monthly Rent (₹) <span class="text-rose-500">*</span></label>
                                    <input type="number" x-model="formData.rent" :required="currentStep === 2" min="0" class="block w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3" placeholder="e.g. 15000">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Security Deposit (₹) <span class="text-rose-500">*</span></label>
                                    <input type="number" x-model="formData.deposit" :required="currentStep === 2" min="0" class="block w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3" placeholder="e.g. 15000">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Area (Sq Ft) <span class="text-rose-500">*</span></label>
                                    <input type="number" x-model="formData.area" :required="currentStep === 2" min="1" class="block w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3" placeholder="e.g. 900">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Floor <span class="text-rose-500">*</span></label>
                                    <input type="text" x-model="formData.floor" :required="currentStep === 2" class="block w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3" placeholder="e.g. 2nd">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Furnishing <span class="text-rose-500">*</span></label>
                                    <select x-model="formData.furnishing" :required="currentStep === 2" class="block w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3">
                                        <option value="">Select Status</option>
                                        <option value="furnished">Furnished</option>
                                        <option value="semi-furnished">Semi-Furnished</option>
                                        <option value="unfurnished">Unfurnished</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Availability <span class="text-rose-500">*</span></label>
                                <select x-model="formData.availability" :required="currentStep === 2" class="block w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3">
                                    <option value="">Select Availability</option>
                                    <option value="immediate">Immediate</option>
                                    <option value="within_15_days">Within 15 Days</option>
                                    <option value="within_30_days">Within 30 Days</option>
                                </select>
                            </div>
                        </div>

                        <!-- STEP 3: Location -->
                        <div x-show="currentStep === 3" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" class="space-y-6">
                            <h3 class="text-xl font-bold text-slate-900 border-b border-slate-100 pb-4">Location & Owner Info</h3>
                            
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Approximate Location (Public) <span class="text-rose-500">*</span></label>
                                <p class="text-xs text-slate-400 mb-2">This is visible to public. Example: "Near Khalilullah Masjid, Batla House"</p>
                                <input type="text" x-model="formData.approximate_location" :required="currentStep === 3" class="block w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3">
                            </div>

                            <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-5 mb-4">
                                <h4 class="text-sm font-bold text-indigo-900 flex items-center gap-2 mb-2">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    Private Information
                                </h4>
                                <p class="text-xs text-indigo-700">The following details are kept completely private and offline. They will only be seen by our verified agents for scheduling visits.</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="col-span-1 md:col-span-2">
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Exact Full Address <span class="text-rose-500">*</span></label>
                                    <textarea x-model="formData.exact_address" :required="currentStep === 3" rows="2" class="block w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3"></textarea>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Building/House Number <span class="text-rose-500">*</span></label>
                                    <input type="text" x-model="formData.building_number" :required="currentStep === 3" class="block w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Owner Full Name <span class="text-rose-500">*</span></label>
                                    <input type="text" x-model="formData.owner_name" :required="currentStep === 3" class="block w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Owner Contact Number <span class="text-rose-500">*</span></label>
                                    <input type="text" x-model="formData.owner_contact" :required="currentStep === 3" class="block w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Detailed Description (Optional)</label>
                                <textarea x-model="formData.description" rows="3" class="block w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3"></textarea>
                            </div>
                        </div>

                        <!-- STEP 4: Media & Amenities -->
                        <div x-show="currentStep === 4" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" class="space-y-6">
                            <h3 class="text-xl font-bold text-slate-900 border-b border-slate-100 pb-4">Amenities & Photos</h3>
                            
                            <!-- Amenities -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-4">Select Amenities</label>
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                    @foreach($amenities as $amenity)
                                        <label class="flex items-center p-4 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition-colors">
                                            <input type="checkbox" value="{{ $amenity->id }}" x-model="formData.amenities" class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                                            <span class="ml-3 text-sm font-semibold text-slate-700">{{ $amenity->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Image Upload -->
                            <div class="mt-8">
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-4">Property Photos</label>
                                
                                <div class="flex items-center justify-center w-full">
                                    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-48 border-2 border-slate-300 border-dashed rounded-2xl cursor-pointer bg-slate-50 hover:bg-slate-100 transition-colors relative overflow-hidden" :class="isUploading ? 'opacity-50 pointer-events-none' : ''">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-10 h-10 mb-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                            <p class="mb-2 text-sm text-slate-500"><span class="font-bold">Click to upload</span> or drag and drop</p>
                                            <p class="text-xs text-slate-400">PNG, JPG or JPEG (MAX. 5MB)</p>
                                        </div>
                                        <input id="dropzone-file" type="file" class="hidden" accept="image/*" @change="uploadImage($event.target.files[0])" />
                                        
                                        <div x-show="isUploading" class="absolute inset-0 flex items-center justify-center bg-white/80">
                                            <svg class="animate-spin h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                        </div>
                                    </label>
                                </div>

                                <!-- Uploaded Images Preview -->
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6" x-show="uploadedImages.length > 0">
                                    <template x-for="img in uploadedImages" :key="img.id">
                                        <div class="relative group rounded-xl overflow-hidden border border-slate-200 aspect-[4/3]">
                                            <img :src="img.url" class="w-full h-full object-cover">
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- SUCCESS SCREEN -->
                        <div x-show="currentStep === 5" style="display: none;" class="text-center py-12 space-y-4">
                            <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-extrabold text-slate-900">Property Submitted Successfully!</h3>
                            <p class="text-slate-500 max-w-md mx-auto">Your property details have been saved and sent to our admins for verification. We will contact you shortly.</p>
                            <div class="pt-6">
                                <a href="{{ route('customer.dashboard') }}" class="inline-flex items-center justify-center px-6 py-3 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition-all shadow-md">
                                    Return to Dashboard
                                </a>
                            </div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="mt-10 pt-6 border-t border-slate-100 flex items-center justify-between" x-show="currentStep < totalSteps + 1">
                            <button type="button" @click="currentStep--" x-show="currentStep > 1" class="px-5 py-2.5 text-sm font-bold text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-xl transition-colors">
                                Back
                            </button>
                            <div x-show="currentStep === 1"></div> <!-- Spacer -->

                            <button type="submit" class="inline-flex items-center justify-center px-6 py-3 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition-all shadow-md shadow-indigo-100 hover:shadow-lg hover:-translate-y-0.5 duration-200" :disabled="isSaving">
                                <span x-text="currentStep === totalSteps ? 'Submit Property' : 'Save & Next'"></span>
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

    <script>
        function propertyListingForm() {
            return {
                currentStep: 1,
                totalSteps: 4,
                propertyId: null,
                isSaving: false,
                isUploading: false,
                errorMessage: '',
                formData: {
                    // Step 1
                    title: '', locality_id: '', property_type: '', bhk: '',
                    // Step 2
                    rent: '', deposit: '', area: '', floor: '', furnishing: '', availability: '',
                    // Step 3
                    approximate_location: '', exact_address: '', building_number: '', owner_name: '', owner_contact: '', description: '',
                    // Step 4
                    amenities: []
                },
                uploadedImages: [],

                async nextStep() {
                    this.errorMessage = '';
                    this.isSaving = true;

                    try {
                        const response = await fetch('{{ route('customer.properties.store-step') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                step: this.currentStep,
                                property_id: this.propertyId,
                                ...this.formData
                            })
                        });

                        const result = await response.json();

                        if (!response.ok) {
                            if (result.errors) {
                                // Just grab the first error for simplicity
                                const firstKey = Object.keys(result.errors)[0];
                                throw new Error(result.errors[firstKey][0]);
                            }
                            throw new Error(result.message || 'An error occurred while saving.');
                        }

                        if (result.property_id) {
                            this.propertyId = result.property_id;
                        }

                        // Go to next step
                        this.currentStep++;

                    } catch (error) {
                        this.errorMessage = error.message;
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    } finally {
                        this.isSaving = false;
                    }
                },

                async uploadImage(file) {
                    if (!file) return;
                    
                    if (!this.propertyId) {
                        this.errorMessage = "Please save Step 1 details first before uploading images.";
                        return;
                    }

                    this.isUploading = true;
                    this.errorMessage = '';

                    const formData = new FormData();
                    formData.append('image', file);
                    formData.append('property_id', this.propertyId);

                    try {
                        const response = await fetch('{{ route('customer.properties.upload-image') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            },
                            body: formData
                        });

                        const result = await response.json();

                        if (!response.ok) {
                            if (result.errors && result.errors.image) {
                                throw new Error(result.errors.image[0]);
                            }
                            throw new Error('Image upload failed.');
                        }

                        this.uploadedImages.push(result.image);

                    } catch (error) {
                        this.errorMessage = error.message;
                    } finally {
                        this.isUploading = false;
                        // Reset file input
                        document.getElementById('dropzone-file').value = '';
                    }
                }
            }
        }
    </script>
</x-public-layout>
