<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DynamoDbService;
use Illuminate\Support\Facades\App;

class PagesController extends Controller
{
    protected $dynamoDBService;

    public function __construct(DynamoDbService $dynamoDBService)
    {
        $this->dynamoDBService = $dynamoDBService;
    }

    public function show($url, $locale = 'en-us')
    {
        $data = $this->dynamoDBService->getDataByUrl('main-website', $url);

        $page = $this->dynamoDBService->getAllData('main-website');
        

        if ($data) {
            $lang = $data['lang'] ?? $locale;  
            
            App::setLocale($lang);

            if($page){
                return view($data['controller_name'], ['data' => $data, 'page' => $page]);
            } else {
                return view($data['controller_name'], ['data' => $data]);
            }
        }

        return abort(404, 'Page not found');
    }
}
