<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions
        $permissions = [
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

        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName, 'guard_name' => 'web']);
        }

        // 1. Role: Admin (Full Access)
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions(Permission::all());

        // 2. Role: Manager (Tables CRUD + View Users)
        $managerRole = Role::firstOrCreate(['name' => 'manager', 'guard_name' => 'web']);
        $managerRole->syncPermissions([
            'view-tables',
            'create-tables',
            'edit-tables',
            'delete-tables',
            'view-users',
        ]);

        // 3. Role: User (Basic Access)
        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);
        $userRole->syncPermissions([
            'view-tables',
            'create-tables',
        ]);

        // Assign Admin role to default admin if exists
        $admin = User::where('email', 'admin@example.com')->first();
        if ($admin) {
            $admin->syncRoles([$adminRole]);
        }

        // Assign User role to existing demo users without roles
        $otherUsers = User::where('email', '!=', 'admin@example.com')->get();
        foreach ($otherUsers as $idx => $user) {
            if ($idx === 0) {
                $user->syncRoles([$managerRole]);
            } else {
                $user->syncRoles([$userRole]);
            }
        }
    }
}
