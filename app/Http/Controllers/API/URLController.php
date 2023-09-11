<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreURLRequest;
use App\Http\Resources\URLRequestResource;
use App\Models\URLRequest;
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
     * @return View
     */
    public function crawler(StoreURLRequest $request)
    {
        // will return only validated data
        $validated = $request->validated();
        // if the url is already submitted but failed to process, delete the previous crawled request
        $previousUrlRequest = URLRequest::where("url", $validated["url"])
            ->where(function ($query) {
                $query->where("status_code", "!=", Response::HTTP_OK)
                    ->orWhereNull("status_code");
            })->first();
        $urlRequest = $this->crawlerService->process($validated["url"], $previousUrlRequest);
        $resource = (new URLRequestResource($urlRequest))->resolveRelationship(true)->resolve();
        return view("crawler.result", ["urlRequest" => $resource]);
    }

    /**
     * Display a listing of the resource.
     * 
     * @return View
     */
    public function history()
    {
        $urlRequests = URLRequest::with("website_metadata")->get();
        $resources = URLRequestResource::collection($urlRequests)->resolve();
        return view("crawler.history", ["urlRequests" => $resources]);
    }

    public function detail($id)
    {
        $urlRequest = URLRequest::with("website_metadata")->findOrFail($id);
        $resource = (new URLRequestResource($urlRequest))->resolveRelationship(true)->resolve();
        return response()->view("crawler.detail", ["urlRequest" => $resource]);
    }
}
