<?php

namespace App\Traits\Storage;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait FileTrait
{
    /**
     * Get a default filename based on the time of the action in a specific format (Y-m-d_-_H_m_s_ms)
     * 
     * @return string
     */
    public function getDefaultNameUsingTime()
    {
        return date("Y-m-d_-_H\h_i\m_s\s", time())."_".substr((string)microtime(), 2, 3);
    }

    /**
     * Get storage path
     */
    public function getPath($filename, $folder = "", $disk = "public")
    {
        return Storage::disk($disk)->path($folder."/".$filename);
    }

    /**
     * Create main directory
     * 
     * @param  $folder
     * @param  $disk
     * @return boolean
     */
    public function createMainDirectoryIfNotExists($folder, $disk = "public")
    {
        // check if the directory exists
        if (!Storage::disk($disk)->exists($folder."/")) {
            // create new folder
            $result = Storage::disk($disk)->makeDirectory($folder);
        }

        return $result ?? true;
    }

    /**
     * Handle file saving
     * 
     * @param  $content
     * @param  $folder
     * @param  $disk
     * @return string|false file path
     */
    public function saveBodyStringAsXML($content, $folder = "", $disk = "public")
    {
        $filename = $this->getDefaultNameUsingTime();
        $filenameToStore = $filename.".xml";
        $count = 1;
        while(Storage::disk($disk)->exists($folder."/".$filenameToStore)) {
            $count++;
            // add the zeroes for sequential numbers
            $countString = str_pad($count, 2, "0", STR_PAD_LEFT);
            $filenameToStore = $filename."_".$countString.".xml";
        }
        $path = $this->getPath($filenameToStore, $folder, $disk);
        $file = file_put_contents($path, $content.PHP_EOL , LOCK_EX);
        if ($file === false) {
            die('Couldn\'t save body to '.$folder."/".$filenameToStore);
        }

        return $filenameToStore;
    }
}