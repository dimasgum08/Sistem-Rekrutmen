<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $humanResource = Role::create([
            'name' => 'HRD',
            'display_name' => 'HRD',
            'guard_name' => 'web',
        ]);

        $admin = Role::create([
            'name' => 'Admin',
            'display_name' => 'Administrator',
            'guard_name' => 'web',
        ]);

        $applicant = Role::create([
            'name' => 'Applicant',
            'display_name' => 'Pelamar',
            'guard_name' => 'web',
        ]);
        $admin->givePermissionTo([
            'read-dashboard',
            'read-users', 'create-users', 'update-users', 'delete-users',
        ]);
        $humanResource->givePermissionTo([
            'read-dashboard',
            'read-users', 'create-users', 'update-users', 'delete-users',
        ]);
        $applicant->givePermissionTo([
            'read-dashboard',
        ]);
    }
}
