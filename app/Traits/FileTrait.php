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
}
