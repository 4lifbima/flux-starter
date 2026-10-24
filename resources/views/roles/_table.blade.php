<div class="overflow-x-auto">
    <table class="w-full text-left text-sm">
        <thead class="bg-zinc-50/80 dark:bg-zinc-800/50 border-b border-zinc-200/80 dark:border-zinc-800 text-[11px] font-semibold text-zinc-500 uppercase tracking-wider">
            <tr>
                <!-- Column: Role Name (Sortable) -->
                <th scope="col" class="py-3.5 pl-6 pr-3">
                    <button type="button"
                            onclick="window.roleFilter.sort('name')"
                            class="group inline-flex items-center gap-1.5 hover:text-primary-600 dark:hover:text-primary-400 transition-colors focus:outline-none">
                        <span>Nama Role</span>
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

                <!-- Column: Permissions -->
                <th scope="col" class="px-3 py-3.5">
                    Hak Akses (Permissions)
                </th>

                <!-- Column: Users Count -->
                <th scope="col" class="px-3 py-3.5 text-center">
                    Jumlah Pengguna
                </th>

                <!-- Column: Created At (Sortable) -->
                <th scope="col" class="px-3 py-3.5 hidden sm:table-cell">
                    <button type="button"
                            onclick="window.roleFilter.sort('created_at')"
                            class="group inline-flex items-center gap-1.5 hover:text-primary-600 dark:hover:text-primary-400 transition-colors focus:outline-none">
                        <span>Dibuat Pada</span>
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
            @forelse ($roles as $role)
                <tr class="hover:bg-zinc-50/70 dark:hover:bg-zinc-800/40 transition-colors">
                    <!-- Role Name + Icon -->
                    <td class="py-4 pl-6 pr-3 font-medium text-zinc-900 dark:text-zinc-100">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-primary-100 dark:bg-primary-950/60 text-primary-700 dark:text-primary-300 flex items-center justify-center flex-shrink-0 border border-primary-200 dark:border-primary-800">
                                <x-heroicon-o-shield-check class="w-4 h-4" />
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold capitalize">{{ $role->name }}</span>
                                    @if ($role->name === 'admin')
                                        <span class="px-1.5 py-0.2 rounded text-[10px] font-bold bg-rose-50 text-rose-700 dark:bg-rose-950/40 dark:text-rose-400 border border-rose-200 dark:border-rose-800/60">
                                            Superadmin
                                        </span>
                                    @elseif ($role->name === 'manager')
                                        <span class="px-1.5 py-0.2 rounded text-[10px] font-bold bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:text-amber-400 border border-amber-200 dark:border-amber-800/60">
                                            Manager
                                        </span>
                                    @elseif ($role->name === 'user')
                                        <span class="px-1.5 py-0.2 rounded text-[10px] font-bold bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700">
                                            Default
                                        </span>
                                    @endif
                                </div>
                                <span class="text-[11px] text-zinc-400">guard: {{ $role->guard_name }}</span>
                            </div>
                        </div>
                    </td>

                    <!-- Permissions Badges -->
                    <td class="px-3 py-4 max-w-md">
                        <div class="flex flex-wrap items-center gap-1.5">
                            @php
                                $permList = $role->permissions;
                                $displayLimit = 3;
                            @endphp
                            @forelse ($permList->take($displayLimit) as $perm)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-medium bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700">
                                    {{ $perm->name }}
                                </span>
                            @empty
                                <span class="text-xs text-zinc-400 italic">Tanpa permission khusus</span>
                            @endforelse

                            @if ($permList->count() > $displayLimit)
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded-md text-[10px] font-semibold bg-primary-50 text-primary-700 dark:bg-primary-950/40 dark:text-primary-300 border border-primary-200/60 dark:border-primary-800/60"
                                      title="{{ $permList->slice($displayLimit)->pluck('name')->join(', ') }}">
                                    +{{ $permList->count() - $displayLimit }} lainnya
                                </span>
                            @endif
                        </div>
                    </td>

                    <!-- Users Count -->
                    <td class="px-3 py-4 text-center">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700">
                            <x-heroicon-o-users class="w-3.5 h-3.5 text-zinc-400" />
                            <span>{{ $role->users_count }}</span>
                        </span>
                    </td>

                    <!-- Created At -->
                    <td class="px-3 py-4 text-xs text-zinc-500 dark:text-zinc-400 hidden sm:table-cell">
                        {{ $role->created_at ? $role->created_at->translatedFormat('d M Y, H:i') : '-' }}
                    </td>

                    <!-- Actions -->
                    <td class="py-4 pl-3 pr-6 text-right whitespace-nowrap">
                        <div class="flex items-center justify-end gap-1.5">
                            <!-- Edit Button -->
                            <a href="{{ route('roles.edit', $role->id) }}"
                               title="Edit role {{ $role->name }}"
                               aria-label="Edit role {{ $role->name }}"
                               class="p-1.5 text-zinc-400 hover:text-primary-600 dark:hover:text-primary-400 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500/20">
                                <x-heroicon-o-pencil-square class="w-4 h-4" />
                            </a>

                            <!-- Delete Button (Protected for admin) -->
                            @if ($role->name === 'admin')
                                <button type="button"
                                        disabled
                                        title="Role superadmin sistem tidak dapat dihapus"
                                        aria-label="Role superadmin sistem tidak dapat dihapus"
                                        class="p-1.5 text-zinc-300 dark:text-zinc-700 cursor-not-allowed">
                                    <x-heroicon-o-trash class="w-4 h-4" />
                                </button>
                            @else
                                <button type="button"
                                        title="Hapus role {{ $role->name }}"
                                        aria-label="Hapus role {{ $role->name }}"
                                        onclick="window.openConfirmModal({
                                            title: 'Hapus Role',
                                            message: 'Apakah Anda yakin ingin menghapus role \'{{ $role->name }}\'? Tindakan ini tidak dapat dibatalkan.',
                                            action: '{{ route('roles.destroy', $role->id) }}',
                                            method: 'DELETE',
                                            confirmText: 'Hapus Role'
                                        })"
                                        class="p-1.5 text-zinc-400 hover:text-rose-600 dark:hover:text-rose-400 rounded-lg hover:bg-rose-50 dark:hover:bg-rose-950/30 transition-colors focus:outline-none focus:ring-2 focus:ring-rose-500/20 cursor-pointer">
                                    <x-heroicon-o-trash class="w-4 h-4" />
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <span class="p-3 rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-400 mb-3">
                                <x-heroicon-o-shield-check class="w-6 h-6" />
                            </span>
                            <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                @if ($search !== '')
                                    Tidak ada role atau permission yang cocok dengan "{{ $search }}"
                                @else
                                    Belum ada data role
                                @endif
                            </p>
                            <p class="text-xs text-zinc-500 mt-1 max-w-sm">
                                @if ($search !== '')
                                    Coba gunakan kata kunci pencarian lain atau klik tombol reset.
                                @else
                                    Mulai tambahkan peran pengguna baru dengan hak akses yang disesuaikan.
                                @endif
                            </p>
                            @if ($search !== '')
                                <button type="button"
                                        onclick="window.roleFilter.clearSearch()"
                                        class="mt-4 text-xs font-semibold text-primary-600 dark:text-primary-400 hover:underline">
                                    Reset Pencarian
                                </button>
                            @else
                                <a href="{{ route('roles.create') }}" class="mt-4 inline-flex items-center gap-2 px-3 py-1.5 text-xs font-semibold rounded-lg bg-primary-600 text-white hover:bg-primary-700 transition-colors">
                                    <x-heroicon-o-plus class="w-3.5 h-3.5" />
                                    <span>Tambah Role Baru</span>
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination Footer -->
@if ($roles->hasPages() || $roles->total() > 0)
    <div class="px-6 py-4 border-t border-zinc-200/80 dark:border-zinc-800 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-zinc-500 dark:text-zinc-400">
        <div>
            Menampilkan <span class="font-semibold text-zinc-900 dark:text-zinc-100">{{ $roles->firstItem() ?? 0 }}</span>
            sampai <span class="font-semibold text-zinc-900 dark:text-zinc-100">{{ $roles->lastItem() ?? 0 }}</span>
            dari <span class="font-semibold text-zinc-900 dark:text-zinc-100">{{ $roles->total() }}</span> role
        </div>
        <div>
            {{ $roles->links() }}
        </div>
    </div>
@endif
