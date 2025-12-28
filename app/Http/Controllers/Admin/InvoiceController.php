<?php 
namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Admin\Invoice\InvoiceRequest;
use Illuminate\Support\Facades\DB; // for transactions
use App\Http\Requests\Admin\Invoice\InvoiceUpdateRequest;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index()
    {
        $paginator = Invoice::paginate(10)->withQueryString();

        $paginator->getCollection()->transform(function ($invoice) {
            return [
                'id'           => $invoice->id,
                'inv_unique_id' => $invoice->inv_unique_id,
                'client'       => $invoice->client->user()->first()->name ?? null,
                'project'      => $invoice->project->title ?? null,
                'invoice_id'   => $invoice->invoice_id,
                'amount'       => $invoice->amount,
                'issue_date'   => $invoice->issue_date?->format('d M Y'),
                'due_date'     => $invoice->due_date?->format('d M Y'),
                'notes'        => $invoice->notes,
                'status'       => $invoice->status,
                'created_at'   => $invoice->created_at?->format('d M Y, h:i A'),
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
            'invoice_id'  => $request->invoice_id,
            'project_id'  => $request->project_id,
            'issue_date'  => $request->issue_date,
            'due_date'    => $request->due_date,
            'notes'       => $request->notes,
            'status'      => $request->status,
        ]);

        return redirect()->route('admin.invoices.edit', $invoice->id)->with('flash', [
            'message' => 'Invoice created successfully!',
            'type' => 'success'
        ]);
    }

    public function show(Invoice $invoice)
    {
        // Load related data
        $invoice->load('items', 'client');

        $data = [
            'id'         => $invoice->id,
            'client'  => $invoice->client->user()->first()->name ?? null,
            'invoice_id' => $invoice->invoice_id,
            'issue_date' => $invoice->issue_date?->format('Y-m-d'),
            'due_date'   => $invoice->due_date?->format('Y-m-d'),
            'amount'     => $invoice->amount,
            'notes'      => $invoice->notes,
            'status'     => $invoice->status,
        ];

        return Inertia::render('admin/invoices/Show', [
            'invoice' => $data,
            'invoiceItems' => $invoice->items ?? [],
            'client' => $invoice->client,
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
            'invoice_id' => $invoice->invoice_id,
            'issue_date' => $invoice->issue_date->format('Y-m-d'),
            'due_date'   => $invoice->due_date->format('Y-m-d'),
            'amount'     => $invoice->amount,
            'notes'      => $invoice->notes,
            'status'     => $invoice->status,
        ];

        return Inertia::render('admin/invoices/Edit', [
            'invoice' => $data,
            'invoiceItems' => $invoice->items ?? [],
            'clients' => $clients,
        ]);
    }

   public function update(InvoiceUpdateRequest $request, Invoice $invoice)
    {

        // Use transaction to keep invoice and items in sync
        DB::transaction(function () use ($request, $invoice) {
            // Update invoice main fields
            $invoice->update([
                'issue_date'  => $request->issue_date,
                'due_date'    => $request->due_date,
                'notes'       => $request->notes,
            ]);

            $items = $request->get('items', []);

            $existingIds = $invoice->items()->pluck('id')->toArray();
            $processedIds = [];
            $totalAmount = 0;

            foreach ($items as $item) {
                $qty = $item['qty'] ?? ($item['quantity'] ?? 0);
                $rate = $item['rate'] ?? ($item['price'] ?? 0);
                $lineTotal = $qty * $rate;
                $totalAmount += $lineTotal;

                if (!empty($item['id'])) {
                    // Update existing item
                    $invoice->items()->where('id', $item['id'])->update([
                        'description' => $item['description'],
                        'price' => $rate,
                        'quantity' => $qty,
                        'total' => $lineTotal,
                    ]);

                    $processedIds[] = $item['id'];
                } else {
                    // Create new item
                    $created = $invoice->items()->create([
                        'description' => $item['description'],
                        'price' => $rate,
                        'quantity' => $qty,
                        'total' => $lineTotal,
                    ]);

                    $processedIds[] = $created->id;
                }
            }

            // Delete removed items
            $toDelete = array_diff($existingIds, $processedIds);
            if (!empty($toDelete)) {
                InvoiceItem::whereIn('id', $toDelete)->delete();
            }

            // Update invoice amount (sum of item totals)
            $invoice->amount = $totalAmount;
            $invoice->save();
        });

        return redirect()->route('admin.invoices.index')->with('flash', [
            'message' => 'Invoice updated successfully!',
            'type' => 'success'
        ]);
    }

    public function destroy(Invoice $invoice): RedirectResponse
    {
        $invoice->items()->delete();
        $invoice->delete();
        
        return redirect()->route('admin.invoices.index')->with('flash', [
            'message' => 'Invoice deleted successfully!',
            'type' => 'success'
        ]);
    }

    public function download(Invoice $invoice)
    {
      /*   $invoice->load('items', 'client');

        return Pdf::loadView('admin.invoices.pdf', [
            'invoice' => $invoice
        ])
        ->setPaper('a4', 'portrait')
        ->stream("invoice-{$invoice->id}.pdf"); */
   
        // Load related data
        $invoice->load('items', 'client');

        // Prepare data for the view
        $data = [
            'invoice' => $invoice,
        ];

        // Generate PDF using the dompdf facade
        $pdf = Pdf::loadView('admin.invoices.pdf', $data)
                  ->setPaper('a4', 'portrait');

        // Return as download
        return $pdf->download('invoice_' . $invoice->inv_unique_id . '.pdf');
    }
}