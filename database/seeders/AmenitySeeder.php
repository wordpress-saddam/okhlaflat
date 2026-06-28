<?php

namespace Database\Seeders;

use App\Models\Amenity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AmenitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $amenities = [
            'Air Conditioning' => 'ac',
            'Wi-Fi' => 'wifi',
            'Geyser' => 'geyser',
            'Two Wheeler Parking' => 'parking-bike',
            'Four Wheeler Parking' => 'parking-car',
            'Elevator / Lift' => 'lift',
            'CCTV Security' => 'cctv',
            'Power Backup' => 'power',
            'Gymnasium' => 'gym',
            'Semi-Furnished' => 'semi-furnished',
            'Fully-Furnished' => 'furnished'
        ];

        foreach ($amenities as $name => $icon) {
            Amenity::firstOrCreate([
                'slug' => Str::slug($name)
            ], [
                'name' => $name,
                'icon' => $icon
            ]);
        }
    }
}
