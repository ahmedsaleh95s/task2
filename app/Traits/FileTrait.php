<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

trait FileTrait
{
    public function uploadFile($file, $path)
    {
        return Storage::put('public/'.$path, $file);
    }

    function saveImage($image ,$image_path_name) {
        $imagePath = Storage::put('public/'.$image_path_name, $image);
        // compress image 
        $path = substr($imagePath, 6); // remove public from path
        $this->compress('storage'. $path, 30);
        return $imagePath;
    }

    private function compress($source, $quality)
    {
        $info = getimagesize($source);

        if ($info['mime'] == 'image/jpeg')
            $image = imagecreatefromjpeg($source);

        elseif ($info['mime'] == 'image/gif')
            $image = imagecreatefromgif($source);

        elseif ($info['mime'] == 'image/png')
            $image = imagecreatefrompng($source);

        imagejpeg($image, $source, $quality);
        return $source;
    }
}
