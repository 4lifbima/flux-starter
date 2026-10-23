<?php

namespace Tests\Feature;

use App\Models\Table;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TableTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_user_can_view_tables_index_with_pagination(): void
    {
        Table::factory()->count(15)->create();

        $response = $this->actingAs($this->user)->get(route('tables.index'));

        $response->assertStatus(200);
        $response->assertSee('Data Tables');
        $response->assertViewHas('tables');
    }

    public function test_user_can_search_tables_by_name(): void
    {
        $target = Table::factory()->create(['name' => 'Spesifik Server Alpha']);
        $other = Table::factory()->create(['name' => 'Database Backup Beta']);

        $response = $this->actingAs($this->user)->get(route('tables.index', ['search' => 'Alpha']));

        $response->assertStatus(200);
        $response->assertSee('Spesifik Server Alpha');
        $response->assertDontSee('Database Backup Beta');
    }

    public function test_user_can_search_tables_via_ajax_request(): void
    {
        $target = Table::factory()->create(['name' => 'Data Ajax Khusus']);
        $other = Table::factory()->create(['name' => 'Data Lain']);

        $response = $this->actingAs($this->user)->get(route('tables.index', ['search' => 'Khusus']), [
            'X-Requested-With' => 'XMLHttpRequest',
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('tables._table');
        $response->assertSee('Data Ajax Khusus');
        $response->assertDontSee('Data Lain');
    }

    public function test_user_can_filter_tables_by_status(): void
    {
        $active = Table::factory()->create(['name' => 'Tabel Aktif', 'status' => 'active']);
        $inactive = Table::factory()->create(['name' => 'Tabel Nonaktif', 'status' => 'inactive']);

        $response = $this->actingAs($this->user)->get(route('tables.index', ['status' => 'inactive']));

        $response->assertStatus(200);
        $response->assertSee('Tabel Nonaktif');
        $response->assertDontSee('Tabel Aktif');
    }

    public function test_user_can_sort_tables(): void
    {
        $first = Table::factory()->create(['name' => 'AAA Table', 'created_at' => now()->subDays(2)]);
        $second = Table::factory()->create(['name' => 'ZZZ Table', 'created_at' => now()->subDay()]);

        $response = $this->actingAs($this->user)->get(route('tables.index', ['sort' => 'name', 'direction' => 'asc']));

        $response->assertStatus(200);
        $tables = $response->viewData('tables');
        $this->assertEquals('AAA Table', $tables->first()->name);
    }

    public function test_user_can_view_create_table_form(): void
    {
        $response = $this->actingAs($this->user)->get(route('tables.create'));

        $response->assertStatus(200);
        $response->assertSee('Tambah Data Table Baru');
    }

    public function test_user_can_create_table_with_valid_data(): void
    {
        $response = $this->actingAs($this->user)->post(route('tables.store'), [
            'name' => 'Inventaris Perangkat Baru',
            'description' => 'Monitoring perangkat kantor',
            'status' => 'active',
        ]);

        $response->assertRedirect(route('tables.index'));
        $response->assertSessionHas('success', 'Data berhasil ditambahkan.');

        $this->assertDatabaseHas('tables', [
            'name' => 'Inventaris Perangkat Baru',
            'status' => 'active',
        ]);
    }

    public function test_cannot_create_table_without_name(): void
    {
        $response = $this->actingAs($this->user)->post(route('tables.store'), [
            'name' => '',
            'status' => 'active',
        ]);

        $response->assertSessionHasErrors('name');
        $response->assertSessionMissing('success');
        $this->assertDatabaseCount('tables', 0);
    }

    public function test_user_can_view_edit_table_form(): void
    {
        $table = Table::factory()->create();

        $response = $this->actingAs($this->user)->get(route('tables.edit', $table->id));

        $response->assertStatus(200);
        $response->assertSee('Edit Data Table');
        $response->assertSee($table->name);
    }

    public function test_user_can_update_table(): void
    {
        $table = Table::factory()->create([
            'name' => 'Nama Lama',
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->user)->put(route('tables.update', $table->id), [
            'name' => 'Nama Baru Diperbarui',
            'description' => 'Deskripsi diperbarui',
            'status' => 'inactive',
        ]);

        $response->assertRedirect(route('tables.index'));
        $response->assertSessionHas('success', 'Data berhasil diperbarui.');

        $this->assertDatabaseHas('tables', [
            'id' => $table->id,
            'name' => 'Nama Baru Diperbarui',
            'status' => 'inactive',
        ]);
    }

    public function test_user_can_delete_table(): void
    {
        $table = Table::factory()->create();

        $response = $this->actingAs($this->user)->delete(route('tables.destroy', $table->id));

        $response->assertRedirect(route('tables.index'));
        $response->assertSessionHas('success', 'Data berhasil dihapus.');

        $this->assertDatabaseMissing('tables', ['id' => $table->id]);
    }
}
