<?php
namespace App\Providers;

use App\Database\Connectors\DynamoDbConnector;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\DatabaseManager;

class DynamoDbServiceProvider extends ServiceProvider
{
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