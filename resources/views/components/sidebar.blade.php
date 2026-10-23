@php
    $navItems = [
        [
            'name' => 'Dashboard',
            'route' => 'dashboard',
            'active' => request()->routeIs('dashboard'),
            'icon' => 'heroicon-o-home',
        ],
        [
            'name' => 'Tables',
            'route' => 'tables.index',
            'active' => request()->routeIs('tables.*'),
            'icon' => 'heroicon-o-table-cells',
        ],
        [
            'name' => 'Users',
            'route' => 'users.index',
            'active' => request()->routeIs('users.*'),
            'icon' => 'heroicon-o-users',
        ],
    ];
@endphp

<!-- Desktop Sidebar -->
<aside id="desktop-sidebar" class="hidden lg:flex lg:flex-col lg:w-64 lg:fixed lg:inset-y-0 bg-white dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-800 z-30 transition-all duration-300 ease-in-out">
    <!-- Brand / Logo & Collapse Toggle -->
    <div class="h-16 flex items-center justify-between px-4 border-b border-zinc-200/80 dark:border-zinc-800 sidebar-header">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group focus:outline-none focus:ring-2 focus:ring-primary-500 rounded-md p-1 min-w-0" title="Flux Starter">
            <div class="w-8 h-8 rounded-md bg-primary-600 text-white flex items-center justify-center font-bold text-sm tracking-tight shadow-xs transition-colors flex-shrink-0">
                <img src="{{ asset('assets/icon/laravel-white.svg') }}" alt="Flux Starter" class="w-full h-full object-contain dark:invert dark:brightness-200" />
            </div>
            <div class="flex flex-col min-w-0 sidebar-text">
                <span class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 tracking-tight leading-tight truncate">
                    Flux Starter
                </span>
                <span class="text-[11px] text-zinc-400 font-medium leading-none truncate">
                    Laravel Dashboard
                </span>
            </div>
        </a>

        <!-- Desktop Sidebar Collapse Toggle Button (Circle in User's Screenshot) -->
        <button type="button"
                id="sidebar-toggle-btn"
                onclick="window.toggleSidebarCollapse()"
                class="sidebar-toggle-btn p-1.5 rounded-lg text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 flex-shrink-0 cursor-pointer"
                title="Tutup / Buka Sidebar"
                aria-label="Tutup / Buka Sidebar">
            <x-heroicon-o-chevron-double-left class="w-4 h-4 sidebar-icon-collapse" />
            <x-heroicon-o-chevron-double-right class="w-4 h-4 sidebar-icon-expand" />
        </button>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto" aria-label="Main Navigation">
        <div class="px-3 pb-2 text-[11px] font-semibold text-zinc-400 uppercase tracking-wider sidebar-section-title">
            Menu Utama
        </div>
        <div class="hidden sidebar-divider my-2 border-t border-zinc-200/80 dark:border-zinc-800"></div>

        @foreach ($navItems as $item)
            <a href="{{ route($item['route']) }}"
               title="{{ $item['name'] }}"
               class="sidebar-nav-link group flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-md transition-all {{ $item['active'] ? 'bg-primary-50 dark:bg-primary-950/40 text-primary-700 dark:text-primary-300 font-semibold shadow-2xs' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800/60 hover:text-zinc-900 dark:hover:text-zinc-100' }}">
                @if ($item['icon'] === 'heroicon-o-home')
                    <x-heroicon-o-home class="w-5 h-5 flex-shrink-0 {{ $item['active'] ? 'text-primary-600 dark:text-primary-400' : 'text-zinc-400 dark:text-zinc-500 group-hover:text-zinc-600 dark:group-hover:text-zinc-300' }}" />
                @elseif ($item['icon'] === 'heroicon-o-table-cells')
                    <x-heroicon-o-table-cells class="w-5 h-5 flex-shrink-0 {{ $item['active'] ? 'text-primary-600 dark:text-primary-400' : 'text-zinc-400 dark:text-zinc-500 group-hover:text-zinc-600 dark:group-hover:text-zinc-300' }}" />
                @elseif ($item['icon'] === 'heroicon-o-users')
                    <x-heroicon-o-users class="w-5 h-5 flex-shrink-0 {{ $item['active'] ? 'text-primary-600 dark:text-primary-400' : 'text-zinc-400 dark:text-zinc-500 group-hover:text-zinc-600 dark:group-hover:text-zinc-300' }}" />
                @endif
                <span class="sidebar-text truncate">{{ $item['name'] }}</span>
            </a>
        @endforeach
    </nav>

    <!-- Bottom User Section -->
    <div class="p-3 border-t border-zinc-200/80 dark:border-zinc-800 sidebar-footer">
        <div class="sidebar-user-card p-2 rounded-md bg-zinc-50/80 dark:bg-zinc-800/50 flex items-center justify-between gap-2 border border-zinc-200/50 dark:border-zinc-700/50">
            <div class="flex items-center gap-2.5 min-w-0">
                <div class="w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-950/60 text-primary-700 dark:text-primary-300 flex items-center justify-center font-medium text-xs flex-shrink-0 uppercase"
                     title="{{ auth()->user()->name }} ({{ auth()->user()->email }})">
                    {{ substr(auth()->user()->name ?? 'U', 0, 2) }}
                </div>
                <div class="min-w-0 flex-1 sidebar-text">
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
                <button type="submit" title="Keluar dari akun" aria-label="Keluar dari akun" class="p-1.5 text-zinc-400 hover:text-rose-600 dark:hover:text-rose-400 rounded-lg hover:bg-white dark:hover:bg-zinc-700 transition-colors focus:outline-none focus:ring-2 focus:ring-rose-500 cursor-pointer">
                    <x-heroicon-o-arrow-left-on-rectangle class="w-4 h-4" />
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
            <div class="w-8 h-8 rounded-md bg-primary-600 text-white flex items-center justify-center font-bold text-sm tracking-tight shadow-xs">
                <img src="{{ asset('assets/icon/laravel-white.svg') }}" alt="Flux Starter" class="w-full h-full object-contain dark:invert dark: brightness-200" />
            </div>
            <span class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                Flux Starter
            </span>
        </div>
        <button type="button" id="close-sidebar-btn" class="p-1.5 text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-zinc-400" aria-label="Tutup navigasi mobile">
            <x-heroicon-o-x-mark class="w-5 h-5" />
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
        @foreach ($navItems as $item)
            <a href="{{ route($item['route']) }}"
               class="group flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-md transition-all {{ $item['active'] ? 'bg-primary-50 dark:bg-primary-950/40 text-primary-700 dark:text-primary-300 font-semibold' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800/60 hover:text-zinc-900 dark:hover:text-zinc-100' }}">
                @if ($item['icon'] === 'heroicon-o-home')
                    <x-heroicon-o-home class="w-5 h-5 flex-shrink-0 {{ $item['active'] ? 'text-primary-600 dark:text-primary-400' : 'text-zinc-400 dark:text-zinc-500' }}" />
                @elseif ($item['icon'] === 'heroicon-o-table-cells')
                    <x-heroicon-o-table-cells class="w-5 h-5 flex-shrink-0 {{ $item['active'] ? 'text-primary-600 dark:text-primary-400' : 'text-zinc-400 dark:text-zinc-500' }}" />
                @elseif ($item['icon'] === 'heroicon-o-users')
                    <x-heroicon-o-users class="w-5 h-5 flex-shrink-0 {{ $item['active'] ? 'text-primary-600 dark:text-primary-400' : 'text-zinc-400 dark:text-zinc-500' }}" />
                @endif
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
