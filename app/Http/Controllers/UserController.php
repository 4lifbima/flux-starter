<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Allowed columns for sorting.
     *
     * @var array<string>
     */
    protected array $sortableColumns = [
        'name',
        'email',
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

        $query = User::with('roles');

        // Search by name or email
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%');
            });
        }

        // Apply sorting
        $query->orderBy($sort, $direction);

        // Paginate and retain query parameters
        $users = $query->paginate($perPage)->withQueryString();

        $viewData = [
            'users' => $users,
            'search' => $search,
            'sort' => $sort,
            'direction' => $direction,
            'perPage' => $perPage,
            'allowedPerPage' => $this->allowedPerPage,
            'currentUserId' => Auth::id(),
            'totalUsersCount' => User::count(),
        ];

        if ($request->ajax()) {
            return view('users._table', $viewData);
        }

        return view('users.index', $viewData);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $roles = Role::all();

        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $role = $validated['role'] ?? 'user';
        unset($validated['role']);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);
        if (Role::where('name', $role)->exists()) {
            $user->assignRole($role);
        }

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        $roles = Role::all();

        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $validated = $request->validated();
        $role = $validated['role'] ?? null;
        unset($validated['role']);

        if (! empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        if ($role && Role::where('name', $role)->exists()) {
            $user->syncRoles([$role]);
        }

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        // Protection 1: User cannot delete their own account
        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Protection 2: Cannot delete the last remaining user/admin
        if (User::count() <= 1) {
            return redirect()->route('users.index')
                ->with('error', 'Tidak dapat menghapus pengguna/admin terakhir dalam sistem.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}
