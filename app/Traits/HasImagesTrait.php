<?php
namespace App\Traits;

use App\Models\Image;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreImageRequest;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasImagesTrait
{
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function addImages(StoreImageRequest $request, $type, $id)
    {
        $urls = $this->storeImages($request->file('images'), $type, $id);

        DB::beginTransaction();

        try {
            $this->images()->createMany(array_map(function ($path) {
                return ['path' => $path];
            }, $urls));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

public function updateImages(StoreImageRequest $request, $type, $id)
    {
        $urls = $this->storeImages($request->file('images'), $type, $id);

        DB::beginTransaction();

        try {
            $this->images()->delete();

            $this->images()->createMany(array_map(function ($path) {
                return ['path' => $path];
            }, $urls));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function deleteImages()
    {
        DB::beginTransaction();

        try {
            $this->images()->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    private function storeImages($images, $type, $id)
    {
        $paths = [];


        if ($images) {
            foreach ($images as $image) {
                $paths[] = $this->storeImage($image, $type, $id);
            }
        }

        return $paths;
    }

    private function storeImage($image, $type, $id)
    {
        $path = $image->store("images/{$type}/{$id}", 'public');

        return $path;
    }
}
