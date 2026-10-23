<x-app-layout title="Users" :breadcrumbs="[['label' => 'Users']]">
    <!-- Header Page -->
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">
                Pengguna (Users)
            </h1>
            <p class="mt-1 text-sm text-zinc-500">
                Kelola akun pengguna dan administrator dengan kontrol akses dan proteksi keamanan sistem.
            </p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('users.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold rounded-xl bg-primary-600 hover:bg-primary-700 text-white shadow-xs transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500">
                <x-heroicon-o-user-plus class="w-4 h-4" />
                <span>Tambah Pengguna</span>
            </a>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 rounded-2xl p-4 mb-5 shadow-2xs">
        <form method="GET" action="{{ route('users.index') }}" class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
            <input type="hidden" name="sort" value="{{ $sort }}">
            <input type="hidden" name="direction" value="{{ $direction }}">

            <!-- Left: Search Box -->
            <div class="relative flex-1 max-w-md">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-zinc-400">
                    <x-heroicon-o-magnifying-glass class="w-4 h-4" />
                </div>
                <input type="text"
                       name="search"
                       value="{{ $search }}"
                       placeholder="Cari berdasarkan nama atau email pengguna..."
                       class="w-full pl-10 pr-4 py-2 text-sm rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50/50 dark:bg-zinc-800/50 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:bg-white dark:focus:bg-zinc-800 focus:border-primary-500 dark:focus:border-primary-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 transition-colors">
            </div>

            <!-- Right: Per Page & Reset -->
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2">
                    <label for="per_page" class="text-xs font-medium text-zinc-500 whitespace-nowrap">Baris:</label>
                    <select id="per_page"
                            name="per_page"
                            onchange="this.form.submit()"
                            class="px-2.5 py-2 text-xs font-medium rounded-xl border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                        @foreach ($allowedPerPage as $opt)
                            <option value="{{ $opt }}" {{ $perPage === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>

                @if ($search !== '')
                    <a href="{{ route('users.index') }}" class="p-2 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-xl transition-colors" title="Reset pencarian">
                        <x-heroicon-o-x-mark class="w-4 h-4" />
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
                        <!-- Column: User/Name (Sortable) -->
                        <th scope="col" class="py-3.5 pl-6 pr-3">
                            <a href="{{ route('users.index', array_merge(request()->query(), ['sort' => 'name', 'direction' => ($sort === 'name' && $direction === 'asc') ? 'desc' : 'asc'])) }}"
                               class="group inline-flex items-center gap-1.5 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                                <span>Nama Lengkap</span>
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
                            </a>
                        </th>

                        <!-- Column: Email (Sortable) -->
                        <th scope="col" class="px-3 py-3.5">
                            <a href="{{ route('users.index', array_merge(request()->query(), ['sort' => 'email', 'direction' => ($sort === 'email' && $direction === 'asc') ? 'desc' : 'asc'])) }}"
                               class="group inline-flex items-center gap-1.5 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                                <span>Email</span>
                                <span class="text-zinc-400 group-hover:text-primary-600">
                                    @if ($sort === 'email')
                                        @if ($direction === 'asc')
                                            ▲
                                        @else
                                            ▼
                                        @endif
                                    @else
                                        <span class="opacity-40 group-hover:opacity-100">↕</span>
                                    @endif
                                </span>
                            </a>
                        </th>

                        <!-- Column: Created At (Sortable) -->
                        <th scope="col" class="px-3 py-3.5 hidden sm:table-cell">
                            <a href="{{ route('users.index', array_merge(request()->query(), ['sort' => 'created_at', 'direction' => ($sort === 'created_at' && $direction === 'asc') ? 'desc' : 'asc'])) }}"
                               class="group inline-flex items-center gap-1.5 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                                <span>Terdaftar Sejak</span>
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
                    @forelse ($users as $user)
                        <tr class="hover:bg-zinc-50/70 dark:hover:bg-zinc-800/40 transition-colors">
                            <!-- Name + Avatar -->
                            <td class="py-4 pl-6 pr-3 font-medium text-zinc-900 dark:text-zinc-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-950/60 text-primary-700 dark:text-primary-300 font-medium text-xs flex items-center justify-center flex-shrink-0 uppercase border border-primary-200 dark:border-primary-800">
                                        {{ substr($user->name, 0, 2) }}
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-semibold">{{ $user->name }}</span>
                                        @if ($user->id === $currentUserId)
                                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-primary-50 dark:bg-primary-950/40 text-primary-700 dark:text-primary-300 border border-primary-200 dark:border-primary-800">
                                                Anda
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Email -->
                            <td class="px-3 py-4 text-zinc-600 dark:text-zinc-400">
                                {{ $user->email }}
                            </td>

                            <!-- Date -->
                            <td class="px-3 py-4 text-xs text-zinc-500 hidden sm:table-cell">
                                {{ $user->created_at->format('d M Y, H:i') }}
                            </td>

                            <!-- Actions with Security Guard Checks -->
                            <td class="py-4 pl-3 pr-6 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('users.edit', $user->id) }}"
                                       class="px-2.5 py-1.5 text-xs font-semibold rounded-lg text-zinc-700 dark:text-zinc-300 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                                        Edit
                                    </a>

                                    @if ($user->id === $currentUserId)
                                        <span class="px-2.5 py-1.5 text-xs font-semibold rounded-lg text-zinc-400 cursor-not-allowed" title="Anda tidak dapat menghapus akun Anda sendiri">
                                            Hapus
                                        </span>
                                    @elseif ($totalUsersCount <= 1)
                                        <span class="px-2.5 py-1.5 text-xs font-semibold rounded-lg text-zinc-400 cursor-not-allowed" title="Tidak dapat menghapus user terakhir">
                                            Hapus
                                        </span>
                                    @else
                                        <button type="button"
                                                onclick="window.openConfirmModal({
                                                    title: 'Hapus Pengguna',
                                                    message: 'Apakah Anda yakin ingin menghapus akun \'{{ addslashes($user->name) }}\' ({{ $user->email }})? Tindakan ini tidak dapat dibatalkan.',
                                                    action: '{{ route('users.destroy', $user->id) }}',
                                                    confirmText: 'Ya, Hapus Pengguna'
                                                })"
                                                class="px-2.5 py-1.5 text-xs font-semibold rounded-lg text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition-colors">
                                            Hapus
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-16 text-center">
                                <div class="max-w-xs mx-auto">
                                    <div class="w-12 h-12 rounded-2xl bg-zinc-100 dark:bg-zinc-800 text-zinc-400 flex items-center justify-center mx-auto mb-3">
                                        <x-heroicon-o-users class="w-6 h-6" />
                                    </div>
                                    <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                        Tidak ada pengguna ditemukan
                                    </h3>
                                    <p class="mt-1 text-xs text-zinc-500">
                                        @if ($search !== '')
                                            Coba sesuaikan kata kunci pencarian Anda.
                                        @else
                                            Belum ada pengguna lain terdaftar di sistem.
                                        @endif
                                    </p>
                                    <div class="mt-4">
                                        @if ($search !== '')
                                            <a href="{{ route('users.index') }}" class="inline-flex items-center px-3.5 py-2 text-xs font-semibold rounded-xl border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-200 hover:bg-zinc-50">
                                                Reset Pencarian
                                            </a>
                                        @else
                                            <a href="{{ route('users.create') }}" class="inline-flex items-center px-3.5 py-2 text-xs font-semibold rounded-xl bg-primary-600 hover:bg-primary-700 text-white shadow-xs">
                                                Tambah Pengguna
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
        @if ($users->hasPages())
            <div class="px-6 py-4 border-t border-zinc-200/80 dark:border-zinc-800 flex items-center justify-between">
                <div class="text-xs text-zinc-500">
                    Menampilkan <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $users->firstItem() ?? 0 }}</span> sampai <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $users->lastItem() ?? 0 }}</span> dari <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $users->total() }}</span> pengguna
                </div>
                <div>
                    {{ $users->links() }}
                </div>
            </div>
        @else
            <div class="px-6 py-3.5 border-t border-zinc-200/80 dark:border-zinc-800 text-xs text-zinc-500">
                Total: <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $users->total() }}</span> pengguna
            </div>
        @endif
    </div>
</x-app-layout>
