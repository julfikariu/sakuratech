<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use App\Models\ChecklistItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    protected array $morphMap = [
        'task' => Task::class,
        'checklist_item' => ChecklistItem::class,
        // Add more: 'project' => Project::class,
    ];

    public function index(string $type, int $id)
    {
        $model = $this->resolveModel($type, $id);

        $comments = $model->comments()
            ->with('user:id,name')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn ($comment) => $this->formatComment($comment));

        return response()->json($comments);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'commentable_type' => 'required|string|in:' . implode(',', array_keys($this->morphMap)),
            'commentable_id' => 'required|integer',
            'body' => 'required|string|max:2000',
        ]);

        $model = $this->resolveModel($validated['commentable_type'], $validated['commentable_id']);

        $comment = $model->comments()->create([
            'body' => $validated['body'],
            'user_id' => Auth::id(),
        ]);

        $comment->load('user:id,name');

        return response()->json($this->formatComment($comment), 201);
    }

    public function update(Request $request, Comment $comment)
    {
        // $this->authorize('update', $comment);

        $validated = $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        $comment->update($validated);
        $comment->load('user:id,name');

        return response()->json($this->formatComment($comment));
    }

    public function destroy(Comment $comment)
    {
        // $this->authorize('delete', $comment);

        $comment->delete();

        return response()->json(['message' => 'Deleted']);
    }

    protected function resolveModel(string $type, int $id)
    {
        $class = $this->morphMap[$type] ?? null;

        abort_unless($class, 404, 'Invalid commentable type');

        return $class::findOrFail($id);
    }

    protected function formatComment(Comment $comment): array
    {
        return [
            'id' => $comment->id,
            'body' => $comment->body,
            'created_at' => $comment->created_at?->format('d M Y, h:i A'),
            'user' => [
                'id' => $comment->user?->id,
                'name' => $comment->user?->name,
            ],
            'can_edit' => Auth::id() === $comment->user_id,
            'can_delete' => Auth::id() === $comment->user_id,
        ];
    }
}
