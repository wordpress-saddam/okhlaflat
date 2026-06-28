<?php

namespace Tests\Feature;

use App\Models\Locality;
use App\Models\Property;
use App\Models\User;
use App\Models\VisitRequest;
use App\Models\Deal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_displays_correct_dynamic_metrics()
    {
        $this->artisan('db:seed', ['--class' => 'RolesAndPermissionsSeeder']);

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $agent = User::factory()->create();
        $agent->assignRole('agent');

        $customer = User::factory()->create();
        $customer->assignRole('customer');

        $locality = Locality::create([
            'name' => 'Zakir Nagar',
            'slug' => 'zakir-nagar',
            'is_active' => true
        ]);

        // Create 3 properties: 2 verified/published, 1 draft
        $prop1 = Property::create([
            'property_code' => 'OF-1111',
            'title' => 'Live Property One',
            'rent' => 10000,
            'deposit' => 20000,
            'property_type' => 'flat',
            'bhk' => 1,
            'area' => 500,
            'floor' => '1st',
            'furnishing' => 'unfurnished',
            'availability' => 'immediate',
            'approximate_location' => 'Zakir Nagar Gate',
            'exact_address' => 'Gali 1',
            'building_number' => '1',
            'owner_name' => 'Owner A',
            'owner_contact' => '1111111111',
            'verification_status' => 'verified',
            'publication_status' => 'published',
            'locality_id' => $locality->id,
            'created_by' => $admin->id,
        ]);

        $prop2 = Property::create([
            'property_code' => 'OF-2222',
            'title' => 'Live Property Two',
            'rent' => 20000,
            'deposit' => 40000,
            'property_type' => 'flat',
            'bhk' => 2,
            'area' => 800,
            'floor' => '2nd',
            'furnishing' => 'semi-furnished',
            'availability' => 'immediate',
            'approximate_location' => 'Zakir Nagar Market',
            'exact_address' => 'Gali 2',
            'building_number' => '2',
            'owner_name' => 'Owner B',
            'owner_contact' => '2222222222',
            'verification_status' => 'verified',
            'publication_status' => 'published',
            'locality_id' => $locality->id,
            'created_by' => $admin->id,
        ]);

        $propDraft = Property::create([
            'property_code' => 'OF-3333',
            'title' => 'Draft Property',
            'rent' => 30000,
            'deposit' => 60000,
            'property_type' => 'house',
            'bhk' => 3,
            'area' => 1500,
            'floor' => 'Ground',
            'furnishing' => 'furnished',
            'availability' => 'immediate',
            'approximate_location' => 'Johri Farm',
            'exact_address' => 'Gali 3',
            'building_number' => '3',
            'owner_name' => 'Owner C',
            'owner_contact' => '3333333333',
            'verification_status' => 'pending',
            'publication_status' => 'draft',
            'locality_id' => $locality->id,
            'created_by' => $admin->id,
        ]);

        // Create 3 visit requests: 1 pending, 1 scheduled, 1 completed
        $visitPending = VisitRequest::create([
            'property_id' => $prop1->id,
            'customer_id' => $customer->id,
            'status' => 'pending',
        ]);

        $visitScheduled = VisitRequest::create([
            'property_id' => $prop2->id,
            'customer_id' => $customer->id,
            'agent_id' => $agent->id,
            'status' => 'scheduled',
            'scheduled_at' => now()->addDays(2),
        ]);

        $visitCompleted = VisitRequest::create([
            'property_id' => $prop1->id,
            'customer_id' => $customer->id,
            'agent_id' => $agent->id,
            'status' => 'completed',
        ]);

        // Create 2 deals: 1 paid (from prop1 completed visit), 1 pending_payment (other deal)
        Deal::create([
            'visit_request_id' => $visitCompleted->id,
            'property_id' => $prop1->id,
            'customer_id' => $customer->id,
            'agent_id' => $agent->id,
            'rent_amount' => 10000,
            'service_fee' => 2500,
            'payment_status' => 'paid',
            'closed_at' => now(),
        ]);

        Deal::create([
            'property_id' => $prop2->id,
            'customer_id' => $customer->id,
            'agent_id' => $agent->id,
            'rent_amount' => 20000,
            'service_fee' => 5000,
            'payment_status' => 'pending_payment',
            'closed_at' => now(),
        ]);

        // Fetch dashboard
        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);

        // Assert core metrics are passed to view
        $response->assertViewHas('totalFlats', 3);
        $response->assertViewHas('verifiedFlats', 2);
        $response->assertViewHas('activeLeads', 2); // pending + scheduled
        $response->assertViewHas('scheduledVisits', 1);

        // Assert revenue calculations
        $response->assertViewHas('totalRevenue', 2500);
        $response->assertViewHas('pendingRevenue', 5000);
        
        // Conversion rate: 1 completed out of 3 requests = 33.3%
        $response->assertViewHas('conversionRate', 33.3);

        // Assert HTML contains the metric data
        $response->assertSee('₹2,500');
        $response->assertSee('₹5,000');
        $response->assertSee('33.3%');
    }
}
