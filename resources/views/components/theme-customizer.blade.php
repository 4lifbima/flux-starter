@php
    $primaryColors = [
        ['id' => 'base', 'name' => 'Base', 'color' => '#18181b'],
        ['id' => 'red', 'name' => 'Red', 'color' => '#ef4444'],
        ['id' => 'orange', 'name' => 'Orange', 'color' => '#f97316'],
        ['id' => 'amber', 'name' => 'Amber', 'color' => '#f59e0b'],
        ['id' => 'yellow', 'name' => 'Yellow', 'color' => '#eab308'],
        ['id' => 'lime', 'name' => 'Lime', 'color' => '#84cc16'],
        ['id' => 'green', 'name' => 'Green', 'color' => '#22c55e'],
        ['id' => 'emerald', 'name' => 'Emerald', 'color' => '#10b981'],
        ['id' => 'teal', 'name' => 'Teal', 'color' => '#14b8a6'],
        ['id' => 'cyan', 'name' => 'Cyan', 'color' => '#06b6d4'],
        ['id' => 'sky', 'name' => 'Sky', 'color' => '#0ea5e9'],
        ['id' => 'blue', 'name' => 'Blue', 'color' => '#3b82f6'],
        ['id' => 'indigo', 'name' => 'Indigo', 'color' => '#6366f1'],
        ['id' => 'violet', 'name' => 'Violet', 'color' => '#8b5cf6'],
        ['id' => 'purple', 'name' => 'Purple', 'color' => '#a855f7'],
        ['id' => 'fuchsia', 'name' => 'Fuchsia', 'color' => '#d946ef'],
        ['id' => 'pink', 'name' => 'Pink', 'color' => '#ec4899'],
        ['id' => 'rose', 'name' => 'Rose', 'color' => '#f43f5e'],
    ];

    $neutralPalettes = [
        ['id' => 'slate', 'name' => 'Slate', 'bg' => '#64748b'],
        ['id' => 'gray', 'name' => 'Gray', 'bg' => '#6b7280'],
        ['id' => 'zinc', 'name' => 'Zinc', 'bg' => '#71717a'],
        ['id' => 'neutral', 'name' => 'Neutral', 'bg' => '#737373'],
        ['id' => 'stone', 'name' => 'Stone', 'bg' => '#78716c'],
        ['id' => 'mauve', 'name' => 'Mauve', 'bg' => '#8e838e'],
        ['id' => 'olive', 'name' => 'Olive', 'bg' => '#7b8273'],
        ['id' => 'mist', 'name' => 'Mist', 'bg' => '#76858e'],
        ['id' => 'taupe', 'name' => 'Taupe', 'bg' => '#8a7d77'],
    ];
@endphp

<!-- Theme Customizer Modal Dialog -->
<div id="theme-customizer-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 sm:p-6" role="dialog" aria-modal="true" aria-labelledby="theme-customizer-title">
    <!-- Backdrop blur overlay -->
    <div class="fixed inset-0 bg-zinc-950/50 backdrop-blur-xs transition-opacity" onclick="window.closeThemeCustomizer()"></div>

    <!-- Modal Card (Make it your own.) -->
    <div class="relative w-full max-w-4xl transform overflow-hidden rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200/90 dark:border-zinc-800 p-6 sm:p-10 text-left shadow-2xl transition-all max-h-[92vh] overflow-y-auto">
        
        <!-- Close Button -->
        <button type="button" onclick="window.closeThemeCustomizer()" class="absolute top-5 right-5 p-2 rounded-xl text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors focus:outline-none focus:ring-2 focus:ring-zinc-400" aria-label="Tutup kustomisasi tema">
            <x-heroicon-o-x-mark class="w-5 h-5" />
        </button>

        <!-- Header -->
        <div class="text-center max-w-lg mx-auto mb-8">
            <h2 id="theme-customizer-title" class="text-2xl sm:text-3xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">
                Make it your own.
            </h2>
            <p class="mt-2 text-sm text-zinc-500">
                Choose from one of our themes or build your own.
            </p>
        </div>

        <!-- Section 1: Primary Colors -->
        <div class="mb-8">
            <div class="flex flex-wrap justify-center gap-2 sm:gap-2.5">
                @foreach ($primaryColors as $item)
                    <button type="button"
                            onclick="window.selectPrimaryTheme('{{ $item['id'] }}')"
                            data-primary-btn="{{ $item['id'] }}"
                            class="theme-primary-btn group inline-flex items-center gap-2 px-3 py-2 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800/90 shadow-2xs hover:bg-zinc-50 dark:hover:bg-zinc-700/60 focus:outline-none transition-all cursor-pointer">
                        <span class="w-4 h-4 rounded-md shadow-2xs flex-shrink-0" style="background-color: {{ $item['color'] }}"></span>
                        <span class="text-xs font-medium text-zinc-700 dark:text-zinc-200 group-hover:text-zinc-900 dark:group-hover:text-white">
                            {{ $item['name'] }}
                        </span>
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Section 2: Neutral Palettes -->
        <div class="mb-10 pt-6 border-t border-zinc-100 dark:border-zinc-800">
            <div class="flex items-center justify-center gap-3 sm:gap-4 overflow-x-auto py-2">
                <div class="text-zinc-400 pr-1" title="Pilihan Palet Netral">
                    <x-heroicon-o-link class="w-4 h-4" />
                </div>
                <div class="flex items-center gap-3 sm:gap-5">
                    @foreach ($neutralPalettes as $neutral)
                        <button type="button"
                                onclick="window.selectNeutralTheme('{{ $neutral['id'] }}')"
                                data-neutral-btn="{{ $neutral['id'] }}"
                                class="theme-neutral-btn flex flex-col items-center gap-2 group focus:outline-none cursor-pointer">
                            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl border-2 border-zinc-200 dark:border-zinc-700 flex items-center justify-center p-0.5 group-hover:border-zinc-400 dark:group-hover:border-zinc-500 transition-all">
                                <span class="w-full h-full rounded-lg" style="background-color: {{ $neutral['bg'] }}; opacity: 0.25;"></span>
                            </div>
                            <span class="text-[11px] font-medium text-zinc-500 group-hover:text-zinc-800 dark:group-hover:text-zinc-200">
                                {{ $neutral['name'] }}
                            </span>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Section 3: Bottom Mode Toggle & Generate/Save Theme CTA -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-6 border-t border-zinc-100 dark:border-zinc-800">
            <!-- Mode Switcher (Light / Dark) -->
            <div class="inline-flex items-center p-1 rounded-xl bg-zinc-100 dark:bg-zinc-800 border border-zinc-200/80 dark:border-zinc-700">
                <button type="button"
                        id="theme-mode-light-btn"
                        onclick="window.selectThemeMode('light')"
                        class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all">
                    <x-heroicon-o-sun class="w-4 h-4" />
                    <span>Light</span>
                </button>
                <button type="button"
                        id="theme-mode-dark-btn"
                        onclick="window.selectThemeMode('dark')"
                        class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all">
                    <x-heroicon-o-moon class="w-4 h-4" />
                    <span>Dark</span>
                </button>
            </div>

            <!-- Separator -->
            <div class="hidden sm:block h-6 w-px bg-zinc-200 dark:bg-zinc-700"></div>

            <!-- Generate / Apply Theme CTA -->
            <button type="button"
                    onclick="window.applyAndSaveTheme()"
                    class="inline-flex items-center gap-2.5 px-6 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-semibold text-sm shadow-md shadow-primary-600/20 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all transform active:scale-98">
                <x-heroicon-o-swatch class="w-4 h-4" />
                <span>Generate theme</span>
            </button>
        </div>

    </div>
</div>
