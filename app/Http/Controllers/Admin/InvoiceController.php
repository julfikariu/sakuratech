<?php 
namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Client;
use App\Models\Invoice;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Admin\Invoice\InvoiceRequest;
use App\Http\Requests\Admin\Project\ProjectRequest;

class InvoiceController extends Controller
{
    public function index()
    {
        $paginator = Invoice::paginate(10)->withQueryString();

        $paginator->getCollection()->transform(function ($project) {
            return [
                'id'           => $project->id,
                'inv_unique_id' => $project->inv_unique_id,
                'client_id'    => $project->client_id,
                'project_id'   => $project->project_id,
                'amount'       => $project->amount,
                'issue_date'   => $project->issue_date?->format('d M Y'),
                'due_date'     => $project->due_date?->format('d M Y'),
                'notes'        => $project->notes,
                'status'       => $project->status,
                'created_at'   => $project->created_at?->format('d M Y, h:i A'),
            ];
        });

        return Inertia::render('admin/invoices/Index', [
            'invoices' => $paginator,
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
        return Inertia::render('admin/invoices/CreateModal', [
            'clients' => $clients,
            'is_edit' => false,
        ]);
    }

    public function store(InvoiceRequest $request)
    {
        $invoice = Invoice::create([
            'inv_unique_id' => 'INV-' . strtoupper(uniqid()),
            'client_id'   => $request->client_id,
            'project_id'  => $request->project_id,
            'issue_date'  => $request->issue_date,
            'due_date'    => $request->due_date,
            'notes'       => $request->notes,
            'status'      => $request->status,
        ]);

        return redirect()->route('admin.projects.edit', $invoice->id)->with('flash', [
            'message' => 'Invoice created successfully!',
            'type' => 'success'
        ]);
    }

    public function show(Invoice $project)
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


    public function edit(Invoice $invoice)
    {
        $clients = Client::all()->map(function ($client) {
            return [
                'id' => $client->id,
                'company_name' => $client->company_name,
            ];
        });

        $data = [
            'id'         => $invoice->id,            
            'client_id'  => $invoice->client_id,
            'project_id' => $invoice->project_id,
            'issue_date' => $invoice->issue_date,
            'due_date'   => $invoice->due_date,
            'notes'      => $invoice->notes,
            'status'     => $invoice->status,
        ];

        return Inertia::render('admin/invoices/Edit', [
            'invoice' => $data,
            'invoiceItems' => $invoice->items ?? [],
            'clients' => $clients,
        ]);
    }

   public function update(InvoiceRequest $request, Invoice $project)
    {   
        $project->update($request->validated());

        return redirect()->route('admin.projects.index')->with('flash', [
            'message' => 'Invoice updated successfully!',
            'type' => 'success'
        ]);
    }

    public function destroy(Invoice $project): RedirectResponse
    {
        $project->delete();
        
        return redirect()->route('admin.projects.index')->with('flash', [
            'message' => 'Invoice deleted successfully!',
            'type' => 'success'
        ]);
    }
}