<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Services\DynamoDbService;
use Illuminate\Support\Facades\Log;

class SitemapController extends Controller
{
    protected $dynamoDbService;

    public function __construct(DynamoDbService $dynamoDbService)
    {
        $this->dynamoDbService = $dynamoDbService;
    }

    public function index()
    {
        $urls = $this->dynamoDbService->getAllData('main-website');

        $baseUrl = 'https://www.tree-websites.com/';
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        if (is_array($urls)) {
            foreach ($urls as $url) {
                $fullUrl = $baseUrl . $url['url'];
                $sitemap .= '<url>';
                $sitemap .= '<loc>' . htmlspecialchars($fullUrl, ENT_XML1) . '</loc>';
                $sitemap .= '</url>';
            }
        }

        $sitemap .= '</urlset>';

        return response($sitemap, 200)
                ->header('Content-Type', 'application/xml');
    }
}

