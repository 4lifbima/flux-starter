<div id="toast-container" class="fixed top-5 right-5 z-50 flex flex-col gap-2.5 max-w-sm w-full pointer-events-none px-4 sm:px-0" role="status" aria-live="polite">
    @if (session('success'))
        <div class="flux-toast pointer-events-auto flex items-start gap-3 p-4 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-lg shadow-zinc-950/5 text-zinc-900 dark:text-zinc-100 transition-all duration-300 transform translate-y-0 opacity-100 animate-in fade-in slide-in-from-top-2">
            <div class="flex-shrink-0 mt-0.5 text-emerald-600 dark:text-emerald-400">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <div class="flex-1 text-sm font-medium leading-5">
                {{ session('success') }}
            </div>
            <button type="button" class="toast-close-btn flex-shrink-0 -mr-1 -mt-1 p-1 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors focus:outline-none focus:ring-2 focus:ring-zinc-400" aria-label="Tutup notifikasi">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="flux-toast pointer-events-auto flex items-start gap-3 p-4 bg-white dark:bg-zinc-900 border border-rose-200 dark:border-rose-900/50 rounded-xl shadow-lg shadow-zinc-950/5 text-zinc-900 dark:text-zinc-100 transition-all duration-300 transform translate-y-0 opacity-100 animate-in fade-in slide-in-from-top-2">
            <div class="flex-shrink-0 mt-0.5 text-rose-600 dark:text-rose-400">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 7.5h.008v.008H12v-.008Z" />
                </svg>
            </div>
            <div class="flex-1 text-sm font-medium leading-5 text-rose-900 dark:text-rose-200">
                {{ session('error') }}
            </div>
            <button type="button" class="toast-close-btn flex-shrink-0 -mr-1 -mt-1 p-1 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors focus:outline-none focus:ring-2 focus:ring-zinc-400" aria-label="Tutup notifikasi">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif
</div>
