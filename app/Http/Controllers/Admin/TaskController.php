<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Resources\TaskResource;
use App\Http\Requests\Admin\Task\TaskRequest;

class TaskController extends Controller
{
    public function index()
    {
        $paginator = Task::paginate(10)->withQueryString();

        $tasks = $paginator->through(fn ($task) => (new TaskResource($task))->toArray(request()));

        return Inertia::render('admin/tasks/Index', [
            'tasks' => $tasks,
        ]);
    }

    public function create()
    {
        $projects = Project::all()->map(fn($p) => ['id' => $p->id, 'title' => $p->title]);
        $users = User::all()->map(fn($u) => ['id' => $u->id, 'name' => $u->name]);

        return Inertia::render('admin/tasks/Form', [
            'projects' => $projects,
            'users' => $users,
            'is_edit' => false,
        ]);
    }

    public function store(TaskRequest $request)
    {
        Task::create([
            'project_id' => $request->project_id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'pending',
            'priority' => $request->priority,
            'due_date' => $request->due_date,
            'assigned_to' => $request->assigned_to,
        ]);

        return redirect()->route('admin.tasks.index')->with('flash', [
            'message' => 'Task created successfully!',
            'type' => 'success'
        ]);
    }

    public function show(Task $task)
    {
        $data = (new TaskResource($task))->toArray(request());

        $comments = $task->comments()->with('user')->orderBy('created_at', 'asc')->get()->map(function ($c) use ($task) {
            return [
                'id' => $c->id,
                'body' => $c->body,
                'created_at' => $c->created_at?->format('d M Y, h:i A'),
                'user' => [
                    'id' => $c->user?->id,
                    'name' => $c->user?->name,
                ],
                'can_edit' => auth()->id() === $c->user_id,
                'can_delete' => auth()->id() === $c->user_id,
            ];
        });

        return Inertia::render('admin/tasks/Details', [
            'task' => $data,
            'comments' => fn () => $comments->toArray(),
        ]);
    }

    public function edit(Task $task)
    {
        $projects = Project::all()->map(fn($p) => ['id' => $p->id, 'title' => $p->title]);
        $users = User::all()->map(fn($u) => ['id' => $u->id, 'name' => $u->name]);

        $data = (new TaskResource($task))->toArray(request());
        // ensure date format for form
        if (is_object($task->due_date) && method_exists($task->due_date, 'format')) {
            $data['due_date'] = $task->due_date->format('Y-m-d');
        } else {
            $data['due_date'] = $task->due_date ? date('Y-m-d', strtotime($task->due_date)) : null;
        }

        return Inertia::render('admin/tasks/Form', [
            'task' => $data,
            'projects' => $projects,
            'users' => $users,
            'is_edit' => true,
        ]);
    }

    public function update(TaskRequest $request, Task $task)
    {
        $task->update([
            'project_id' => $request->project_id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'pending',
            'priority' => $request->priority,
            'due_date' => $request->due_date,
            'assigned_to' => $request->assigned_to,
        ]);

        return redirect()->route('admin.tasks.index')->with('flash', [
            'message' => 'Task updated successfully!',
            'type' => 'success'
        ]);
    }

    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()->route('admin.tasks.index')->with('flash', [
            'message' => 'Task deleted successfully!',
            'type' => 'success'
        ]);
    }

    // Checklists
    public function checklists(Task $task)
    {
        $checklists = $task->checklists->map(function ($c) {
            $comments = $c->comments()->with('user')->orderBy('created_at', 'asc')->get()->map(function ($cc) {
                return [
                    'id' => $cc->id,
                    'body' => $cc->body,
                    'created_at' => $cc->created_at?->format('d M Y, h:i A'),
                    'user' => [
                        'id' => $cc->user?->id,
                        'name' => $cc->user?->name,
                    ],
                    'can_edit' => auth()->id() === $cc->user_id,
                    'can_delete' => auth()->id() === $cc->user_id,
                ];
            })->toArray();

            return [
                'id' => $c->id,
                'title' => $c->title,
                'created_at' => $c->created_at?->format('d M Y, h:i A'),
                'comments' => $comments,
            ];
        });

        return Inertia::render('admin/tasks/Checklists', [
            'task' => (new TaskResource($task))->toArray(request()),
            'checklists' => $checklists,
        ]);
    }

    public function createChecklist(Task $task)
    {
        return Inertia::render('admin/tasks/ChecklistForm', [
            'task' => (new TaskResource($task))->toArray(request()),
            'is_edit' => false,
        ]);
    }

    public function storeChecklist(\Illuminate\Http\Request $request, Task $task)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
        ]);

        $task->checklists()->create($data);

        return redirect()->route('admin.tasks.checklists', $task->id)->with('flash', [
            'message' => 'Checklist item created successfully!',
            'type' => 'success'
        ]);
    }

    // Comments
    public function storeComment(\Illuminate\Http\Request $request, Task $task)
    {
        $data = $request->validate([
            'body' => ['required', 'string', 'max:1000'],
        ]);

        $comment = $task->comments()->create([
            'body' => $data['body'],
            'user_id' => auth()->id(),
        ]);

        $comment->load('user');

        $payload = [
            'id' => $comment->id,
            'body' => $comment->body,
            'created_at' => $comment->created_at?->format('d M Y, h:i A'),
            'user' => [
                'id' => $comment->user?->id,
                'name' => $comment->user?->name,
            ],
            'can_edit' => auth()->id() === $comment->user_id,
            'can_delete' => auth()->id() === $comment->user_id,
        ];

        if ($request->wantsJson()) {
            return response()->json($payload, 201);
        }

        return redirect()->route('admin.tasks.show', $task->id)->with('flash', [
            'message' => 'Comment posted!',
            'type' => 'success',
        ]);
    }

    public function updateComment(\Illuminate\Http\Request $request, Task $task, \App\Models\Comment $comment)
    {
        if ($comment->commentable_id !== $task->id || $comment->commentable_type !== Task::class) {
            return redirect()->route('admin.tasks.show', $task->id)->with('flash', [
                'message' => 'Comment not found for this task!',
                'type' => 'error',
            ]);
        }

        if ($comment->user_id !== auth()->id()) {
            return redirect()->route('admin.tasks.show', $task->id)->with('flash', [
                'message' => 'Unauthorized',
                'type' => 'error',
            ]);
        }

        $data = $request->validate([
            'body' => ['required', 'string', 'max:1000'],
        ]);

        $comment->update(['body' => $data['body']]);
        $comment->refresh();
        $comment->load('user');

        $payload = [
            'id' => $comment->id,
            'body' => $comment->body,
            'created_at' => $comment->created_at?->format('d M Y, h:i A'),
            'user' => [
                'id' => $comment->user?->id,
                'name' => $comment->user?->name,
            ],
            'can_edit' => auth()->id() === $comment->user_id,
            'can_delete' => auth()->id() === $comment->user_id,
        ];

        if ($request->wantsJson()) {
            return response()->json($payload, 200);
        }

        return redirect()->route('admin.tasks.show', $task->id)->with('flash', [
            'message' => 'Comment updated!',
            'type' => 'success',
        ]);
    }

    public function destroyComment(Task $task, \App\Models\Comment $comment)
    {
        if ($comment->commentable_id !== $task->id || $comment->commentable_type !== Task::class) {
            return redirect()->route('admin.tasks.show', $task->id)->with('flash', [
                'message' => 'Comment not found for this task!',
                'type' => 'error',
            ]);
        }

        if ($comment->user_id !== auth()->id()) {
            return redirect()->route('admin.tasks.show', $task->id)->with('flash', [
                'message' => 'Unauthorized',
                'type' => 'error',
            ]);
        }

        $comment->delete();

        if (request()->wantsJson()) {
            return response()->json(['success' => true], 200);
        }

        return redirect()->route('admin.tasks.show', $task->id)->with('flash', [
            'message' => 'Comment deleted!',
            'type' => 'success',
        ]);
    }

    public function editChecklist(Task $task, \App\Models\Checklist $checklist)
    {
        // ensure checklist belongs to task
        if ($checklist->task_id !== $task->id) {
            return redirect()->route('admin.tasks.checklists', $task->id)->with('flash', [
                'message' => 'Checklist not found for this task!',
                'type' => 'error'
            ]);
        }

        return Inertia::render('admin/tasks/ChecklistForm', [
            'task' => (new TaskResource($task))->toArray(request()),
            'checklist' => [
                'id' => $checklist->id,
                'title' => $checklist->title,
            ],
            'is_edit' => true,
        ]);
    }

    public function updateChecklist(\Illuminate\Http\Request $request, Task $task, \App\Models\Checklist $checklist)
    {
        if ($checklist->task_id !== $task->id) {
            return redirect()->route('admin.tasks.checklists', $task->id)->with('flash', [
                'message' => 'Checklist not found for this task!',
                'type' => 'error'
            ]);
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
        ]);

        $checklist->update($data);

        return redirect()->route('admin.tasks.checklists', $task->id)->with('flash', [
            'message' => 'Checklist updated successfully!',
            'type' => 'success'
        ]);
    }

    public function destroyChecklist(Task $task, \App\Models\Checklist $checklist): RedirectResponse
    {
        if ($checklist->task_id !== $task->id) {
            return redirect()->route('admin.tasks.checklists', $task->id)->with('flash', [
                'message' => 'Checklist not found for this task!',
                'type' => 'error'
            ]);
        }

        $checklist->delete();

        return redirect()->route('admin.tasks.checklists', $task->id)->with('flash', [
            'message' => 'Checklist deleted successfully!',
            'type' => 'success'
        ]);
    }

    // Checklist comments
    public function storeChecklistComment(\Illuminate\Http\Request $request, Task $task, \App\Models\Checklist $checklist)
    {
        if ($checklist->task_id !== $task->id) {
            return response()->json(['message' => 'Checklist not found for this task!'], 404);
        }

        $data = $request->validate([
            'body' => ['required', 'string', 'max:1000'],
        ]);

        $comment = $checklist->comments()->create([
            'body' => $data['body'],
            'user_id' => auth()->id(),
        ]);

        $comment->load('user');

        $payload = [
            'id' => $comment->id,
            'body' => $comment->body,
            'created_at' => $comment->created_at?->format('d M Y, h:i A'),
            'user' => [
                'id' => $comment->user?->id,
                'name' => $comment->user?->name,
            ],
            'can_edit' => auth()->id() === $comment->user_id,
            'can_delete' => auth()->id() === $comment->user_id,
        ];

        return response()->json($payload, 201);
    }

    public function updateChecklistComment(\Illuminate\Http\Request $request, Task $task, \App\Models\Checklist $checklist, \App\Models\Comment $comment)
    {
        if ($checklist->task_id !== $task->id || $comment->commentable_id !== $checklist->id || $comment->commentable_type !== \App\Models\Checklist::class) {
            return response()->json(['message' => 'Comment not found for this checklist!'], 404);
        }

        if ($comment->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'body' => ['required', 'string', 'max:1000'],
        ]);

        $comment->update(['body' => $data['body']]);
        $comment->refresh();
        $comment->load('user');

        $payload = [
            'id' => $comment->id,
            'body' => $comment->body,
            'created_at' => $comment->created_at?->format('d M Y, h:i A'),
            'user' => [
                'id' => $comment->user?->id,
                'name' => $comment->user?->name,
            ],
            'can_edit' => auth()->id() === $comment->user_id,
            'can_delete' => auth()->id() === $comment->user_id,
        ];

        return response()->json($payload, 200);
    }

    public function destroyChecklistComment(Task $task, \App\Models\Checklist $checklist, \App\Models\Comment $comment)
    {
        if ($checklist->task_id !== $task->id || $comment->commentable_id !== $checklist->id || $comment->commentable_type !== \App\Models\Checklist::class) {
            return response()->json(['message' => 'Comment not found for this checklist!'], 404);
        }

        if ($comment->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $comment->delete();

        return response()->json(['success' => true], 200);
    }
}
