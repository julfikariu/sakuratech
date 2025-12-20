<?php 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Client\ClientRequest;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $paginator = Client::paginate(10)->withQueryString();

        $paginator->getCollection()->transform(function ($client) {
            return [
                'id'           => $client->id,
                'user_id'      => $client->user_id,
                'company_name' => $client->company_name,
                'phone'        => $client->phone,
                'address'      => $client->address,
                'website'      => $client->website,
                'created_at'   => $client->created_at?->format('d M Y, h:i A'),
            ];
        });

        return Inertia::render('admin/clients/Index', [
            'clients' => $paginator,
        ]);
    }

    public function create()
    {
        return Inertia::render('admin/clients/Form');
    }

    public function store(ClientRequest $request)
    {
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // $user->assignRole('Client');

        Client::create([
            'user_id'      => $user->id,
            'company_name' => $request->company_name,
            'phone'        => $request->phone,
            'address'      => $request->address,
            'website'      => $request->website,
            'status'       => $request->status,
        ]); 

        return redirect()->route('admin.clients.index')->with('flash', [
            'message' => 'Client created successfully!',
            'type' => 'success'
        ]);
    }

    public function show(Client $client)
    {
        $data = [
            'id'        => $client->id,
            'user_id'   => $client->user_id,
            'company_name' => $client->company_name,
            'phone'     => $client->phone,
            'address'   => $client->address,
            'website'   => $client->website,
            'status'    => $client->status,
            'created_at' => $client->created_at?->format('d M Y, h:i A'),
        ];
        return Inertia::render('admin/clients/DetailsModal', [
            'client' => $data,
        ]);
    }


    public function edit(Client $client)
    {
        $data = [
            'id'        => $client->id,            
            'name'      => $client->user->name,
            'email'     => $client->user->email,
            'company_name' => $client->company_name,
            'phone'     => $client->phone,
            'address'   => $client->address,
            'website'   => $client->website,
            'status'    => $client->status,
        ];

        return Inertia::render('admin/clients/Form', [
            'client' => $data,
            'is_edit' => true,
        ]);
    }

   public function update(ClientRequest $request, Client $client)
    {
        try {
            DB::transaction(function () use ($request, $client) {
                // Update user
                $client->user()->update([
                    'name'  => $request->name,
                    'email' => $request->email,
                ]);

                // Update client
                $client->update([
                    'company_name' => $request->company_name,
                    'phone'        => $request->phone,
                    'address'      => $request->address,
                    'website'      => $request->website,
                    'status'       => $request->status,
                ]);
            }, config('database.transaction_attempts', 3)); // Configurable attempts

            return redirect()->route('admin.clients.index')->with('flash', [
                'message' => 'Client updated successfully!',
                'type' => 'success'
            ]);
        } catch (Exception $e) {
            Log::error('Client update failed', [
                'client_id' => $client->id,
                'error' => $e->getMessage()
            ]);

            return back()->withInput()->with('flash', [
                'message' => 'Failed to update client. Please try again.',
                'type' => 'error'
            ]);
        }
    }

    public function destroy(Client $client): RedirectResponse
    {
        
        $client->user->delete();
        $client->delete();
        
        return redirect()->route('admin.clients.index')->with('flash', [
            'message' => 'Client deleted successfully!',
            'type' => 'success'
        ]);
    }
}