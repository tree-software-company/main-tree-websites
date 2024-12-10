<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\DynamoDbService;  // Poprawiony import
use App\Models\User; // Upewnij się, że importujesz model User
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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

    /**
     * Pobierz walidator dla przychodzącego żądania rejestracji.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Utwórz nowego użytkownika po pomyślnej walidacji.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // Sprawdzenie, czy użytkownik z danym e-mailem już istnieje
        if ($this->dynamoDbServices->userExistsByEmail($data['email'])) {
            // Dodanie błędu, jeśli e-mail już istnieje
            throw \Illuminate\Validation\ValidationException::withMessages([
                'email' => ['Ten e-mail jest już zajęty.'],
            ]);
        }
    
        // Zarejestruj użytkownika w DynamoDB
        $userData = $this->dynamoDbServices->registerUser($data);
    
        // Zwróć nowego użytkownika
        $user = new User([
            'user_id' => $userData['user_id'],
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => $userData['password'],
        ]);

        auth()->login($user);

        return $user;
    }

    /**
     * Zalogowanie użytkownika.
     *
     * @param array $credentials
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(array $credentials)
    {
        $user = $this->dynamoDbServices->findUserByEmail($credentials['email']);

        if ($user && Hash::check($credentials['password'], $user['password']['S'])) {
            // Tworzenie obiektu użytkownika, który jest kompatybilny z Laravel Auth
            $user = new User([
                'user_id' => $user['user_id']['N'],
                'name' => $user['name']['S'],
                'email' => $user['email']['S'],
                'password' => $user['password']['S'],
            ]);

            auth()->login($user); // Teraz używamy obiektu User, który implementuje Authenticatable
            return redirect()->intended($this->redirectTo);
        } else {
            return back()->withErrors(['email' => 'Nieprawidłowe dane logowania']);
        }
    }
}
