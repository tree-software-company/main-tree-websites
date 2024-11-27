<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DynamoDbService;

class HomeController extends Controller
{
    protected $dynamoDBService;

    // Konstruktor wstrzykujący serwis
    public function __construct(DynamoDbService $dynamoDBService)
    {
        $this->dynamoDBService = $dynamoDBService;
    }

    // Metoda do wyświetlania danych na stronie
    public function index($langUrl, $locale = 'en-us')
    {
        // Wywołanie funkcji i pobranie danych na podstawie 'url' oraz 'controller_name'
        $data = $this->dynamoDBService->getDataByUrl('main-website', $langUrl, 'homepage');
        
        // Jeśli dane zostały znalezione, zwróć stronę z danymi
        if ($data) {
            return view('welcome', ['data' => $data]);
        }
    }
}
