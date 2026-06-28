@php
    $role = auth()->user()->roles->first()?->name ?? 'customer';
    $dashboardRoute = $role . '.dashboard';
@endphp

<li>
    <a href="{{ route($dashboardRoute) }}" class="flex gap-x-3 rounded-lg p-2 text-sm leading-6 font-semibold {{ Route::is($dashboardRoute) ? 'bg-indigo-700 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800' }} transition-all">
        <!-- Home Icon -->
        <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
        </svg>
        Dashboard
    </a>
</li>

@can('manage properties')
<li>
    <a href="{{ route('admin.properties.index') }}" class="flex gap-x-3 rounded-lg p-2 text-sm leading-6 font-semibold {{ Route::is('admin.properties.*') ? 'bg-indigo-700 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800' }} transition-all">
        <!-- Building Icon -->
        <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205l3 1m1.5-3.93l-4.5-2.582M9 3h1.5m-1.5 3h1.5m-1.5 3h1.5m-1.5 3h1.5m-1.5 3h1.5M15 6h1.5m-1.5 3h1.5m-1.5 3h1.5m-1.5 3h1.5" />
        </svg>
        Properties
    </a>
</li>
@endcan

@if($role === 'admin')
<li>
    <a href="{{ route('admin.localities.index') }}" class="flex gap-x-3 rounded-lg p-2 text-sm leading-6 font-semibold {{ Route::is('admin.localities.*') ? 'bg-indigo-700 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800' }} transition-all">
        <!-- Map Pin Icon -->
        <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
        </svg>
        Localities
    </a>
</li>

<li>
    <a href="{{ route('admin.amenities.index') }}" class="flex gap-x-3 rounded-lg p-2 text-sm leading-6 font-semibold {{ Route::is('admin.amenities.*') ? 'bg-indigo-700 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800' }} transition-all">
        <!-- Sparkles Icon -->
        <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 21l-1.81-5.096L2.25 14.1l5.09-1.8L9.07 7.2l1.8 5.1 5.08 1.8-5.08 1.804zM19.006 5.404L18.5 7.5l-.51-2.096-2.09-.5 2.09-.51.5-2.094.51 2.094 2.09.5-2.09.51z" />
        </svg>
        Amenities
    </a>
</li>

<li>
    <a href="#" class="flex gap-x-3 rounded-lg p-2 text-sm leading-6 font-semibold text-slate-400 hover:text-white hover:bg-slate-800 transition-all">
        <!-- Users Icon -->
        <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A12.018 12.018 0 0112 21c-3.12 0-6.026-.954-8.384-2.582A9.374 9.374 0 015.421 18 4.125 4.125 0 0113.5 16.5M15 9.75a3 3 0 11-6 0 3 3 0 016 0zm-3 7.5a3 3 0 100-6 3 3 0 000 6zM19.5 9.75a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
        </svg>
        Agents & Users
    </a>
</li>
@endif

<li>
    <a href="#" class="flex gap-x-3 rounded-lg p-2 text-sm leading-6 font-semibold text-slate-400 hover:text-white hover:bg-slate-800 transition-all">
        <!-- Queue List Icon -->
        <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
        </svg>
        Leads & Visits
    </a>
</li>

@if($role === 'admin')
<li class="mt-4 border-t border-slate-800 pt-4">
    <a href="#" class="flex gap-x-3 rounded-lg p-2 text-sm leading-6 font-semibold text-slate-400 hover:text-white hover:bg-slate-800 transition-all">
        <!-- Settings Icon -->
        <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.43l-1.003.828c-.293.241-.438.613-.43.992a7.723 7.723 0 010 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.43l1.004-.827c.292-.24.437-.613.43-.991a6.936 6.936 0 010-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        Platform Settings
    </a>
</li>
@endif
