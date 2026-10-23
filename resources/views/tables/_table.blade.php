<div class="overflow-x-auto">
    <table class="w-full text-left text-sm">
        <thead class="bg-zinc-50/80 dark:bg-zinc-800/50 border-b border-zinc-200/80 dark:border-zinc-800 text-[11px] font-semibold text-zinc-500 uppercase tracking-wider">
            <tr>
                <!-- Column: Name (Sortable) -->
                <th scope="col" class="py-3.5 pl-6 pr-3">
                    <button type="button"
                            onclick="window.tableFilter.sort('name')"
                            class="group inline-flex items-center gap-1.5 hover:text-primary-600 dark:hover:text-primary-400 transition-colors focus:outline-none">
                        <span>Nama</span>
                        <span class="text-zinc-400 group-hover:text-primary-600">
                            @if ($sort === 'name')
                                @if ($direction === 'asc')
                                    ▲
                                @else
                                    ▼
                                @endif
                            @else
                                <span class="opacity-40 group-hover:opacity-100">↕</span>
                            @endif
                        </span>
                    </button>
                </th>

                <!-- Column: Description -->
                <th scope="col" class="px-3 py-3.5 hidden md:table-cell">
                    Deskripsi
                </th>

                <!-- Column: Status (Sortable) -->
                <th scope="col" class="px-3 py-3.5">
                    <button type="button"
                            onclick="window.tableFilter.sort('status')"
                            class="group inline-flex items-center gap-1.5 hover:text-primary-600 dark:hover:text-primary-400 transition-colors focus:outline-none">
                        <span>Status</span>
                        <span class="text-zinc-400 group-hover:text-primary-600">
                            @if ($sort === 'status')
                                @if ($direction === 'asc')
                                    ▲
                                @else
                                    ▼
                                @endif
                            @else
                                <span class="opacity-40 group-hover:opacity-100">↕</span>
                            @endif
                        </span>
                    </button>
                </th>

                <!-- Column: Created At (Sortable) -->
                <th scope="col" class="px-3 py-3.5 hidden sm:table-cell">
                    <button type="button"
                            onclick="window.tableFilter.sort('created_at')"
                            class="group inline-flex items-center gap-1.5 hover:text-primary-600 dark:hover:text-primary-400 transition-colors focus:outline-none">
                        <span>Tanggal Dibuat</span>
                        <span class="text-zinc-400 group-hover:text-primary-600">
                            @if ($sort === 'created_at')
                                @if ($direction === 'asc')
                                    ▲
                                @else
                                    ▼
                                @endif
                            @else
                                <span class="opacity-40 group-hover:opacity-100">↕</span>
                            @endif
                        </span>
                    </button>
                </th>

                <!-- Column: Actions -->
                <th scope="col" class="relative py-3.5 pl-3 pr-6 text-right">
                    <span class="sr-only">Aksi</span>
                    Aksi
                </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-zinc-200/70 dark:divide-zinc-800">
            @forelse ($tables as $table)
                <tr class="hover:bg-zinc-50/70 dark:hover:bg-zinc-800/40 transition-colors">
                    <!-- Name -->
                    <td class="py-4 pl-6 pr-3 font-medium text-zinc-900 dark:text-zinc-100">
                        {{ $table->name }}
                    </td>

                    <!-- Description -->
                    <td class="px-3 py-4 text-zinc-500 max-w-xs truncate hidden md:table-cell">
                        {{ $table->description ?: '—' }}
                    </td>

                    <!-- Status Badge -->
                    <td class="px-3 py-4">
                        @if ($table->status === 'active')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/60">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-zinc-400"></span>
                                Nonaktif
                            </span>
                        @endif
                    </td>

                    <!-- Date -->
                    <td class="px-3 py-4 text-xs text-zinc-500 hidden sm:table-cell">
                        {{ $table->created_at->format('d M Y, H:i') }}
                    </td>

                    <!-- Actions -->
                    <td class="py-4 pl-3 pr-6 text-right whitespace-nowrap">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('tables.edit', $table->id) }}"
                               class="px-2.5 py-1.5 text-xs font-semibold rounded-lg text-zinc-700 dark:text-zinc-300 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                                Edit
                            </a>
                            <button type="button"
                                    onclick="window.openConfirmModal({
                                        title: 'Hapus Data Table',
                                        message: 'Apakah Anda yakin ingin menghapus data \'{{ addslashes($table->name) }}\'? Tindakan ini tidak dapat dibatalkan.',
                                        action: '{{ route('tables.destroy', $table->id) }}',
                                        confirmText: 'Ya, Hapus Data'
                                    })"
                                    class="px-2.5 py-1.5 text-xs font-semibold rounded-lg text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition-colors">
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="py-16 text-center">
                        <div class="max-w-xs mx-auto">
                            <div class="w-12 h-12 rounded-xl bg-zinc-100 dark:bg-zinc-800 text-zinc-400 flex items-center justify-center mx-auto mb-3">
                                <x-heroicon-o-archive-box class="w-6 h-6" />
                            </div>
                            <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                Tidak ada data yang ditemukan
                            </h3>
                            <p class="mt-1 text-xs text-zinc-500">
                                @if ($search !== '' || !empty($status))
                                    Coba ubah kata kunci pencarian atau sesuaikan filter status Anda.
                                @else
                                    Belum ada data tables yang dibuat. Mulai dengan membuat data pertama.
                                @endif
                            </p>
                            <div class="mt-4">
                                @if ($search !== '' || !empty($status))
                                    <button type="button" onclick="window.tableFilter.reset()" class="inline-flex items-center px-3.5 py-2 text-xs font-semibold rounded-xl border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-200 hover:bg-zinc-50">
                                        Bersihkan Filter
                                    </button>
                                @else
                                    <a href="{{ route('tables.create') }}" class="inline-flex items-center px-3.5 py-2 text-xs font-semibold rounded-xl bg-primary-600 hover:bg-primary-700 text-white shadow-xs">
                                        Tambah Data Pertama
                                    </a>
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination Bar -->
@if ($tables->hasPages())
    <div class="px-6 py-4 border-t border-zinc-200/80 dark:border-zinc-800 flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="text-xs text-zinc-500">
            Menampilkan <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $tables->firstItem() ?? 0 }}</span> sampai <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $tables->lastItem() ?? 0 }}</span> dari <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $tables->total() }}</span> hasil
        </div>
        <div class="table-pagination-links">
            {{ $tables->links() }}
        </div>
    </div>
@else
    <div class="px-6 py-3.5 border-t border-zinc-200/80 dark:border-zinc-800 text-xs text-zinc-500">
        Total: <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $tables->total() }}</span> data
    </div>
@endif
