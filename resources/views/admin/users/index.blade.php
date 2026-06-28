<x-admin-layout>
    <x-slot name="title">Manage Users</x-slot>

    <!-- Header Section -->
    <div class="md:flex md:items-center md:justify-between mb-8">
        <div class="flex-1 min-w-0">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight sm:truncate">
                Users Management
            </h1>
            <p class="mt-2 text-sm text-slate-500">
                View and manage all platform users including Admins, Agents, and Customers.
            </p>
        </div>
        <div class="mt-4 flex md:ml-4 md:mt-0">
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-4 py-2.5 border border-transparent rounded-xl shadow-md text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none transition-all shadow-indigo-100 duration-200">
                Add New User
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-sm font-semibold text-emerald-800">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-xl text-sm font-semibold text-rose-800">
            {{ session('error') }}
        </div>
    @endif

    <!-- Users Table Card -->
    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 text-left">
                <thead class="bg-slate-50 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                    <tr>
                        <th scope="col" class="px-6 py-4">Name</th>
                        <th scope="col" class="px-6 py-4">Role</th>
                        <th scope="col" class="px-6 py-4">Contact</th>
                        <th scope="col" class="px-6 py-4">Date Joined</th>
                        <th scope="col" class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center font-bold text-sm uppercase">
                                        {{ substr($user->name, 0, 2) }}
                                    </div>
                                    <div class="font-bold text-slate-900 leading-snug">
                                        {{ $user->name }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-500 font-normal">
                                @foreach($user->roles as $role)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                        @if($role->name === 'admin') bg-purple-100 text-purple-800 
                                        @elseif($role->name === 'agent') bg-blue-100 text-blue-800 
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($role->name) }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="px-6 py-4 text-slate-500 font-normal">
                                <div>{{ $user->email }}</div>
                                <div class="text-xs text-slate-400 mt-1">{{ $user->mobile }}</div>
                            </td>
                            <td class="px-6 py-4 text-slate-400 font-normal text-xs">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('admin.users.edit', $user) }}" class="text-slate-600 hover:text-slate-700 font-bold text-xs transition-colors">Edit Details</a>
                                @if(auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-600 hover:text-rose-700 font-bold text-xs transition-colors">Remove</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                No users found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
