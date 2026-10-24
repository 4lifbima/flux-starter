<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login_page(): void
    {
        $response = $this->get(route('dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_users_can_view_dashboard_with_apexcharts(): void
    {
        $this->seed(RolePermissionSeeder::class);

        $user = User::factory()->create();
        $user->assignRole('user');

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk();
        $response->assertViewHas([
            'totalTables',
            'activeTables',
            'inactiveTables',
            'totalUsers',
            'areaCategories',
            'areaSeries',
            'donutLabels',
            'donutSeries',
        ]);
        $response->assertSee('Basic Area in JavaScript');
        $response->assertSee('Simple Donut in JavaScript');
        $response->assertSee('basic-area-chart');
        $response->assertSee('simple-donut-chart');
    }
}
