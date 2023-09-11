<?php

namespace App\Traits\GoogleChrome;

use Spatie\Browsershot\Browsershot;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;
use Spatie\Browsershot\Exceptions\ElementNotFound;
use Spatie\Browsershot\Exceptions\UnsuccessfulResponse;
use Spatie\Image\Manipulations;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Exception\ProcessTimedOutException;
use Throwable;

trait BrowserScreenshotTrait
{
    /**
     * Capture the webpage and convert it to an image
     * 
     * @param  $url
     * @param  $pathToImage
     * @return array
     */
    public function captureAndSaveAsImage($url, $pathToImage)
    {
        // To temporarily extend the time limit in your script
        $maxTime = 180;
        ini_set("max_execution_time", $maxTime); // 3 minutes

        $result = [];
        try {
            $browsershot = Browsershot::url($url)
                ->noSandbox()
                ->waitUntilNetworkIdle(false)
                ->ignoreHttpsErrors()
                ->windowSize(1920, 1080)
                ->timeout($maxTime)
                ->save($pathToImage);
        }
        catch (ProcessFailedException $e) {
            $errorMessage = "ERROR PROCESS_FAILED";
            $errors = $e->getMessage();

            // ANALYZE ERROR TYPES
            if (strpos($errors, "Cannot navigate to invalid URL") !== false) {
                $errorMessage = "ERROR INVALID_LINK";
            }
            else if (strpos($errors, "Could not find expected browser") !== false) {
                $errorMessage = "ERROR BROWSER_NOT_FOUND";
            }

            $result = [
                "code" => $e->getCode(),
                "message" => $errorMessage,
                "errors" => $errors
            ];
        }
        catch (CouldNotTakeBrowsershot $e) {
            $result = [
                "code" => $e->getCode(),
                "message" => "ERROR UNABLE_TO_TAKE_SCREENSHOT",
                "errors" => $e->getMessage()
            ];
        }
        catch (ElementNotFound $e) {
            $result = [
                "code" => $e->getCode(),
                "message" => "ERROR ELEMENT_NOT_FOUND",
                "errors" => $e->getMessage()
            ];
        }
        catch (UnsuccessfulResponse $e) {
            $result = [
                "code" => $e->getCode(),
                "message" => "ERROR UNSUCCESSFUL_RESPONSE",
                "errors" => $e->getMessage()
            ];
        }
        catch (ProcessTimedOutException $e) {
            $result = [
                "code" => $e->getCode(),
                "message" => "ERROR PROCESS_TIMED_OUT",
                "errors" => $e->getMessage()
            ];
        }
        catch (Throwable $e) {
            $result = [
                "code" => $e->getCode(),
                "message" => "ERROR",
                "errors" => $e->getMessage()
            ];
        }

        return $result;
    }
}