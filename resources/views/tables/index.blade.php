<x-app-layout title="Tables" :breadcrumbs="[['label' => 'Tables']]">
    <!-- Header Page -->
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">
                Data Tables
            </h1>
            <p class="mt-1 text-sm text-zinc-500 hidden lg:block">
                Kelola entitas data demo dengan pencarian instan (live search), filter status, pengurutan, dan paginasi server-side tanpa reload.
            </p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('tables.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold rounded-xl bg-primary-600 hover:bg-primary-700 text-white shadow-xs transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500">
                <x-heroicon-o-plus class="w-4 h-4" />
                <span>Tambah Data</span>
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
                    <span id="search-idle-icon">
                        <x-heroicon-o-magnifying-glass class="w-4 h-4" />
                    </span>
                    <span id="search-loading-icon" class="hidden">
                        <svg class="animate-spin w-4 h-4 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                    </span>
                </div>

                <input type="text"
                       id="table-search-input"
                       value="{{ $search }}"
                       oninput="window.tableFilter.onSearchInput(this.value)"
                       autocomplete="off"
                       placeholder="Ketik untuk mencari data secara instan..."
                       class="w-full pl-10 pr-10 py-2 text-sm rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50/50 dark:bg-zinc-800/50 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:bg-white dark:focus:bg-zinc-800 focus:border-primary-500 dark:focus:border-primary-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 transition-colors">

                <!-- Clear Search Input button -->
                <button type="button"
                        id="table-search-clear-btn"
                        onclick="window.tableFilter.clearSearch()"
                        class="{{ $search !== '' ? '' : 'hidden' }} absolute inset-y-0 right-0 pr-3 flex items-center text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
                    <x-heroicon-o-x-mark class="w-4 h-4" />
                </button>
            </div>

            <!-- Right: Filter Status & Per Page -->
            <div class="flex items-center gap-3">
                <!-- Status Filter -->
                <div class="flex items-center gap-2">
                    <label for="table-status-select" class="text-xs font-medium text-zinc-500 whitespace-nowrap">Status:</label>
                    <select id="table-status-select"
                            onchange="window.tableFilter.onStatusChange(this.value)"
                            class="px-3 py-2 text-xs font-medium rounded-xl border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                        <option value="" {{ empty($status) ? 'selected' : '' }}>Semua Status</option>
                        <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

                <!-- Per Page -->
                <div class="flex items-center gap-2">
                    <label for="table-per-page-select" class="text-xs font-medium text-zinc-500 whitespace-nowrap">Baris:</label>
                    <select id="table-per-page-select"
                            onchange="window.tableFilter.onPerPageChange(this.value)"
                            class="px-2.5 py-2 text-xs font-medium rounded-xl border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                        @foreach ($allowedPerPage as $opt)
                            <option value="{{ $opt }}" {{ $perPage === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Reset Filter Button -->
                <button type="button"
                        id="table-reset-btn"
                        onclick="window.tableFilter.reset()"
                        class="{{ ($search !== '' || !empty($status)) ? '' : 'hidden' }} p-2 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-xl transition-colors"
                        title="Reset pencarian dan filter">
                    <x-heroicon-o-x-mark class="w-4 h-4" />
                </button>
            </div>
        </div>
    </div>

    <!-- Data Table Container (Dynamically Swapped via AJAX) -->
    <div id="table-content-area" class="bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 rounded-xl shadow-2xs overflow-hidden transition-opacity duration-150">
        @include('tables._table')
    </div>

    <!-- Live AJAX Controller Script for Tables -->
    <script>
        (function () {
            let debounceTimer = null;
            let currentRequest = null;

            window.tableFilter = {
                state: {
                    search: @json($search),
                    status: @json($status ?? ''),
                    sort: @json($sort),
                    direction: @json($direction),
                    per_page: @json($perPage),
                    page: 1
                },

                buildUrl: function () {
                    const params = new URLSearchParams();
                    if (this.state.search) params.set('search', this.state.search);
                    if (this.state.status) params.set('status', this.state.status);
                    if (this.state.sort) params.set('sort', this.state.sort);
                    if (this.state.direction) params.set('direction', this.state.direction);
                    if (this.state.per_page) params.set('per_page', this.state.per_page);
                    if (this.state.page && this.state.page > 1) params.set('page', this.state.page);

                    const qs = params.toString();
                    return '{{ route('tables.index') }}' + (qs ? '?' + qs : '');
                },

                fetchData: function () {
                    const url = this.buildUrl();
                    const container = document.getElementById('table-content-area');
                    const idleIcon = document.getElementById('search-idle-icon');
                    const loadingIcon = document.getElementById('search-loading-icon');
                    const clearBtn = document.getElementById('table-search-clear-btn');
                    const resetBtn = document.getElementById('table-reset-btn');

                    // Toggle clear & reset buttons
                    if (clearBtn) {
                        if (this.state.search) clearBtn.classList.remove('hidden');
                        else clearBtn.classList.add('hidden');
                    }
                    if (resetBtn) {
                        if (this.state.search || this.state.status) resetBtn.classList.remove('hidden');
                        else resetBtn.classList.add('hidden');
                    }

                    // Show subtle spinner, keep table visible
                    idleIcon?.classList.add('hidden');
                    loadingIcon?.classList.remove('hidden');
                    if (container) container.style.opacity = '0.65';

                    // Cancel previous in-flight request if any
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
                        // Update browser URL without reloading
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
                    this.state.page = 1; // reset page on search

                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => {
                        this.fetchData();
                    }, 250); // fast 250ms debounced instant search
                },

                clearSearch: function () {
                    const input = document.getElementById('table-search-input');
                    if (input) {
                        input.value = '';
                        input.focus();
                    }
                    this.onSearchInput('');
                },

                onStatusChange: function (val) {
                    this.state.status = val;
                    this.state.page = 1;
                    this.fetchData();
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
                    this.state.status = '';
                    this.state.page = 1;

                    const searchInput = document.getElementById('table-search-input');
                    if (searchInput) searchInput.value = '';

                    const statusSelect = document.getElementById('table-status-select');
                    if (statusSelect) statusSelect.value = '';

                    this.fetchData();
                }
            };

            // Intercept pagination clicks dynamically inside #table-content-area
            document.addEventListener('click', function (e) {
                const link = e.target.closest('#table-content-area .table-pagination-links a');
                if (link && link.href) {
                    e.preventDefault();
                    try {
                        const urlObj = new URL(link.href);
                        const page = urlObj.searchParams.get('page') || 1;
                        window.tableFilter.goToPage(page);
                    } catch (err) {
                        window.location.href = link.href;
                    }
                }
            });
        })();
    </script>
</x-app-layout>
