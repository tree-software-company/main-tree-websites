<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MainWebsiteDynamoDB extends Model
{
    /**
     * Połączenie z DynamoDB
     *
     * @var string
     */
    protected $connection = 'dynamodb';  // Określamy połączenie z DynamoDB

    /**
     * Nazwa tabeli w DynamoDB
     *
     * @var string
     */
    protected $table = 'main-website'; // Tabela 'main-website' w DynamoDB

    /**
     * Określenie, że klucz główny to 'page_id'.
     *
     * @var string
     */
    protected $primaryKey = 'page_id';  // Klucz główny to 'page_id' w tabeli DynamoDB
    public $incrementing = false;  // Klucze w DynamoDB nie są inkrementowane automatycznie
    protected $keyType = 'string'; // Klucz główny w DynamoDB to string (np. UUID)

    /**
     * Atrybuty, które mogą być masowo przypisywane.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'page_id', 'website_name', 'url', 'description',
    ];
}
