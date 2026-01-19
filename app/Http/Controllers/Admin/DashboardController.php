<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\InvoiceResource;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {        
        $stats = [
            'total_clients' => \App\Models\Client::count(),
            'total_projects' => \App\Models\Project::count(),
            'total_invoices' => \App\Models\Invoice::count(),
            'total_users' => \App\Models\User::count(),
        ];

        // Fetch recent projects with pagination and transformation
        // Using paginator but limiting to 5 per page to act as "recent" list
        $projects_paginator = \App\Models\Project::latest()->paginate(5, ['*'], 'projects_page');
        $recent_projects = $projects_paginator->through(
            fn($project) => (new ProjectResource($project))->toArray(request())
        );

        // Fetch recent invoices with pagination and transformation
        $invoices_paginator = \App\Models\Invoice::latest()->paginate(5, ['*'], 'invoices_page');
        $recent_invoices = $invoices_paginator->through(
            fn($invoice) => (new InvoiceResource($invoice))->toArray(request())
        );

        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'recent_projects' => $recent_projects,
            'recent_invoices' => $recent_invoices,
        ]);
    }
}