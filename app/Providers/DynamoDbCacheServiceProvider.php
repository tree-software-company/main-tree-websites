<?php

namespace App\Providers;

use Aws\DynamoDb\DynamoDbClient;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\DynamoDbStore;

class DynamoDbCacheServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Cache::extend('dynamodb', function ($app) {
            $config = [
                'region' => env('AWS_DEFAULT_REGION', 'us-west-1'),
                'version' => 'latest',
                'credentials' => [
                    'key' => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                ],
            ];

            $client = new DynamoDbClient($config);

            return Cache::repository(new DynamoDbStore(
                $client,
                env('DYNAMODB_CACHE_TABLE', 'cache'),
                env('CACHE_PREFIX', '')
            ));
        });
    }
}
