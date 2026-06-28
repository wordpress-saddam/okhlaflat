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

            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-sm font-semibold text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-xl text-sm font-semibold text-rose-800">
                    {{ session('error') }}
                </div>
            @endif

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
                        
                        @if($visitRequests->isEmpty())
                            <div class="p-8 text-center text-slate-400">
                                <svg class="mx-auto h-12 w-12 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-sm font-semibold">No visit bookings found.</p>
                                <p class="text-xs text-slate-400 mt-1">Book an office visit using the form on the right.</p>
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-slate-100 text-left">
                                    <thead class="bg-slate-50 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        <tr>
                                            <th scope="col" class="px-6 py-4">Request / Flat</th>
                                            <th scope="col" class="px-6 py-4">Appointment Time</th>
                                            <th scope="col" class="px-6 py-4">Assigned Agent</th>
                                            <th scope="col" class="px-6 py-4">Status</th>
                                            <th scope="col" class="px-6 py-4 text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
                                        @foreach($visitRequests as $request)
                                            <tr class="hover:bg-slate-50 transition-colors">
                                                <td class="px-6 py-4">
                                                    @if($request->property)
                                                        <div class="font-bold text-slate-900 leading-snug">
                                                            {{ $request->property->title }}
                                                        </div>
                                                        <span class="block text-xs text-slate-400 font-semibold mt-1">
                                                            Flat: {{ $request->property->property_code }} • {{ $request->property->locality->name }}
                                                        </span>
                                                    @else
                                                        <div class="font-bold text-slate-900 leading-snug">
                                                            General Consultation
                                                        </div>
                                                        <span class="block text-xs text-slate-400 font-normal mt-1">
                                                            Physical office visit to explore options
                                                        </span>
                                                    @endif
                                                    @if($request->customer_notes)
                                                        <p class="text-xs text-slate-400 italic mt-2 font-normal line-clamp-1">"{{ $request->customer_notes }}"</p>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 text-slate-500 font-normal">
                                                    @if($request->scheduled_at)
                                                        <span class="text-slate-900 font-semibold">{{ $request->scheduled_at->format('M d, Y') }}</span>
                                                        <span class="block text-xs text-slate-400 font-semibold mt-1">{{ $request->scheduled_at->format('h:i A') }}</span>
                                                    @else
                                                        <span class="text-slate-400 italic">Scheduling pending contact</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 text-slate-500 font-semibold">
                                                    @if($request->agent)
                                                        <div class="flex items-center gap-2">
                                                            <div class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center text-[10px] text-slate-600 font-bold uppercase">
                                                                {{ substr($request->agent->name, 0, 2) }}
                                                            </div>
                                                            <span class="text-xs text-slate-700">{{ $request->agent->name }}</span>
                                                        </div>
                                                    @else
                                                        <span class="text-xs text-slate-400 font-normal italic">Staff assigning soon</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4">
                                                    @if($request->status === 'pending')
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-800 border border-amber-200">Pending</span>
                                                    @elseif($request->status === 'assigned')
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-800 border border-indigo-200">Agent Assigned</span>
                                                    @elseif($request->status === 'scheduled')
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-teal-50 text-teal-800 border border-teal-200">Scheduled</span>
                                                    @elseif($request->status === 'completed')
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">Completed</span>
                                                    @else
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-800 border border-rose-200">Cancelled</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 text-right space-x-1.5 whitespace-nowrap">
                                                    @if($request->deal)
                                                        <a href="{{ route('customer.deals.invoice', $request->deal) }}" class="inline-flex items-center px-2.5 py-1 bg-indigo-50 border border-indigo-200 text-xs font-bold text-indigo-700 rounded-lg hover:bg-indigo-100 transition-colors shadow-sm">
                                                            View Invoice
                                                        </a>
                                                    @endif

                                                    @if($request->status === 'completed')
                                                        @if($request->review)
                                                            <span class="inline-flex items-center gap-1 text-xs font-bold text-slate-700 bg-slate-50 border border-slate-200 rounded-lg px-2 py-1">
                                                                <svg class="w-3 h-3 text-amber-400 fill-current" viewBox="0 0 20 20">
                                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                </svg>
                                                                {{ $request->review->property_rating }}/5 Stars
                                                            </span>
                                                        @else
                                                            <a href="{{ route('customer.reviews.create', $request) }}" class="inline-flex items-center px-2.5 py-1 bg-amber-50 border border-amber-200 text-xs font-bold text-amber-700 rounded-lg hover:bg-amber-100 transition-colors shadow-sm">
                                                                Rate Visit
                                                            </a>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right: Book Office Visit Form -->
                <div>
                    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm p-6 sticky top-24">
                        <h3 class="text-lg font-bold text-slate-900 mb-4">Book Office Visit</h3>
                        <p class="text-xs text-slate-400 mb-6">Schedule a physical office visit where our agents will showcase verified flats matching your exact requirements.</p>
                        
                        <form action="{{ route('customer.visits.store') }}" method="POST" class="space-y-4">
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
