<x-admin-layout>
    <x-slot name="title">Agent Dashboard</x-slot>

    <!-- Header Section -->
    <div class="md:flex md:items-center md:justify-between mb-8">
        <div class="flex-1 min-w-0">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight sm:truncate">
                Agent Dashboard
            </h1>
            <p class="mt-2 text-sm text-slate-500">
                Manage your assigned leads, schedule office visits, and document flat deals.
            </p>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-3 mb-8">
        <div class="bg-white overflow-hidden rounded-2xl border border-slate-200/80 shadow-sm p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-3 bg-amber-50 rounded-xl text-amber-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div class="ml-5">
                    <dt class="text-sm font-semibold text-slate-500 truncate">My Leads</dt>
                    <dd class="text-2xl font-bold text-slate-950 mt-1">8</dd>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden rounded-2xl border border-slate-200/80 shadow-sm p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-3 bg-violet-50 rounded-xl text-violet-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="ml-5">
                    <dt class="text-sm font-semibold text-slate-500 truncate">Visits Today</dt>
                    <dd class="text-2xl font-bold text-slate-950 mt-1">2</dd>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden rounded-2xl border border-slate-200/80 shadow-sm p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-3 bg-emerald-50 rounded-xl text-emerald-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-5">
                    <dt class="text-sm font-semibold text-slate-500 truncate">Closed Deals</dt>
                    <dd class="text-2xl font-bold text-slate-950 mt-1">3</dd>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Tasks / Leads List -->
    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm overflow-hidden mb-8">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-slate-900">My Assigned Leads</h3>
            <span class="text-xs font-semibold text-slate-400">Total: 8 active</span>
        </div>
        <div class="divide-y divide-slate-100">
            <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50 transition-colors">
                <div>
                    <h4 class="font-bold text-slate-800">Imran Khan (Customer)</h4>
                    <p class="text-xs text-slate-400 mt-1">Interested in: 2BHK Batla House | Budget: ₹15,000 - ₹20,000</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-800 border border-indigo-200">Visit Scheduled</span>
                    <a href="#" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">Update status</a>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
