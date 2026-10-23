<x-app-layout title="Tables" :breadcrumbs="[['label' => 'Tables']]">
    <!-- Header Page -->
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">
                Data Tables
            </h1>
            <p class="mt-1 text-sm text-zinc-500">
                Kelola entitas data demo dengan fitur pencarian, filter status, pengurutan, dan paginasi server-side.
            </p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('tables.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold rounded-xl bg-zinc-900 hover:bg-zinc-800 dark:bg-zinc-100 dark:hover:bg-zinc-200 text-white dark:text-zinc-900 shadow-xs transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Data
            </a>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 rounded-2xl p-4 mb-5 shadow-2xs">
        <form method="GET" action="{{ route('tables.index') }}" class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
            <!-- Hidden Sort inputs to preserve sorting while searching/filtering -->
            <input type="hidden" name="sort" value="{{ $sort }}">
            <input type="hidden" name="direction" value="{{ $direction }}">

            <!-- Left: Search Box -->
            <div class="relative flex-1 max-w-md">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-zinc-400">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </div>
                <input type="text"
                       name="search"
                       value="{{ $search }}"
                       placeholder="Cari berdasarkan nama data..."
                       class="w-full pl-10 pr-4 py-2 text-sm rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50/50 dark:bg-zinc-800/50 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:bg-white dark:focus:bg-zinc-800 focus:border-zinc-900 dark:focus:border-zinc-100 focus:outline-none focus:ring-2 focus:ring-zinc-900/10 transition-colors">
            </div>

            <!-- Right: Filter Status & Per Page -->
            <div class="flex items-center gap-3">
                <!-- Status Filter -->
                <div class="flex items-center gap-2">
                    <label for="status" class="text-xs font-medium text-zinc-500 whitespace-nowrap">Status:</label>
                    <select id="status"
                            name="status"
                            onchange="this.form.submit()"
                            class="px-3 py-2 text-xs font-medium rounded-xl border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 focus:outline-none focus:ring-2 focus:ring-zinc-900/10">
                        <option value="" {{ empty($status) ? 'selected' : '' }}>Semua Status</option>
                        <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

                <!-- Per Page -->
                <div class="flex items-center gap-2">
                    <label for="per_page" class="text-xs font-medium text-zinc-500 whitespace-nowrap">Baris:</label>
                    <select id="per_page"
                            name="per_page"
                            onchange="this.form.submit()"
                            class="px-2.5 py-2 text-xs font-medium rounded-xl border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 focus:outline-none focus:ring-2 focus:ring-zinc-900/10">
                        @foreach ($allowedPerPage as $opt)
                            <option value="{{ $opt }}" {{ $perPage === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>

                @if ($search !== '' || !empty($status))
                    <a href="{{ route('tables.index') }}" class="p-2 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-xl transition-colors" title="Reset filter">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Data Table Container -->
    <div class="bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 rounded-2xl shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-zinc-50/80 dark:bg-zinc-800/50 border-b border-zinc-200/80 dark:border-zinc-800 text-[11px] font-semibold text-zinc-500 uppercase tracking-wider">
                    <tr>
                        <!-- Column: Name (Sortable) -->
                        <th scope="col" class="py-3.5 pl-6 pr-3">
                            <a href="{{ route('tables.index', array_merge(request()->query(), ['sort' => 'name', 'direction' => ($sort === 'name' && $direction === 'asc') ? 'desc' : 'asc'])) }}"
                               class="group inline-flex items-center gap-1.5 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">
                                <span>Nama</span>
                                <span class="text-zinc-400 group-hover:text-zinc-700 dark:group-hover:text-zinc-200">
                                    @if ($sort === 'name')
                                        @if ($direction === 'asc')
                                            ▲
                                        @else
                                            ▼
                                        @endif
                                    @else
                                        <svg class="w-3.5 h-3.5 opacity-40 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                        </svg>
                                    @endif
                                </span>
                            </a>
                        </th>

                        <!-- Column: Description -->
                        <th scope="col" class="px-3 py-3.5 hidden md:table-cell">
                            Deskripsi
                        </th>

                        <!-- Column: Status (Sortable) -->
                        <th scope="col" class="px-3 py-3.5">
                            <a href="{{ route('tables.index', array_merge(request()->query(), ['sort' => 'status', 'direction' => ($sort === 'status' && $direction === 'asc') ? 'desc' : 'asc'])) }}"
                               class="group inline-flex items-center gap-1.5 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">
                                <span>Status</span>
                                <span class="text-zinc-400 group-hover:text-zinc-700 dark:group-hover:text-zinc-200">
                                    @if ($sort === 'status')
                                        @if ($direction === 'asc')
                                            ▲
                                        @else
                                            ▼
                                        @endif
                                    @else
                                        <svg class="w-3.5 h-3.5 opacity-40 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                        </svg>
                                    @endif
                                </span>
                            </a>
                        </th>

                        <!-- Column: Created At (Sortable) -->
                        <th scope="col" class="px-3 py-3.5 hidden sm:table-cell">
                            <a href="{{ route('tables.index', array_merge(request()->query(), ['sort' => 'created_at', 'direction' => ($sort === 'created_at' && $direction === 'asc') ? 'desc' : 'asc'])) }}"
                               class="group inline-flex items-center gap-1.5 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">
                                <span>Tanggal Dibuat</span>
                                <span class="text-zinc-400 group-hover:text-zinc-700 dark:group-hover:text-zinc-200">
                                    @if ($sort === 'created_at')
                                        @if ($direction === 'asc')
                                            ▲
                                        @else
                                            ▼
                                        @endif
                                    @else
                                        <svg class="w-3.5 h-3.5 opacity-40 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                        </svg>
                                    @endif
                                </span>
                            </a>
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
                                       class="px-2.5 py-1.5 text-xs font-semibold rounded-lg text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
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
                                    <div class="w-12 h-12 rounded-2xl bg-zinc-100 dark:bg-zinc-800 text-zinc-400 flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                        </svg>
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
                                            <a href="{{ route('tables.index') }}" class="inline-flex items-center px-3.5 py-2 text-xs font-semibold rounded-xl border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-200 hover:bg-zinc-50">
                                                Bersihkan Filter
                                            </a>
                                        @else
                                            <a href="{{ route('tables.create') }}" class="inline-flex items-center px-3.5 py-2 text-xs font-semibold rounded-xl bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 hover:bg-zinc-800 dark:hover:bg-zinc-200">
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
            <div class="px-6 py-4 border-t border-zinc-200/80 dark:border-zinc-800 flex items-center justify-between">
                <div class="text-xs text-zinc-500">
                    Menampilkan <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $tables->firstItem() ?? 0 }}</span> sampai <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $tables->lastItem() ?? 0 }}</span> dari <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $tables->total() }}</span> hasil
                </div>
                <div>
                    {{ $tables->links() }}
                </div>
            </div>
        @else
            <div class="px-6 py-3.5 border-t border-zinc-200/80 dark:border-zinc-800 text-xs text-zinc-500">
                Total: <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $tables->total() }}</span> data
            </div>
        @endif
    </div>
</x-app-layout>
