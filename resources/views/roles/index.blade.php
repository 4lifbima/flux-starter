<x-app-layout title="Roles & Permissions" :breadcrumbs="[['label' => 'Roles & Permissions']]">
    <!-- Header Page -->
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">
                Roles & Permissions
            </h1>
            <p class="mt-1 text-sm text-zinc-500">
                Kelola peran pengguna (Roles) dan hak akses (Permissions) Spatie dengan proteksi sistem dan pencarian interaktif.
            </p>
        </div>
        <div class="mt-4 sm:mt-0 flex items-center gap-2.5">
            <a href="{{ route('roles.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold rounded-xl bg-primary-600 hover:bg-primary-700 text-white shadow-xs transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500">
                <x-heroicon-o-plus class="w-4 h-4" />
                <span>Tambah Role</span>
            </a>
        </div>
    </div>

    <!-- Filter & Search Toolbar (Instant Reactive Search) -->
    <div class="bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 rounded-xl p-4 mb-5 shadow-2xs">
        <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
            <!-- Left: Real-time Live Search Input -->
            <div class="relative flex-1 max-w-md">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-zinc-400">
                    <span id="role-search-idle-icon">
                        <x-heroicon-o-magnifying-glass class="w-4 h-4" />
                    </span>
                    <span id="role-search-loading-icon" class="hidden">
                        <svg class="animate-spin w-4 h-4 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                    </span>
                </div>

                <input type="text"
                       id="role-search-input"
                       value="{{ $search }}"
                       oninput="window.roleFilter.onSearchInput(this.value)"
                       autocomplete="off"
                       placeholder="Cari nama role atau permission..."
                       class="w-full pl-10 pr-10 py-2 text-sm rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50/50 dark:bg-zinc-800/50 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:bg-white dark:focus:bg-zinc-800 focus:border-primary-500 dark:focus:border-primary-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 transition-colors">

                <!-- Clear Search Input button -->
                <button type="button"
                        id="role-search-clear-btn"
                        onclick="window.roleFilter.clearSearch()"
                        class="{{ $search !== '' ? '' : 'hidden' }} absolute inset-y-0 right-0 pr-3 flex items-center text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
                    <x-heroicon-o-x-mark class="w-4 h-4" />
                </button>
            </div>

            <!-- Right: Per Page & Reset -->
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2">
                    <label for="role-per-page-select" class="text-xs font-medium text-zinc-500 whitespace-nowrap">Baris:</label>
                    <select id="role-per-page-select"
                            onchange="window.roleFilter.onPerPageChange(this.value)"
                            class="px-2.5 py-2 text-xs font-medium rounded-xl border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                        @foreach ($allowedPerPage as $opt)
                            <option value="{{ $opt }}" {{ $perPage === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Reset Button -->
                <button type="button"
                        id="role-reset-btn"
                        onclick="window.roleFilter.reset()"
                        class="{{ $search !== '' ? '' : 'hidden' }} p-2 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-xl transition-colors"
                        title="Reset pencarian">
                    <x-heroicon-o-x-mark class="w-4 h-4" />
                </button>
            </div>
        </div>
    </div>

    <!-- Data Table Container (Dynamically Swapped via AJAX) -->
    <div id="role-content-area" class="bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 rounded-xl shadow-2xs overflow-hidden transition-opacity duration-150 mb-8">
        @include('roles._table')
    </div>

    <!-- Permissions Management Panel -->
    <div class="bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 rounded-xl p-5 shadow-2xs">
        <div class="sm:flex sm:items-center sm:justify-between pb-4 border-b border-zinc-100 dark:border-zinc-800 mb-5">
            <div>
                <h2 class="text-base font-semibold text-zinc-900 dark:text-zinc-100 flex items-center gap-2">
                    <x-heroicon-o-key class="w-5 h-5 text-primary-600 dark:text-primary-400" />
                    <span>Daftar Hak Akses (Permissions)</span>
                </h2>
                <p class="text-xs text-zinc-500 mt-0.5">
                    Total {{ $permissions->count() }} permission terdaftar dalam database guard web.
                </p>
            </div>

            <!-- Inline Form: Tambah Permission Baru -->
            <form action="{{ route('permissions.store') }}" method="POST" class="mt-3 sm:mt-0 flex items-center gap-2">
                @csrf
                <div class="relative">
                    <input type="text"
                           name="name"
                           required
                           placeholder="Contoh: export-data"
                           class="w-48 sm:w-56 px-3 py-1.5 text-xs rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                </div>
                <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg bg-zinc-800 hover:bg-zinc-900 dark:bg-zinc-700 dark:hover:bg-zinc-600 text-white transition-colors cursor-pointer">
                    <x-heroicon-o-plus class="w-3.5 h-3.5" />
                    <span>Tambah Permission</span>
                </button>
            </form>
        </div>

        <!-- Permissions Badges List -->
        <div class="flex flex-wrap items-center gap-2">
            @php
                $protectedPerms = ['view-tables', 'create-tables', 'edit-tables', 'delete-tables', 'view-users', 'create-users', 'edit-users', 'delete-users', 'manage-roles'];
            @endphp
            @forelse ($permissions as $perm)
                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-zinc-50 dark:bg-zinc-800/70 text-zinc-800 dark:text-zinc-200 border border-zinc-200 dark:border-zinc-700 group">
                    <x-heroicon-o-check class="w-3.5 h-3.5 text-primary-600 dark:text-primary-400" />
                    <span>{{ $perm->name }}</span>
                    @if (in_array($perm->name, $protectedPerms, true))
                        <span class="text-[10px] text-zinc-400 font-semibold px-1 rounded bg-zinc-200/60 dark:bg-zinc-700/60 ml-0.5" title="Permission bawaan sistem">sistem</span>
                    @else
                        <button type="button"
                                title="Hapus permission {{ $perm->name }}"
                                onclick="window.openConfirmModal({
                                    title: 'Hapus Permission',
                                    message: 'Apakah Anda yakin ingin menghapus permission \'{{ $perm->name }}\'?',
                                    action: '{{ route('permissions.destroy', $perm->id) }}',
                                    method: 'DELETE',
                                    confirmText: 'Hapus Permission'
                                })"
                                class="ml-1 text-zinc-400 hover:text-rose-600 dark:hover:text-rose-400 transition-colors cursor-pointer">
                            <x-heroicon-o-x-mark class="w-3.5 h-3.5" />
                        </button>
                    @endif
                </div>
            @empty
                <p class="text-xs text-zinc-400 italic">Belum ada permission yang terdaftar.</p>
            @endforelse
        </div>
    </div>

    <!-- Live AJAX Controller Script for Roles -->
    <script>
        (function () {
            let debounceTimer = null;
            let currentRequest = null;

            window.roleFilter = {
                state: {
                    search: @json($search),
                    sort: @json($sort),
                    direction: @json($direction),
                    per_page: @json($perPage),
                    page: 1
                },

                onSearchInput(value) {
                    this.state.search = value.trim();
                    this.state.page = 1;
                    this.updateUI();

                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => {
                        this.fetchData();
                    }, 250);
                },

                clearSearch() {
                    const input = document.getElementById('role-search-input');
                    if (input) input.value = '';
                    this.state.search = '';
                    this.state.page = 1;
                    this.updateUI();
                    this.fetchData();
                },

                onPerPageChange(value) {
                    this.state.per_page = parseInt(value, 10);
                    this.state.page = 1;
                    this.fetchData();
                },

                sort(column) {
                    if (this.state.sort === column) {
                        this.state.direction = this.state.direction === 'asc' ? 'desc' : 'asc';
                    } else {
                        this.state.sort = column;
                        this.state.direction = 'asc';
                    }
                    this.state.page = 1;
                    this.fetchData();
                },

                paginate(page) {
                    this.state.page = page;
                    this.fetchData();
                },

                reset() {
                    this.clearSearch();
                },

                updateUI() {
                    const clearBtn = document.getElementById('role-search-clear-btn');
                    const resetBtn = document.getElementById('role-reset-btn');
                    const isSearching = this.state.search !== '';

                    if (clearBtn) clearBtn.classList.toggle('hidden', !isSearching);
                    if (resetBtn) resetBtn.classList.toggle('hidden', !isSearching);
                },

                setLoading(loading) {
                    const idleIcon = document.getElementById('role-search-idle-icon');
                    const loadingIcon = document.getElementById('role-search-loading-icon');
                    const container = document.getElementById('role-content-area');

                    if (idleIcon && loadingIcon) {
                        idleIcon.classList.toggle('hidden', loading);
                        loadingIcon.classList.toggle('hidden', !loading);
                    }

                    if (container) {
                        if (loading) {
                            container.classList.add('opacity-50', 'pointer-events-none');
                        } else {
                            container.classList.remove('opacity-50', 'pointer-events-none');
                        }
                    }
                },

                async fetchData() {
                    this.setLoading(true);

                    if (currentRequest) {
                        currentRequest.abort();
                    }

                    const controller = new AbortController();
                    currentRequest = controller;

                    const params = new URLSearchParams({
                        search: this.state.search,
                        sort: this.state.sort,
                        direction: this.state.direction,
                        per_page: this.state.per_page,
                        page: this.state.page
                    });

                    // Update browser URL without reloading
                    const newUrl = `${window.location.pathname}?${params.toString()}`;
                    window.history.replaceState({}, '', newUrl);

                    try {
                        const response = await fetch(`${window.location.pathname}?${params.toString()}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'text/html'
                            },
                            signal: controller.signal
                        });

                        if (!response.ok) throw new Error('Network error');

                        const html = await response.text();
                        const container = document.getElementById('role-content-area');
                        if (container) {
                            container.innerHTML = html;
                        }
                    } catch (error) {
                        if (error.name !== 'AbortError') {
                            console.error('Failed to fetch role data:', error);
                        }
                    } finally {
                        this.setLoading(false);
                        currentRequest = null;
                    }
                }
            };

            // Intercept pagination clicks within table container
            document.addEventListener('click', function (e) {
                const target = e.target.closest('#role-content-area a');
                if (target && target.href) {
                    try {
                        const url = new URL(target.href);
                        const page = url.searchParams.get('page');
                        if (page) {
                            e.preventDefault();
                            window.roleFilter.paginate(page);
                        }
                    } catch (err) {}
                }
            });
        })();
    </script>
</x-app-layout>
