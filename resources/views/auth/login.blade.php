<x-guest-layout title="Masuk">
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-primary-600 text-white font-bold text-lg shadow-sm mb-3 transition-colors">
            FX
        </div>
        <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">
            Masuk ke Akun Anda
        </h1>
        <p class="text-xs text-zinc-500 mt-1">
            Laravel Dashboard Starter Kit (Flux-Inspired UI)
        </p>
    </div>

    <div class="relative bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 shadow-xl shadow-zinc-950/5">
        <!-- Floating Theme Trigger in Login -->
        <button type="button"
                onclick="window.openThemeCustomizer()"
                class="absolute top-4 right-4 p-1.5 rounded-lg text-zinc-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors"
                title="Pilih Tema Warna">
            <x-heroicon-o-swatch class="w-4 h-4" />
        </button>

        <form method="POST" action="{{ route('login.store') }}" class="space-y-4">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-semibold text-zinc-700 dark:text-zinc-300 uppercase tracking-wider mb-1.5">
                    Alamat Email
                </label>
                <input id="email"
                       type="email"
                       name="email"
                       value="{{ old('email', 'admin@example.com') }}"
                       required
                       autofocus
                       autocomplete="username"
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
                       value="password"
                       required
                       autocomplete="current-password"
                       placeholder="••••••••"
                       class="w-full px-3.5 py-2.5 text-sm rounded-xl border {{ $errors->has('password') ? 'border-rose-300 bg-rose-50/20 text-rose-900 focus:border-rose-500 focus:ring-rose-200' : 'border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-primary-500/20' }} focus:outline-none focus:ring-2 transition-colors">
                @error('password')
                    <p class="mt-1.5 text-xs text-rose-600 dark:text-rose-400 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center gap-2 cursor-pointer select-none">
                    <input type="checkbox"
                           name="remember"
                           class="w-4 h-4 rounded-md border-zinc-300 dark:border-zinc-700 text-primary-600 focus:ring-primary-500">
                    <span class="text-zinc-600 dark:text-zinc-400">Ingat sesi saya</span>
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                    class="w-full mt-2 py-2.5 px-4 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-semibold text-sm shadow-xs focus:outline-none focus:ring-2 focus:ring-primary-500 transition-colors">
                Masuk ke Dashboard
            </button>
        </form>

        <!-- Dev Hint Box -->
        <div class="mt-6 pt-5 border-t border-zinc-100 dark:border-zinc-800 text-[11px] text-zinc-500 bg-zinc-50 dark:bg-zinc-800/50 -mx-6 -mb-6 p-4 rounded-b-2xl">
            <p class="font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Kredensial Default (Development):</p>
            <p>Email: <code class="text-zinc-900 dark:text-zinc-100 font-mono font-medium">admin@example.com</code></p>
            <p>Password: <code class="text-zinc-900 dark:text-zinc-100 font-mono font-medium">password</code></p>
        </div>
    </div>
</x-guest-layout>
