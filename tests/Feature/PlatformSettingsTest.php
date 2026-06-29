<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Setting;
use Spatie\Permission\Models\Role;

class PlatformSettingsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'agent']);
        Role::create(['name' => 'customer']);
    }

    public function test_admin_can_view_settings_page(): void
    {
        $admin = User::factory()->create()->assignRole('admin');

        $response = $this->actingAs($admin)->get(route('admin.settings.index'));

        $response->assertStatus(200);
        $response->assertSee('Platform Settings');
    }

    public function test_agent_cannot_view_settings_page(): void
    {
        $agent = User::factory()->create()->assignRole('agent');

        $response = $this->actingAs($agent)->get(route('admin.settings.index'));

        $response->assertStatus(403);
    }

    public function test_admin_can_update_brokerage_fee(): void
    {
        $admin = User::factory()->create()->assignRole('admin');

        $response = $this->actingAs($admin)->post(route('admin.settings.store'), [
            'brokerage_fee_percentage' => 15
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertEquals(15, Setting::getValue('brokerage_fee_percentage'));
    }
}
