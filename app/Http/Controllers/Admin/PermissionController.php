<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Permission\PermissionRequest;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::select(['id', 'name'])->get();

        return Inertia::render('admin/permission/Index', [
            'permissions' => $permissions,
        ]);
    }

    public function store(PermissionRequest $request)
    {
        Permission::create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('flash', [
            'message' => 'Permission created successfully!',
            'type' => 'success'
        ]);
    }

    public function update(PermissionRequest $request, Permission $permission)
    {
        $permission->update([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('flash', [
            'message' => 'Permission updated successfully!',
            'type' => 'success'
        ]);
    }

    public function destroy(Permission $permission): RedirectResponse
    {
        $permission->delete();
        return redirect()->back();
    }
}
