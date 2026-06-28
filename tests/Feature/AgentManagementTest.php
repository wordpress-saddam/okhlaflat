<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AgentManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'RolesAndPermissionsSeeder']);
    }

    public function test_guest_cannot_access_agents_module()
    {
        $this->get(route('admin.agents.index'))->assertRedirect(route('login'));
    }

    public function test_customer_cannot_access_agents_module()
    {
        $customer = User::factory()->create();
        $customer->assignRole('customer');

        $this->actingAs($customer)->get(route('admin.agents.index'))->assertStatus(403);
    }

    public function test_agent_cannot_access_agents_module()
    {
        $agent = User::factory()->create();
        $agent->assignRole('agent');

        $this->actingAs($agent)->get(route('admin.agents.index'))->assertStatus(403);
    }

    public function test_admin_can_access_agents_module()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin)->get(route('admin.agents.index'))->assertStatus(200);
    }

    public function test_admin_can_register_new_agent()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $payload = [
            'name' => 'Agent Bobby',
            'email' => 'bobby@okhlaflat.com',
            'mobile' => '9876543210',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->actingAs($admin)->post(route('admin.agents.store'), $payload);

        $response->assertRedirect(route('admin.agents.index'));
        $this->assertDatabaseHas('users', [
            'name' => 'Agent Bobby',
            'email' => 'bobby@okhlaflat.com',
            'mobile' => '9876543210',
        ]);

        $newAgent = User::where('email', 'bobby@okhlaflat.com')->first();
        $this->assertTrue($newAgent->hasRole('agent'));
    }

    public function test_admin_can_update_agent_details()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $agent = User::factory()->create();
        $agent->assignRole('agent');

        $payload = [
            'name' => 'Agent Updated Name',
            'email' => 'updated@okhlaflat.com',
            'mobile' => '1111222233',
        ];

        $response = $this->actingAs($admin)->put(route('admin.agents.update', $agent), $payload);

        $response->assertRedirect(route('admin.agents.index'));
        $this->assertDatabaseHas('users', [
            'id' => $agent->id,
            'name' => 'Agent Updated Name',
            'email' => 'updated@okhlaflat.com',
            'mobile' => '1111222233',
        ]);
    }

    public function test_admin_can_delete_agent()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $agent = User::factory()->create();
        $agent->assignRole('agent');

        $response = $this->actingAs($admin)->delete(route('admin.agents.destroy', $agent));

        $response->assertRedirect(route('admin.agents.index'));
        $this->assertDatabaseMissing('users', [
            'id' => $agent->id,
        ]);
    }
}
