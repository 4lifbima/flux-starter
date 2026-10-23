<x-app-layout title="Dashboard" :breadcrumbs="[['label' => 'Dashboard']]">
    <!-- Header Page -->
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">
                Dashboard Overview
            </h1>
            <p class="mt-1 text-sm text-zinc-500">
                Selamat datang di starter kit dashboard Laravel dengan antarmuka bergaya Flux UI.
            </p>
        </div>
        <div class="mt-4 sm:mt-0 flex gap-2.5">
            <a href="{{ route('tables.create') }}" class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-semibold rounded-xl border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-200 hover:bg-zinc-50 dark:hover:bg-zinc-700/50 shadow-2xs transition-colors">
                <svg class="w-4 h-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Table
            </a>
            <a href="{{ route('users.create') }}" class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-semibold rounded-xl bg-zinc-900 hover:bg-zinc-800 dark:bg-zinc-100 dark:hover:bg-zinc-200 text-white dark:text-zinc-900 shadow-xs transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                </svg>
                Tambah User
            </a>
        </div>
    </div>

    <!-- Stat Cards Grid -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <!-- Card 1: Total Tables -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 rounded-2xl p-5 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-zinc-500 uppercase tracking-wider">Total Tables</span>
                <span class="p-2 rounded-xl bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0 1 12 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M12 10.875v7.5m0-7.5a1.125 1.125 0 0 1 1.125-1.125h7.125" />
                    </svg>
                </span>
            </div>
            <div class="mt-4 flex items-baseline justify-between">
                <span class="text-3xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">{{ $totalTables }}</span>
                <a href="{{ route('tables.index') }}" class="text-xs font-semibold text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100 flex items-center gap-1 group">
                    Buka
                    <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Card 2: Active Tables -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 rounded-2xl p-5 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-zinc-500 uppercase tracking-wider">Tables Aktif</span>
                <span class="p-2 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </span>
            </div>
            <div class="mt-4 flex items-baseline justify-between">
                <span class="text-3xl font-bold tracking-tight text-emerald-600 dark:text-emerald-400">{{ $activeTables }}</span>
                <span class="text-xs text-zinc-400 font-medium">Status Berjalan</span>
            </div>
        </div>

        <!-- Card 3: Inactive Tables -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 rounded-2xl p-5 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-zinc-500 uppercase tracking-wider">Tables Nonaktif</span>
                <span class="p-2 rounded-xl bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 7.5h.008v.008H12v-.008Z" />
                    </svg>
                </span>
            </div>
            <div class="mt-4 flex items-baseline justify-between">
                <span class="text-3xl font-bold tracking-tight text-amber-600 dark:text-amber-400">{{ $inactiveTables }}</span>
                <span class="text-xs text-zinc-400 font-medium">Diarsipkan</span>
            </div>
        </div>

        <!-- Card 4: Total Users -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 rounded-2xl p-5 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-zinc-500 uppercase tracking-wider">Total Users</span>
                <span class="p-2 rounded-xl bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </span>
            </div>
            <div class="mt-4 flex items-baseline justify-between">
                <span class="text-3xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">{{ $totalUsers }}</span>
                <a href="{{ route('users.index') }}" class="text-xs font-semibold text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100 flex items-center gap-1 group">
                    Buka
                    <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Data Grids -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Tables Panel -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 rounded-2xl shadow-2xs overflow-hidden">
            <div class="p-5 border-b border-zinc-100 dark:border-zinc-800 flex items-center justify-between">
                <div>
                    <h2 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                        Data Tables Terbaru
                    </h2>
                    <p class="text-xs text-zinc-500">Record entitas demo yang baru ditambahkan.</p>
                </div>
                <a href="{{ route('tables.index') }}" class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">
                    Lihat Semua
                </a>
            </div>
            <div class="divide-y divide-zinc-100 dark:divide-zinc-800">
                @forelse ($recentTables as $table)
                    <div class="p-4 flex items-center justify-between hover:bg-zinc-50/50 dark:hover:bg-zinc-800/30 transition-colors">
                        <div class="min-w-0 pr-3">
                            <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100 truncate">
                                {{ $table->name }}
                            </p>
                            <p class="text-xs text-zinc-500 truncate">
                                {{ $table->description ?: 'Tanpa deskripsi' }}
                            </p>
                        </div>
                        <div class="flex items-center gap-3 flex-shrink-0">
                            @if ($table->status === 'active')
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-medium bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/60">
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-medium bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700">
                                    Nonaktif
                                </span>
                            @endif
                            <a href="{{ route('tables.edit', $table->id) }}" class="text-xs font-medium text-zinc-500 hover:text-zinc-900 dark:hover:text-zinc-200">
                                Edit
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-xs text-zinc-500">
                        Belum ada data tabel yang tersedia.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Users Panel -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 rounded-2xl shadow-2xs overflow-hidden">
            <div class="p-5 border-b border-zinc-100 dark:border-zinc-800 flex items-center justify-between">
                <div>
                    <h2 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                        Pengguna Terdaftar Terbaru
                    </h2>
                    <p class="text-xs text-zinc-500">Akun pengguna sistem yang baru dibuat.</p>
                </div>
                <a href="{{ route('users.index') }}" class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">
                    Lihat Semua
                </a>
            </div>
            <div class="divide-y divide-zinc-100 dark:divide-zinc-800">
                @forelse ($recentUsers as $user)
                    <div class="p-4 flex items-center justify-between hover:bg-zinc-50/50 dark:hover:bg-zinc-800/30 transition-colors">
                        <div class="flex items-center gap-3 min-w-0 pr-3">
                            <div class="w-8 h-8 rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 font-medium text-xs flex items-center justify-center flex-shrink-0 uppercase border border-zinc-200 dark:border-zinc-700">
                                {{ substr($user->name, 0, 2) }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100 truncate">
                                    {{ $user->name }}
                                </p>
                                <p class="text-xs text-zinc-500 truncate">
                                    {{ $user->email }}
                                </p>
                            </div>
                        </div>
                        <div class="text-xs text-zinc-400 flex-shrink-0">
                            {{ $user->created_at->diffForHumans() }}
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-xs text-zinc-500">
                        Belum ada pengguna terdaftar.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
