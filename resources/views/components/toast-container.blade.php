<div id="toast-container" class="fixed top-5 right-5 z-50 flex flex-col gap-2.5 max-w-sm w-full pointer-events-none px-4 sm:px-0" role="status" aria-live="polite">
    @if (session('success'))
        <div class="flux-toast pointer-events-auto flex items-start gap-3 p-4 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-lg shadow-zinc-950/5 text-zinc-900 dark:text-zinc-100 transition-all duration-300 transform translate-y-0 opacity-100">
            <div class="flex-shrink-0 mt-0.5 text-primary-600 dark:text-primary-400">
                <x-heroicon-o-check-circle class="w-5 h-5" />
            </div>
            <div class="flex-1 text-sm font-medium leading-5">
                {{ session('success') }}
            </div>
            <button type="button" class="toast-close-btn flex-shrink-0 -mr-1 -mt-1 p-1 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors focus:outline-none focus:ring-2 focus:ring-zinc-400" aria-label="Tutup notifikasi">
                <x-heroicon-o-x-mark class="w-4 h-4" />
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="flux-toast pointer-events-auto flex items-start gap-3 p-4 bg-white dark:bg-zinc-900 border border-rose-200 dark:border-rose-900/50 rounded-xl shadow-lg shadow-zinc-950/5 text-zinc-900 dark:text-zinc-100 transition-all duration-300 transform translate-y-0 opacity-100">
            <div class="flex-shrink-0 mt-0.5 text-rose-600 dark:text-rose-400">
                <x-heroicon-o-exclamation-circle class="w-5 h-5" />
            </div>
            <div class="flex-1 text-sm font-medium leading-5 text-rose-900 dark:text-rose-200">
                {{ session('error') }}
            </div>
            <button type="button" class="toast-close-btn flex-shrink-0 -mr-1 -mt-1 p-1 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors focus:outline-none focus:ring-2 focus:ring-zinc-400" aria-label="Tutup notifikasi">
                <x-heroicon-o-x-mark class="w-4 h-4" />
            </button>
        </div>
    @endif
</div>
