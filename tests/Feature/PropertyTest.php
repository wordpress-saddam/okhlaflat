<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Locality;
use App\Models\Amenity;
use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PropertyTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Seed roles and permissions
        $this->artisan('db:seed', ['--class' => 'RolesAndPermissionsSeeder']);
    }

    public function test_public_user_cannot_access_admin_property_index()
    {
        $response = $this->get(route('admin.properties.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_customer_cannot_access_admin_property_index()
    {
        $customer = User::factory()->create();
        $customer->assignRole('customer');

        $response = $this->actingAs($customer)->get(route('admin.properties.index'));
        $response->assertStatus(403);
    }

    public function test_agent_can_access_admin_property_index()
    {
        $agent = User::factory()->create();
        $agent->assignRole('agent');

        $response = $this->actingAs($agent)->get(route('admin.properties.index'));
        $response->assertStatus(200);
    }

    public function test_admin_can_access_admin_property_index()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get(route('admin.properties.index'));
        $response->assertStatus(200);
    }

    public function test_sensitive_attributes_are_hidden_from_serialization()
    {
        $locality = Locality::create([
            'name' => 'Batla House',
            'slug' => 'batla-house',
            'is_active' => true
        ]);

        $admin = User::factory()->create();

        $property = Property::create([
            'property_code' => 'OF-0001',
            'title' => 'Test Property',
            'rent' => 12000,
            'deposit' => 24000,
            'property_type' => 'flat',
            'bhk' => 1,
            'area' => 500,
            'floor' => 'Ground',
            'furnishing' => 'unfurnished',
            'availability' => 'immediate',
            'approximate_location' => 'Batla House',
            'exact_address' => 'Private Lane 1',
            'building_number' => 'Flat 202',
            'owner_name' => 'John Doe',
            'owner_contact' => '1234567890',
            'locality_id' => $locality->id,
            'created_by' => $admin->id
        ]);

        $serialized = $property->toArray();

        $this->assertArrayNotHasKey('exact_address', $serialized);
        $this->assertArrayNotHasKey('building_number', $serialized);
        $this->assertArrayNotHasKey('owner_name', $serialized);
        $this->assertArrayNotHasKey('owner_contact', $serialized);
    }
}
