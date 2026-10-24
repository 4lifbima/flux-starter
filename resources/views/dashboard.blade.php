<x-app-layout title="Dashboard" :breadcrumbs="[['label' => 'Dashboard']]">
    <!-- Header Page -->
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">
                Dashboard Overview
            </h1>
        </div>
        <div class="mt-4 sm:mt-0 flex flex-wrap items-center gap-2.5">
            <a href="{{ route('tables.create') }}" class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-semibold rounded-md border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-200 hover:bg-zinc-50 dark:hover:bg-zinc-700/50 shadow-2xs transition-colors">
                <x-heroicon-o-plus class="w-4 h-4 text-zinc-500" />
                <span>Tambah Table</span>
            </a>
            <a href="{{ route('users.create') }}" class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-semibold rounded-md bg-primary-600 hover:bg-primary-700 text-white shadow-xs transition-colors dark:text-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500">
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
                <span class="p-3 rounded-md bg-primary-50 dark:bg-primary-950/40 text-primary-600 dark:text-primary-400">
                    <x-heroicon-o-table-cells class="w-6 h-6" />
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
                <span class="p-3 rounded-md bg-primary-50 dark:bg-primary-950/40 text-primary-600 dark:text-primary-400">
                    <x-heroicon-o-check-circle class="w-6 h-6" />
                </span>
            </div>
            <div class="mt-4 flex items-baseline justify-between">
                <span class="text-3xl font-bold tracking-tight text-primary-600 dark:text-primary-400">{{ $activeTables }}</span>
                <span class="text-xs text-zinc-400 font-medium">Status Berjalan</span>
            </div>
        </div>

        <!-- Card 3: Inactive Tables -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 rounded-xl p-5 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-zinc-500 uppercase tracking-wider">Tables Nonaktif</span>
                <span class="p-3 rounded-md bg-primary-50 dark:bg-primary-950/40 text-primary-600 dark:text-primary-400">
                    <x-heroicon-o-exclamation-circle class="w-6 h-6" />
                </span>
            </div>
            <div class="mt-4 flex items-baseline justify-between">
                <span class="text-3xl font-bold tracking-tight text-primary-600 dark:text-primary-400">{{ $inactiveTables }}</span>
                <span class="text-xs text-zinc-400 font-medium">Diarsipkan</span>
            </div>
        </div>

        <!-- Card 4: Total Users -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 rounded-xl p-5 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-zinc-500 uppercase tracking-wider">Total Users</span>
                <span class="p-3 rounded-md bg-primary-50 dark:bg-primary-950/40 text-primary-600 dark:text-primary-400">
                    <x-heroicon-o-users class="w-6 h-6" />
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

    <!-- ApexCharts 2 Columns Grid: Basic Area (7) & Simple Donut (5) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-8">
        <!-- Kolom 1: Basic Area in JavaScript (7 Kolom) -->
        <div class="lg:col-span-7 bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 rounded-xl p-5 shadow-2xs flex flex-col justify-between">
            <div id="basic-area-chart" class="w-full min-h-[350px]"></div>
        </div>

        <!-- Kolom 2: Simple Donut in JavaScript (5 Kolom) -->
        <div class="lg:col-span-5 bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 rounded-xl p-5 shadow-2xs flex flex-col justify-between overflow-hidden">
            <span class="sr-only">Simple Donut in JavaScript</span>
            <div id="simple-donut-chart" class="w-full min-h-[350px] flex items-center justify-center"></div>
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
                    <p class="text-xs text-zinc-500">Akun pengguna sistem yang baru dibuat beserta role Spatie.</p>
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
                                <div class="flex items-center gap-2">
                                    <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100 truncate">
                                        {{ $user->name }}
                                    </p>
                                    @php
                                        $primaryRole = $user->roles->first()?->name ?? 'user';
                                    @endphp
                                    <span class="inline-flex items-center px-1.5 py-0.2 rounded text-[10px] font-semibold uppercase tracking-wider
                                        @if($primaryRole === 'admin') bg-rose-50 text-rose-700 dark:bg-rose-950/40 dark:text-rose-400 border border-rose-200 dark:border-rose-800/60
                                        @elseif($primaryRole === 'manager') bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:text-amber-400 border border-amber-200 dark:border-amber-800/60
                                        @else bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700 @endif">
                                        {{ $primaryRole }}
                                    </span>
                                </div>
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

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const primaryColorMap = {
                orange: '#ea580c',
                indigo: '#4f46e5',
                rose: '#e11d48',
                emerald: '#059669',
                amber: '#d97706',
                sky: '#0284c7',
                purple: '#9333ea',
                neutral: '#52525b'
            };

            function getCurrentPrimaryHex() {
                const primary = document.documentElement.getAttribute('data-primary') || 'orange';
                return primaryColorMap[primary] || '#ea580c';
            }

            function isDarkMode() {
                return document.documentElement.classList.contains('dark');
            }

            const areaCategories = @json($areaCategories ?? []);
            const areaSeries = @json($areaSeries ?? []);
            const donutLabels = @json($donutLabels ?? []);
            const donutSeries = @json($donutSeries ?? []);

            function initCharts() {
                if (typeof ApexCharts === 'undefined') {
                    setTimeout(initCharts, 60);
                    return;
                }

                const dark = isDarkMode();
                const primaryHex = getCurrentPrimaryHex();

                // 1. Basic Area in JavaScript Configuration
                const areaOptions = {
                    series: areaSeries,
                    chart: {
                        type: 'area',
                        height: 350,
                        zoom: { enabled: false },
                        toolbar: { show: false },
                        fontFamily: 'Instrument Sans, sans-serif',
                        background: 'transparent'
                    },
                    dataLabels: { enabled: false },
                    stroke: {
                        curve: 'straight',
                        width: 2
                    },
                    title: {
                        text: 'Basic Area in JavaScript',
                        align: 'left',
                        style: {
                            fontSize: '14px',
                            fontWeight: 600,
                            fontFamily: 'Instrument Sans, sans-serif',
                            color: dark ? '#f4f4f5' : '#18181b'
                        }
                    },
                    subtitle: {
                        text: 'Tren pertumbuhan aktivitas & rekapitulasi data',
                        align: 'left',
                        style: {
                            fontSize: '12px',
                            fontFamily: 'Instrument Sans, sans-serif',
                            color: dark ? '#a1a1aa' : '#71717a'
                        }
                    },
                    labels: areaCategories,
                    xaxis: {
                        type: 'category',
                        labels: {
                            style: {
                                colors: dark ? '#a1a1aa' : '#71717a',
                                fontFamily: 'Instrument Sans, sans-serif'
                            }
                        },
                        axisBorder: { show: false },
                        axisTicks: { show: false }
                    },
                    yaxis: {
                        opposite: false,
                        labels: {
                            style: {
                                colors: dark ? '#a1a1aa' : '#71717a',
                                fontFamily: 'Instrument Sans, sans-serif'
                            }
                        }
                    },
                    grid: {
                        borderColor: dark ? '#27272a' : '#f4f4f5',
                        strokeDashArray: 4
                    },
                    colors: [primaryHex],
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.45,
                            opacityTo: 0.05,
                            stops: [0, 90, 100]
                        }
                    },
                    theme: {
                        mode: dark ? 'dark' : 'light'
                    },
                    tooltip: {
                        theme: dark ? 'dark' : 'light',
                        y: {
                            formatter: function (val) {
                                return val + " records";
                            }
                        }
                    }
                };

                const areaChartEl = document.querySelector("#basic-area-chart");
                let areaChart = null;
                if (areaChartEl) {
                    areaChartEl.innerHTML = '';
                    areaChart = new ApexCharts(areaChartEl, areaOptions);
                    areaChart.render();
                }

                // 2. Simple Donut in JavaScript Configuration (Revenue by Region with External Labels)
                const donutOptions = {
                    series: [54, 41, 38, 16, 12],
                    chart: {
                        width: 440,
                        type: 'donut',
                        fontFamily: 'Instrument Sans, sans-serif',
                        background: 'transparent'
                    },
                    labels: [
                        'North America',
                        'Europe',
                        'Asia Pacific',
                        'Latin America',
                        'Middle East',
                    ],
                    title: {
                        text: 'Revenue by Region ($M)',
                        align: 'center',
                        style: {
                            fontSize: '15px',
                            fontWeight: 700,
                            fontFamily: 'Instrument Sans, sans-serif',
                            color: dark ? '#f4f4f5' : '#18181b'
                        }
                    },
                    colors: ['#008ffb', '#00b074', '#c87a08', '#ff4560', '#775dd0'],
                    legend: {
                        show: false,
                    },
                    stroke: {
                        show: true,
                        colors: dark ? ['#18181b'] : ['#ffffff'],
                        width: 2
                    },
                    plotOptions: {
                        pie: {
                            dataLabels: {
                                external: {
                                    show: true,
                                    color: dark ? '#e4e4e7' : '#27272a',
                                    fontWeight: 600,
                                    connector: {
                                        show: true,
                                    }
                                },
                            },
                        },
                    },
                    theme: {
                        mode: dark ? 'dark' : 'light'
                    },
                    responsive: [
                        {
                            breakpoint: 1366,
                            options: {
                                chart: {
                                    width: 380,
                                },
                            },
                        },
                        {
                            breakpoint: 480,
                            options: {
                                chart: {
                                    width: 320,
                                },
                            },
                        },
                    ],
                };

                const donutChartEl = document.querySelector("#simple-donut-chart");
                let donutChart = null;
                if (donutChartEl) {
                    donutChartEl.innerHTML = '';
                    donutChart = new ApexCharts(donutChartEl, donutOptions);
                    donutChart.render();
                }

                // Dynamic theme change listener
                window.addEventListener('flux-theme-changed', function (e) {
                    const isDark = e.detail.mode === 'dark';
                    const primaryColor = primaryColorMap[e.detail.primary] || '#ea580c';

                    if (areaChart) {
                        areaChart.updateOptions({
                            theme: { mode: isDark ? 'dark' : 'light' },
                            colors: [primaryColor],
                            grid: { borderColor: isDark ? '#27272a' : '#f4f4f5' },
                            xaxis: {
                                labels: { style: { colors: isDark ? '#a1a1aa' : '#71717a' } }
                            },
                            yaxis: {
                                labels: { style: { colors: isDark ? '#a1a1aa' : '#71717a' } }
                            },
                            title: {
                                style: { color: isDark ? '#f4f4f5' : '#18181b' }
                            },
                            subtitle: {
                                style: { color: isDark ? '#a1a1aa' : '#71717a' }
                            }
                        });
                    }

                    if (donutChart) {
                        donutChart.updateOptions({
                            theme: { mode: isDark ? 'dark' : 'light' },
                            stroke: { colors: isDark ? ['#18181b'] : ['#ffffff'] },
                            title: {
                                style: { color: isDark ? '#f4f4f5' : '#18181b' }
                            },
                            plotOptions: {
                                pie: {
                                    dataLabels: {
                                        external: {
                                            show: true,
                                            color: isDark ? '#e4e4e7' : '#27272a'
                                        }
                                    }
                                }
                            }
                        });
                    }
                });
            }

            initCharts();
        });
    </script>
    @endpush
</x-app-layout>
