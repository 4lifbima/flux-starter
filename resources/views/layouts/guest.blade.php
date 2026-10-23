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
    <div class="w-full max-w-sm">
        {{ $slot }}
    </div>

    <!-- Theme Customizer Modal -->
    <x-theme-customizer />

    <!-- Reusable Toast Notification Container -->
    <x-toast-container />
</body>
</html>
