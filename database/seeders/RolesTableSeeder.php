<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            [
                'name'        => 'Admin',
                'guard_name'  => 'web',
                'description' => 'Full access to everything',
                'created_at'  => now(),
                'updated_at'  => now(),
            ], [
                'name'        => 'Staff/Employee Manager',
                'guard_name'  => 'web',
                'description' => 'Access to their assigned data',
                'created_at'  => now(),
                'updated_at'  => now(),
            ], [
                'name'        => 'Client',
                'guard_name'  => 'web',
                'description' => 'Can manage their own data',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
