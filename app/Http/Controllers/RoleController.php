<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Allowed columns for sorting roles.
     *
     * @var array<string>
     */
    protected array $sortableColumns = [
        'name',
        'created_at',
    ];

    /**
     * Allowed page sizes.
     *
     * @var array<int>
     */
    protected array $allowedPerPage = [10, 25, 50];

    /**
     * Display a listing of roles and permissions with dynamic search and sorting.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $sort = $request->query('sort', 'name');
        $direction = strtolower((string) $request->query('direction', 'asc'));
        $perPage = (int) $request->query('per_page', 10);

        if (! in_array($sort, $this->sortableColumns, true)) {
            $sort = 'name';
        }

        if (! in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'asc';
        }

        if (! in_array($perPage, $this->allowedPerPage, true)) {
            $perPage = 10;
        }

        $query = Role::with(['permissions'])->withCount(['users', 'permissions']);

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%'.$search.'%')
                    ->orWhereHas('permissions', function ($pq) use ($search) {
                        $pq->where('name', 'like', '%'.$search.'%');
                    });
            });
        }

        $query->orderBy($sort, $direction);

        $roles = $query->paginate($perPage)->withQueryString();
        $permissions = Permission::orderBy('name')->get();

        $allowedPerPage = $this->allowedPerPage;

        if ($request->ajax()) {
            return view('roles._table', compact('roles', 'search', 'sort', 'direction', 'perPage'));
        }

        return view('roles.index', compact('roles', 'permissions', 'search', 'sort', 'direction', 'perPage', 'allowedPerPage'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create(): View
    {
        $permissions = Permission::orderBy('name')->get();
        $groupedPermissions = $this->groupPermissions($permissions);

        return view('roles.create', compact('permissions', 'groupedPermissions'));
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(StoreRoleRequest $request): RedirectResponse
    {
        $role = Role::create([
            'name' => strtolower($request->validated('name')),
            'guard_name' => 'web',
        ]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->validated('permissions'));
        }

        return redirect()->route('roles.index')->with('success', "Role '{$role->name}' berhasil dibuat.");
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(Role $role): View
    {
        $permissions = Permission::orderBy('name')->get();
        $groupedPermissions = $this->groupPermissions($permissions);
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('roles.edit', compact('role', 'permissions', 'groupedPermissions', 'rolePermissions'));
    }

    /**
     * Update the specified role in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        $newName = strtolower($request->validated('name'));

        // Prevent renaming the core admin role
        if ($role->name === 'admin' && $newName !== 'admin') {
            return back()->with('error', 'Role administrator sistem utama tidak dapat diubah namanya.');
        }

        $role->update(['name' => $newName]);

        $permissions = $request->validated('permissions') ?? [];
        $role->syncPermissions($permissions);

        return redirect()->route('roles.index')->with('success', "Role '{$role->name}' berhasil diperbarui.");
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy(Role $role): RedirectResponse
    {
        // Protect super admin role
        if ($role->name === 'admin') {
            return back()->with('error', 'Role administrator sistem utama tidak dapat dihapus.');
        }

        // Prevent deleting role if users are still assigned
        $usersCount = $role->users()->count();
        if ($usersCount > 0) {
            return back()->with('error', "Role '{$role->name}' tidak dapat dihapus karena masih digunakan oleh {$usersCount} pengguna.");
        }

        $roleName = $role->name;
        $role->delete();

        return redirect()->route('roles.index')->with('success', "Role '{$roleName}' berhasil dihapus.");
    }

    /**
     * Store a newly created permission.
     */
    public function storePermission(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50', 'regex:/^[a-zA-Z0-9_\-]+$/', 'unique:permissions,name'],
        ], [
            'name.required' => 'Nama permission wajib diisi.',
            'name.unique' => 'Permission dengan nama ini sudah ada.',
            'name.regex' => 'Nama permission hanya boleh berisi huruf, angka, strip (-), dan garis bawah (_).',
        ]);

        $permission = Permission::create([
            'name' => strtolower($validated['name']),
            'guard_name' => 'web',
        ]);

        return back()->with('success', "Permission '{$permission->name}' berhasil ditambahkan.");
    }

    /**
     * Remove the specified permission from storage.
     */
    public function destroyPermission(Permission $permission): RedirectResponse
    {
        $protected = [
            'view-tables',
            'create-tables',
            'edit-tables',
            'delete-tables',
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',
            'manage-roles',
        ];

        if (in_array($permission->name, $protected, true)) {
            return back()->with('error', "Permission inti sistem '{$permission->name}' tidak dapat dihapus.");
        }

        $permissionName = $permission->name;
        $permission->delete();

        return back()->with('success', "Permission '{$permissionName}' berhasil dihapus.");
    }

    /**
     * Group permissions logically for forms.
     */
    protected function groupPermissions($permissions): array
    {
        $groups = [
            'Tables Management' => [],
            'Users Management' => [],
            'Roles & System' => [],
            'Lainnya' => [],
        ];

        foreach ($permissions as $permission) {
            if (str_contains($permission->name, 'table')) {
                $groups['Tables Management'][] = $permission;
            } elseif (str_contains($permission->name, 'user')) {
                $groups['Users Management'][] = $permission;
            } elseif (str_contains($permission->name, 'role') || str_contains($permission->name, 'permission')) {
                $groups['Roles & System'][] = $permission;
            } else {
                $groups['Lainnya'][] = $permission;
            }
        }

        return array_filter($groups, fn ($group) => ! empty($group));
    }
}
