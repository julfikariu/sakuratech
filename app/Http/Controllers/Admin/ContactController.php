<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {        
        $paginator = Contact::paginate(10)->withQueryString();

        $paginator->getCollection()->transform(function ($contact) {
            return [
                'id'          => $contact->id,
                'name'        => $contact->name,
                'email'       => $contact->email,
                'subject'     => $contact->subject,
                'message'     => $contact->message,
                'created_at'  => $contact->created_at?->format('d M Y, h:i A'),
            ];
        });

        return inertia('admin/contacts/Index', [
            'contacts' => $paginator,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('admin/contacts/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        $contact = Contact::create($data);

        return redirect()->route('admin.contacts.index')->with('success', 'Contact created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        return inertia('admin/contacts/Show', [
            'contact' => array_merge($contact->toArray(), [
                'created_at' => $contact->created_at?->format('d M Y, h:i A'),
            ]),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        return inertia('admin/contacts/Edit', [
            'contact' => $contact,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        $contact->update($data);

        return redirect()->route('admin.contacts.index')->with('success', 'Contact updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')->with('success', 'Contact deleted.');
    }
}
