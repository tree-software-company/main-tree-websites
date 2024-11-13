<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function show($locale = 'en-us')
    {
        return view('landing-page');
    }
}
