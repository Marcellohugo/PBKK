<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $projects = $request->user()->projects()->latest()->get();

        return view('dashboard', compact('projects'));
    }
}
