<?php

namespace App\Services;

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Marshaler;
use Ramsey\Uuid\Guid\Guid;

class DynamoDbService
{
    protected $dynamoDb;

    public function __construct()
    {
        $this->dynamoDb = new DynamoDbClient([
            'region'      => env('AWS_DEFAULT_REGION'),
            'version'     => 'latest',
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);
    }

    // Metoda listująca dostępne tabele w DynamoDB
    public function listTables()
    {
        return $this->dynamoDb->listTables();
    }

    // Metoda dodająca element do tabeli
    public function putItem($tableName, $item)
    {
        return $this->dynamoDb->putItem([
            'TableName' => $tableName,
            'Item'      => $this->marshalItem($item),
        ]);
    }

    // Metoda pobierająca element z tabeli
    public function getItem($tableName, $key)
    {
        return $this->dynamoDb->getItem([
            'TableName' => $tableName,
            'Key'       => $this->marshalItem($key),
        ]);
    }

    private function marshalItem(array $item)
    {
        $marshaler = new Marshaler();  // Tworzymy instancję Marshaler
        return $marshaler->marshalItem($item);  // Wywołujemy metodę na instancji obiektu
    }

    public function getLangSetting()
    {
        try {
            // Zakładając, że masz tabelę 'settings' z polem 'lang'
            $result = $this->dynamoDb->scan([
                'TableName' => 'settings',  // Nazwa tabeli
            ]);

            // Sprawdzenie, czy są wyniki
            if (isset($result['Items']) && count($result['Items']) > 0) {
                $item = $this->unmarshalItems($result['Items'])[0];  // Pobieramy pierwszy rekord
                return $item['lang'];  // Zakładamy, że pole 'lang' przechowuje kod języka
            }

            return 'en-us';  // Domyślny język, jeśli brak w tabeli
        } catch (\Aws\Exception\AwsException $e) {
            dd('Error: ' . $e->getMessage());
        }
    }

    public function getData($tableName, $controller)
    {
        try {
            // Zmieniamy zapytanie na 'Query' zamiast 'Scan'
            $result = $this->dynamoDb->scan([
                'TableName' => $tableName,
                'FilterExpression' => 'controller_name = :controller_name',
                'ExpressionAttributeValues' => [
                    ':controller_name' => ['S' => $controller],  // 'S' dla ciągów znaków
                ],
            ]);
    
            // Jeśli chcesz tylko jeden rekord, weź pierwszy element
            if (count($result['Items']) > 0) {
                return $this->unmarshalItems($result['Items']); // Zwracamy tylko pierwszy rekord
            }
    
            return null; // Jeśli brak wyników
        } catch (\Aws\Exception\AwsException $e) {
            dd('Error: ' . $e->getMessage());
        }
    }
    
    // Zmodyfikowana metoda, która nie filtruje już po 'controller_name', tylko po 'url'
    public function getDataByUrl($tableName, $url)
    {
        try {
            // Używamy tylko 'url' w filtrze, a 'controller_name' zwrócimy jako nazwę widoku
            $result = $this->dynamoDb->scan([
                'TableName' => $tableName,
                'FilterExpression' => '#url = :url',
                'ExpressionAttributeNames' => [
                    '#url' => 'url', // Alias dla 'url'
                ],
                'ExpressionAttributeValues' => [
                    ':url' => ['S' => $url],  // Filtrujemy po url
                ],
            ]);
    
            // Jeśli znaleziono dane, zwracamy je
            if (count($result['Items']) > 0) {
                // Zwracamy dane, w tym 'controller_name', które posłuży jako nazwa widoku
                $unmarshalledData = $this->unmarshalItems($result['Items']);
                return $unmarshalledData[0];  // Zakładamy, że chcemy tylko pierwszy wynik
            }
    
            return null;  // Jeśli brak wyników
        } catch (\Aws\Exception\AwsException $e) {
            dd('Error: ' . $e->getMessage());
        }
    }

    public function saveFormSubmission($data)
    {
        try {
            $marshaler = new Marshaler();

            // Generate a unique submission ID
            $submissionId = round(microtime(true) * 1000);

            $item = [
                'id'         => (int) $submissionId,
                'name'       => $data['name'],
                'email'      => $data['email'],
                'message'    => $data['message'],
                'created_at' => now()->toIso8601String(),
            ];

            // Marshal the item
            $item = $marshaler->marshalItem($item);

            return $this->dynamoDb->putItem([
                'TableName' => 'form_website',
                'Item'      => $item,
            ]);
        } catch (\Aws\Exception\AwsException $e) {
            dd('Error: ' . $e->getMessage());
        }
    }

    public function saveFormLandingPageNewsletter($data)
    {
        try {
            $marshaler = new Marshaler();

            // Generate a unique submission ID
            $submissionId = round(microtime(true) * 1000);

            $item = [
                'id'         => (int) $submissionId,
                'name'       => $data['name'],
                'email'      => $data['email'],
                'created_at' => now()->toIso8601String(),
            ];

            // Marshal the item
            $item = $marshaler->marshalItem($item);

            return $this->dynamoDb->putItem([
                'TableName' => 'landing-page-newsletter',
                'Item'      => $item,
            ]);
        } catch (\Aws\Exception\AwsException $e) {
            dd('Error: ' . $e->getMessage());
        }
    }
    
    // Funkcja do unmarshalingu wyników
    private function unmarshalItems($items)
    {
        $marshaler = new Marshaler();
        $unmarshalledItems = [];

        foreach ($items as $item) {
            $unmarshalledItems[] = $marshaler->unmarshalItem($item);
        }

        return $unmarshalledItems;
    }

    public function getAllData($tableName)
    {
        try {
            // Skanujemy całą tabelę bez filtrów
            $result = $this->dynamoDb->scan([
                'TableName' => $tableName,
            ]);

            // Jeśli są wyniki, zwracamy je po unmarshalingu
            if (isset($result['Items']) && count($result['Items']) > 0) {
                return $this->unmarshalItems($result['Items']);
            }

            return [];  // Jeśli brak wyników
        } catch (\Aws\Exception\AwsException $e) {
            dd('Error: ' . $e->getMessage());
        }
    }
}
