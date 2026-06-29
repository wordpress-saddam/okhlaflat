<x-admin-layout>
    <x-slot name="title">Platform Settings - OkhlaFlat</x-slot>

    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight sm:truncate">Platform Settings</h1>
            <p class="mt-2 text-sm text-slate-500">Configure global parameters and fees for OkhlaFlat.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center gap-3 text-sm font-semibold">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white overflow-hidden rounded-2xl border border-slate-200/80 shadow-sm max-w-3xl">
        <form action="{{ route('admin.settings.store') }}" method="POST" class="p-8">
            @csrf

            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-3 mb-6">Financial Configuration</h3>
                    
                    <div class="max-w-md">
                        <label for="brokerage_fee_percentage" class="block text-sm font-semibold text-slate-700 mb-2">Flat Brokerage Service Fee (%)</label>
                        <div class="relative">
                            <input type="number" step="0.1" name="brokerage_fee_percentage" id="brokerage_fee_percentage" value="{{ old('brokerage_fee_percentage', $brokerageFee) }}" class="block w-full rounded-xl border-slate-300 pr-12 focus:border-indigo-500 focus:ring-indigo-500 text-sm font-bold text-slate-900 @error('brokerage_fee_percentage') border-rose-300 text-rose-900 focus:border-rose-500 focus:ring-rose-500 @enderror" required min="0" max="100">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <span class="text-slate-500 font-bold">%</span>
                            </div>
                        </div>
                        @error('brokerage_fee_percentage')
                            <p class="mt-2 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-xs text-slate-500">This percentage is used to calculate the service fee on all new deals. For example, a 25% fee on a ₹10,000 rent will result in a ₹2,500 service fee invoice.</p>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition-all shadow-md">
                        Save Settings
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-admin-layout>
