<?php

namespace App\Models;

use Aws\DynamoDb\DynamoDbClient;
use Illuminate\Support\Facades\Config;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User implements Authenticatable
{
    use AuthenticatableTrait, HasApiTokens, Notifiable;

    public $id;
    public $email;
    public $name;
    public $password;
    protected $rememberToken;

    protected $connection = 'dynamodb';
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id', 'name', 'email', 'password',
    ];

    public static function createUser(array $data)
    {
        $userId = time();

        $dynamoDb = new DynamoDbClient([
            'region'  => Config::get('services.dynamodb.region'),
            'version' => 'latest',
            'credentials' => [
                'key'    => Config::get('services.dynamodb.key'),
                'secret' => Config::get('services.dynamodb.secret'),
            ],
        ]);

        $dynamoDb->putItem([
            'TableName' => 'users',
            'Item' => [
                'user_id' => ['N' => (string) $userId],
                'name' => ['S' => $data['name']],
                'email' => ['S' => $data['email']],
                'password' => ['S' => Hash::make($data['password'])],
            ],
        ]);

        return new self([
            'user_id' => $userId,
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        return $this->id;
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return $this->rememberToken;
    }

    public function setRememberToken($value)
    {
        $this->rememberToken = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    // Add the missing getKeyName method
    public function getKeyName()
    {
        return 'id';
    }
}
