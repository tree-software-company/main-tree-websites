<?php

namespace App\Models;

use Aws\DynamoDb\DynamoDbClient;
use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * Określenie połączenia z DynamoDB.
     * 
     * @var string
     */
    protected $connection = 'dynamodb';  // Określamy połączenie z DynamoDB

    /**
     * Nazwa tabeli w DynamoDB
     *
     * @var string
     */
    protected $table = 'users';  // Tabela 'users' w DynamoDB

    /**
     * Klucz główny tabeli.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';  // Zakładając, że klucz główny to 'user_id'

    public $incrementing = false;  // DynamoDB nie używa autoinkrementacji
    protected $keyType = 'string'; // Klucz główny w DynamoDB jest typu string (np. UUID)

    /**
     * Atrybuty, które mogą być masowo przypisywane.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id', 'name', 'email', 'password',
    ];

    /**
     * Użyj AWS SDK do zapisu użytkownika w DynamoDB.
     */
    public static function create(array $data)
    {
        $dynamoDb = new DynamoDbClient([
            'version' => 'latest',
            'region'  => Config::get('services.dynamodb.region'),
            'credentials' => [
                'key'    => Config::get('services.dynamodb.key'),
                'secret' => Config::get('services.dynamodb.secret'),
            ],
        ]);

        // Zapisz użytkownika w tabeli DynamoDB
        $dynamoDb->putItem([
            'TableName' => 'users',
            'Item' => [
                'user_id' => ['S' => (string) \Str::uuid()],  // Generowanie unikalnego UUID dla user_id
                'name' => ['S' => $data['name']],
                'email' => ['S' => $data['email']],
                'password' => ['S' => \Hash::make($data['password'])],
            ],
        ]);

        return true;  // Jeśli operacja zakończyła się sukcesem
    }
}
