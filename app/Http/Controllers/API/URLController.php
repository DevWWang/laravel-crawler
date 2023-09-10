<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreURLRequest;
use App\Services\Crawler\CrawlerService;
use Illuminate\Http\Response;

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
     * 
     * @param  StoreURLRequest $request
     */
    public function crawler(StoreURLRequest $request)
    {
        // will return only validated data
        $validated = $request->validated();
        $urlRequest = $this->crawlerService->process($validated["url"]);

        return response()->json($urlRequest, Response::HTTP_OK);
    }
}
