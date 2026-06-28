<x-admin-layout>
    <x-slot name="title">Register New Agent</x-slot>

    <!-- Header Section -->
    <div class="mb-8">
        <a href="{{ route('admin.agents.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 transition-colors">&larr; Back to Agents</a>
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mt-2">
            Register Agent
        </h1>
        <p class="mt-1 text-sm text-slate-500">
            Create an internal account for physical property coordinators.
        </p>
    </div>

    <!-- Register Form Card -->
    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm max-w-xl p-6 md:p-8">
        <form action="{{ route('admin.agents.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Agent Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="block w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200/50 text-sm font-semibold text-slate-800 py-3 px-4 transition-all"
                       placeholder="Enter agent's full name">
                @error('name')
                    <p class="mt-2 text-xs font-semibold text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Email Address</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                       class="block w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200/50 text-sm font-semibold text-slate-800 py-3 px-4 transition-all"
                       placeholder="agent@okhlaflat.com">
                @error('email')
                    <p class="mt-2 text-xs font-semibold text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Mobile -->
            <div>
                <label for="mobile" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Mobile Number</label>
                <input type="tel" name="mobile" id="mobile" value="{{ old('mobile') }}" required
                       class="block w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200/50 text-sm font-semibold text-slate-800 py-3 px-4 transition-all"
                       placeholder="e.g. +91 XXXXX XXXXX">
                @error('mobile')
                    <p class="mt-2 text-xs font-semibold text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Password</label>
                <input type="password" name="password" id="password" required
                       class="block w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200/50 text-sm font-semibold text-slate-800 py-3 px-4 transition-all"
                       placeholder="••••••••">
                @error('password')
                    <p class="mt-2 text-xs font-semibold text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                       class="block w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200/50 text-sm font-semibold text-slate-800 py-3 px-4 transition-all"
                       placeholder="••••••••">
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit"
                        class="w-full inline-flex items-center justify-center px-4 py-3 border border-transparent rounded-xl shadow-md text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none transition-all shadow-indigo-100 duration-200">
                    Register Agent
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
