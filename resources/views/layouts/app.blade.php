<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-zinc-50 dark:bg-zinc-950">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . ' - ' . config('app.name', 'Flux Starter') : config('app.name', 'Flux Starter') }}</title>

    <!-- Anti-FOUC Theme & Sidebar State Script -->
    <script>
        (function () {
            try {
                const primary = localStorage.getItem('flux_theme_primary') || 'orange';
                const neutral = localStorage.getItem('flux_theme_neutral') || 'neutral';
                const mode = localStorage.getItem('flux_theme_mode') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
                const sidebarCollapsed = localStorage.getItem('flux_sidebar_collapsed') === 'true';

                document.documentElement.setAttribute('data-primary', primary);
                document.documentElement.setAttribute('data-neutral', neutral);
                if (mode === 'dark') {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }

                if (sidebarCollapsed) {
                    document.documentElement.classList.add('sidebar-collapsed');
                } else {
                    document.documentElement.classList.remove('sidebar-collapsed');
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
<body class="h-full text-zinc-900 dark:text-zinc-100 antialiased font-sans selection:bg-primary-600 selection:text-white transition-colors duration-150">
    <div class="min-h-full">
        <!-- Sidebar (Desktop & Mobile Drawer) -->
        <x-sidebar />

        <!-- Main Wrapper -->
        <div id="main-wrapper" class="lg:pl-64 flex flex-col min-h-screen">
            <!-- Topbar -->
            <x-topbar :title="$title ?? 'Dashboard'" :breadcrumbs="$breadcrumbs ?? []" />

            <!-- Main Page Content -->
            <main class="flex-1 py-8 px-4 sm:px-6 lg:px-8 max-w-7xl w-full mx-auto">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="py-4 px-4 sm:px-6 lg:px-8 border-t border-zinc-200/80 dark:border-zinc-800 text-center text-xs text-zinc-400">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-2 max-w-7xl mx-auto">
                    <div class="flex items-center gap-2">
                        <span>Flux-Inspired Laravel Dashboard Starter Kit</span>
                        <button type="button" onclick="window.openThemeCustomizer()" class="text-primary-600 dark:text-primary-400 hover:underline inline-flex items-center gap-1 font-medium">
                            <x-heroicon-o-swatch class="w-3.5 h-3.5" />
                            <span>Ganti Tema</span>
                        </button>
                    </div>
                    <span>Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</span>
                </div>
            </footer>
        </div>
    </div>

    <!-- Theme Customizer Modal -->
    <x-theme-customizer />

    <!-- Reusable Toast Notification Container (Top Right) -->
    <x-toast-container />

    <!-- Reusable Modal Confirmation Dialog -->
    <x-confirm-dialog />

    @stack('scripts')
</body>
</html>
