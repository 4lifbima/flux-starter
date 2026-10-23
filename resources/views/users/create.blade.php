<x-app-layout title="Tambah Pengguna" :breadcrumbs="[['label' => 'Users', 'url' => route('users.index')], ['label' => 'Tambah Pengguna']]">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">
                Tambah Pengguna Baru
            </h1>
            <p class="mt-1 text-sm text-zinc-500">
                Buat akun pengguna baru dengan kredensial akses yang aman.
            </p>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 rounded-2xl p-6 sm:p-8 shadow-2xs">
            <form method="POST" action="{{ route('users.store') }}" class="space-y-6">
                @csrf

                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-xs font-semibold text-zinc-700 dark:text-zinc-300 uppercase tracking-wider mb-2">
                        Nama Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name') }}"
                           required
                           placeholder="Contoh: Budi Santoso"
                           class="w-full px-3.5 py-2.5 text-sm rounded-xl border {{ $errors->has('name') ? 'border-rose-300 bg-rose-50/20 text-rose-900 focus:border-rose-500 focus:ring-rose-200' : 'border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-primary-500/20' }} focus:outline-none focus:ring-2 transition-colors">
                    @error('name')
                        <p class="mt-1.5 text-xs text-rose-600 dark:text-rose-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-xs font-semibold text-zinc-700 dark:text-zinc-300 uppercase tracking-wider mb-2">
                        Alamat Email <span class="text-rose-500">*</span>
                    </label>
                    <input type="email"
                           id="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           placeholder="budi@perusahaan.com"
                           class="w-full px-3.5 py-2.5 text-sm rounded-xl border {{ $errors->has('email') ? 'border-rose-300 bg-rose-50/20 text-rose-900 focus:border-rose-500 focus:ring-rose-200' : 'border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-primary-500/20' }} focus:outline-none focus:ring-2 transition-colors">
                    @error('email')
                        <p class="mt-1.5 text-xs text-rose-600 dark:text-rose-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-xs font-semibold text-zinc-700 dark:text-zinc-300 uppercase tracking-wider mb-2">
                        Kata Sandi <span class="text-rose-500">*</span>
                    </label>
                    <input type="password"
                           id="password"
                           name="password"
                           required
                           autocomplete="new-password"
                           placeholder="Minimal 8 karakter"
                           class="w-full px-3.5 py-2.5 text-sm rounded-xl border {{ $errors->has('password') ? 'border-rose-300 bg-rose-50/20 text-rose-900 focus:border-rose-500 focus:ring-rose-200' : 'border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-primary-500/20' }} focus:outline-none focus:ring-2 transition-colors">
                    @error('password')
                        <p class="mt-1.5 text-xs text-rose-600 dark:text-rose-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Confirmation Field -->
                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold text-zinc-700 dark:text-zinc-300 uppercase tracking-wider mb-2">
                        Konfirmasi Kata Sandi <span class="text-rose-500">*</span>
                    </label>
                    <input type="password"
                           id="password_confirmation"
                           name="password_confirmation"
                           required
                           autocomplete="new-password"
                           placeholder="Ulangi kata sandi"
                           class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:border-primary-500 dark:focus:border-primary-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 transition-colors">
                </div>

                <!-- Actions -->
                <div class="pt-4 border-t border-zinc-100 dark:border-zinc-800 flex items-center justify-end gap-3">
                    <a href="{{ route('users.index') }}"
                       class="px-4 py-2.5 text-sm font-medium rounded-xl border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-200 hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-5 py-2.5 text-sm font-semibold rounded-xl bg-primary-600 hover:bg-primary-700 text-white shadow-xs focus:outline-none focus:ring-2 focus:ring-primary-500 transition-colors">
                        Simpan Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
