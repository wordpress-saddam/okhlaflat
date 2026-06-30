<x-admin-layout>
    <x-slot name="title">Manage Agents</x-slot>

    <!-- Header Section -->
    <div class="md:flex md:items-center md:justify-between mb-8">
        <div class="flex-1 min-w-0">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight sm:truncate">
                Office Agents
            </h1>
            <p class="mt-2 text-sm text-slate-500">
                Register and manage internal agency brokers who oversee physical flat visits.
            </p>
        </div>
        <div class="mt-4 flex md:ml-4 md:mt-0">
            <a href="{{ route('admin.agents.create') }}" class="inline-flex items-center px-4 py-2.5 border border-transparent rounded-xl shadow-md text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none transition-all shadow-indigo-100 duration-200">
                Register New Agent
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-sm font-semibold text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search Form -->
    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm p-6 mb-6">
        <form action="{{ route('admin.agents.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
            <!-- Search input -->
            <div class="md:col-span-8">
                <label for="search" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Search Agent</label>
                <div class="relative">
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Name, email, or mobile..." class="block w-full pr-10 rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5 px-3">
                </div>
            </div>
            <!-- Action buttons -->
            <div class="md:col-span-4 flex gap-3">
                <button type="submit" class="flex-1 inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition-all shadow-md shadow-indigo-100 duration-200">
                    Search
                </button>
                <a href="{{ route('admin.agents.index') }}" class="flex-1 inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 rounded-xl transition-all shadow-md shadow-slate-100 duration-200">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Agents Table Card -->
    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 text-left">
                <thead class="bg-slate-50 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                    <tr>
                        <th scope="col" class="px-6 py-4">Name</th>
                        <th scope="col" class="px-6 py-4">Email</th>
                        <th scope="col" class="px-6 py-4">Mobile</th>
                        <th scope="col" class="px-6 py-4">Date Registered</th>
                        <th scope="col" class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
                    @forelse($agents as $agent)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center font-bold text-sm uppercase">
                                        {{ substr($agent->name, 0, 2) }}
                                    </div>
                                    <div class="font-bold text-slate-900 leading-snug">
                                        {{ $agent->name }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-500 font-normal">
                                {{ $agent->email }}
                            </td>
                            <td class="px-6 py-4 text-slate-500 font-normal">
                                {{ $agent->mobile }}
                            </td>
                            <td class="px-6 py-4 text-slate-400 font-normal text-xs">
                                {{ $agent->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('admin.agents.edit', $agent) }}" class="text-slate-600 hover:text-slate-700 font-bold text-xs transition-colors">Edit Details</a>
                                <form action="{{ route('admin.agents.destroy', $agent) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this agent? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:text-rose-700 font-bold text-xs transition-colors">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                No agents registered yet. Click "Register New Agent" to add one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination footer -->
        @if($agents->hasPages())
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                {{ $agents->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
