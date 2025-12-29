<?php

namespace Database\Factories;

use App\Models\TicketReply;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketReplyFactory extends Factory
{
    protected $model = TicketReply::class;

    public function definition()
    {
        $users = User::pluck('id')->toArray();
        $tickets = Ticket::pluck('id')->toArray();

        return [
            'ticket_id' => $this->faker->randomElement($tickets) ?? 1,
            'user_id' => $this->faker->randomElement($users) ?? 1,
            'message' => $this->faker->paragraph(),
        ];
    }
}
