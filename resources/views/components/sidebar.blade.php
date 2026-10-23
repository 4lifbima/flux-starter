@php
    $navItems = [
        [
            'name' => 'Dashboard',
            'route' => 'dashboard',
            'active' => request()->routeIs('dashboard'),
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />',
        ],
        [
            'name' => 'Tables',
            'route' => 'tables.index',
            'active' => request()->routeIs('tables.*'),
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0 1 12 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M12 10.875v7.5m0-7.5a1.125 1.125 0 0 1 1.125-1.125h7.125" />',
        ],
        [
            'name' => 'Users',
            'route' => 'users.index',
            'active' => request()->routeIs('users.*'),
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />',
        ],
    ];
@endphp

<!-- Desktop Sidebar -->
<aside class="hidden lg:flex lg:flex-col lg:w-64 lg:fixed lg:inset-y-0 bg-white dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-800 z-30 transition-colors">
    <!-- Brand / Logo -->
    <div class="h-16 flex items-center px-6 border-b border-zinc-200/80 dark:border-zinc-800">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group focus:outline-none focus:ring-2 focus:ring-zinc-900 dark:focus:ring-zinc-100 rounded-lg p-1">
            <div class="w-8 h-8 rounded-lg bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 flex items-center justify-center font-bold text-sm tracking-tight shadow-xs">
                FX
            </div>
            <div class="flex flex-col">
                <span class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 tracking-tight leading-tight">
                    Flux Starter
                </span>
                <span class="text-[11px] text-zinc-400 font-medium leading-none">
                    Laravel Dashboard
                </span>
            </div>
        </a>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto" aria-label="Main Navigation">
        <div class="px-3 pb-2 text-[11px] font-semibold text-zinc-400 uppercase tracking-wider">
            Menu Utama
        </div>
        @foreach ($navItems as $item)
            <a href="{{ route($item['route']) }}"
               class="group flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-xl transition-all {{ $item['active'] ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-white font-semibold shadow-2xs' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800/60 hover:text-zinc-900 dark:hover:text-zinc-100' }}">
                <svg class="w-5 h-5 flex-shrink-0 {{ $item['active'] ? 'text-zinc-900 dark:text-white' : 'text-zinc-400 dark:text-zinc-500 group-hover:text-zinc-600 dark:group-hover:text-zinc-300' }}"
                     fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                    {!! $item['icon'] !!}
                </svg>
                <span>{{ $item['name'] }}</span>
            </a>
        @endforeach
    </nav>

    <!-- Bottom User Section -->
    <div class="p-3 border-t border-zinc-200/80 dark:border-zinc-800">
        <div class="p-2 rounded-xl bg-zinc-50/80 dark:bg-zinc-800/50 flex items-center justify-between gap-2 border border-zinc-200/50 dark:border-zinc-700/50">
            <div class="flex items-center gap-2.5 min-w-0">
                <div class="w-8 h-8 rounded-full bg-zinc-200 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 flex items-center justify-center font-medium text-xs flex-shrink-0 uppercase">
                    {{ substr(auth()->user()->name ?? 'U', 0, 2) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 truncate">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="text-[11px] text-zinc-500 dark:text-zinc-400 truncate">
                        {{ auth()->user()->email }}
                    </p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="flex-shrink-0">
                @csrf
                <button type="submit" title="Keluar dari akun" aria-label="Keluar dari akun" class="p-1.5 text-zinc-400 hover:text-rose-600 dark:hover:text-rose-400 rounded-lg hover:bg-white dark:hover:bg-zinc-700 transition-colors focus:outline-none focus:ring-2 focus:ring-rose-500">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- Mobile Sidebar Drawer -->
<div id="sidebar-backdrop" class="fixed inset-0 bg-zinc-950/40 backdrop-blur-xs z-40 hidden lg:hidden transition-opacity"></div>

<aside id="mobile-sidebar" class="fixed inset-y-0 left-0 w-72 bg-white dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-800 z-50 transform -translate-x-full transition-transform duration-300 ease-in-out lg:hidden flex flex-col">
    <!-- Brand / Close -->
    <div class="h-16 flex items-center justify-between px-6 border-b border-zinc-200/80 dark:border-zinc-800">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 flex items-center justify-center font-bold text-sm tracking-tight">
                FX
            </div>
            <span class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                Flux Starter
            </span>
        </div>
        <button type="button" id="close-sidebar-btn" class="p-1.5 text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-zinc-400" aria-label="Tutup navigasi mobile">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
        @foreach ($navItems as $item)
            <a href="{{ route($item['route']) }}"
               class="group flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-xl transition-all {{ $item['active'] ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-white font-semibold' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800/60 hover:text-zinc-900 dark:hover:text-zinc-100' }}">
                <svg class="w-5 h-5 flex-shrink-0 {{ $item['active'] ? 'text-zinc-900 dark:text-white' : 'text-zinc-400 dark:text-zinc-500' }}"
                     fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                    {!! $item['icon'] !!}
                </svg>
                <span>{{ $item['name'] }}</span>
            </a>
        @endforeach
    </nav>

    <!-- Mobile User Profile -->
    <div class="p-4 border-t border-zinc-200/80 dark:border-zinc-800">
        <div class="flex items-center justify-between">
            <div class="min-w-0">
                <p class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 truncate">
                    {{ auth()->user()->name }}
                </p>
                <p class="text-[11px] text-zinc-500 truncate">
                    {{ auth()->user()->email }}
                </p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-xs font-medium text-rose-600 hover:underline">
                    Keluar
                </button>
            </form>
        </div>
    </div>
</aside>
