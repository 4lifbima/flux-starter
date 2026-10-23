@props(['title' => 'Dashboard', 'breadcrumbs' => []])

<header class="h-16 bg-white/80 dark:bg-zinc-900/80 backdrop-blur-md border-b border-zinc-200/80 dark:border-zinc-800 sticky top-0 z-20 flex items-center justify-between px-4 sm:px-6 lg:px-8">
    <div class="flex items-center gap-3">
        <!-- Mobile hamburger toggle -->
        <button type="button" id="open-sidebar-btn" class="lg:hidden p-2 -ml-2 text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 focus:outline-none focus:ring-2 focus:ring-zinc-400" aria-label="Buka navigasi mobile">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>

        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-sm" aria-label="Breadcrumb">
            <a href="{{ route('dashboard') }}" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
            </a>
            @foreach ($breadcrumbs as $crumb)
                <span class="text-zinc-300 dark:text-zinc-700">/</span>
                @if (isset($crumb['url']) && !$loop->last)
                    <a href="{{ $crumb['url'] }}" class="text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-zinc-200 font-medium transition-colors">
                        {{ $crumb['label'] }}
                    </a>
                @else
                    <span class="text-zinc-900 dark:text-zinc-100 font-semibold">
                        {{ $crumb['label'] }}
                    </span>
                @endif
            @endforeach
        </nav>
    </div>

    <!-- Right Side Actions & Profile Dropdown -->
    <div class="flex items-center gap-3">
        <div class="relative">
            <button type="button" id="profile-dropdown-btn" class="flex items-center gap-2.5 p-1 rounded-xl hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors focus:outline-none focus:ring-2 focus:ring-zinc-400" aria-expanded="false" aria-haspopup="true">
                <div class="w-8 h-8 rounded-full bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 flex items-center justify-center font-semibold text-xs uppercase shadow-2xs">
                    {{ substr(auth()->user()->name ?? 'U', 0, 2) }}
                </div>
                <div class="hidden md:flex flex-col text-left">
                    <span class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 leading-tight">
                        {{ auth()->user()->name }}
                    </span>
                    <span class="text-[11px] text-zinc-400 leading-none">
                        {{ auth()->user()->email }}
                    </span>
                </div>
                <svg class="w-4 h-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div id="profile-dropdown-menu" class="hidden absolute right-0 mt-2 w-48 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 py-1.5 shadow-xl shadow-zinc-950/5 focus:outline-none z-30" role="menu">
                <div class="px-3 py-2 border-b border-zinc-100 dark:border-zinc-800 md:hidden">
                    <p class="text-xs font-semibold text-zinc-900 dark:text-zinc-100">{{ auth()->user()->name }}</p>
                    <p class="text-[11px] text-zinc-400 truncate">{{ auth()->user()->email }}</p>
                </div>
                <a href="{{ route('users.edit', auth()->user()->id) }}" class="flex items-center gap-2.5 px-3 py-2 text-xs font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors" role="menuitem">
                    <svg class="w-4 h-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    Profil Saya
                </a>
                <div class="my-1 border-t border-zinc-100 dark:border-zinc-800"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2 text-xs font-medium text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition-colors text-left" role="menuitem">
                        <svg class="w-4 h-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
