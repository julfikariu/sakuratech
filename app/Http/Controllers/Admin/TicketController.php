<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Ticket;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Ticket\TicketRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class TicketController extends Controller
{
     use AuthorizesRequests;
    public function index()
    {
        $paginator = Ticket::latest()->paginate(10)->withQueryString();

        $paginator->getCollection()->transform(function ($ticket) {
            return [
                'id' => $ticket->id,
                'title' => $ticket->title,
                'priority' => $ticket->priority,
                'status' => $ticket->status,
                'assignee_name' => $ticket->assignee?->name ?? null,
                'created_at' => $ticket->created_at?->format('d M Y, h:i A'),
            ];
        });

        return Inertia::render('admin/tickets/Index', [
            'tickets' => $paginator,
        ]);
    }

    public function create()
    {
        $users = User::all()->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
            ];
        });

        return Inertia::render('admin/tickets/Form', [
            'is_edit' => false,
            'users' => $users,
        ]);
    }

    public function store(TicketRequest $request)
    {
        Ticket::create([
            'user_id' => auth()->id(),
            'assignee_id' => $request->assignee_id,
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.tickets.index')->with('flash', [
            'message' => 'Ticket created successfully!',
            'type' => 'success',
        ]);
    }

    public function show(Ticket $ticket)
    {
        $replies = $ticket->replies()->with('user')->get()->map(function ($reply) use ($ticket) {
            return [
                'id' => $reply->id,
                'message' => $reply->message,
                'user' => [
                    'id' => $reply->user->id,
                    'name' => $reply->user->name,
                ],
                'created_at' => $reply->created_at?->format('d M Y, h:i A'),
                'can_delete' => auth()->id() === $reply->user_id || auth()->id() === $ticket->user_id || auth()->id() === $ticket->assignee_id,
            ];
        });

        $data = [
            'id' => $ticket->id,
            'title' => $ticket->title,
            'description' => $ticket->description,
            'priority' => $ticket->priority,
            'status' => $ticket->status,
            'assignee' => $ticket->assignee ? [
                'id' => $ticket->assignee->id,
                'name' => $ticket->assignee->name,
            ] : null,
            'replies' => $replies->toArray(),
            'created_at' => $ticket->created_at?->format('d M Y, h:i A'),
        ];

        return Inertia::render('admin/tickets/Details', [
            'ticket' => $data,
        ]);
    }

    public function edit(Ticket $ticket)
    {

        // $this->authorize('update', $ticket);

        $users = User::all()->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
            ];
        });

        $data = [
            'id' => $ticket->id,
            'title' => $ticket->title,
            'description' => $ticket->description,
            'priority' => $ticket->priority,
            'status' => $ticket->status,
            'assignee_id' => $ticket->assignee_id,
        ];

        return Inertia::render('admin/tickets/Form', [
            'ticket' => $data,
            'users' => $users,
            'is_edit' => true,
        ]);
    }

    public function update(TicketRequest $request, Ticket $ticket)
    {
        // $this->authorize(ability: User::class, Ticket::class);
        $this->authorize('update', $ticket);

        $ticket->update([
            'assignee_id' => $request->assignee_id,
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.tickets.index')->with('flash', [
            'message' => 'Ticket updated successfully!',
            'type' => 'success',
        ]);
    }

    public function changeStatus(Ticket $ticket)
    {

        $status = request()->input('status');
        if (!in_array($status, [Ticket::STATUS_OPEN, Ticket::STATUS_PENDING, Ticket::STATUS_CLOSED])) {
            return redirect()->back()->with('flash', [
                'message' => 'Invalid status',
                'type' => 'danger',
            ]);
        }

        $ticket->update(['status' => $status]);

        return redirect()->route('admin.tickets.index')->with('flash', [
            'message' => 'Status updated!',
            'type' => 'success',
        ]);
    }

    public function destroy(Ticket $ticket): RedirectResponse
    {

        $ticket->delete();

        return redirect()->route('admin.tickets.index')->with('flash', [
            'message' => 'Ticket deleted successfully!',
            'type' => 'success',
        ]);
    }
}
