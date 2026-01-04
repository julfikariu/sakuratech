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

        return Inertia::render('admin/tasks/Details', [
            'task' => $data,
        ]);
    }

    public function edit(Task $task)
    {
        $projects = Project::all()->map(fn($p) => ['id' => $p->id, 'title' => $p->title]);
        $users = User::all()->map(fn($u) => ['id' => $u->id, 'name' => $u->name]);

        $data = (new TaskResource($task))->toArray(request());
        // ensure date format for form
        $data['due_date'] = $task->due_date?->format('Y-m-d');

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
}
