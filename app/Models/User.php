<?php

namespace App\Models;

use Aws\DynamoDb\DynamoDbClient;
use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

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
}
