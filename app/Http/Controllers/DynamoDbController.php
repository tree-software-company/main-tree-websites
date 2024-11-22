<?php

namespace App\Http\Controllers;

use App\Services\DynamoDbService;

class DynamoDbController extends Controller
{
    protected $dynamoDb;

    public function __construct(DynamoDbService $dynamoDb)
    {
        $this->dynamoDb = $dynamoDb;
    }

    public function listTables()
    {
        $tables = $this->dynamoDb->listTables();
        return response()->json($tables);
    }

    public function putItem()
    {
        $item = [
            'id'      => '123',
            'name'    => 'Example Item',
            'created' => now()->toDateTimeString(),
        ];

        $response = $this->dynamoDb->putItem(env('AWS_DYNAMODB_TABLE_NAME'), $item);
        return response()->json($response);
    }
}

