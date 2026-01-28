<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $permissions = [
            // ================= Dashboard =================
            ['name'=>'Dashboard','guard_name'=>'web','created_at'=>now(),'updated_at'=>now()],

            // ================= Role Management =================
            ['name'=>'Role List','guard_name'=>'web','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Role Create','guard_name'=>'web','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Role Edit','guard_name'=>'web','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Role Delete','guard_name'=>'web','created_at'=>now(),'updated_at'=>now()],

            // ================= Permission Management =================
            ['name'=>'Permission List','guard_name'=>'web','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Permission Create','guard_name'=>'web','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Permission Edit','guard_name'=>'web','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Permission Delete','guard_name'=>'web','created_at'=>now(),'updated_at'=>now()],

            // ================= Client Management =================
            ['name'=>'Client List','guard_name'=>'web','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Client Create','guard_name'=>'web','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Client Edit','guard_name'=>'web','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Client Delete','guard_name'=>'web','created_at'=>now(),'updated_at'=>now()],

            // ================= Contact Management =================
            ['name'=>'Contact List','guard_name'=>'web','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Contact Create','guard_name'=>'web','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Contact Edit','guard_name'=>'web','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Contact Delete','guard_name'=>'web','created_at'=>now(),'updated_at'=>now()],

            // ================== Project Management =================
            ['name'=>'Project List','guard_name'=>'web','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Project Create','guard_name'=>'web','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Project Edit','guard_name'=>'web','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Project Delete','guard_name'=>'web','created_at'=>now(),'updated_at'=>now()],

            // ================== Ticket Management =================
            ['name'=>'Ticket List','guard_name'=>'web','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Ticket Create','guard_name'=>'web','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Ticket Edit','guard_name'=>'web','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Ticket Delete','guard_name'=>'web','created_at'=>now(),'updated_at'=>now()],

            // ================== Task Management =================
            ['name'=>'Task List','guard_name'=>'web','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Task Create','guard_name'=>'web','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Task Edit','guard_name'=>'web','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Task Delete','guard_name'=>'web','created_at'=>now(),'updated_at'=>now()],

            // ================== Payment Management =================
            ['name'=>'Payment List','guard_name'=>'web','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Payment Create','guard_name'=>'web','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Payment Edit','guard_name'=>'web','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Payment Delete','guard_name'=>'web','created_at'=>now(),'updated_at'=>now()],

            // ================== Invoice Management =================
            ['name'=>'Invoice List','guard_name'=>'web','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Invoice Create','guard_name'=>'web','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Invoice Edit','guard_name'=>'web','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Invoice Delete','guard_name'=>'web','created_at'=>now(),'updated_at'=>now()],


          
        ];

        Permission::insert($permissions);
    }
}
