<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TreeForEducationController extends Controller
{
    public function index()
    {
        return view('tree-for-education');
    }
}
