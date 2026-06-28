<x-admin-layout>
    <x-slot name="title">Manage Amenities</x-slot>

    <div class="md:flex md:items-center md:justify-between mb-8">
        <div class="flex-1 min-w-0">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight sm:truncate">
                Amenities
            </h1>
            <p class="mt-2 text-sm text-slate-500">
                Manage property amenities (AC, Wi-Fi, Elevator, Security, etc.).
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Add Amenity Form -->
        <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm p-6 h-fit">
            <h3 class="text-lg font-bold text-slate-900 mb-4">Add New Amenity</h3>
            <form action="{{ route('admin.amenities.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Amenity Name</label>
                    <input type="text" name="name" id="name" required placeholder="e.g. Air Conditioning" class="block w-full rounded-xl border-slate-200/85 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3">
                </div>

                <div>
                    <label for="icon" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Icon Tag / Class (optional)</label>
                    <input type="text" name="icon" id="icon" placeholder="e.g. ac, wifi, parking" class="block w-full rounded-xl border-slate-200/85 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3">
                </div>

                <div class="flex items-center">
                    <input id="is_active" name="is_active" type="checkbox" checked class="h-4.5 w-4.5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    <label for="is_active" class="ml-2.5 text-sm font-semibold text-slate-700">Active</label>
                </div>

                <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-3.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition-all shadow-md shadow-indigo-100 hover:shadow-lg duration-200">
                    Create Amenity
                </button>
            </form>
        </div>

        <!-- Amenities Table List (Span 2) -->
        <div class="lg:col-span-2 bg-white border border-slate-200/80 rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 text-left">
                    <thead class="bg-slate-50 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        <tr>
                            <th scope="col" class="px-6 py-4">Name</th>
                            <th scope="col" class="px-6 py-4">Slug</th>
                            <th scope="col" class="px-6 py-4">Icon Tag</th>
                            <th scope="col" class="px-6 py-4">Status</th>
                            <th scope="col" class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
                        @forelse($amenities as $amenity)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 font-bold text-slate-900">{{ $amenity->name }}</td>
                                <td class="px-6 py-4 text-slate-500 font-mono text-xs">{{ $amenity->slug }}</td>
                                <td class="px-6 py-4 text-slate-500">
                                    <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded bg-slate-100 text-xs font-semibold text-slate-700">
                                        {{ $amenity->icon }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($amenity->is_active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">Active</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-50 text-slate-800 border border-slate-200">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('admin.amenities.edit', $amenity) }}" class="text-slate-600 hover:text-slate-700 font-semibold text-xs transition-colors">Edit</a>
                                    <form action="{{ route('admin.amenities.destroy', $amenity) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this amenity?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-600 hover:text-rose-700 font-semibold text-xs transition-colors">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                                    No amenities configured yet. Add one on the left.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>
