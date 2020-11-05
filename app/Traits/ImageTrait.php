<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

trait ImageTrait
{
    public function saveImage($image, $model, $path)
    {
        if(!empty($image)){
            $link['image'] = Storage::put($path, $image);
            $model->images()->create($link);
        }
    }

    public function saveImages($images, $model, $path)
    {
        if(!empty($images)){
            foreach ($images as $image) {
                $links[]['link'] = Storage::put($path, $image);
            }
            $model->images()->createMany($links);
        }
    }
}
