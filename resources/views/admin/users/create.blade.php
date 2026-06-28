<x-admin-layout>
    <x-slot name="title">Add New User</x-slot>

    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('admin.users.index') }}" class="text-indigo-600 hover:text-indigo-700 font-semibold text-sm flex items-center gap-2 mb-4">
            &larr; Back to Users
        </a>
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Add New User</h1>
    </div>

    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm max-w-2xl">
        <form method="POST" action="{{ route('admin.users.store') }}" class="p-8 space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700">Full Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                       class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition-colors">
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                       class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition-colors">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Mobile -->
            <div>
                <label for="mobile" class="block text-sm font-semibold text-slate-700">Mobile Number</label>
                <input id="mobile" type="text" name="mobile" value="{{ old('mobile') }}" required
                       class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition-colors">
                <x-input-error :messages="$errors->get('mobile')" class="mt-2" />
            </div>

            <!-- Role -->
            <div>
                <label for="role" class="block text-sm font-semibold text-slate-700">User Role</label>
                <select id="role" name="role" required class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition-colors">
                    <option value="">Select a role...</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700">Password</label>
                <input id="password" type="password" name="password" required
                       class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition-colors">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-slate-700">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                       class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition-colors">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end">
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-semibold shadow-md shadow-indigo-100 hover:bg-indigo-700 transition-all text-sm">
                    Create User
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
