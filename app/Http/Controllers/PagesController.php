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

    public function show(Request $request, $url, $locale = 'en-us')
    {
        $keyword = $request->input('keyword');

        $data = $this->dynamoDBService->getDataByUrl('main-website', $url);
        $page = $this->dynamoDBService->getAllData('main-website');

        $results = null;

        if ($keyword) {
            $results = $this->dynamoDBService->searchMetaData($keyword);
        }

        if ($data) {
            $lang = $data['lang'] ?? $locale;  
            App::setLocale($lang);

            $viewData = [
                'data' => $data,
                'page' => $page,
                'results' => $results,
                'keyword' => $keyword
            ];

            return view($data['controller_name'], $viewData);
        }

        return abort(404, 'Page not found');
    }
}
