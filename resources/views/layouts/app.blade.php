<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-zinc-50 dark:bg-zinc-950">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . ' - ' . config('app.name', 'Flux Starter') : config('app.name', 'Flux Starter') }}</title>

    <!-- Google Fonts / Instrument Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full text-zinc-900 dark:text-zinc-100 antialiased font-sans selection:bg-zinc-900 selection:text-white dark:selection:bg-zinc-100 dark:selection:text-zinc-900">
    <div class="min-h-full">
        <!-- Sidebar (Desktop & Mobile Drawer) -->
        <x-sidebar />

        <!-- Main Wrapper -->
        <div class="lg:pl-64 flex flex-col min-h-screen">
            <!-- Topbar -->
            <x-topbar :title="$title ?? 'Dashboard'" :breadcrumbs="$breadcrumbs ?? []" />

            <!-- Main Page Content -->
            <main class="flex-1 py-8 px-4 sm:px-6 lg:px-8 max-w-7xl w-full mx-auto">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="py-4 px-4 sm:px-6 lg:px-8 border-t border-zinc-200/80 dark:border-zinc-800 text-center text-xs text-zinc-400">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-2 max-w-7xl mx-auto">
                    <span>Flux-Inspired Laravel Dashboard Starter Kit</span>
                    <span>Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</span>
                </div>
            </footer>
        </div>
    </div>

    <!-- Reusable Toast Notification Container (Top Right) -->
    <x-toast-container />

    <!-- Reusable Modal Confirmation Dialog -->
    <x-confirm-dialog />
</body>
</html>
