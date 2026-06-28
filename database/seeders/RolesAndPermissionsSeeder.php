<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'manage properties',
            'verify properties',
            'manage agents',
            'manage leads',
            'manage bookings',
            'view reports',
            'edit lead notes',
            'update lead status',
            'save properties',
            'book office visit',
            'view booking history'
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        // Create roles and assign created permissions

        // Admin role gets all permissions
        $adminRole = Role::findOrCreate('admin');
        $adminRole->givePermissionTo(Permission::all());

        // Agent role
        $agentRole = Role::findOrCreate('agent');
        $agentRole->givePermissionTo([
            'manage properties',
            'manage leads',
            'edit lead notes',
            'update lead status',
            'view booking history'
        ]);

        // Customer role
        $customerRole = Role::findOrCreate('customer');
        $customerRole->givePermissionTo([
            'save properties',
            'book office visit',
            'view booking history'
        ]);
    }
}
