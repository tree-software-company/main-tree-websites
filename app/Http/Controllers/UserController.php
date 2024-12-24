<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
    
        $existingUserByEmail = $this->dynamoDbService->userExistsByEmail($data['email']);
        $existingUserByPhone = $this->dynamoDbService->checkPhoneExists($data['phone']);
    
        if ($existingUserByEmail && $data['email'] !== Auth::user()->email) {
            return back()->with('error', 'This email is already in use by another user.');
        }
    
        if ($existingUserByPhone && $data['phone'] !== Auth::user()->phone) {
            return back()->with('error', 'This phone number is already in use by another user.');
        }
    
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
            \Log::info('Password has been updated: ' . $data['password']);
        }
    
        try {
            \Log::info('Updated user from ID: ' . Auth::id());
            $this->dynamoDbService->updateUser(Auth::id(), $data);
    
            return redirect()->route('user.edit')->with('success', 'Dane zostały zaktualizowane!');
    
        } catch (\Exception $e) {
            \Log::error('Error with data: ' . $e->getMessage());
            return back()->with('error', 'Error with data: ' . $e->getMessage());
        }
    }
        

}
