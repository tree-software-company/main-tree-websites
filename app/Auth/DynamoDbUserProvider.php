<?php

namespace App\Auth;

use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DynamoDbUserProvider implements UserProvider
{
    protected $dynamoDbService;

    public function __construct()
    {
        $this->dynamoDbService = app(\App\Services\DynamoDbService::class);
    }

    public function retrieveById($identifier)
    {
        // Fetch user by ID from DynamoDB
        $user = $this->dynamoDbService->findUserById($identifier);

        if ($user) {
            return $this->getUserInstance($user);
        }

        return null;
    }

    public function retrieveByToken($identifier, $token)
    {
        // Not implemented (required for "remember me" functionality)
        return null;
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        // Not implemented (required for "remember me" functionality)
    }

    public function retrieveByCredentials(array $credentials)
    {
        // Fetch user by email
        $user = $this->dynamoDbService->findUserByEmail($credentials['email']);

        if ($user) {
            return $this->getUserInstance($user);
        }

        return null;
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        // Check if the given credentials match
        $plainPassword = $credentials['password'];

        return Hash::check($plainPassword, $user->password);
    }

    protected function getUserInstance($userData)
    {
        $user = new User();
        $user->id = $userData['user_id']['N'];
        $user->email = $userData['email']['S'];
        $user->name = $userData['name']['S'];
        $user->password = $userData['password']['S'];

        return $user;
    }
}