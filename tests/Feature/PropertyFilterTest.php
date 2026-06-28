<?php

namespace Tests\Feature;

use App\Models\Locality;
use App\Models\Amenity;
use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyFilterTest extends TestCase
{
    use RefreshDatabase;

    protected $locality;
    protected $admin;
    protected $wifi;
    protected $ac;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'RolesAndPermissionsSeeder']);

        $this->locality = Locality::create([
            'name' => 'Batla House',
            'slug' => 'batla-house',
            'is_active' => true
        ]);

        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');

        $this->wifi = Amenity::create(['name' => 'Wi-Fi', 'slug' => 'wi-fi', 'icon' => 'wifi']);
        $this->ac = Amenity::create(['name' => 'Air Conditioning', 'slug' => 'air-conditioning', 'icon' => 'ac']);
    }

    private function createProperty(array $overrides)
    {
        $defaults = [
            'title' => 'Sample Property',
            'rent' => 12000,
            'deposit' => 24000,
            'property_type' => 'flat',
            'bhk' => 2,
            'area' => 800,
            'floor' => '2nd',
            'furnishing' => 'semi-furnished',
            'availability' => 'immediate',
            'approximate_location' => 'Batla House near mosque',
            'nearest_metro' => 'Okhla Vihar',
            'exact_address' => 'Gali 2',
            'building_number' => '12',
            'owner_name' => 'Zakir Sahab',
            'owner_contact' => '9876543210',
            'verification_status' => 'verified',
            'publication_status' => 'published',
            'locality_id' => $this->locality->id,
            'created_by' => $this->admin->id,
        ];

        // Generate unique property code if not provided
        if (!isset($overrides['property_code'])) {
            $overrides['property_code'] = 'OF-' . rand(1000, 9999);
        }

        return Property::create(array_merge($defaults, $overrides));
    }

    public function test_filter_by_property_type()
    {
        $flat = $this->createProperty(['property_type' => 'flat', 'title' => 'Flat Property']);
        $house = $this->createProperty(['property_type' => 'house', 'title' => 'House Property']);

        $response = $this->get(route('properties.index', ['property_type' => 'flat']));
        $response->assertStatus(200);
        $response->assertSee($flat->title);
        $response->assertDontSee($house->title);
    }

    public function test_filter_by_rent_range()
    {
        $cheap = $this->createProperty(['rent' => 8000, 'title' => 'Cheap Property']);
        $mid = $this->createProperty(['rent' => 12000, 'title' => 'Mid Property']);
        $expensive = $this->createProperty(['rent' => 20000, 'title' => 'Expensive Property']);

        $response = $this->get(route('properties.index', ['min_rent' => 10000, 'max_rent' => 15000]));
        $response->assertStatus(200);
        $response->assertSee($mid->title);
        $response->assertDontSee($cheap->title);
        $response->assertDontSee($expensive->title);
    }

    public function test_filter_by_nearest_metro()
    {
        $okhlaMetro = $this->createProperty(['nearest_metro' => 'Okhla Vihar', 'title' => 'Okhla Metro Property']);
        $jasolaMetro = $this->createProperty(['nearest_metro' => 'Jasola', 'title' => 'Jasola Metro Property']);

        $response = $this->get(route('properties.index', ['nearest_metro' => 'Okhla']));
        $response->assertStatus(200);
        $response->assertSee($okhlaMetro->title);
        $response->assertDontSee($jasolaMetro->title);
    }

    public function test_filter_by_amenities()
    {
        $propBoth = $this->createProperty(['title' => 'Wi-Fi and AC Property']);
        $propBoth->amenities()->attach([$this->wifi->id, $this->ac->id]);

        $propWifiOnly = $this->createProperty(['title' => 'Wi-Fi Only Property']);
        $propWifiOnly->amenities()->attach([$this->wifi->id]);

        // Requesting both Wi-Fi and AC
        $response = $this->get(route('properties.index', ['amenity_ids' => [$this->wifi->id, $this->ac->id]]));
        $response->assertStatus(200);
        $response->assertSee($propBoth->title);
        $response->assertDontSee($propWifiOnly->title);
    }

    public function test_sorting_by_rent()
    {
        $cheap = $this->createProperty(['rent' => 8000, 'title' => 'Cheap Property']);
        $mid = $this->createProperty(['rent' => 12000, 'title' => 'Mid Property']);
        $expensive = $this->createProperty(['rent' => 20000, 'title' => 'Expensive Property']);

        // Rent Low to High
        $responseAsc = $this->get(route('properties.index', ['sort_by' => 'rent_asc']));
        $responseAsc->assertStatus(200);
        
        $contentAsc = $responseAsc->getContent();
        $posCheap = strpos($contentAsc, 'Cheap Property');
        $posMid = strpos($contentAsc, 'Mid Property');
        $posExpensive = strpos($contentAsc, 'Expensive Property');

        $this->assertTrue($posCheap < $posMid);
        $this->assertTrue($posMid < $posExpensive);

        // Rent High to Low
        $responseDesc = $this->get(route('properties.index', ['sort_by' => 'rent_desc']));
        $responseDesc->assertStatus(200);
        
        $contentDesc = $responseDesc->getContent();
        $posCheapDesc = strpos($contentDesc, 'Cheap Property');
        $posMidDesc = strpos($contentDesc, 'Mid Property');
        $posExpensiveDesc = strpos($contentDesc, 'Expensive Property');

        $this->assertTrue($posExpensiveDesc < $posMidDesc);
        $this->assertTrue($posMidDesc < $posCheapDesc);
    }
}
