<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PortalController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $modules = \App\Models\Module::accessibleBy($user);
        return view('portal', compact('user', 'modules'));
    }
}
