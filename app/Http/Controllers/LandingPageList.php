<?php

namespace App\Http\Controllers;

use App\Services\DynamoDbService;
use Illuminate\Http\Request;

class LandingPageList extends Controller
{
    protected $dynamoDbService;

    public function __construct(DynamoDbService $dynamoDbService)
    {
        $this->dynamoDbService = $dynamoDbService;
    }

    public function submitForm(Request $request)
    {
        // Validate form input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        // Handle the registration logic here (saving to DB, etc.)
        \Log::info('New registration:', $request->all());

        // Redirect back with success message
        return redirect()->back()->with('success', 'Registration successful!');
    }
}
