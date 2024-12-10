<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DynamoDbService;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected $dynamoDbService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
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

    /**
     * Handle the login attempt.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Logowanie użytkownika za pomocą metody z serwisu
        $user = $this->dynamoDbService->loginUser($credentials['email'], $credentials['password']);

        if ($user) {
            // Jeśli użytkownik jest poprawny, logujemy go
            $userInstance = new \App\Models\User();
            $userInstance->email = $user['email'];
            $userInstance->password = $user['password'];

            Auth::login($userInstance);

            return redirect('/');
        } else {
            return back()->withErrors(['email' => 'The provided email or password is incorrect.']);
        }
    }
}
