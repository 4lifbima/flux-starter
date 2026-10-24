<div class="overflow-x-auto">
    <table class="w-full text-left text-sm">
        <thead class="bg-zinc-50/80 dark:bg-zinc-800/50 border-b border-zinc-200/80 dark:border-zinc-800 text-[11px] font-semibold text-zinc-500 uppercase tracking-wider">
            <tr>
                <!-- Column: User/Name (Sortable) -->
                <th scope="col" class="py-3.5 pl-6 pr-3">
                    <button type="button"
                            onclick="window.userFilter.sort('name')"
                            class="group inline-flex items-center gap-1.5 hover:text-primary-600 dark:hover:text-primary-400 transition-colors focus:outline-none">
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
                    </button>
                </th>

                <!-- Column: Email (Sortable) -->
                <th scope="col" class="px-3 py-3.5">
                    <button type="button"
                            onclick="window.userFilter.sort('email')"
                            class="group inline-flex items-center gap-1.5 hover:text-primary-600 dark:hover:text-primary-400 transition-colors focus:outline-none">
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
                    </button>
                </th>

                <!-- Column: Role -->
                <th scope="col" class="px-3 py-3.5">
                    Peran (Role)
                </th>

                <!-- Column: Created At (Sortable) -->
                <th scope="col" class="px-3 py-3.5 hidden sm:table-cell">
                    <button type="button"
                            onclick="window.userFilter.sort('created_at')"
                            class="group inline-flex items-center gap-1.5 hover:text-primary-600 dark:hover:text-primary-400 transition-colors focus:outline-none">
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

                    <!-- Role Badge -->
                    <td class="px-3 py-4 whitespace-nowrap">
                        @php
                            $roleName = $user->roles->first()?->name ?? 'user';
                        @endphp
                        @if ($roleName === 'admin')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-primary-50 text-primary-700 dark:bg-primary-950/40 dark:text-primary-300 border border-primary-200 dark:border-primary-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-primary-600"></span>
                                Administrator
                            </span>
                        @elseif ($roleName === 'manager')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 dark:bg-blue-950/40 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                Manager
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-zinc-400"></span>
                                User
                            </span>
                        @endif
                    </td>

                    <!-- Date -->
                    <td class="px-3 py-4 text-xs text-zinc-500 hidden sm:table-cell">
                        {{ $user->created_at->format('d M Y, H:i') }}
                    </td>

                    <!-- Actions with Security Guard Checks -->
                    <td class="py-4 pl-3 pr-6 text-right whitespace-nowrap">
                        <div class="flex items-center justify-end gap-1">
                            <a href="{{ route('users.edit', $user->id) }}"
                               title="Edit pengguna"
                               aria-label="Edit {{ $user->name }}"
                               class="inline-flex items-center justify-center p-2 rounded-lg text-zinc-500 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <x-heroicon-o-pencil-square class="w-4 h-4" />
                            </a>

                            @if ($user->id === $currentUserId)
                                <span class="inline-flex items-center justify-center p-2 rounded-lg text-zinc-300 dark:text-zinc-600 cursor-not-allowed"
                                      title="Anda tidak dapat menghapus akun Anda sendiri"
                                      aria-label="Tidak dapat menghapus akun Anda sendiri">
                                    <x-heroicon-o-trash class="w-4 h-4" />
                                </span>
                            @elseif ($totalUsersCount <= 1)
                                <span class="inline-flex items-center justify-center p-2 rounded-lg text-zinc-300 dark:text-zinc-600 cursor-not-allowed"
                                      title="Tidak dapat menghapus user terakhir"
                                      aria-label="Tidak dapat menghapus user terakhir">
                                    <x-heroicon-o-trash class="w-4 h-4" />
                                </span>
                            @else
                                <button type="button"
                                        title="Hapus pengguna"
                                        aria-label="Hapus {{ $user->name }}"
                                        onclick="window.openConfirmModal({
                                            title: 'Hapus Pengguna',
                                            message: 'Apakah Anda yakin ingin menghapus akun \'{{ addslashes($user->name) }}\' ({{ $user->email }})? Tindakan ini tidak dapat dibatalkan.',
                                            action: '{{ route('users.destroy', $user->id) }}',
                                            confirmText: 'Ya, Hapus Pengguna'
                                        })"
                                        class="inline-flex items-center justify-center p-2 rounded-lg text-zinc-500 hover:text-rose-600 dark:hover:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition-colors focus:outline-none focus:ring-2 focus:ring-rose-500">
                                    <x-heroicon-o-trash class="w-4 h-4" />
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="py-16 text-center">
                        <div class="max-w-xs mx-auto">
                            <div class="w-12 h-12 rounded-xl bg-zinc-100 dark:bg-zinc-800 text-zinc-400 flex items-center justify-center mx-auto mb-3">
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
                                    <button type="button" onclick="window.userFilter.reset()" class="inline-flex items-center px-3.5 py-2 text-xs font-semibold rounded-xl border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-200 hover:bg-zinc-50">
                                        Reset Pencarian
                                    </button>
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
    <div class="px-6 py-4 border-t border-zinc-200/80 dark:border-zinc-800 flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="text-xs text-zinc-500">
            Menampilkan <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $users->firstItem() ?? 0 }}</span> sampai <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $users->lastItem() ?? 0 }}</span> dari <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $users->total() }}</span> pengguna
        </div>
        <div class="user-pagination-links">
            {{ $users->links() }}
        </div>
    </div>
@else
    <div class="px-6 py-3.5 border-t border-zinc-200/80 dark:border-zinc-800 text-xs text-zinc-500">
        Total: <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $users->total() }}</span> pengguna
    </div>
@endif
