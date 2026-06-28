<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Roles and Permissions
        $this->call(RolesAndPermissionsSeeder::class);

        // 2. Seed Localities & Amenities
        $this->call(LocalitySeeder::class);
        $this->call(AmenitySeeder::class);

        // 3. Create Administrator
        $admin = User::firstOrCreate([
            'email' => 'admin@okhlaflat.com'
        ], [
            'name' => 'Admin User',
            'mobile' => '9999999991',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');

        // 4. Create Agent
        $agent = User::firstOrCreate([
            'email' => 'agent@okhlaflat.com'
        ], [
            'name' => 'Agent Saddam',
            'mobile' => '9999999992',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);
        $agent->assignRole('agent');

        // 5. Create Customer
        $customer = User::firstOrCreate([
            'email' => 'customer@okhlaflat.com'
        ], [
            'name' => 'Customer Imran',
            'mobile' => '9999999993',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);
        $customer->assignRole('customer');
    }
}
