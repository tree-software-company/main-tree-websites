<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DynamoDbService;

class LandingPageController extends Controller
{
    protected $dynamoDBService;

    // Konstruktor wstrzykujący serwis
    public function __construct(DynamoDbService $dynamoDBService)
    {
        $this->dynamoDBService = $dynamoDBService;
    }

    // Metoda do wyświetlania danych na stronie
    public function show($url, $locale = 'en-us')
    {
        // Wywołanie funkcji i pobranie danych na podstawie 'url' oraz 'controller_name'
        $data = $this->dynamoDBService->getDataByUrl('main-website', $url, 'landing-page');
        
        // Jeśli dane zostały znalezione, zwróć stronę z danymi
        if ($data) {
            return view('landing-page', ['data' => $data]);
        }

        // Jeśli dane nie zostały znalezione, zwróć niestandardowy widok 404
        return abort(404, 'Page ID is required');
    }
}



