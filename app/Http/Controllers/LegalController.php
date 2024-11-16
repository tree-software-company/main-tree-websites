<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LegalController extends Controller
{
    public function show()
    {
        return view('legal.legal');
    }

    public function privacyPolicy()
    {
        return view('legal.privacy');
    }
}
