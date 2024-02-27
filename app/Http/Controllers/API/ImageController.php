<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Image;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\StoreImageRequest;

class ImageController extends Controller
{

    public function addImages(StoreImageRequest $request, $type, $id)
    {
        $model = $this->findModel($type, $id);

        $model->addImages($request, $type, $id);

        return response()->json(['message' => ucfirst($type) . ' images added successfully']);
    }

    public function updateImages(StoreImageRequest $request, $type, $id)
    {
        $model = $this->findModel($type, $id);

        $model->updateImages($request, $type, $id);

        return response()->json(['message' => ucfirst($type) . ' images updated successfully']);
    }

    public function deleteImages($type, $id)
    {
        $model = $this->findModel($type, $id);

        $model->deleteImages();

        return response()->json(['message' => ucfirst($type) . ' images deleted successfully']);
    }

    private function findModel($type, $id)
    {
        switch ($type) {
            case 'user':
                return User::findOrFail($id);
            case 'category':
                return Category::findOrFail($id);
            case 'product':
                return Product::findOrFail($id);
            default:
                return response()->json(['message' => 'Invalid type'], 400);
        }
    }
}
