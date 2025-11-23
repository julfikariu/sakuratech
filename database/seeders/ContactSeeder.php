<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon as Carbon;
use Faker\Factory as Faker;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $now = Carbon::now();

        $subjects = [
            'Website Inquiry',
            'Partnership Opportunity',
            'Product Information',
            'Technical Support',
            'General Question',
            'Feedback',
            'Complaint',
            'Career Opportunity',
            'Press Inquiry',
            'Billing Question'
        ];

        for ($i = 1; $i <= 50; $i++) {
            DB::table('contacts')->insert([
                'id' => $i,
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'subject' => $faker->randomElement($subjects),
                'message' => $faker->paragraph(3),
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => $now,
            ]);
        }

    }
}
