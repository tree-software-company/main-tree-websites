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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'product' => 'required|string',
        ]);

        if ($this->dynamoDbService->emailExistsForProduct($validatedData['email'], $validatedData['product'])) {
            return redirect()->back()->with('error', 'Email already registered for this product.');
        }

        $this->dynamoDbService->saveFormLandingPageNewsletter($validatedData);

        return redirect()->back()->with('success', 'Registration successful!');
    }
}
