<?php

namespace Database\Seeders;

use App\Models\Locality;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LocalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $localities = [
            'Batla House',
            'Zakir Nagar',
            'Abul Fazal Enclave',
            'Shaheen Bagh',
            'Okhla Vihar',
            'Ghaffar Manzil',
            'Johri Farm',
            'Jasola'
        ];

        foreach ($localities as $localityName) {
            Locality::firstOrCreate([
                'slug' => Str::slug($localityName)
            ], [
                'name' => $localityName,
                'description' => $localityName . ' area in Jamia Nagar',
                'is_active' => true
            ]);
        }
    }
}
