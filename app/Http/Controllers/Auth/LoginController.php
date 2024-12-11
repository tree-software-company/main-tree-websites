<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DynamoDbService;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected $dynamoDbService;

    public function __construct(DynamoDbService $dynamoDbService)
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');

        $this->dynamoDbService = $dynamoDbService;
    }

    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');  // Upewnij się, że masz widok 'auth.login'
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $loginSuccess = $this->dynamoDbService->loginUser($credentials['email'], $credentials['password']);

        if ($loginSuccess) {
            session(['user_email' => Auth::user()->email]);
            session(['user_name' => Auth::user()->name]);
            return redirect('/');
        } else {
            return back()->withErrors(['email' => 'The provided email or password is incorrect.']);
        }
    }
}

