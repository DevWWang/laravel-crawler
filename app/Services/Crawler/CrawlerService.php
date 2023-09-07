<?php

namespace App\Services\Crawler;

use Illuminate\Http\Response;

class CrawlerService
{
    function getContentFromURL($url)
    {
        // set up curl to point to the requested URL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        // execute the request
        $content = curl_exec($ch);
        // check if any error occurred
        if (curl_errno($ch)) {
            die('Couldn\'t send request (Curl Errno returned): ' . curl_error($ch));
        }
        else {
            $httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($httpCode !== Response::HTTP_OK) {
                die('Request failed (HTTP status code): ' . $httpCode);
            }
        }
        // close cURL resource, and free up system resources
        curl_close($ch);

        return $content;
    }
}