<x-admin-layout>
    <x-slot name="title">Invoice #INV-DEAL-{{ $deal->id }} - OkhlaFlat</x-slot>

    <!-- Header Actions (Hidden when printing) -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 print:hidden">
        <div>
            <a href="{{ route('agent.visits.index') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-slate-500 hover:text-slate-900 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Visits
            </a>
        </div>
        <div class="flex items-center gap-3 flex-wrap">
            <!-- Print button -->
            <button onclick="window.print()" class="inline-flex items-center gap-1.5 px-4 py-2 border border-slate-200 text-sm font-bold rounded-xl text-slate-700 bg-white hover:bg-slate-50 transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Print Invoice
            </button>

            <!-- Document Downloads -->
            @if($deal->id_proof_path)
                <a href="{{ asset('storage/' . $deal->id_proof_path) }}" target="_blank" class="inline-flex items-center gap-1.5 px-4 py-2 border border-slate-200 text-sm font-bold rounded-xl text-slate-700 bg-white hover:bg-slate-50 transition-all shadow-sm">
                    View ID Proof
                </a>
            @endif
            @if($deal->agreement_doc_path)
                <a href="{{ asset('storage/' . $deal->agreement_doc_path) }}" target="_blank" class="inline-flex items-center gap-1.5 px-4 py-2 border border-slate-200 text-sm font-bold rounded-xl text-slate-700 bg-white hover:bg-slate-50 transition-all shadow-sm">
                    View Rent Agreement
                </a>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-sm font-semibold text-emerald-800 print:hidden">
            {{ session('success') }}
        </div>
    @endif

    <!-- Payment Status Management Form (Admin Only, Hidden when printing) -->
    @if(auth()->user()->hasRole('admin'))
        <div class="mb-8 p-6 bg-slate-50 border border-slate-200/80 rounded-2xl print:hidden">
            <h3 class="text-sm font-bold text-slate-900 mb-3 uppercase tracking-wider">Admin Actions: Update Payment Status</h3>
            <form action="{{ route('admin.deals.payment-status', $deal) }}" method="POST" class="flex items-center gap-3 flex-wrap">
                @csrf
                <select name="payment_status" required class="rounded-xl border-slate-200 text-sm py-2 px-3 focus:border-indigo-500 focus:ring-indigo-500/20 font-semibold text-slate-800 min-w-[200px]">
                    <option value="pending_payment" @selected($deal->payment_status === 'pending_payment')>Pending Payment</option>
                    <option value="paid" @selected($deal->payment_status === 'paid')>Paid</option>
                    <option value="written_off" @selected($deal->payment_status === 'written_off')>Written Off</option>
                </select>
                <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 transition-all shadow-md shadow-indigo-100">
                    Save Changes
                </button>
            </form>
        </div>
    @endif

    <!-- Printable Invoice Page -->
    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm overflow-hidden p-8 max-w-4xl mx-auto print:border-0 print:shadow-none print:p-0">
        <!-- Invoice Header -->
        <div class="flex flex-col sm:flex-row sm:justify-between gap-6 border-b border-slate-100 pb-8 mb-8">
            <div>
                <!-- Brand name/logo -->
                <div class="text-2xl font-black text-slate-950 tracking-tight">
                    Okhla<span class="text-indigo-600">Flat</span>
                </div>
                <p class="text-xs text-slate-400 mt-1 font-semibold">HYBRID RENTAL PLATFORM</p>
                <p class="text-xs text-slate-500 mt-3 leading-relaxed">
                    Batla House, Jamia Nagar,<br>
                    Okhla, New Delhi - 110025<br>
                    support@okhlaflat.com
                </p>
            </div>
            <div class="sm:text-right">
                <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Invoice / Receipt</span>
                <h2 class="text-2xl font-bold text-slate-950 mt-1">#INV-DEAL-{{ $deal->id }}</h2>
                <p class="text-xs text-slate-500 mt-2">Date: <span class="font-semibold text-slate-800">{{ $deal->closed_at->format('M d, Y') }}</span></p>
                
                <div class="mt-4">
                    @if($deal->payment_status === 'paid')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 uppercase tracking-wide">Paid</span>
                    @elseif($deal->payment_status === 'written_off')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-slate-50 text-slate-800 border border-slate-200 uppercase tracking-wide">Written Off</span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200 uppercase tracking-wide">Pending Payment</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Client & Property details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div>
                <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-2">Billed To (Tenant)</span>
                <h4 class="font-bold text-slate-900 text-base leading-snug">{{ $deal->customer->name }}</h4>
                <p class="text-xs text-slate-500 mt-1.5 font-semibold">Contact: {{ $deal->customer->mobile }}</p>
                <p class="text-xs text-slate-500 mt-1 font-semibold">Email: {{ $deal->customer->email }}</p>
            </div>
            <div>
                <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-2">Rented Flat Details</span>
                <h4 class="font-bold text-slate-900 text-base leading-snug">{{ $deal->property->title }}</h4>
                <p class="text-xs text-slate-500 mt-1.5 font-semibold">Property Code: {{ $deal->property->property_code }}</p>
                <p class="text-xs text-slate-500 mt-1 font-semibold">Locality: {{ $deal->property->locality->name }}, Jamia Nagar</p>
                <p class="text-xs text-slate-500 mt-1 font-semibold">Assigned Coordinator: {{ $deal->agent->name }}</p>
            </div>
        </div>

        <!-- Invoice Breakdown Table -->
        <div class="border border-slate-100 rounded-2xl overflow-hidden mb-8">
            <table class="min-w-full divide-y divide-slate-100 text-left text-sm">
                <thead class="bg-slate-50 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                    <tr>
                        <th scope="col" class="px-6 py-4">Description of Service</th>
                        <th scope="col" class="px-6 py-4 text-right">Agreed Monthly Rent</th>
                        <th scope="col" class="px-6 py-4 text-right">Platform Fee Rate</th>
                        <th scope="col" class="px-6 py-4 text-right">Amount Due (INR)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                    <tr>
                        <td class="px-6 py-5">
                            <span class="font-bold text-slate-900 block">OkhlaFlat Assistance Service Fee ({{ $globalBrokerageFee }}%)</span>
                            <span class="text-xs text-slate-400 font-normal mt-0.5 block">Offline office-assisted verification, agreement drafting, and closing.</span>
                        </td>
                        <td class="px-6 py-5 text-right font-semibold">₹{{ number_format($deal->rent_amount) }}</td>
                        <td class="px-6 py-5 text-right text-slate-400">25%</td>
                        <td class="px-6 py-5 text-right font-black text-slate-950">₹{{ number_format($deal->service_fee) }}</td>
                    </tr>
                    <!-- Total row -->
                    <tr class="bg-slate-50/50">
                        <td colspan="3" class="px-6 py-5 text-right font-bold text-slate-500">Total Platform Service Fee Due:</td>
                        <td class="px-6 py-5 text-right text-xl font-black text-indigo-600">₹{{ number_format($deal->service_fee) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Payment Terms / Thank you -->
        <div class="border-t border-slate-100 pt-8 flex flex-col md:flex-row md:justify-between gap-6">
            <div>
                <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-2">Terms & Conditions</h4>
                <p class="text-[11px] text-slate-400 leading-relaxed max-w-md">
                    Please pay the platform service fee within 48 hours of key collection or agreement signing. Payments can be completed at the OkhlaFlat office via cash, UPI, or bank transfer. Platform fee is non-refundable once the rent agreement is signed by both owner and tenant.
                </p>
            </div>
            <div class="md:text-right">
                <p class="text-xs font-bold text-slate-800">Thank you for your business!</p>
                <p class="text-[11px] text-slate-400 mt-1">Digitizing rentals in Jamia Nagar.</p>
            </div>
        </div>
    </div>
</x-admin-layout>
