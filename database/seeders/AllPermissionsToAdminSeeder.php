<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AllPermissionsToAdminSeeder extends Seeder
{
    public function run()
    {
        // Find role ID 1
        $role = Role::find(1);

        if (!$role) {
            $this->command->warn("Role ID 1 not found!");
            return;
        }

        // Get all permissions
        $permissions = Permission::all();

        if ($permissions->isEmpty()) {
            $this->command->warn("No permissions found!");
            return;
        }

        // Assign all permissions to the role
        $role->syncPermissions($permissions);

        $this->command->info("All permissions assigned to Role ID 1 successfully!");
    }
}
