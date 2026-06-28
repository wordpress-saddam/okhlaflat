<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Customer Portal') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Welcome message card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-200/80 mb-8 p-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <h3 class="text-2xl font-extrabold text-slate-900">Hello, {{ auth()->user()->name }}!</h3>
                    <p class="text-sm text-slate-500 mt-1">Discover premium rental flats in Jamia Nagar. Book your physical office visit to get started.</p>
                </div>
                <a href="{{ route('properties.index') }}" class="inline-flex items-center justify-center px-5 py-3 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition-all shadow-md shadow-indigo-100 hover:shadow-lg hover:-translate-y-0.5 duration-200">
                    Browse Flats Catalogue
                </a>
            </div>

            <!-- Portal Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left: Saved Properties & Booking History -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Saved Properties -->
                    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                            <h3 class="text-lg font-bold text-slate-900">Saved Properties</h3>
                            <a href="{{ route('properties.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">Find flats</a>
                        </div>
                        <div class="p-8 text-center text-slate-400">
                            <svg class="mx-auto h-12 w-12 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <p class="text-sm font-semibold">You haven't saved any properties yet.</p>
                            <p class="text-xs text-slate-400 mt-1">Save properties to quickly reference them later.</p>
                        </div>
                    </div>

                    <!-- Visit Bookings History -->
                    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-slate-100">
                            <h3 class="text-lg font-bold text-slate-900">My Office Visit History</h3>
                        </div>
                        <div class="p-8 text-center text-slate-400">
                            <svg class="mx-auto h-12 w-12 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-sm font-semibold">No visit bookings found.</p>
                            <p class="text-xs text-slate-400 mt-1">Book an office visit using the form on the right.</p>
                        </div>
                    </div>
                </div>

                <!-- Right: Book Office Visit Form -->
                <div>
                    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm p-6 sticky top-24">
                        <h3 class="text-lg font-bold text-slate-900 mb-4">Book Office Visit</h3>
                        <p class="text-xs text-slate-400 mb-6">Schedule a physical office visit where our agents will showcase verified flats matching your exact requirements.</p>
                        
                        <form action="#" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label for="visit_date" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Preferred Date</label>
                                <input type="date" name="visit_date" id="visit_date" required class="block w-full rounded-xl border-slate-200/85 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3" min="{{ date('Y-m-d') }}">
                            </div>

                            <div>
                                <label for="visit_time" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Preferred Time</label>
                                <select name="visit_time" id="visit_time" required class="block w-full rounded-xl border-slate-200/85 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3">
                                    <option value="10:00">10:00 AM</option>
                                    <option value="11:30">11:30 AM</option>
                                    <option value="13:00">01:00 PM</option>
                                    <option value="14:30">02:30 PM</option>
                                    <option value="16:00">04:00 PM</option>
                                    <option value="17:30">05:30 PM</option>
                                </select>
                            </div>

                            <div>
                                <label for="notes" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Requirements / Notes</label>
                                <textarea name="notes" id="notes" rows="3" placeholder="e.g. looking for a 2BHK flat near Jamia Metro station, budget ₹18,000 max..." class="block w-full rounded-xl border-slate-200/85 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3"></textarea>
                            </div>

                            <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-3.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition-all shadow-md shadow-indigo-100 hover:shadow-lg duration-200">
                                Schedule Office Visit
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
