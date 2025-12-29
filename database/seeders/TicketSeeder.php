<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\User;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        Ticket::factory()->count(15)->create()->each(function ($ticket) {
            $users = User::pluck('id')->toArray();
            $count = rand(0, 3);
            for ($i = 0; $i < $count; $i++) {
                TicketReply::create([
                    'ticket_id' => $ticket->id,
                    'user_id' => $users[array_rand($users)],
                    'message' => 'Sample reply: ' . fake()->sentence(),
                ]);
            }
        });
    }
}
