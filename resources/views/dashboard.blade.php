<x-app-layout title="Dashboard" :breadcrumbs="[['label' => 'Dashboard']]">
    <!-- Header Page -->
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">
                Dashboard Overview
            </h1>
            <p class="mt-1 text-sm text-zinc-500">
                Selamat datang di starter kit dashboard Laravel dengan antarmuka bergaya Flux UI dan tema dinamis.
            </p>
        </div>
        <div class="mt-4 sm:mt-0 flex flex-wrap items-center gap-2.5">
            <a href="{{ route('tables.create') }}" class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-semibold rounded-md border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-200 hover:bg-zinc-50 dark:hover:bg-zinc-700/50 shadow-2xs transition-colors">
                <x-heroicon-o-plus class="w-4 h-4 text-zinc-500" />
                <span>Tambah Table</span>
            </a>
            <a href="{{ route('users.create') }}" class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-semibold rounded-md bg-primary-600 hover:bg-primary-700 text-white shadow-xs transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500">
                <x-heroicon-o-user-plus class="w-4 h-4" />
                <span>Tambah User</span>
            </a>
        </div>
    </div>

    <!-- Stat Cards Grid -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <!-- Card 1: Total Tables -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 rounded-xl p-5 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-zinc-500 uppercase tracking-wider">Total Tables</span>
                <span class="p-2 rounded-xl bg-primary-50 dark:bg-primary-950/40 text-primary-600 dark:text-primary-400">
                    <x-heroicon-o-table-cells class="w-4 h-4" />
                </span>
            </div>
            <div class="mt-4 flex items-baseline justify-between">
                <span class="text-3xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">{{ $totalTables }}</span>
                <a href="{{ route('tables.index') }}" class="text-xs font-semibold text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 flex items-center gap-1 group">
                    Buka
                    <x-heroicon-o-arrow-right class="w-3.5 h-3.5 transition-transform group-hover:translate-x-0.5" />
                </a>
            </div>
        </div>

        <!-- Card 2: Active Tables -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 rounded-xl p-5 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-zinc-500 uppercase tracking-wider">Tables Aktif</span>
                <span class="p-2 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400">
                    <x-heroicon-o-check-circle class="w-4 h-4" />
                </span>
            </div>
            <div class="mt-4 flex items-baseline justify-between">
                <span class="text-3xl font-bold tracking-tight text-emerald-600 dark:text-emerald-400">{{ $activeTables }}</span>
                <span class="text-xs text-zinc-400 font-medium">Status Berjalan</span>
            </div>
        </div>

        <!-- Card 3: Inactive Tables -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 rounded-xl p-5 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-zinc-500 uppercase tracking-wider">Tables Nonaktif</span>
                <span class="p-2 rounded-xl bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400">
                    <x-heroicon-o-exclamation-circle class="w-4 h-4" />
                </span>
            </div>
            <div class="mt-4 flex items-baseline justify-between">
                <span class="text-3xl font-bold tracking-tight text-amber-600 dark:text-amber-400">{{ $inactiveTables }}</span>
                <span class="text-xs text-zinc-400 font-medium">Diarsipkan</span>
            </div>
        </div>

        <!-- Card 4: Total Users -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 rounded-xl p-5 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-zinc-500 uppercase tracking-wider">Total Users</span>
                <span class="p-2 rounded-xl bg-primary-50 dark:bg-primary-950/40 text-primary-600 dark:text-primary-400">
                    <x-heroicon-o-users class="w-4 h-4" />
                </span>
            </div>
            <div class="mt-4 flex items-baseline justify-between">
                <span class="text-3xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">{{ $totalUsers }}</span>
                <a href="{{ route('users.index') }}" class="text-xs font-semibold text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 flex items-center gap-1 group">
                    Buka
                    <x-heroicon-o-arrow-right class="w-3.5 h-3.5 transition-transform group-hover:translate-x-0.5" />
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Data Grids -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Tables Panel -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 rounded-xl shadow-2xs overflow-hidden">
            <div class="p-5 border-b border-zinc-100 dark:border-zinc-800 flex items-center justify-between">
                <div>
                    <h2 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                        Data Tables Terbaru
                    </h2>
                    <p class="text-xs text-zinc-500">Record entitas demo yang baru ditambahkan.</p>
                </div>
                <a href="{{ route('tables.index') }}" class="text-xs font-semibold text-primary-600 dark:text-primary-400 hover:underline">
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
                            <a href="{{ route('tables.edit', $table->id) }}"
                               title="Edit data"
                               aria-label="Edit data {{ $table->name }}"
                               class="p-1.5 rounded-lg text-zinc-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                                <x-heroicon-o-pencil-square class="w-4 h-4" />
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
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 rounded-xl shadow-2xs overflow-hidden">
            <div class="p-5 border-b border-zinc-100 dark:border-zinc-800 flex items-center justify-between">
                <div>
                    <h2 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                        Pengguna Terdaftar Terbaru
                    </h2>
                    <p class="text-xs text-zinc-500">Akun pengguna sistem yang baru dibuat.</p>
                </div>
                <a href="{{ route('users.index') }}" class="text-xs font-semibold text-primary-600 dark:text-primary-400 hover:underline">
                    Lihat Semua
                </a>
            </div>
            <div class="divide-y divide-zinc-100 dark:divide-zinc-800">
                @forelse ($recentUsers as $user)
                    <div class="p-4 flex items-center justify-between hover:bg-zinc-50/50 dark:hover:bg-zinc-800/30 transition-colors">
                        <div class="flex items-center gap-3 min-w-0 pr-3">
                            <div class="w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-950/60 text-primary-700 dark:text-primary-300 font-medium text-xs flex items-center justify-center flex-shrink-0 uppercase border border-primary-200 dark:border-primary-800">
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
