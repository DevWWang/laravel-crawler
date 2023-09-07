<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Crawler\CrawlerService;
use Illuminate\Http\Request;

class URLController extends Controller
{
    protected $crawlerService;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(CrawlerService $crawlerService)
    {
        $this->crawlerService = $crawlerService;
    }

    /**
     * Display a listing of the resource.
     */
    public function crawler(Request $request)
    {
        $request->validate([
            "url" => ["required", "url"]
        ]);
        
        return response()->json();
    }
}
