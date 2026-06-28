<?php

namespace Tests\Feature;

use App\Models\Locality;
use App\Models\Property;
use App\Models\User;
use App\Models\VisitRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VisitRequestTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'RolesAndPermissionsSeeder']);
    }

    public function test_guest_cannot_book_visit()
    {
        $response = $this->post(route('customer.visits.store'), [
            'property_id' => 1,
        ]);

        $response->assertRedirect(route('login'));
    }

    public function test_customer_can_book_visit_for_verified_and_published_property()
    {
        $customer = User::factory()->create();
        $customer->assignRole('customer');

        $locality = Locality::create([
            'name' => 'Abul Fazal',
            'slug' => 'abul-fazal',
            'is_active' => true,
        ]);

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $property = Property::create([
            'property_code' => 'OF-1001',
            'title' => 'Stunning BHK flat',
            'rent' => 15000,
            'deposit' => 30000,
            'property_type' => 'flat',
            'bhk' => 2,
            'area' => 900,
            'floor' => '1st',
            'furnishing' => 'semi-furnished',
            'availability' => 'immediate',
            'approximate_location' => 'Thana Road',
            'exact_address' => 'Gali 4',
            'building_number' => '44/A',
            'owner_name' => 'Owner Sahab',
            'owner_contact' => '9988776655',
            'verification_status' => 'verified',
            'publication_status' => 'published',
            'locality_id' => $locality->id,
            'created_by' => $admin->id,
        ]);

        $response = $this->actingAs($customer)->post(route('customer.visits.store'), [
            'property_id' => $property->id,
            'customer_notes' => 'Looking to visit this weekend.',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('visit_requests', [
            'property_id' => $property->id,
            'customer_id' => $customer->id,
            'status' => 'pending',
            'customer_notes' => 'Looking to visit this weekend.',
        ]);
    }

    public function test_customer_cannot_double_book_visit_for_same_property()
    {
        $customer = User::factory()->create();
        $customer->assignRole('customer');

        $locality = Locality::create([
            'name' => 'Abul Fazal',
            'slug' => 'abul-fazal',
            'is_active' => true,
        ]);

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $property = Property::create([
            'property_code' => 'OF-1001',
            'title' => 'Stunning BHK flat',
            'rent' => 15000,
            'deposit' => 30000,
            'property_type' => 'flat',
            'bhk' => 2,
            'area' => 900,
            'floor' => '1st',
            'furnishing' => 'semi-furnished',
            'availability' => 'immediate',
            'approximate_location' => 'Thana Road',
            'exact_address' => 'Gali 4',
            'building_number' => '44/A',
            'owner_name' => 'Owner Sahab',
            'owner_contact' => '9988776655',
            'verification_status' => 'verified',
            'publication_status' => 'published',
            'locality_id' => $locality->id,
            'created_by' => $admin->id,
        ]);

        // First booking
        $this->actingAs($customer)->post(route('customer.visits.store'), [
            'property_id' => $property->id,
        ])->assertSessionHasNoErrors();

        // Second booking (should fail/redirect back with error)
        $response = $this->actingAs($customer)->post(route('customer.visits.store'), [
            'property_id' => $property->id,
        ]);

        $response->assertSessionHas('error');
    }

    public function test_admin_can_assign_agent_to_visit_request()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $agent = User::factory()->create();
        $agent->assignRole('agent');

        $customer = User::factory()->create();
        $customer->assignRole('customer');

        $visit = VisitRequest::create([
            'customer_id' => $customer->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.visits.assign', $visit), [
            'agent_id' => $agent->id,
        ]);

        $response->assertRedirect(route('admin.visits.index'));
        $this->assertDatabaseHas('visit_requests', [
            'id' => $visit->id,
            'agent_id' => $agent->id,
            'status' => 'assigned',
        ]);
    }

    public function test_assigned_agent_can_update_status_and_schedule_visit()
    {
        $agent = User::factory()->create();
        $agent->assignRole('agent');

        $customer = User::factory()->create();
        $customer->assignRole('customer');

        $visit = VisitRequest::create([
            'customer_id' => $customer->id,
            'agent_id' => $agent->id,
            'status' => 'assigned',
        ]);

        $payload = [
            'status' => 'scheduled',
            'scheduled_date' => '2026-07-15',
            'scheduled_time' => '14:30',
        ];

        $response = $this->actingAs($agent)->put(route('agent.visits.update', $visit), $payload);

        $response->assertRedirect(route('agent.visits.index'));
        $this->assertDatabaseHas('visit_requests', [
            'id' => $visit->id,
            'status' => 'scheduled',
            'scheduled_at' => '2026-07-15 14:30:00',
        ]);
    }

    public function test_other_agent_cannot_update_visit_status()
    {
        $agent1 = User::factory()->create();
        $agent1->assignRole('agent');

        $agent2 = User::factory()->create();
        $agent2->assignRole('agent');

        $customer = User::factory()->create();
        $customer->assignRole('customer');

        $visit = VisitRequest::create([
            'customer_id' => $customer->id,
            'agent_id' => $agent1->id,
            'status' => 'assigned',
        ]);

        $payload = [
            'status' => 'scheduled',
            'scheduled_date' => '2026-07-15',
            'scheduled_time' => '14:30',
        ];

        $response = $this->actingAs($agent2)->put(route('agent.visits.update', $visit), $payload);

        $response->assertStatus(403);
    }
}
