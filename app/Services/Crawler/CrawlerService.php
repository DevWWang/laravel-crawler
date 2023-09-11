<?php

namespace App\Services\Crawler;

use App\Models\URLRequest;
use App\Models\WebsiteMetadata;
use App\Traits\GoogleChrome\BrowserScreenshotTrait;
use App\Traits\Storage\FileTrait;
use Illuminate\Http\Response;

class CrawlerService
{
    use BrowserScreenshotTrait, FileTrait;
    
    /**
     * @param  $url
     * @param  URLRequest $previousUrlRequest
     * @return
     */
    function process($url, $previousUrlRequest = null)
    {
        $urlRequestModel = $previousUrlRequest ?? $this->storeUrlCrawlerRequest($url);
        // execute the request
        $content = $this->getContentFromURL($urlRequestModel);
        // analyze the content and gather information
        $dom = $this->loadContentToDom($content);
        $metadata = $this->getWebsiteMetadataFromDom($urlRequestModel, $dom);
        $metadata["screenshot_filename"] = $this->takeScreenshot($urlRequestModel);
        $this->storeWebsiteMetadata($urlRequestModel, $metadata);

        return $urlRequestModel->refresh()->load("website_metadata");
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param  $url
     * @return URLRequest
     */
    function storeUrlCrawlerRequest($url)
    {
        return URLRequest::create([
            "url" => $url,
        ]);
    }

    /**
     * Store website metadata associate with url
     */
    function storeWebsiteMetadata(URLRequest $urlRequestModel, $data)
    {
        $websiteMetadataModel = WebsiteMetadata::firstOrNew($data);
        $urlRequestModel->website_metadata()->save($websiteMetadataModel);
    }

    /**
     * @param  URLRequest $urlRequestModel
     * @return string|bool
     */
    function getContentFromURL(URLRequest $urlRequestModel)
    {
        $headers = [
            "Accept: */*",
        ];

        // set up curl to point to the requested URL
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $urlRequestModel->url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36");
        
        // execute the request
        $content = curl_exec($ch);
        // check if any error occurred
        $httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = null;
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            die('Couldn\'t send request (Curl Errno returned): ' . $error);
        }
        else {
            if ($httpCode !== Response::HTTP_OK) {
                die('Request failed (HTTP status code): ' . $httpCode);
            }
        }
        // close cURL resource, and free up system resources
        curl_close($ch);

        // update the request after crawling
        $urlRequestModel->status_code = $httpCode;
        $urlRequestModel->error_message = $error;
        $urlRequestModel->save();

        return $content;
    }

    /**
     * Load the websites' content obtained using curl to DOM format and retrieve information
     * 
     * @param  URLRequest $urlRequestModel
     * @param  $content
     */
    function loadContentToDom($content)
    {
        $dom = new \DOMDocument();
        // disable the warning
        $previously = libxml_use_internal_errors(true);
        $dom->loadHTML($content);
        
        return $dom;
    }

    function getWebsiteMetadataFromDom(URLRequest $urlRequestModel, $dom)
    {
        // Create a new DOMXPath instance
        $xpath = new \DOMXPath($dom);
        // get title
        $title = $xpath->evaluate('string(//head/title)');
        // get meta description
        $description = $xpath->evaluate('string(//meta[@name="description"]/@content)');
        // get publish_date
         $publishedTime = $xpath->evaluate('string(//meta[@property="article:published_time"]/@content)');
        // get body
        $body = $xpath->query('/html/body');
        $bodyStr = $dom->saveXml($body->item(0));

        $bodyFilename = $this->saveBodyXMLToStorage($urlRequestModel, $bodyStr);

        return [
            "title" => $title,
            "description" => $description,
            "published_time" => $publishedTime,
            "body_filename" => $bodyFilename,
        ];
    }

    /**
     * @param  URLRequest $urlRequestModel
     * @param  $bodyStr
     */
    function saveBodyXMLToStorage(URLRequest $urlRequestModel, $bodyStr)
    {
        $disk = $urlRequestModel->getStorageDisk();
        $folder = $urlRequestModel->host ?? "";
        $this->createMainDirectoryIfNotExists($folder, $disk);
        $filename = $this->saveBodyStringAsXML($bodyStr, $folder, $disk);
        
        return $filename;
    }

    function takeScreenshot(URLRequest $urlRequestModel)
    {
        $disk = $urlRequestModel->getStorageDisk();
        $folder = $urlRequestModel->host ?? "";
        $filename = $this->getDefaultNameUsingTime().".jpg";
        $path = $this->getPath($filename, $folder, $disk);
        $convertedResult = $this->captureAndSaveAsImage($urlRequestModel->url, $path);
        if (!empty($convertedResult)) {
            $urlRequestModel->status_code = $convertedResult["code"];
            $urlRequestModel->error_message = $convertedResult["errors"];
            $urlRequestModel->save();
            die('Couldn\'t capture the webpage (Browsershot error): '. $convertedResult["message"]);
        }

        return $filename;
    }
}