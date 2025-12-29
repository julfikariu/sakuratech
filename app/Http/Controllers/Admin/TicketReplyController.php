<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TicketReply\TicketReplyRequest;
use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TicketReplyController extends Controller
{
    use AuthorizesRequests;

    public function store(Ticket $ticket, TicketReplyRequest $request)
    {
        // $this->authorize('view', $ticket);

        TicketReply::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);

        return redirect()->route('admin.tickets.show', $ticket->id)->with('flash', [
            'message' => 'Reply posted!',
            'type' => 'success',
        ]);
    }

    public function destroy(Ticket $ticket, TicketReply $reply): RedirectResponse
    {
        $this->authorize('delete', $reply);

        $reply->delete();

        return redirect()->route('admin.tickets.show', $ticket->id)->with('flash', [
            'message' => 'Reply deleted!',
            'type' => 'success',
        ]);
    }
}
