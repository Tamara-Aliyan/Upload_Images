<?php

namespace App\Http\Controllers\API;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\ImageService;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\StoreImageRequest;

class ImageController extends Controller
{
    public function upload_images(Request $request, $entityType, $entityId)
    {
        $images = [];
        foreach ($request->file('image') as $imageFile) {
            $path = $imageFile->store("images/{$entityType}/{$entityId}", 'public');
            $image = Image::create([
                'path' => $path,
                'imageable_id' => $entityId,
                'imageable_type' => "App\\Models\\{$entityType}",
            ]);
            $images[] = $image;
        }
        return response()->json(['images' => $images], 201);
    }

    public function upload_image(StoreImageRequest $request, $entityType, $entityId)
    {
        $path = $request->file('image')->store("images/{$entityType}/{$entityId}", 'public');
        $image = Image::create([
            'path' => $path,
            'imageable_id' => $entityId,
            'imageable_type' => "App\\Models\\{$entityType}",
        ]);
        return response()->json(['image' => $image], 201);
    }
}
