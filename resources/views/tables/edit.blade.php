<x-app-layout title="Edit Data Table" :breadcrumbs="[['label' => 'Tables', 'url' => route('tables.index')], ['label' => 'Edit Data']]">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">
                Edit Data Table
            </h1>
            <p class="mt-1 text-sm text-zinc-500">
                Perbarui informasi entitas data demo {{ $table->name }}.
            </p>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 rounded-xl p-6 sm:p-8 shadow-2xs">
            <form method="POST" action="{{ route('tables.update', $table->id) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-xs font-semibold text-zinc-700 dark:text-zinc-300 uppercase tracking-wider mb-2">
                        Nama Data <span class="text-rose-500">*</span>
                    </label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name', $table->name) }}"
                           required
                           maxlength="150"
                           placeholder="Contoh: Inventaris Kantor Cabang"
                           class="w-full px-3.5 py-2.5 text-sm rounded-xl border {{ $errors->has('name') ? 'border-rose-300 bg-rose-50/20 text-rose-900 focus:border-rose-500 focus:ring-rose-200' : 'border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-primary-500/20' }} focus:outline-none focus:ring-2 transition-colors">
                    @error('name')
                        <p class="mt-1.5 text-xs text-rose-600 dark:text-rose-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description Field -->
                <div>
                    <label for="description" class="block text-xs font-semibold text-zinc-700 dark:text-zinc-300 uppercase tracking-wider mb-2">
                        Deskripsi
                    </label>
                    <textarea id="description"
                              name="description"
                              rows="4"
                              placeholder="Keterangan singkat mengenai data ini (opsional)..."
                              class="w-full px-3.5 py-2.5 text-sm rounded-xl border {{ $errors->has('description') ? 'border-rose-300 bg-rose-50/20 text-rose-900 focus:border-rose-500 focus:ring-rose-200' : 'border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-primary-500/20' }} focus:outline-none focus:ring-2 transition-colors">{{ old('description', $table->description) }}</textarea>
                    @error('description')
                        <p class="mt-1.5 text-xs text-rose-600 dark:text-rose-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Field -->
                <div>
                    <label for="status" class="block text-xs font-semibold text-zinc-700 dark:text-zinc-300 uppercase tracking-wider mb-2">
                        Status <span class="text-rose-500">*</span>
                    </label>
                    <select id="status"
                            name="status"
                            class="w-full px-3.5 py-2.5 text-sm rounded-xl border {{ $errors->has('status') ? 'border-rose-300 bg-rose-50/20 text-rose-900 focus:border-rose-500 focus:ring-rose-200' : 'border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-primary-500/20' }} focus:outline-none focus:ring-2 transition-colors">
                        <option value="active" {{ old('status', $table->status) === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('status', $table->status) === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('status')
                        <p class="mt-1.5 text-xs text-rose-600 dark:text-rose-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="pt-4 border-t border-zinc-100 dark:border-zinc-800 flex items-center justify-end gap-3">
                    <a href="{{ route('tables.index') }}"
                       class="px-4 py-2.5 text-sm font-medium rounded-xl border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-200 hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-5 py-2.5 text-sm font-semibold rounded-xl bg-primary-600 hover:bg-primary-700 text-white shadow-xs focus:outline-none focus:ring-2 focus:ring-primary-500 transition-colors">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
