<?php

namespace App\Database\Connectors;

use Aws\DynamoDb\DynamoDbClient;
use Illuminate\Database\Connectors\Connector;
use Illuminate\Database\Connectors\ConnectorInterface;
use App\Database\DynamoDbConnection;

class DynamoDbConnector extends Connector implements ConnectorInterface
{
    public function connect(array $config)
    {
        $client = new DynamoDbClient([
            'region'  => $config['region'],
            'version' => 'latest',
            'credentials' => [
                'key'    => $config['key'],
                'secret' => $config['secret'],
            ],
        ]);

        return new DynamoDbConnection($client);
    }
}