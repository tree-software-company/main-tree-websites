<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TreeForBusinessController extends Controller
{
    public function index()
    {
        return view('tree-for-business');
    }
}

