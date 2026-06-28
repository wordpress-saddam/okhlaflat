<x-admin-layout>
    <x-slot name="title">My Assigned Visits</x-slot>

    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
            My Assigned Visits
        </h1>
        <p class="mt-2 text-sm text-slate-500">
            Coordinate physical flat visits with your assigned clients. Call the client to schedule, and update status.
        </p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-sm font-semibold text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <!-- Leads Table Card -->
    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 text-left">
                <thead class="bg-slate-50 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                    <tr>
                        <th scope="col" class="px-6 py-4">Customer Details</th>
                        <th scope="col" class="px-6 py-4">Request / Flat</th>
                        <th scope="col" class="px-6 py-4">Current Appointment</th>
                        <th scope="col" class="px-6 py-4">Status</th>
                        <th scope="col" class="px-6 py-4 text-right">Update Visit Details</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
                    @forelse($visits as $visit)
                        <tr class="hover:bg-slate-50 transition-colors" x-data="{ status: '{{ $visit->status }}' }">
                            <!-- Customer Details -->
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900 leading-snug">
                                    {{ $visit->customer->name }}
                                </div>
                                <a href="tel:{{ $visit->customer->mobile }}" class="inline-flex items-center gap-1 text-xs text-indigo-600 hover:text-indigo-700 font-semibold mt-1">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    {{ $visit->customer->mobile }}
                                </a>
                                <span class="block text-[10px] text-slate-400 font-normal mt-0.5">
                                    {{ $visit->customer->email }}
                                </span>
                            </td>

                            <!-- Flat details -->
                            <td class="px-6 py-4">
                                @if($visit->property)
                                    <div class="font-bold text-slate-900 leading-snug">
                                        {{ $visit->property->title }}
                                    </div>
                                    <span class="block text-xs text-slate-400 font-semibold mt-1">
                                        Code: {{ $visit->property->property_code }} • {{ $visit->property->locality->name }}
                                    </span>
                                @else
                                    <div class="font-bold text-slate-900 leading-snug">
                                        General Consultation
                                    </div>
                                    <span class="block text-xs text-slate-400 font-normal mt-1">
                                        Office meeting booking
                                    </span>
                                @endif
                                @if($visit->customer_notes)
                                    <div class="mt-2 p-2 bg-slate-50 rounded-lg text-xs text-slate-500 font-normal border border-slate-100 max-w-xs">
                                        <span class="font-semibold block text-[10px] text-slate-400 uppercase mb-0.5">Customer Notes:</span>
                                        "{{ $visit->customer_notes }}"
                                    </div>
                                @endif
                            </td>

                            <!-- Date scheduled -->
                            <td class="px-6 py-4">
                                @if($visit->scheduled_at)
                                    <span class="text-slate-900 font-semibold">{{ $visit->scheduled_at->format('M d, Y') }}</span>
                                    <span class="block text-xs text-slate-400 font-semibold mt-1">{{ $visit->scheduled_at->format('h:i A') }}</span>
                                @else
                                    <span class="text-xs text-amber-600 font-semibold italic bg-amber-50 px-2 py-1 rounded-lg border border-amber-100">Pending Schedule</span>
                                @endif
                                <span class="block text-[10px] text-slate-400 font-normal mt-1.5">
                                    Assigned: {{ $visit->updated_at->format('M d, h:i A') }}
                                </span>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4">
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
                            </td>

                            <!-- Action status Form -->
                            <td class="px-6 py-4 text-right">
                                @if($visit->deal)
                                    <div class="flex flex-col items-end gap-1">
                                        <a href="{{ route('agent.deals.invoice', $visit->deal) }}" class="inline-flex items-center gap-1.5 px-3 py-2 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 rounded-xl text-xs font-bold text-emerald-800 transition-all">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Invoice: ₹{{ number_format($visit->deal->service_fee) }}
                                        </a>
                                        <span class="text-[10px] uppercase font-bold tracking-wider {{ $visit->deal->payment_status === 'paid' ? 'text-emerald-600' : ($visit->deal->payment_status === 'written_off' ? 'text-slate-400' : 'text-amber-600') }}">
                                            {{ str_replace('_', ' ', $visit->deal->payment_status) }}
                                        </span>
                                    </div>
                                @else
                                    <div class="flex items-center justify-end gap-3 flex-wrap">
                                        @if(in_array($visit->status, ['assigned', 'scheduled']))
                                            <a href="{{ route('agent.deals.create', $visit) }}" class="inline-flex items-center gap-1 px-3 py-2 border border-emerald-200 text-xs font-bold rounded-xl text-emerald-800 bg-emerald-50 hover:bg-emerald-100 transition-all">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Close Deal
                                            </a>
                                        @endif

                                        <form action="{{ route('agent.visits.update', $visit) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PUT')
                                            <div class="flex items-center justify-end gap-2">
                                                <!-- Show date inputs only if scheduling -->
                                                <div x-show="status === 'scheduled'" class="flex gap-2">
                                                    <input type="date" name="scheduled_date" value="{{ $visit->scheduled_at ? $visit->scheduled_at->format('Y-m-d') : '' }}" class="rounded-xl border-slate-200 text-xs py-1.5 focus:border-indigo-500 focus:ring-indigo-500/20 max-w-[120px] font-semibold text-slate-800">
                                                    <input type="time" name="scheduled_time" value="{{ $visit->scheduled_at ? $visit->scheduled_at->format('H:i') : '' }}" class="rounded-xl border-slate-200 text-xs py-1.5 focus:border-indigo-500 focus:ring-indigo-500/20 max-w-[100px] font-semibold text-slate-800">
                                                </div>

                                                <select name="status" x-model="status" required class="rounded-xl border-slate-200 text-xs py-1.5 focus:border-indigo-500 focus:ring-indigo-500/20 max-w-[120px] font-semibold text-slate-800">
                                                    <option value="assigned" @selected($visit->status === 'assigned')>Assigned</option>
                                                    <option value="scheduled" @selected($visit->status === 'scheduled')>Scheduled</option>
                                                    <option value="completed" @selected($visit->status === 'completed')>Completed</option>
                                                    <option value="cancelled" @selected($visit->status === 'cancelled')>Cancelled</option>
                                                </select>

                                                <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-xs font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 transition-all">
                                                    Update
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                No physical visit requests assigned to you yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($visits->hasPages())
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                {{ $visits->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
