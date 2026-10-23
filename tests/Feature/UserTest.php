<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create([
            'name' => 'Super Administrator',
            'email' => 'admin@example.com',
        ]);
    }

    public function test_user_can_view_users_index(): void
    {
        User::factory()->count(5)->create();

        $response = $this->actingAs($this->admin)->get(route('users.index'));

        $response->assertStatus(200);
        $response->assertSee('Pengguna (Users)');
        $response->assertSee('Super Administrator');
    }

    public function test_user_can_search_users(): void
    {
        $target = User::factory()->create(['name' => 'Zulfa Khairunnisa', 'email' => 'zulfa@example.com']);
        $other = User::factory()->create(['name' => 'Bambang Sudirman', 'email' => 'bambang@example.com']);

        $response = $this->actingAs($this->admin)->get(route('users.index', ['search' => 'Zulfa']));

        $response->assertStatus(200);
        $response->assertSee('Zulfa Khairunnisa');
        $response->assertDontSee('Bambang Sudirman');
    }

    public function test_user_can_search_users_via_ajax_request(): void
    {
        $target = User::factory()->create(['name' => 'User Ajax Khusus', 'email' => 'ajax@example.com']);
        $other = User::factory()->create(['name' => 'User Lain', 'email' => 'other@example.com']);

        $response = $this->actingAs($this->admin)->get(route('users.index', ['search' => 'Khusus']), [
            'X-Requested-With' => 'XMLHttpRequest',
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('users._table');
        $response->assertSee('User Ajax Khusus');
        $response->assertDontSee('User Lain');
    }

    public function test_user_can_view_create_user_form(): void
    {
        $response = $this->actingAs($this->admin)->get(route('users.create'));

        $response->assertStatus(200);
        $response->assertSee('Tambah Pengguna Baru');
    }

    public function test_user_can_create_new_user_with_hashed_password(): void
    {
        $response = $this->actingAs($this->admin)->post(route('users.store'), [
            'name' => 'Karyawan Baru',
            'email' => 'karyawan@example.com',
            'password' => 'secret12345',
            'password_confirmation' => 'secret12345',
        ]);

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success', 'Pengguna berhasil ditambahkan.');

        $newUser = User::where('email', 'karyawan@example.com')->first();
        $this->assertNotNull($newUser);
        $this->assertEquals('Karyawan Baru', $newUser->name);
        $this->assertTrue(Hash::check('secret12345', $newUser->password));
    }

    public function test_cannot_create_user_with_duplicate_email(): void
    {
        $response = $this->actingAs($this->admin)->post(route('users.store'), [
            'name' => 'Duplicate Email User',
            'email' => 'admin@example.com',
            'password' => 'secret12345',
            'password_confirmation' => 'secret12345',
        ]);

        $response->assertSessionHasErrors('email');
        $response->assertSessionMissing('success');
    }

    public function test_user_can_view_edit_user_form(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->admin)->get(route('users.edit', $user->id));

        $response->assertStatus(200);
        $response->assertSee('Edit Pengguna');
        $response->assertSee($user->name);
    }

    public function test_user_can_update_user_without_changing_password(): void
    {
        $user = User::factory()->create([
            'name' => 'Nama Sebelum Edit',
            'email' => 'usersebelum@example.com',
            'password' => Hash::make('original_password'),
        ]);

        $response = $this->actingAs($this->admin)->put(route('users.update', $user->id), [
            'name' => 'Nama Setelah Edit',
            'email' => 'usersesudah@example.com',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success', 'Pengguna berhasil diperbarui.');

        $user->refresh();
        $this->assertEquals('Nama Setelah Edit', $user->name);
        $this->assertEquals('usersesudah@example.com', $user->email);
        $this->assertTrue(Hash::check('original_password', $user->password));
    }

    public function test_user_can_update_user_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('original_password'),
        ]);

        $response = $this->actingAs($this->admin)->put(route('users.update', $user->id), [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'new_secret_password',
            'password_confirmation' => 'new_secret_password',
        ]);

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success', 'Pengguna berhasil diperbarui.');

        $user->refresh();
        $this->assertTrue(Hash::check('new_secret_password', $user->password));
    }

    public function test_user_cannot_delete_their_own_account(): void
    {
        // Add another user so admin is not the only user in the system
        User::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('users.destroy', $this->admin->id));

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('error', 'Anda tidak dapat menghapus akun Anda sendiri.');

        $this->assertDatabaseHas('users', ['id' => $this->admin->id]);
    }

    public function test_cannot_delete_the_last_remaining_user(): void
    {
        // Admin is the only user in the database
        $this->assertEquals(1, User::count());

        $response = $this->actingAs($this->admin)->delete(route('users.destroy', $this->admin->id));

        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', ['id' => $this->admin->id]);
    }

    public function test_user_can_delete_another_user_when_multiple_users_exist(): void
    {
        $otherUser = User::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('users.destroy', $otherUser->id));

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success', 'Pengguna berhasil dihapus.');

        $this->assertDatabaseMissing('users', ['id' => $otherUser->id]);
    }
}
