<?php

namespace Tests\Feature;

use App\Models\Locality;
use App\Models\Property;
use App\Models\User;
use App\Models\VisitRequest;
use App\Models\Deal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DealClosingTest extends TestCase
{
    use RefreshDatabase;

    protected $locality;
    protected $admin;
    protected $agent;
    protected $customer;
    protected $visit;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'RolesAndPermissionsSeeder']);

        $this->locality = Locality::create([
            'name' => 'Shaheen Bagh',
            'slug' => 'shaheen-bagh',
            'is_active' => true
        ]);

        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');

        $this->agent = User::factory()->create();
        $this->agent->assignRole('agent');

        $this->customer = User::factory()->create();
        $this->customer->assignRole('customer');

        $property = Property::create([
            'property_code' => 'OF-9999',
            'title' => 'Shaheen Bagh 3 BHK',
            'rent' => 20000,
            'deposit' => 40000,
            'property_type' => 'flat',
            'bhk' => 3,
            'area' => 1200,
            'floor' => '3rd',
            'furnishing' => 'furnished',
            'availability' => 'immediate',
            'approximate_location' => 'Main Road',
            'exact_address' => 'Gali 9',
            'building_number' => '100',
            'owner_name' => 'Ali Sahab',
            'owner_contact' => '9999988888',
            'verification_status' => 'verified',
            'publication_status' => 'published',
            'locality_id' => $this->locality->id,
            'created_by' => $this->admin->id,
        ]);

        $this->visit = VisitRequest::create([
            'property_id' => $property->id,
            'customer_id' => $this->customer->id,
            'agent_id' => $this->agent->id,
            'status' => 'scheduled',
        ]);
    }

    public function test_assigned_agent_can_close_deal()
    {
        Storage::fake('public');

        $agreement = UploadedFile::fake()->create('agreement.pdf', 100);
        $idProof = UploadedFile::fake()->image('id_proof.jpg');

        $payload = [
            'visit_request_id' => $this->visit->id,
            'property_id' => $this->visit->property_id,
            'rent_amount' => 18000, // Negotiated rent
            'agreement_doc' => $agreement,
            'id_proof' => $idProof,
        ];

        $response = $this->actingAs($this->agent)->post(route('agent.deals.store'), $payload);

        $response->assertRedirect(route('agent.visits.index'));
        $response->assertSessionHasNoErrors();

        // Verify visit status is completed
        $this->visit->refresh();
        $this->assertEquals('completed', $this->visit->status);

        // Verify property is archived
        $property = $this->visit->property;
        $property->refresh();
        $this->assertEquals('archived', $property->publication_status);

        // Verify deal record
        $this->assertDatabaseHas('deals', [
            'visit_request_id' => $this->visit->id,
            'property_id' => $property->id,
            'rent_amount' => 18000,
            'service_fee' => 4500, // 25% of 18000
            'payment_status' => 'pending_payment',
        ]);

        // Verify file storage
        $deal = Deal::first();
        Storage::disk('public')->assertExists($deal->agreement_doc_path);
        Storage::disk('public')->assertExists($deal->id_proof_path);
    }

    public function test_unauthorized_agent_cannot_close_deal()
    {
        $otherAgent = User::factory()->create();
        $otherAgent->assignRole('agent');

        $response = $this->actingAs($otherAgent)->get(route('agent.deals.create', $this->visit));
        $response->assertStatus(403);
    }

    public function test_invoice_access_rules()
    {
        // Close a deal first
        $deal = Deal::create([
            'visit_request_id' => $this->visit->id,
            'property_id' => $this->visit->property_id,
            'customer_id' => $this->customer->id,
            'agent_id' => $this->agent->id,
            'rent_amount' => 20000,
            'service_fee' => 5000,
            'closed_at' => now(),
        ]);

        // Agent can access
        $this->actingAs($this->agent)->get(route('agent.deals.invoice', $deal))->assertStatus(200);

        // Admin can access
        $this->actingAs($this->admin)->get(route('admin.deals.invoice', $deal))->assertStatus(200);

        // Customer can access
        $this->actingAs($this->customer)->get(route('customer.deals.invoice', $deal))->assertStatus(200);

        // Other agent cannot access
        $otherAgent = User::factory()->create();
        $otherAgent->assignRole('agent');
        $this->actingAs($otherAgent)->get(route('agent.deals.invoice', $deal))->assertStatus(403);
    }

    public function test_admin_can_update_payment_status()
    {
        $deal = Deal::create([
            'visit_request_id' => $this->visit->id,
            'property_id' => $this->visit->property_id,
            'customer_id' => $this->customer->id,
            'agent_id' => $this->agent->id,
            'rent_amount' => 20000,
            'service_fee' => 5000,
            'payment_status' => 'pending_payment',
            'closed_at' => now(),
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.deals.payment-status', $deal), [
            'payment_status' => 'paid',
        ]);

        $response->assertSessionHasNoErrors();
        $deal->refresh();
        $this->assertEquals('paid', $deal->payment_status);

        // Agent cannot update payment status
        $responseAgent = $this->actingAs($this->agent)->post(route('admin.deals.payment-status', $deal), [
            'payment_status' => 'written_off',
        ]);
        $responseAgent->assertStatus(403);
    }
}
