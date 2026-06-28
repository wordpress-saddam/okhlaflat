<?php

namespace Tests\Feature;

use App\Models\Locality;
use App\Models\Property;
use App\Models\User;
use App\Models\VisitRequest;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerReviewTest extends TestCase
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
            'name' => 'Abul Fazal',
            'slug' => 'abul-fazal',
            'is_active' => true
        ]);

        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');

        $this->agent = User::factory()->create();
        $this->agent->assignRole('agent');

        $this->customer = User::factory()->create();
        $this->customer->assignRole('customer');

        $property = Property::create([
            'property_code' => 'OF-8888',
            'title' => 'Abul Fazal 2 BHK',
            'rent' => 15000,
            'deposit' => 30000,
            'property_type' => 'flat',
            'bhk' => 2,
            'area' => 900,
            'floor' => '2nd',
            'furnishing' => 'semi-furnished',
            'availability' => 'immediate',
            'approximate_location' => 'Thana Road',
            'exact_address' => 'Gali 4',
            'building_number' => '40',
            'owner_name' => 'Malik',
            'owner_contact' => '8888888888',
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

    public function test_customer_cannot_review_incomplete_visit()
    {
        // Visit is currently scheduled, not completed
        $response = $this->actingAs($this->customer)->get(route('customer.reviews.create', $this->visit));
        $response->assertStatus(403);

        $responsePost = $this->actingAs($this->customer)->post(route('customer.reviews.store', $this->visit), [
            'property_rating' => 5,
            'agent_rating' => 4,
            'comment' => 'Great experience'
        ]);
        $responsePost->assertStatus(403);
    }

    public function test_customer_can_submit_valid_review_for_completed_visit()
    {
        $this->visit->update(['status' => 'completed']);

        $response = $this->actingAs($this->customer)->get(route('customer.reviews.create', $this->visit));
        $response->assertStatus(200);

        $responsePost = $this->actingAs($this->customer)->post(route('customer.reviews.store', $this->visit), [
            'property_rating' => 4,
            'agent_rating' => 5,
            'comment' => 'Very satisfied with the flat and the coordinator.'
        ]);

        $responsePost->assertRedirect(route('customer.dashboard'));
        $responsePost->assertSessionHas('success');

        $this->assertDatabaseHas('reviews', [
            'visit_request_id' => $this->visit->id,
            'property_id' => $this->visit->property_id,
            'customer_id' => $this->customer->id,
            'agent_id' => $this->agent->id,
            'property_rating' => 4,
            'agent_rating' => 5,
            'comment' => 'Very satisfied with the flat and the coordinator.',
        ]);

        // Check model averages
        $property = $this->visit->property;
        $this->assertEquals(4.0, $property->averageRating());
        
        $this->assertEquals(5.0, $this->agent->averageAgentRating());
    }

    public function test_customer_cannot_submit_duplicate_reviews()
    {
        $this->visit->update(['status' => 'completed']);

        // First review
        Review::create([
            'visit_request_id' => $this->visit->id,
            'property_id' => $this->visit->property_id,
            'customer_id' => $this->customer->id,
            'agent_id' => $this->agent->id,
            'property_rating' => 5,
            'agent_rating' => 5,
        ]);

        // Attempting to visit review page again should redirect
        $response = $this->actingAs($this->customer)->get(route('customer.reviews.create', $this->visit));
        $response->assertRedirect(route('customer.dashboard'));
        $response->assertSessionHas('error');

        // Attempting to post review again should redirect with error
        $responsePost = $this->actingAs($this->customer)->post(route('customer.reviews.store', $this->visit), [
            'property_rating' => 4,
            'agent_rating' => 4,
        ]);
        $responsePost->assertRedirect(route('customer.dashboard'));
        $responsePost->assertSessionHas('error');
    }

    public function test_unauthorized_user_cannot_submit_review()
    {
        $this->visit->update(['status' => 'completed']);

        $otherCustomer = User::factory()->create();
        $otherCustomer->assignRole('customer');

        $response = $this->actingAs($otherCustomer)->get(route('customer.reviews.create', $this->visit));
        $response->assertStatus(403);

        $responsePost = $this->actingAs($otherCustomer)->post(route('customer.reviews.store', $this->visit), [
            'property_rating' => 5,
            'agent_rating' => 5,
        ]);
        $responsePost->assertStatus(403);
    }

    public function test_review_validation_rules()
    {
        $this->visit->update(['status' => 'completed']);

        // Out of bounds property rating (6)
        $response = $this->actingAs($this->customer)->post(route('customer.reviews.store', $this->visit), [
            'property_rating' => 6,
            'agent_rating' => 5,
        ]);
        $response->assertSessionHasErrors(['property_rating']);

        // Negative property rating (0)
        $responseNeg = $this->actingAs($this->customer)->post(route('customer.reviews.store', $this->visit), [
            'property_rating' => 0,
            'agent_rating' => 3,
        ]);
        $responseNeg->assertSessionHasErrors(['property_rating']);
    }
}
