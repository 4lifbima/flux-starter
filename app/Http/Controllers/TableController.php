<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTableRequest;
use App\Http\Requests\UpdateTableRequest;
use App\Models\Table;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TableController extends Controller
{
    /**
     * Allowed columns for sorting.
     *
     * @var array<string>
     */
    protected array $sortableColumns = [
        'name',
        'status',
        'created_at',
    ];

    /**
     * Allowed page sizes.
     *
     * @var array<int>
     */
    protected array $allowedPerPage = [10, 25, 50];

    /**
     * Display a listing of the resource with dynamic filtering, sorting, and pagination.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $status = $request->query('status');
        $sort = $request->query('sort', 'created_at');
        $direction = strtolower((string) $request->query('direction', 'desc'));
        $perPage = (int) $request->query('per_page', 10);

        // Validate sorting column against allowlist
        if (! in_array($sort, $this->sortableColumns, true)) {
            $sort = 'created_at';
        }

        // Validate sorting direction
        if (! in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'desc';
        }

        // Validate per_page against allowlist
        if (! in_array($perPage, $this->allowedPerPage, true)) {
            $perPage = 10;
        }

        $query = Table::query();

        // Search by name
        if ($search !== '') {
            $query->where('name', 'like', '%'.$search.'%');
        }

        // Filter by status (active / inactive)
        if (in_array($status, ['active', 'inactive'], true)) {
            $query->where('status', $status);
        }

        // Apply sorting
        $query->orderBy($sort, $direction);

        // Paginate and retain query parameters
        $tables = $query->paginate($perPage)->withQueryString();

        return view('tables.index', [
            'tables' => $tables,
            'search' => $search,
            'status' => $status,
            'sort' => $sort,
            'direction' => $direction,
            'perPage' => $perPage,
            'allowedPerPage' => $this->allowedPerPage,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('tables.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTableRequest $request): RedirectResponse
    {
        Table::create($request->validated());

        return redirect()->route('tables.index')
            ->with('success', 'Data berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Table $table): View
    {
        return view('tables.show', compact('table'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Table $table): View
    {
        return view('tables.edit', compact('table'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTableRequest $request, Table $table): RedirectResponse
    {
        $table->update($request->validated());

        return redirect()->route('tables.index')
            ->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Table $table): RedirectResponse
    {
        $table->delete();

        return redirect()->route('tables.index')
            ->with('success', 'Data berhasil dihapus.');
    }
}
