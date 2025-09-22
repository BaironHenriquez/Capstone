<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Mostrar dashboard principal
     */
    public function index(Request $request)
    {
        $user = session('demo_user') ?? auth()->user();
        
        return view('dashboard.index', [
            'user' => $user,
            'isDemoMode' => session('authenticated') && !auth()->check()
        ]);
    }
}
