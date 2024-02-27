<?php
namespace App\Traits;

use App\Models\Image;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasImagesTrait
{
    /**
     * Define a one-to-one relationship for user images.
     */
    public function userImage(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    /**
     * Define a one-to-one relationship for category images.
     */
    public function categoryImage(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    /**
     * Define a one-to-many relationship for product images.
     */
    public function productImages(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
