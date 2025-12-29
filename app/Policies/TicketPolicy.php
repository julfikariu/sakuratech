<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    public function view(User $user, Ticket $ticket): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Ticket $ticket): bool
    {
        return $user->id === $ticket->user_id || $user->id === $ticket->assignee_id;
    }

    public function delete(User $user, Ticket $ticket): bool
    {
        return $user->id === $ticket->user_id || $user->id === $ticket->assignee_id;
    }

    public function changeStatus(User $user, Ticket $ticket): bool
    {
        return $user->id === $ticket->assignee_id || $user->id === $ticket->user_id;
    }
}
