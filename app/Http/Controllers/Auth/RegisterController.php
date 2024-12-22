<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\DynamoDbService;
use App\Models\User; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Carbon\Carbon;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/';
    protected $dynamoDbServices;

    public function __construct(DynamoDbService $dynamoDbServices)
    {
        $this->middleware('guest');
        $this->dynamoDbServices = $dynamoDbServices;
    }


    protected function validator(array $data)
    {
        $birthday = Carbon::parse($data['birthday']);
        $age = Carbon::now()->diffInYears($birthday);
    
        if ($age < 13) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'birthday' => ['You must be at least 13 years old to register.'],
            ]);
        }
    
        if ($this->dynamoDbServices->checkPhoneExists($data['phone'])) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'phone' => ['The phone number is already taken.'],
            ]);
        }
    
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'birthday' => ['required', 'date', 'before:today'],
            'phone' => ['required', 'string', 'regex:/^\+?[0-9]{1,3}?[-.\s]?[0-9]{1,4}[-.\s]?[0-9]{1,4}[-.\s]?[0-9]{1,9}$/'],
        ]);
    }
    

    protected function create(array $data)
    {

        if ($this->dynamoDbServices->userExistsByEmail($data['email'])) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'email' => ['This email is already taken.'],
            ]);
        }
    
        $userData = $this->dynamoDbServices->registerUser($data);
    
        $user = new User([
            'user_id' => $userData['user_id'],
            'first_name' => $userData['first_name'],
            'last_name' => $userData['last_name'],
            'country' => $userData['country'],
            'birthday' => $userData['birthday'],
            'phone' => $userData['phone'],
            'email' => $userData['email'],
            'password' => $userData['password'],
        ]);

        auth()->login($user);
    
        return $user;
    }
    
    

    public function login(array $credentials)
    {
        $user = $this->dynamoDbServices->findUserByEmail($credentials['email']);

        if ($user && Hash::check($credentials['password'], $user['password']['S'])) {
            $user = new User([
                'user_id' => $user['user_id']['N'],
                'name' => $user['name']['S'],
                'email' => $user['email']['S'],
                'password' => $user['password']['S'],
            ]);

            auth()->login($user); 
            return redirect()->intended($this->redirectTo);
        } else {
            return back()->withErrors(['email' => 'Invalid login credentials']);
        }
    }
}
