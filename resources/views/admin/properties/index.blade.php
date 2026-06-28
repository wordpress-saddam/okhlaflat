<x-admin-layout>
    <x-slot name="title">Manage Properties</x-slot>

    <!-- Header Section -->
    <div class="md:flex md:items-center md:justify-between mb-8">
        <div class="flex-1 min-w-0">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight sm:truncate">
                Properties Catalogue
            </h1>
            <p class="mt-2 text-sm text-slate-500">
                View, manage, verify, and publish flats across Jamia Nagar.
            </p>
        </div>
        <div class="mt-4 flex md:ml-4 md:mt-0">
            <a href="{{ route('admin.properties.create') }}" class="inline-flex items-center px-4 py-2.5 border border-transparent rounded-xl shadow-md text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none transition-all shadow-indigo-100 duration-200">
                Add Flat Listing
            </a>
        </div>
    </div>

    <!-- Properties Table Card -->
    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 text-left">
                <thead class="bg-slate-50 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                    <tr>
                        <th scope="col" class="px-6 py-4">Property</th>
                        <th scope="col" class="px-6 py-4">BHK / Type</th>
                        <th scope="col" class="px-6 py-4">Rent / Deposit</th>
                        <th scope="col" class="px-6 py-4">Verification</th>
                        <th scope="col" class="px-6 py-4">Visibility</th>
                        <th scope="col" class="px-6 py-4">Assigned Agent</th>
                        <th scope="col" class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
                    @forelse($properties as $property)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <!-- Property Info -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 font-extrabold text-xs">
                                        {{ $property->property_code }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-900 leading-snug">{{ $property->title }}</h4>
                                        <p class="text-xs text-slate-400 mt-1 font-semibold">{{ $property->locality->name }} • Floor: {{ $property->floor }}</p>
                                    </div>
                                </div>
                            </td>
                            <!-- BHK / Type -->
                            <td class="px-6 py-4">
                                <span class="capitalize">{{ $property->bhk }} BHK {{ $property->property_type }}</span>
                                <span class="block text-xs text-slate-400 font-normal mt-0.5">{{ $property->area }} sq ft</span>
                            </td>
                            <!-- Rent / Deposit -->
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900">₹{{ number_format($property->rent) }}<span class="text-xs font-normal text-slate-400">/mo</span></div>
                                <span class="block text-xs text-slate-400 font-normal mt-0.5">Dep: ₹{{ number_format($property->deposit) }}</span>
                            </td>
                            <!-- Verification -->
                            <td class="px-6 py-4">
                                @if($property->verification_status === 'verified')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">Verified</span>
                                @elseif($property->verification_status === 'rejected')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-800 border border-rose-200">Rejected</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-800 border border-amber-200">Pending</span>
                                @endif
                            </td>
                            <!-- Visibility -->
                            <td class="px-6 py-4">
                                @if($property->publication_status === 'published')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-800 border border-indigo-200">Published</span>
                                @elseif($property->publication_status === 'archived')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-800 border border-slate-200">Archived</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-50 text-slate-500 border border-slate-200">Draft</span>
                                @endif
                            </td>
                            <!-- Assigned Agent -->
                            <td class="px-6 py-4 text-slate-500 font-normal">
                                {{ $property->agent->name ?? 'Unassigned' }}
                            </td>
                            <!-- Actions -->
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('admin.properties.show', $property) }}" class="text-indigo-600 hover:text-indigo-700 font-bold text-xs transition-colors">View</a>
                                <a href="{{ route('admin.properties.edit', $property) }}" class="text-slate-600 hover:text-slate-700 font-bold text-xs transition-colors">Edit</a>
                                
                                @if(auth()->user()->hasRole('admin'))
                                    <form action="{{ route('admin.properties.destroy', $property) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this property?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-600 hover:text-rose-700 font-bold text-xs transition-colors">Delete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                                No flats catalogued yet. Click "Add Flat Listing" above to begin.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination footer -->
        @if($properties->hasPages())
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                {{ $properties->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
