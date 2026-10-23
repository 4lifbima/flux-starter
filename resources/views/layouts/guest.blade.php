<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-zinc-50 dark:bg-zinc-950">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . ' - ' . config('app.name', 'Flux Starter') : config('app.name', 'Flux Starter') }}</title>

    <!-- Anti-FOUC Theme Script -->
    <script>
        (function () {
            try {
                const primary = localStorage.getItem('flux_theme_primary') || 'orange';
                const neutral = localStorage.getItem('flux_theme_neutral') || 'neutral';
                const mode = localStorage.getItem('flux_theme_mode') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
                document.documentElement.setAttribute('data-primary', primary);
                document.documentElement.setAttribute('data-neutral', neutral);
                if (mode === 'dark') {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            } catch (e) {}
        })();
    </script>

    <!-- Google Fonts / Instrument Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full text-zinc-900 dark:text-zinc-100 antialiased font-sans flex items-center justify-center p-4 selection:bg-primary-600 selection:text-white transition-colors duration-150">
    <!-- Top-Right Floating Controls (Theme & Dark Mode) -->
    <div class="fixed top-4 right-4 z-40 flex items-center gap-2">
        <button type="button"
                onclick="window.toggleDarkMode()"
                class="inline-flex items-center justify-center p-2 rounded-md border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 text-zinc-600 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 shadow-2xs transition-all focus:outline-none focus:ring-2 focus:ring-primary-500 cursor-pointer"
                title="Beralih Mode Gelap / Terang">
            <x-heroicon-o-sun class="w-4 h-4 hidden dark:block text-amber-400" />
            <x-heroicon-o-moon class="w-4 h-4 block dark:hidden text-zinc-600" />
        </button>
        <button type="button"
                onclick="window.openThemeCustomizer()"
                class="inline-flex items-center gap-2 px-3 py-2 rounded-md border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 text-xs font-semibold text-zinc-700 dark:text-zinc-200 hover:bg-zinc-50 dark:hover:bg-zinc-800 shadow-2xs transition-all focus:outline-none focus:ring-2 focus:ring-primary-500 cursor-pointer"
                title="Kustomisasi Tema & Warna">
            <x-heroicon-o-swatch class="w-4 h-4 text-primary-600 dark:text-primary-400" />
            <span class="w-2 h-2 rounded-full bg-primary-600"></span>
        </button>
    </div>

    <div class="w-full max-w-sm">
        {{ $slot }}
    </div>

    <!-- Theme Customizer Modal -->
    <x-theme-customizer />

    <!-- Reusable Toast Notification Container -->
    <x-toast-container />
</body>
</html>
