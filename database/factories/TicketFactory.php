<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition()
    {
        $users = User::pluck('id')->toArray();
        return [
            'user_id' => $this->faker->randomElement($users) ?? 1,
            'assignee_id' => $this->faker->boolean(30) ? $this->faker->randomElement($users) : null,
            'title' => $this->faker->sentence(6),
            'description' => $this->faker->paragraph(),
            'priority' => $this->faker->randomElement([Ticket::PRIORITY_LOW, Ticket::PRIORITY_MEDIUM, Ticket::PRIORITY_HIGH]),
            'status' => $this->faker->randomElement([Ticket::STATUS_OPEN, Ticket::STATUS_PENDING, Ticket::STATUS_CLOSED]),
        ];
    }
}
