<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DynamoDbService;
use Illuminate\Support\Facades\App;

class PagesController extends Controller
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
        // Wywołanie funkcji i pobranie danych na podstawie 'url'
        $data = $this->dynamoDBService->getDataByUrl('main-website', $url);

        $page = $this->dynamoDBService->getAllData('main-website');
        
        // Jeśli dane zostały znalezione
        if ($data) {
            // Ustawienie lokalizacji na podstawie wartości 'lang' z danych
            $lang = $data['lang'] ?? $locale;  // Użyj wartości z danych lub domyślnie $locale
            
            // Ustawienie lokalizacji
            App::setLocale($lang);

            if($page){
                return view($data['controller_name'], ['data' => $data, 'page' => $page]);
            } else {
                return view($data['controller_name'], ['data' => $data]);
            }
        }

        // Jeśli nie znaleziono danych, zwróć 404
        return abort(404, 'Page not found');
    }
}
