<x-guest-layout title="Daftar Akun">
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-primary-600 text-white font-bold text-lg shadow-sm mb-3 transition-colors">
            <img src="{{ asset('assets/icon/laravel-white.svg') }}" alt="Flux Starter" class="w-full h-full object-contain" />
        </div>
        <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">
            Daftar Akun Baru
        </h1>
        <p class="text-xs text-zinc-500 mt-1">
            Mulai kelola data dengan starter kit bergaya Flux UI
        </p>
    </div>

    <div class="relative bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 shadow-xl shadow-zinc-950/5">
        <!-- Floating Theme Trigger -->
        <button type="button"
                onclick="window.openThemeCustomizer()"
                class="absolute top-4 right-4 p-1.5 rounded-lg text-zinc-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors"
                title="Pilih Tema Warna">
            <x-heroicon-o-swatch class="w-4 h-4" />
        </button>

        <form method="POST" action="{{ route('register.store') }}" class="space-y-4">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-xs font-semibold text-zinc-700 dark:text-zinc-300 uppercase tracking-wider mb-1.5">
                    Nama Lengkap
                </label>
                <input id="name"
                       type="text"
                       name="name"
                       value="{{ old('name') }}"
                       required
                       autofocus
                       autocomplete="name"
                       placeholder="John Doe"
                       class="w-full px-3.5 py-2.5 text-sm rounded-xl border {{ $errors->has('name') ? 'border-rose-300 bg-rose-50/20 text-rose-900 focus:border-rose-500 focus:ring-rose-200' : 'border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-primary-500/20' }} focus:outline-none focus:ring-2 transition-colors">
                @error('name')
                    <p class="mt-1.5 text-xs text-rose-600 dark:text-rose-400 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-semibold text-zinc-700 dark:text-zinc-300 uppercase tracking-wider mb-1.5">
                    Alamat Email
                </label>
                <input id="email"
                       type="email"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       autocomplete="email"
                       placeholder="nama@perusahaan.com"
                       class="w-full px-3.5 py-2.5 text-sm rounded-xl border {{ $errors->has('email') ? 'border-rose-300 bg-rose-50/20 text-rose-900 focus:border-rose-500 focus:ring-rose-200' : 'border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-primary-500/20' }} focus:outline-none focus:ring-2 transition-colors">
                @error('email')
                    <p class="mt-1.5 text-xs text-rose-600 dark:text-rose-400 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-xs font-semibold text-zinc-700 dark:text-zinc-300 uppercase tracking-wider mb-1.5">
                    Kata Sandi
                </label>
                <input id="password"
                       type="password"
                       name="password"
                       required
                       autocomplete="new-password"
                       placeholder="Minimal 8 karakter"
                       class="w-full px-3.5 py-2.5 text-sm rounded-xl border {{ $errors->has('password') ? 'border-rose-300 bg-rose-50/20 text-rose-900 focus:border-rose-500 focus:ring-rose-200' : 'border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-primary-500/20' }} focus:outline-none focus:ring-2 transition-colors">
                @error('password')
                    <p class="mt-1.5 text-xs text-rose-600 dark:text-rose-400 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Confirmation -->
            <div>
                <label for="password_confirmation" class="block text-xs font-semibold text-zinc-700 dark:text-zinc-300 uppercase tracking-wider mb-1.5">
                    Konfirmasi Kata Sandi
                </label>
                <input id="password_confirmation"
                       type="password"
                       name="password_confirmation"
                       required
                       autocomplete="new-password"
                       placeholder="Ulangi kata sandi"
                       class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:border-primary-500 dark:focus:border-primary-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 transition-colors">
            </div>

            <!-- Submit Button -->
            <button type="submit"
                    class="w-full mt-2 py-2.5 px-4 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-semibold text-sm shadow-xs focus:outline-none focus:ring-2 focus:ring-primary-500 transition-colors cursor-pointer">
                Daftar Sekarang
            </button>
        </form>

        <div class="mt-6 border-t border-zinc-100 dark:border-zinc-800 text-[11px] text-zinc-500 bg-zinc-50 dark:bg-zinc-800/50 -mx-6 -mb-6 p-4 rounded-b-2xl">
            <div class="flex items-center justify-center gap-2">
                <span>Sudah punya akun?</span>
                <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-700 font-semibold">Masuk</a>
            </div>
        </div>
    </div>
</x-guest-layout>
