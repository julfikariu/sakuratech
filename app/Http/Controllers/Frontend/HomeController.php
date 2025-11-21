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
}
