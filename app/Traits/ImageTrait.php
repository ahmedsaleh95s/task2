<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

trait ImageTrait
{
    public function uploadImage($image, $path)
    {
            return Storage::put($path, $image);
    }
}
