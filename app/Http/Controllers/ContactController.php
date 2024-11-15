<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    // Display the contact form
    public function show()
    {
        return view('contact');
    }

    // Handle the form submission
    public function submit(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|min:10',
        ]);

        // Example: Send an email or save to the database
        Mail::raw($validatedData['message'], function ($message) use ($validatedData) {
            $message->to('support@example.com')
                ->subject('New Contact Form Submission')
                ->from($validatedData['email'], $validatedData['name']);
        });

        return back()->with('success', 'Your message has been sent!');
    }
}
