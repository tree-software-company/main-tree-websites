<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Exception\DynamoDbException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    protected $dynamoDb;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');

        $this->dynamoDb = new DynamoDbClient([
            'region'  => env('AWS_DEFAULT_REGION'),
            'version' => 'latest',
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            $result = $this->dynamoDb->getItem([
                'TableName' => 'users', // Your DynamoDB table name
                'Key' => [
                    'email' => ['S' => $credentials['email']],
                ],
            ]);

            if (isset($result['Item'])) {
                $user = $result['Item'];
                $hashedPassword = $user['password']['S'];

                if (Hash::check($credentials['password'], $hashedPassword)) {
                    // Manually create a user instance for authentication
                    $userInstance = new \App\Models\User();
                    $userInstance->email = $user['email']['S'];
                    $userInstance->password = $hashedPassword;
                    Auth::login($userInstance);

                    return redirect()->intended('dashboard');
                } else {
                    return back()->withErrors(['password' => 'The provided password is incorrect.']);
                }
            } else {
                return back()->withErrors(['email' => 'The provided email does not match our records.']);
            }
        } catch (DynamoDbException $e) {
            return back()->withErrors(['error' => 'An error occurred while accessing the database.']);
        }
    }
}
