<?php

namespace Tests\Feature;

use App\Models\Locality;
use App\Models\Property;
use App\Models\User;
use App\Models\VisitRequest;
use App\Notifications\NewVisitRequestAdminAlert;
use App\Notifications\VisitAssignedAgentAlert;
use App\Notifications\VisitRequestAssigned;
use App\Notifications\VisitRequestScheduled;
use App\Notifications\VisitRequestStatusUpdated;
use App\Notifications\VisitRequestSubmitted;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class VisitNotificationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'RolesAndPermissionsSeeder']);
    }

    public function test_customer_booking_triggers_notifications()
    {
        Notification::fake();

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

        // Customer notification
        Notification::assertSentTo(
            $customer,
            VisitRequestSubmitted::class,
            function ($notification, $channels) use ($property) {
                return in_array('mail', $channels);
            }
        );

        // Admin notifications
        Notification::assertSentTo(
            $admin,
            NewVisitRequestAdminAlert::class,
            function ($notification, $channels) {
                return in_array('mail', $channels);
            }
        );
    }

    public function test_admin_assignment_triggers_notifications()
    {
        Notification::fake();

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

        // Customer notification
        Notification::assertSentTo(
            $customer,
            VisitRequestAssigned::class
        );

        // Agent notification
        Notification::assertSentTo(
            $agent,
            VisitAssignedAgentAlert::class
        );
    }

    public function test_agent_scheduling_triggers_notification()
    {
        Notification::fake();

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

        // Customer notification
        Notification::assertSentTo(
            $customer,
            VisitRequestScheduled::class
        );
    }

    public function test_agent_status_updates_triggers_notifications()
    {
        Notification::fake();

        $agent = User::factory()->create();
        $agent->assignRole('agent');

        $customer = User::factory()->create();
        $customer->assignRole('customer');

        $visit = VisitRequest::create([
            'customer_id' => $customer->id,
            'agent_id' => $agent->id,
            'status' => 'scheduled',
            'scheduled_at' => '2026-07-15 14:30:00',
        ]);

        // Complete the visit
        $response = $this->actingAs($agent)->put(route('agent.visits.update', $visit), [
            'status' => 'completed',
        ]);

        $response->assertRedirect(route('agent.visits.index'));

        Notification::assertSentTo(
            $customer,
            VisitRequestStatusUpdated::class,
            function ($notification) use ($customer) {
                return $notification->toMail($customer)->subject === 'Visit Completed - OkhlaFlat';
            }
        );

        // Reset fake for cancellation test
        Notification::fake();

        $visit2 = VisitRequest::create([
            'customer_id' => $customer->id,
            'agent_id' => $agent->id,
            'status' => 'scheduled',
            'scheduled_at' => '2026-07-15 14:30:00',
        ]);

        // Cancel the visit
        $response2 = $this->actingAs($agent)->put(route('agent.visits.update', $visit2), [
            'status' => 'cancelled',
        ]);

        $response2->assertRedirect(route('agent.visits.index'));

        Notification::assertSentTo(
            $customer,
            VisitRequestStatusUpdated::class,
            function ($notification) use ($customer) {
                return $notification->toMail($customer)->subject === 'Visit Cancelled - OkhlaFlat';
            }
        );
    }
}
