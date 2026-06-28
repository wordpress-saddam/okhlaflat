<x-admin-layout>
    <x-slot name="title">Edit Locality</x-slot>

    <!-- Header Section -->
    <div class="mb-8">
        <a href="{{ route('admin.localities.index') }}" class="text-indigo-600 hover:text-indigo-700 font-semibold text-sm flex items-center gap-2 mb-4">
            &larr; Back to Localities
        </a>
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Edit Locality</h1>
    </div>

    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm max-w-xl p-6">
        <form action="{{ route('admin.localities.update', $locality) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div>
                <label for="name" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Locality Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $locality->name) }}" required class="block w-full rounded-xl border-slate-200/85 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3">
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <label for="description" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Description</label>
                <textarea name="description" id="description" rows="3" class="block w-full rounded-xl border-slate-200/85 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3">{{ old('description', $locality->description) }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <div class="flex items-center">
                <input id="is_active" name="is_active" type="checkbox" {{ old('is_active', $locality->is_active) ? 'checked' : '' }} class="h-4.5 w-4.5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                <label for="is_active" class="ml-2.5 text-sm font-semibold text-slate-700">Active (Visible for properties)</label>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" class="inline-flex items-center justify-center px-6 py-3 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition-all shadow-md shadow-indigo-100 hover:shadow-lg duration-200">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
