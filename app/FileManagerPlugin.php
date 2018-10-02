<?php

namespace App;


/**
 * Class FileManagerPlugin
 * @package App
 */
class FileManagerPlugin
{

    /**
     * @param $folder
     * @param $filename
     * @param $id
     * @param string $alternateUrl
     * @return string
     */
    public static function getFileUrl($folder, $filename, $id, $alternateUrl = "")
    {
        $url = $alternateUrl;
        if(file_exists(storage_path("app/public/{$folder}/{$id}/{$filename}"))){
            $url = asset("storage/{$folder}/{$id}/{$filename}") ;
        }
        return $url;
    }

    /**
     * @param $file \Illuminate\Http\UploadedFile|array|null
     * @param $folder
     * @param $filename
     * @param $id
     */
    public static function uploadTo($file, $folder, $filename, $id)
    {
        $file->storeAs("public/{$folder}/".$id, $filename);
    }

    /**
     * @param $module
     * @param null $id
     * @param null $filename
     * @return bool
     */
    public static function delete($module, $id = null, $filename = null)
    {
        $path = storage_path("app/public/{$module}/{$id}/{$filename}");
        @unlink($path);
        return ( ! file_exists($path));
    }
}