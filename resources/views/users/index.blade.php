<x-app-layout title="Users" :breadcrumbs="[['label' => 'Users']]">
    <!-- Header Page -->
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">
                Pengguna (Users)
            </h1>
            <p class="mt-1 text-sm text-zinc-500">
                Kelola akun pengguna dan administrator dengan kontrol akses, pencarian instan, dan proteksi keamanan sistem.
            </p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('users.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold rounded-xl bg-primary-600 hover:bg-primary-700 text-white shadow-xs transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500">
                <x-heroicon-o-user-plus class="w-4 h-4" />
                <span>Tambah Pengguna</span>
            </a>
        </div>
    </div>

    <!-- Filter & Search Toolbar (Instant Reactive Search) -->
    <div class="bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 rounded-xl p-4 mb-5 shadow-2xs">
        <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
            
            <!-- Left: Real-time Live Search Input -->
            <div class="relative flex-1 max-w-md">
                <!-- Search Icon / Dynamic Loading Spinner -->
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-zinc-400">
                    <span id="user-search-idle-icon">
                        <x-heroicon-o-magnifying-glass class="w-4 h-4" />
                    </span>
                    <span id="user-search-loading-icon" class="hidden">
                        <svg class="animate-spin w-4 h-4 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                    </span>
                </div>

                <input type="text"
                       id="user-search-input"
                       value="{{ $search }}"
                       oninput="window.userFilter.onSearchInput(this.value)"
                       autocomplete="off"
                       placeholder="Cari nama atau email secara instan..."
                       class="w-full pl-10 pr-10 py-2 text-sm rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50/50 dark:bg-zinc-800/50 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:bg-white dark:focus:bg-zinc-800 focus:border-primary-500 dark:focus:border-primary-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 transition-colors">

                <!-- Clear Search Input button -->
                <button type="button"
                        id="user-search-clear-btn"
                        onclick="window.userFilter.clearSearch()"
                        class="{{ $search !== '' ? '' : 'hidden' }} absolute inset-y-0 right-0 pr-3 flex items-center text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
                    <x-heroicon-o-x-mark class="w-4 h-4" />
                </button>
            </div>

            <!-- Right: Per Page & Reset -->
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2">
                    <label for="user-per-page-select" class="text-xs font-medium text-zinc-500 whitespace-nowrap">Baris:</label>
                    <select id="user-per-page-select"
                            onchange="window.userFilter.onPerPageChange(this.value)"
                            class="px-2.5 py-2 text-xs font-medium rounded-xl border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                        @foreach ($allowedPerPage as $opt)
                            <option value="{{ $opt }}" {{ $perPage === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Reset Button -->
                <button type="button"
                        id="user-reset-btn"
                        onclick="window.userFilter.reset()"
                        class="{{ $search !== '' ? '' : 'hidden' }} p-2 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-xl transition-colors"
                        title="Reset pencarian">
                    <x-heroicon-o-x-mark class="w-4 h-4" />
                </button>
            </div>
        </div>
    </div>

    <!-- Data Table Container (Dynamically Swapped via AJAX) -->
    <div id="user-content-area" class="bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 rounded-xl shadow-2xs overflow-hidden transition-opacity duration-150">
        @include('users._table')
    </div>

    <!-- Live AJAX Controller Script for Users -->
    <script>
        (function () {
            let debounceTimer = null;
            let currentRequest = null;

            window.userFilter = {
                state: {
                    search: @json($search),
                    sort: @json($sort),
                    direction: @json($direction),
                    per_page: @json($perPage),
                    page: 1
                },

                buildUrl: function () {
                    const params = new URLSearchParams();
                    if (this.state.search) params.set('search', this.state.search);
                    if (this.state.sort) params.set('sort', this.state.sort);
                    if (this.state.direction) params.set('direction', this.state.direction);
                    if (this.state.per_page) params.set('per_page', this.state.per_page);
                    if (this.state.page && this.state.page > 1) params.set('page', this.state.page);

                    const qs = params.toString();
                    return '{{ route('users.index') }}' + (qs ? '?' + qs : '');
                },

                fetchData: function () {
                    const url = this.buildUrl();
                    const container = document.getElementById('user-content-area');
                    const idleIcon = document.getElementById('user-search-idle-icon');
                    const loadingIcon = document.getElementById('user-search-loading-icon');
                    const clearBtn = document.getElementById('user-search-clear-btn');
                    const resetBtn = document.getElementById('user-reset-btn');

                    if (clearBtn) {
                        if (this.state.search) clearBtn.classList.remove('hidden');
                        else clearBtn.classList.add('hidden');
                    }
                    if (resetBtn) {
                        if (this.state.search) resetBtn.classList.remove('hidden');
                        else resetBtn.classList.add('hidden');
                    }

                    idleIcon?.classList.add('hidden');
                    loadingIcon?.classList.remove('hidden');
                    if (container) container.style.opacity = '0.65';

                    if (currentRequest) {
                        currentRequest.abort();
                    }
                    const controller = new AbortController();
                    currentRequest = controller;

                    fetch(url, {
                        signal: controller.signal,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html'
                        }
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.text();
                    })
                    .then(html => {
                        if (container) {
                            container.innerHTML = html;
                            container.style.opacity = '1';
                        }
                        window.history.replaceState(null, '', url);
                    })
                    .catch(err => {
                        if (err.name !== 'AbortError') {
                            console.error('Fetch error:', err);
                            if (container) container.style.opacity = '1';
                        }
                    })
                    .finally(() => {
                        idleIcon?.classList.remove('hidden');
                        loadingIcon?.classList.add('hidden');
                    });
                },

                onSearchInput: function (val) {
                    this.state.search = val.trim();
                    this.state.page = 1;

                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => {
                        this.fetchData();
                    }, 250);
                },

                clearSearch: function () {
                    const input = document.getElementById('user-search-input');
                    if (input) {
                        input.value = '';
                        input.focus();
                    }
                    this.onSearchInput('');
                },

                onPerPageChange: function (val) {
                    this.state.per_page = val;
                    this.state.page = 1;
                    this.fetchData();
                },

                sort: function (column) {
                    if (this.state.sort === column) {
                        this.state.direction = this.state.direction === 'asc' ? 'desc' : 'asc';
                    } else {
                        this.state.sort = column;
                        this.state.direction = 'asc';
                    }
                    this.state.page = 1;
                    this.fetchData();
                },

                goToPage: function (page) {
                    this.state.page = page;
                    this.fetchData();
                },

                reset: function () {
                    this.state.search = '';
                    this.state.page = 1;

                    const searchInput = document.getElementById('user-search-input');
                    if (searchInput) searchInput.value = '';

                    this.fetchData();
                }
            };

            // Intercept pagination clicks dynamically inside #user-content-area
            document.addEventListener('click', function (e) {
                const link = e.target.closest('#user-content-area .user-pagination-links a');
                if (link && link.href) {
                    e.preventDefault();
                    try {
                        const urlObj = new URL(link.href);
                        const page = urlObj.searchParams.get('page') || 1;
                        window.userFilter.goToPage(page);
                    } catch (err) {
                        window.location.href = link.href;
                    }
                }
            });
        })();
    </script>
</x-app-layout>
