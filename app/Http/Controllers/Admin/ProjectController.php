<?php 
namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Client;
use App\Models\Project;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Admin\Project\ProjectRequest;

class ProjectController extends Controller
{
    public function index()
    {
        $paginator = Project::paginate(10)->withQueryString();

        $paginator->getCollection()->transform(function ($project) {
            return [
                'id'           => $project->id,
                'title'        => $project->title,
                'client_id'    => $project->client_id,
                'client_name'  => $project->client->company_name ?? null,
                'type'         => $project->type,
                'description'  => $project->description,
                'start_date'   => $project->start_date?->format('d M Y'),
                'deadline'     => $project->deadline?->format('d M Y'),
                'status'       => $project->status,
                'created_at'   => $project->created_at?->format('d M Y, h:i A'),
            ];
        });

        return Inertia::render('admin/projects/Index', [
            'projects' => $paginator,
        ]);
    }

    public function create()
    {
        $clients = Client::all()->map(function ($client) {
            return [
                'id' => $client->id,
                'company_name' => $client->company_name,
            ];
        });
        return Inertia::render('admin/projects/Form', [
            'clients' => $clients,
            'is_edit' => false,
        ]);
    }

    public function store(ProjectRequest $request)
    {
        Project::create([
            'title'       => $request->title,
            'client_id'   => $request->client_id,
            'type'        => $request->type,
            'description' => $request->description,
            'start_date'  => $request->start_date,
            'deadline'    => $request->deadline,
            'status'      => $request->status,
            'progress'    => $request->progress_info,
        ]);

        return redirect()->route('admin.projects.index')->with('flash', [
            'message' => 'Project created successfully!',
            'type' => 'success'
        ]);
    }

    public function show(Project $project)
    {
        $data = [
            'id'        => $project->id,
            'client_id'   => $project->client_id,
            'title' => $project->title,
            'description'     => $project->description,
            'start_date'   => $project->start_date,
            'deadline'   => $project->deadline,
            'progress'    => $project->progress,
            'status'    => $project->status,
            'created_at' => $project->created_at?->format('d M Y, h:i A'),
        ];
        return Inertia::render('admin/projects/Details', [
            'project' => $data,
        ]);
    }


    public function edit(Project $project)
    {
    
        $clients = Client::all()->map(function ($client) {
            return [
                'id' => $client->id,
                'company_name' => $client->company_name,
            ];
        });

        $data = [
            'id'        => $project->id,            
            'title'     => $project->title,
            'client_id' => $project->client_id,
            'description' => $project->description,
            'start_date'=> $project->start_date?->format('Y-m-d'),
            'deadline'  => $project->deadline?->format('Y-m-d'),
            'progress'  => (int) $project->progress,
            'status'    => $project->status,
        ];

        return Inertia::render('admin/projects/Form', [
            'project' => $data,
            'clients' => $clients,
            'is_edit' => true,
        ]);
    }

   public function update(ProjectRequest $request, Project $project)
    {   
        $project->update([
            'title'       => $request->title,
            'client_id'   => $request->client_id,
            'type'        => $request->type,
            'description' => $request->description,
            'start_date'  => $request->start_date,
            'deadline'    => $request->deadline,
            'status'      => $request->status,
            'progress'    => $request->progress_info ? (int) $request->progress_info : 0,
        ]);

        return redirect()->route('admin.projects.index')->with('flash', [
            'message' => 'Project updated successfully!',
            'type' => 'success'
        ]);
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();
        
        return redirect()->route('admin.projects.index')->with('flash', [
            'message' => 'Project deleted successfully!',
            'type' => 'success'
        ]);
    }

    public function getProjectsByClient(Client $client)
    {
        $projects = Project::where('client_id', $client->id)->get()->map(function ($project) {
            return [
                'id'    => $project->id,
                'title' => $project->title,
            ];
        });

        return response()->json($projects);
    }
}