<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HrdController extends Controller
{
    public function index()
    {
        return view('hrd.dashboard');
    }
}
