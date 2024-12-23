<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\DynamoDbService;

class UserController extends Controller
{
    protected $dynamoDbService;

    public function __construct(DynamoDbService $dynamoDbService)
    {
        $this->dynamoDbService = $dynamoDbService;

        $this->middleware('auth');
    }

    public function edit()
    {
        $user = $this->dynamoDbService->findUserByEmail(Auth::user()->email);
    
        if (!$user) {
            return redirect('/');
        }
    
        return view('manage-account', compact('user'));
    }
    

    public function update(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birthday' => 'required|date|before:'.now()->subYears(13)->format('Y-m-d'),
            'country' => 'required|string|max:255',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $data = $request->only(['email', 'phone', 'first_name', 'last_name', 'birthday', 'country']);
        
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        try {
            $this->dynamoDbService->updateUser(Auth::id(), $data);
            return redirect()->route('user.edit')->with('success', 'Dane zostały zaktualizowane!');
        } catch (\Exception $e) {
            return back()->with('error', 'Błąd podczas aktualizacji danych: ' . $e->getMessage());
        }
    }

}
