<x-admin-layout>
    <x-slot name="title">Manage Leads & Visits</x-slot>

    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
            Leads & Visits
        </h1>
        <p class="mt-2 text-sm text-slate-500">
            View all client office visit requests, assign agency brokers, and manage schedules.
        </p>
    </div>

    <!-- Leads Table Card -->
    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 text-left">
                <thead class="bg-slate-50 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                    <tr>
                        <th scope="col" class="px-6 py-4">Customer</th>
                        <th scope="col" class="px-6 py-4">Request / Flat</th>
                        <th scope="col" class="px-6 py-4">Scheduled Date</th>
                        <th scope="col" class="px-6 py-4">Status</th>
                        <th scope="col" class="px-6 py-4">Assigned Agent</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
                    @forelse($visits as $visit)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <!-- Customer details -->
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900 leading-snug">
                                    {{ $visit->customer->name }}
                                </div>
                                <span class="block text-xs text-slate-400 font-semibold mt-1">
                                    Mob: {{ $visit->customer->mobile }}
                                </span>
                                <span class="block text-[10px] text-slate-400 font-normal mt-0.5">
                                    Email: {{ $visit->customer->email }}
                                </span>
                            </td>

                            <!-- Flat details -->
                            <td class="px-6 py-4">
                                @if($visit->property)
                                    <div class="font-bold text-slate-900 leading-snug">
                                        {{ $visit->property->title }}
                                    </div>
                                    <span class="block text-xs text-indigo-600 font-semibold mt-1">
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
                                    <div class="mt-2 p-2 bg-slate-50 rounded-lg text-xs text-slate-500 font-normal border border-slate-100">
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
                                    Requested: {{ $visit->created_at->format('M d, h:i A') }}
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

                            <!-- Action dropdown (Assign Agent) -->
                            <td class="px-6 py-4">
                                <form action="{{ route('admin.visits.assign', $visit) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('POST')
                                    <select name="agent_id" required class="rounded-xl border-slate-200 text-xs py-1.5 focus:border-indigo-500 focus:ring-indigo-500/20 max-w-[160px] font-semibold text-slate-800">
                                        <option value="">-- Select Agent --</option>
                                        @foreach($agents as $agent)
                                            <option value="{{ $agent->id }}" @selected($visit->agent_id === $agent->id)>
                                                {{ $agent->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="inline-flex items-center px-3 py-2 border border-slate-200 hover:border-indigo-500 text-xs font-bold rounded-xl text-slate-700 hover:text-indigo-600 bg-white transition-all">
                                        {{ $visit->agent_id ? 'Reassign' : 'Assign' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                No physical visit requests recorded yet.
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
