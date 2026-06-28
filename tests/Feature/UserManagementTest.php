<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Ensure roles exist
        Role::findOrCreate('admin');
        Role::findOrCreate('agent');
        Role::findOrCreate('customer');
    }

    public function test_admin_can_view_users_list(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get('/admin/users');

        $response->assertStatus(200);
        $response->assertViewIs('admin.users.index');
    }

    public function test_non_admin_cannot_view_users_list(): void
    {
        $agent = User::factory()->create();
        $agent->assignRole('agent');

        $response = $this->actingAs($agent)->get('/admin/users');

        $response->assertStatus(403);
    }

    public function test_admin_can_create_user(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->post('/admin/users', [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'mobile' => '0987654321',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'customer',
        ]);

        $response->assertRedirect('/admin/users');
        $this->assertDatabaseHas('users', [
            'email' => 'testuser@example.com',
        ]);
        
        $newUser = User::where('email', 'testuser@example.com')->first();
        $this->assertTrue($newUser->hasRole('customer'));
    }

    public function test_admin_can_update_user(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $userToUpdate = User::factory()->create();
        $userToUpdate->assignRole('customer');

        $response = $this->actingAs($admin)->put('/admin/users/' . $userToUpdate->id, [
            'name' => 'Updated Name',
            'email' => $userToUpdate->email, // keep same
            'mobile' => '1112223334',
            'role' => 'agent',
        ]);

        $response->assertRedirect('/admin/users');
        $this->assertDatabaseHas('users', [
            'id' => $userToUpdate->id,
            'name' => 'Updated Name',
            'mobile' => '1112223334',
        ]);
        
        $this->assertTrue($userToUpdate->fresh()->hasRole('agent'));
        $this->assertFalse($userToUpdate->fresh()->hasRole('customer'));
    }

    public function test_admin_can_delete_user(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $userToDelete = User::factory()->create();

        $response = $this->actingAs($admin)->delete('/admin/users/' . $userToDelete->id);

        $response->assertRedirect('/admin/users');
        $this->assertDatabaseMissing('users', [
            'id' => $userToDelete->id,
        ]);
    }

    public function test_admin_cannot_delete_themselves(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->delete('/admin/users/' . $admin->id);

        $response->assertRedirect('/admin/users');
        $response->assertSessionHas('error');
        
        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
        ]);
    }
}
