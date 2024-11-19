<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;  // Zaktualizowany model User
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Gdzie przekierować użytkownika po rejestracji.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Tworzenie nowego kontrolera instancji.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], // Dostosuj unikalność
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
        // Używamy nowej metody `create` w modelu User, która zapisuje dane do DynamoDB
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return true;
    }
}
