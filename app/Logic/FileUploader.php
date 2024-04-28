<?php

namespace App\Logic;

/*
*
* Models used for this class
*/

/*
*
* Classes used for this class
*/
use Carbon\Carbon;
use Str, File, Image, URL;

class FileUploader {

    /**
    *
    *@param App\Http\Requests\RequestRequest $request
    *@param string $request
    *
    *@return array
    */
    static public function upload($file, $file_directory = "uploads"){
        
        $storage = env('IMAGE_STORAGE', "file");
        
        $ext = $file->getClientOriginalExtension();
        $thumbnail = ['height' => 500, 'width' => 500];
        $path_directory = $file_directory."/".Carbon::now()->format('Ymd');

        if (!File::exists($path_directory)){
            File::makeDirectory($path_directory, $mode = 0777, true, true);
        }

        $filename = str_random(20). date("mdYhs") . "." . $ext;

        $file->move($path_directory, $filename);

        return [ "path" => $path_directory, "directory" => URL::to($path_directory), "filename" => $filename ];

    }
}
