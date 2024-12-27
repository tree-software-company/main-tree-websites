<?php
namespace App\Http\Controllers;

use App\Services\DynamoDbService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    protected $dynamoDbService;

    public function __construct(DynamoDbService $dynamoDbService)
    {
        $this->dynamoDbService = $dynamoDbService;
    }

    public function submitForm(Request $request)
    {
        $validatedData = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'message' => 'required|string',
            'status' => 'required|string',
        ]);

        $this->dynamoDbService->saveFormSubmission($validatedData);

        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }
}
