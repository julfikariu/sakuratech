<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Role\RoleRequest;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::select(['id', 'name', 'description'])->get();
        
        return Inertia::render('admin/role/Index', [
            'roles'=> $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        Role::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('flash', [
            'message' => 'Role created successfully!',
            'type' => 'success' 
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role)
    {
        $role->update([
            'name'=> $request->name,
            'description'=> $request->description,
        ]);

        return redirect()->back()->with('flash', [
            'message' => 'Role Updated successfully!',
            'type' => 'success' 
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): RedirectResponse
    {
        $role->delete();
        return redirect()->back();
    }
}
