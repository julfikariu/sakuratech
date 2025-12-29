<?php

namespace App\Policies;

use App\Models\TicketReply;
use App\Models\User;

class TicketReplyPolicy
{
    public function delete(User $user, TicketReply $reply): bool
    {
        return $user->id === $reply->user_id || $user->id === $reply->ticket->user_id || $user->id === $reply->ticket->assignee_id;
    }
}
