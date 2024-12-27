<?php

namespace App\Services;

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Marshaler;
use Ramsey\Uuid\Guid\Guid;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;

use Exception;
use Carbon\Carbon;


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

    public function userExistsByEmail($email)
    {
        $result = $this->dynamoDb->scan([
            'TableName' => 'users',
            'FilterExpression' => 'email = :email',
            'ExpressionAttributeValues' => [
                ':email' => ['S' => $email],
            ],
        ]);

        return count($result['Items']) > 0; 
    }
    

    public function checkPhoneExists($phone)
    {
        
        $result = $this->dynamoDb->scan([
            'TableName' => 'users',
            'FilterExpression' => 'phone = :phone',
            'ExpressionAttributeValues' => [
                ':phone' => ['S' => $phone]
            ]
        ]);

        return count($result['Items']) > 0; 
    }
    
    public function phoneBelongsToAnotherUser($phone, $currentUserId)
    {
        $result = $this->dynamoDb->scan([
            'TableName' => 'users',
            'FilterExpression' => 'phone = :phone',
            'ExpressionAttributeValues' => [
                ':phone' => ['S' => $phone],
            ],
        ]);

        if (count($result['Items']) === 0) {
            return false;
        }

        foreach ($result['Items'] as $item) {
            if ($item['user_id']['N'] !== (string)$currentUserId) {
                return true;
            }
        }

        return false;
    }

    public function registerUser(array $data)
    {
        $birthday = Carbon::parse($data['birthday']);
        $age = Carbon::now()->diffInYears($birthday);

        if ($age < 13) {
            throw new Exception('You must be at least 13 years old to register.');
        }

        if ($this->checkPhoneExists($data['phone'])) {
            throw new Exception('The phone number is already taken.');
        }

        $userId = time();

        $hashedPassword = Hash::make($data['password']);

        $item = [
            'user_id' => ['N' => (string) $userId],  
            'user_type' => ['S' => 'user'],  
            'email' => ['S' => $data['email']],
            'phone' => ['S' => $data['phone']],
            'birthday' => ['S' => $data['birthday']],
            'first_name' => ['S' => $data['first_name']],
            'last_name' => ['S' => $data['last_name']],
            'country' => ['S' => $data['country']],
            'password' => ['S' => $hashedPassword],  
        ];

        try {
            $this->dynamoDb->putItem([
                'TableName' => 'users', 
                'Item' => $item
            ]);

            return [
                'user_id' => $userId,
                'user_type' => 'user',
                'email' => $data['email'],
                'phone' => $data['phone'],
                'birthday' => $data['birthday'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'country' => $data['country'],
                'password' => $hashedPassword,
            ];

        } catch (\Aws\Exception\AwsException $e) {
            Log::error('DynamoDB PutItem Error: ' . $e->getMessage());
            throw new Exception('Failed to register the user.');
        }
    }

    public function loginUser($email, $password)
    {
        $user = $this->findUserByEmail($email);

        if ($user) {
            $hashedPassword = $user['password']['S'];

            if (Hash::check($password, $hashedPassword)) {
                $userInstance = new User();
                $userInstance->id = $user['user_id']['N'];
                $userInstance->email = $user['email']['S'];
                $userInstance->phone = $user['phone']['S'] ?? null; 

                Auth::login($userInstance);

                return true;
            }
        }

        return false;
    }

    public function findUserByEmail($email)
    {
        try {
            $result = $this->dynamoDb->scan([
                'TableName' => 'users',
                'FilterExpression' => 'email = :email',
                'ExpressionAttributeValues' => [
                    ':email' => ['S' => $email], 
                ],
            ]);


            if (count($result['Items']) > 0) {
                return $result['Items'][0];
            } else {
                return null;
            }
        } catch (\Aws\Exception\AwsException $e) {
            return null;
        }
    }
    
    public function findUserById($id)
    {
        try {
            $result = $this->dynamoDb->getItem([
                'TableName' => 'users',
                'Key' => [
                    'user_id' => ['N' => (string) $id],
                ],
            ]);

            if (isset($result['Item'])) {
                return $result['Item'];
            } else {
                return null;
            }
        } catch (\Aws\Exception\AwsException $e) {
            return null;
        }
    }

    public function updateUser($userId, array $data)
    {
        $updateExprParts = [];
        $exprValues = [];
        $exprNames = [];
        $i = 0;

        foreach ($data as $key => $value) {
            $i++;
            $updateExprParts[] = "#attr{$i} = :val{$i}";
            $exprValues[":val{$i}"] = ['S' => (string) $value];  
            $exprNames["#attr{$i}"] = $key;
        }

        $params = [
            'TableName' => 'users',
            'Key' => [
                'user_id' => ['N' => (string) $userId],
            ],
            'UpdateExpression' => 'SET ' . implode(', ', $updateExprParts),
            'ExpressionAttributeValues' => $exprValues,
            'ExpressionAttributeNames' => $exprNames,
            'ReturnValues' => 'ALL_NEW',
        ];

        $this->dynamoDb->updateItem($params);
    }
    

    public function listTables()
    {
        return $this->dynamoDb->listTables();
    }

    public function putItem($tableName, $item)
    {
        return $this->dynamoDb->putItem([
            'TableName' => $tableName,
            'Item'      => $this->marshalItem($item),
        ]);
    }

    public function getItem($tableName, $key)
    {
        return $this->dynamoDb->getItem([
            'TableName' => $tableName,
            'Key'       => $this->marshalItem($key),
        ]);
    }

    private function marshalItem(array $item)
    {
        $marshaler = new Marshaler(); 
        return $marshaler->marshalItem($item); 
    }

    public function getLangSetting()
    {
        try {
            $result = $this->dynamoDb->scan([
                'TableName' => 'settings',
            ]);

            if (isset($result['Items']) && count($result['Items']) > 0) {
                $item = $this->unmarshalItems($result['Items'])[0];  
                return $item['lang'];  
            }

            return 'en-us'; 
        } catch (\Aws\Exception\AwsException $e) {
            dd('Error: ' . $e->getMessage());
        }
    }

    public function getData($tableName, $controller)
    {
        try {
            $result = $this->dynamoDb->scan([
                'TableName' => $tableName,
                'FilterExpression' => 'controller_name = :controller_name',
                'ExpressionAttributeValues' => [
                    ':controller_name' => ['S' => $controller], 
                ],
            ]);
    

            if (count($result['Items']) > 0) {
                return $this->unmarshalItems($result['Items']); 
            }
    
            return null; 
        } catch (\Aws\Exception\AwsException $e) {
            dd('Error: ' . $e->getMessage());
        }
    }
    
    public function getDataByUrl($tableName, $url)
    {
        try {
            $result = $this->dynamoDb->scan([
                'TableName' => $tableName,
                'FilterExpression' => '#url = :url',
                'ExpressionAttributeNames' => [
                    '#url' => 'url', 
                ],
                'ExpressionAttributeValues' => [
                    ':url' => ['S' => $url],  
                ],
            ]);
    

            if (count($result['Items']) > 0) {
                $unmarshalledData = $this->unmarshalItems($result['Items']);
                return $unmarshalledData[0];  
            }
    
            return null;  
        } catch (\Aws\Exception\AwsException $e) {
            dd('Error: ' . $e->getMessage());
        }
    }

    public function saveFormSubmission($data)
    {
        try {
            $marshaler = new Marshaler();

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
                'product'    => $data['product'],
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
            $result = $this->dynamoDb->scan([
                'TableName' => $tableName,
            ]);

            if (isset($result['Items']) && count($result['Items']) > 0) {
                return $this->unmarshalItems($result['Items']);
            }

            return []; 
        } catch (\Aws\Exception\AwsException $e) {
            dd('Error: ' . $e->getMessage());
        }
    }

    public function getAllPages()
    {
        try {
            $result = $this->dynamoDb->scan([
                'TableName' => 'main-website',  
            ]);

            if (isset($result['Items']) && count($result['Items']) > 0) {
                return $this->unmarshalItems($result['Items']);
            }

            return []; 
        } catch (\Aws\Exception\AwsException $e) {
            dd('Error: ' . $e->getMessage());
        }
    }

    public function emailExistsForProduct($email, $product)
    {
        $result = $this->dynamoDb->scan([
            'TableName' => 'landing-page-newsletter',
            'FilterExpression' => 'email = :email AND product = :product',
            'ExpressionAttributeValues' => [
                ':email'   => ['S' => $email],
                ':product' => ['S' => $product]
            ],
        ]);

        return count($result['Items']) > 0;
    }

    public function searchMetaData($keyword)
    {
        $result = $this->dynamoDb->scan([
            'TableName' => 'main-website',
            'FilterExpression' => 'contains(meta_title, :k) OR contains(meta_description, :k)',
            'ExpressionAttributeValues' => [
                ':k' => ['S' => $keyword],
            ],
        ]);
        return $this->unmarshalItems($result['Items']);
    }

    public function getFormWebsiteRecords()
    {
        $result = $this->dynamoDb->scan([
            'TableName' => 'form_website',
        ]);
        return $this->unmarshalItems($result['Items']);
    }

    public function updateFormWebsiteStatus($id, $status)
    {
        $this->dynamoDb->updateItem([
            'TableName' => 'form_website',
            'Key'       => ['id' => ['S' => $id]],
            'UpdateExpression' => 'SET #st = :s',
            'ExpressionAttributeNames' => ['#st' => 'status'],
            'ExpressionAttributeValues' => [':s' => ['S' => $status]],
        ]);
    }

    public function getNewsletterRecords()
    {
        $result = $this->dynamoDb->scan([
            'TableName' => 'landing-page-newsletter',
        ]);
        return $this->unmarshalItems($result['Items']);
    }

    public function getAllUsers()
    {
        $result = $this->dynamoDb->scan([
            'TableName' => 'users',
        ]);
        return $this->unmarshalItems($result['Items']);
    }

    public function updateUserPassword($userId, $hashedPassword)
    {
        $this->dynamoDb->updateItem([
            'TableName' => 'users',
            'Key'       => ['user_id' => ['N' => (string)$userId]],
            'UpdateExpression' => 'SET #pwd = :p',
            'ExpressionAttributeNames' => ['#pwd' => 'password'],
            'ExpressionAttributeValues' => [':p' => ['S' => $hashedPassword]],
        ]);
    }

    public function getUser($userId)
    {
        $result = $this->dynamoDb->query([
            'TableName' => 'users',
            'KeyConditionExpression' => 'user_id = :uid',
            'ExpressionAttributeValues' => [
                ':uid' => ['N' => (string)$userId],
            ],
        ]);
        $items = $this->unmarshalItems($result['Items']);
        return count($items) ? $items[0] : [];
    }

    public function isAdmin($userId)
    {
        $user = $this->getUser($userId);
        return (isset($user['user_type']) && $user['user_type'] === 'admin');
    }

}
