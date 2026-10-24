<x-app-layout title="Tambah Role" :breadcrumbs="[['label' => 'Roles & Permissions', 'url' => route('roles.index')], ['label' => 'Tambah Role']]">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">
                Tambah Role Baru
            </h1>
            <p class="mt-1 text-sm text-zinc-500">
                Tentukan nama peran dan pilih hak akses (permissions) yang diizinkan untuk peran ini.
            </p>
        </div>

        <!-- Form Card -->
        <form action="{{ route('roles.store') }}" method="POST" class="bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 rounded-2xl shadow-2xs overflow-hidden">
            @csrf

            <div class="p-6 space-y-6">
                <!-- Field: Nama Role -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100 mb-1.5">
                        Nama Role <span class="text-rose-500">*</span>
                    </label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name') }}"
                           required
                           autofocus
                           placeholder="Contoh: editor, supervisor, staff"
                           class="w-full px-4 py-2.5 text-sm rounded-xl border @error('name') border-rose-400 dark:border-rose-700 bg-rose-50/30 dark:bg-rose-950/20 @else border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 @enderror text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                    <p class="mt-1 text-xs text-zinc-400">Gunakan huruf kecil tanpa spasi (boleh menggunakan strip '-' atau underscore '_').</p>
                    @error('name')
                        <p class="mt-1.5 text-xs text-rose-600 dark:text-rose-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Section: Hak Akses (Permissions) -->
                <div class="pt-4 border-t border-zinc-100 dark:border-zinc-800">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                Tetapkan Hak Akses (Permissions)
                            </h2>
                            <p class="text-xs text-zinc-500">Pilih modul dan fitur yang dapat diakses oleh peran ini.</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button"
                                    onclick="toggleAllPermissions(true)"
                                    class="text-xs font-semibold text-primary-600 dark:text-primary-400 hover:underline">
                                Pilih Semua
                            </button>
                            <span class="text-zinc-300 dark:text-zinc-700">|</span>
                            <button type="button"
                                    onclick="toggleAllPermissions(false)"
                                    class="text-xs font-medium text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300">
                                Hapus Pilihan
                            </button>
                        </div>
                    </div>

                    @error('permissions')
                        <p class="mb-3 text-xs text-rose-600 dark:text-rose-400 font-medium">{{ $message }}</p>
                    @enderror

                    <!-- Grouped Checkboxes -->
                    <div class="space-y-4">
                        @foreach ($groupedPermissions as $groupName => $groupPerms)
                            <div class="bg-zinc-50/70 dark:bg-zinc-800/40 border border-zinc-200/80 dark:border-zinc-800 rounded-xl p-4">
                                <div class="flex items-center justify-between pb-3 mb-3 border-b border-zinc-200/60 dark:border-zinc-700/60">
                                    <div class="flex items-center gap-2">
                                        <x-heroicon-o-shield-check class="w-4 h-4 text-primary-600 dark:text-primary-400" />
                                        <span class="text-xs font-bold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider">{{ $groupName }}</span>
                                    </div>
                                    <button type="button"
                                            onclick="toggleGroupPermissions('group-{{ Str::slug($groupName) }}')"
                                            class="text-[11px] font-medium text-zinc-500 hover:text-primary-600 dark:hover:text-primary-400">
                                        Pilih Modul Ini
                                    </button>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 group-{{ Str::slug($groupName) }}">
                                    @foreach ($groupPerms as $perm)
                                        <label class="flex items-start gap-2.5 p-2 rounded-lg hover:bg-white dark:hover:bg-zinc-800 transition-colors cursor-pointer select-none">
                                            <input type="checkbox"
                                                   name="permissions[]"
                                                   value="{{ $perm->name }}"
                                                   {{ in_array($perm->name, old('permissions', [])) ? 'checked' : '' }}
                                                   class="perm-checkbox mt-0.5 rounded border-zinc-300 dark:border-zinc-700 text-primary-600 focus:ring-primary-500/20">
                                            <div class="text-xs">
                                                <p class="font-medium text-zinc-900 dark:text-zinc-100 font-mono">{{ $perm->name }}</p>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="px-6 py-4 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-100 dark:border-zinc-800 flex items-center justify-end gap-3">
                <a href="{{ route('roles.index') }}" class="px-4 py-2 text-xs font-semibold text-zinc-700 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-white rounded-xl hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold rounded-xl bg-primary-600 hover:bg-primary-700 text-white shadow-xs transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 cursor-pointer">
                    <x-heroicon-o-check class="w-4 h-4" />
                    <span>Simpan Role</span>
                </button>
            </div>
        </form>
    </div>

    <script>
        function toggleAllPermissions(checked) {
            document.querySelectorAll('.perm-checkbox').forEach(cb => cb.checked = checked);
        }

        function toggleGroupPermissions(groupClass) {
            const checkboxes = document.querySelectorAll('.' + groupClass + ' .perm-checkbox');
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            checkboxes.forEach(cb => cb.checked = !allChecked);
        }
    </script>
</x-app-layout>
