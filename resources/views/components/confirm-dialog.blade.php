<div id="confirm-dialog-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 sm:p-6" role="dialog" aria-modal="true" aria-labelledby="confirm-dialog-title">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-zinc-950/50 backdrop-blur-xs transition-opacity" onclick="window.closeConfirmModal()"></div>

    <!-- Modal Card -->
    <div class="relative w-full max-w-md transform overflow-hidden rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-6 text-left shadow-2xl transition-all">
        <div class="flex items-start gap-4">
            <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400">
                <x-heroicon-o-exclamation-triangle class="h-6 w-6" />
            </div>
            <div class="flex-1">
                <h3 id="confirm-dialog-title" class="text-base font-semibold leading-6 text-zinc-900 dark:text-zinc-100">
                    Konfirmasi Tindakan
                </h3>
                <div class="mt-2">
                    <p id="confirm-dialog-message" class="text-sm text-zinc-600 dark:text-zinc-400">
                        Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-6 flex flex-col-reverse sm:flex-row sm:justify-end gap-2.5">
            <button type="button" onclick="window.closeConfirmModal()" class="inline-flex justify-center items-center px-4 py-2.5 text-sm font-medium rounded-xl border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-200 hover:bg-zinc-50 dark:hover:bg-zinc-700/60 focus:outline-none focus:ring-2 focus:ring-zinc-400 transition-colors">
                Batal
            </button>
            <form id="confirm-dialog-form" method="POST" action="" class="inline-block">
                @csrf
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" id="confirm-dialog-confirm-btn" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2.5 text-sm font-medium rounded-xl bg-rose-600 hover:bg-rose-700 text-white shadow-xs focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2 transition-colors">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>
