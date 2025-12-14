<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the frontend home page using Blade.
     */
    public function index()
    {
        // Return the Blade view at resources/views/frontend/index.blade.php
        return view('frontend.index');
    }


    /**
     * Display the frontend service page using Blade.
     */    
    public function service()
    {

        return view('frontend.service.index');
    }

    /**
     * Display the frontend service details page using Blade.
     */
    public function serviceDetails($slug)
    {
        $view = 'frontend.service.'.$slug;
        return view($view, compact('slug'));
    }

    /**
     * Display the frontend project page using Blade.
     */
    public function project()
    {
        return view('frontend.project.index');
    }

    /**
     * Display the frontend project details page using Blade.
     */
    public function projectDetails($slug)
    {
        $view = 'frontend.project.'.$slug;
        return view($view, compact('slug'));
    }
}
