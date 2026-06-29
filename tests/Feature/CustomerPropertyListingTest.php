<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Locality;
use App\Models\Property;
use Spatie\Permission\Models\Role;

class CustomerPropertyListingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Ensure roles exist
        Role::firstOrCreate(['name' => 'customer']);
        Role::firstOrCreate(['name' => 'agent']);
        Role::firstOrCreate(['name' => 'admin']);
    }

    public function test_customer_can_view_property_creation_form()
    {
        $customer = User::factory()->create();
        $customer->assignRole('customer');

        $response = $this->actingAs($customer)->get(route('customer.properties.create'));

        $response->assertStatus(200);
        $response->assertSee('List Your Flat');
    }

    public function test_customer_can_create_property_draft_in_step_1()
    {
        $customer = User::factory()->create();
        $customer->assignRole('customer');
        
        $locality = Locality::create(['name' => 'Test Locality', 'slug' => 'test-locality']);

        $data = [
            'step' => 1,
            'title' => 'My New Flat',
            'locality_id' => $locality->id,
            'property_type' => 'flat',
            'bhk' => 2,
        ];

        $response = $this->actingAs($customer)
            ->postJson(route('customer.properties.store-step'), $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $this->assertDatabaseHas('properties', [
            'title' => 'My New Flat',
            'locality_id' => $locality->id,
            'property_type' => 'flat',
            'bhk' => 2,
            'created_by' => $customer->id,
            'publication_status' => 'draft',
        ]);
    }

    public function test_customer_can_update_property_draft_in_step_2()
    {
        $customer = User::factory()->create();
        $customer->assignRole('customer');
        
        $locality = Locality::create(['name' => 'Test Locality', 'slug' => 'test-locality']);

        // Manually create a step 1 draft
        $property = Property::create([
            'property_code' => 'OF-0001',
            'title' => 'My New Flat',
            'locality_id' => $locality->id,
            'property_type' => 'flat',
            'bhk' => 2,
            'created_by' => $customer->id,
            'publication_status' => 'draft',
            'verification_status' => 'pending',
        ]);

        $data = [
            'step' => 2,
            'property_id' => $property->id,
            'rent' => 15000,
            'deposit' => 15000,
            'area' => 900,
            'floor' => '2nd',
            'furnishing' => 'furnished',
            'availability' => 'immediate',
        ];

        $response = $this->actingAs($customer)
            ->postJson(route('customer.properties.store-step'), $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('properties', [
            'id' => $property->id,
            'rent' => 15000,
            'deposit' => 15000,
            'area' => 900,
            'furnishing' => 'furnished',
        ]);
    }
}
