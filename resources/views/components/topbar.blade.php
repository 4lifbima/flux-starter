@props(['title' => 'Dashboard', 'breadcrumbs' => []])

<header class="h-16 bg-white/80 dark:bg-zinc-900/80 backdrop-blur-md border-b border-zinc-200/80 dark:border-zinc-800 sticky top-0 z-20 flex items-center justify-between px-4 sm:px-6 lg:px-8 transition-colors">
    <div class="flex items-center gap-3">
        <!-- Mobile hamburger toggle -->
        <button type="button" id="open-sidebar-btn" class="lg:hidden p-2 -ml-2 text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 focus:outline-none focus:ring-2 focus:ring-primary-500" aria-label="Buka navigasi mobile">
            <x-heroicon-o-bars-3 class="w-5 h-5" />
        </button>

        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-sm" aria-label="Breadcrumb">
            <a href="{{ route('dashboard') }}" class="text-zinc-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                <x-heroicon-o-home class="w-4 h-4" />
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
    <div class="flex items-center gap-2 sm:gap-3">
        <!-- Quick Dark/Light Mode Toggle Button -->
        <button type="button"
                id="quick-dark-mode-toggle"
                onclick="window.toggleDarkMode()"
                class="inline-flex items-center justify-center p-2 rounded-md border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700/60 shadow-2xs transition-all focus:outline-none focus:ring-2 focus:ring-primary-500 cursor-pointer"
                title="Beralih Mode Gelap / Terang"
                aria-label="Beralih Mode Gelap / Terang">
            <x-heroicon-o-sun class="w-4 h-4 hidden dark:block text-amber-400" />
            <x-heroicon-o-moon class="w-4 h-4 block dark:hidden text-zinc-600" />
        </button>

        <!-- Quick Theme Customizer Button (Matching User's Request) -->
        <button type="button"
                onclick="window.openThemeCustomizer()"
                class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-xs font-semibold text-zinc-700 dark:text-zinc-200 hover:bg-zinc-50 dark:hover:bg-zinc-700/60 shadow-2xs transition-all focus:outline-none focus:ring-2 focus:ring-primary-500"
                title="Kustomisasi Tema & Warna">
            <x-heroicon-o-swatch class="w-4 h-4 text-primary-600 dark:text-primary-400" />
            <span class="hidden sm:inline">Tema</span>
            <span class="w-2.5 h-2.5 rounded-full bg-primary-600 shadow-2xs"></span>
        </button>

        <!-- Profile Dropdown -->
        <div class="relative">
            <button type="button" id="profile-dropdown-btn" class="flex items-center gap-2.5 p-1 rounded-xl hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500" aria-expanded="false" aria-haspopup="true">
                <div class="w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center font-semibold text-xs uppercase shadow-2xs">
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
                <x-heroicon-o-chevron-down class="w-3.5 h-3.5 text-zinc-400" />
            </button>

            <!-- Dropdown Menu -->
            <div id="profile-dropdown-menu" class="hidden absolute right-0 mt-2 w-48 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 py-1.5 shadow-xl shadow-zinc-950/5 focus:outline-none z-30" role="menu">
                <div class="px-3 py-2 border-b border-zinc-100 dark:border-zinc-800 md:hidden">
                    <p class="text-xs font-semibold text-zinc-900 dark:text-zinc-100">{{ auth()->user()->name }}</p>
                    <p class="text-[11px] text-zinc-400 truncate">{{ auth()->user()->email }}</p>
                </div>
                <a href="{{ route('users.edit', auth()->user()->id) }}" class="flex items-center gap-2.5 px-3 py-2 text-xs font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors" role="menuitem">
                    <x-heroicon-o-user class="w-4 h-4 text-zinc-400" />
                    Profil Saya
                </a>
                <button type="button" onclick="window.openThemeCustomizer()" class="w-full flex items-center gap-2.5 px-3 py-2 text-xs font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors text-left" role="menuitem">
                    <x-heroicon-o-swatch class="w-4 h-4 text-primary-600 dark:text-primary-400" />
                    Pilih Tema Warna
                </button>
                <div class="my-1 border-t border-zinc-100 dark:border-zinc-800"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2 text-xs font-medium text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition-colors text-left" role="menuitem">
                        <x-heroicon-o-arrow-left-on-rectangle class="w-4 h-4 text-rose-500" />
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
