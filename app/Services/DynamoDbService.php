<?php

namespace App\Services;

use Aws\DynamoDb\DynamoDbClient;

class DynamoDbService
{
    protected $client;

    public function __construct()
    {
        $this->client = new DynamoDbClient([
            'region'      => env('AWS_DEFAULT_REGION'),
            'version'     => 'latest',
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);
    }

    public function listTables()
    {
        return $this->client->listTables();
    }

    public function putItem($tableName, $item)
    {
        return $this->client->putItem([
            'TableName' => $tableName,
            'Item'      => $this->marshalItem($item),
        ]);
    }

    public function getItem($tableName, $key)
    {
        return $this->client->getItem([
            'TableName' => $tableName,
            'Key'       => $this->marshalItem($key),
        ]);
    }

    private function marshalItem(array $item)
    {
        return \Aws\DynamoDb\Marshaler::marshalItem($item);
    }

    public function register()
    {
        $this->app->resolving('db', function (DatabaseManager $db) {
            $db->extend('dynamodb', function ($config, $name) {
                $connector = new DynamoDbConnector();
                return $connector->connect($config);
            });
        });
    }
}


