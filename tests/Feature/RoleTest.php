<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
    }

    public function test_guests_cannot_access_roles(): void
    {
        $this->get(route('roles.index'))->assertRedirect(route('login'));
        $this->get(route('roles.create'))->assertRedirect(route('login'));
        $this->post(route('roles.store'), ['name' => 'editor'])->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_roles_index(): void
    {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $response = $this->actingAs($user)->get(route('roles.index'));

        $response->assertOk();
        $response->assertSee('Roles & Permissions');
        $response->assertSee('admin');
        $response->assertSee('manager');
        $response->assertSee('user');
        $response->assertSee('Daftar Hak Akses (Permissions)');
    }

    public function test_ajax_search_filters_roles(): void
    {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $response = $this->actingAs($user)->get(route('roles.index', ['search' => 'admin']), [
            'X-Requested-With' => 'XMLHttpRequest',
        ]);

        $response->assertOk();
        $response->assertSee('admin');
        $response->assertDontSee('editor-test-not-exist');
    }

    public function test_user_can_create_role_with_permissions(): void
    {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $response = $this->actingAs($user)->post(route('roles.store'), [
            'name' => 'supervisor',
            'permissions' => ['view-tables', 'create-tables'],
        ]);

        $response->assertRedirect(route('roles.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('roles', ['name' => 'supervisor']);

        $role = Role::findByName('supervisor');
        $this->assertTrue($role->hasPermissionTo('view-tables'));
        $this->assertTrue($role->hasPermissionTo('create-tables'));
        $this->assertFalse($role->hasPermissionTo('delete-tables'));
    }

    public function test_role_creation_validates_duplicate_name(): void
    {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $response = $this->actingAs($user)->post(route('roles.store'), [
            'name' => 'admin',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_user_can_edit_and_update_role(): void
    {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $role = Role::create(['name' => 'analyst', 'guard_name' => 'web']);
        $role->givePermissionTo('view-tables');

        $this->actingAs($user)->get(route('roles.edit', $role->id))->assertOk();

        $response = $this->actingAs($user)->put(route('roles.update', $role->id), [
            'name' => 'lead-analyst',
            'permissions' => ['view-tables', 'view-users'],
        ]);

        $response->assertRedirect(route('roles.index'));
        $this->assertDatabaseHas('roles', ['name' => 'lead-analyst']);

        $updatedRole = Role::findByName('lead-analyst');
        $this->assertTrue($updatedRole->hasPermissionTo('view-users'));
    }

    public function test_admin_role_cannot_be_renamed(): void
    {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $adminRole = Role::findByName('admin');

        $response = $this->actingAs($user)->put(route('roles.update', $adminRole->id), [
            'name' => 'super-hacker',
        ]);

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('roles', ['name' => 'admin']);
        $this->assertDatabaseMissing('roles', ['name' => 'super-hacker']);
    }

    public function test_admin_role_cannot_be_deleted(): void
    {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $adminRole = Role::findByName('admin');

        $response = $this->actingAs($user)->delete(route('roles.destroy', $adminRole->id));

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('roles', ['name' => 'admin']);
    }

    public function test_role_with_assigned_users_cannot_be_deleted(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $customRole = Role::create(['name' => 'support', 'guard_name' => 'web']);
        $staffUser = User::factory()->create();
        $staffUser->assignRole($customRole);

        $response = $this->actingAs($admin)->delete(route('roles.destroy', $customRole->id));

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('roles', ['name' => 'support']);
    }

    public function test_unused_role_can_be_deleted(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $customRole = Role::create(['name' => 'temporary-role', 'guard_name' => 'web']);

        $response = $this->actingAs($admin)->delete(route('roles.destroy', $customRole->id));

        $response->assertRedirect(route('roles.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('roles', ['name' => 'temporary-role']);
    }

    public function test_user_can_create_custom_permission(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->post(route('permissions.store'), [
            'name' => 'download-backup',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('permissions', ['name' => 'download-backup']);
    }

    public function test_core_permissions_cannot_be_deleted(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $corePerm = Permission::findByName('view-tables');

        $response = $this->actingAs($admin)->delete(route('permissions.destroy', $corePerm->id));

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('permissions', ['name' => 'view-tables']);
    }

    public function test_custom_permission_can_be_deleted(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $customPerm = Permission::create(['name' => 'temp-perm', 'guard_name' => 'web']);

        $response = $this->actingAs($admin)->delete(route('permissions.destroy', $customPerm->id));

        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('permissions', ['name' => 'temp-perm']);
    }
}
